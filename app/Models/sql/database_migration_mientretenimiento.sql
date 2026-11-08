-- ==============================================================================
-- Migración Consolidada: Mi Entretenimiento Personalizado (Gim360)
-- Incluye las tablas:
--   1. mientretenimiento (con idpersona e identretenimiento base opcional)
--   2. mientretenimientomusica
--   3. mientretenimientovideo
--   4. mientretenimientojuego
--   5. mientretenimientopodcast
-- ==============================================================================
-- Script 100% seguro e idempotente (CREATE TABLE IF NOT EXISTS / INSERT IGNORE)
-- ==============================================================================

-- 1. Tabla mientretenimiento
CREATE TABLE IF NOT EXISTS `mientretenimiento` (
  `idmientretenimiento` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  `identretenimiento` int(11) DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`idmientretenimiento`),
  KEY `fk_me_persona` (`idpersona`),
  KEY `fk_me_entretenimiento` (`identretenimiento`),
  CONSTRAINT `fk_me_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_me_entretenimiento` FOREIGN KEY (`identretenimiento`) REFERENCES `entretenimiento` (`identretenimiento`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `MiEntretenimiento` AS
SELECT `idmientretenimiento`, `idpersona`, `identretenimiento`, `nombre`, `descripcion`
FROM `mientretenimiento`;

-- 2. Tabla relacional mientretenimientomusica
CREATE TABLE IF NOT EXISTS `mientretenimientomusica` (
  `idmientretenimientomusica` int(11) NOT NULL AUTO_INCREMENT,
  `idmientretenimiento` int(11) NOT NULL,
  `idmusica` int(11) NOT NULL,
  PRIMARY KEY (`idmientretenimientomusica`),
  UNIQUE KEY `uk_mientretenimiento_musica` (`idmientretenimiento`, `idmusica`),
  KEY `fk_mem_mientretenimiento` (`idmientretenimiento`),
  KEY `fk_mem_musica` (`idmusica`),
  CONSTRAINT `fk_mem_mientretenimiento` FOREIGN KEY (`idmientretenimiento`) REFERENCES `mientretenimiento` (`idmientretenimiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mem_musica` FOREIGN KEY (`idmusica`) REFERENCES `musica` (`idmusica`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `MiEntretenimientoMusica` AS
SELECT `idmientretenimientomusica`, `idmientretenimiento`, `idmusica`
FROM `mientretenimientomusica`;

-- 3. Tabla relacional mientretenimientovideo
CREATE TABLE IF NOT EXISTS `mientretenimientovideo` (
  `idmientretenimientovideo` int(11) NOT NULL AUTO_INCREMENT,
  `idmientretenimiento` int(11) NOT NULL,
  `idvideo` int(11) NOT NULL,
  PRIMARY KEY (`idmientretenimientovideo`),
  UNIQUE KEY `uk_mientretenimiento_video` (`idmientretenimiento`, `idvideo`),
  KEY `fk_mev_mientretenimiento` (`idmientretenimiento`),
  KEY `fk_mev_video` (`idvideo`),
  CONSTRAINT `fk_mev_mientretenimiento` FOREIGN KEY (`idmientretenimiento`) REFERENCES `mientretenimiento` (`idmientretenimiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mev_video` FOREIGN KEY (`idvideo`) REFERENCES `video` (`idvideo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `MiEntretenimientoVideo` AS
SELECT `idmientretenimientovideo`, `idmientretenimiento`, `idvideo`
FROM `mientretenimientovideo`;

-- 4. Tabla relacional mientretenimientojuego
CREATE TABLE IF NOT EXISTS `mientretenimientojuego` (
  `idmientretenimientojuego` int(11) NOT NULL AUTO_INCREMENT,
  `idmientretenimiento` int(11) NOT NULL,
  `idjuego` int(11) NOT NULL,
  PRIMARY KEY (`idmientretenimientojuego`),
  UNIQUE KEY `uk_mientretenimiento_juego` (`idmientretenimiento`, `idjuego`),
  KEY `fk_mej_mientretenimiento` (`idmientretenimiento`),
  KEY `fk_mej_juego` (`idjuego`),
  CONSTRAINT `fk_mej_mientretenimiento` FOREIGN KEY (`idmientretenimiento`) REFERENCES `mientretenimiento` (`idmientretenimiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mej_juego` FOREIGN KEY (`idjuego`) REFERENCES `juego` (`idjuego`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `MiEntretenimientoJuego` AS
SELECT `idmientretenimientojuego`, `idmientretenimiento`, `idjuego`
FROM `mientretenimientojuego`;

-- 5. Tabla relacional mientretenimientopodcast
CREATE TABLE IF NOT EXISTS `mientretenimientopodcast` (
  `idmientretenimientopodcast` int(11) NOT NULL AUTO_INCREMENT,
  `idmientretenimiento` int(11) NOT NULL,
  `idpodcast` int(11) NOT NULL,
  PRIMARY KEY (`idmientretenimientopodcast`),
  UNIQUE KEY `uk_mientretenimiento_podcast` (`idmientretenimiento`, `idpodcast`),
  KEY `fk_mepod_mientretenimiento` (`idmientretenimiento`),
  KEY `fk_mepod_podcast` (`idpodcast`),
  CONSTRAINT `fk_mepod_mientretenimiento` FOREIGN KEY (`idmientretenimiento`) REFERENCES `mientretenimiento` (`idmientretenimiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mepod_podcast` FOREIGN KEY (`idpodcast`) REFERENCES `podcast` (`idpodcast`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `MiEntretenimientoPodcast` AS
SELECT `idmientretenimientopodcast`, `idmientretenimiento`, `idpodcast`
FROM `mientretenimientopodcast`;

-- ==============================================================================
-- Datos semilla iniciales (INSERT IGNORE) si existe al menos una persona
-- ==============================================================================

INSERT IGNORE INTO `mientretenimiento` (`idmientretenimiento`, `idpersona`, `identretenimiento`, `nombre`, `descripcion`)
SELECT 1, p.idpersona, 1, 'Mi Energía Cardio y Fuerza Personalizado', 'Lista personalizada basada en Energía Cardio y Fuerza con selección propia de música, videos, juegos y podcasts.'
FROM (SELECT MIN(`idpersona`) AS idpersona FROM `persona`) p
WHERE p.idpersona IS NOT NULL;

INSERT IGNORE INTO `mientretenimientomusica` (`idmientretenimientomusica`, `idmientretenimiento`, `idmusica`)
SELECT 1, 1, 1 FROM `mientretenimiento` WHERE `idmientretenimiento` = 1;
INSERT IGNORE INTO `mientretenimientomusica` (`idmientretenimientomusica`, `idmientretenimiento`, `idmusica`)
SELECT 2, 1, 2 FROM `mientretenimiento` WHERE `idmientretenimiento` = 1;
INSERT IGNORE INTO `mientretenimientomusica` (`idmientretenimientomusica`, `idmientretenimiento`, `idmusica`)
SELECT 3, 1, 3 FROM `mientretenimiento` WHERE `idmientretenimiento` = 1;
INSERT IGNORE INTO `mientretenimientomusica` (`idmientretenimientomusica`, `idmientretenimiento`, `idmusica`)
SELECT 4, 1, 4 FROM `mientretenimiento` WHERE `idmientretenimiento` = 1;

INSERT IGNORE INTO `mientretenimientovideo` (`idmientretenimientovideo`, `idmientretenimiento`, `idvideo`)
SELECT 1, 1, 1 FROM `mientretenimiento` WHERE `idmientretenimiento` = 1;
INSERT IGNORE INTO `mientretenimientovideo` (`idmientretenimientovideo`, `idmientretenimiento`, `idvideo`)
SELECT 2, 1, 2 FROM `mientretenimiento` WHERE `idmientretenimiento` = 1;
INSERT IGNORE INTO `mientretenimientovideo` (`idmientretenimientovideo`, `idmientretenimiento`, `idvideo`)
SELECT 3, 1, 3 FROM `mientretenimiento` WHERE `idmientretenimiento` = 1;

INSERT IGNORE INTO `mientretenimientojuego` (`idmientretenimientojuego`, `idmientretenimiento`, `idjuego`)
SELECT 1, 1, 1 FROM `mientretenimiento` WHERE `idmientretenimiento` = 1;
INSERT IGNORE INTO `mientretenimientojuego` (`idmientretenimientojuego`, `idmientretenimiento`, `idjuego`)
SELECT 2, 1, 2 FROM `mientretenimiento` WHERE `idmientretenimiento` = 1;

INSERT IGNORE INTO `mientretenimientopodcast` (`idmientretenimientopodcast`, `idmientretenimiento`, `idpodcast`)
SELECT 1, 1, 1 FROM `mientretenimiento` WHERE `idmientretenimiento` = 1;
INSERT IGNORE INTO `mientretenimientopodcast` (`idmientretenimientopodcast`, `idmientretenimiento`, `idpodcast`)
SELECT 2, 1, 2 FROM `mientretenimiento` WHERE `idmientretenimiento` = 1;
