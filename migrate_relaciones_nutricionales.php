<?php
/**
 * Script de migración en la nube / servidor para Gim360:
 * Tablas alimentocomponentenutricional y recetacomponentenutricional.
 * 
 * 100% Idempotente y seguro: no altera ni elimina datos existentes.
 * 
 * Uso por terminal (CLI):
 *   php migrate_relaciones_nutricionales.php
 * 
 * Uso vía navegador:
 *   https://tudominio.com/migrate_relaciones_nutricionales.php
 */

$envFile = __DIR__ . '/.env';
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
        if (preg_match('/^database\.default\.hostname\s*=\s*(.+)$/i', $line, $m)) $dbHost = trim($m[1]);
        if (preg_match('/^database\.default\.database\s*=\s*(.+)$/i', $line, $m)) $dbName = trim($m[1]);
        if (preg_match('/^database\.default\.username\s*=\s*(.+)$/i', $line, $m)) $dbUser = trim($m[1]);
        if (preg_match('/^database\.default\.password\s*=\s*(.+)$/i', $line, $m)) $dbPass = trim($m[1]);
        if (preg_match('/^database\.default\.port\s*=\s*(.+)$/i', $line, $m)) $dbPort = (int)trim($m[1]);
    }
}

$dbHost = getenv('DB_HOST') ?: (isset($_GET['db_host']) ? $_GET['db_host'] : $dbHost);
$dbUser = getenv('DB_USER') ?: (isset($_GET['db_user']) ? $_GET['db_user'] : $dbUser);
$dbPass = getenv('DB_PASS') ?: (isset($_GET['db_pass']) ? $_GET['db_pass'] : $dbPass);
$dbName = getenv('DB_NAME') ?: (isset($_GET['db_name']) ? $_GET['db_name'] : $dbName);

$isCli = (php_sapi_name() === 'cli');

function outputLog($msg, $isCli) {
    if ($isCli) {
        echo $msg . PHP_EOL;
    } else {
        echo nl2br(htmlspecialchars($msg)) . '<br>';
    }
}

if (!$isCli) {
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Migración Relaciones Nutricionales Gim360</title>';
    echo '<style>body{font-family:sans-serif;background:#f4f6f9;padding:30px;color:#333;} .box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);max-width:700px;margin:auto;} .success{color:#198754;font-weight:bold;} .error{color:#dc3545;font-weight:bold;} hr{margin:20px 0;border:0;border-top:1px solid #ddd;}</style>';
    echo '</head><body><div class="box"><h2>Migración Gim360: Relaciones de Componentes Nutricionales</h2><hr>';
}

outputLog("==> Conectando a la base de datos '{$dbName}' en '{$dbHost}:{$dbPort}'...", $isCli);

mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

if ($mysqli->connect_error) {
    outputLog("[ERROR] Conexión fallida: " . $mysqli->connect_error, $isCli);
    if (!$isCli) echo '</div></body></html>';
    exit(1);
}

$mysqli->set_charset("utf8mb4");
outputLog("[OK] Conexión establecida.", $isCli);

