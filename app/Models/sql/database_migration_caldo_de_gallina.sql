-- ==============================================================================
-- Migración Gim360: Registro de Caldo de Gallina Criolla con Yuca,
-- Ingredientes, Componentes Nutricionales e Imágenes Asociadas.
-- ==============================================================================

SET NAMES utf8mb4;
SET foreign_key_checks = 0;

-- 1. Nuevos Alimentos (Ingredientes del Caldo de Gallina Criolla)
INSERT INTO `alimento` (`idalimento`, `idgrupo`, `nombre`, `descripcion`) VALUES
(41, 1, 'Gallina Criolla', 'Carne de ave de corral criada de manera tradicional, con mayor densidad de colágeno, proteínas de alto valor biológico, aminoácidos esenciales, hierro, zinc, fósforo y vitaminas del complejo B (especialmente B12 y niacina), aportando un caldo concentrado, nutritivo y revitalizante.'),
(42, 6, 'Cebolla Blanca (de Rama)', 'Hortaliza aromática rica en compuestos azufrados antioxidantes, flavonoides, potasio y vitamina C, fundamental para aportar aroma y sabor característico a caldos y sopas tradicionales.')
ON DUPLICATE KEY UPDATE 
  idgrupo = VALUES(idgrupo),
  nombre = VALUES(nombre),
  descripcion = VALUES(descripcion);

-- 2. Receta: Caldo de Gallina Criolla con Yuca
INSERT INTO `receta` (`idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`) VALUES
(9, 'Caldo de Gallina Criolla con Yuca', 
'1. Lava la gallina, córtala en presas y colócala en una olla grande con 2,5 a 3 litros de agua. Lleva a ebullición y retira la espuma.
2. En una sartén, sofríe en aceite la cebolla picada y el ajo machacado. Agrega el comino y mezcla.
3. Incorpora el refrito a la olla con la gallina. Cocina a fuego medio por 60 a 90 minutos, hasta que la carne esté tierna.
4. Añade la yuca en trozos y cocina 20 a 30 minutos más, hasta que esté suave.
5. Rectifica la sal, agrega cilantro picado y cebolla blanca. Sirve caliente.', 
4, 120)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  instrucciones = VALUES(instrucciones),
  porciones = VALUES(porciones),
  tiempopreparacion = VALUES(tiempopreparacion);

-- 3. AlimentoReceta (Ingredientes y cantidades para la Receta 9: Caldo de Gallina Criolla con Yuca)
-- idunidadalimento: 1=Gramo, 3=Mililitro, 5=Cucharada, 6=Cucharadita, 8=Unidad / Pieza
INSERT INTO `alimentoreceta` (`idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`) VALUES
(31, 9, 41, 1350.00, 1), -- 1350 g (1 gallina criolla ≈ 1,2 - 1,5 kg, en presas)
(32, 9, 25, 600.00, 1),  -- 600 g (500 - 700 g de yuca, pelada y en trozos)
(33, 9, 26, 1.00, 8),    -- 1 cebolla colorada (unidad)
(34, 9, 29, 4.00, 8),    -- 4 dientes de ajo (unidades)
(35, 9, 42, 1.00, 8),    -- 1 rama de cebolla blanca (unidad)
(36, 9, 30, 1.00, 8),    -- 1 porción de cilantro fresco (al gusto)
(37, 9, 31, 0.50, 6),    -- 1/2 cdta (0.50) de comino molido
(38, 9, 36, 5.00, 1),    -- 5 g de sal común (al gusto)
(39, 9, 40, 1.00, 5),    -- 1 cda de aceite vegetal
(40, 9, 34, 2750.00, 3)  -- 2750 ml (2,5 - 3 litros) de agua purificada
ON DUPLICATE KEY UPDATE
  idreceta = VALUES(idreceta),
  idalimento = VALUES(idalimento),
  cantidad = VALUES(cantidad),
  idunidadalimento = VALUES(idunidadalimento);

-- 4. AlimentoComponenteNutricional (Relaciones nutricionales de los nuevos ingredientes)
-- Componentes: 1:Proteínas, 2:Carbohidratos Totales, 3:Grasas Totales, 4:Grasas Saturadas,
-- 7:Fibra Dietética, 9:Calorías, 10:Sodio, 11:Potasio, 12:Calcio, 13:Magnesio, 14:Hierro,
-- 15:Zinc, 16:Fósforo, 17:Vitamina C, 19:Vitamina B12
INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES
-- Gallina Criolla (id 41)
(41, 1), (41, 3), (41, 4), (41, 9), (41, 10), (41, 11), (41, 12), (41, 13), (41, 14), (41, 15), (41, 16), (41, 19),
-- Cebolla Blanca (id 42)
(42, 2), (42, 7), (42, 9), (42, 10), (42, 11), (42, 17);

