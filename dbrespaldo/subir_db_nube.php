<?php
/**
 * Script PHP: subir_db_nube.php
 * Ubicación: /var/www/html/gim360/dbrespaldo/subir_db_nube.php
 *
 * Permite respaldar la base de datos local 'gim360' y subirla/migrarla
 * a la base de datos en la nube (MySQL / MariaDB).
 *
 * Uso CLI:
 *   php dbrespaldo/subir_db_nube.php
 *   php dbrespaldo/subir_db_nube.php --host=midominio.com --user=remoto --pass=secret --db=gim360
 *   php dbrespaldo/subir_db_nube.php --limpiar --host=midominio.com --user=remoto --pass=secret
 *   php dbrespaldo/subir_db_nube.php --solo-exportar
 *   php dbrespaldo/subir_db_nube.php --verificar
 */

// Asegurar ejecución solo desde CLI o con token seguro si es web
if (php_sapi_name() !== 'cli') {
    $tokenReq = $_GET['token'] ?? '';
    if (empty($tokenReq) || $tokenReq !== 'gim360_secure_backup') {
        http_response_code(403);
        header('Content-Type: text/plain; charset=utf-8');
        die("Acceso denegado. Este script se ejecuta preferentemente por línea de comandos (CLI).\n");
    }
    header('Content-Type: text/plain; charset=utf-8');
}

$scriptDir  = __DIR__;
$projectDir = dirname($scriptDir);

// Función auxiliar para leer variables tipo .env
function parseEnvFile(string $path): array {
    $data = [];
    if (!file_exists($path)) {
        return $data;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (str_contains($line, '=')) {
            [$key, $val] = explode('=', $line, 2);
            $key = trim($key);
            $val = trim($val);
            $val = trim($val, "'\"");
            $data[$key] = $val;
        }
    }
    return $data;
}

// Función para sanitizar archivos SQL para máxima compatibilidad cloud
function sanitizarSql(string $filePath): void {
    if (!file_exists($filePath)) {
        return;
    }
    $content = file_get_contents($filePath);

    // 1. Eliminar sandbox de MariaDB
    $content = preg_replace('/\/\*M!999999\\\\- enable the sandbox mode \*\/\s*/', '', $content);

    // 2. Eliminar bloques de DEFINER y SQL SECURITY DEFINER en vistas
    $content = preg_replace('/\/\*!50013\s+DEFINER=[^*]+\*\/\s*/', '', $content);
    $content = preg_replace('/\/\*!50013\s+SQL SECURITY DEFINER\s*\*\/\s*/', '', $content);

    // 3. Eliminar cláusulas DEFINER residuales en triggers, funciones o procedimientos
    $content = preg_replace('/DEFINER=`[^`]+`@`[^`]+`\s*/', '', $content);
    $content = preg_replace('/DEFINER=[^ ]+\s*/', '', $content);

    // 4. Eliminar bloqueos de tablas
    $content = preg_replace('/LOCK TABLES `[^`]+` WRITE;\n/', '', $content);
    $content = preg_replace('/UNLOCK TABLES;\n/', '', $content);

    // 5. Normalizar utf8mb3 -> utf8mb4
    $content = str_replace('utf8mb3_general_ci', 'utf8mb4_spanish_ci', $content);
    $content = str_replace('utf8mb3', 'utf8mb4', $content);

    file_put_contents($filePath, $content);
}

// 1. Cargar configuración local de .env de CodeIgniter
$localEnv = parseEnvFile($projectDir . '/.env');
$localHost = $localEnv['database.default.hostname'] ?? 'localhost';
$localPort = (int)($localEnv['database.default.port'] ?? 3306);
$localDb   = $localEnv['database.default.database'] ?? 'gim360';
$localUser = $localEnv['database.default.username'] ?? 'root';
$localPass = $localEnv['database.default.password'] ?? 'PIWIIB1234';

// 2. Cargar configuración de la nube desde config_nube.env si existe
$cloudEnv = parseEnvFile($scriptDir . '/config_nube.env');
$cloudHost = $cloudEnv['CLOUD_DB_HOST'] ?? '';
$cloudPort = (int)($cloudEnv['CLOUD_DB_PORT'] ?? 3306);
$cloudDb   = $cloudEnv['CLOUD_DB_NAME'] ?? 'gim360';
$cloudUser = $cloudEnv['CLOUD_DB_USER'] ?? '';
$cloudPass = $cloudEnv['CLOUD_DB_PASS'] ?? '';
$cloudSsl  = filter_var($cloudEnv['CLOUD_DB_SSL'] ?? false, FILTER_VALIDATE_BOOLEAN);

