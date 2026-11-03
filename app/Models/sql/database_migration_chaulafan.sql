-- ==============================================================================
-- Migración Gim360: Registro de Receta Chaulafán de Pollo,
-- Ingredientes, Componentes Nutricionales, Video e Imágenes Asociadas.
-- ==============================================================================

SET NAMES utf8mb4;
SET foreign_key_checks = 0;

-- 1. Alimentos (Nuevos ingredientes de la receta si no existen)
INSERT INTO `alimento` (`idalimento`, `idgrupo`, `nombre`, `descripcion`) VALUES
(50, 6, 'Cebolla China', 'Hortaliza aromática conocida también como cebollín o cebolleta china, fundamental en el chaulafán y salteados chifa, rica en compuestos azufrados, vitamina C, potasio y antioxidantes.'),
(51, 6, 'Pimiento Rojo', 'Hortaliza rica en vitamina C, provitamina A (betacarotenos), capsantina y antioxidantes que aporta color, textura crujiente y frescura a salteados y platos principales.'),
(52, 6, 'Salsa de Soya', 'Condimento líquido tradicional fermentado a base de soya y trigo que proporciona el sabor umami característico, color tostado y aporte de aminoácidos y sodio.'),
(53, 6, 'Pimienta Negra Molida', 'Especia aromática termogénica rica en piperina que estimula la digestión, potencia la biodisponibilidad de nutrientes y sazona carnes y preparaciones.')
ON DUPLICATE KEY UPDATE 
  idgrupo = VALUES(idgrupo),
  nombre = VALUES(nombre),
  descripcion = VALUES(descripcion);

-- 2. Receta: Chaulafán
INSERT INTO `receta` (`idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`, `video`) VALUES
(13, 'Chaulafán', 
'1. Cocina el pollo con una pizca de sal y pimienta, corta en trozos pequeños y reserva.
2. Bate los huevos, cocínalos en la sartén, desmenúzalos y reserva.
3. En la misma sartén, saltea el ajo, la zanahoria y el pimiento por 3-4 minutos.
4. Agrega el arroz, el pollo y el huevo. Incorpora la salsa de soya, mezcla bien y cocina por 2-3 minutos.
5. Añade la cebolla china, rectifica la sal, mezcla y sirve caliente.', 
4, 30, 'https://www.youtube.com/watch?v=ZbvNmAsx7lw&t=48s')
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  instrucciones = VALUES(instrucciones),
  porciones = VALUES(porciones),
  tiempopreparacion = VALUES(tiempopreparacion),
  video = VALUES(video);

-- 3. AlimentoReceta (Ingredientes y cantidades para la Receta 13: Chaulafán)
-- Unidades: 1=Gramo (g), 5=Cucharada (cda), 6=Cucharadita (cdta), 7=Taza (tz), 8=Unidad / Pieza (unid)
INSERT INTO `alimentoreceta` (`idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`) VALUES
(58, 13, 9, 4.00, 7),   -- Arroz cocido (preferible del día anterior): 4 tazas
(59, 13, 1, 300.00, 1),  -- Pollo (pechuga o muslo): 300 g
(60, 13, 2, 2.00, 8),    -- Huevos: 2 unidades
(61, 13, 46, 1.00, 8),   -- Zanahoria (mediana): 1 unidad
(62, 13, 50, 3.00, 8),   -- Cebolla china: 3 ramas
(63, 13, 51, 0.50, 8),   -- Pimiento rojo: 1/2 unidad (mediana)
(64, 13, 29, 2.00, 8),   -- Ajo: 2 dientes
(65, 13, 52, 3.50, 5),   -- Salsa de soya: 3-4 cucharadas (promedio 3.5 cda)
(66, 13, 40, 2.00, 5),   -- Aceite vegetal para cocinar: 2 cucharadas
(67, 13, 36, 0.50, 6),   -- Sal al gusto: 1/2 cucharadita
(68, 13, 53, 0.25, 6)    -- Pimienta negra al gusto: 1/4 cucharadita
ON DUPLICATE KEY UPDATE
  idreceta = VALUES(idreceta),
  idalimento = VALUES(idalimento),
  cantidad = VALUES(cantidad),
  idunidadalimento = VALUES(idunidadalimento);

-- 4. AlimentoComponenteNutricional (Relaciones nutricionales de los alimentos/ingredientes)
-- 1:Proteínas, 2:Carbohidratos, 3:Grasas Totales, 5:Grasas Monoinsaturadas, 6:Grasas Poliinsaturadas,
-- 7:Fibra Dietética, 9:Calorías, 10:Sodio, 11:Potasio, 12:Calcio, 13:Magnesio, 14:Hierro, 16:Fósforo, 17:Vitamina C, 19:Vitamina B12
INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES
-- Cebolla China (id 50)
(50, 2), (50, 7), (50, 9), (50, 10), (50, 11), (50, 17),
-- Pimiento Rojo (id 51)
(51, 2), (51, 7), (51, 9), (51, 11), (51, 17),
-- Salsa de Soya (id 52)
(52, 1), (52, 2), (52, 9), (52, 10),
-- Pimienta Negra Molida (id 53)
(53, 7), (53, 11), (53, 12), (53, 13), (53, 14),
-- Ajo (id 29)
(29, 2), (29, 7), (29, 9), (29, 11), (29, 17),
-- Aceite Vegetal para Cocinar (id 40)
(40, 3), (40, 5), (40, 6), (40, 9);

