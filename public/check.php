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

mysqli_report(MYSQLI_REPORT_OFF);
try {
    $conn = @new mysqli($host, $user, $pass, null, $port);
} catch (\Throwable $e) {
    $conn = null;
}
if (!$conn || $conn->connect_error) {
    echo "<tr><td>Conexión al servidor MySQL</td><td>" . badge(false, '', 'Falló: ' . ($conn ? $conn->connect_error : 'Error de conexión')) . "</td></tr>";
} else {
    echo "<tr><td>Conexión al servidor MySQL</td><td>" . badge(true, 'Conectado exitosamente') . "</td></tr>";
    
    // Probar seleccionar BD
    $dbSelected = $conn->select_db($db);
    if (!$dbSelected) {
        echo "<tr><td>Seleccionar base '{$db}'</td><td>" . badge(false, '', "No existe la base de datos '{$db}'.") . "</td></tr>";
    } else {
        // Ejecutar migración si se solicita
        if (isset($_GET['migrar']) || isset($_POST['migrar'])) {
            try {
                // Migración preventiva de renombramiento de tablas y columnas
                @$conn->query("ALTER TABLE `ejercicioequipo` DROP FOREIGN KEY `fk_ee_equipo`");
            } catch (\Throwable $ignored) {}
            try {
                $resEquipos = $conn->query("SHOW TABLES LIKE 'equipos'");
                $resEquipo = $conn->query("SHOW TABLES LIKE 'equipo'");
                if ($resEquipos && $resEquipos->num_rows > 0 && (!$resEquipo || $resEquipo->num_rows == 0)) {
                    @$conn->query("ALTER TABLE `equipos` CHANGE COLUMN `id_equipo` `idequipo` INT(11) NOT NULL AUTO_INCREMENT");
                    @$conn->query("RENAME TABLE `equipos` TO `equipo`");
                }
                @$conn->query("ALTER TABLE `equipo` CHANGE COLUMN `id_equipo` `idequipo` INT(11) NOT NULL AUTO_INCREMENT");
                @$conn->query("ALTER TABLE `equipo` ADD COLUMN IF NOT EXISTS `iddisponibilidadequipo` INT(11) DEFAULT 1 AFTER `id_estado`");
            } catch (\Throwable $ignored) {}

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

ALTER TABLE `equipo` ADD COLUMN IF NOT EXISTS `imagen` VARCHAR(255) DEFAULT NULL AFTER `nombre`;

CREATE TABLE IF NOT EXISTS `ejercicioequipo` (
  `idejercicioequipo` int(11) NOT NULL AUTO_INCREMENT,
  `idejercicio` int(11) NOT NULL,
  `idequipo` int(11) NOT NULL,
  PRIMARY KEY (`idejercicioequipo`),
  UNIQUE KEY `uk_ejercicio_equipo` (`idejercicio`, `idequipo`),
  KEY `fk_ee_ejercicio` (`idejercicio`),
  KEY `fk_ee_equipo` (`idequipo`),
  CONSTRAINT `fk_ee_ejercicio` FOREIGN KEY (`idejercicio`) REFERENCES `ejercicio` (`idejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ee_equipo` FOREIGN KEY (`idequipo`) REFERENCES `equipo` (`idequipo`) ON DELETE CASCADE ON UPDATE CASCADE
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

CREATE TABLE IF NOT EXISTS `disponibilidadequipo` (
  `iddisponibilidadequipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`iddisponibilidadequipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

INSERT IGNORE INTO `disponibilidadequipo` (`iddisponibilidadequipo`, `nombre`) VALUES
(1, 'Disponible'),
(2, 'En Uso'),
(3, 'En Mantenimiento'),
(4, 'En Reparación'),
(5, 'Fuera de Servicio'),
(6, 'Reservado');

ALTER TABLE `equipo` ADD COLUMN IF NOT EXISTS `iddisponibilidadequipo` INT(11) DEFAULT 1 AFTER `id_estado`;

CREATE TABLE IF NOT EXISTS `equipomusculo` (
  `idequipomusculo` int(11) NOT NULL AUTO_INCREMENT,
  `idequipo` int(11) NOT NULL,
  `idmusculo` int(11) NOT NULL,
  PRIMARY KEY (`idequipomusculo`),
  UNIQUE KEY `uk_equipo_musculo` (`idequipo`, `idmusculo`),
  KEY `fk_em_equipo` (`idequipo`),
  KEY `fk_em_musculo` (`idmusculo`),
  CONSTRAINT `fk_em_equipo` FOREIGN KEY (`idequipo`) REFERENCES `equipo` (`idequipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_em_musculo` FOREIGN KEY (`idmusculo`) REFERENCES `musculo` (`idmusculo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE IF NOT EXISTS `rangoedad` (
  `idrangoedad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `edadminima` int(11) NOT NULL,
  `edadmaxima` int(11) NOT NULL,
  PRIMARY KEY (`idrangoedad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE IF NOT EXISTS `ejecucionprograma` (
  `idejecucionprograma` int(11) NOT NULL AUTO_INCREMENT,
  `idprogramacliente` int(11) NOT NULL,
  `idejercicio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `horainicio` time NOT NULL,
  `horafin` time DEFAULT NULL,
  PRIMARY KEY (`idejecucionprograma`),
  KEY `idx_ejecucionprograma_pc` (`idprogramacliente`),
  KEY `idx_ejecucionprograma_ejercicio` (`idejercicio`),
  KEY `idx_ejecucionprograma_fecha` (`fecha`),
  CONSTRAINT `fk_ep_programacliente` FOREIGN KEY (`idprogramacliente`) REFERENCES `programacliente` (`idprogramacliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ep_ejercicio` FOREIGN KEY (`idejercicio`) REFERENCES `ejercicio` (`idejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

ALTER TABLE `equipo` ADD COLUMN IF NOT EXISTS `video` VARCHAR(300) DEFAULT NULL AFTER `imagen`;

CREATE TABLE IF NOT EXISTS `trenmuscular` (
  `idtrenmuscular` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idtrenmuscular`),
  UNIQUE KEY `uk_trenmuscular_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

INSERT IGNORE INTO `trenmuscular` (`idtrenmuscular`, `nombre`) VALUES
(1, 'Tren Superior'),
(2, 'Tren Inferior'),
(3, 'Core / Tronco'),
(4, 'Cuerpo Completo');

ALTER TABLE `programaentrenamiento` ADD COLUMN IF NOT EXISTS `idtrenmuscular` int(11) NULL DEFAULT NULL AFTER `idrangoedad`;
ALTER TABLE `ejercicio` ADD COLUMN IF NOT EXISTS `idtrenmuscular` int(11) NULL DEFAULT NULL AFTER `imagen`;
ALTER TABLE `musculo` ADD COLUMN IF NOT EXISTS `idtrenmuscular` int(11) NULL DEFAULT NULL AFTER `imagen`;

UPDATE `musculo` SET `idtrenmuscular` = 1 
WHERE `nombre` IN (
    'Bíceps Braquial', 'Braquial', 'Braquiorradial', 
    'Deltoides Anterior', 'Deltoides Lateral', 'Deltoides Posterior', 
    'Dorsal Ancho', 'Extensores del Antebrazo', 'Flexores del Antebrazo', 
    'Pectoral Mayor', 'Romboides', 'Serrato Anterior', 
    'Trapecio', 'Tríceps Braquial'
) AND `idtrenmuscular` IS NULL;

UPDATE `musculo` SET `idtrenmuscular` = 2 
WHERE `nombre` IN (
    'Abductores', 'Aductores', 'Cuádriceps', 
    'Flexores de Cadera', 'Gastrocnemio (Gemelos)', 'Glúteo Mayor', 
    'Glúteo Medio', 'Isquiotibiales', 'Sóleo'
) AND `idtrenmuscular` IS NULL;

UPDATE `musculo` SET `idtrenmuscular` = 3 
WHERE `nombre` IN (
    'Erector Espinal', 'Oblicuos', 'Recto Abdominal', 'Transverso Abdominal'
) AND `idtrenmuscular` IS NULL;

CREATE OR REPLACE VIEW `TrenMuscular` AS 
SELECT `idtrenmuscular`, `nombre` FROM `trenmuscular`;

CREATE OR REPLACE VIEW `Musculo` AS 
SELECT `idmusculo`, `nombre`, `imagen`, `idtrenmuscular` FROM `musculo`;

CREATE OR REPLACE VIEW `ProgramaEntrenamiento` AS 
SELECT `idprogramaentrenamiento`, `nombre`, `idmotivoentrenamiento`, `idrangoedad`, `idtrenmuscular` 
FROM `programaentrenamiento`;

CREATE TABLE IF NOT EXISTS `perfilnutricional` (
  `idperfilnutricional` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  `peso_kg` decimal(5,2) NOT NULL,
  `estatura_cm` decimal(5,2) NOT NULL,
  `fechamedicion` date DEFAULT (CURRENT_DATE),
  `porcentajegrasa` decimal(4,1) DEFAULT NULL,
  `porcentajemusculo` decimal(4,1) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`idperfilnutricional`),
  KEY `fk_pn_persona` (`idpersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `PerfilNutricional` AS
SELECT `idperfilnutricional`, `idpersona`, `peso_kg`, `estatura_cm`, `fechamedicion`, `porcentajegrasa`, `porcentajemusculo`, `observaciones`
FROM `perfilnutricional`;

CREATE TABLE IF NOT EXISTS `grupoalimento` (
  `idgrupoalimento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`idgrupoalimento`),
  UNIQUE KEY `uk_grupoalimento_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `GrupoAlimento` AS
SELECT `idgrupoalimento`, `nombre`, `descripcion`
FROM `grupoalimento`;

INSERT IGNORE INTO `grupoalimento` (`idgrupoalimento`, `nombre`, `descripcion`) VALUES
(1, 'Proteínas (Carnes, Pescados y Huevos)', 'Alimentos con alto valor biológico fundamentales para el desarrollo, recuperación y mantenimiento de la masa muscular.'),
(2, 'Lácteos y Derivados', 'Leche, quesos, yogur y derivados ricos en calcio, proteínas de lenta y rápida asimilación (caseína y suero) y vitamina D.'),
(3, 'Cereales, Granos y Tubérculos', 'Avena, arroz, quinua, pasta, papas y camote. Fuentes principales de carbohidratos complejos y energía para el entrenamiento.'),
(4, 'Legumbres y Semillas', 'Lentejas, garbanzos, frijoles, chía y lino. Aportan fibra, carbohidratos de bajo índice glucémico y proteínas vegetales.'),
(5, 'Frutas', 'Plátano, manzana, frutos rojos, cítricos. Ricas en vitaminas, minerales, antioxidantes y fructosa para recarga de glucógeno.'),
(6, 'Verduras y Hortalizas', 'Espinacas, brócoli, zanahorias, lechuga. Aporte esencial de micronutrientes, fitonutrientes, fibra y baja densidad calórica.'),
(7, 'Grasas Saludables y Aceites', 'Aceite de oliva virgen extra, frutos secos, aguacate. Esenciales para la función hormonal, absorción de vitaminas y salud cardiovascular.'),
(8, 'Suplementos y Complementos Dietéticos', 'Proteína de suero (whey), creatina, multivitaminas, BCAAs y aminoácidos esenciales para optimización del rendimiento atlético.');

CREATE TABLE IF NOT EXISTS `alimento` (
  `idalimento` int(11) NOT NULL AUTO_INCREMENT,
  `idgrupo` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`idalimento`),
  KEY `fk_alimento_grupo` (`idgrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Alimento` AS
SELECT `idalimento`, `idgrupo`, `nombre`, `descripcion`
FROM `alimento`;

INSERT IGNORE INTO `alimento` (`idalimento`, `idgrupo`, `nombre`, `descripcion`) VALUES
(1, 1, 'Pechuga de Pollo', 'Excelente fuente de proteína magra de alto valor biológico con bajo contenido de grasa.'),
(2, 1, 'Huevos Enteros y Claras', 'Proteína de referencia biológica rica en albúmina, colina, vitaminas B12 y minerales.'),
(3, 1, 'Atún al Natural', 'Pescado magro con alto contenido proteico y aporte de ácidos grasos omega-3.'),
(4, 1, 'Lomo de Ternera Magra', 'Carne roja magra con alto contenido de hierro hemo, zinc, creatina natural y vitaminas B.'),
(5, 3, 'Avena en Hojuelas', 'Carbohidrato complejo de absorción lenta rico en fibra soluble (betaglucanos) y micronutrientes.'),
(6, 3, 'Arroz Integral / Jazmín', 'Fuente energética limpia y de fácil digestión para recarga de glucógeno muscular.'),
(7, 3, 'Quinoa', 'Pseudocereal con aminoácidos completos, fibra y minerales para deportistas.'),
(8, 3, 'Batata / Camote', 'Carbohidrato con bajo índice glucémico rico en provitamina A y potasio.'),
(9, 7, 'Aceite de Oliva Virgen Extra', 'Ácidos grasos monoinsaturados saludables, antiinflamatorio natural para articulaciones.'),
(10, 7, 'Aguacate', 'Grasas monoinsaturadas, fibra y potasio para soporte cardiovascular y hormonal.'),
(11, 7, 'Nueces y Almendras', 'Frutos secos con magnesio, vitamina E, grasas poliinsaturadas y saciedad.'),
(12, 6, 'Brócoli al Vapor', 'Rico en sulforafano, vitamina C, folatos y antioxidantes para control estrogénico.'),
(13, 6, 'Espinacas Frescas', 'Hojas verdes ricas en nitratos naturales, magnesio, hierro y fibra.'),
(14, 6, 'Zanahorias', 'Ricas en betacarotenos y antioxidantes para recuperación celular.'),
(15, 5, 'Plátano / Banana', 'Fruta rica en carbohidratos de absorción rápida y potasio, ideal pre/post entreno.'),
(16, 5, 'Manzana Verde', 'Bajo índice glucémico, rica en pectina para digestión y saciedad.'),
(17, 5, 'Arándanos y Frutos Rojos', 'Potentes antioxidantes que combaten el daño oxidativo del entrenamiento intenso.'),
(18, 2, 'Leche Descremada / Bebida de Almendras', 'Aporte líquido de proteínas o alternativa baja en calorías para batidos.'),
(19, 2, 'Yogur Griego Natural (0% Grasa)', 'Alto en caseína y probióticos para síntesis proteica nocturna y salud intestinal.'),
(20, 2, 'Queso Cottage Bajo en Grasa', 'Proteína de digestión lenta ideal para antes de dormir o snacks saciantes.'),
(21, 4, 'Lentejas Cocidas', 'Legumbre con proteínas vegetales, hierro y fibra prebiótica.'),
(22, 8, 'Proteína Whey Aislada (Isolate)', 'Suplemento proteico ultra rápido de alta pureza para ventana anabólica post-entreno.'),
(23, 8, 'Creatina Monohidrato', 'Incrementa reservas de fosfocreatina muscular, mejorando fuerza explosiva e hidratación.');

CREATE TABLE IF NOT EXISTS `unidadalimento` (
  `idunidadalimento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `abreviatura` varchar(15) NOT NULL,
  PRIMARY KEY (`idunidadalimento`),
  UNIQUE KEY `uq_unidad_nombre` (`nombre`),
  UNIQUE KEY `uq_unidad_abrev` (`abreviatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `UnidadAlimento` AS
SELECT `idunidadalimento`, `nombre`, `abreviatura`
FROM `unidadalimento`;

INSERT IGNORE INTO `unidadalimento` (`idunidadalimento`, `nombre`, `abreviatura`) VALUES
(1, 'Gramo', 'g'),
(2, 'Kilogramo', 'kg'),
(3, 'Mililitro', 'ml'),
(4, 'Litro', 'l'),
(5, 'Cucharada', 'cda'),
(6, 'Cucharadita', 'cdta'),
(7, 'Taza', 'tz'),
(8, 'Unidad / Pieza', 'unid'),
(9, 'Medida / Scoop', 'scoop'),
(10, 'Rebanada / Rodaja', 'reb'),
(11, 'Onza', 'oz');

CREATE TABLE IF NOT EXISTS `receta` (
  `idreceta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `instrucciones` text DEFAULT NULL,
  `porciones` int(11) DEFAULT 1,
  `tiempopreparacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idreceta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Receta` AS
SELECT `idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`
FROM `receta`;

INSERT IGNORE INTO `receta` (`idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`) VALUES
(1, 'Tortilla de Avena y Claras de Huevo', '1. Batir 4 claras de huevo con 1 yema.\n2. Incorporar 40g de avena en hojuelas y una pizca de canela al gusto.\n3. Calentar una sartén antiadherente con 2 gotas de aceite de oliva virgen.\n4. Verter la mezcla y cocinar a fuego medio durante 3 minutos por cada lado hasta dorar.', 1, 10),
(2, 'Bowl de Pollo a la Plancha con Quinoa y Aguacate', '1. Cocinar 100g de quinoa en agua con sal durante 15 minutos y escurrir.\n2. Sazonar 250g de pechuga de pollo con ajo, orégano, sal y pimienta.\n3. Cocinar el pollo a la plancha durante 5-6 minutos por lado a fuego medio-alto.\n4. Cortar en tiras y servir sobre la quinoa templada con rodajas de aguacate fresco y hojas de espinaca.', 2, 25),
(3, 'Batido Proteico Post-Entreno de Plátano y Avena', '1. Colocar en el vaso de la licuadora 250ml de leche desnatada o bebida vegetal de almendras.\n2. Agregar 1 plátano maduro cortado en rodajas, 35g de avena en copos y 1 medida (scoop) de proteína de suero.\n3. Añadir 3 cubos de hielo y licuar a máxima potencia durante 60 segundos hasta lograr una textura suave y homogénea.', 1, 5),
(4, 'Salmón al Horno con Espárragos y Batata Asada', '1. Precalentar el horno a 200°C.\n2. Lavar y cortar la batata en rodajas finas y distribuirlas en una bandeja con papel vegetal junto con los espárragos trigueros.\n3. Rociar con una cucharadita de aceite de oliva, sal marina y romero.\n4. Hornear durante 15 minutos, luego incorporar los lomos de salmón salpimentados y cocinar 12 a 15 minutos adicionales hasta que el pescado esté jugoso.', 2, 35),
(5, 'Yogur Griego con Nueces y Arándanos', 'Servir 150g de yogur griego natural, agregar un puñado de arándanos frescos y nueces picadas con un toque de miel pura.', 1, 5);

CREATE TABLE IF NOT EXISTS `alimentoreceta` (
  `idalimentoreceta` int(11) NOT NULL AUTO_INCREMENT,
  `idreceta` int(11) NOT NULL,
  `idalimento` int(11) NOT NULL,
  `cantidad` decimal(8,2) NOT NULL,
  `idunidadalimento` int(11) NOT NULL,
  PRIMARY KEY (`idalimentoreceta`),
  KEY `fk_ar_receta` (`idreceta`),
  KEY `fk_ar_alimento` (`idalimento`),
  KEY `fk_ar_unidad` (`idunidadalimento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `AlimentoReceta` AS
SELECT `idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`
FROM `alimentoreceta`;

INSERT IGNORE INTO `alimentoreceta` (`idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`) VALUES
(1, 1, 2, 4.00, 8),
(2, 1, 5, 40.00, 1),
(3, 1, 9, 5.00, 3),
(4, 2, 1, 250.00, 1),
(5, 2, 7, 100.00, 1),
(6, 2, 10, 1.00, 8),
(7, 2, 13, 50.00, 1),
(8, 3, 18, 250.00, 3),
(9, 3, 15, 1.00, 8),
(10, 3, 5, 35.00, 1),
(11, 3, 22, 1.00, 9);

CREATE TABLE IF NOT EXISTS `tipocomida` (
  `idtipocomida` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  PRIMARY KEY (`idtipocomida`),
  UNIQUE KEY `uq_tipocomida_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `TipoComida` AS
SELECT `idtipocomida`, `nombre`
FROM `tipocomida`;

INSERT IGNORE INTO `tipocomida` (`idtipocomida`, `nombre`) VALUES
(1, 'Desayuno'),
(2, 'Media Mañana (Snack 1)'),
(3, 'Almuerzo'),
(4, 'Merienda (Snack 2)'),
(5, 'Pre-Entrenamiento'),
(6, 'Post-Entrenamiento'),
(7, 'Cena'),
(8, 'Colación Nocturna'),
(9, 'Snack General');

CREATE TABLE IF NOT EXISTS `diasemana` (
  `iddiasemana` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`iddiasemana`),
  UNIQUE KEY `uq_diasemana_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `DiaSemana` AS
SELECT `iddiasemana`, `nombre`
FROM `diasemana`;

INSERT IGNORE INTO `diasemana` (`iddiasemana`, `nombre`) VALUES
(1, 'Lunes'),
(2, 'Martes'),
(3, 'Miércoles'),
(4, 'Jueves'),
(5, 'Viernes'),
(6, 'Sábado'),
(7, 'Domingo');

CREATE TABLE IF NOT EXISTS `planalimentacion` (
  `idplanalimentacion` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `fechainicio` date NOT NULL,
  `fechafin` date DEFAULT NULL,
  `objetivo` text DEFAULT NULL,
  PRIMARY KEY (`idplanalimentacion`),
  KEY `fk_planalimentacion_persona` (`idpersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `PlanAlimentacion` AS
SELECT `idplanalimentacion`, `idpersona`, `nombre`, `fechainicio`, `fechafin`, `objetivo`
FROM `planalimentacion`;

CREATE TABLE IF NOT EXISTS `comida` (
  `idcomida` int(11) NOT NULL AUTO_INCREMENT,
  `idplanalimentacion` int(11) NOT NULL,
  `idtipocomida` int(11) NOT NULL,
  `idreceta` int(11) NOT NULL,
  `horarecomendada` time DEFAULT NULL,
  PRIMARY KEY (`idcomida`),
  KEY `fk_comida_plan` (`idplanalimentacion`),
  KEY `fk_comida_tipo` (`idtipocomida`),
  KEY `fk_comida_receta` (`idreceta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Comida` AS
SELECT `idcomida`, `idplanalimentacion`, `idtipocomida`, `idreceta`, `horarecomendada`
FROM `comida`;

CREATE TABLE IF NOT EXISTS `formatoimagen` (
  `idformatoimagen` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idformatoimagen`),
  UNIQUE KEY `uk_formatoimagen_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `FormatoImagen` AS
SELECT `idformatoimagen`, `nombre` FROM `formatoimagen`;

INSERT IGNORE INTO `formatoimagen` (`idformatoimagen`, `nombre`) VALUES
(1, 'jpg'), (2, 'png'), (3, 'webp'), (4, 'gif'), (5, 'jpeg');

CREATE TABLE IF NOT EXISTS `ordenador` (
  `idordenador` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idordenador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Ordenador` AS
SELECT `idordenador`, `nombre` FROM `ordenador`;

INSERT IGNORE INTO `ordenador` (`idordenador`, `nombre`) VALUES
(1, 'Servidor Local gim360');

CREATE TABLE IF NOT EXISTS `directorio` (
  `iddirectorio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `ruta` varchar(200) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `idordenador` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`iddirectorio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Directorio` AS
SELECT `iddirectorio`, `nombre`, `ruta`, `descripcion`, `idordenador` FROM `directorio`;

INSERT IGNORE INTO `directorio` (`iddirectorio`, `nombre`, `ruta`, `descripcion`, `idordenador`) VALUES
(1, 'Imagenes Gim360', 'repositorio/imagen', 'Directorio de almacenamiento de imágenes', 1);

CREATE TABLE IF NOT EXISTS `imagen` (
  `idimagen` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `idformatoimagen` int(11) DEFAULT NULL,
  `fechacaptura` datetime DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `palabrasclave` text DEFAULT NULL,
  `licencia` varchar(50) DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `idordenador` int(11) DEFAULT 1,
  `iddirectorio` int(11) DEFAULT 1,
  PRIMARY KEY (`idimagen`),
  KEY `idx_imagen_formato` (`idformatoimagen`),
  KEY `idx_imagen_ordenador` (`idordenador`),
  KEY `idx_imagen_directorio` (`iddirectorio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Imagen` AS
SELECT `idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, 
       `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio`
FROM `imagen`;
";
            try {
                if ($conn->multi_query($migrationSql)) {
                    do {
                        if ($resMulti = $conn->store_result()) {
                            $resMulti->free();
                        }
                    } while ($conn->more_results() && $conn->next_result());
                    echo "<div style='background:#dcfce7;border:1px solid #86efac;color:#166534;padding:12px;border-radius:6px;margin:15px 0;font-weight:bold;'>✓ ¡Tablas y registros creados/actualizados exitosamente!</div>";
                } else {
                    echo "<div style='background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px;border-radius:6px;margin:15px 0;'>✗ Error al procesar migración: " . htmlspecialchars($conn->error) . "</div>";
                }
            } catch (\Throwable $e) {
                echo "<div style='background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px;border-radius:6px;margin:15px 0;'>✗ Excepción en migración: " . htmlspecialchars($e->getMessage()) . "</div>";
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
        $requiredTables = [
            'motivoentrenamiento', 'rutinaejecicio', 'planejercicio', 'programaentrenamiento', 
            'rutinaprograma', 'rutinaplan', 'musculo', 'musculoejercicio', 
            'estadoprogramacliente', 'programacliente', 'ejercicioequipo', 'equipomusculo', 
            'disponibilidadequipo', 'rangoedad', 'ejecucionprograma',
            'trenmuscular', 'perfilnutricional', 'grupoalimento', 'alimento',
            'unidadalimento', 'receta', 'alimentoreceta', 'tipocomida', 'diasemana',
            'planalimentacion', 'comida', 'componentenutricional', 'imagen', 'formatoimagen', 'ordenador', 'directorio'
        ];
        $missingTables = array_diff($requiredTables, $existingTables);

        echo "<tr><td>Base de datos '{$db}'</td><td>" . badge($tableCount >= 20 && empty($missingTables), "OK ({$tableCount} tablas/vistas encontradas)", "Incompleta ({$tableCount} tablas/vistas encontradas)") . "</td></tr>";

        if (!empty($missingTables)) {
            echo "<tr><td colspan='2' style='background:#fef2f2;padding:15px;'>";
            echo "<p style='color:#b91c1c;margin:0 0 10px 0;font-weight:bold;'>⚠️ ¡Faltan las siguientes tablas requeridas: " . implode(', ', $missingTables) . "!</p>";
            echo "<p style='margin:0 0 12px 0;font-size:14px;color:#4b5563;'>Presiona el botón a continuación para crearlas automáticamente:</p>";
            echo "<a href='?migrar=1' style='background:#0284c7;color:#fff;text-decoration:none;padding:10px 18px;border-radius:6px;font-weight:bold;display:inline-block;'>⚡ Crear tablas faltantes ahora (1 Clic)</a>";
            echo "</td></tr>";
        } else {
            echo "<tr><td colspan='2' style='background:#f0fdf4;padding:12px;'>";
            echo "<span style='color:#166534;font-weight:bold;'>✓ Todas las tablas requeridas están presentes.</span> ";
            echo "<a href='?migrar=1' style='background:#0284c7;color:#fff;text-decoration:none;padding:6px 14px;border-radius:6px;font-weight:bold;margin-left:15px;display:inline-block;'>⚡ Sincronizar / Migrar BD</a>";
            echo "<a href='./' style='background:#10b981;color:#fff;text-decoration:none;padding:6px 14px;border-radius:6px;font-weight:bold;margin-left:10px;display:inline-block;'>Ir a GIM360</a>";
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