// 3. Procesar parámetros de línea de comandos
$longOpts = [
    'host:', 'port:', 'user:', 'pass:', 'db:', 'ssl', 'crear-db',
    'limpiar', 'reset', 'verificar', 'check', 'file:', 'usar-sql',
    'solo-exportar', 'help'
];
$options = getopt('', $longOpts);

if (isset($options['help'])) {
    echo "======================================================================\n";
    echo "   Sincronización de Base de Datos GIM360 a la Nube (PHP CLI)        \n";
    echo "======================================================================\n\n";
    echo "Uso: php dbrespaldo/subir_db_nube.php [OPCIONES]\n\n";
    echo "Opciones de conexión a la nube:\n";
    echo "  --host=HOST        Host o IP del servidor en la nube\n";
    echo "  --port=PUERTO      Puerto remoto (por defecto: 3306)\n";
    echo "  --user=USUARIO     Usuario MySQL remoto\n";
    echo "  --pass=PASSWORD    Contraseña MySQL remota\n";
    echo "  --db=NOMBRE_BD     Nombre de la base de datos remota (por defecto: gim360)\n";
    echo "  --ssl              Habilitar conexión SSL con el servidor remoto\n";
    echo "  --crear-db         Intentar crear la base de datos si no existe en la nube\n";
    echo "  --limpiar          Eliminar tablas y vistas previas en la nube antes de importar\n";
    echo "  --verificar        Probar conexión remota e inspeccionar tablas actuales sin modificar\n\n";
    echo "Opciones de origen y exportación:\n";
    echo "  --file=ARCHIVO     Usar un archivo SQL específico en lugar de exportar\n";
    echo "  --usar-sql         Usar directamente el archivo gim360.sql canonical del proyecto\n";
    echo "  --solo-exportar    Generar únicamente el respaldo local limpio y sincronizar copias\n";
    echo "  --help             Mostrar esta ayuda\n\n";
    exit(0);
}

if (!empty($options['host'])) $cloudHost = $options['host'];
if (!empty($options['port'])) $cloudPort = (int)$options['port'];
if (!empty($options['user'])) $cloudUser = $options['user'];
if (!empty($options['pass'])) $cloudPass = $options['pass'];
if (!empty($options['db']))   $cloudDb   = $options['db'];
if (isset($options['ssl']))   $cloudSsl  = true;

$crearDb       = isset($options['crear-db']);
$limpiarRemota = isset($options['limpiar']) || isset($options['reset']);
$verificarSolo = isset($options['verificar']) || isset($options['check']);
$soloExportar  = isset($options['solo-exportar']);
$usarSqlCanon  = isset($options['usar-sql']);
$customFile    = $options['file'] ?? null;

echo "======================================================================\n";
echo "   Sincronización de Base de Datos GIM360 a la Nube (PHP CLI)        \n";
echo "======================================================================\n\n";

$timestamp  = date('Y-m-d_His');
$fechaDia   = date('Y-m-d');
$backupFile = $scriptDir . "/gim360_{$timestamp}.sql";

