-- ==============================================================================
-- Migración Gim360: Registro de Receta Batido de Avena, Guineo, Leche y Almendra,
-- Ingredientes, Componentes Nutricionales e Imágenes Asociadas.
-- ==============================================================================

SET NAMES utf8mb4;
SET foreign_key_checks = 0;

-- 1. Receta: Batido de Avena, Guineo, Leche y Almendra
INSERT INTO `receta` (`idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`, `video`) VALUES
(12, 'Batido de Avena, Guineo, Leche y Almendra', 
'1. Coloca en la licuadora la avena, el guineo, la leche y las almendras.
2. Licúa por 30-60 segundos hasta obtener una mezcla cremosa.
3. Sirve y disfruta.', 
1, 5, 'https://www.youtube.com/watch?v=hAEwt3ro6mU')
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  instrucciones = VALUES(instrucciones),
  porciones = VALUES(porciones),
  tiempopreparacion = VALUES(tiempopreparacion),
  video = VALUES(video);

-- 2. AlimentoReceta (Ingredientes y cantidades para la Receta 12)
-- idunidadalimento: 1=Gramo, 3=Mililitro, 8=Unidad / Pieza
-- Alimentos reutilizados existentes: 8=Avena en Hojuelas, 14=Plátano / Banano, 7=Leche Descremada, 45=Almendras
INSERT INTO `alimentoreceta` (`idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`) VALUES
(54, 12, 8, 40.00, 1),   -- Avena 40 g (4 cucharadas)
(55, 12, 14, 1.00, 8),   -- Guineo (banana) 1 unidad (mediano)
(56, 12, 7, 250.00, 3),  -- Leche 250 ml (1 vaso)
(57, 12, 45, 15.00, 1)   -- Almendra 15 g (10-12 unidades)
ON DUPLICATE KEY UPDATE
  idreceta = VALUES(idreceta),
  idalimento = VALUES(idalimento),
  cantidad = VALUES(cantidad),
  idunidadalimento = VALUES(idunidadalimento);

-- 3. AlimentoComponenteNutricional (Relaciones nutricionales de los ingredientes)
-- 1:Proteínas, 2:Carbohidratos, 3:Grasas Totales, 5:Grasas Monoinsaturadas, 6:Grasas Poliinsaturadas,
-- 7:Fibra Dietética, 8:Azúcares, 9:Calorías, 10:Sodio, 11:Potasio, 12:Calcio, 13:Magnesio, 14:Hierro, 15:Zinc, 16:Fósforo, 17:Vitamina C, 18:Vitamina D, 19:Vitamina B12
INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES
-- Leche Descremada (id 7)
(7, 1), (7, 2), (7, 9), (7, 10), (7, 11), (7, 12), (7, 16), (7, 18), (7, 19),
-- Avena en Hojuelas (id 8)
(8, 1), (8, 2), (8, 7), (8, 9), (8, 11), (8, 13), (8, 14), (8, 16),
-- Plátano / Banano (id 14)
(14, 2), (14, 7), (14, 8), (14, 9), (14, 11), (14, 17),
-- Almendras (id 45)
(45, 1), (45, 3), (45, 5), (45, 6), (45, 7), (45, 9), (45, 12), (45, 13), (45, 14), (45, 15), (45, 16);

-- 4. RecetaComponenteNutricional (Componentes globales de la Receta 12 por porción)
-- Beneficios: Energía sostenida, mantenimiento muscular, digestión y salud cardiovascular
INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES
(12, 1),   -- Proteínas (leche, avena, almendras)
(12, 2),   -- Carbohidratos Totales (avena, banano, leche)
(12, 3),   -- Grasas Totales (almendras, leche)
(12, 5),   -- Grasas Monoinsaturadas (almendras - cardiosaludable)
(12, 6),   -- Grasas Poliinsaturadas (almendras)
(12, 7),   -- Fibra Dietética (avena y plátano - salud digestiva)
(12, 8),   -- Azúcares (energía natural del guineo)
(12, 9),   -- Calorías / Valor Energético (energía sostenida)
(12, 11),  -- Potasio (plátano y leche)
(12, 12),  -- Calcio (leche y almendras)
(12, 13),  -- Magnesio (avena y almendras - recuperación muscular)
(12, 14),  -- Hierro (avena y almendras)
(12, 16),  -- Fósforo (leche y avena)
(12, 17),  -- Vitamina C (guineo / plátano)
(12, 18),  -- Vitamina D (leche)
(12, 19);  -- Vitamina B12 (leche)

-- 5. Imágenes
INSERT INTO `imagen` (`idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio`) VALUES
(38, '20261102_094000-00038.jpg', 1, '2026-11-02 09:40:00', 'Vaso cremoso de batido nutritivo de avena, guineo, leche y almendras, ideal para energía sostenida y recuperación muscular', 'batido,smoothie,avena,guineo,banana,leche,almendras,energia,musculo,desayuno', 'Libre', '2026-11-02 09:40:00', 1, 1),
(39, '20261102_094001-00039.png', 2, '2026-11-02 09:40:01', 'Ficha e infografía completa de la receta Batido de Avena, Guineo, Leche y Almendra con ingredientes, pasos de preparación y beneficios nutricionales', 'batido,avena,guineo,banana,leche,almendra,receta,infografia,preparacion,nutricion,beneficios', 'Propietaria', '2026-11-02 09:40:01', 1, 1),
(40, '20261102_094002-00040.jpg', 1, '2026-11-02 09:40:02', 'Vaso de leche fresca y nutritiva fuente de calcio, proteínas de alto valor biológico, fósforo y vitamina D', 'leche,lacteo,calcio,proteina,ingrediente', 'Libre', '2026-11-02 09:40:02', 1, 1)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  idformatoimagen = VALUES(idformatoimagen),
  fechacaptura = VALUES(fechacaptura),
  descripcion = VALUES(descripcion),
  palabrasclave = VALUES(palabrasclave),
  licencia = VALUES(licencia),
  idordenador = VALUES(idordenador),
  iddirectorio = VALUES(iddirectorio);

-- 6. ImagenReceta (Asociar plato preparado e infografía a la receta 12)
INSERT INTO `imagenreceta` (`idimagenreceta`, `idimagen`, `idreceta`) VALUES
(15, 38, 12),
(16, 39, 12)
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idreceta = VALUES(idreceta);

-- 7. ImagenAlimento (Asociar imagen a la Leche Descremada)
INSERT INTO `imagenalimento` (`idimagenalimento`, `idimagen`, `idalimento`) VALUES
(26, 40, 7)
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idalimento = VALUES(idalimento);

SET foreign_key_checks = 1;
