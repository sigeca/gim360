-- ==========================================================
-- SCRIPT DE MIGRACIÓN PARA ACTUALIZACIÓN DE SERVIDOR (GIM360)
-- Corrige tabla equipo, idequipo, equipomusculo y disponibilidadequipo
-- ==========================================================

-- 1. Deshabilitar revisión de claves foráneas temporalmente para migración limpia
SET FOREIGN_KEY_CHECKS = 0;

-- 2. Modificar ejercicioequipo si existe la FK anterior fk_ee_equipo
DROP PROCEDURE IF EXISTS `sp_migrar_gim360`;
DELIMITER $$
CREATE PROCEDURE `sp_migrar_gim360`()
BEGIN
    -- A. Renombrar equipos -> equipo si aún no se ha renombrado
    IF EXISTS (
        SELECT 1 FROM information_schema.TABLES 
        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'equipos' AND TABLE_TYPE = 'BASE TABLE'
    ) THEN
        -- Eliminar FKs que apuntaban a equipos si existen
        IF EXISTS (
            SELECT 1 FROM information_schema.TABLE_CONSTRAINTS 
            WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'ejercicioequipo' AND CONSTRAINT_NAME = 'fk_ee_equipo'
        ) THEN
            ALTER TABLE `ejercicioequipo` DROP FOREIGN KEY `fk_ee_equipo`;
        END IF;

        -- Renombrar columna id_equipo a idequipo si existe
        IF EXISTS (
            SELECT 1 FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'equipos' AND COLUMN_NAME = 'id_equipo'
        ) THEN
            ALTER TABLE `equipos` CHANGE COLUMN `id_equipo` `idequipo` INT(11) NOT NULL AUTO_INCREMENT;
        END IF;

        -- Renombrar tabla
        RENAME TABLE `equipos` TO `equipo`;
    END IF;

    -- B. Asegurar que idequipo existe en tabla equipo
    IF EXISTS (
        SELECT 1 FROM information_schema.COLUMNS 
        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'equipo' AND COLUMN_NAME = 'id_equipo'
    ) THEN
        ALTER TABLE `equipo` CHANGE COLUMN `id_equipo` `idequipo` INT(11) NOT NULL AUTO_INCREMENT;
    END IF;

    -- C. Crear tabla disponibilidadequipo
    CREATE TABLE IF NOT EXISTS `disponibilidadequipo` (
      `iddisponibilidadequipo` int(11) NOT NULL AUTO_INCREMENT,
      `nombre` varchar(50) NOT NULL,
      PRIMARY KEY (`iddisponibilidadequipo`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

    -- D. Agregar columna iddisponibilidadequipo a equipo si no existe
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.COLUMNS 
        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'equipo' AND COLUMN_NAME = 'iddisponibilidadequipo'
    ) THEN
        ALTER TABLE `equipo` ADD COLUMN `iddisponibilidadequipo` INT(11) DEFAULT 1 AFTER `id_estado`;
    END IF;

    -- E. Crear tabla equipomusculo
    CREATE TABLE IF NOT EXISTS `equipomusculo` (
      `idequipomusculo` int(11) NOT NULL AUTO_INCREMENT,
      `idequipo` int(11) NOT NULL,
      `idmusculo` int(11) NOT NULL,
      PRIMARY KEY (`idequipomusculo`),
      UNIQUE KEY `uk_equipo_musculo` (`idequipo`, `idmusculo`),
      KEY `fk_em_equipo` (`idequipo`),
      KEY `fk_em_musculo` (`idmusculo`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

END$$
DELIMITER ;

-- Ejecutar el procedimiento
CALL `sp_migrar_gim360`();
DROP PROCEDURE IF EXISTS `sp_migrar_gim360`;

-- 3. Poblar datos iniciales de disponibilidadequipo
INSERT INTO `disponibilidadequipo` (`iddisponibilidadequipo`, `nombre`) VALUES
(1, 'Disponible'),
(2, 'En Uso'),
(3, 'En Mantenimiento'),
(4, 'En Reparación'),
(5, 'Fuera de Servicio'),
(6, 'Reservado')
ON DUPLICATE KEY UPDATE `nombre` = VALUES(`nombre`);

-- 4. Actualizar equipos existentes sin estado de disponibilidad
UPDATE `equipo` SET `iddisponibilidadequipo` = 1 WHERE `iddisponibilidadequipo` IS NULL;

-- 5. Poblar relaciones automáticas iniciales en equipomusculo desde ejercicios existentes
INSERT IGNORE INTO `equipomusculo` (`idequipo`, `idmusculo`)
SELECT DISTINCT ee.idequipo, me.idmusculo
FROM `ejercicioequipo` ee
JOIN `musculoejercicio` me ON me.idejercicio = ee.idejercicio
ORDER BY ee.idequipo, me.idmusculo;

-- 6. Crear vistas de compatibilidad y nombres canónicos
CREATE OR REPLACE VIEW `DisponibilidadEquipo` AS
SELECT `iddisponibilidadequipo`, `nombre`
FROM `disponibilidadequipo`;

CREATE OR REPLACE VIEW `EquipoMusculo` AS
SELECT `idequipomusculo`, `idequipo`, `idmusculo`
FROM `equipomusculo`;

CREATE OR REPLACE VIEW `equipos` AS 
SELECT `idequipo` AS `id_equipo`, `idequipo`, `codigo`, `nombre`, `imagen`, `id_tipo`, `id_marca`, `modelo`, `numero_serie`, `descripcion`, `id_ubicacion`, `fecha_adquisicion`, `valor_adquisicion`, `id_estado`, `iddisponibilidadequipo`, `activo`, `observaciones`, `fecha_registro` 
FROM `equipo`;

-- 7. Restaurar claves foráneas
ALTER TABLE `ejercicioequipo` DROP FOREIGN KEY IF EXISTS `fk_ee_equipo`;
ALTER TABLE `ejercicioequipo` ADD CONSTRAINT `fk_ee_equipo` FOREIGN KEY (`idequipo`) REFERENCES `equipo` (`idequipo`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `equipo` DROP FOREIGN KEY IF EXISTS `fk_equipo_disponibilidad`;
ALTER TABLE `equipo` ADD CONSTRAINT `fk_equipo_disponibilidad` FOREIGN KEY (`iddisponibilidadequipo`) REFERENCES `disponibilidadequipo` (`iddisponibilidadequipo`) ON UPDATE CASCADE ON DELETE SET NULL;

ALTER TABLE `equipomusculo` DROP FOREIGN KEY IF EXISTS `fk_em_equipo`;
ALTER TABLE `equipomusculo` ADD CONSTRAINT `fk_em_equipo` FOREIGN KEY (`idequipo`) REFERENCES `equipo` (`idequipo`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `equipomusculo` DROP FOREIGN KEY IF EXISTS `fk_em_musculo`;
ALTER TABLE `equipomusculo` ADD CONSTRAINT `fk_em_musculo` FOREIGN KEY (`idmusculo`) REFERENCES `musculo` (`idmusculo`) ON DELETE CASCADE ON UPDATE CASCADE;

SET FOREIGN_KEY_CHECKS = 1;
