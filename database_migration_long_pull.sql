-- Migración GIM360: Incorporación de Máquina Long Pull / Seated Row y 6 Ejercicios Asociados

START TRANSACTION;

-- 1. Incorporar Máquina Long Pull / Seated Row si no existe
INSERT INTO `equipos` (
  `codigo`, `nombre`, `imagen`, `id_tipo`, `id_marca`, `modelo`,
  `numero_serie`, `descripcion`, `id_ubicacion`, `fecha_adquisicion`,
  `valor_adquisicion`, `id_estado`, `activo`, `observaciones`, `fecha_registro`
)
SELECT 'EQ-061', 'Máquina de Remo Sentado (Long Pull)', 'long_pull_seated_row_machine.jpg', 2, 1, 'Gim360 Pro',
       NULL, 'Máquina de polea baja con asiento y apoyo para pies (Long Pull / Seated Row) diseñada para trabajo de espalda, dorsales, trapecio, bíceps y deltoides posterior.',
       2, '2026-10-20', 850.00, 1, 1, 'Máquina de remo sentado / polea baja con 6 ejercicios vinculados.', NOW()
WHERE NOT EXISTS (
  SELECT 1 FROM `equipos` WHERE `imagen` = 'long_pull_seated_row_machine.jpg' OR `codigo` = 'EQ-061'
);

-- Si ya existe la máquina con otro nombre o código pero con esta imagen o referencia, actualizar su imagen
UPDATE `equipos`
SET `imagen` = 'long_pull_seated_row_machine.jpg'
WHERE `codigo` = 'EQ-061';

-- Obtener el ID del equipo (Long Pull)
SET @idequipo_long_pull = (SELECT `id_equipo` FROM `equipos` WHERE `codigo` = 'EQ-061' OR `imagen` = 'long_pull_seated_row_machine.jpg' LIMIT 1);

-- 2. Ejercicio 1: Remo sentado agarre estrecho (idejercicio = 360) - Ya existe, actualizar imagen y nombre
UPDATE `ejercicio`
SET `imagen` = '01_remo_sentado_agarre_estrecho.webp',
    `nombreespanol` = 'Remo Sentado en Polea (Agarre Estrecho)'
WHERE `idejercicio` = 360;

-- 3. Ejercicio 2: Remo sentado barra ancha (idejercicio = 459) - Ya existe, actualizar imagen y nombre
UPDATE `ejercicio`
SET `imagen` = '02_remo_sentado_barra_ancha.webp',
    `nombreespanol` = 'Remo Sentado con Barra Ancha en Polea'
WHERE `idejercicio` = 459;

-- 4. Ejercicio 3: Remo Unilateral Sentado en Polea
INSERT INTO `ejercicio` (`nombreespanol`, `nombreingles`, `descripcion`, `urlvideo`, `imagen`)
SELECT 'Remo Unilateral Sentado en Polea', 'Single-Arm Seated Cable Row',
       'Variación unilateral del remo sentado en polea baja con maneral individual. Permite corregir desequilibrios musculares bilaterales y lograr un mayor rango de recorrido y contracción del dorsal ancho y romboides.',
       NULL, '03_remo_unilateral_sentado.webp'
WHERE NOT EXISTS (
  SELECT 1 FROM `ejercicio` WHERE `imagen` = '03_remo_unilateral_sentado.webp' OR `nombreingles` = 'Single-Arm Seated Cable Row'
);

SET @id_ej3 = (SELECT `idejercicio` FROM `ejercicio` WHERE `imagen` = '03_remo_unilateral_sentado.webp' LIMIT 1);

-- 5. Ejercicio 4: Face Pull Sentado con Cuerda
INSERT INTO `ejercicio` (`nombreespanol`, `nombreingles`, `descripcion`, `urlvideo`, `imagen`)
SELECT 'Face Pull Sentado con Cuerda', 'Seated Cable Rope Face Pull',
       'Variación de face pull ejecutada sentado en máquina de polea baja / remo con agarre de cuerda hacia el rostro. Enfocada en el aislamiento del deltoides posterior, manguito rotador externo y trapecio medio/superior.',
       NULL, '04_face_pull_sentado_cuerda.webp'
WHERE NOT EXISTS (
  SELECT 1 FROM `ejercicio` WHERE `imagen` = '04_face_pull_sentado_cuerda.webp' OR `nombreingles` = 'Seated Cable Rope Face Pull'
);

SET @id_ej4 = (SELECT `idejercicio` FROM `ejercicio` WHERE `imagen` = '04_face_pull_sentado_cuerda.webp' LIMIT 1);

