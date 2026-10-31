-- ==============================================================================
-- Migración: Tabla imagenreceta para Gim360
-- ==============================================================================
-- Relaciona las imágenes del repositorio con las recetas nutricionales.
-- Este script es seguro e idempotente (CREATE TABLE IF NOT EXISTS / INSERT IGNORE).
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `imagenreceta` (
  `idimagenreceta` int(11) NOT NULL AUTO_INCREMENT,
  `idimagen` int(11) NOT NULL,
  `idreceta` int(11) NOT NULL,
  PRIMARY KEY (`idimagenreceta`),
  UNIQUE KEY `uk_imagen_receta` (`idimagen`, `idreceta`),
  KEY `fk_ir_imagen` (`idimagen`),
  KEY `fk_ir_receta` (`idreceta`),
  CONSTRAINT `fk_ir_imagen` FOREIGN KEY (`idimagen`) REFERENCES `imagen` (`idimagen`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ir_receta` FOREIGN KEY (`idreceta`) REFERENCES `receta` (`idreceta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad para evitar problemas de mayúsculas/minúsculas en diferentes SO
CREATE OR REPLACE VIEW `ImagenReceta` AS
SELECT `idimagenreceta`, `idimagen`, `idreceta`
FROM `imagenreceta`;

-- Datos de prueba / semilla (si existen imágenes y recetas)
INSERT IGNORE INTO `imagenreceta` (`idimagen`, `idreceta`) VALUES
(1, 1),
(2, 2);
