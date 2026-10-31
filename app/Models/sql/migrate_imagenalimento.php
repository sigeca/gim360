<?php
/**
 * Script de migración en la nube / local para Gim360:
 * Tabla imagenalimento y vista de compatibilidad.
 * 
 * Este script es 100% idempotente: no borra ni modifica datos existentes.
 * 
 * Uso por línea de comando (SSH/Terminal):
 *   php migrate_imagenalimento.php
 * 
 * Uso por navegador web:
 *   https://tudominio.com/migrate_imagenalimento.php
 *   o https://tudominio.com/public/migrate_imagenalimento.php
 */

$envFiles = [
    __DIR__ . '/.env',
    dirname(__DIR__, 2) . '/.env',
    dirname(__DIR__, 3) . '/.env',
    dirname(__DIR__) . '/.env',
];

$envFile = null;
foreach ($envFiles as $ef) {
    if (file_exists($ef)) {
        $envFile = $ef;
        break;
    }
}

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'PIWIIB1234';
$dbName = 'gim360';
$dbPort = 3306;

if ($envFile && file_exists($envFile)) {
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
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Migración Gim360: Módulo ImagenAlimento</title>';
    echo '<style>body{font-family:sans-serif;background:#f8f9fa;padding:30px;color:#333;} .box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);max-width:700px;margin:auto;} .success{color:#198754;font-weight:bold;} .error{color:#dc3545;font-weight:bold;} hr{margin:20px 0;border:0;border-top:1px solid #ddd;}</style>';
    echo '</head><body><div class="box"><h2>Migración Gim360: Módulo ImagenAlimento</h2><hr>';
}

try {
    outputMsg("Conectando a base de datos MySQL en {$dbHost}:{$dbPort} [BD: {$dbName}]...", $isCli);
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

    if ($mysqli->connect_error) {
        throw new Exception("Error de conexión: " . $mysqli->connect_error);
    }

    $mysqli->set_charset("utf8mb4");
    outputMsg("✔ Conexión establecida con éxito.", $isCli);

    // 1. Crear tabla imagenalimento
    $sqlTable = "CREATE TABLE IF NOT EXISTS `imagenalimento` (
      `idimagenalimento` int(11) NOT NULL AUTO_INCREMENT,
      `idimagen` int(11) NOT NULL,
      `idalimento` int(11) NOT NULL,
      PRIMARY KEY (`idimagenalimento`),
      UNIQUE KEY `uk_imagen_alimento` (`idimagen`, `idalimento`),
      KEY `fk_ia_imagen` (`idimagen`),
      KEY `fk_ia_alimento` (`idalimento`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";

    if ($mysqli->query($sqlTable)) {
        outputMsg("✔ Tabla 'imagenalimento' verificada o creada exitosamente.", $isCli);
    } else {
        outputMsg("⚠ Aviso al crear tabla 'imagenalimento': " . $mysqli->error, $isCli);
    }

    // 2. Foreign keys (si no existen)
    try {
        @$mysqli->query("ALTER TABLE `imagenalimento` 
            ADD CONSTRAINT `fk_ia_imagen` FOREIGN KEY (`idimagen`) REFERENCES `imagen` (`idimagen`) ON DELETE CASCADE ON UPDATE CASCADE;");
        @$mysqli->query("ALTER TABLE `imagenalimento` 
            ADD CONSTRAINT `fk_ia_alimento` FOREIGN KEY (`idalimento`) REFERENCES `alimento` (`idalimento`) ON DELETE CASCADE ON UPDATE CASCADE;");
    } catch (\Throwable $e) {
        // Ignorar si ya existen
    }

    // 3. Crear vista de compatibilidad
    $sqlView = "CREATE OR REPLACE VIEW `ImagenAlimento` AS 
                SELECT `idimagenalimento`, `idimagen`, `idalimento` 
                FROM `imagenalimento`;";
    if ($mysqli->query($sqlView)) {
        outputMsg("✔ Vista de compatibilidad 'ImagenAlimento' creada o actualizada.", $isCli);
    }

    // 4. Datos semilla si existen registros
    $resImg = $mysqli->query("SELECT idimagen FROM imagen LIMIT 2");
    $resAli = $mysqli->query("SELECT idalimento FROM alimento LIMIT 2");
    if ($resImg && $resAli && $resImg->num_rows > 0 && $resAli->num_rows > 0) {
        $imgRows = [];
        while ($r = $resImg->fetch_assoc()) $imgRows[] = $r['idimagen'];
        $aliRows = [];
        while ($r = $resAli->fetch_assoc()) $aliRows[] = $r['idalimento'];

        for ($i = 0; $i < min(count($imgRows), count($aliRows)); $i++) {
            $idimg = (int)$imgRows[$i];
            $idali = (int)$aliRows[$i];
            $mysqli->query("INSERT IGNORE INTO `imagenalimento` (`idimagen`, `idalimento`) VALUES ($idimg, $idali);");
        }
        outputMsg("✔ Datos de enlace inicial verificados entre imágenes y alimentos.", $isCli);
    }

    outputMsg(PHP_EOL . "<span class='success'>¡MIGRACIÓN COMPLETADA CORRECTAMENTE! El módulo imagenalimento está listo para usarse.</span>", $isCli);

    $mysqli->close();
} catch (Exception $e) {
    outputMsg("<span class='error'>Error crítico en la migración: " . $e->getMessage() . "</span>", $isCli);
}

if (!$isCli) {
    echo '<hr><p><a href="' . (function_exists('base_url') ? base_url('imagenalimento') : 'index.php/imagenalimento') . '">Ir al módulo ImagenAlimento</a></p></div></body></html>';
}