-- 5. RecetaComponenteNutricional (Componentes globales del Caldo de Gallina Criolla con Yuca)
-- Valor nutricional aprox. por porción según infografía:
-- Energía: ~350 - 400 kcal, Proteína: 28 - 32 g, Carbohidratos: 38 - 42 g, Grasas: 10 - 12 g
INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES
(9, 1),   -- Proteínas: 28 - 32 g (Gallina criolla)
(9, 2),   -- Carbohidratos Totales: 38 - 42 g (Yuca)
(9, 3),   -- Grasas Totales: 10 - 12 g (Gallina y aceite de refrito)
(9, 4),   -- Grasas Saturadas
(9, 7),   -- Fibra Dietética (Yuca, cebolla y cilantro)
(9, 9),   -- Calorías / Valor Energético: ~350 - 400 kcal
(9, 10),  -- Sodio (Sal y caldo)
(9, 11),  -- Potasio (Yuca, gallina y hortalizas)
(9, 12),  -- Calcio (Aporte mineral del caldo de huesos)
(9, 13),  -- Magnesio (Yuca y gallina)
(9, 14),  -- Hierro (Gallina criolla)
(9, 15),  -- Zinc (Gallina criolla)
(9, 16),  -- Fósforo (Gallina criolla)
(9, 17),  -- Vitamina C (Yuca, cebolla blanca y cilantro)
(9, 19);  -- Vitamina B12 (Gallina criolla)

-- 6. Imágenes
INSERT INTO `imagen` (`idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio`) VALUES
(19, '20261101_191500-00019.jpg', 1, '2026-11-01 19:15:00', 'Plato tradicional de caldo de gallina criolla con yuca humeante, presa de gallina tierna, hierbas frescas y caldo dorado', 'caldo,gallina criolla,yuca,sopa,ecuador,almuerzo,receta tradicional', 'Libre', '2026-11-01 19:15:00', 1, 1),
(20, '20261101_191501-00020.png', 2, '2026-11-01 19:15:01', 'Ficha e infografía completa de la receta Caldo de Gallina Criolla con Yuca con ingredientes, pasos de preparación y valor nutricional', 'caldo de gallina,receta,infografia,ingredientes,preparacion,nutricion', 'Propietaria', '2026-11-01 19:15:01', 1, 1),
(21, '20261101_191502-00021.jpg', 1, '2026-11-01 19:15:02', 'Gallina criolla entera fresca de campo, proteína de alto valor biológico y colágeno para caldos reconstituyentes', 'gallina,gallina criolla,carne de ave,proteina,colageno,ingrediente', 'Libre', '2026-11-01 19:15:02', 1, 1),
(22, '20261101_191503-00022.jpg', 1, '2026-11-01 19:15:03', 'Rama de cebolla blanca fresca y aromática para condimentar caldos y sopas', 'cebolla blanca,cebollin,cebolla de rama,aromatico,hortaliza,ingrediente', 'Libre', '2026-11-01 19:15:03', 1, 1)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  idformatoimagen = VALUES(idformatoimagen),
  fechacaptura = VALUES(fechacaptura),
  descripcion = VALUES(descripcion),
  palabrasclave = VALUES(palabrasclave),
  licencia = VALUES(licencia),
  idordenador = VALUES(idordenador),
  iddirectorio = VALUES(iddirectorio);

-- 7. ImagenReceta (Asociar imágenes 19 y 20 a la receta 9: Caldo de Gallina Criolla con Yuca)
INSERT INTO `imagenreceta` (`idimagenreceta`, `idimagen`, `idreceta`) VALUES
(9, 19, 9),
(10, 20, 9)
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idreceta = VALUES(idreceta);

-- 8. ImagenAlimento (Asociar imágenes a los nuevos alimentos)
INSERT INTO `imagenalimento` (`idimagenalimento`, `idimagen`, `idalimento`) VALUES
(13, 21, 41),  -- Gallina Criolla
(14, 22, 42)   -- Cebolla Blanca
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idalimento = VALUES(idalimento);

SET foreign_key_checks = 1;
