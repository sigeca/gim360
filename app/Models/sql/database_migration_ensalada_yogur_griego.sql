-- ==============================================================================
-- Migración Gim360: Registro de Receta Ensalada de Yogur Griego con Frutas y Almendras,
-- Ingredientes, Componentes Nutricionales e Imágenes Asociadas.
-- ==============================================================================

SET NAMES utf8mb4;
SET foreign_key_checks = 0;

-- 1. Alimentos (Nuevos ingredientes de la receta)
INSERT INTO `alimento` (`idalimento`, `idgrupo`, `nombre`, `descripcion`) VALUES
(43, 5, 'Fresas Frescas', 'Fruta rica en vitamina C, antioxidantes, polifenoles y fibra, con muy bajo aporte calórico y bajo índice glucémico.'),
(44, 5, 'Arándanos', 'Fruto silvestre rico en antocianinas, antioxidantes de alto impacto celular, vitamina C y fibra dietética que favorecen la recuperación muscular y salud cerebral.'),
(45, 7, 'Almendras', 'Fruto seco de alto valor nutritivo, fuente de grasas monoinsaturadas cardiosaludables, proteína vegetal, vitamina E, magnesio, fósforo y calcio.')
ON DUPLICATE KEY UPDATE 
  idgrupo = VALUES(idgrupo),
  nombre = VALUES(nombre),
  descripcion = VALUES(descripcion);

-- 2. Receta: Ensalada de Yogur Griego con Frutas y Almendras
INSERT INTO `receta` (`idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`, `video`) VALUES
(10, 'Ensalada de Yogur Griego con Frutas y Almendras', 
'1. Coloca el yogur griego en un tazón.
2. Lava y corta las fresas en láminas.
3. Corta la banana en rodajas.
4. Agrega las fresas, la banana y los arándanos.
5. Incorpora las almendras (enteras o picadas).
6. Disfruta de inmediato.', 
1, 5, 'https://www.youtube.com/watch?v=mUOmX_jcwGM')
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  instrucciones = VALUES(instrucciones),
  porciones = VALUES(porciones),
  tiempopreparacion = VALUES(tiempopreparacion),
  video = VALUES(video);

-- 3. AlimentoReceta (Ingredientes y cantidades para la Receta 10)
-- idunidadalimento: 1=Gramo, 8=Unidad / Pieza
INSERT INTO `alimentoreceta` (`idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`) VALUES
(41, 10, 5, 150.00, 1),   -- 150 g de Yogur griego natural
(42, 10, 43, 100.00, 1),  -- 100 g de Fresas (≈ 5-6 unidades)
(43, 10, 14, 60.00, 1),   -- 60 g de Banana (1/2 unidad)
(44, 10, 44, 50.00, 1),   -- 50 g de Arándanos (≈ 1/2 taza)
(45, 10, 45, 18.00, 1)    -- 18 g de Almendras (15-20 g ≈ 10-12 unidades)
ON DUPLICATE KEY UPDATE
  idreceta = VALUES(idreceta),
  idalimento = VALUES(idalimento),
  cantidad = VALUES(cantidad),
  idunidadalimento = VALUES(idunidadalimento);

-- 4. AlimentoComponenteNutricional (Componentes de los ingredientes)
-- 1:Proteínas, 2:Carbohidratos, 3:Grasas Totales, 5:Grasas Monoinsaturadas, 6:Grasas Poliinsaturadas,
-- 7:Fibra Dietética, 8:Azúcares, 9:Calorías, 11:Potasio, 12:Calcio, 13:Magnesio, 14:Hierro, 15:Zinc, 16:Fósforo, 17:Vitamina C
INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES
-- Yogur Griego Natural (id 5)
(5, 1), (5, 2), (5, 3), (5, 9), (5, 12), (5, 16),
-- Banana / Plátano (id 14)
(14, 2), (14, 7), (14, 8), (14, 9), (14, 11), (14, 17),
-- Fresas Frescas (id 43)
(43, 2), (43, 7), (43, 8), (43, 9), (43, 11), (43, 17),
-- Arándanos (id 44)
(44, 2), (44, 7), (44, 8), (44, 9), (44, 17),
-- Almendras (id 45)
(45, 1), (45, 3), (45, 5), (45, 6), (45, 7), (45, 9), (45, 12), (45, 13), (45, 14), (45, 15), (45, 16);

