-- ==============================================================================
-- Migración: Tabla trenmuscular y campo idtrenmuscular en tablas asociadas
-- ==============================================================================

-- 1. Crear tabla trenmuscular
CREATE TABLE IF NOT EXISTS `trenmuscular` (
  `idtrenmuscular` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idtrenmuscular`),
  UNIQUE KEY `uk_trenmuscular_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- 2. Insertar registros por defecto
INSERT IGNORE INTO `trenmuscular` (`idtrenmuscular`, `nombre`) VALUES
(1, 'Tren Superior'),
(2, 'Tren Inferior'),
(3, 'Core / Tronco'),
(4, 'Cuerpo Completo');

-- 3. Agregar campo idtrenmuscular en programaentrenamiento
SET @col_exists = (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'programaentrenamiento' AND column_name = 'idtrenmuscular');
SET @sql = IF(@col_exists = 0, 'ALTER TABLE `programaentrenamiento` ADD COLUMN `idtrenmuscular` int(11) NULL DEFAULT NULL AFTER `idrangoedad`', 'SELECT 1');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Clave foránea en programaentrenamiento
SET @fk_exists = (SELECT COUNT(*) FROM information_schema.table_constraints WHERE table_schema = DATABASE() AND table_name = 'programaentrenamiento' AND constraint_name = 'fk_pe_trenmuscular');
SET @sql = IF(@fk_exists = 0, 'ALTER TABLE `programaentrenamiento` ADD CONSTRAINT `fk_pe_trenmuscular` FOREIGN KEY (`idtrenmuscular`) REFERENCES `trenmuscular` (`idtrenmuscular`) ON DELETE SET NULL ON UPDATE CASCADE', 'SELECT 1');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 4. Agregar campo idtrenmuscular en ejercicio
SET @col_exists = (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'ejercicio' AND column_name = 'idtrenmuscular');
SET @sql = IF(@col_exists = 0, 'ALTER TABLE `ejercicio` ADD COLUMN `idtrenmuscular` int(11) NULL DEFAULT NULL AFTER `imagen`', 'SELECT 1');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Clave foránea en ejercicio
SET @fk_exists = (SELECT COUNT(*) FROM information_schema.table_constraints WHERE table_schema = DATABASE() AND table_name = 'ejercicio' AND constraint_name = 'fk_ejercicio_trenmuscular');
SET @sql = IF(@fk_exists = 0, 'ALTER TABLE `ejercicio` ADD CONSTRAINT `fk_ejercicio_trenmuscular` FOREIGN KEY (`idtrenmuscular`) REFERENCES `trenmuscular` (`idtrenmuscular`) ON DELETE SET NULL ON UPDATE CASCADE', 'SELECT 1');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 5. Agregar campo idtrenmuscular en musculo
SET @col_exists = (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'musculo' AND column_name = 'idtrenmuscular');
SET @sql = IF(@col_exists = 0, 'ALTER TABLE `musculo` ADD COLUMN `idtrenmuscular` int(11) NULL DEFAULT NULL AFTER `imagen`', 'SELECT 1');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Clave foránea en musculo
SET @fk_exists = (SELECT COUNT(*) FROM information_schema.table_constraints WHERE table_schema = DATABASE() AND table_name = 'musculo' AND constraint_name = 'fk_musculo_trenmuscular');
SET @sql = IF(@fk_exists = 0, 'ALTER TABLE `musculo` ADD CONSTRAINT `fk_musculo_trenmuscular` FOREIGN KEY (`idtrenmuscular`) REFERENCES `trenmuscular` (`idtrenmuscular`) ON DELETE SET NULL ON UPDATE CASCADE', 'SELECT 1');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 6. Clasificar músculos existentes según su tren muscular
-- Tren Superior (id = 1)
UPDATE `musculo` SET `idtrenmuscular` = 1 
WHERE `nombre` IN (
    'Bíceps Braquial', 'Braquial', 'Braquiorradial', 
    'Deltoides Anterior', 'Deltoides Lateral', 'Deltoides Posterior', 
    'Dorsal Ancho', 'Extensores del Antebrazo', 'Flexores del Antebrazo', 
    'Pectoral Mayor', 'Romboides', 'Serrato Anterior', 
    'Trapecio', 'Tríceps Braquial'
) AND `idtrenmuscular` IS NULL;

-- Tren Inferior (id = 2)
UPDATE `musculo` SET `idtrenmuscular` = 2 
WHERE `nombre` IN (
    'Abductores', 'Aductores', 'Cuádriceps', 
    'Flexores de Cadera', 'Gastrocnemio (Gemelos)', 'Glúteo Mayor', 
    'Glúteo Medio', 'Isquiotibiales', 'Sóleo'
) AND `idtrenmuscular` IS NULL;

-- Core / Tronco (id = 3)
UPDATE `musculo` SET `idtrenmuscular` = 3 
WHERE `nombre` IN (
    'Erector Espinal', 'Oblicuos', 'Recto Abdominal', 'Transverso Abdominal'
) AND `idtrenmuscular` IS NULL;

-- 7. Clasificar ejercicios existentes basándose en el músculo asociado principal
UPDATE `ejercicio` e
JOIN `musculoejercicio` me ON me.idejercicio = e.idejercicio
JOIN `musculo` m ON m.idmusculo = me.idmusculo
SET e.idtrenmuscular = m.idtrenmuscular
WHERE e.idtrenmuscular IS NULL AND m.idtrenmuscular IS NOT NULL;

-- 8. Actualizar / crear vistas compatibles
CREATE OR REPLACE VIEW `TrenMuscular` AS 
SELECT `idtrenmuscular`, `nombre` FROM `trenmuscular`;

CREATE OR REPLACE VIEW `Musculo` AS 
SELECT `idmusculo`, `nombre`, `imagen`, `idtrenmuscular` FROM `musculo`;

CREATE OR REPLACE VIEW `ProgramaEntrenamiento` AS 
SELECT `idprogramaentrenamiento`, `nombre`, `idmotivoentrenamiento`, `idrangoedad`, `idtrenmuscular` 
FROM `programaentrenamiento`;
