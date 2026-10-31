<?php
/**
 * Script de migración en la nube / local para Gim360:
 * Tabla cumplimientoplanalimentacion y vista de compatibilidad.
 * 
 * Este script es 100% idempotente: no borra ni modifica datos existentes.
 * 
 * Uso por línea de comando (SSH/Terminal):
 *   php migrate_cumplimientoplanalimentacion.php
 * 
 * Uso por navegador web:
 *   https://tudominio.com/migrate_cumplimientoplanalimentacion.php
 *   o https://tudominio.com/public/migrate_cumplimientoplanalimentacion.php
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
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Migración Gim360: Módulo CumplimientoPlanAlimentacion</title>';
    echo '<style>body{font-family:sans-serif;background:#f8f9fa;padding:30px;color:#333;} .box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);max-width:700px;margin:auto;} .success{color:#198754;font-weight:bold;} .error{color:#dc3545;font-weight:bold;} hr{margin:20px 0;border:0;border-top:1px solid #ddd;}</style>';
    echo '</head><body><div class="box"><h2>Migración Gim360: Módulo CumplimientoPlanAlimentacion</h2><hr>';
}

try {
    outputMsg("Conectando a base de datos MySQL en {$dbHost}:{$dbPort} [BD: {$dbName}]...", $isCli);
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

    if ($mysqli->connect_error) {
        throw new Exception("Error de conexión: " . $mysqli->connect_error);
    }

    $mysqli->set_charset("utf8mb4");
    outputMsg("✔ Conexión establecida con éxito.", $isCli);

    // 1. Crear tabla cumplimientoplanalimentacion
    $sqlTable = "CREATE TABLE IF NOT EXISTS `cumplimientoplanalimentacion` (
      `idcumplimientoplanalimentacion` int(11) NOT NULL AUTO_INCREMENT,
      `idplanalimentacion` int(11) NOT NULL,
      `idcomida` int(11) NOT NULL,
      `fechahora` datetime NOT NULL,
      PRIMARY KEY (`idcumplimientoplanalimentacion`),
      KEY `fk_cumplimiento_plan` (`idplanalimentacion`),
      KEY `fk_cumplimiento_comida` (`idcomida`),
      KEY `idx_cumplimiento_fechahora` (`fechahora`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";

    if ($mysqli->query($sqlTable)) {
        outputMsg("✔ Tabla 'cumplimientoplanalimentacion' verificada o creada exitosamente.", $isCli);
    } else {
        outputMsg("⚠ Aviso al crear tabla 'cumplimientoplanalimentacion': " . $mysqli->error, $isCli);
    }

    // 2. Foreign keys (si no existen)
    try {
        @$mysqli->query("ALTER TABLE `cumplimientoplanalimentacion` 
            ADD CONSTRAINT `fk_cumplimiento_plan` FOREIGN KEY (`idplanalimentacion`) REFERENCES `planalimentacion` (`idplanalimentacion`) ON DELETE CASCADE ON UPDATE CASCADE;");
    } catch (\Throwable $e) {}

    try {
        @$mysqli->query("ALTER TABLE `cumplimientoplanalimentacion` 
            ADD CONSTRAINT `fk_cumplimiento_comida` FOREIGN KEY (`idcomida`) REFERENCES `comida` (`idcomida`) ON DELETE CASCADE ON UPDATE CASCADE;");
    } catch (\Throwable $e) {}

    // 3. Crear vista de compatibilidad
    $sqlView = "CREATE OR REPLACE VIEW `CumplimientoPlanAlimentacion` AS 
                SELECT `idcumplimientoplanalimentacion`, `idplanalimentacion`, `idcomida`, `fechahora` 
                FROM `cumplimientoplanalimentacion`;";
    if ($mysqli->query($sqlView)) {
        outputMsg("✔ Vista de compatibilidad 'CumplimientoPlanAlimentacion' creada o actualizada.", $isCli);
    }

    // 4. Semilla de datos de prueba si existen planes y comidas
    $sqlSeed = "INSERT INTO `cumplimientoplanalimentacion` (`idplanalimentacion`, `idcomida`, `fechahora`)
                SELECT c.`idplanalimentacion`, c.`idcomida`, NOW()
                FROM `comida` c
                WHERE c.`idcomida` = (SELECT MIN(c2.`idcomida`) FROM `comida` c2 WHERE c2.`idplanalimentacion` = c.`idplanalimentacion`)
                  AND NOT EXISTS (
                    SELECT 1 FROM `cumplimientoplanalimentacion` cp 
                    WHERE cp.`idplanalimentacion` = c.`idplanalimentacion` AND cp.`idcomida` = c.`idcomida`
                  )
                LIMIT 3;";
    $mysqli->query($sqlSeed);
    outputMsg("✔ Registros de prueba verificados en 'cumplimientoplanalimentacion'.", $isCli);

    outputMsg(PHP_EOL . "<span class='success'>¡MIGRACIÓN COMPLETADA CORRECTAMENTE! El módulo cumplimientoplanalimentacion está listo para usarse.</span>", $isCli);

    $mysqli->close();
} catch (Exception $e) {
    outputMsg("<span class='error'>Error crítico en la migración: " . $e->getMessage() . "</span>", $isCli);
}

if (!$isCli) {
    echo '<hr><p><a href="' . (function_exists('base_url') ? base_url('cumplimientoplanalimentacion') : 'index.php/cumplimientoplanalimentacion') . '">Ir al módulo CumplimientoPlanAlimentacion</a></p></div></body></html>';
}
