<?php
/**
 * Script de migración en la nube / local para Gim360:
 * Tabla imagenreceta y vista de compatibilidad.
 * 
 * Este script es 100% idempotente: no borra ni modifica datos existentes.
 * 
 * Uso por línea de comando (SSH/Terminal):
 *   php migrate_imagenreceta.php
 * 
 * Uso por navegador web:
 *   https://tudominio.com/migrate_imagenreceta.php
 *   o https://tudominio.com/public/migrate_imagenreceta.php
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
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Migración Gim360: Módulo ImagenReceta</title>';
    echo '<style>body{font-family:sans-serif;background:#f8f9fa;padding:30px;color:#333;} .box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);max-width:700px;margin:auto;} .success{color:#198754;font-weight:bold;} .error{color:#dc3545;font-weight:bold;} hr{margin:20px 0;border:0;border-top:1px solid #ddd;}</style>';
    echo '</head><body><div class="box"><h2>Migración Gim360: Módulo ImagenReceta</h2><hr>';
}

try {
    outputMsg("Conectando a base de datos MySQL en {$dbHost}:{$dbPort} [BD: {$dbName}]...", $isCli);
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

    if ($mysqli->connect_error) {
        throw new Exception("Error de conexión: " . $mysqli->connect_error);
    }

    $mysqli->set_charset("utf8mb4");
    outputMsg("✔ Conexión establecida con éxito.", $isCli);

    // 1. Crear tabla imagenreceta
    $sqlTable = "CREATE TABLE IF NOT EXISTS `imagenreceta` (
      `idimagenreceta` int(11) NOT NULL AUTO_INCREMENT,
      `idimagen` int(11) NOT NULL,
      `idreceta` int(11) NOT NULL,
      PRIMARY KEY (`idimagenreceta`),
      UNIQUE KEY `uk_imagen_receta` (`idimagen`, `idreceta`),
      KEY `fk_ir_imagen` (`idimagen`),
      KEY `fk_ir_receta` (`idreceta`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";

    if ($mysqli->query($sqlTable)) {
        outputMsg("✔ Tabla 'imagenreceta' verificada o creada exitosamente.", $isCli);
    } else {
        outputMsg("⚠ Aviso al crear tabla 'imagenreceta': " . $mysqli->error, $isCli);
    }

    // 2. Foreign keys (si no existen)
    try {
        @$mysqli->query("ALTER TABLE `imagenreceta` 
            ADD CONSTRAINT `fk_ir_imagen` FOREIGN KEY (`idimagen`) REFERENCES `imagen` (`idimagen`) ON DELETE CASCADE ON UPDATE CASCADE;");
        @$mysqli->query("ALTER TABLE `imagenreceta` 
            ADD CONSTRAINT `fk_ir_receta` FOREIGN KEY (`idreceta`) REFERENCES `receta` (`idreceta`) ON DELETE CASCADE ON UPDATE CASCADE;");
    } catch (\Throwable $e) {
        // Ignorar si ya existen
    }

    // 3. Crear vista de compatibilidad
    $sqlView = "CREATE OR REPLACE VIEW `ImagenReceta` AS 
                SELECT `idimagenreceta`, `idimagen`, `idreceta` 
                FROM `imagenreceta`;";
    if ($mysqli->query($sqlView)) {
        outputMsg("✔ Vista de compatibilidad 'ImagenReceta' creada o actualizada.", $isCli);
    }

    // 4. Datos semilla si existen registros
    $resImg = $mysqli->query("SELECT idimagen FROM imagen LIMIT 2");
    $resRec = $mysqli->query("SELECT idreceta FROM receta LIMIT 2");
    if ($resImg && $resRec && $resImg->num_rows > 0 && $resRec->num_rows > 0) {
        $imgRows = [];
        while ($r = $resImg->fetch_assoc()) $imgRows[] = $r['idimagen'];
        $recRows = [];
        while ($r = $resRec->fetch_assoc()) $recRows[] = $r['idreceta'];

        for ($i = 0; $i < min(count($imgRows), count($recRows)); $i++) {
            $idimg = (int)$imgRows[$i];
            $idrec = (int)$recRows[$i];
            $mysqli->query("INSERT IGNORE INTO `imagenreceta` (`idimagen`, `idreceta`) VALUES ($idimg, $idrec);");
        }
        outputMsg("✔ Datos de enlace inicial verificados entre imágenes y recetas.", $isCli);
    }

    outputMsg(PHP_EOL . "<span class='success'>¡MIGRACIÓN COMPLETADA CORRECTAMENTE! El módulo imagenreceta está listo para usarse.</span>", $isCli);

    $mysqli->close();
} catch (Exception $e) {
    outputMsg("<span class='error'>Error crítico en la migración: " . $e->getMessage() . "</span>", $isCli);
}

if (!$isCli) {
    echo '<hr><p><a href="' . (function_exists('base_url') ? base_url('imagenreceta') : 'index.php/imagenreceta') . '">Ir al módulo ImagenReceta</a></p></div></body></html>';
}
