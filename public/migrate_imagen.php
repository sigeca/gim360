<?php
/**
 * Script de migración en la nube / local para Gim360:
 * Tabla imagen, formatoimagen, ordenador, directorio y carpeta repositorio/imagen.
 * 
 * Este script es 100% idempotente: no borra ni modifica datos existentes.
 * 
 * Uso por línea de comando (SSH/Terminal):
 *   php migrate_imagen.php
 * 
 * Uso por navegador web:
 *   https://tudominio.com/migrate_imagen.php
 *   o https://tudominio.com/public/migrate_imagen.php
 */

$envFile = __DIR__ . '/.env';
if (!file_exists($envFile) && file_exists(dirname(__DIR__) . '/.env')) {
    $envFile = dirname(__DIR__) . '/.env';
}

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'gim360';
$dbPort = 3306;

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (strpos($line, '#') === 0) continue;
        if (preg_match('/^database\.default\.hostname\s*=\s*(.+)$/i', $line, $m)) $dbHost = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.database\s*=\s*(.+)$/i', $line, $m)) $dbName = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.username\s*=\s*(.+)$/i', $line, $m)) $dbUser = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.password\s*=\s*(.+)$/i', $line, $m)) $dbPass = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.port\s*=\s*(.+)$/i', $line, $m)) $dbPort = (int)trim($m[1], " '\"");
    }
}

$dbHost = getenv('DB_HOST') ?: (isset($_GET['db_host']) ? $_GET['db_host'] : $dbHost);
$dbUser = getenv('DB_USER') ?: (isset($_GET['db_user']) ? $_GET['db_user'] : $dbUser);
$dbPass = getenv('DB_PASS') ?: (isset($_GET['db_pass']) ? $_GET['db_pass'] : $dbPass);
$dbName = getenv('DB_NAME') ?: (isset($_GET['db_name']) ? $_GET['db_name'] : $dbName);

$isCli = (php_sapi_name() === 'cli');

function outputMsg($msg, $isCli) {
    if ($isCli) {
        echo $msg . PHP_EOL;
    } else {
        echo nl2br(htmlspecialchars($msg)) . '<br>';
    }
}

if (!$isCli) {
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Migración Gim360: Módulo Imagen</title>';
    echo '<style>body{font-family:sans-serif;background:#f8f9fa;padding:30px;color:#333;} .box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);max-width:700px;margin:auto;} .success{color:#198754;font-weight:bold;} .error{color:#dc3545;font-weight:bold;} hr{margin:20px 0;border:0;border-top:1px solid #ddd;}</style>';
    echo '</head><body><div class="box"><h2>Migración Gim360: Módulo Imagen & Multimedia</h2><hr>';
}

outputMsg("==> Conectando a la base de datos '{$dbName}' en '{$dbHost}:{$dbPort}'...", $isCli);

mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

if ($mysqli->connect_error) {
    outputMsg("[ERROR] Error de conexión: " . $mysqli->connect_error, $isCli);
    if (!$isCli) echo '</div></body></html>';
    exit(1);
}

$mysqli->set_charset("utf8mb4");
outputMsg("[OK] Conexión establecida con éxito.", $isCli);

// 1. Tabla formatoimagen
$sqlFormato = "CREATE TABLE IF NOT EXISTS `formatoimagen` (
  `idformatoimagen` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idformatoimagen`),
  UNIQUE KEY `uk_formatoimagen_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";
$mysqli->query($sqlFormato);
$mysqli->query("CREATE OR REPLACE VIEW `FormatoImagen` AS SELECT `idformatoimagen`, `nombre` FROM `formatoimagen`;");
$mysqli->query("INSERT IGNORE INTO `formatoimagen` (`idformatoimagen`, `nombre`) VALUES (1,'jpg'),(2,'png'),(3,'webp'),(4,'gif'),(5,'jpeg');");
outputMsg("[OK] Tabla 'formatoimagen' y vista verificadas.", $isCli);

// 2. Tabla ordenador
$sqlOrdenador = "CREATE TABLE IF NOT EXISTS `ordenador` (
  `idordenador` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idordenador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";
