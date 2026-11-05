-- ==============================================================================
-- Migración GIM360: Registro de Máquina Pulldown (Jalón al Pecho) y Ejercicios
-- Basada en Video de Entrenamiento en Gimnasio (WhatsApp Video 2026-11-05)
-- ==============================================================================

START TRANSACTION;

-- 1. Incorporar la Máquina de Jalón al Pecho Selectorizada (Pulldown Machine) en `equipo`
INSERT INTO `equipo` (
  `codigo`, `nombre`, `imagen`, `id_tipo`, `id_marca`, `modelo`,
  `numero_serie`, `descripcion`, `id_ubicacion`, `fecha_adquisicion`,
  `valor_adquisicion`, `id_estado`, `iddisponibilidadequipo`, `activo`, `observaciones`, `fecha_registro`
)
SELECT 'EQ-062', 'Máquina de Jalón al Pecho (Pulldown Machine)', 'pulldown_machine.webp', 2, 1, 'Gim360 Pro Selectorized',
       NULL, 'Máquina selectorizada comercial de jalón al pecho (Pulldown Machine) con torre de placas de peso, rodillos ajustables de fijación para muslos, asiento ergonómico y polea alta para desarrollo muscular integral de la espalda y brazos.',
       2, '2026-11-05', 950.00, 1, 1, 1, 'Máquina comercial de jalón al pecho con torre de placas de peso y rodillos de sujeción.', NOW()
WHERE NOT EXISTS (
  SELECT 1 FROM `equipo` WHERE `codigo` = 'EQ-062' OR `imagen` = 'pulldown_machine.webp'
);

-- Asegurar actualización de imagen en caso de registro preexistente
UPDATE `equipo`
SET `imagen` = 'pulldown_machine.webp'
WHERE `codigo` = 'EQ-062';

-- Obtener el ID de la máquina recién registrada (EQ-062)
SET @idequipo_pulldown = (SELECT `idequipo` FROM `equipo` WHERE `codigo` = 'EQ-062' OR `imagen` = 'pulldown_machine.webp' LIMIT 1);

-- 2. Registrar el Ejercicio del Video Real en `ejercicio`
INSERT INTO `ejercicio` (`nombreespanol`, `nombreingles`, `descripcion`, `urlvideo`, `imagen`)
SELECT 'Jalón al Pecho en Pulldown Machine (Ejecución Real en Video)', 'Machine Lat Pulldown Execution',
       'Demostración y ejecución real del ejercicio de jalón al pecho con agarre prono ancho en máquina selectorizada Pulldown Machine. Fortalece el dorsal ancho, redondo mayor, romboides, trapecio medio e inferior y bíceps braquial con máxima estabilidad en el tren inferior.',
       'https://educaysoft.org/gim360/repositorio/ejercicios/01_jalon_pecho_video_real.webp', '01_jalon_pecho_video_real.webp'
WHERE NOT EXISTS (
  SELECT 1 FROM `ejercicio` WHERE `imagen` = '01_jalon_pecho_video_real.webp' OR `nombreespanol` LIKE 'Jalón al Pecho en Pulldown Machine%'
);

-- Actualizar si ya existía
UPDATE `ejercicio`
SET `imagen` = '01_jalon_pecho_video_real.webp'
WHERE `imagen` = '01_jalon_pecho_video_real.webp' OR `nombreespanol` LIKE 'Jalón al Pecho en Pulldown Machine%';

SET @idejercicio_real = (SELECT `idejercicio` FROM `ejercicio` WHERE `imagen` = '01_jalon_pecho_video_real.webp' LIMIT 1);

-- Actualizar imágenes de los ejercicios asociados de jalón para que apunten a las animaciones webp optimizadas
UPDATE `ejercicio` SET `imagen` = '02_jalon_al_pecho_prona_ancha.webp' WHERE `idejercicio` = 265;
UPDATE `ejercicio` SET `imagen` = '03_jalon_al_pecho_agarre_supino.webp' WHERE `idejercicio` = 343;
UPDATE `ejercicio` SET `imagen` = '04_jalon_al_pecho_barra_en_v.webp' WHERE `idejercicio` = 448;
UPDATE `ejercicio` SET `imagen` = '05_jalon_al_pecho_unilateral.webp' WHERE `idejercicio` = 303;
UPDATE `ejercicio` SET `imagen` = '06_jalon_al_pecho_agarre_cerrado.webp' WHERE `idejercicio` = 103;
UPDATE `ejercicio` SET `imagen` = '07_jalon_trasnuca.webp' WHERE `idejercicio` = 47;
UPDATE `ejercicio` SET `imagen` = '08_jalon_brazos_rectos.webp' WHERE `idejercicio` = 422;

