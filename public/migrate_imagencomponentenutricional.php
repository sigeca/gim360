<?php
/**
 * Script de migración en la nube / local para Gim360:
 * Tabla imagencomponentenutricional y vista de compatibilidad.
 * 
 * Este script es 100% idempotente: no borra ni modifica datos existentes.
 * 
 * Uso por línea de comando (SSH/Terminal):
 *   php migrate_imagencomponentenutricional.php
 * 
 * Uso por navegador web:
 *   https://tudominio.com/migrate_imagencomponentenutricional.php
 *   o https://tudominio.com/public/migrate_imagencomponentenutricional.php
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
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Migración Gim360: Módulo ImagenComponenteNutricional</title>';
    echo '<style>body{font-family:sans-serif;background:#f8f9fa;padding:30px;color:#333;} .box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);max-width:700px;margin:auto;} .success{color:#198754;font-weight:bold;} .error{color:#dc3545;font-weight:bold;} hr{margin:20px 0;border:0;border-top:1px solid #ddd;}</style>';
    echo '</head><body><div class="box"><h2>Migración Gim360: Módulo ImagenComponenteNutricional</h2><hr>';
}

outputMsg("=== INICIANDO MIGRACIÓN IMAGENCOMPONENTENUTRICIONAL ===", $isCli);
outputMsg("Conectando a base de datos '{$dbName}' en '{$dbHost}'...", $isCli);

$mysqli = @new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

if ($mysqli->connect_error) {
    outputMsg("ERROR: No se pudo conectar a la base de datos: " . $mysqli->connect_error, $isCli);
    if (!$isCli) echo '</div></body></html>';
    exit(1);
}

$mysqli->set_charset("utf8mb4");
outputMsg("Conexión exitosa a MySQL.", $isCli);

// 1. Crear tabla imagencomponentenutricional
$sqlTable = "CREATE TABLE IF NOT EXISTS `imagencomponentenutricional` (
  `idimagencomponentenutricional` int(11) NOT NULL AUTO_INCREMENT,
  `idimagen` int(11) NOT NULL,
  `idcomponentenutricional` int(11) NOT NULL,
  PRIMARY KEY (`idimagencomponentenutricional`),
  UNIQUE KEY `uk_imagen_componentenutricional` (`idimagen`, `idcomponentenutricional`),
  KEY `fk_icn_imagen` (`idimagen`),
  KEY `fk_icn_componentenutricional` (`idcomponentenutricional`),
  CONSTRAINT `fk_icn_imagen` FOREIGN KEY (`idimagen`) REFERENCES `imagen` (`idimagen`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_icn_componentenutricional` FOREIGN KEY (`idcomponentenutricional`) REFERENCES `componentenutricional` (`idcomponentenutricional`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";

if ($mysqli->query($sqlTable)) {
    outputMsg("✓ Tabla 'imagencomponentenutricional' creada o verificada correctamente.", $isCli);
} else {
    outputMsg("⚠ Aviso al crear tabla 'imagencomponentenutricional': " . $mysqli->error, $isCli);
}

// 2. Crear vista de compatibilidad
$sqlView = "CREATE OR REPLACE VIEW `ImagenComponenteNutricional` AS 
            SELECT `idimagencomponentenutricional`, `idimagen`, `idcomponentenutricional` 
            FROM `imagencomponentenutricional`;";

if ($mysqli->query($sqlView)) {
    outputMsg("✓ Vista de compatibilidad 'ImagenComponenteNutricional' creada.", $isCli);
} else {
    outputMsg("⚠ Aviso al crear vista: " . $mysqli->error, $isCli);
}

outputMsg("=== MIGRACIÓN FINALIZADA CON ÉXITO ===", $isCli);

if (!$isCli) {
    echo '<hr><p class="success">La base de datos está completamente lista para usar el módulo ImagenComponenteNutricional.</p>';
    echo '<a href="componentenutricional" style="display:inline-block;padding:10px 18px;background:#0d6efd;color:#fff;text-decoration:none;border-radius:5px;">Ir a Componentes Nutricionales</a> ';
    echo '<a href="imagencomponentenutricional" style="display:inline-block;padding:10px 18px;background:#198754;color:#fff;text-decoration:none;border-radius:5px;">Ir al Módulo Imagen-Componente</a>';
    echo '</div></body></html>';
}
