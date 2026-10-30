-- ==============================================================================
-- Migración: Tabla planalimentacion para Planes de Alimentación Nutricional
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `planalimentacion` (
  `idplanalimentacion` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `fechainicio` date NOT NULL,
  `fechafin` date DEFAULT NULL,
  `objetivo` text DEFAULT NULL,
  PRIMARY KEY (`idplanalimentacion`),
  KEY `fk_planalimentacion_persona` (`idpersona`),
  CONSTRAINT `fk_planalimentacion_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad
CREATE OR REPLACE VIEW `PlanAlimentacion` AS
SELECT `idplanalimentacion`, `idpersona`, `nombre`, `fechainicio`, `fechafin`, `objetivo`
FROM `planalimentacion`;

-- Datos de ejemplo iniciales
INSERT INTO `planalimentacion` (`idpersona`, `nombre`, `fechainicio`, `fechafin`, `objetivo`)
SELECT 1, 'Plan de Definición y Rendimiento Físico', '2026-10-01', '2026-12-31', 'Reducción progresiva de porcentaje graso corporal manteniendo masa muscular magra y optimizando el rendimiento atlético.'
WHERE NOT EXISTS (SELECT 1 FROM `planalimentacion` WHERE `idpersona` = 1 AND `nombre` = 'Plan de Definición y Rendimiento Físico');

INSERT INTO `planalimentacion` (`idpersona`, `nombre`, `fechainicio`, `fechafin`, `objetivo`)
SELECT 2, 'Plan de Tonificación y Recomposición Corporal', '2026-09-15', '2026-11-30', 'Aumento de ingesta de proteínas de alto valor biológico, balance calórico equilibrado y control de micronutrientes.'
WHERE NOT EXISTS (SELECT 1 FROM `planalimentacion` WHERE `idpersona` = 2 AND `nombre` = 'Plan de Tonificación y Recomposición Corporal');

INSERT INTO `planalimentacion` (`idpersona`, `nombre`, `fechainicio`, `fechafin`, `objetivo`)
SELECT 3, 'Plan Hipertrofia y Superávit Calórico', '2026-10-15', '2027-01-15', 'Superávit calórico controlado (+350 kcal) para estimular hipertrofia muscular y recuperación post-entrenamiento de fuerza.'
WHERE NOT EXISTS (SELECT 1 FROM `planalimentacion` WHERE `idpersona` = 3 AND `nombre` = 'Plan Hipertrofia y Superávit Calórico');
