-- ==============================================================================
-- Migración: Tabla componentenutricional para Gim360
-- ==============================================================================
-- Este script es seguro e idempotente. Puede ejecutarse en local y en la nube
-- tantas veces como sea necesario SIN afectar ni borrar datos existentes.
-- ==============================================================================

-- 1. Crear la tabla componentenutricional si no existe
CREATE TABLE IF NOT EXISTS `componentenutricional` (
  `idcomponentenutricional` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`idcomponentenutricional`),
  UNIQUE KEY `uk_componentenutricional_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- 2. Vista de compatibilidad para evitar problemas de mayúsculas/minúsculas
CREATE OR REPLACE VIEW `ComponenteNutricional` AS
SELECT `idcomponentenutricional`, `nombre`, `descripcion`
FROM `componentenutricional`;

-- 3. Inserción de componentes nutricionales base (macronutrientes y micronutrientes esenciales)
-- Usamos INSERT IGNORE para no sobreescribir ni duplicar registros existentes
INSERT IGNORE INTO `componentenutricional` (`idcomponentenutricional`, `nombre`, `descripcion`) VALUES
(1, 'Proteínas', 'Macronutriente fundamental para la síntesis de tejido muscular, recuperación y regeneración celular.'),
(2, 'Carbohidratos Totales', 'Principal fuente de combustible energético del organismo y reserva de glucógeno muscular y hepático.'),
(3, 'Grasas Totales (Lípidos)', 'Macronutriente esencial para la producción hormonal, absorción de vitaminas liposolubles y reserva de energía.'),
(4, 'Grasas Saturadas', 'Ácidos grasos presentes en productos animales y aceites tropicales; su consumo debe ser moderado.'),
(5, 'Grasas Monoinsaturadas', 'Grasas saludables presentes en aceite de oliva, aguacate y frutos secos que protegen la salud cardiovascular.'),
(6, 'Grasas Poliinsaturadas', 'Ácidos grasos esenciales (como Omega-3 y Omega-6) requeridos para el control de inflamación y salud cerebral.'),
(7, 'Fibra Dietética', 'Carbohidrato no digerible clave para el tránsito gastrointestinal, saciedad y control glucémico.'),
(8, 'Azúcares', 'Carbohidratos simples de rápida asimilación; aportan energía inmediata.'),
(9, 'Calorías / Valor Energético', 'Energía aportada por los nutrientes (expresada generalmente en kcal) requerida para las funciones basales y el entrenamiento.'),
(10, 'Sodio', 'Electrolito esencial para el equilibrio osmótico, transmisión del impulso nervioso y contracción muscular.'),
(11, 'Potasio', 'Electrolito que previene calambres, equilibra los niveles de líquidos y apoya la salud cardiovascular.'),
(12, 'Calcio', 'Mineral indispensable para la densidad mineral ósea, contracción muscular y señalización celular.'),
(13, 'Magnesio', 'Mineral involucrado en más de 300 reacciones enzimáticas, síntesis proteica, relajación muscular y descanso.'),
(14, 'Hierro', 'Componente clave de la hemoglobina y mioglobina para el transporte de oxígeno a los tejidos musculares.'),
(15, 'Zinc', 'Mineral cofactor de la inmunidad, síntesis de testosterona y cicatrización de tejidos.'),
(16, 'Fósforo', 'Mineral esencial que participa en la formación ósea y en la molécula energética de ATP.'),
(17, 'Vitamina C', 'Antioxidante hidrosoluble que estimula el sistema inmunológico y la producción de colágeno.'),
(18, 'Vitamina D', 'Vitamina liposoluble y prohormona vital para la absorción de calcio, fuerza muscular y sistema inmunitario.'),
(19, 'Vitamina B12', 'Crucial para la producción de glóbulos rojos, metabolismo energético y funcionamiento del sistema nervioso.'),
(20, 'Creatina', 'Compuesto nitrogenado que eleva las reservas intramusculares de fosfocreatina para esfuerzos de alta intensidad.');
