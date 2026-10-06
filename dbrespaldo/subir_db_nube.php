<?php
/**
 * Script PHP: subir_db_nube.php
 * Ubicación: /var/www/html/gim360/dbrespaldo/subir_db_nube.php
 *
 * Permite respaldar la base de datos local 'gim360' y subirla/migrarla
 * a la base de datos en la nube.
 *
 * Uso CLI:
 *   php dbrespaldo/subir_db_nube.php
 *   php dbrespaldo/subir_db_nube.php --host=midominio.com --user=remoto --pass=secret --db=gim360
 *   php dbrespaldo/subir_db_nube.php --solo-exportar
 */

// Asegurar ejecución solo desde CLI o con token seguro si es web
if (php_sapi_name() !== 'cli') {
    $tokenReq = $_GET['token'] ?? '';
    // Evitar acceso no autorizado por navegador
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
$options = getopt('', ['host:', 'port:', 'user:', 'pass:', 'db:', 'file:', 'solo-exportar', 'help']);

if (isset($options['help'])) {
    echo "Uso: php dbrespaldo/subir_db_nube.php [OPCIONES]\n\n";
    echo "Opciones:\n";
    echo "  --host=HOST       Host o IP del servidor en la nube\n";
    echo "  --port=PUERTO     Puerto remoto (default: 3306)\n";
    echo "  --user=USUARIO    Usuario MySQL remoto\n";
    echo "  --pass=PASSWORD   Contraseña MySQL remota\n";
    echo "  --db=NOMBRE_BD    Nombre de la base de datos remota (default: gim360)\n";
    echo "  --file=ARCHIVO    Usar archivo SQL existente\n";
    echo "  --solo-exportar   Generar únicamente el respaldo local\n";
    echo "  --help            Mostrar esta ayuda\n";
    exit(0);
}

if (!empty($options['host'])) $cloudHost = $options['host'];
if (!empty($options['port'])) $cloudPort = (int)$options['port'];
if (!empty($options['user'])) $cloudUser = $options['user'];
if (!empty($options['pass'])) $cloudPass = $options['pass'];
if (!empty($options['db']))   $cloudDb   = $options['db'];

$soloExportar = isset($options['solo-exportar']);
$customFile   = $options['file'] ?? null;

echo "======================================================================\n";
echo "   Sincronización de Base de Datos GIM360 a la Nube (PHP CLI)        \n";
echo "======================================================================\n\n";

// 4. Probar conexión local
echo "[1/4] Comprobando conexión local ({$localDb} en {$localHost})...\n";
$localMysqli = @new mysqli($localHost, $localUser, $localPass, $localDb, $localPort);
if ($localMysqli->connect_error) {
    die("[ERROR] No se pudo conectar a la base local: " . $localMysqli->connect_error . "\n");
}
$localMysqli->set_charset('utf8mb4');
echo "[OK] Conexión local exitosa.\n";

// 5. Generar o tomar archivo de respaldo
$timestamp  = date('Y-m-d_His');
$backupFile = $scriptDir . "/gim360_{$timestamp}.sql";

if ($customFile) {
    if (!file_exists($customFile)) {
        die("[ERROR] El archivo especificado no existe: {$customFile}\n");
    }
    $backupFile = $customFile;
    echo "[INFO] Usando archivo SQL indicado: {$backupFile}\n";
} else {
    echo "[2/4] Generando volcado con mysqldump...\n";
    $passArg = !empty($localPass) ? "-p" . escapeshellarg($localPass) : "";
    $dumpCmd = sprintf(
        "mysqldump -h %s -P %d -u %s %s --single-transaction --quick --routines --triggers --hex-blob --default-character-set=utf8mb4 %s > %s",
        escapeshellarg($localHost),
        $localPort,
        escapeshellarg($localUser),
        $passArg,
        escapeshellarg($localDb),
        escapeshellarg($backupFile)
    );

    exec($dumpCmd, $output, $returnCode);
    if ($returnCode !== 0 || !file_exists($backupFile) || filesize($backupFile) === 0) {
        die("[ERROR] Falló la ejecución de mysqldump (Código: {$returnCode})\n");
    }

    $sizeMb = round(filesize($backupFile) / (1024 * 1024), 2);
    echo "[OK] Respaldo generado con éxito: {$backupFile} ({$sizeMb} MB)\n";

    // Actualizar copias de referencia
    $fechaDia = date('Y-m-d');
    copy($backupFile, $scriptDir . "/gim360-{$fechaDia}.sql");
    copy($backupFile, $scriptDir . '/gim360.sql');
    copy($backupFile, $projectDir . '/gim360.sql');
    echo "[OK] Copias sincronizadas: dbrespaldo/gim360-{$fechaDia}.sql y gim360.sql\n";
}

if ($soloExportar) {
    echo "\n[ÉXITO] Proceso finalizado en modo solo-exportar.\n";
    exit(0);
}

// 6. Verificar datos de conexión en la nube
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
echo "[OK] Conexión remota establecida.\n";

// Asegurar que la base de datos exista
$escapedDb = $cloudMysqli->real_escape_string($cloudDb);
$cloudMysqli->query("CREATE DATABASE IF NOT EXISTS `{$escapedDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
if (!$cloudMysqli->select_db($cloudDb)) {
    die("[ERROR] No se pudo seleccionar la base de datos '{$cloudDb}' en la nube: " . $cloudMysqli->error . "\n");
}

// 8. Importar a la nube
echo "[4/4] Subiendo datos e importando estructura a '{$cloudDb}' en la nube...\n";
$start = microtime(true);

$passArgCloud = !empty($cloudPass) ? "-p" . escapeshellarg($cloudPass) : "";
$sslFlag      = $cloudSsl ? "--ssl-mode=REQUIRED" : "";

$importCmd = sprintf(
    "mysql -h %s -P %d -u %s %s %s %s < %s",
    escapeshellarg($cloudHost),
    $cloudPort,
    escapeshellarg($cloudUser),
    $passArgCloud,
    $sslFlag,
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

echo "\n======================================================================\n";
echo "   ✓ ¡BASE DE DATOS MIGRADA EXITOSAMENTE A LA NUBE!                  \n";
echo "======================================================================\n";
echo "  Base local:        {$localDb} ({$localHost})\n";
echo "  Archivo respaldo:  {$backupFile}\n";
echo "  Host nube:         {$cloudHost}:{$cloudPort}\n";
echo "  Base remota:       {$cloudDb}\n";
echo "  Tablas migradas:   {$totalTables}\n";
echo "  Tiempo de subida:  {$elapsed} segundos\n";
echo "======================================================================\n";