-- 3. Vincular los 8 Ejercicios a la nueva Máquina EQ-062 en `ejercicioequipo`
INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT @idejercicio_real, @idequipo_pulldown
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = @idejercicio_real AND `idequipo` = @idequipo_pulldown);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 265, @idequipo_pulldown
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 265 AND `idequipo` = @idequipo_pulldown);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 343, @idequipo_pulldown
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 343 AND `idequipo` = @idequipo_pulldown);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 448, @idequipo_pulldown
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 448 AND `idequipo` = @idequipo_pulldown);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 303, @idequipo_pulldown
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 303 AND `idequipo` = @idequipo_pulldown);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 103, @idequipo_pulldown
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 103 AND `idequipo` = @idequipo_pulldown);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 47, @idequipo_pulldown
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 47 AND `idequipo` = @idequipo_pulldown);

INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 422, @idequipo_pulldown
WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 422 AND `idequipo` = @idequipo_pulldown);

-- Vincular también los ejercicios a la máquina previa EQ-049 (idequipo = 50) para redundancia
INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 265, 50 WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 265 AND `idequipo` = 50);
INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 343, 50 WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 343 AND `idequipo` = 50);
INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 303, 50 WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 303 AND `idequipo` = 50);
INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 103, 50 WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 103 AND `idequipo` = 50);
INSERT INTO `ejercicioequipo` (`idejercicio`, `idequipo`)
SELECT 422, 50 WHERE NOT EXISTS (SELECT 1 FROM `ejercicioequipo` WHERE `idejercicio` = 422 AND `idequipo` = 50);

-- 4. Vincular Músculos al Equipo EQ-062 en `equipomusculo`
-- Músculos involucrados:
-- 10: Dorsal Ancho, 22: Romboides, 26: Trapecio, 3: Bíceps Braquial, 9: Deltoides Posterior, 4: Braquial, 5: Braquiorradial, 11: Erector Espinal
INSERT INTO `equipomusculo` (`idequipo`, `idmusculo`)
SELECT @idequipo_pulldown, 10 WHERE NOT EXISTS (SELECT 1 FROM `equipomusculo` WHERE `idequipo` = @idequipo_pulldown AND `idmusculo` = 10);

INSERT INTO `equipomusculo` (`idequipo`, `idmusculo`)
SELECT @idequipo_pulldown, 22 WHERE NOT EXISTS (SELECT 1 FROM `equipomusculo` WHERE `idequipo` = @idequipo_pulldown AND `idmusculo` = 22);

INSERT INTO `equipomusculo` (`idequipo`, `idmusculo`)
SELECT @idequipo_pulldown, 26 WHERE NOT EXISTS (SELECT 1 FROM `equipomusculo` WHERE `idequipo` = @idequipo_pulldown AND `idmusculo` = 26);

INSERT INTO `equipomusculo` (`idequipo`, `idmusculo`)
SELECT @idequipo_pulldown, 3 WHERE NOT EXISTS (SELECT 1 FROM `equipomusculo` WHERE `idequipo` = @idequipo_pulldown AND `idmusculo` = 3);

INSERT INTO `equipomusculo` (`idequipo`, `idmusculo`)
SELECT @idequipo_pulldown, 9 WHERE NOT EXISTS (SELECT 1 FROM `equipomusculo` WHERE `idequipo` = @idequipo_pulldown AND `idmusculo` = 9);

INSERT INTO `equipomusculo` (`idequipo`, `idmusculo`)
SELECT @idequipo_pulldown, 4 WHERE NOT EXISTS (SELECT 1 FROM `equipomusculo` WHERE `idequipo` = @idequipo_pulldown AND `idmusculo` = 4);

INSERT INTO `equipomusculo` (`idequipo`, `idmusculo`)
SELECT @idequipo_pulldown, 5 WHERE NOT EXISTS (SELECT 1 FROM `equipomusculo` WHERE `idequipo` = @idequipo_pulldown AND `idmusculo` = 5);

INSERT INTO `equipomusculo` (`idequipo`, `idmusculo`)
SELECT @idequipo_pulldown, 11 WHERE NOT EXISTS (SELECT 1 FROM `equipomusculo` WHERE `idequipo` = @idequipo_pulldown AND `idmusculo` = 11);

-- 5. Vincular Músculos al Ejercicio del Video Real en `musculoejercicio`
INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @idejercicio_real, 10 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @idejercicio_real AND `idmusculo` = 10);

INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @idejercicio_real, 22 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @idejercicio_real AND `idmusculo` = 22);

INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @idejercicio_real, 26 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @idejercicio_real AND `idmusculo` = 26);

INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @idejercicio_real, 3 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @idejercicio_real AND `idmusculo` = 3);

INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @idejercicio_real, 9 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @idejercicio_real AND `idmusculo` = 9);

INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @idejercicio_real, 4 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @idejercicio_real AND `idmusculo` = 4);

INSERT INTO `musculoejercicio` (`idejercicio`, `idmusculo`)
SELECT @idejercicio_real, 5 WHERE NOT EXISTS (SELECT 1 FROM `musculoejercicio` WHERE `idejercicio` = @idejercicio_real AND `idmusculo` = 5);

COMMIT;
