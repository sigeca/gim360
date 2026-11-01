-- ==============================================================================
-- Migración Gim360: Registro de Patacones con Queso, Ingredientes,
-- Componentes Nutricionales e Imágenes Asociadas.
-- ==============================================================================

SET NAMES utf8mb4;
SET foreign_key_checks = 0;

-- 1. Nuevos Alimentos (Ingredientes de los Patacones con Queso y complementos)
INSERT INTO `alimento` (`idalimento`, `idgrupo`, `nombre`, `descripcion`) VALUES
(37, 3, 'Plátano Verde (Patacón)', 'Plátano verde rico en carbohidratos complejos y almidón resistente que proporciona energía sostenida, además de un alto contenido de potasio y fibra dietética que contribuye al funcionamiento muscular.'),
(38, 2, 'Queso Fresco', 'Queso tierno artesanal de humedad intermedia, excelente fuente de proteínas de alto valor biológico, calcio biodisponible para la salud ósea, fósforo, grasas lácteas y sodio.'),
(39, 1, 'Huevo Frito', 'Huevo de gallina preparado en sartén con ligera fritura, rico en proteína completa de altísima biodisponibilidad, colina indispensable para el sistema nervioso, grasas saludables y vitaminas B12 y D.'),
(40, 7, 'Aceite Vegetal para Cocinar', 'Aceite vegetal para cocción y fritura, fuente concentrada de energía, ácidos grasos insaturados y vehículo para la absorción de vitaminas liposolubles.')
ON DUPLICATE KEY UPDATE 
  idgrupo = VALUES(idgrupo),
  nombre = VALUES(nombre),
  descripcion = VALUES(descripcion);

-- 2. Receta: Patacones con Queso
INSERT INTO `receta` (`idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`) VALUES
(8, 'Patacones con Queso', 
'1. Pela el plátano verde y córtalo en rodajas de aproximadamente 2 cm de grosor.
2. Calienta el aceite en una sartén a fuego medio y fríe los trozos de plátano durante 3 a 4 minutos por lado hasta que estén ligeramente dorados por fuera y tiernos por dentro.
3. Retira los trozos de plátano y aplástalos inmediatamente sobre una tabla con una pataconera o la base de un vaso plano hasta formar discos (patacones).
4. Vuelve a freír los patacones en el aceite caliente durante 1 a 2 minutos por lado hasta que queden crujientes y dorados. Escurre sobre papel absorbente y añade una pizca de sal.
5. En la misma sartén o plancha caliente, fríe el huevo al gusto cuidando el punto de cocción de la yema.
6. Corta el queso fresco en bastones o láminas uniformes.
7. Sirve los patacones calientes y crujientes acompañados del queso fresco y el huevo frito recién preparado.', 
1, 20)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  instrucciones = VALUES(instrucciones),
  porciones = VALUES(porciones),
  tiempopreparacion = VALUES(tiempopreparacion);

-- 3. AlimentoReceta (Ingredientes y cantidades para la Receta 8: Patacones con Queso)
-- idunidadalimento: 1=Gramo, 6=Cucharadita, 8=Unidad / Pieza
INSERT INTO `alimentoreceta` (`idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`) VALUES
(26, 8, 37, 100.00, 1),  -- 100 g (1 plátano verde mediano, parte comestible)
(27, 8, 38, 30.00, 1),   -- 30 g de Queso Fresco
(28, 8, 39, 1.00, 8),    -- 1 Unidad de Huevo Frito (grande)
(29, 8, 40, 1.00, 6),    -- 1 cdta de Aceite Vegetal absorbido
(30, 8, 36, 1.00, 1)     -- 1 g de Sal Común / Sal Marina (al gusto)
ON DUPLICATE KEY UPDATE
  idreceta = VALUES(idreceta),
  idalimento = VALUES(idalimento),
  cantidad = VALUES(cantidad),
  idunidadalimento = VALUES(idunidadalimento);

-- 4. AlimentoComponenteNutricional (Relaciones nutricionales de los ingredientes)
-- Componentes: 1:Proteínas, 2:Carbohidratos Totales, 3:Grasas Totales, 4:Grasas Saturadas,
-- 5:Grasas Monoinsaturadas, 6:Grasas Poliinsaturadas, 7:Fibra Dietética, 9:Calorías,
-- 10:Sodio, 11:Potasio, 12:Calcio, 13:Magnesio, 16:Fósforo, 18:Vitamina D, 19:Vitamina B12
INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES
-- Plátano Verde (id 37)
(37, 2), (37, 7), (37, 9), (37, 11), (37, 13),
-- Queso Fresco (id 38)
(38, 1), (38, 3), (38, 4), (38, 9), (38, 10), (38, 12), (38, 16),
-- Huevo Frito (id 39)
(39, 1), (39, 3), (39, 9), (39, 18), (39, 19),
-- Aceite Vegetal (id 40)
(40, 3), (40, 5), (40, 6), (40, 9);

