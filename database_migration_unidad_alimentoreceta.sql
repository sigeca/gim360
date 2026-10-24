-- ==============================================================================
-- Migración: Tablas unidadalimento y alimentoreceta
-- ==============================================================================

-- 1. Tabla unidadalimento (Unidades de medida para alimentos)
CREATE TABLE IF NOT EXISTS `unidadalimento` (
  `idunidadalimento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `abreviatura` varchar(15) NOT NULL,
  PRIMARY KEY (`idunidadalimento`),
  UNIQUE KEY `uq_unidad_nombre` (`nombre`),
  UNIQUE KEY `uq_unidad_abrev` (`abreviatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad para UnidadAlimento
CREATE OR REPLACE VIEW `UnidadAlimento` AS
SELECT `idunidadalimento`, `nombre`, `abreviatura`
FROM `unidadalimento`;

-- 2. Tabla alimentoreceta (Ingredientes y cantidades de cada receta)
CREATE TABLE IF NOT EXISTS `alimentoreceta` (
  `idalimentoreceta` int(11) NOT NULL AUTO_INCREMENT,
  `idreceta` int(11) NOT NULL,
  `idalimento` int(11) NOT NULL,
  `cantidad` decimal(8,2) NOT NULL,
  `idunidadalimento` int(11) NOT NULL,
  PRIMARY KEY (`idalimentoreceta`),
  KEY `fk_ar_receta` (`idreceta`),
  KEY `fk_ar_alimento` (`idalimento`),
  KEY `fk_ar_unidad` (`idunidadalimento`),
  CONSTRAINT `fk_ar_receta` FOREIGN KEY (`idreceta`) REFERENCES `receta` (`idreceta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ar_alimento` FOREIGN KEY (`idalimento`) REFERENCES `alimento` (`idalimento`) ON UPDATE CASCADE,
  CONSTRAINT `fk_ar_unidad` FOREIGN KEY (`idunidadalimento`) REFERENCES `unidadalimento` (`idunidadalimento`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad para AlimentoReceta
CREATE OR REPLACE VIEW `AlimentoReceta` AS
SELECT `idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`
FROM `alimentoreceta`;

-- Semillas de unidades de medida estándar
INSERT INTO `unidadalimento` (`nombre`, `abreviatura`) VALUES
('Gramo', 'g'),
('Kilogramo', 'kg'),
('Mililitro', 'ml'),
('Litro', 'l'),
('Cucharada', 'cda'),
('Cucharadita', 'cdta'),
('Taza', 'tz'),
('Unidad / Pieza', 'unid'),
('Medida / Scoop', 'scoop'),
('Rebanada / Rodaja', 'reb'),
('Onza', 'oz')
ON DUPLICATE KEY UPDATE `abreviatura` = VALUES(`abreviatura`);

-- Ingredientes de ejemplo para las recetas existentes:
-- Receta 1: Tortilla de Avena y Claras de Huevo (idreceta=1)
-- Huevos (idalimento=2), Avena (idalimento=5), Aceite de Oliva (idalimento=9)
INSERT INTO `alimentoreceta` (`idreceta`, `idalimento`, `cantidad`, `idunidadalimento`)
SELECT 1, 2, 4.00, 8 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `alimentoreceta` WHERE `idreceta` = 1 AND `idalimento` = 2);

INSERT INTO `alimentoreceta` (`idreceta`, `idalimento`, `cantidad`, `idunidadalimento`)
SELECT 1, 5, 40.00, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `alimentoreceta` WHERE `idreceta` = 1 AND `idalimento` = 5);

INSERT INTO `alimentoreceta` (`idreceta`, `idalimento`, `cantidad`, `idunidadalimento`)
SELECT 1, 9, 5.00, 3 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `alimentoreceta` WHERE `idreceta` = 1 AND `idalimento` = 9);

-- Receta 2: Bowl de Pollo a la Plancha con Quinoa y Aguacate (idreceta=2)
-- Pechuga de Pollo (idalimento=1), Quinoa (idalimento=7), Aguacate (idalimento=10), Espinacas (idalimento=13)
INSERT INTO `alimentoreceta` (`idreceta`, `idalimento`, `cantidad`, `idunidadalimento`)
SELECT 2, 1, 250.00, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `alimentoreceta` WHERE `idreceta` = 2 AND `idalimento` = 1);

INSERT INTO `alimentoreceta` (`idreceta`, `idalimento`, `cantidad`, `idunidadalimento`)
SELECT 2, 7, 100.00, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `alimentoreceta` WHERE `idreceta` = 2 AND `idalimento` = 7);

INSERT INTO `alimentoreceta` (`idreceta`, `idalimento`, `cantidad`, `idunidadalimento`)
SELECT 2, 10, 1.00, 8 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `alimentoreceta` WHERE `idreceta` = 2 AND `idalimento` = 10);

INSERT INTO `alimentoreceta` (`idreceta`, `idalimento`, `cantidad`, `idunidadalimento`)
SELECT 2, 13, 50.00, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `alimentoreceta` WHERE `idreceta` = 2 AND `idalimento` = 13);

-- Receta 3: Batido Proteico Post-Entreno de Plátano y Avena (idreceta=3)
-- Leche (idalimento=18), Plátano (idalimento=15), Avena (idalimento=5), Proteína Whey (idalimento=22)
INSERT INTO `alimentoreceta` (`idreceta`, `idalimento`, `cantidad`, `idunidadalimento`)
SELECT 3, 18, 250.00, 3 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `alimentoreceta` WHERE `idreceta` = 3 AND `idalimento` = 18);

INSERT INTO `alimentoreceta` (`idreceta`, `idalimento`, `cantidad`, `idunidadalimento`)
SELECT 3, 15, 1.00, 8 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `alimentoreceta` WHERE `idreceta` = 3 AND `idalimento` = 15);

INSERT INTO `alimentoreceta` (`idreceta`, `idalimento`, `cantidad`, `idunidadalimento`)
SELECT 3, 5, 35.00, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `alimentoreceta` WHERE `idreceta` = 3 AND `idalimento` = 5);

INSERT INTO `alimentoreceta` (`idreceta`, `idalimento`, `cantidad`, `idunidadalimento`)
SELECT 3, 22, 1.00, 9 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `alimentoreceta` WHERE `idreceta` = 3 AND `idalimento` = 22);
