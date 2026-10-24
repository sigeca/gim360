-- ==============================================================================
-- Migración: Tabla alimento vinculada a grupoalimento
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `alimento` (
  `idalimento` int(11) NOT NULL AUTO_INCREMENT,
  `idgrupo` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`idalimento`),
  KEY `fk_alimento_grupo` (`idgrupo`),
  CONSTRAINT `fk_alimento_grupo` FOREIGN KEY (`idgrupo`) REFERENCES `grupoalimento` (`idgrupoalimento`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad
CREATE OR REPLACE VIEW `Alimento` AS
SELECT `idalimento`, `idgrupo`, `nombre`, `descripcion`
FROM `alimento`;

-- Alimentos base de nutrición deportiva y fitness
INSERT IGNORE INTO `alimento` (`idgrupo`, `nombre`, `descripcion`) VALUES
-- Proteínas (idgrupo = 1)
(1, 'Pechuga de Pollo', 'Excelente fuente de proteína magra de alto valor biológico con bajo contenido de grasa.'),
(1, 'Huevos Enteros y Claras', 'Proteína de referencia biológica rica en albúmina, colina, vitaminas B12 y minerales.'),
(1, 'Atún al Natural', 'Pescado magro con alto contenido proteico y aporte de ácidos grasos omega-3.'),
(1, 'Carne de Res Magra', 'Aporte proteico rico en hierro hemo, zinc, creatina natural y vitamina B12.'),

-- Lácteos (idgrupo = 2)
(2, 'Yogur Griego Natural', 'Concentrado proteico con probióticos naturales para la microbiota y calcio.'),
(2, 'Queso Cottage / Ricotta', 'Rico en proteína de caseína de lenta digestión, ideal para etapas nocturnas.'),
(2, 'Leche Descremada', 'Bebida rica en calcio, fósforo y combinación de suero lácteo y caseína.'),

-- Cereales y Tubérculos (idgrupo = 3)
(3, 'Avena en Hojuelas', 'Carbohidrato complejo de absorción lenta con alto contenido de fibra soluble (beta-glucanos).'),
(3, 'Arroz Blanco / Integral', 'Fuente limpia de energía para el rendimiento muscular y reposición de glucógeno.'),
(3, 'Papa Cocida y Camote (Batata)', 'Tubérculos ricos en carbohidratos complejos, potasio y antioxidantes (betacaroteno).'),
(3, 'Quinua', 'Pseudocereal andino con carbohidratos complejos y perfil completo de aminoácidos.'),

-- Legumbres (idgrupo = 4)
(4, 'Lentejas', 'Ricas en hierro, fibra y carbohidratos de bajo índice glucémico.'),
(4, 'Garbanzos', 'Fuente vegetal equilibrada de proteínas, carbohidratos y fibra dietética.'),

-- Frutas (idgrupo = 5)
(5, 'Plátano / Banano', 'Excelente para pre/post entrenamiento por su aporte rápido de potasio y fructosa.'),
(5, 'Manzana', 'Rica en pectina, fibra y antioxidantes que modulan la glucemia.'),
(5, 'Frutos Rojos (Arándanos, Fresas)', 'Baja carga glucémica con potente concentración de antioxidantes y antocianinas.'),

-- Verduras (idgrupo = 6)
(6, 'Brócoli', 'Crucífera con sulforafano, vitamina C, fibra y efecto desintoxicante.'),
(6, 'Espinacas', 'Hojas verdes con nitratos naturales que mejoran la oxigenación muscular y hierro.'),

-- Grasas Saludables (idgrupo = 7)
(7, 'Aguacate (Palta)', 'Ácidos grasos monoinsaturados saludables, potasio y fibra para la salud hormonal.'),
(7, 'Aceite de Oliva Virgen Extra', 'Ácido oleico y polifenoles antiinflamatorios para la salud cardiovascular.'),
(7, 'Frutos Secos (Almendras, Nueces)', 'Aporte de grasas saludables, magnesio, vitamina E y energía saciante.'),

-- Suplementación (idgrupo = 8)
(8, 'Proteína de Suero (Whey Protein)', 'Aislado o concentrado proteico de rápida asimilación con leucina para síntesis proteica.'),
(8, 'Creatina Monohidrato', 'Suplemento con mayor evidencia para ganancia de fuerza, potencia y volumen muscular.');
