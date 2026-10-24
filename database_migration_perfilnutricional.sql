-- ==============================================================================
-- Migración: Tabla perfilnutricional para el Control Nutricional de Personas
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `perfilnutricional` (
  `idperfilnutricional` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  `peso_kg` decimal(5,2) NOT NULL,
  `estatura_cm` decimal(5,2) NOT NULL,
  `fechamedicion` date DEFAULT (CURRENT_DATE),
  `porcentajegrasa` decimal(4,1) DEFAULT NULL,
  `porcentajemusculo` decimal(4,1) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`idperfilnutricional`),
  KEY `fk_pn_persona` (`idpersona`),
  CONSTRAINT `fk_pn_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad
CREATE OR REPLACE VIEW `PerfilNutricional` AS
SELECT `idperfilnutricional`, `idpersona`, `peso_kg`, `estatura_cm`, `fechamedicion`, `porcentajegrasa`, `porcentajemusculo`, `observaciones`
FROM `perfilnutricional`;

-- Datos de ejemplo iniciales para personas existentes si la tabla está vacía
INSERT INTO `perfilnutricional` (`idpersona`, `peso_kg`, `estatura_cm`, `fechamedicion`, `porcentajegrasa`, `porcentajemusculo`, `observaciones`)
SELECT 1, 74.50, 172.00, CURDATE(), 18.5, 38.0, 'Evaluación inicial de ingreso. Buen estado físico general.'
WHERE NOT EXISTS (SELECT 1 FROM `perfilnutricional` WHERE `idpersona` = 1);

INSERT INTO `perfilnutricional` (`idpersona`, `peso_kg`, `estatura_cm`, `fechamedicion`, `porcentajegrasa`, `porcentajemusculo`, `observaciones`)
SELECT 2, 61.20, 163.00, CURDATE(), 23.0, 31.5, 'Control nutricional para tonificación muscular.'
WHERE NOT EXISTS (SELECT 1 FROM `perfilnutricional` WHERE `idpersona` = 2);
