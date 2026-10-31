-- ==============================================================================
-- Migración: Tabla imagenalimento para Gim360
-- ==============================================================================
-- Relaciona las imágenes del repositorio institucional con los alimentos del catálogo.
-- Este script es seguro e idempotente (CREATE TABLE IF NOT EXISTS / INSERT IGNORE).
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `imagenalimento` (
  `idimagenalimento` int(11) NOT NULL AUTO_INCREMENT,
  `idimagen` int(11) NOT NULL,
  `idalimento` int(11) NOT NULL,
  PRIMARY KEY (`idimagenalimento`),
  UNIQUE KEY `uk_imagen_alimento` (`idimagen`, `idalimento`),
  KEY `fk_ia_imagen` (`idimagen`),
  KEY `fk_ia_alimento` (`idalimento`),
  CONSTRAINT `fk_ia_imagen` FOREIGN KEY (`idimagen`) REFERENCES `imagen` (`idimagen`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ia_alimento` FOREIGN KEY (`idalimento`) REFERENCES `alimento` (`idalimento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad para evitar problemas de mayúsculas/minúsculas en diferentes SO
CREATE OR REPLACE VIEW `ImagenAlimento` AS
SELECT `idimagenalimento`, `idimagen`, `idalimento`
FROM `imagenalimento`;

-- Datos de prueba / semilla (si existen imágenes y alimentos)
INSERT IGNORE INTO `imagenalimento` (`idimagen`, `idalimento`) VALUES
(1, 1),
(2, 2);
