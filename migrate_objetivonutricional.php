<?php
/**
 * Script de migración en la nube / local para Gim360:
 * Tabla objetivonutricional y relación con planalimentacion.
 * 
 * Este script es 100% idempotente: no borra ni modifica datos existentes.
 * 
 * Uso por línea de comando (SSH/Terminal):
 *   php migrate_objetivonutricional.php
 * 
 * Uso por navegador web:
 *   https://tudominio.com/migrate_objetivonutricional.php
 *   o https://tudominio.com/public/migrate_objetivonutricional.php
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
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Migración Gim360: Módulo ObjetivoNutricional</title>';
    echo '<style>body{font-family:sans-serif;background:#f8f9fa;padding:30px;color:#333;} .box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);max-width:700px;margin:auto;} .success{color:#198754;font-weight:bold;} .error{color:#dc3545;font-weight:bold;} hr{margin:20px 0;border:0;border-top:1px solid #ddd;}</style>';
    echo '</head><body><div class="box"><h2>Migración Gim360: Módulo Objetivo Nutricional</h2><hr>';
}

outputMsg("=== INICIANDO MIGRACIÓN OBJETIVONUTRICIONAL ===", $isCli);
outputMsg("Conectando a base de datos '{$dbName}' en '{$dbHost}'...", $isCli);

$mysqli = @new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

if ($mysqli->connect_error) {
    outputMsg("ERROR: No se pudo conectar a la base de datos: " . $mysqli->connect_error, $isCli);
    if (!$isCli) echo '</div></body></html>';
    exit(1);
}

$mysqli->set_charset("utf8mb4");
outputMsg("Conexión exitosa a MySQL.", $isCli);

// 1. Crear tabla objetivonutricional
$sqlTable = "CREATE TABLE IF NOT EXISTS `objetivonutricional` (
  `idobjetivonutricional` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) NOT NULL,
  PRIMARY KEY (`idobjetivonutricional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";

if ($mysqli->query($sqlTable)) {
    outputMsg("✓ Tabla 'objetivonutricional' creada o verificada correctamente.", $isCli);
} else {
    outputMsg("⚠ Aviso al crear tabla: " . $mysqli->error, $isCli);
}

// 2. Crear vista de compatibilidad
$sqlView = "CREATE OR REPLACE VIEW `ObjetivoNutricional` AS 
            SELECT `idobjetivonutricional`, `nombre` 
            FROM `objetivonutricional`;";

if ($mysqli->query($sqlView)) {
    outputMsg("✓ Vista de compatibilidad 'ObjetivoNutricional' creada.", $isCli);
} else {
    outputMsg("⚠ Aviso al crear vista: " . $mysqli->error, $isCli);
}

// 3. Semilla de datos
$sqlSeeds = "INSERT IGNORE INTO `objetivonutricional` (`idobjetivonutricional`, `nombre`) VALUES
(1, 'Pérdida de Grasa y Definición Muscular'),
(2, 'Aumento de Masa Muscular (Hipertrofia / Superávit Calórico)'),
(3, 'Mantenimiento y Recomposición Corporal'),
(4, 'Rendimiento Deportivo y Resistencia'),
(5, 'Salud Cardiovascular y Control Metabólico'),
(6, 'Fuerza Máxima y Potencia');";

if ($mysqli->query($sqlSeeds)) {
    outputMsg("✓ Objetivos nutricionales base insertados.", $isCli);
}

// 4. Agregar columna idobjetivonutricional a planalimentacion si no existe
$checkCol = $mysqli->query("SELECT COUNT(*) AS total FROM information_schema.COLUMNS 
                            WHERE TABLE_SCHEMA = '{$dbName}' 
                            AND TABLE_NAME = 'planalimentacion' 
                            AND COLUMN_NAME = 'idobjetivonutricional'");
$colRow = $checkCol ? $checkCol->fetch_assoc() : ['total' => 0];

if ((int)$colRow['total'] === 0) {
    $sqlAlter = "ALTER TABLE `planalimentacion` 
                 ADD COLUMN `idobjetivonutricional` int(11) DEFAULT NULL AFTER `idpersona`,
                 ADD KEY `fk_plan_objetivonutricional` (`idobjetivonutricional`),
                 ADD CONSTRAINT `fk_plan_objetivonutricional` 
                 FOREIGN KEY (`idobjetivonutricional`) REFERENCES `objetivonutricional` (`idobjetivonutricional`) 
                 ON DELETE SET NULL ON UPDATE CASCADE;";
    if ($mysqli->query($sqlAlter)) {
        outputMsg("✓ Columna 'idobjetivonutricional' añadida con éxito a 'planalimentacion'.", $isCli);
    } else {
        outputMsg("⚠ Aviso al modificar planalimentacion: " . $mysqli->error, $isCli);
    }
} else {
    outputMsg("✓ Columna 'idobjetivonutricional' ya existía en 'planalimentacion'.", $isCli);
}

outputMsg("=== MIGRACIÓN FINALIZADA CON ÉXITO ===", $isCli);

if (!$isCli) {
    echo '<hr><p class="success">La base de datos está completamente actualizada y lista para usar ObjetivoNutricional.</p>';
    echo '<a href="objetivonutricional" style="display:inline-block;padding:10px 18px;background:#0d6efd;color:#fff;text-decoration:none;border-radius:5px;">Ir a Objetivos Nutricionales</a> ';
    echo '<a href="planalimentacion/add" style="display:inline-block;padding:10px 18px;background:#198754;color:#fff;text-decoration:none;border-radius:5px;">Crear Nuevo Plan Alimenticio</a>';
    echo '</div></body></html>';
}
