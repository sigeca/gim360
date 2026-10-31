-- ==============================================================================
-- Migración: Tabla objetivonutricional y relación con planalimentacion
-- ==============================================================================
-- Script 100% seguro e idempotente para entorno local o servidores en la nube.
-- ==============================================================================

-- 1. Crear tabla objetivonutricional
CREATE TABLE IF NOT EXISTS `objetivonutricional` (
  `idobjetivonutricional` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) NOT NULL,
  PRIMARY KEY (`idobjetivonutricional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- 2. Crear vista de compatibilidad de nombres
CREATE OR REPLACE VIEW `ObjetivoNutricional` AS 
SELECT `idobjetivonutricional`, `nombre` 
FROM `objetivonutricional`;

-- 3. Datos iniciales para objetivos nutricionales
INSERT IGNORE INTO `objetivonutricional` (`idobjetivonutricional`, `nombre`) VALUES
(1, 'Pérdida de Grasa y Definición Muscular'),
(2, 'Aumento de Masa Muscular (Hipertrofia / Superávit Calórico)'),
(3, 'Mantenimiento y Recomposición Corporal'),
(4, 'Rendimiento Deportivo y Resistencia'),
(5, 'Salud Cardiovascular y Control Metabólico'),
(6, 'Fuerza Máxima y Potencia');

-- 4. Agregar columna idobjetivonutricional en planalimentacion si aún no existe
SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
                   WHERE TABLE_SCHEMA = DATABASE() 
                   AND TABLE_NAME = 'planalimentacion' 
                   AND COLUMN_NAME = 'idobjetivonutricional');

SET @sql = IF(@col_exists = 0, 
              'ALTER TABLE `planalimentacion` ADD COLUMN `idobjetivonutricional` int(11) DEFAULT NULL AFTER `idpersona`, ADD KEY `fk_plan_objetivonutricional` (`idobjetivonutricional`), ADD CONSTRAINT `fk_plan_objetivonutricional` FOREIGN KEY (`idobjetivonutricional`) REFERENCES `objetivonutricional` (`idobjetivonutricional`) ON DELETE SET NULL ON UPDATE CASCADE;', 
              'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 5. Vincular registros existentes si están vacíos
UPDATE `planalimentacion` SET `idobjetivonutricional` = 1 WHERE `idplanalimentacion` = 1 AND `idobjetivonutricional` IS NULL;
UPDATE `planalimentacion` SET `idobjetivonutricional` = 3 WHERE `idplanalimentacion` = 2 AND `idobjetivonutricional` IS NULL;
UPDATE `planalimentacion` SET `idobjetivonutricional` = 2 WHERE `idplanalimentacion` = 3 AND `idobjetivonutricional` IS NULL;
UPDATE `planalimentacion` SET `idobjetivonutricional` = 6 WHERE `idplanalimentacion` = 4 AND `idobjetivonutricional` IS NULL;
