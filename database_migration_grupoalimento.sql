-- ==============================================================================
-- Migración: Tabla grupoalimento para la Clasificación de Alimentos
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `grupoalimento` (
  `idgrupoalimento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`idgrupoalimento`),
  UNIQUE KEY `uk_grupoalimento_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad
CREATE OR REPLACE VIEW `GrupoAlimento` AS
SELECT `idgrupoalimento`, `nombre`, `descripcion`
FROM `grupoalimento`;

-- Grupos de alimentos base de la nutrición humana y deportiva
INSERT IGNORE INTO `grupoalimento` (`idgrupoalimento`, `nombre`, `descripcion`) VALUES
(1, 'Proteínas (Carnes, Pescados y Huevos)', 'Alimentos con alto valor biológico fundamentales para el desarrollo, recuperación y mantenimiento de la masa muscular.'),
(2, 'Lácteos y Derivados', 'Leche, quesos, yogur y derivados ricos en calcio, proteínas de lenta y rápida asimilación (caseína y suero) y vitamina D.'),
(3, 'Cereales, Granos y Tubérculos', 'Avena, arroz, quinua, pasta, papas y camote. Fuentes principales de carbohidratos complejos y energía para el entrenamiento.'),
(4, 'Legumbres y Semillas', 'Lentejas, garbanzos, frijoles, chía y lino. Aportan fibra, carbohidratos de bajo índice glucémico y proteínas vegetales.'),
(5, 'Frutas', 'Plátano, manzana, frutos rojos, cítricos. Ricas en vitaminas, minerales, antioxidantes y fructosa para recarga de glucógeno.'),
(6, 'Verduras y Hortalizas', 'Espinacas, brócoli, zanahorias, lechuga. Aporte esencial de micronutrientes, fitonutrientes, fibra y baja densidad calórica.'),
(7, 'Grasas y Aceites Saludables', 'Aguacate, aceite de oliva virgen extra, frutos secos. Ácidos grasos monoinsaturados y poliinsaturados esenciales para el sistema hormonal.'),
(8, 'Suplementación Deportiva', 'Proteína de suero (whey), creatina, aminoácidos, multivitamínicos y electrolitos para complementar la dieta.');
