<?php
/**
 * Diagnóstico rápido del estado del sistema GIM360
 * Accede desde el navegador: http://tudominio/gim360/check.php
 */

header('Content-Type: text/html; charset=utf-8');

function badge($ok, $textOk = 'OK', $textFail = 'ERROR') {
    return $ok 
        ? "<span style='color:green;font-weight:bold;'>[✓ {$textOk}]</span>" 
        : "<span style='color:red;font-weight:bold;'>[✗ {$textFail}]</span>";
}

echo "<html><head><title>Diagnóstico GIM360</title><style>
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 20px; background: #f8fafc; color: #1e293b; }
.card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
h2 { margin-top: 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; }
pre { background: #0f172a; color: #f8fafc; padding: 15px; border-radius: 6px; overflow-x: auto; font-size: 13px; }
table { width: 100%; border-collapse: collapse; }
td, th { padding: 8px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
</style></head><body>";

echo "<h1>Diagnóstico de Instalación - GIM360</h1>";

// 1. PHP y Extensiones
echo "<div class='card'><h2>1. Entorno PHP</h2><table>";
echo "<tr><td>Versión de PHP</td><td>" . PHP_VERSION . " " . badge(version_compare(PHP_VERSION, '8.1', '>=')) . "</td></tr>";
$exts = ['mysqli', 'intl', 'mbstring', 'json', 'curl'];
foreach ($exts as $ext) {
    echo "<tr><td>Extensión '{$ext}'</td><td>" . badge(extension_loaded($ext), 'Instalada', 'Falta instalar') . "</td></tr>";
}
echo "</table></div>";

$projectDir = is_dir(__DIR__ . '/writable') ? __DIR__ : dirname(__DIR__);

// 2. Permisos de Writable
echo "<div class='card'><h2>2. Permisos de Escritura (writable)</h2><table>";
$paths = [
    'writable'          => $projectDir . '/writable',
    'writable/cache'    => $projectDir . '/writable/cache',
    'writable/logs'     => $projectDir . '/writable/logs',
    'writable/session'  => $projectDir . '/writable/session',
    'writable/debugbar' => $projectDir . '/writable/debugbar',
];
foreach ($paths as $name => $path) {
    $isDir = is_dir($path);
    $isWritable = is_writable($path);
    echo "<tr><td>{$name}</td><td>" . ($isDir ? badge($isWritable, 'Escribible', 'Sin permisos de escritura') : badge(false, '', 'No existe el directorio')) . "</td></tr>";
}
echo "</table>";
echo "<p><small>Si hay errores de permisos, ejecuta en el servidor: <code>chmod -R 777 writable/</code> o <code>chown -R apache:apache writable/</code></small></p>";
echo "</div>";

// 3. Base de Datos
echo "<div class='card'><h2>3. Conexión a Base de Datos</h2>";
// Intentar leer configuración
$envFile = $projectDir . '/.env';
$hasEnv = file_exists($envFile);
echo "<p>Archivo .env presente: " . badge($hasEnv, 'Sí', 'No (usando app/Config/Database.php)') . "</p>";

$host = 'localhost';
$user = 'root';
$pass = 'PIWIIB1234';
$db   = 'gim360';
$port = 3306;

if ($hasEnv) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $l) {
        $l = trim($l);
        if (preg_match('/^database\.default\.hostname\s*=\s*(.*)$/', $l, $m)) $host = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.username\s*=\s*(.*)$/', $l, $m)) $user = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.password\s*=\s*(.*)$/', $l, $m)) $pass = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.database\s*=\s*(.*)$/', $l, $m)) $db   = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.port\s*=\s*(.*)$/', $l, $m))     $port = (int)trim($m[1], " '\"");
    }
}

echo "<table>";
echo "<tr><td>Host</td><td>{$host}:{$port}</td></tr>";
echo "<tr><td>Usuario</td><td>{$user}</td></tr>";
echo "<tr><td>Base de Datos</td><td>{$db}</td></tr>";

