-- =====================================================================
-- Migración: Garantizar un solo programa de entrenamiento activo por cliente
-- Base de Datos: gim360
-- Tabla: programacliente
-- =====================================================================

-- Actualizar a estado 'Pausado' (idestadoprogramacliente = 4)
-- los programas activos más antiguos de cada cliente que tenga más de un programa activo (idestadoprogramacliente = 1),
-- dejando únicamente el más reciente activo.

UPDATE `programacliente` pc
JOIN (
    SELECT idcliente, MAX(idprogramacliente) AS max_id
    FROM `programacliente`
    WHERE `idestadoprogramacliente` = 1
    GROUP BY idcliente
    HAVING COUNT(*) > 1
) multi ON pc.idcliente = multi.idcliente
SET pc.idestadoprogramacliente = 4
WHERE pc.idestadoprogramacliente = 1
  AND pc.idprogramacliente < multi.max_id;
