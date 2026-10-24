-- ==============================================================================
-- Migración: Tabla comida para Estructuración de Comidas en Planes Nutricionales
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `comida` (
  `idcomida` int(11) NOT NULL AUTO_INCREMENT,
  `idplanalimentacion` int(11) NOT NULL,
  `idtipocomida` int(11) NOT NULL,
  `idreceta` int(11) NOT NULL,
  `horarecomendada` time DEFAULT NULL,
  PRIMARY KEY (`idcomida`),
  KEY `fk_comida_plan` (`idplanalimentacion`),
  KEY `fk_comida_tipo` (`idtipocomida`),
  KEY `fk_comida_receta` (`idreceta`),
  CONSTRAINT `fk_comida_plan` FOREIGN KEY (`idplanalimentacion`) REFERENCES `planalimentacion` (`idplanalimentacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comida_tipo` FOREIGN KEY (`idtipocomida`) REFERENCES `tipocomida` (`idtipocomida`) ON UPDATE CASCADE,
  CONSTRAINT `fk_comida_receta` FOREIGN KEY (`idreceta`) REFERENCES `receta` (`idreceta`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad
CREATE OR REPLACE VIEW `Comida` AS
SELECT `idcomida`, `idplanalimentacion`, `idtipocomida`, `idreceta`, `horarecomendada`
FROM `comida`;

-- Inserción de comidas estructuradas de ejemplo
INSERT INTO `comida` (`idplanalimentacion`, `idtipocomida`, `idreceta`, `horarecomendada`)
SELECT 1, 1, 1, '07:30:00' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `comida` WHERE `idplanalimentacion` = 1 AND `idtipocomida` = 1 AND `idreceta` = 1);

INSERT INTO `comida` (`idplanalimentacion`, `idtipocomida`, `idreceta`, `horarecomendada`)
SELECT 1, 3, 2, '13:00:00' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `comida` WHERE `idplanalimentacion` = 1 AND `idtipocomida` = 3 AND `idreceta` = 2);

INSERT INTO `comida` (`idplanalimentacion`, `idtipocomida`, `idreceta`, `horarecomendada`)
SELECT 1, 6, 3, '17:30:00' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `comida` WHERE `idplanalimentacion` = 1 AND `idtipocomida` = 6 AND `idreceta` = 3);

INSERT INTO `comida` (`idplanalimentacion`, `idtipocomida`, `idreceta`, `horarecomendada`)
SELECT 1, 7, 4, '20:30:00' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `comida` WHERE `idplanalimentacion` = 1 AND `idtipocomida` = 7 AND `idreceta` = 4);

INSERT INTO `comida` (`idplanalimentacion`, `idtipocomida`, `idreceta`, `horarecomendada`)
SELECT 2, 1, 3, '08:00:00' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `comida` WHERE `idplanalimentacion` = 2 AND `idtipocomida` = 1 AND `idreceta` = 3);

INSERT INTO `comida` (`idplanalimentacion`, `idtipocomida`, `idreceta`, `horarecomendada`)
SELECT 2, 3, 2, '13:30:00' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `comida` WHERE `idplanalimentacion` = 2 AND `idtipocomida` = 3 AND `idreceta` = 2);

INSERT INTO `comida` (`idplanalimentacion`, `idtipocomida`, `idreceta`, `horarecomendada`)
SELECT 2, 7, 4, '20:00:00' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `comida` WHERE `idplanalimentacion` = 2 AND `idtipocomida` = 7 AND `idreceta` = 4);
