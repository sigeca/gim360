-- ==============================================================================
-- Migración: Tabla receta para Recetas Nutricionales y Fitness
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `receta` (
  `idreceta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `instrucciones` text DEFAULT NULL,
  `porciones` int(11) DEFAULT 1,
  `tiempopreparacion` int(11) DEFAULT NULL COMMENT 'Tiempo de preparación en minutos',
  PRIMARY KEY (`idreceta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Vista de compatibilidad
CREATE OR REPLACE VIEW `Receta` AS
SELECT `idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`
FROM `receta`;

-- Inserción de recetas fitness de ejemplo si no existen
INSERT INTO `receta` (`nombre`, `instrucciones`, `porciones`, `tiempopreparacion`)
SELECT 
  'Tortilla de Avena y Claras de Huevo',
  '1. Batir 4 claras de huevo con 1 yema.\n2. Incorporar 40g de avena en hojuelas y una pizca de canela al gusto.\n3. Calentar una sartén antiadherente con 2 gotas de aceite de oliva virgen.\n4. Verter la mezcla y cocinar a fuego medio durante 3 minutos por cada lado hasta dorar.',
  1,
  10
WHERE NOT EXISTS (SELECT 1 FROM `receta` WHERE `nombre` = 'Tortilla de Avena y Claras de Huevo');

INSERT INTO `receta` (`nombre`, `instrucciones`, `porciones`, `tiempopreparacion`)
SELECT 
  'Bowl de Pollo a la Plancha con Quinoa y Aguacate',
  '1. Cocinar 100g de quinoa en agua con sal durante 15 minutos y escurrir.\n2. Sazonar 250g de pechuga de pollo con ajo, orégano, sal y pimienta.\n3. Cocinar el pollo a la plancha durante 5-6 minutos por lado a fuego medio-alto.\n4. Cortar en tiras y servir sobre la quinoa templada con rodajas de aguacate fresco y hojas de espinaca.',
  2,
  25
WHERE NOT EXISTS (SELECT 1 FROM `receta` WHERE `nombre` = 'Bowl de Pollo a la Plancha con Quinoa y Aguacate');

INSERT INTO `receta` (`nombre`, `instrucciones`, `porciones`, `tiempopreparacion`)
SELECT 
  'Batido Proteico Post-Entreno de Plátano y Avena',
  '1. Colocar en el vaso de la licuadora 250ml de leche desnatada o bebida vegetal de almendras.\n2. Agregar 1 plátano maduro cortado en rodajas, 35g de avena en copos y 1 medida (scoop) de proteína de suero.\n3. Añadir 3 cubos de hielo y licuar a máxima potencia durante 60 segundos hasta lograr una textura suave y homogénea.',
  1,
  5
WHERE NOT EXISTS (SELECT 1 FROM `receta` WHERE `nombre` = 'Batido Proteico Post-Entreno de Plátano y Avena');

INSERT INTO `receta` (`nombre`, `instrucciones`, `porciones`, `tiempopreparacion`)
SELECT 
  'Salmón al Horno con Espárragos y Batata Asada',
  '1. Precalentar el horno a 200°C.\n2. Lavar y cortar la batata en rodajas finas y distribuirlas en una bandeja con papel vegetal junto con los espárragos trigueros.\n3. Rociar con una cucharadita de aceite de oliva, sal marina y romero.\n4. Hornear durante 15 minutos, luego incorporar los lomos de salmón salpimentados y cocinar 12 a 15 minutos adicionales hasta que el pescado esté jugoso.',
  2,
  35
WHERE NOT EXISTS (SELECT 1 FROM `receta` WHERE `nombre` = 'Salmón al Horno con Espárragos y Batata Asada');