-- 5. RecetaComponenteNutricional (Componentes globales de los Patacones con Queso)
-- Aporte estimado según infografía: Calorías (430-470 kcal), Proteínas (17-19 g),
-- Carbohidratos (45-50 g), Grasas (19-22 g), Fibra (3-4 g), Calcio (180-220 mg), Potasio (500-600 mg)
INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES
(8, 1),   -- Proteínas (Huevo y queso)
(8, 2),   -- Carbohidratos Totales (Plátano verde)
(8, 3),   -- Grasas Totales (Aceite, huevo y queso)
(8, 4),   -- Grasas Saturadas (Queso)
(8, 7),   -- Fibra Dietética (Plátano verde)
(8, 9),   -- Calorías / Valor Energético (430-470 kcal)
(8, 10),  -- Sodio (Queso y sal)
(8, 11),  -- Potasio (500-600 mg, plátano verde)
(8, 12),  -- Calcio (180-220 mg, queso fresco)
(8, 13),  -- Magnesio (Plátano verde)
(8, 16),  -- Fósforo (Queso)
(8, 18),  -- Vitamina D (Huevo)
(8, 19);  -- Vitamina B12 (Huevo)

-- 6. Imágenes
INSERT INTO `imagen` (`idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio`) VALUES
(14, '20261101_181500-00014.jpg', 1, '2026-11-01 18:15:00', 'Plato tradicional de patacones dorados y crujientes servidos con queso fresco artesanal y huevo frito', 'patacon,patacones,queso,huevo,desayuno,platano verde,receta', 'Libre', '2026-11-01 18:15:00', 1, 1),
(15, '20261101_181501-00015.png', 2, '2026-11-01 18:15:01', 'Ficha e infografía nutricional de Patacones con Queso y Huevo Frito con porciones y macronutrientes', 'patacon,receta,infografia,nutricion,calorias,proteinas,carbohidratos,grasas', 'Propietaria', '2026-11-01 18:15:01', 1, 1),
(16, '20261101_181502-00016.jpg', 1, '2026-11-01 18:15:02', 'Porción de patacones crujientes a base de plátano verde, rica fuente de energía y potasio', 'patacon,platano verde,carbohidratos,potasio,fibra,ingrediente', 'Libre', '2026-11-01 18:15:02', 1, 1),
(17, '20261101_181503-00017.jpg', 1, '2026-11-01 18:15:03', 'Huevo frito con yema tierna, fuente de proteína completa de alto valor biológico y colina', 'huevo,huevo frito,proteina,colina,vitamina b12,vitamina d,ingrediente', 'Libre', '2026-11-01 18:15:03', 1, 1),
(18, '20261101_181504-00018.jpg', 1, '2026-11-01 18:15:04', 'Bastones de queso fresco artesanal rico en calcio, fósforo y proteínas lácteas', 'queso,queso fresco,calcio,fosforo,proteina,lacteo,ingrediente', 'Libre', '2026-11-01 18:15:04', 1, 1)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  idformatoimagen = VALUES(idformatoimagen),
  fechacaptura = VALUES(fechacaptura),
  descripcion = VALUES(descripcion),
  palabrasclave = VALUES(palabrasclave),
  licencia = VALUES(licencia),
  idordenador = VALUES(idordenador),
  iddirectorio = VALUES(iddirectorio);

-- 7. ImagenReceta (Asociar imágenes 14 y 15 a la receta 8: Patacones con Queso)
INSERT INTO `imagenreceta` (`idimagenreceta`, `idimagen`, `idreceta`) VALUES
(7, 14, 8),
(8, 15, 8)
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idreceta = VALUES(idreceta);

-- 8. ImagenAlimento (Asociar imágenes a los alimentos)
INSERT INTO `imagenalimento` (`idimagenalimento`, `idimagen`, `idalimento`) VALUES
(10, 16, 37),  -- Plátano Verde (Patacón)
(11, 18, 38),  -- Queso Fresco
(12, 17, 39)   -- Huevo Frito
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idalimento = VALUES(idalimento);

SET foreign_key_checks = 1;
