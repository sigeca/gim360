-- ==============================================================================
-- Migración: Tabla diasemana para Planificación de Entrenamientos y Dietas
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `diasemana` (
  `iddiasemana` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`iddiasemana`),
  UNIQUE KEY `uq_diasemana_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad
CREATE OR REPLACE VIEW `DiaSemana` AS
SELECT `iddiasemana`, `nombre`
FROM `diasemana`;

-- Semillas de los 7 días de la semana
INSERT INTO `diasemana` (`iddiasemana`, `nombre`) VALUES
(1, 'Lunes'),
(2, 'Martes'),
(3, 'Miércoles'),
(4, 'Jueves'),
(5, 'Viernes'),
(6, 'Sábado'),
(7, 'Domingo')
ON DUPLICATE KEY UPDATE `nombre` = VALUES(`nombre`);
