-- Migración GIM360: Separación de Modelos y Personalizados
-- 1. Vistas / Tablas explícitas para programas modelo
CREATE OR REPLACE VIEW programaentrenamientomodelo AS 
SELECT idprogramaentrenamiento, nombre, idmotivoentrenamiento, idrangoedad FROM programaentrenamiento;

CREATE OR REPLACE VIEW rutinaejerciciomodelo AS 
SELECT idrutinaejercicio, nombre FROM rutinaejecicio;

CREATE OR REPLACE VIEW rutinaprogramamodelo AS 
SELECT idrutinaprograma, idprogramaentrenamiento, idrutinaejercicio FROM rutinaprograma;

CREATE OR REPLACE VIEW planejerciciomodelo AS 
SELECT idplanejercicio, nombre, idejercicio, diassemanas, repeticiones, series, tiempodescanso, peso FROM planejercicio;

CREATE OR REPLACE VIEW rutinaplanmodelo AS 
SELECT id_rutina_plan, idrutinaejercicio, idplanejercicio FROM rutinaplan;

-- 2. Tabla programa de entrenamiento personalizado
CREATE TABLE IF NOT EXISTS `programaentrenamientopersonalizado` (
  `idprogramapersonalizado` int(11) NOT NULL AUTO_INCREMENT,
  `idprogramaentrenamientomodelo` int(11) DEFAULT NULL,
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `idmotivoentrenamiento` int(11) NOT NULL,
  `idrangoedad` int(11) DEFAULT NULL,
  `fechacreacion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idprogramapersonalizado`),
  KEY `fk_pep_cliente` (`idcliente`),
  KEY `fk_pep_modelo` (`idprogramaentrenamientomodelo`),
  KEY `fk_pep_motivo` (`idmotivoentrenamiento`),
  KEY `fk_pep_rango` (`idrangoedad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- 3. Tabla rutina de ejercicio personalizada
CREATE TABLE IF NOT EXISTS `rutinaejerciciopersonalizado` (
  `idrutinapersonalizada` int(11) NOT NULL AUTO_INCREMENT,
  `idrutinaejerciciomodelo` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `fechacreacion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idrutinapersonalizada`),
  KEY `fk_rep_modelo` (`idrutinaejerciciomodelo`),
  KEY `fk_rep_cliente` (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- 4. Tabla pivote rutina - programa personalizado
CREATE TABLE IF NOT EXISTS `rutinaprogramapersonalizado` (
  `idrutinaprogramapersonalizado` int(11) NOT NULL AUTO_INCREMENT,
  `idprogramapersonalizado` int(11) NOT NULL,
  `idrutinapersonalizada` int(11) NOT NULL,
  PRIMARY KEY (`idrutinaprogramapersonalizado`),
  KEY `fk_rpp_prog` (`idprogramapersonalizado`),
  KEY `fk_rpp_rutina` (`idrutinapersonalizada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- 5. Tabla plan de ejercicio personalizado
CREATE TABLE IF NOT EXISTS `planejerciciopersonalizado` (
  `idplanpersonalizado` int(11) NOT NULL AUTO_INCREMENT,
  `idplanejerciciomodelo` int(11) DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `idejercicio` int(11) NOT NULL,
  `diassemanas` int(11) DEFAULT NULL,
  `repeticiones` int(11) DEFAULT NULL,
  `series` int(11) DEFAULT NULL,
  `tiempodescanso` int(11) DEFAULT NULL,
  `peso` decimal(8,2) DEFAULT 0.00,
  `fechainicio` date DEFAULT NULL,
  `duracionsemana` int(11) DEFAULT NULL,
  PRIMARY KEY (`idplanpersonalizado`),
  KEY `fk_pep_ejercicio` (`idejercicio`),
  KEY `fk_pep_planmodelo` (`idplanejerciciomodelo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- 6. Tabla pivote rutina - plan personalizado
CREATE TABLE IF NOT EXISTS `rutinaplanpersonalizado` (
  `idrutinaplanpersonalizado` int(11) NOT NULL AUTO_INCREMENT,
  `idrutinapersonalizada` int(11) NOT NULL,
  `idplanpersonalizado` int(11) NOT NULL,
  PRIMARY KEY (`idrutinaplanpersonalizado`),
  KEY `fk_rplp_rutina` (`idrutinapersonalizada`),
  KEY `fk_rplp_plan` (`idplanpersonalizado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- 7. Vistas alternativas para conveniencia
CREATE OR REPLACE VIEW programapersonalizado AS SELECT * FROM programaentrenamientopersonalizado;
CREATE OR REPLACE VIEW rutinaejerciciopersonalizada AS SELECT * FROM rutinaejerciciopersonalizado;
CREATE OR REPLACE VIEW rutinapersonalizada AS SELECT * FROM rutinaejerciciopersonalizado;
CREATE OR REPLACE VIEW planpersonalizado AS SELECT * FROM planejerciciopersonalizado;

-- 8. Agregar columna idprogramapersonalizado a programacliente
SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
                   WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'programacliente' AND COLUMN_NAME = 'idprogramapersonalizado');
SET @alter_sql = IF(@col_exists = 0, 'ALTER TABLE programacliente ADD COLUMN idprogramapersonalizado int(11) DEFAULT NULL AFTER idprogramaentrenamiento', 'SELECT 1');
PREPARE stmt FROM @alter_sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 9. Agregar fechainicio y duracionsemana a planejerciciopersonalizado si no existen
SET @col_fi_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
                      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'planejerciciopersonalizado' AND COLUMN_NAME = 'fechainicio');
SET @alter_sql_fi = IF(@col_fi_exists = 0, 'ALTER TABLE planejerciciopersonalizado ADD COLUMN fechainicio date DEFAULT NULL AFTER peso', 'SELECT 1');
PREPARE stmt_fi FROM @alter_sql_fi;
EXECUTE stmt_fi;
DEALLOCATE PREPARE stmt_fi;

SET @col_ds_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
                      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'planejerciciopersonalizado' AND COLUMN_NAME = 'duracionsemana');
SET @alter_sql_ds = IF(@col_ds_exists = 0, 'ALTER TABLE planejerciciopersonalizado ADD COLUMN duracionsemana int(11) DEFAULT NULL AFTER fechainicio', 'SELECT 1');
PREPARE stmt_ds FROM @alter_sql_ds;
EXECUTE stmt_ds;
DEALLOCATE PREPARE stmt_ds;

CREATE OR REPLACE VIEW planpersonalizado AS SELECT * FROM planejerciciopersonalizado;