// 1. Tabla alimentocomponentenutricional
$sql1 = "CREATE TABLE IF NOT EXISTS `alimentocomponentenutricional` (
  `idalimentocomponentenutricional` int(11) NOT NULL AUTO_INCREMENT,
  `idalimentocomponentenuetricional` int(11) GENERATED ALWAYS AS (`idalimentocomponentenutricional`) VIRTUAL,
  `idalimento` int(11) NOT NULL,
  `idcomponentenutricional` int(11) NOT NULL,
  PRIMARY KEY (`idalimentocomponentenutricional`),
  UNIQUE KEY `uk_alimento_componente` (`idalimento`, `idcomponentenutricional`),
  KEY `fk_acn_alimento` (`idalimento`),
  KEY `fk_acn_componente` (`idcomponentenutricional`),
  CONSTRAINT `fk_acn_alimento` FOREIGN KEY (`idalimento`) REFERENCES `alimento` (`idalimento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_acn_componente` FOREIGN KEY (`idcomponentenutricional`) REFERENCES `componentenutricional` (`idcomponentenutricional`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";

if ($mysqli->query($sql1)) {
    outputLog("[OK] Tabla 'alimentocomponentenutricional' creada o verificada.", $isCli);
} else {
    outputLog("[ERROR] Falló al crear 'alimentocomponentenutricional': " . $mysqli->error, $isCli);
}

// Vista AlimentoComponenteNutricional
$sql1View = "CREATE OR REPLACE VIEW `AlimentoComponenteNutricional` AS
SELECT `idalimentocomponentenutricional`, `idalimentocomponentenuetricional`, `idalimento`, `idcomponentenutricional`
FROM `alimentocomponentenutricional`;";
$mysqli->query($sql1View);

// 2. Tabla recetacomponentenutricional
$sql2 = "CREATE TABLE IF NOT EXISTS `recetacomponentenutricional` (
  `idrecetacomponentenutricional` int(11) NOT NULL AUTO_INCREMENT,
  `idreceta` int(11) NOT NULL,
  `idcomponentenutricional` int(11) NOT NULL,
  PRIMARY KEY (`idrecetacomponentenutricional`),
  UNIQUE KEY `uk_receta_componente` (`idreceta`, `idcomponentenutricional`),
  KEY `fk_rcn_receta` (`idreceta`),
  KEY `fk_rcn_componente` (`idcomponentenutricional`),
  CONSTRAINT `fk_rcn_receta` FOREIGN KEY (`idreceta`) REFERENCES `receta` (`idreceta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rcn_componente` FOREIGN KEY (`idcomponentenutricional`) REFERENCES `componentenutricional` (`idcomponentenutricional`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";

if ($mysqli->query($sql2)) {
    outputLog("[OK] Tabla 'recetacomponentenutricional' creada o verificada.", $isCli);
} else {
    outputLog("[ERROR] Falló al crear 'recetacomponentenutricional': " . $mysqli->error, $isCli);
}

// Vista RecetaComponenteNutricional
$sql2View = "CREATE OR REPLACE VIEW `RecetaComponenteNutricional` AS
SELECT `idrecetacomponentenutricional`, `idreceta`, `idcomponentenutricional`
FROM `recetacomponentenutricional`;";
$mysqli->query($sql2View);

// 3. Inserción de datos semilla con INSERT IGNORE (no altera existentes)
$seedAlimento = [
    [1, 1], [1, 10], [1, 11], [1, 19],
    [2, 1], [2, 3], [2, 18], [2, 19],
    [3, 1], [3, 6], [3, 10],
    [4, 1], [4, 14], [4, 15], [4, 20], [4, 19],
    [5, 1], [5, 2], [5, 12],
    [6, 1], [6, 12], [6, 10],
    [7, 1], [7, 2], [7, 12], [7, 18],
    [8, 2], [8, 7], [8, 13], [8, 1],
    [9, 2], [9, 9],
    [10, 2], [10, 11], [10, 7]
];

$stmt1 = $mysqli->prepare("INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES (?, ?)");
if ($stmt1) {
    foreach ($seedAlimento as $sa) {
        $stmt1->bind_param("ii", $sa[0], $sa[1]);
        $stmt1->execute();
    }
    $stmt1->close();
}

$seedReceta = [
    [1, 1], [1, 2], [1, 7],
    [2, 1], [2, 5], [2, 7], [2, 11],
    [3, 1], [3, 2], [3, 11], [3, 9],
    [4, 1], [4, 6], [4, 7], [4, 18],
    [5, 1], [5, 5], [5, 12], [5, 17]
];

$stmt2 = $mysqli->prepare("INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES (?, ?)");
if ($stmt2) {
    foreach ($seedReceta as $sr) {
        $stmt2->bind_param("ii", $sr[0], $sr[1]);
        $stmt2->execute();
    }
    $stmt2->close();
}

// Estadísticas finales
$resAC = $mysqli->query("SELECT COUNT(*) AS total FROM `alimentocomponentenutricional`");
$totalAC = $resAC ? $resAC->fetch_assoc()['total'] : 0;
outputLog("[INFO] Total en alimentocomponentenutricional: {$totalAC} registros.", $isCli);

$resRC = $mysqli->query("SELECT COUNT(*) AS total FROM `recetacomponentenutricional`");
$totalRC = $resRC ? $resRC->fetch_assoc()['total'] : 0;
outputLog("[INFO] Total en recetacomponentenutricional: {$totalRC} registros.", $isCli);

outputLog("==> Migración completada con éxito.", $isCli);
$mysqli->close();

if (!$isCli) {
    echo '<hr><p class="success">Migración finalizada con éxito.</p></div></body></html>';
}
