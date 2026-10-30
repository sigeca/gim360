-- ==============================================================================
-- Migración Consolidada: Relaciones de Componentes Nutricionales (Gim360)
-- Incluye: alimentocomponentenutricional y recetacomponentenutricional
-- ==============================================================================
-- Este script es seguro e idempotente:
-- - No altera datos preexistentes.
-- - Crea tablas con IF NOT EXISTS.
-- - Registra vistas con CREATE OR REPLACE VIEW.
-- - Inserta datos de inicialización usando INSERT IGNORE INTO.
-- ==============================================================================

-- 1. Tabla alimentocomponentenutricional
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

-- Vista de compatibilidad para alimentocomponentenutricional
CREATE OR REPLACE VIEW `AlimentoComponenteNutricional` AS
SELECT `idalimentocomponentenutricional`, `idalimentocomponentenuetricional`, `idalimento`, `idcomponentenutricional`
FROM `alimentocomponentenutricional`;

-- 2. Tabla recetacomponentenutricional
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

-- Vista de compatibilidad para recetacomponentenutricional
CREATE OR REPLACE VIEW `RecetaComponenteNutricional` AS
SELECT `idrecetacomponentenutricional`, `idreceta`, `idcomponentenutricional`
FROM `recetacomponentenutricional`;

-- 3. Datos iniciales para alimentocomponentenutricional
INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES
(1, 1), (1, 10), (1, 11), (1, 19),
(2, 1), (2, 3), (2, 18), (2, 19),
(3, 1), (3, 6), (3, 10),
(4, 1), (4, 14), (4, 15), (4, 20), (4, 19),
(5, 1), (5, 2), (5, 12),
(6, 1), (6, 12), (6, 10),
(7, 1), (7, 2), (7, 12), (7, 18),
(8, 2), (8, 7), (8, 13), (8, 1),
(9, 2), (9, 9),
(10, 2), (10, 11), (10, 7);

-- 4. Datos iniciales para recetacomponentenutricional
INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES
(1, 1), (1, 2), (1, 7),
(2, 1), (2, 5), (2, 7), (2, 11),
(3, 1), (3, 2), (3, 11), (3, 9),
(4, 1), (4, 6), (4, 7), (4, 18),
(5, 1), (5, 5), (5, 12), (5, 17);
