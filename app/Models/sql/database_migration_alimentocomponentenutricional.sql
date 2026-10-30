-- ==============================================================================
-- Migración: Tabla alimentocomponentenutricional para Gim360
-- ==============================================================================
-- Asocia alimentos con sus componentes nutricionales esenciales.
-- Este script es seguro e idempotente (CREATE TABLE IF NOT EXISTS / INSERT IGNORE).
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `alimentocomponentenutricional` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad para evitar problemas de mayúsculas/minúsculas
CREATE OR REPLACE VIEW `AlimentoComponenteNutricional` AS
SELECT `idalimentocomponentenutricional`, `idalimentocomponentenuetricional`, `idalimento`, `idcomponentenutricional`
FROM `alimentocomponentenutricional`;

-- Datos semilla iniciales para alimentos base (no afecta datos existentes)
INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES
-- 1: Pechuga de Pollo (Proteínas, Sodio, Potasio, Vitamina B12)
(1, 1), (1, 10), (1, 11), (1, 19),
-- 2: Huevos Enteros y Claras (Proteínas, Grasas Totales, Vitamina D, Vitamina B12)
(2, 1), (2, 3), (2, 18), (2, 19),
-- 3: Atún al Natural (Proteínas, Grasas Poliinsaturadas, Sodio)
(3, 1), (3, 6), (3, 10),
-- 4: Carne de Res Magra (Proteínas, Hierro, Zinc, Creatina, Vitamina B12)
(4, 1), (4, 14), (4, 15), (4, 20), (4, 19),
-- 5: Yogur Griego Natural (Proteínas, Carbohidratos Totales, Calcio)
(5, 1), (5, 2), (5, 12),
-- 6: Queso Cottage / Ricotta (Proteínas, Calcio, Sodio)
(6, 1), (6, 12), (6, 10),
-- 7: Leche Descremada (Proteínas, Carbohidratos Totales, Calcio, Vitamina D)
(7, 1), (7, 2), (7, 12), (7, 18),
-- 8: Avena en Hojuelas (Carbohidratos Totales, Fibra Dietética, Magnesio, Proteínas)
(8, 2), (8, 7), (8, 13), (8, 1),
-- 9: Arroz Blanco / Integral (Carbohidratos Totales, Calorías / Valor Energético)
(9, 2), (9, 9),
-- 10: Papa Cocida y Camote (Carbohidratos Totales, Potasio, Fibra Dietética)
(10, 2), (10, 11), (10, 7);