if (!$verificarSolo) {
    if ($customFile) {
        if (!file_exists($customFile)) {
            die("[ERROR] El archivo especificado no existe: {$customFile}\n");
        }
        $backupFile = $customFile;
        echo "[INFO] Usando archivo SQL indicado: {$backupFile}\n";
    } elseif ($usarSqlCanon) {
        if (file_exists($projectDir . '/gim360.sql')) {
            $backupFile = $projectDir . '/gim360.sql';
        } elseif (file_exists($scriptDir . '/gim360.sql')) {
            $backupFile = $scriptDir . '/gim360.sql';
        } else {
            die("[ERROR] No se encontró el archivo gim360.sql del proyecto.\n");
        }
        echo "[INFO] Usando archivo SQL canonical existente: {$backupFile}\n";
    } else {
        // Probar conexión local
        echo "[1/4] Comprobando conexión local ({$localDb} en {$localHost}:{$localPort})...\n";
        $localMysqli = @new mysqli($localHost, $localUser, $localPass, $localDb, $localPort);
        if ($localMysqli->connect_error) {
            echo "[AVISO] No se pudo conectar a la base local: " . $localMysqli->connect_error . "\n";
            if (file_exists($projectDir . '/gim360.sql')) {
                $backupFile = $projectDir . '/gim360.sql';
                echo "[INFO] Usando automáticamente gim360.sql existente: {$backupFile}\n";
            } else {
                die("[ERROR] Sin conexión a base local y sin archivo gim360.sql disponible.\n");
            }
        } else {
            $localMysqli->set_charset('utf8mb4');
            echo "[OK] Conexión local exitosa.\n";

            echo "[2/4] Generando volcado con mysqldump / mariadb-dump...\n";
            putenv("MYSQL_PWD={$localPass}");
            $dumpCmd = sprintf(
                "mysqldump -h %s -P %d -u %s --single-transaction --skip-add-locks --quick --routines --triggers --hex-blob --default-character-set=utf8mb4 %s > %s 2>/dev/null || mariadb-dump -h %s -P %d -u %s --single-transaction --skip-add-locks --quick --routines --triggers --hex-blob --default-character-set=utf8mb4 %s > %s",
                escapeshellarg($localHost), $localPort, escapeshellarg($localUser), escapeshellarg($localDb), escapeshellarg($backupFile),
                escapeshellarg($localHost), $localPort, escapeshellarg($localUser), escapeshellarg($localDb), escapeshellarg($backupFile)
            );

            exec($dumpCmd, $output, $returnCode);
            if ($returnCode !== 0 || !file_exists($backupFile) || filesize($backupFile) === 0) {
                die("[ERROR] Falló la ejecución del comando de volcado.\n");
            }

            echo "[INFO] Optimizando compatibilidad cloud (eliminando DEFINER y sandbox)...\n";
            sanitizarSql($backupFile);

            $sizeMb = round(filesize($backupFile) / (1024 * 1024), 2);
            echo "[OK] Respaldo generado con éxito: {$backupFile} ({$sizeMb} MB)\n";

            // Sincronizar copias en dbrespaldo y raíz
            copy($backupFile, $scriptDir . "/gim360-{$fechaDia}.sql");
            copy($backupFile, $scriptDir . '/gim360.sql');
            copy($backupFile, $projectDir . '/gim360.sql');
            echo "[OK] Copias sincronizadas: dbrespaldo/gim360-{$fechaDia}.sql y gim360.sql\n";
        }
    }
}

if ($soloExportar) {
    echo "\n[ÉXITO] Proceso finalizado en modo solo-exportar.\n";
    exit(0);
}

// Verificar datos de conexión en la nube
if (empty($cloudHost) || empty($cloudUser)) {
    echo "\n----------------------------------------------------------------------\n";
    echo "[AVISO] El respaldo local se completó correctamente.\n";
    echo "Para subirlo automáticamente a la nube, completa las credenciales en:\n";
    echo "  {$scriptDir}/config_nube.env\n";
    echo "O ejecuta pasando los parámetros:\n";
    echo "  php dbrespaldo/subir_db_nube.php --host=TU_HOST --user=TU_USUARIO --pass=TU_PASS --db=gim360\n";
    echo "----------------------------------------------------------------------\n";
    exit(0);
}

// 7. Probar conexión en la nube
echo "[3/4] Probando conexión remota con {$cloudHost}:{$cloudPort}...\n";
$cloudMysqli = mysqli_init();
if ($cloudSsl) {
    $cloudMysqli->ssl_set(null, null, null, null, null);
}

if (!@$cloudMysqli->real_connect($cloudHost, $cloudUser, $cloudPass, null, $cloudPort, null, MYSQLI_CLIENT_FOUND_ROWS)) {
    die("[ERROR] No se pudo conectar al servidor MySQL en la nube: " . $cloudMysqli->connect_error . "\n");
}
$cloudMysqli->set_charset('utf8mb4');
echo "[OK] Conexión remota establecida.\n";

