-- ==============================================================================
-- Migración: Tabla imagen y auxiliares para Gim360 (compatible con la nube)
-- ==============================================================================
-- Este script es seguro e idempotente. Puede ejecutarse en local y en la nube
-- tantas veces como sea necesario SIN afectar ni borrar datos existentes.
-- ==============================================================================

-- 1. Tabla formatoimagen
CREATE TABLE IF NOT EXISTS `formatoimagen` (
  `idformatoimagen` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idformatoimagen`),
  UNIQUE KEY `uk_formatoimagen_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `FormatoImagen` AS
SELECT `idformatoimagen`, `nombre`
FROM `formatoimagen`;

INSERT IGNORE INTO `formatoimagen` (`idformatoimagen`, `nombre`) VALUES
(1, 'jpg'),
(2, 'png'),
(3, 'webp'),
(4, 'gif'),
(5, 'jpeg');

-- 2. Tabla ordenador
CREATE TABLE IF NOT EXISTS `ordenador` (
  `idordenador` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idordenador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Ordenador` AS
SELECT `idordenador`, `nombre`
FROM `ordenador`;

INSERT IGNORE INTO `ordenador` (`idordenador`, `nombre`) VALUES
(1, 'Servidor Local gim360');

-- 3. Tabla directorio
CREATE TABLE IF NOT EXISTS `directorio` (
  `iddirectorio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `ruta` varchar(200) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `idordenador` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`iddirectorio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Directorio` AS
SELECT `iddirectorio`, `nombre`, `ruta`, `descripcion`, `idordenador`
FROM `directorio`;

INSERT IGNORE INTO `directorio` (`iddirectorio`, `nombre`, `ruta`, `descripcion`, `idordenador`) VALUES
(1, 'Imagenes Gim360', 'repositorio/imagen', 'Directorio de almacenamiento de imágenes', 1);

-- 4. Tabla imagen
CREATE TABLE IF NOT EXISTS `imagen` (
  `idimagen` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `idformatoimagen` int(11) DEFAULT NULL,
  `fechacaptura` datetime DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `palabrasclave` text DEFAULT NULL,
  `licencia` varchar(50) DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `idordenador` int(11) DEFAULT 1,
  `iddirectorio` int(11) DEFAULT 1,
  PRIMARY KEY (`idimagen`),
  KEY `idx_imagen_formato` (`idformatoimagen`),
  KEY `idx_imagen_ordenador` (`idordenador`),
  KEY `idx_imagen_directorio` (`iddirectorio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Imagen` AS
SELECT `idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, 
       `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio`
FROM `imagen`;
