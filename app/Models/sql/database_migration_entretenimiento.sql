-- ==============================================================================
-- Migración Consolidada: Sección de Entretenimiento (Gim360)
-- Incluye las tablas:
--   1. entretenimiento
--   2. musica
--   3. video
--   4. juego
--   5. podcast
--   6. entretenimientomusica
--   7. entretenimientovideo
--   8. entretenimientojuego
--   9. entretenimientopodcast
-- ==============================================================================
-- Script 100% seguro e idempotente (CREATE TABLE IF NOT EXISTS / INSERT IGNORE)
-- ==============================================================================

-- 1. Tabla entretenimiento
CREATE TABLE IF NOT EXISTS `entretenimiento` (
  `identretenimiento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`identretenimiento`),
  UNIQUE KEY `uk_entretenimiento_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Entretenimiento` AS
SELECT `identretenimiento`, `nombre`, `descripcion`
FROM `entretenimiento`;

-- 2. Tabla musica
CREATE TABLE IF NOT EXISTS `musica` (
  `idmusica` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `artista` varchar(150) DEFAULT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `enlace` varchar(500) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`idmusica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Musica` AS
SELECT `idmusica`, `nombre`, `artista`, `genero`, `enlace`, `descripcion`
FROM `musica`;

-- 3. Tabla video
CREATE TABLE IF NOT EXISTS `video` (
  `idvideo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `autor` varchar(150) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `enlace` varchar(500) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`idvideo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Video` AS
SELECT `idvideo`, `nombre`, `autor`, `categoria`, `enlace`, `descripcion`
FROM `video`;

-- 4. Tabla juego
CREATE TABLE IF NOT EXISTS `juego` (
  `idjuego` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `enlace` varchar(500) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`idjuego`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Juego` AS
SELECT `idjuego`, `nombre`, `categoria`, `enlace`, `descripcion`
FROM `juego`;

-- 5. Tabla podcast
CREATE TABLE IF NOT EXISTS `podcast` (
  `idpodcast` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `presentador` varchar(150) DEFAULT NULL,
  `tema` varchar(100) DEFAULT NULL,
  `enlace` varchar(500) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`idpodcast`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Podcast` AS
SELECT `idpodcast`, `nombre`, `presentador`, `tema`, `enlace`, `descripcion`
FROM `podcast`;

-- 6. Tabla relacional entretenimientomusica
CREATE TABLE IF NOT EXISTS `entretenimientomusica` (
  `identretenimientomusica` int(11) NOT NULL AUTO_INCREMENT,
  `identretenimiento` int(11) NOT NULL,
  `idmusica` int(11) NOT NULL,
  PRIMARY KEY (`identretenimientomusica`),
  UNIQUE KEY `uk_entretenimiento_musica` (`identretenimiento`, `idmusica`),
  KEY `fk_em_entretenimiento` (`identretenimiento`),
  KEY `fk_em_musica` (`idmusica`),
  CONSTRAINT `fk_em_entretenimiento` FOREIGN KEY (`identretenimiento`) REFERENCES `entretenimiento` (`identretenimiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_em_musica` FOREIGN KEY (`idmusica`) REFERENCES `musica` (`idmusica`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `EntretenimientoMusica` AS
SELECT `identretenimientomusica`, `identretenimiento`, `idmusica`
FROM `entretenimientomusica`;

-- 7. Tabla relacional entretenimientovideo
CREATE TABLE IF NOT EXISTS `entretenimientovideo` (
  `identretenimientovideo` int(11) NOT NULL AUTO_INCREMENT,
  `identretenimiento` int(11) NOT NULL,
  `idvideo` int(11) NOT NULL,
  PRIMARY KEY (`identretenimientovideo`),
  UNIQUE KEY `uk_entretenimiento_video` (`identretenimiento`, `idvideo`),
  KEY `fk_ev_entretenimiento` (`identretenimiento`),
  KEY `fk_ev_video` (`idvideo`),
  CONSTRAINT `fk_ev_entretenimiento` FOREIGN KEY (`identretenimiento`) REFERENCES `entretenimiento` (`identretenimiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ev_video` FOREIGN KEY (`idvideo`) REFERENCES `video` (`idvideo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `EntretenimientoVideo` AS
SELECT `identretenimientovideo`, `identretenimiento`, `idvideo`
FROM `entretenimientovideo`;

-- 8. Tabla relacional entretenimientojuego
CREATE TABLE IF NOT EXISTS `entretenimientojuego` (
  `identretenimientojuego` int(11) NOT NULL AUTO_INCREMENT,
  `identretenimiento` int(11) NOT NULL,
  `idjuego` int(11) NOT NULL,
  PRIMARY KEY (`identretenimientojuego`),
  UNIQUE KEY `uk_entretenimiento_juego` (`identretenimiento`, `idjuego`),
  KEY `fk_ej_entretenimiento` (`identretenimiento`),
  KEY `fk_ej_juego` (`idjuego`),
  CONSTRAINT `fk_ej_entretenimiento` FOREIGN KEY (`identretenimiento`) REFERENCES `entretenimiento` (`identretenimiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ej_juego` FOREIGN KEY (`idjuego`) REFERENCES `juego` (`idjuego`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `EntretenimientoJuego` AS
SELECT `identretenimientojuego`, `identretenimiento`, `idjuego`
FROM `entretenimientojuego`;

-- 9. Tabla relacional entretenimientopodcast
CREATE TABLE IF NOT EXISTS `entretenimientopodcast` (
  `identretenimientopodcast` int(11) NOT NULL AUTO_INCREMENT,
  `identretenimiento` int(11) NOT NULL,
  `idpodcast` int(11) NOT NULL,
  PRIMARY KEY (`identretenimientopodcast`),
  UNIQUE KEY `uk_entretenimiento_podcast` (`identretenimiento`, `idpodcast`),
  KEY `fk_epod_entretenimiento` (`identretenimiento`),
  KEY `fk_epod_podcast` (`idpodcast`),
  CONSTRAINT `fk_epod_entretenimiento` FOREIGN KEY (`identretenimiento`) REFERENCES `entretenimiento` (`identretenimiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_epod_podcast` FOREIGN KEY (`idpodcast`) REFERENCES `podcast` (`idpodcast`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `EntretenimientoPodcast` AS
SELECT `identretenimientopodcast`, `identretenimiento`, `idpodcast`
FROM `entretenimientopodcast`;

-- ==============================================================================
-- Datos semilla iniciales (INSERT IGNORE)
-- ==============================================================================

INSERT IGNORE INTO `entretenimiento` (`identretenimiento`, `nombre`, `descripcion`) VALUES
(1, 'Energía Cardio y Fuerza', 'Selección multimedia de alta intensidad para sesiones de cardio, pesas y entrenamiento funcional.'),
(2, 'Pausa Activa y Descanso Mental', 'Juegos tradicionales básicos, música relajante y podcasts durante pausas entre series o post-entreno.'),
(3, 'Bienestar Integral y Motivación', 'Contenido educativo, podcasts de salud, videos técnicos y música ambiental para concentración.');

INSERT IGNORE INTO `musica` (`idmusica`, `nombre`, `artista`, `genero`, `enlace`, `descripcion`) VALUES
(1, 'Eye of the Tiger - Workout Mix', 'Survivor', 'Rock / Motivación', 'https://www.youtube.com/watch?v=btPJPFnesV4', 'Clásico motivacional ideal para sesiones intensas de fuerza y cardio.'),
(2, 'Electro Gym Cardio Beats 128 BPM', 'NCS Fitness', 'Electrónica / EDM', 'https://www.youtube.com/watch?v=K4DyBUG242c', 'Ritmo constante a 128 BPM para mantener la cadencia en caminadora, elíptica o bicicleta.'),
(3, 'Lo-Fi Chill Stretching & Mobility', 'Lofi Girl', 'Lo-Fi / Instrumental', 'https://www.youtube.com/watch?v=jfKfPfyJRdk', 'Música suave para sesiones de estiramiento, vuelta a la calma y movilidad articular.'),
(4, 'Powerlifting Heavy Metal Mix', 'Gym Anthems', 'Rock / Metal', 'https://www.youtube.com/watch?v=fJ9rUzIMcZQ', 'Selección de alta energía para levantamientos pesados y récords personales.');

INSERT IGNORE INTO `video` (`idvideo`, `nombre`, `autor`, `categoria`, `enlace`, `descripcion`) VALUES
(1, 'Técnica Correcta de Sentadilla y Peso Muerto', 'Athlean-X Español', 'Técnica de Entrenamiento', 'https://www.youtube.com/watch?v=ultWZbUMPL8', 'Guía biomecánica paso a paso para ejecutar ejercicios compuestos de forma segura.'),
(2, 'Rutina de Calentamiento Dinámico de 10 Minutos', 'Fisioterapia Online', 'Movilidad y Prevención', 'https://www.youtube.com/watch?v=R0mMyV5OtcM', 'Secuencia de activación articular previa al entrenamiento de fuerza.'),
(3, 'Disciplina y Constancia en el Deporte', 'Motivación Fitness', 'Motivación', 'https://www.youtube.com/watch?v=ZXsQAXx_ao0', 'Video inspiracional sobre hábitos saludables y superación personal en el gimnasio.');

INSERT IGNORE INTO `juego` (`idjuego`, `nombre`, `categoria`, `enlace`, `descripcion`) VALUES
(1, 'Ajedrez Clásico Online', 'Estrategia / Tablero', 'https://lichess.org/', 'Juego tradicional de estrategia en tablero para ejercitar la mente entre sesiones.'),
(2, 'Tres en Raya (Tic-Tac-Toe)', 'Clásico / Rápido', 'https://playtictactoe.org/', 'Juego tradicional básico y rápido para partidas cortas durante el tiempo de descanso.'),
(3, 'Sudoku Clásico', 'Lógica / Números', 'https://sudoku.com/es', 'Rompecabezas numérico tradicional para estimular la concentración y memoria.'),
(4, 'Damas Tradicionales', 'Tablero / Estrategia', 'https://cardgames.io/checkers/', 'Juego tradicional de damas en tablero de 64 casillas.'),
(5, 'Solitario Clásico (Klondike)', 'Cartas / Tradicional', 'https://cardgames.io/solitaire/', 'Juego tradicional de cartas ideal para relajación mental.');

INSERT IGNORE INTO `podcast` (`idpodcast`, `nombre`, `presentador`, `tema`, `enlace`, `descripcion`) VALUES
(1, 'Nutrición Deportiva y Ganancia Muscular', 'Fitness Revolucionario', 'Nutrición y Salud', 'https://open.spotify.com/show/2beN17eac98fC5C6K26U3j', 'Episodios sobre alimentación basada en evidencia, hipertrofia y metabolismo.'),
(2, 'Hábitos Atómicos y Salud Mental', 'Entiende Tu Mente', 'Bienestar y Psicología', 'https://open.spotify.com/show/0sGGLIDnnijRPLef7InllD', 'Consejos prácticos para mantener la adherencia al ejercicio y reducir el estrés.'),
(3, 'Longevidad, Sueño y Recuperación Física', 'Dr. Andrew Huberman / Salud', 'Ciencia y Rendimiento', 'https://www.youtube.com/@hubermanlab', 'Protocolos científicos para optimizar el descanso nocturno y la energía diaria.');

INSERT IGNORE INTO `entretenimientomusica` (`identretenimientomusica`, `identretenimiento`, `idmusica`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4),
(4, 2, 3),
(5, 3, 1),
(6, 3, 3);

INSERT IGNORE INTO `entretenimientovideo` (`identretenimientovideo`, `identretenimiento`, `idvideo`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 3, 1),
(5, 3, 3);

INSERT IGNORE INTO `entretenimientojuego` (`identretenimientojuego`, `identretenimiento`, `idjuego`) VALUES
(1, 2, 1),
(2, 2, 2),
(3, 2, 3),
(4, 2, 4),
(5, 2, 5),
(6, 3, 1),
(7, 3, 3);

INSERT IGNORE INTO `entretenimientopodcast` (`identretenimientopodcast`, `identretenimiento`, `idpodcast`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 1),
(4, 3, 2),
(5, 3, 3);