$escapedDb = $cloudMysqli->real_escape_string($cloudDb);
if ($crearDb) {
    $cloudMysqli->query("CREATE DATABASE IF NOT EXISTS `{$escapedDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
}

if (!$cloudMysqli->select_db($cloudDb)) {
    echo "[INFO] Intentando crear la base de datos '{$cloudDb}' en la nube...\n";
    if (!$cloudMysqli->query("CREATE DATABASE IF NOT EXISTS `{$escapedDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") || !$cloudMysqli->select_db($cloudDb)) {
        die("[ERROR] No se pudo seleccionar ni crear la base de datos '{$cloudDb}' en la nube: " . $cloudMysqli->error . "\n");
    }
}

$resPrev = $cloudMysqli->query("SELECT COUNT(*) AS total FROM information_schema.tables WHERE table_schema='{$escapedDb}'");
$prevCount = ($resPrev && $r = $resPrev->fetch_assoc()) ? $r['total'] : 0;
echo "[INFO] Tablas y vistas actualmente en la nube: {$prevCount}\n";

if ($verificarSolo) {
    echo "\n[OK] Verificación completada con éxito. Servidor y base de datos remotos listos.\n";
    exit(0);
}

// Limpiar base de datos si se solicitó
if ($limpiarRemota) {
    echo "[INFO] Limpiando tablas y vistas previas en la base remota...\n";
    $cloudMysqli->query("SET FOREIGN_KEY_CHECKS = 0");
    $resDrop = $cloudMysqli->query("SELECT table_name, table_type FROM information_schema.tables WHERE table_schema='{$escapedDb}'");
    if ($resDrop) {
        while ($t = $resDrop->fetch_assoc()) {
            $tName = $t['table_name'];
            if ($t['table_type'] === 'VIEW') {
                $cloudMysqli->query("DROP VIEW IF EXISTS `{$tName}`");
            } else {
                $cloudMysqli->query("DROP TABLE IF EXISTS `{$tName}`");
            }
        }
    }
    $cloudMysqli->query("SET FOREIGN_KEY_CHECKS = 1");
    echo "[OK] Tablas previas eliminadas.\n";
}

// 8. Importar a la nube
echo "[4/4] Subiendo datos e importando estructura a '{$cloudDb}' en la nube...\n";
$start = microtime(true);

putenv("MYSQL_PWD={$cloudPass}");
$sslArg = $cloudSsl ? "--ssl-mode=REQUIRED" : "";

$importCmd = sprintf(
    "mysql -h %s -P %d -u %s %s --default-character-set=utf8mb4 --max-allowed-packet=64M --binary-mode --init-command=\"SET SESSION FOREIGN_KEY_CHECKS=0; SET SESSION UNIQUE_CHECKS=0; SET SESSION SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\" %s < %s",
    escapeshellarg($cloudHost),
    $cloudPort,
    escapeshellarg($cloudUser),
    $sslArg,
    escapeshellarg($cloudDb),
    escapeshellarg($backupFile)
);

exec($importCmd, $outputImport, $returnImport);

if ($returnImport !== 0) {
    die("[ERROR] Falló la importación a la nube con código de salida: {$returnImport}\n");
}

$elapsed = round(microtime(true) - $start, 2);

// Contar tablas importadas
$res = $cloudMysqli->query("SELECT COUNT(*) AS total FROM information_schema.tables WHERE table_schema='{$escapedDb}'");
$totalTables = ($res && $row = $res->fetch_assoc()) ? $row['total'] : 'N/A';

// Verificar tablas clave
$resKey = $cloudMysqli->query("
    SELECT COUNT(*) AS total FROM information_schema.tables 
    WHERE table_schema='{$escapedDb}' 
      AND table_name IN ('rutinaprograma', 'rutinaejecicio', 'programaentrenamiento', 'planejercicio', 'programacliente', 'ejercicioequipo')
");
$keyCount = ($resKey && $rk = $resKey->fetch_assoc()) ? $rk['total'] : 0;

echo "\n======================================================================\n";
echo "   ✓ ¡BASE DE DATOS ACTUALIZADA EXITOSAMENTE EN LA NUBE!             \n";
echo "======================================================================\n";
echo "  Archivo respaldo:    {$backupFile}\n";
echo "  Host nube:           {$cloudHost}:{$cloudPort}\n";
echo "  Base remota:         {$cloudDb}\n";
echo "  Tablas migradas:     {$totalTables}\n";
echo "  Tablas clave listas: {$keyCount} / 6\n";
echo "  Tiempo de subida:    {$elapsed} segundos\n";
echo "======================================================================\n";
