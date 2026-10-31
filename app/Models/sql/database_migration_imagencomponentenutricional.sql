-- ==============================================================================
-- Migración: Tabla imagencomponentenutricional para Gim360
-- ==============================================================================
-- Relaciona las imágenes del repositorio con los componentes nutricionales.
-- Este script es seguro e idempotente (CREATE TABLE IF NOT EXISTS / INSERT IGNORE).
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `imagencomponentenutricional` (
  `idimagencomponentenutricional` int(11) NOT NULL AUTO_INCREMENT,
  `idimagen` int(11) NOT NULL,
  `idcomponentenutricional` int(11) NOT NULL,
  PRIMARY KEY (`idimagencomponentenutricional`),
  UNIQUE KEY `uk_imagen_componentenutricional` (`idimagen`, `idcomponentenutricional`),
  KEY `fk_icn_imagen` (`idimagen`),
  KEY `fk_icn_componentenutricional` (`idcomponentenutricional`),
  CONSTRAINT `fk_icn_imagen` FOREIGN KEY (`idimagen`) REFERENCES `imagen` (`idimagen`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_icn_componentenutricional` FOREIGN KEY (`idcomponentenutricional`) REFERENCES `componentenutricional` (`idcomponentenutricional`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad para evitar problemas de mayúsculas/minúsculas en diferentes SO
CREATE OR REPLACE VIEW `ImagenComponenteNutricional` AS
SELECT `idimagencomponentenutricional`, `idimagen`, `idcomponentenutricional`
FROM `imagencomponentenutricional`;

-- Datos de prueba / semilla (si existen imágenes y componentes)
INSERT IGNORE INTO `imagencomponentenutricional` (`idimagen`, `idcomponentenutricional`) VALUES
(1, 1),
(2, 2);
