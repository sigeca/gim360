-- ==============================================================================
-- Migración: Tabla recetacomponentenutricional para Gim360
-- ==============================================================================
-- Asocia recetas saludables con sus componentes nutricionales esenciales.
-- Este script es seguro e idempotente (CREATE TABLE IF NOT EXISTS / INSERT IGNORE).
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `recetacomponentenutricional` (
  `idrecetacomponentenutricional` int(11) NOT NULL AUTO_INCREMENT,
  `idreceta` int(11) NOT NULL,
  `idcomponentenutricional` int(11) NOT NULL,
  PRIMARY KEY (`idrecetacomponentenutricional`),
  UNIQUE KEY `uk_receta_componente` (`idreceta`, `idcomponentenutricional`),
  KEY `fk_rcn_receta` (`idreceta`),
  KEY `fk_rcn_componente` (`idcomponentenutricional`),
  CONSTRAINT `fk_rcn_receta` FOREIGN KEY (`idreceta`) REFERENCES `receta` (`idreceta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rcn_componente` FOREIGN KEY (`idcomponentenutricional`) REFERENCES `componentenutricional` (`idcomponentenutricional`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad para evitar problemas de mayúsculas/minúsculas
CREATE OR REPLACE VIEW `RecetaComponenteNutricional` AS
SELECT `idrecetacomponentenutricional`, `idreceta`, `idcomponentenutricional`
FROM `recetacomponentenutricional`;

-- Datos semilla iniciales para recetas base (no afecta datos existentes)
INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES
-- 1: Tortilla de Avena y Claras de Huevo (Proteínas, Carbohidratos Totales, Fibra Dietética)
(1, 1), (1, 2), (1, 7),
-- 2: Bowl de Pollo a la Plancha con Quinoa y Aguacate (Proteínas, Grasas Monoinsaturadas, Fibra Dietética, Potasio)
(2, 1), (2, 5), (2, 7), (2, 11),
-- 3: Batido Proteico Post-Entreno de Plátano y Avena (Proteínas, Carbohidratos Totales, Potasio, Calorías)
(3, 1), (3, 2), (3, 11), (3, 9),
-- 4: Salmón al Horno con Espárragos y Batata Asada (Proteínas, Grasas Poliinsaturadas, Fibra Dietética, Vitamina D)
(4, 1), (4, 6), (4, 7), (4, 18),
-- 5: Yogur Griego con Nueces y Arándanos (Proteínas, Grasas Monoinsaturadas, Calcio, Vitamina C)
(5, 1), (5, 5), (5, 12), (5, 17);