-- 5. RecetaComponenteNutricional (Componentes globales de la Receta 10)
-- Beneficios: Alto en proteínas, Rico en antioxidantes, Aporta energía sostenida, Grasas saludables.
INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES
(10, 1),   -- Proteínas (yogur griego y almendras)
(10, 2),   -- Carbohidratos Totales (frutas y yogur)
(10, 3),   -- Grasas Totales (almendras y yogur)
(10, 5),   -- Grasas Monoinsaturadas (almendras)
(10, 6),   -- Grasas Poliinsaturadas (almendras)
(10, 7),   -- Fibra Dietética (fresas, banana, arándanos, almendras)
(10, 8),   -- Azúcares naturales (fructosa de frutas)
(10, 9),   -- Calorías / Valor Energético (≈ 320 kcal)
(10, 11),  -- Potasio (banana, fresas)
(10, 12),  -- Calcio (yogur griego, almendras)
(10, 13),  -- Magnesio (almendras, banana)
(10, 14),  -- Hierro (almendras, fresas)
(10, 16),  -- Fósforo (yogur griego, almendras)
(10, 17);  -- Vitamina C (fresas, arándanos)

-- 6. Imágenes
INSERT INTO `imagen` (`idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio`) VALUES
(23, '20261101_201500-00023.jpg', 1, '2026-11-01 20:15:00', 'Bowl saludable de ensalada de yogur griego con fresas en láminas, banana en rodajas, arándanos y almendras crujientes', 'yogur griego,frutas,ensalada,fresas,banana,arandanos,almendras,desayuno,saludable', 'Libre', '2026-11-01 20:15:00', 1, 1),
(24, '20261101_201501-00024.png', 2, '2026-11-01 20:15:01', 'Ficha e infografía completa de la receta Ensalada de Yogur Griego con Frutas y Almendra con ingredientes, pasos de preparación y beneficios nutricionales', 'yogur griego,frutas,receta,infografia,preparacion,nutricion,beneficios', 'Propietaria', '2026-11-01 20:15:01', 1, 1),
(25, '20261101_201502-00025.jpg', 1, '2026-11-01 20:15:02', 'Yogur griego natural sin azúcar añadido, fuente de proteínas de alto valor biológico, calcio y probióticos', 'yogur griego,lacteo,proteina,probioticos,calcio,ingrediente', 'Libre', '2026-11-01 20:15:02', 1, 1),
(26, '20261101_201503-00026.jpg', 1, '2026-11-01 20:15:03', 'Fresas frescas cortadas en láminas ricas en vitamina C, antioxidantes y fibra', 'fresas,frutas,antioxidantes,vitamina c,ingrediente', 'Libre', '2026-11-01 20:15:03', 1, 1),
(27, '20261101_201504-00027.jpg', 1, '2026-11-01 20:15:04', 'Banana madura en rodajas fuente de energía sostenida, fructosa natural y potasio', 'banana,platano,fruta,potasio,energia,ingrediente', 'Libre', '2026-11-01 20:15:04', 1, 1),
(28, '20261101_201505-00028.jpg', 1, '2026-11-01 20:15:05', 'Arándanos frescos silvestres de alto poder antioxidante y antocianinas', 'arandanos,frutos rojos,antioxidantes,antocianinas,ingrediente', 'Libre', '2026-11-01 20:15:05', 1, 1),
(29, '20261101_201506-00029.jpg', 1, '2026-11-01 20:15:06', 'Almendras enteras y picadas con grasas saludables monoinsaturadas, magnesio y vitamina E', 'almendras,frutos secos,grasas saludables,magnesio,ingrediente', 'Libre', '2026-11-01 20:15:06', 1, 1)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  idformatoimagen = VALUES(idformatoimagen),
  fechacaptura = VALUES(fechacaptura),
  descripcion = VALUES(descripcion),
  palabrasclave = VALUES(palabrasclave),
  licencia = VALUES(licencia),
  idordenador = VALUES(idordenador),
  iddirectorio = VALUES(iddirectorio);

-- 7. ImagenReceta (Asociar plato e infografía a la receta 10)
INSERT INTO `imagenreceta` (`idimagenreceta`, `idimagen`, `idreceta`) VALUES
(11, 23, 10),
(12, 24, 10)
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idreceta = VALUES(idreceta);

-- 8. ImagenAlimento (Asociar imágenes a los ingredientes)
INSERT INTO `imagenalimento` (`idimagenalimento`, `idimagen`, `idalimento`) VALUES
(15, 25, 5),   -- Yogur Griego Natural
(16, 26, 43),  -- Fresas Frescas
(17, 27, 14),  -- Banana / Plátano
(18, 28, 44),  -- Arándanos
(19, 29, 45)   -- Almendras
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idalimento = VALUES(idalimento);

SET foreign_key_checks = 1;