-- 5. RecetaComponenteNutricional (Componentes globales de la Receta 13: Chaulafán por porción)
INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES
(13, 1),   -- Proteínas (pollo, huevo)
(13, 2),   -- Carbohidratos Totales (arroz blanco, vegetales)
(13, 3),   -- Grasas Totales (aceite, huevo)
(13, 5),   -- Grasas Monoinsaturadas (aceite de cocina)
(13, 6),   -- Grasas Poliinsaturadas (aceite de cocina, huevo)
(13, 7),   -- Fibra Dietética (zanahoria, pimiento rojo, cebolla china)
(13, 9),   -- Calorías / Valor Energético (plato balanceado)
(13, 10),  -- Sodio (salsa de soya, sal)
(13, 11),  -- Potasio (pollo, arroz, pimiento, cebolla)
(13, 12),  -- Calcio (huevo, vegetales)
(13, 13),  -- Magnesio (arroz, vegetales)
(13, 14),  -- Hierro (pollo, huevo, arroz)
(13, 15),  -- Zinc (pollo, huevo)
(13, 16),  -- Fósforo (pollo, huevo, arroz)
(13, 17),  -- Vitamina C (pimiento rojo, cebolla china, zanahoria)
(13, 18),  -- Vitamina D (yema de huevo)
(13, 19);  -- Vitamina B12 (pollo, huevo)

-- 6. Imágenes
INSERT INTO `imagen` (`idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio`) VALUES
(41, '20261102_211500-00041.jpg', 1, '2026-11-02 21:15:00', 'Plato tradicional de chaulafán servido caliente con arroz salteado, trozos de pechuga de pollo dorada, huevo, cebollín, pimiento rojo y salsa de soya', 'chaulafan,arroz,pollo,huevo,cebollin,cebollachina,pimiento,salteado,chifa,receta,plato', 'Libre', '2026-11-02 21:15:00', 1, 1),
(42, '20261102_211501-00042.png', 2, '2026-11-02 21:15:01', 'Ficha e infografía completa de la receta Chaulafán con ingredientes, cantidades, pasos de preparación, porciones y tiempos de cocción', 'chaulafan,receta,infografia,ingredientes,preparacion,chifa,pollo,arroz', 'Propietaria', '2026-11-02 21:15:01', 1, 1),
(43, '20261102_211502-00043.jpg', 1, '2026-11-02 21:15:02', 'Ramas frescas de cebolla china o cebollín para aromatizar y dar sabor fresco y crujiente al chaulafán', 'cebolla,cebollachina,cebollin,vegetal,ingrediente', 'Libre', '2026-11-02 21:15:02', 1, 1),
(44, '20261102_211503-00044.jpg', 1, '2026-11-02 21:15:03', 'Pimiento rojo fresco y crujiente rico en vitamina C y antioxidantes para salteados', 'pimiento,pimientorojo,vegetal,vitaminaC,ingrediente', 'Libre', '2026-11-02 21:15:03', 1, 1),
(45, '20261102_211504-00045.jpg', 1, '2026-11-02 21:15:04', 'Dientes de ajo aromáticos con alicina y fitoquímicos para aromatizar la cocción y salteados', 'ajo,condimento,alicina,aroma,ingrediente', 'Libre', '2026-11-02 21:15:04', 1, 1),
(46, '20261102_211505-00046.jpg', 1, '2026-11-02 21:15:05', 'Salsa de soya oscura tradicional para aportar el color y sabor característico del chaulafán', 'salsasoya,soya,soja,condimento,chifa,ingrediente', 'Libre', '2026-11-02 21:15:05', 1, 1),
(47, '20261102_211506-00047.jpg', 1, '2026-11-02 21:15:06', 'Aceite vegetal para saltear y freír ingredientes a fuego vivo', 'aceite,aceitevegetal,coccion,grasa,ingrediente', 'Libre', '2026-11-02 21:15:06', 1, 1),
(48, '20261102_211507-00048.jpg', 1, '2026-11-02 21:15:07', 'Pimienta negra molida aromática para sazonar y realzar sabores en carnes y salteados', 'pimienta,pimientanegra,especia,sazon,ingrediente', 'Libre', '2026-11-02 21:15:07', 1, 1)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  idformatoimagen = VALUES(idformatoimagen),
  fechacaptura = VALUES(fechacaptura),
  descripcion = VALUES(descripcion),
  palabrasclave = VALUES(palabrasclave),
  licencia = VALUES(licencia),
  idordenador = VALUES(idordenador),
  iddirectorio = VALUES(iddirectorio);

-- 7. ImagenReceta (Asociar plato preparado e infografía a la receta 13: Chaulafán)
INSERT INTO `imagenreceta` (`idimagenreceta`, `idimagen`, `idreceta`) VALUES
(17, 41, 13),
(18, 42, 13)
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idreceta = VALUES(idreceta);

-- 8. ImagenAlimento (Asociar imágenes a los ingredientes correspondientes)
INSERT INTO `imagenalimento` (`idimagenalimento`, `idimagen`, `idalimento`) VALUES
(27, 43, 50),  -- Cebolla China
(28, 44, 51),  -- Pimiento Rojo
(29, 45, 29),  -- Ajo
(30, 46, 52),  -- Salsa de Soya
(31, 47, 40),  -- Aceite Vegetal para Cocinar
(32, 48, 53)   -- Pimienta Negra Molida
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idalimento = VALUES(idalimento);

SET foreign_key_checks = 1;
