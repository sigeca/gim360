-- ==============================================================================
-- Migración: Agregar columna 'video' a tabla 'equipo' y actualizar vista 'equipos'
-- Permite almacenar la URL de YouTube que explica el uso y guía de cada equipo.
-- ==============================================================================

-- 1. Agregar columna 'video' a la tabla 'equipo'
ALTER TABLE `equipo` 
  ADD COLUMN IF NOT EXISTS `video` VARCHAR(300) DEFAULT NULL AFTER `imagen`;

-- 2. Actualizar la vista 'equipos' para incluir la columna 'video'
CREATE OR REPLACE VIEW `equipos` AS 
SELECT `idequipo` AS `id_equipo`, 
       `idequipo`, 
       `codigo`, 
       `nombre`, 
       `imagen`, 
       `video`, 
       `id_tipo`, 
       `id_marca`, 
       `modelo`, 
       `numero_serie`, 
       `descripcion`, 
       `id_ubicacion`, 
       `fecha_adquisicion`, 
       `valor_adquisicion`, 
       `id_estado`, 
       `iddisponibilidadequipo`, 
       `activo`, 
       `observaciones`, 
       `fecha_registro` 
FROM `equipo`;