$conn = @new mysqli($host, $user, $pass, null, $port);
if ($conn->connect_error) {
    echo "<tr><td>Conexión al servidor MySQL</td><td>" . badge(false, '', 'Falló: ' . $conn->connect_error) . "</td></tr>";
} else {
    echo "<tr><td>Conexión al servidor MySQL</td><td>" . badge(true, 'Conectado exitosamente') . "</td></tr>";
    
    // Probar seleccionar BD
    $dbSelected = $conn->select_db($db);
    if (!$dbSelected) {
        echo "<tr><td>Seleccionar base '{$db}'</td><td>" . badge(false, '', "No existe la base de datos '{$db}'.") . "</td></tr>";
    } else {
        // Ejecutar migración si se solicita
        if (isset($_GET['migrar']) || isset($_POST['migrar'])) {
            $migrationSql = "
CREATE TABLE IF NOT EXISTS `motivoentrenamiento` (
  `idmotivoentrenamiento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `objetivo` text DEFAULT NULL,
  PRIMARY KEY (`idmotivoentrenamiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE IF NOT EXISTS `rutinaejecicio` (
  `idrutinaejercicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idrutinaejercicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `rutinaejercicio` AS 
SELECT `idrutinaejercicio`, `nombre` FROM `rutinaejecicio`;

CREATE TABLE IF NOT EXISTS `planejercicio` (
  `idplanejercicio` int(11) NOT NULL AUTO_INCREMENT,
  `idejercicio` int(11) NOT NULL,
  `diassemanas` int(11) DEFAULT NULL,
  `repeticiones` int(11) DEFAULT NULL,
  `series` int(11) DEFAULT NULL,
  `tiempodescanso` int(11) DEFAULT NULL,
  `peso` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`idplanejercicio`),
  KEY `fk_pej_ejercicio` (`idejercicio`),
  CONSTRAINT `fk_pej_ejercicio` FOREIGN KEY (`idejercicio`) REFERENCES `ejercicio` (`idejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `PlanEjercicio` AS 
SELECT `idplanejercicio`, `idejercicio`, `diassemanas`, `repeticiones`, `series`, `tiempodescanso`, `peso` 
FROM `planejercicio`;

CREATE TABLE IF NOT EXISTS `programaentrenamiento` (
  `idprogramaentrenamiento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `idmotivoentrenamiento` int(11) NOT NULL,
  PRIMARY KEY (`idprogramaentrenamiento`),
  KEY `fk_pe_motivo` (`idmotivoentrenamiento`),
  CONSTRAINT `fk_pe_motivo` FOREIGN KEY (`idmotivoentrenamiento`) REFERENCES `motivoentrenamiento` (`idmotivoentrenamiento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

ALTER TABLE `programaentrenamiento` ADD COLUMN IF NOT EXISTS `nombre` VARCHAR(100) NOT NULL DEFAULT '' AFTER `idprogramaentrenamiento`;
ALTER TABLE `programaentrenamiento` DROP FOREIGN KEY IF EXISTS `fk_pe_planejercicio`;
ALTER TABLE `programaentrenamiento` DROP COLUMN IF EXISTS `idplanejercicio`;
ALTER TABLE `programaentrenamiento` DROP FOREIGN KEY IF EXISTS `fk_pe_rutina`;
ALTER TABLE `programaentrenamiento` DROP COLUMN IF EXISTS `idrutinaejercicio`;

CREATE OR REPLACE VIEW `ProgramaEntrenamiento` AS 
SELECT `idprogramaentrenamiento`, `nombre`, `idmotivoentrenamiento` 
FROM `programaentrenamiento`;

CREATE TABLE IF NOT EXISTS `rutinaprograma` (
  `idrutinaprograma` int(11) NOT NULL AUTO_INCREMENT,
  `idprogramaentrenamiento` int(11) NOT NULL,
  `idrutinaejercicio` int(11) NOT NULL,
  PRIMARY KEY (`idrutinaprograma`),
  KEY `fk_rprog_programa` (`idprogramaentrenamiento`),
  KEY `fk_rprog_rutina` (`idrutinaejercicio`),
  CONSTRAINT `fk_rprog_programa` FOREIGN KEY (`idprogramaentrenamiento`) REFERENCES `programaentrenamiento` (`idprogramaentrenamiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rprog_rutina` FOREIGN KEY (`idrutinaejercicio`) REFERENCES `rutinaejecicio` (`idrutinaejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `RutinaPrograma` AS 
SELECT `idrutinaprograma`, `idprogramaentrenamiento`, `idrutinaejercicio` 
FROM `rutinaprograma`;

INSERT IGNORE INTO `motivoentrenamiento` (`idmotivoentrenamiento`, `nombre`, `objetivo`) VALUES
(1, 'Hipertrofia Muscular', 'Aumento de masa muscular mediante sobrecarga progresiva y volumen de entrenamiento.'),
(2, 'Pérdida de Peso y Definición', 'Reducción del porcentaje graso manteniendo la masa muscular magra.'),
(3, 'Fuerza y Potencia Máxima', 'Desarrollo de fuerza neuromuscular y capacidad de levantamiento en rangos bajos de repetición.'),
(4, 'Salud y Acondicionamiento General', 'Mejora de la salud cardiovascular, resistencia física y movilidad articular diaria.'),
(5, 'Aumento de Resistencia Cardiovascular', 'Entrenamientos orientados a optimizar la capacidad aeróbica y resistencia general.');

INSERT IGNORE INTO `rutinaejecicio` (`idrutinaejercicio`, `nombre`) VALUES
(1, 'Full Body Principiante'),
(2, 'Tren Superior Hipertrofia'),
(3, 'Tren Inferior Potencia'),
(4, 'Cardio HIIT Quema Grasa'),
(5, 'Movilidad y Core Estabilidad');

INSERT IGNORE INTO `planejercicio` (`idplanejercicio`, `idejercicio`, `diassemanas`, `repeticiones`, `series`, `tiempodescanso`, `peso`) VALUES
(1, 1, 3, 12, 4, 90, 60.00),
(2, 2, 3, 10, 4, 120, 80.00),
(3, 4, 4, 12, 3, 60, 50.00),
(4, 5, 4, 15, 3, 60, 45.00),
(5, 9, 5, 20, 4, 45, 0.00),
(6, 8, 5, 20, 4, 45, 0.00),
(7, 3, 3, 5, 5, 180, 100.00),
(8, 1, 3, 5, 5, 180, 85.00),
(9, 10, 4, 15, 3, 60, 30.00),
(10, 11, 3, 12, 3, 60, 20.00);

INSERT IGNORE INTO `programaentrenamiento` (`idprogramaentrenamiento`, `nombre`, `idmotivoentrenamiento`) VALUES
(1, 'Hipertrofia Muscular - Full Body A', 1),
(2, 'Hipertrofia Muscular - Full Body B', 1),
(3, 'Hipertrofia Torso y Pierna A', 1),
(4, 'Hipertrofia Torso y Pierna B', 1),
(5, 'Definición y Quema Grasa - HIIT A', 2),
(6, 'Definición y Quema Grasa - HIIT B', 2),
(7, 'Fuerza y Potencia 5x5 Básico', 3),
(8, 'Fuerza y Potencia 5x5 Avanzado', 3),
(9, 'Acondicionamiento Físico - PPL Pro', 4),
(10, 'Rehabilitación y Movilidad Funcional', 5);

INSERT IGNORE INTO `rutinaprograma` (`idrutinaprograma`, `idprogramaentrenamiento`, `idrutinaejercicio`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 10, 1),
(4, 3, 2),
(5, 4, 2),
(6, 9, 3),
(7, 5, 4),
(8, 6, 4),
(9, 7, 5),
(10, 8, 5);

CREATE TABLE IF NOT EXISTS `rutinaplan` (
  `id_rutina_plan` int(11) NOT NULL AUTO_INCREMENT,
  `idrutinaejercicio` int(11) NOT NULL,
  `idplanejercicio` int(11) NOT NULL,
  PRIMARY KEY (`id_rutina_plan`),
  KEY `fk_rp_rutina` (`idrutinaejercicio`),
  KEY `fk_rp_plan` (`idplanejercicio`),
  CONSTRAINT `fk_rp_rutina` FOREIGN KEY (`idrutinaejercicio`) REFERENCES `rutinaejecicio` (`idrutinaejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rp_plan` FOREIGN KEY (`idplanejercicio`) REFERENCES `planejercicio` (`idplanejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `RutinaPlan` AS 
SELECT `id_rutina_plan`, `idrutinaejercicio`, `idplanejercicio` 
FROM `rutinaplan`;

INSERT IGNORE INTO `rutinaplan` (`id_rutina_plan`, `idrutinaejercicio`, `idplanejercicio`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 4),
(5, 4, 5),
(6, 4, 6),
(7, 5, 7),
(8, 5, 8),
(9, 3, 9),
(10, 1, 10);

CREATE TABLE IF NOT EXISTS `musculo` (
  `idmusculo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  PRIMARY KEY (`idmusculo`),
  UNIQUE KEY `uk_musculo_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Musculo` AS 
SELECT `idmusculo`, `nombre`, `imagen` 
FROM `musculo`;

INSERT IGNORE INTO `musculo` (`idmusculo`, `nombre`, `imagen`) VALUES
(1, 'Abductores', 'abductores.webp'),
(2, 'Aductores', 'aductores.webp'),
(3, 'Bíceps Braquial', 'biceps-braquial.webp'),
(4, 'Braquial', 'braquial.webp'),
(5, 'Braquiorradial', 'braquiorradial.webp'),
(6, 'Cuádriceps', 'cuadriceps.webp'),
(7, 'Deltoides Anterior', 'deltoides-anterior.webp'),
(8, 'Deltoides Lateral', 'deltoides-lateral.webp'),
(9, 'Deltoides Posterior', 'deltoides-posterior.webp'),
(10, 'Dorsal Ancho', 'dorsal-ancho.webp'),
(11, 'Erector Espinal', 'erector-espinal.webp'),
(12, 'Extensores del Antebrazo', 'extensores-del-antebrazo.webp'),
(13, 'Flexores de Cadera', 'flexores-de-cadera.webp'),
(14, 'Flexores del Antebrazo', 'flexores-del-antebrazo.webp'),
(15, 'Gastrocnemio (Gemelos)', 'gastrocnemio.webp'),
(16, 'Glúteo Mayor', 'gluteo-mayor.webp'),
(17, 'Glúteo Medio', 'gluteo-medio.webp'),
(18, 'Isquiotibiales', 'isquiotibiales.webp'),
(19, 'Oblicuos', 'oblicuos.webp'),
(20, 'Pectoral Mayor', 'pectoral-mayor.webp'),
(21, 'Recto Abdominal', 'recto-abdominal.webp'),
(22, 'Romboides', 'romboides.webp'),
(23, 'Serrato Anterior', 'serrato-anterior.webp'),
(24, 'Sóleo', 'soleo.webp'),
(25, 'Transverso Abdominal', 'transverso-abdominal.webp'),
(26, 'Trapecio', 'trapecio.webp'),
(27, 'Tríceps Braquial', 'triceps-braquial.webp');

CREATE TABLE IF NOT EXISTS `musculoejercicio` (
  `idmusculoejecicio` int(11) NOT NULL AUTO_INCREMENT,
  `idejercicio` int(11) NOT NULL,
  `idmusculo` int(11) NOT NULL,
  PRIMARY KEY (`idmusculoejecicio`),
  UNIQUE KEY `uk_ejercicio_musculo` (`idejercicio`, `idmusculo`),
  KEY `fk_me_ejercicio` (`idejercicio`),
  KEY `fk_me_musculo` (`idmusculo`),
  CONSTRAINT `fk_me_ejercicio` FOREIGN KEY (`idejercicio`) REFERENCES `ejercicio` (`idejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_me_musculo` FOREIGN KEY (`idmusculo`) REFERENCES `musculo` (`idmusculo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `MusculoEjercicio` AS 
SELECT `idmusculoejecicio`, `idejercicio`, `idmusculo` 
FROM `musculoejercicio`;

CREATE TABLE IF NOT EXISTS `estadoprogramacliente` (
  `idestadoprogramacliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idestadoprogramacliente`),
  UNIQUE KEY `uk_epc_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `EstadoProgramaCliente` AS 
SELECT `idestadoprogramacliente`, `nombre` 
FROM `estadoprogramacliente`;

INSERT IGNORE INTO `estadoprogramacliente` (`idestadoprogramacliente`, `nombre`) VALUES
(1, 'Activo'),
(2, 'En Espera'),
(3, 'Completado'),
(4, 'Pausado'),
(5, 'Cancelado');

CREATE TABLE IF NOT EXISTS `programacliente` (
  `idprogramacliente` int(11) NOT NULL AUTO_INCREMENT,
  `idprogramaentrenamiento` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `fechainicio` date NOT NULL,
  `idestadoprogramacliente` int(11) NOT NULL,
  PRIMARY KEY (`idprogramacliente`),
  KEY `fk_pc_programa` (`idprogramaentrenamiento`),
  KEY `fk_pc_cliente` (`idcliente`),
  KEY `fk_pc_estado` (`idestadoprogramacliente`),
  CONSTRAINT `fk_pc_programa` FOREIGN KEY (`idprogramaentrenamiento`) REFERENCES `programaentrenamiento` (`idprogramaentrenamiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pc_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pc_estado` FOREIGN KEY (`idestadoprogramacliente`) REFERENCES `estadoprogramacliente` (`idestadoprogramacliente`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `ProgramaCliente` AS 
SELECT `idprogramacliente`, `idprogramaentrenamiento`, `idcliente`, `fechainicio`, `idestadoprogramacliente` 
FROM `programacliente`;

INSERT IGNORE INTO `programacliente` (`idprogramacliente`, `idprogramaentrenamiento`, `idcliente`, `fechainicio`, `idestadoprogramacliente`) VALUES
(1, 1, 1, '2026-01-15', 1),
(2, 2, 1, '2026-02-01', 1),
(3, 3, 2, '2026-03-10', 1),
(4, 5, 6, '2026-04-05', 2);

ALTER TABLE `equipos` ADD COLUMN IF NOT EXISTS `imagen` VARCHAR(255) DEFAULT NULL AFTER `nombre`;

CREATE TABLE IF NOT EXISTS `ejercicioequipo` (
  `idejercicioequipo` int(11) NOT NULL AUTO_INCREMENT,
  `idejercicio` int(11) NOT NULL,
  `idequipo` int(11) NOT NULL,
  PRIMARY KEY (`idejercicioequipo`),
  UNIQUE KEY `uk_ejercicio_equipo` (`idejercicio`, `idequipo`),
  KEY `fk_ee_ejercicio` (`idejercicio`),
  KEY `fk_ee_equipo` (`idequipo`),
  CONSTRAINT `fk_ee_ejercicio` FOREIGN KEY (`idejercicio`) REFERENCES `ejercicio` (`idejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ee_equipo` FOREIGN KEY (`idequipo`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `EjercicioEquipo` AS 
SELECT `idejercicioequipo`, `idejercicio`, `idequipo` 
FROM `ejercicioequipo`;

INSERT IGNORE INTO `ejercicioequipo` (`idejercicioequipo`, `idejercicio`, `idequipo`) VALUES
(1, 1, 2),
(2, 1, 14),
(3, 2, 2),
(4, 3, 2),
(5, 4, 3),
(6, 4, 14),
(7, 5, 2),
(8, 6, 2),
(9, 7, 10),
(10, 8, 14),
(11, 9, 7),
(12, 10, 8),
(13, 11, 8),
(14, 12, 12),
(15, 13, 2),
(16, 14, 14),
(17, 15, 6);
";
            if ($conn->multi_query($migrationSql)) {
                do {
                    if ($resMulti = $conn->store_result()) {
                        $resMulti->free();
                    }
                } while ($conn->more_results() && $conn->next_result());
                echo "<div style='background:#dcfce7;border:1px solid #86efac;color:#166534;padding:12px;border-radius:6px;margin:15px 0;font-weight:bold;'>✓ ¡Tablas y registros creados exitosamente!</div>";
            } else {
                echo "<div style='background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px;border-radius:6px;margin:15px 0;'>✗ Error al crear tablas: " . htmlspecialchars($conn->error) . "</div>";
            }
        }

        $res = $conn->query("SHOW TABLES");
        $tableCount = $res ? $res->num_rows : 0;
        $existingTables = [];
        if ($res) {
            while ($row = $res->fetch_array()) {
                $existingTables[] = strtolower($row[0]);
            }
        }
        $requiredTables = ['motivoentrenamiento', 'rutinaejecicio', 'planejercicio', 'programaentrenamiento', 'rutinaprograma', 'rutinaplan', 'musculo', 'musculoejercicio', 'estadoprogramacliente', 'programacliente', 'ejercicioequipo'];
        $missingTables = array_diff($requiredTables, $existingTables);

        echo "<tr><td>Base de datos '{$db}'</td><td>" . badge($tableCount >= 16 && empty($missingTables), "OK ({$tableCount} tablas encontradas)", "Incompleta ({$tableCount} tablas encontradas)") . "</td></tr>";

        if (!empty($missingTables)) {
            echo "<tr><td colspan='2' style='background:#fef2f2;padding:15px;'>";
            echo "<p style='color:#b91c1c;margin:0 0 10px 0;font-weight:bold;'>⚠️ ¡Faltan las siguientes tablas requeridas: " . implode(', ', $missingTables) . "!</p>";
            echo "<p style='margin:0 0 12px 0;font-size:14px;color:#4b5563;'>Este es el motivo exacto del error <code>Whoops!</code> en la página de inicio de GIM360.</p>";
            echo "<a href='?migrar=1' style='background:#0284c7;color:#fff;text-decoration:none;padding:10px 18px;border-radius:6px;font-weight:bold;display:inline-block;'>⚡ Crear tablas faltantes ahora (1 Clic)</a>";
            echo "</td></tr>";
        } else {
            echo "<tr><td colspan='2' style='background:#f0fdf4;padding:12px;'>";
            echo "<span style='color:#166534;font-weight:bold;'>✓ Todas las tablas requeridas están presentes.</span> ";
            echo "<a href='./' style='background:#10b981;color:#fff;text-decoration:none;padding:6px 14px;border-radius:6px;font-weight:bold;margin-left:15px;display:inline-block;'>Ir a GIM360</a>";
            echo "</td></tr>";
        }
    }
    $conn->close();
}
echo "</table></div>";

// 4. Últimos Errores en Logs de CodeIgniter
echo "<div class='card'><h2>4. Últimos Registros de Error en CodeIgniter (writable/logs)</h2>";
$logDir = $projectDir . '/writable/logs';
$logFiles = glob($logDir . '/log-*.log');
if (empty($logFiles)) {
    echo "<p>No hay archivos de log generados aún en <code>writable/logs/</code>.</p>";
} else {
    // Tomar el más reciente
    rsort($logFiles);
    $latestLog = $logFiles[0];
    echo "<p>Archivo más reciente: <strong>" . basename($latestLog) . "</strong></p>";
    $content = file_get_contents($latestLog);
    $lines = explode("\n", trim($content));
    $lastLines = array_slice($lines, -30);
    echo "<pre>" . htmlspecialchars(implode("\n", $lastLines)) . "</pre>";
}
echo "</div>";

echo "</body></html>";
