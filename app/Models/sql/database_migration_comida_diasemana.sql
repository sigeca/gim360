-- ==============================================================================
-- Migración: Incorporar campo iddiasemana a la tabla comida para Gim360
-- ==============================================================================
-- Permite organizar las comidas del plan de alimentación por día de la semana.
-- ==============================================================================

-- 1. Agregar columna iddiasemana si no existe
SET @colExists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() 
      AND TABLE_NAME = 'comida' 
      AND COLUMN_NAME = 'iddiasemana'
);

SET @sqlAddCol = IF(@colExists = 0, 
    'ALTER TABLE `comida` ADD COLUMN `iddiasemana` int(11) DEFAULT NULL AFTER `idplanalimentacion`', 
    'SELECT "Columna iddiasemana ya existe en comida"'
);
PREPARE stmtCol FROM @sqlAddCol;
EXECUTE stmtCol;
DEALLOCATE PREPARE stmtCol;

-- 2. Asignar día por defecto (1 = Lunes) a registros existentes que no tengan día
UPDATE `comida` SET `iddiasemana` = 1 WHERE `iddiasemana` IS NULL;

-- 3. Crear índice si no existe
SET @idxExists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.STATISTICS 
    WHERE TABLE_SCHEMA = DATABASE() 
      AND TABLE_NAME = 'comida' 
      AND INDEX_NAME = 'fk_comida_diasemana'
);
SET @sqlAddIdx = IF(@idxExists = 0,
    'ALTER TABLE `comida` ADD KEY `fk_comida_diasemana` (`iddiasemana`)',
    'SELECT "Índice fk_comida_diasemana ya existe"'
);
PREPARE stmtIdx FROM @sqlAddIdx;
EXECUTE stmtIdx;
DEALLOCATE PREPARE stmtIdx;

-- 4. Agregar constraint de Foreign Key si no existe
SET @fkExists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS 
    WHERE TABLE_SCHEMA = DATABASE() 
      AND TABLE_NAME = 'comida' 
      AND CONSTRAINT_NAME = 'fk_comida_diasemana'
);
SET @sqlAddFk = IF(@fkExists = 0,
    'ALTER TABLE `comida` ADD CONSTRAINT `fk_comida_diasemana` FOREIGN KEY (`iddiasemana`) REFERENCES `diasemana` (`iddiasemana`) ON UPDATE CASCADE ON DELETE SET NULL',
    'SELECT "Constraint fk_comida_diasemana ya existe"'
);
PREPARE stmtFk FROM @sqlAddFk;
EXECUTE stmtFk;
DEALLOCATE PREPARE stmtFk;

-- 5. Actualizar vista de compatibilidad
CREATE OR REPLACE VIEW `Comida` AS
SELECT `idcomida`, `idplanalimentacion`, `iddiasemana`, `idtipocomida`, `idreceta`, `horarecomendada`
FROM `comida`;
