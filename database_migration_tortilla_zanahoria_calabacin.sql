-- ==============================================================================
-- Migración Gim360: Registro de Receta Tortitas de Zanahoria y Calabacín,
-- Ingredientes, Componentes Nutricionales e Imágenes Asociadas.
-- ==============================================================================

SET NAMES utf8mb4;
SET foreign_key_checks = 0;

-- 1. Alimentos (Nuevos ingredientes de la receta)
INSERT INTO `alimento` (`idalimento`, `idgrupo`, `nombre`, `descripcion`) VALUES
(46, 6, 'Zanahoria', 'Hortaliza rica en betacarotenos (provitamina A), antioxidantes, fibra dietética, potasio y vitamina C, esencial para la salud ocular, cutánea y sistema inmunológico.'),
(47, 6, 'Calabacín', 'Hortaliza de muy bajo aporte calórico y alta hidratación, rica en potasio, folatos, vitamina C y fibra soluble, ideal para recetas ligeras y digestivas.'),
(48, 2, 'Queso Bajo en Grasa', 'Queso magro con reducido contenido de grasas saturadas, alto en calcio, fósforo y proteínas de alto valor biológico para el mantenimiento muscular.'),
(49, 6, 'Perejil Fresco', 'Hierba aromática fresca rica en vitamina C, vitamina K, hierro y flavonoides antioxidantes, que aporta aroma y realza el valor nutricional.')
ON DUPLICATE KEY UPDATE 
  idgrupo = VALUES(idgrupo),
  nombre = VALUES(nombre),
  descripcion = VALUES(descripcion);

-- 2. Receta: Tortitas de Zanahoria y Calabacín
INSERT INTO `receta` (`idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`, `video`) VALUES
(11, 'Tortitas de Zanahoria y Calabacín', 
'1. Lava y ralla la zanahoria y el calabacín. Escurre el exceso de agua con un paño limpio o colador.
2. En un tazón, mezcla las verduras ralladas con los huevos, la avena, el queso, el perejil y los condimentos (sal, pimienta y orégano).
3. Forma pequeñas tortitas compactas con la mezcla.
4. Calienta una sartén antiadherente a fuego medio con una cucharadita de aceite de oliva.
5. Cocina las tortitas 3-4 minutos por lado, hasta que estén bien doradas y cocidas en el centro. Sirve calientes.', 
4, 25, 'https://www.youtube.com/watch?v=t1Ha_DPETfg')
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  instrucciones = VALUES(instrucciones),
  porciones = VALUES(porciones),
  tiempopreparacion = VALUES(tiempopreparacion),
  video = VALUES(video);

-- 3. AlimentoReceta (Ingredientes y cantidades para la Receta 11)
-- idunidadalimento: 1=Gramo, 6=Cucharadita, 8=Unidad / Pieza
INSERT INTO `alimentoreceta` (`idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`) VALUES
(46, 11, 46, 1.00, 8),   -- 1 zanahoria mediana (rallada)
(47, 11, 47, 1.00, 8),   -- 1 calabacín mediano (rallado)
(48, 11, 2, 2.00, 8),    -- 2 huevos
(49, 11, 8, 50.00, 1),   -- 1/2 taza de avena molida o hojuelas finas (50 g)
(50, 11, 48, 30.00, 1),  -- 1/4 taza de queso bajo en grasa (aprox. 30 g)
(51, 11, 49, 1.00, 8),   -- Perejil o cilantro picado al gusto
(52, 11, 36, 1.00, 1),   -- Sal, pimienta y orégano al gusto (aprox. 1 g)
(53, 11, 20, 1.00, 6)    -- 1 cucharadita de aceite de oliva (para cocción)
ON DUPLICATE KEY UPDATE
  idreceta = VALUES(idreceta),
  idalimento = VALUES(idalimento),
  cantidad = VALUES(cantidad),
  idunidadalimento = VALUES(idunidadalimento);

-- 4. AlimentoComponenteNutricional (Relaciones nutricionales de los ingredientes)
-- 1:Proteínas, 2:Carbohidratos, 3:Grasas Totales, 5:Grasas Monoinsaturadas, 7:Fibra Dietética, 9:Calorías, 10:Sodio, 11:Potasio, 12:Calcio, 13:Magnesio, 14:Hierro, 16:Fósforo, 17:Vitamina C
INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES
-- Zanahoria (id 46)
(46, 2), (46, 7), (46, 9), (46, 11), (46, 17),
-- Calabacín (id 47)
(47, 2), (47, 7), (47, 9), (47, 11), (47, 17),
-- Queso Bajo en Grasa (id 48)
(48, 1), (48, 3), (48, 9), (48, 12), (48, 16),
-- Perejil Fresco (id 49)
(49, 7), (49, 11), (49, 14), (49, 17),
-- Aceite de Oliva Virgen Extra (id 20)
(20, 3), (20, 5), (20, 9);

