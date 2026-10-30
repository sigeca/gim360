-- ==============================================================================
-- Migración: Vinculación de Músculos y Ejercicios para Bicicleta Estática y Air Bike
-- Equipos:
--   - idequipo = 2:  Bicicleta Estática Spinning Pro (EQ-002)
--   - idequipo = 18: Bicicleta de Aire (Air Bike) (EQ-017)
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Insertar relaciones en equipomusculo para Bicicleta Estática Spinning Pro (idequipo = 2)
-- Músculos involucrados:
--   6: Cuádriceps
--   18: Isquiotibiales
--   16: Glúteo Mayor
--   15: Gastrocnemio (Gemelos)
--   24: Sóleo
--   13: Flexores de Cadera
--   21: Recto Abdominal
INSERT IGNORE INTO `equipomusculo` (`idequipo`, `idmusculo`) VALUES
(2, 6),
(2, 18),
(2, 16),
(2, 15),
(2, 24),
(2, 13),
(2, 21);

-- 2. Insertar relaciones en equipomusculo para Bicicleta de Aire (Air Bike) (idequipo = 18)
-- Músculos involucrados (Tren inferior + Tren superior + Core):
--   6: Cuádriceps
--   18: Isquiotibiales
--   16: Glúteo Mayor
--   15: Gastrocnemio (Gemelos)
--   24: Sóleo
--   13: Flexores de Cadera
--   7: Deltoides Anterior
--   20: Pectoral Mayor
--   27: Tríceps Braquial
--   10: Dorsal Ancho
--   3: Bíceps Braquial
--   22: Romboides
--   21: Recto Abdominal
--   19: Oblicuos
INSERT IGNORE INTO `equipomusculo` (`idequipo`, `idmusculo`) VALUES
(18, 6),
(18, 18),
(18, 16),
(18, 15),
(18, 24),
(18, 13),
(18, 7),
(18, 20),
(18, 27),
(18, 10),
(18, 3),
(18, 22),
(18, 21),
(18, 19);

-- 3. Crear ejercicios correspondientes en la tabla ejercicio si no existen
INSERT INTO `ejercicio` (`nombreespanol`, `nombreingles`, `descripcion`, `urlvideo`, `imagen`)
SELECT 'Pedaleo en Bicicleta Estática (Spinning)', 
       'Stationary Bike Cycling', 
       'Entrenamiento cardiovascular y de resistencia en bicicleta estática/spinning. Desarrolla potencia en el tren inferior (cuádriceps, glúteos, isquiotibiales y gemelos) con bajo impacto articular.', 
       '', 
       ''
WHERE NOT EXISTS (
    SELECT 1 FROM `ejercicio` WHERE `nombreespanol` = 'Pedaleo en Bicicleta Estática (Spinning)'
);

INSERT INTO `ejercicio` (`nombreespanol`, `nombreingles`, `descripcion`, `urlvideo`, `imagen`)
SELECT 'Sprint en Bicicleta de Aire (Air Bike HIIT)', 
       'Air Bike HIIT Sprints', 
       'Ejercicio metabólico de cuerpo entero en bicicleta de aire. Combina pedaleo potente con empuje y tirón sincronizado de brazos, reclutando piernas, pecho, espalda, hombros, brazos y core.', 
       '', 
       ''
WHERE NOT EXISTS (
    SELECT 1 FROM `ejercicio` WHERE `nombreespanol` = 'Sprint en Bicicleta de Aire (Air Bike HIIT)'
);

-- 4. Vincular ejercicios creados con los equipos respectivos en ejercicioequipo
SET @id_ej_spinning = (SELECT `idejercicio` FROM `ejercicio` WHERE `nombreespanol` = 'Pedaleo en Bicicleta Estática (Spinning)' LIMIT 1);
SET @id_ej_airbike  = (SELECT `idejercicio` FROM `ejercicio` WHERE `nombreespanol` = 'Sprint en Bicicleta de Aire (Air Bike HIIT)' LIMIT 1);

INSERT IGNORE INTO `ejercicioequipo` (`idejercicio`, `idequipo`) VALUES
(@id_ej_spinning, 2),
(@id_ej_airbike, 18);

-- 5. Vincular músculos a los ejercicios en musculoejercicio
-- Músculos Spinning
INSERT IGNORE INTO `musculoejercicio` (`idejercicio`, `idmusculo`) VALUES
(@id_ej_spinning, 6),
(@id_ej_spinning, 18),
(@id_ej_spinning, 16),
(@id_ej_spinning, 15),
(@id_ej_spinning, 24),
(@id_ej_spinning, 13),
(@id_ej_spinning, 21);

-- Músculos Air Bike
INSERT IGNORE INTO `musculoejercicio` (`idejercicio`, `idmusculo`) VALUES
(@id_ej_airbike, 6),
(@id_ej_airbike, 18),
(@id_ej_airbike, 16),
(@id_ej_airbike, 15),
(@id_ej_airbike, 24),
(@id_ej_airbike, 13),
(@id_ej_airbike, 7),
(@id_ej_airbike, 20),
(@id_ej_airbike, 27),
(@id_ej_airbike, 10),
(@id_ej_airbike, 3),
(@id_ej_airbike, 22),
(@id_ej_airbike, 21),
(@id_ej_airbike, 19);

SET FOREIGN_KEY_CHECKS = 1;