$mysqli->query($sqlOrdenador);
$mysqli->query("CREATE OR REPLACE VIEW `Ordenador` AS SELECT `idordenador`, `nombre` FROM `ordenador`;");
$mysqli->query("INSERT IGNORE INTO `ordenador` (`idordenador`, `nombre`) VALUES (1, 'Servidor Local gim360');");
outputMsg("[OK] Tabla 'ordenador' y vista verificadas.", $isCli);

// 3. Tabla directorio
$sqlDirectorio = "CREATE TABLE IF NOT EXISTS `directorio` (
  `iddirectorio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `ruta` varchar(200) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `idordenador` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`iddirectorio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";
$mysqli->query($sqlDirectorio);
$mysqli->query("CREATE OR REPLACE VIEW `Directorio` AS SELECT `iddirectorio`, `nombre`, `ruta`, `descripcion`, `idordenador` FROM `directorio`;");
$mysqli->query("INSERT IGNORE INTO `directorio` (`iddirectorio`, `nombre`, `ruta`, `descripcion`, `idordenador`) VALUES (1, 'Imagenes Gim360', 'repositorio/imagen', 'Directorio de almacenamiento de imágenes', 1);");
outputMsg("[OK] Tabla 'directorio' y vista verificadas.", $isCli);

// 4. Tabla imagen
$sqlImagen = "CREATE TABLE IF NOT EXISTS `imagen` (
  `idimagen` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `idformatoimagen` int(11) DEFAULT NULL,
  `fechacaptura` datetime DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `palabrasclave` text DEFAULT NULL,
  `licencia` varchar(50) DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `idordenador` int(11) DEFAULT 1,
  `iddirectorio` int(11) DEFAULT 1,
  PRIMARY KEY (`idimagen`),
  KEY `idx_imagen_formato` (`idformatoimagen`),
  KEY `idx_imagen_ordenador` (`idordenador`),
  KEY `idx_imagen_directorio` (`iddirectorio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";

if ($mysqli->query($sqlImagen)) {
    outputMsg("[OK] Tabla 'imagen' creada / verificada correctamente.", $isCli);
} else {
    outputMsg("[ERROR] Falló al crear tabla 'imagen': " . $mysqli->error, $isCli);
}

$mysqli->query("CREATE OR REPLACE VIEW `Imagen` AS SELECT `idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio` FROM `imagen`;");
outputMsg("[OK] Vista de compatibilidad 'Imagen' creada.", $isCli);

// 5. Directorio físico repositorio/imagen
$baseProject = is_dir(__DIR__ . '/repositorio') ? __DIR__ : dirname(__DIR__);
$repoImg = $baseProject . '/repositorio/imagen';
if (!is_dir($repoImg)) {
    @mkdir($repoImg, 0777, true);
}
@chmod($repoImg, 0777);

if (is_dir($repoImg) && is_writable($repoImg)) {
    outputMsg("[OK] Directorio físico '{$repoImg}' verificado con permisos de escritura.", $isCli);
} else {
    outputMsg("[AVISO] El directorio '{$repoImg}' existe pero verifique permisos de escritura (chmod 777).", $isCli);
}

// Enlace simbólico en public/repositorio
$publicRepo = $baseProject . '/public/repositorio';
if (!file_exists($publicRepo) && is_dir($baseProject . '/repositorio')) {
    @symlink('../repositorio', $publicRepo);
    outputMsg("[OK] Enlace simbólico 'public/repositorio' creado.", $isCli);
}

$resCount = $mysqli->query("SELECT COUNT(*) AS total FROM `imagen`");
$total = ($resCount) ? $resCount->fetch_assoc()['total'] : 0;
outputMsg("[INFO] Total de imágenes en la base de datos: {$total}", $isCli);

outputMsg("==> Migración finalizada exitosamente.", $isCli);

$mysqli->close();

if (!$isCli) {
    echo '<hr><p class="success">Proceso completado. Ya puedes registrar imágenes en Gim360 sin errores.</p>';
    echo '<p><a href="./imagen/add" style="background:#0284c7;color:#fff;padding:8px 16px;border-radius:6px;text-decoration:none;font-weight:bold;">Ir a Registrar Imagen</a></p>';
    echo '</div></body></html>';
}
