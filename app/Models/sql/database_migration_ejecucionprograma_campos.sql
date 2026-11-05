-- ==============================================================================
-- Migración: Incorporar campos series, repeticiones, tiempodescanso y peso en ejecucionprograma
-- Permite registrar el esfuerzo, volumen de entrenamiento y descansos realizados al ejecutar un ejercicio de un plan.
-- ==============================================================================

-- 1. Agregar las nuevas columnas a la tabla ejecucionprograma
ALTER TABLE `ejecucionprograma`
  ADD COLUMN IF NOT EXISTS `series` INT(11) DEFAULT NULL AFTER `horafin`,
  ADD COLUMN IF NOT EXISTS `repeticiones` INT(11) DEFAULT NULL AFTER `series`,
  ADD COLUMN IF NOT EXISTS `tiempodescanso` INT(11) DEFAULT NULL AFTER `repeticiones`,
  ADD COLUMN IF NOT EXISTS `peso` DECIMAL(8,2) DEFAULT NULL AFTER `tiempodescanso`;

-- 2. Retrocompatibilidad: poblar registros históricos a partir de los planes de entrenamiento asignados (planes estándar)
UPDATE `ejecucionprograma` ep
JOIN `programacliente` pc ON pc.idprogramacliente = ep.idprogramacliente
JOIN `rutinaprograma` rp ON rp.idprogramaentrenamiento = pc.idprogramaentrenamiento
JOIN `rutinaplan` rpl ON rpl.idrutinaejercicio = rp.idrutinaejercicio
JOIN `planejercicio` pe ON pe.idplanejercicio = rpl.idplanejercicio AND pe.idejercicio = ep.idejercicio
SET ep.series = COALESCE(ep.series, pe.series),
    ep.repeticiones = COALESCE(ep.repeticiones, pe.repeticiones),
    ep.tiempodescanso = COALESCE(ep.tiempodescanso, pe.tiempodescanso),
    ep.peso = COALESCE(ep.peso, pe.peso);

-- 3. Retrocompatibilidad: poblar registros históricos a partir de planes personalizados
UPDATE `ejecucionprograma` ep
JOIN `programacliente` pc ON pc.idprogramacliente = ep.idprogramacliente
JOIN `rutinaprogramapersonalizado` rpp ON rpp.idprogramapersonalizado = pc.idprogramapersonalizado
JOIN `rutinaplanpersonalizado` rplp ON rplp.idrutinapersonalizada = rpp.idrutinapersonalizada
JOIN `planejerciciopersonalizado` pep ON pep.idplanpersonalizado = rplp.idplanpersonalizado AND pep.idejercicio = ep.idejercicio
SET ep.series = COALESCE(ep.series, pep.series),
    ep.repeticiones = COALESCE(ep.repeticiones, pep.repeticiones),
    ep.tiempodescanso = COALESCE(ep.tiempodescanso, pep.tiempodescanso),
    ep.peso = COALESCE(ep.peso, pep.peso);
