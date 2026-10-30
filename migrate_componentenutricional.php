<?php
/**
 * Script de migración en la nube / local para Gim360:
 * Tabla componentenutricional y vista de compatibilidad.
 * 
 * Este script es 100% idempotente: no borra ni modifica datos existentes.
 * 
 * Uso por línea de comando (SSH/Terminal):
 *   php migrate_componentenutricional.php
 * 
 * Uso por navegador web:
 *   https://tudominio.com/migrate_componentenutricional.php
 */

// Intentar leer credenciales desde el archivo .env de CodeIgniter 4
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

// Permitir sobreescritura mediante variables de entorno o parámetros CLI/GET
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
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Migración Gim360: componentenutricional</title>';
    echo '<style>body{font-family:sans-serif;background:#f8f9fa;padding:30px;color:#333;} .box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);max-width:700px;margin:auto;} .success{color:#198754;font-weight:bold;} .error{color:#dc3545;font-weight:bold;} hr{margin:20px 0;border:0;border-top:1px solid #ddd;}</style>';
    echo '</head><body><div class="box"><h2>Migración Gim360: Componente Nutricional</h2><hr>';
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

// 1. Crear tabla si no existe
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS `componentenutricional` (
  `idcomponentenutricional` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`idcomponentenutricional`),
  UNIQUE KEY `uk_componentenutricional_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";

if ($mysqli->query($sqlCreateTable)) {
    outputMsg("[OK] Tabla 'componentenutricional' verificada / creada correctamente.", $isCli);
} else {
    outputMsg("[ERROR] Falló al crear la tabla: " . $mysqli->error, $isCli);
}

// 2. Crear vista de compatibilidad
$sqlCreateView = "CREATE OR REPLACE VIEW `ComponenteNutricional` AS
SELECT `idcomponentenutricional`, `nombre`, `descripcion`
FROM `componentenutricional`;";

if ($mysqli->query($sqlCreateView)) {
    outputMsg("[OK] Vista de compatibilidad 'ComponenteNutricional' verificada / creada.", $isCli);
} else {
    outputMsg("[ERROR] Falló al crear la vista: " . $mysqli->error, $isCli);
}

// 3. Insertar datos iniciales de forma segura (sin tocar ni alterar los existentes)
$initialData = [
    [1, 'Proteínas', 'Macronutriente fundamental para la síntesis de tejido muscular, recuperación y regeneración celular.'],
    [2, 'Carbohidratos Totales', 'Principal fuente de combustible energético del organismo y reserva de glucógeno muscular y hepático.'],
    [3, 'Grasas Totales (Lípidos)', 'Macronutriente esencial para la producción hormonal, absorción de vitaminas liposolubles y reserva de energía.'],
    [4, 'Grasas Saturadas', 'Ácidos grasos presentes en productos animales y aceites tropicales; su consumo debe ser moderado.'],
    [5, 'Grasas Monoinsaturadas', 'Grasas saludables presentes en aceite de oliva, aguacate y frutos secos que protegen la salud cardiovascular.'],
    [6, 'Grasas Poliinsaturadas', 'Ácidos grasos esenciales (como Omega-3 y Omega-6) requeridos para el control de inflamación y salud cerebral.'],
    [7, 'Fibra Dietética', 'Carbohidrato no digerible clave para el tránsito gastrointestinal, saciedad y control glucémico.'],
    [8, 'Azúcares', 'Carbohidratos simples de rápida asimilación; aportan energía inmediata.'],
    [9, 'Calorías / Valor Energético', 'Energía aportada por los nutrientes (expresada generalmente en kcal) requerida para las funciones basales y el entrenamiento.'],
    [10, 'Sodio', 'Electrolito esencial para el equilibrio osmótico, transmisión del impulso nervioso y contracción muscular.'],
    [11, 'Potasio', 'Electrolito que previene calambres, equilibra los niveles de líquidos y apoya la salud cardiovascular.'],
    [12, 'Calcio', 'Mineral indispensable para la densidad mineral ósea, contracción muscular y señalización celular.'],
    [13, 'Magnesio', 'Mineral involucrado en más de 300 reacciones enzimáticas, síntesis proteica, relajación muscular y descanso.'],
    [14, 'Hierro', 'Componente clave de la hemoglobina y mioglobina para el transporte de oxígeno a los tejidos musculares.'],
    [15, 'Zinc', 'Mineral cofactor de la inmunidad, síntesis de testosterona y cicatrización de tejidos.'],
    [16, 'Fósforo', 'Mineral esencial que participa en la formación ósea y en la molécula energética de ATP.'],
    [17, 'Vitamina C', 'Antioxidante hidrosoluble que estimula el sistema inmunológico y la producción de colágeno.'],
    [18, 'Vitamina D', 'Vitamina liposoluble y prohormona vital para la absorción de calcio, fuerza muscular y sistema inmunitario.'],
    [19, 'Vitamina B12', 'Crucial para la producción de glóbulos rojos, metabolismo energético y funcionamiento del sistema nervioso.'],
    [20, 'Creatina', 'Compuesto nitrogenado que eleva las reservas intramusculares de fosfocreatina para esfuerzos de alta intensidad.']
];

$stmt = $mysqli->prepare("INSERT IGNORE INTO `componentenutricional` (`idcomponentenutricional`, `nombre`, `descripcion`) VALUES (?, ?, ?)");
$inserted = 0;
foreach ($initialData as $row) {
    $stmt->bind_param("iss", $row[0], $row[1], $row[2]);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $inserted++;
    }
}
$stmt->close();

outputMsg("[OK] Se insertaron {$inserted} nuevos componentes base (los registros preexistentes no sufrieron alteraciones).", $isCli);

// Total de registros actuales
$resCount = $mysqli->query("SELECT COUNT(*) AS total FROM `componentenutricional`");
$total = ($resCount) ? $resCount->fetch_assoc()['total'] : 0;
outputMsg("[INFO] Total de componentes nutricionales en la base de datos: {$total}", $isCli);

outputMsg("==> Migración finalizada exitosamente.", $isCli);

$mysqli->close();

if (!$isCli) {
    echo '<hr><p class="success">Proceso completado. Ya puedes acceder al módulo en Gim360.</p></div></body></html>';
}