-- 5. RecetaComponenteNutricional (Componentes globales de la Receta 11 por porción)
-- Datos infografía: Calorías 160 kcal, Proteínas 9g, Carbohidratos 14g, Grasas 7g, Fibra 3g
INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES
(11, 1),   -- Proteínas (9 g por porción - huevos, avena, queso)
(11, 2),   -- Carbohidratos Totales (14 g por porción - avena, zanahoria, calabacín)
(11, 3),   -- Grasas Totales (7 g por porción - huevos, aceite de oliva, queso)
(11, 5),   -- Grasas Monoinsaturadas (aceite de oliva, huevo)
(11, 7),   -- Fibra Dietética (3 g por porción - avena, zanahoria, calabacín)
(11, 9),   -- Calorías / Valor Energético (160 kcal por porción)
(11, 10),  -- Sodio (sal y condimentos)
(11, 11),  -- Potasio (calabacín, zanahoria)
(11, 12),  -- Calcio (queso bajo en grasa, huevo, avena)
(11, 13),  -- Magnesio (avena)
(11, 14),  -- Hierro (huevo, avena, perejil)
(11, 16),  -- Fósforo (huevo, queso, avena)
(11, 17),  -- Vitamina C (zanahoria, calabacín, perejil)
(11, 18),  -- Vitamina D (huevo)
(11, 19);  -- Vitamina B12 (huevo, queso)

-- 6. Imágenes
INSERT INTO `imagen` (`idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio`) VALUES
(30, '20261102_080000-00030.jpg', 1, '2026-11-02 08:00:00', 'Plato saludable de tortitas doradas de zanahoria y calabacín a la plancha, ricas en fibra y bajas en calorías', 'tortitas,tortilla,zanahoria,calabacin,desayuno,cena,saludable,fibra', 'Libre', '2026-11-02 08:00:00', 1, 1),
(31, '20261102_080001-00031.png', 2, '2026-11-02 08:00:01', 'Ficha e infografía completa de la receta Tortitas de Zanahoria y Calabacín con ingredientes, pasos de preparación, tiempos, porciones e información nutricional', 'tortitas,tortilla,zanahoria,calabacin,receta,infografia,preparacion,nutricion,beneficios', 'Propietaria', '2026-11-02 08:00:01', 1, 1),
(32, '20261102_080002-00032.jpg', 1, '2026-11-02 08:00:02', 'Zanahoria fresca rallada rica en betacarotenos, vitamina A y fibra dietética', 'zanahoria,hortaliza,betacaroteno,fibra,ingrediente', 'Libre', '2026-11-02 08:00:02', 1, 1),
(33, '20261102_080003-00033.jpg', 1, '2026-11-02 08:00:03', 'Calabacín fresco rallado bajo en calorías y rico en potasio y agua', 'calabacin,zucchini,hortaliza,potasio,ligero,ingrediente', 'Libre', '2026-11-02 08:00:03', 1, 1),
(34, '20261102_080004-00034.jpg', 1, '2026-11-02 08:00:04', 'Avena molida y en hojuelas finas fuente de energía compleja y fibra saciante', 'avena,cereal,fibra,carbohidratos complejos,ingrediente', 'Libre', '2026-11-02 08:00:04', 1, 1),
(35, '20261102_080005-00035.jpg', 1, '2026-11-02 08:00:05', 'Queso bajo en grasa rallado para tortitas ligeras con proteínas y calcio', 'queso,queso bajo en grasa,lacteo magro,proteina,calcio,ingrediente', 'Libre', '2026-11-02 08:00:05', 1, 1),
(36, '20261102_080006-00036.jpg', 1, '2026-11-02 08:00:06', 'Perejil o cilantro picado fresco aromático rico en vitamina C y antioxidantes', 'perejil,cilantro,hierba aromatica,antioxidantes,ingrediente', 'Libre', '2026-11-02 08:00:06', 1, 1),
(37, '20261102_080007-00037.jpg', 1, '2026-11-02 08:00:07', 'Aceite de oliva virgen extra cardiosaludable para cocción antiadherente', 'aceite de oliva,grasas saludables,monoinsaturadas,ingrediente', 'Libre', '2026-11-02 08:00:07', 1, 1)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  idformatoimagen = VALUES(idformatoimagen),
  fechacaptura = VALUES(fechacaptura),
  descripcion = VALUES(descripcion),
  palabrasclave = VALUES(palabrasclave),
  licencia = VALUES(licencia),
  idordenador = VALUES(idordenador),
  iddirectorio = VALUES(iddirectorio);

-- 7. ImagenReceta (Asociar plato e infografía a la receta 11)
INSERT INTO `imagenreceta` (`idimagenreceta`, `idimagen`, `idreceta`) VALUES
(13, 30, 11),
(14, 31, 11)
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idreceta = VALUES(idreceta);

-- 8. ImagenAlimento (Asociar imágenes a los ingredientes)
INSERT INTO `imagenalimento` (`idimagenalimento`, `idimagen`, `idalimento`) VALUES
(20, 32, 46),  -- Zanahoria
(21, 33, 47),  -- Calabacín
(22, 34, 8),   -- Avena en Hojuelas
(23, 35, 48),  -- Queso Bajo en Grasa
(24, 36, 49),  -- Perejil Fresco
(25, 37, 20)   -- Aceite de Oliva Virgen Extra
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idalimento = VALUES(idalimento);

SET foreign_key_checks = 1;
