-- ==============================================================================
-- Migración: Tabla tipocomida para Tipos / Tiempos de Comida Nutricionales
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `tipocomida` (
  `idtipocomida` int(11) NOT NULL AUTO_INCREMENT,
  `idtipocommida` int(11) GENERATED ALWAYS AS (`idtipocomida`) VIRTUAL,
  `nombre` varchar(60) NOT NULL,
  PRIMARY KEY (`idtipocomida`),
  UNIQUE KEY `uq_tipocomida_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad
CREATE OR REPLACE VIEW `TipoComida` AS
SELECT `idtipocomida`, `idtipocommida`, `nombre`
FROM `tipocomida`;

-- Inserción de tipos de comida estándar para nutrición y fitness
INSERT INTO `tipocomida` (`nombre`) VALUES
('Desayuno'),
('Media Mañana (Snack 1)'),
('Almuerzo'),
('Merienda (Snack 2)'),
('Pre-Entrenamiento'),
('Post-Entrenamiento'),
('Cena'),
('Colación Nocturna')
ON DUPLICATE KEY UPDATE `nombre` = VALUES(`nombre`);