-- 6. Ejercicio 5: Curl de Bíceps Sentado en Polea
INSERT INTO `ejercicio` (`nombreespanol`, `nombreingles`, `descripcion`, `urlvideo`, `imagen`)
SELECT 'Curl de Bíceps Sentado en Polea', 'Seated Cable Bicep Curl',
       'Curl de bíceps ejecutado sentado en el banco de la polea baja / long pull. Asegura tensión mecánica continua durante todo el rango de flexión del codo, maximizando la activación del bíceps braquial y braquial anterior.',
       NULL, '05_curl_biceps_sentado_polea.webp'
WHERE NOT EXISTS (
  SELECT 1 FROM `ejercicio` WHERE `imagen` = '05_curl_biceps_sentado_polea.webp' OR `nombreingles` = 'Seated Cable Bicep Curl'
);

SET @id_ej5 = (SELECT `idejercicio` FROM `ejercicio` WHERE `imagen` = '05_curl_biceps_sentado_polea.webp' LIMIT 1);

-- 7. Ejercicio 6: Encogimiento de Hombros Sentado en Polea
INSERT INTO `ejercicio` (`nombreespanol`, `nombreingles`, `descripcion`, `urlvideo`, `imagen`)
SELECT 'Encogimiento de Hombros Sentado en Polea', 'Seated Cable Shrug',
       'Encogimiento de hombros para trapecios realizado sentado frente a la polea baja. Elimina la sobrecarga lumbar de las variantes de pie y enfoca la tracción vertical de las escápulas directamente en el trapecio superior.',
       NULL, '06_encogimiento_hombros_sentado.webp'
WHERE NOT EXISTS (
  SELECT 1 FROM `ejercicio` WHERE `imagen` = '06_encogimiento_hombros_sentado.webp' OR `nombreingles` = 'Seated Cable Shrug'
);

SET @id_ej6 = (SELECT `idejercicio` FROM `ejercicio` WHERE `imagen` = '06_encogimiento_hombros_sentado.webp' LIMIT 1);

-- 8. Vincular los 6 ejercicios a la Máquina Long Pull en `ejercicioequipo`
INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 360, @idequipo_long_pull
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 360 AND `idequipo` = @idequipo_long_pull);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 459, @idequipo_long_pull
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 459 AND `idequipo` = @idequipo_long_pull);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT @id_ej3, @idequipo_long_pull
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = @id_ej3 AND `idequipo` = @idequipo_long_pull);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT @id_ej4, @idequipo_long_pull
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = @id_ej4 AND `idequipo` = @idequipo_long_pull);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT @id_ej5, @idequipo_long_pull
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = @id_ej5 AND `idequipo` = @idequipo_long_pull);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT @id_ej6, @idequipo_long_pull
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = @id_ej6 AND `idequipo` = @idequipo_long_pull);

-- 9. Vincular músculos a los nuevos ejercicios en `musculoejercicio`
-- Músculos para Ejercicio 3 (Remo Unilateral): Dorsal Ancho (10), Romboides (22), Bíceps Braquial (3), Deltoides Posterior (9), Erector Espinal (11), Trapecio (26)
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej3, 10 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej3 AND `idmusculo` = 10);
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej3, 22 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej3 AND `idmusculo` = 22);
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej3, 3 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej3 AND `idmusculo` = 3);
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej3, 9 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej3 AND `idmusculo` = 9);
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej3, 11 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej3 AND `idmusculo` = 11);
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej3, 26 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej3 AND `idmusculo` = 26);

-- Músculos para Ejercicio 4 (Face Pull Sentado): Deltoides Posterior (9), Trapecio (26), Romboides (22), Deltoides Lateral (8)
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej4, 9 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej4 AND `idmusculo` = 9);
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej4, 26 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej4 AND `idmusculo` = 26);
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej4, 22 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej4 AND `idmusculo` = 22);
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej4, 8 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej4 AND `idmusculo` = 8);

-- Músculos para Ejercicio 5 (Curl Bíceps Sentado): Bíceps Braquial (3), Braquial (4), Braquiorradial (5)
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej5, 3 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej5 AND `idmusculo` = 3);
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej5, 4 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej5 AND `idmusculo` = 4);
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej5, 5 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej5 AND `idmusculo` = 5);

-- Músculos para Ejercicio 6 (Encogimiento Hombros Sentado): Trapecio (26), Romboides (22)
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej6, 26 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej6 AND `idmusculo` = 26);
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @id_ej6, 22 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @id_ej6 AND `idmusculo` = 22);

COMMIT;
