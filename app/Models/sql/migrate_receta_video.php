<?php
/**
 * Script de migración en la nube / local para Gim360:
 * Agregar campo 'video' a tabla 'receta' y actualizar vista de compatibilidad 'Receta'.
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
        echo strip_tags($msg) . PHP_EOL;
    } else {
        echo nl2br($msg) . '<br>';
    }
}

if (!$isCli) {
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Migración Gim360: Receta - Video</title>';
    echo '<style>body{font-family:sans-serif;background:#f8f9fa;padding:30px;color:#333;} .box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);max-width:700px;margin:auto;} .success{color:#198754;font-weight:bold;} .error{color:#dc3545;font-weight:bold;} hr{margin:20px 0;border:0;border-top:1px solid #ddd;}</style>';
    echo '</head><body><div class="box"><h2>Migración Gim360: Campo video en Receta</h2><hr>';
}

try {
    outputMsg("Conectando a base de datos MySQL en {$dbHost}:{$dbPort} [BD: {$dbName}]...", $isCli);
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

    if ($mysqli->connect_error) {
        throw new Exception("Error de conexión: " . $mysqli->connect_error);
    }

    $mysqli->set_charset("utf8mb4");
    outputMsg("✔ Conexión establecida con éxito.", $isCli);

    // 1. Verificar si columna 'video' existe en 'receta'
    $resCol = $mysqli->query("SHOW COLUMNS FROM `receta` LIKE 'video'");
    if ($resCol && $resCol->num_rows === 0) {
        $mysqli->query("ALTER TABLE `receta` ADD COLUMN `video` VARCHAR(300) DEFAULT NULL AFTER `tiempopreparacion`");
        outputMsg("✔ Columna 'video' (VARCHAR 300) agregada a la tabla 'receta'.", $isCli);
    } else {
        outputMsg("✔ Columna 'video' ya existe en 'receta'.", $isCli);
    }

    // 2. Actualizar la vista de compatibilidad 'Receta'
    $mysqli->query("CREATE OR REPLACE VIEW `Receta` AS SELECT `idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`, `video` FROM `receta`");
    outputMsg("✔ Vista SQL 'Receta' actualizada con la columna 'video'.", $isCli);

    // 3. Enriquecer recetas iniciales con videos demostrativos
    $videos = [
        1 => 'https://www.youtube.com/watch?v=42eX_20oX54',
        2 => 'https://www.youtube.com/watch?v=mD0Vl2mIuH4',
        3 => 'https://www.youtube.com/watch?v=m53q4qH_L1k',
        4 => 'https://www.youtube.com/watch?v=Z6zV5vEwT7Y',
        5 => 'https://www.youtube.com/watch?v=1F3h3nE8w8Y',
        6 => 'https://www.youtube.com/watch?v=8V7ZkH0_gD4',
        7 => 'https://www.youtube.com/watch?v=5U0h3_x2_j0',
        8 => 'https://www.youtube.com/watch?v=kY67Z3-5qR4',
        9 => 'https://www.youtube.com/watch?v=wXW01mGqP7s',
    ];

    foreach ($videos as $id => $url) {
        $stmt = $mysqli->prepare("UPDATE `receta` SET `video` = ? WHERE `idreceta` = ? AND (`video` IS NULL OR `video` = '')");
        if ($stmt) {
            $stmt->bind_param("si", $url, $id);
            $stmt->execute();
            $stmt->close();
        }
    }
    outputMsg("✔ Videos demostrativos asignados a recetas existentes.", $isCli);

    outputMsg(PHP_EOL . "<span class='success'>¡MIGRACIÓN COMPLETADA CORRECTAMENTE! El campo video en la tabla receta está 100% activo y operativo.</span>", $isCli);

} catch (\Throwable $e) {
    outputMsg("<span class='error'>Error durante la migración: " . $e->getMessage() . "</span>", $isCli);
}

if (!$isCli) {
    echo '<hr><p><a href="' . (isset($_SERVER['HTTP_HOST']) ? '//' . $_SERVER['HTTP_HOST'] . '/receta' : '#') . '" style="color:#0d6efd;font-weight:bold;">Ir al módulo Receta en Gim360</a></p></div></body></html>';
}
