-- ==============================================================================
-- Migración: Agregar columna 'video' a tabla 'receta' y actualizar vista 'Receta'
-- Permite almacenar la URL de YouTube o video explicativo del modo de preparación de la receta.
-- ==============================================================================

-- 1. Agregar columna 'video' a la tabla 'receta'
ALTER TABLE `receta` 
  ADD COLUMN IF NOT EXISTS `video` VARCHAR(300) DEFAULT NULL AFTER `tiempopreparacion`;

-- 2. Actualizar la vista 'Receta' para incluir la columna 'video'
CREATE OR REPLACE VIEW `Receta` AS 
SELECT `idreceta`, 
       `nombre`, 
       `instrucciones`, 
       `porciones`, 
       `tiempopreparacion`, 
       `video` 
FROM `receta`;

-- 3. Videos demostrativos iniciales para recetas emblemáticas (opcional / enriquecimiento)
UPDATE `receta` 
SET `video` = 'https://www.youtube.com/watch?v=42eX_20oX54' 
WHERE `idreceta` = 1 AND (`video` IS NULL OR `video` = '');

UPDATE `receta` 
SET `video` = 'https://www.youtube.com/watch?v=mD0Vl2mIuH4' 
WHERE `idreceta` = 2 AND (`video` IS NULL OR `video` = '');

UPDATE `receta` 
SET `video` = 'https://www.youtube.com/watch?v=m53q4qH_L1k' 
WHERE `idreceta` = 3 AND (`video` IS NULL OR `video` = '');

UPDATE `receta` 
SET `video` = 'https://www.youtube.com/watch?v=Z6zV5vEwT7Y' 
WHERE `idreceta` = 4 AND (`video` IS NULL OR `video` = '');

UPDATE `receta` 
SET `video` = 'https://www.youtube.com/watch?v=1F3h3nE8w8Y' 
WHERE `idreceta` = 5 AND (`video` IS NULL OR `video` = '');

UPDATE `receta` 
SET `video` = 'https://www.youtube.com/watch?v=8V7ZkH0_gD4' 
WHERE `idreceta` = 6 AND (`video` IS NULL OR `video` = '');

UPDATE `receta` 
SET `video` = 'https://www.youtube.com/watch?v=5U0h3_x2_j0' 
WHERE `idreceta` = 7 AND (`video` IS NULL OR `video` = '');

UPDATE `receta` 
SET `video` = 'https://www.youtube.com/watch?v=kY67Z3-5qR4' 
WHERE `idreceta` = 8 AND (`video` IS NULL OR `video` = '');

UPDATE `receta` 
SET `video` = 'https://www.youtube.com/watch?v=wXW01mGqP7s' 
WHERE `idreceta` = 9 AND (`video` IS NULL OR `video` = '');
