<?php
/**
 * Script de migración en la nube / local para Gim360:
 * Agregar campo iddiasemana a tabla comida, foreign key y actualizar vista.
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
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Migración Gim360: Comida - DiaSemana</title>';
    echo '<style>body{font-family:sans-serif;background:#f8f9fa;padding:30px;color:#333;} .box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);max-width:700px;margin:auto;} .success{color:#198754;font-weight:bold;} .error{color:#dc3545;font-weight:bold;} hr{margin:20px 0;border:0;border-top:1px solid #ddd;}</style>';
    echo '</head><body><div class="box"><h2>Migración Gim360: Campo iddiasemana en Comida</h2><hr>';
}

try {
    outputMsg("Conectando a base de datos MySQL en {$dbHost}:{$dbPort} [BD: {$dbName}]...", $isCli);
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

    if ($mysqli->connect_error) {
        throw new Exception("Error de conexión: " . $mysqli->connect_error);
    }

    $mysqli->set_charset("utf8mb4");
    outputMsg("✔ Conexión establecida con éxito.", $isCli);

    // 1. Verificar si columna iddiasemana existe
    $resCol = $mysqli->query("SHOW COLUMNS FROM `comida` LIKE 'iddiasemana'");
    if ($resCol && $resCol->num_rows === 0) {
        $mysqli->query("ALTER TABLE `comida` ADD COLUMN `iddiasemana` int(11) DEFAULT NULL AFTER `idplanalimentacion`");
        outputMsg("✔ Columna 'iddiasemana' agregada a tabla 'comida'.", $isCli);
    } else {
        outputMsg("✔ Columna 'iddiasemana' ya existe en 'comida'.", $isCli);
    }

    // 2. Asignar 1 (Lunes) por defecto a los que estén NULL
    $mysqli->query("UPDATE `comida` SET `iddiasemana` = 1 WHERE `iddiasemana` IS NULL");
    outputMsg("✔ Registros existentes actualizados con día de semana inicial.", $isCli);

    // 3. Índice y Constraint
    try {
        @$mysqli->query("ALTER TABLE `comida` ADD KEY `fk_comida_diasemana` (`iddiasemana`)");
    } catch (\Throwable $e) {}

    try {
        @$mysqli->query("ALTER TABLE `comida` ADD CONSTRAINT `fk_comida_diasemana` FOREIGN KEY (`iddiasemana`) REFERENCES `diasemana` (`iddiasemana`) ON UPDATE CASCADE ON DELETE SET NULL");
    } catch (\Throwable $e) {}
    outputMsg("✔ Llave foránea 'fk_comida_diasemana' verificada.", $isCli);

    // 4. Actualizar vista de compatibilidad
    $mysqli->query("CREATE OR REPLACE VIEW `Comida` AS SELECT `idcomida`, `idplanalimentacion`, `iddiasemana`, `idtipocomida`, `idreceta`, `horarecomendada` FROM `comida`");
    outputMsg("✔ Vista de compatibilidad 'Comida' actualizada.", $isCli);

    outputMsg(PHP_EOL . "<span class='success'>¡MIGRACIÓN COMPLETADA CORRECTAMENTE! El campo iddiasemana está listo.</span>", $isCli);

    $mysqli->close();
} catch (Exception $e) {
    outputMsg("<span class='error'>Error crítico en la migración: " . $e->getMessage() . "</span>", $isCli);
}

if (!$isCli) {
    echo '<hr><p><a href="' . (function_exists('base_url') ? base_url('comida') : 'index.php/comida') . '">Ir al módulo Comida</a></p></div></body></html>';
}
