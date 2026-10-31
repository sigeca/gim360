-- ==============================================================================
-- Migración: Tabla cumplimientoplanalimentacion para Gim360
-- ==============================================================================
-- Registra el cumplimiento efectivo de las comidas programadas dentro de un plan
-- de alimentación nutricional, almacenando la fecha y hora de realización.
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `cumplimientoplanalimentacion` (
  `idcumplimientoplanalimentacion` int(11) NOT NULL AUTO_INCREMENT,
  `idplanalimentacion` int(11) NOT NULL,
  `idcomida` int(11) NOT NULL,
  `fechahora` datetime NOT NULL,
  PRIMARY KEY (`idcumplimientoplanalimentacion`),
  KEY `fk_cumplimiento_plan` (`idplanalimentacion`),
  KEY `fk_cumplimiento_comida` (`idcomida`),
  KEY `idx_cumplimiento_fechahora` (`fechahora`),
  CONSTRAINT `fk_cumplimiento_plan` FOREIGN KEY (`idplanalimentacion`) REFERENCES `planalimentacion` (`idplanalimentacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_cumplimiento_comida` FOREIGN KEY (`idcomida`) REFERENCES `comida` (`idcomida`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad para entornos case-sensitive / estándares del framework
CREATE OR REPLACE VIEW `CumplimientoPlanAlimentacion` AS
SELECT `idcumplimientoplanalimentacion`, `idplanalimentacion`, `idcomida`, `fechahora`
FROM `cumplimientoplanalimentacion`;

-- Inserción de registros iniciales de prueba basados en planes y comidas existentes
INSERT INTO `cumplimientoplanalimentacion` (`idplanalimentacion`, `idcomida`, `fechahora`)
SELECT c.`idplanalimentacion`, c.`idcomida`, NOW()
FROM `comida` c
WHERE c.`idcomida` = (SELECT MIN(c2.`idcomida`) FROM `comida` c2 WHERE c2.`idplanalimentacion` = c.`idplanalimentacion`)
  AND NOT EXISTS (
    SELECT 1 FROM `cumplimientoplanalimentacion` cp 
    WHERE cp.`idplanalimentacion` = c.`idplanalimentacion` AND cp.`idcomida` = c.`idcomida`
  )
LIMIT 3;
