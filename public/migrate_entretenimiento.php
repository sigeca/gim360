<?php
/**
 * Script de migración en la nube / local para Gim360:
 * Sección de Entretenimiento (9 tablas y vistas de compatibilidad):
 *   - entretenimiento
 *   - musica
 *   - video
 *   - juego
 *   - podcast
 *   - entretenimientomusica
 *   - entretenimientovideo
 *   - entretenimientojuego
 *   - entretenimientopodcast
 *
 * 100% idempotente y seguro: no borra ni modifica datos existentes.
 *
 * Uso por línea de comando (SSH/Terminal):
 *   php migrate_entretenimiento.php
 *
 * Uso por navegador web:
 *   https://educaysoft.org/gim360/migrate_entretenimiento.php
 *   o https://educaysoft.org/gim360/public/migrate_entretenimiento.php
 */

$envFiles = [
    __DIR__ . '/.env',
    dirname(__DIR__) . '/.env',
    dirname(__DIR__, 2) . '/.env',
    dirname(__DIR__, 3) . '/.env',
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
        echo $msg . '<br>';
    }
}

if (!$isCli) {
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Migración Gim360: Sección Entretenimiento</title>';
    echo '<style>body{font-family:sans-serif;background:#f8f9fa;padding:30px;color:#333;} .box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);max-width:750px;margin:auto;} .success{color:#198754;font-weight:bold;} .error{color:#dc3545;font-weight:bold;} hr{margin:20px 0;border:0;border-top:1px solid #ddd;}</style>';
    echo '</head><body><div class="box"><h2>Migración Gim360: Sección de Entretenimiento</h2><hr>';
}

try {
    outputMsg("==> Conectando a base de datos MySQL en {$dbHost}:{$dbPort} [BD: {$dbName}]...", $isCli);
    mysqli_report(MYSQLI_REPORT_OFF);
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

    if ($mysqli->connect_error) {
        throw new Exception("Error de conexión: " . $mysqli->connect_error);
    }

    $mysqli->set_charset("utf8mb4");
    outputMsg("✔ Conexión establecida con éxito.", $isCli);

    $sqlFileCandidates = [
        __DIR__ . '/database_migration_entretenimiento.sql',
        dirname(__DIR__) . '/database_migration_entretenimiento.sql',
        __DIR__ . '/app/Models/sql/database_migration_entretenimiento.sql',
        dirname(__DIR__) . '/app/Models/sql/database_migration_entretenimiento.sql',
    ];

    $sqlFile = null;
    foreach ($sqlFileCandidates as $cand) {
        if (file_exists($cand)) {
            $sqlFile = $cand;
            break;
        }
    }

    if (!$sqlFile) {
        throw new Exception("No se encontró el archivo SQL database_migration_entretenimiento.sql");
    }

    $sqlContent = file_get_contents($sqlFile);
    if ($mysqli->multi_query($sqlContent)) {
        do {
            if ($res = $mysqli->store_result()) {
                $res->free();
            }
        } while ($mysqli->more_results() && $mysqli->next_result());
    }

    if ($mysqli->errno) {
        outputMsg("⚠ Aviso durante ejecución SQL: " . $mysqli->error, $isCli);
    }

    $tablas = [
        'entretenimiento',
        'musica',
        'video',
        'juego',
        'podcast',
        'entretenimientomusica',
        'entretenimientovideo',
        'entretenimientojuego',
        'entretenimientopodcast',
    ];

    foreach ($tablas as $tabla) {
        $resCount = $mysqli->query("SELECT COUNT(*) AS total FROM `{$tabla}`");
        $total = $resCount ? $resCount->fetch_assoc()['total'] : 0;
        outputMsg("✔ Tabla '<strong>{$tabla}</strong>' activa ({$total} registros).", $isCli);
    }

    outputMsg("<span class='success'>¡MIGRACIÓN DE ENTRETENIMIENTO COMPLETADA EXITOSAMENTE!</span>", $isCli);
    $mysqli->close();
} catch (Exception $e) {
    outputMsg("<span class='error'>Error crítico en la migración: " . htmlspecialchars($e->getMessage()) . "</span>", $isCli);
    if ($isCli) exit(1);
}

if (!$isCli) {
    echo '<hr><p><a href="entretenimiento">Ir al módulo de Entretenimiento</a></p></div></body></html>';
}
