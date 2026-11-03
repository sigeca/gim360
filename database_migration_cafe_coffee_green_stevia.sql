-- ==============================================================================
-- Migración Gim360: Registro de Receta Café con Coffee Green y Stevia,
-- Ingredientes, Componentes Nutricionales, Video e Imágenes Asociadas.
-- ==============================================================================

SET NAMES utf8mb4;
SET foreign_key_checks = 0;

-- 1. Alimentos (Nuevos ingredientes de la receta si no existen)
-- Nota: Agua caliente utiliza idalimento = 34 (Agua Purificada), previamente registrado.
INSERT INTO `alimento` (`idalimento`, `idgrupo`, `nombre`, `descripcion`) VALUES
(54, 8, 'Café Molido', 'Café tostado molido o soluble rico en cafeína, antioxidantes y polifenoles. Estimula el sistema nervioso central, incrementa la concentración, reduce la fatiga percibida y optimiza el rendimiento físico y cognitivo.'),
(55, 8, 'Coffee Green', 'Café verde en polvo elaborado con granos de café sin tostar, altamente concentrado en ácido clorogénico y antioxidantes bioactivos que favorecen la termogénesis, el metabolismo lipídico y el control de glucosa.'),
(56, 8, 'Stevia', 'Endulzante vegetal natural extraído de la Stevia rebaudiana. Proporciona dulzor de alta intensidad sin aportar calorías ni carbohidratos netos, manteniendo estables los niveles de insulina y glucemia.')
ON DUPLICATE KEY UPDATE 
  idgrupo = VALUES(idgrupo),
  nombre = VALUES(nombre),
  descripcion = VALUES(descripcion);

-- 2. Receta: Café con Coffee Green y Stevia
INSERT INTO `receta` (`idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`, `video`) VALUES
(14, 'Café con Coffee Green y Stevia', 
'1. Calienta el agua (≈ 90–95 °C).
2. Prepara el café en tu taza.
3. Añade el Coffee Green y mezcla bien.
4. Endulza con stevia al gusto.
5. Disfruta caliente.', 
1, 5, 'https://www.youtube.com/watch?v=RUpq04VQp4U')
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  instrucciones = VALUES(instrucciones),
  porciones = VALUES(porciones),
  tiempopreparacion = VALUES(tiempopreparacion),
  video = VALUES(video);

-- 3. AlimentoReceta (Ingredientes y cantidades para la Receta 14: Café con Coffee Green y Stevia)
-- Unidades: 6=Cucharadita (cdta), 7=Taza (tz)
INSERT INTO `alimentoreceta` (`idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`) VALUES
(69, 14, 54, 1.00, 6),  -- Café molido (o soluble): 1 cucharadita (≈ 5 g)
(70, 14, 55, 1.00, 6),  -- Coffee Green (café verde en polvo): 1 cucharadita (≈ 3 g)
(71, 14, 56, 0.50, 6),  -- Stevia (polvo o gotas): al gusto (≈ 0.5 cdta)
(72, 14, 34, 1.00, 7)   -- Agua caliente (Agua Purificada): 1 taza (≈ 240 ml)
ON DUPLICATE KEY UPDATE
  idreceta = VALUES(idreceta),
  idalimento = VALUES(idalimento),
  cantidad = VALUES(cantidad),
  idunidadalimento = VALUES(idunidadalimento);

-- 4. AlimentoComponenteNutricional (Relaciones nutricionales de los ingredientes)
-- 2:Carbohidratos, 7:Fibra, 9:Calorías, 10:Sodio, 11:Potasio, 12:Calcio, 13:Magnesio, 16:Fósforo
INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES
-- Café Molido (id 54)
(54, 2), (54, 7), (54, 9), (54, 10), (54, 11), (54, 13), (54, 16),
-- Coffee Green (id 55)
(55, 2), (55, 7), (55, 9), (55, 11), (55, 13),
-- Stevia (id 56)
(56, 2), (56, 9);

-- 5. RecetaComponenteNutricional (Componentes globales de la Receta 14 por porción)
INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES
(14, 2),   -- Carbohidratos Totales (trazas bioactivas)
(14, 7),   -- Fibra Dietética (polifenoles y solubles)
(14, 9),   -- Calorías / Valor Energético (mínimo aporte calórico, efecto termogénico)
(14, 10),  -- Sodio (electrolitos de agua y café)
(14, 11),  -- Potasio (electrolito del café)
(14, 12),  -- Calcio (mineral del agua)
(14, 13),  -- Magnesio (mineral del café y agua)
(14, 16);  -- Fósforo (mineral del café)

-- 6. Imágenes
INSERT INTO `imagen` (`idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio`) VALUES
(49, '20261103_101500-00049.jpg', 1, '2026-11-03 10:15:00', 'Taza de café recién preparado con Coffee Green y stevia, servido caliente con granos tostados, hojas de stevia fresca y café verde en polvo', 'cafe,coffeegreen,stevia,antioxidante,energia,termogenico,receta,bebida,desayuno,preentreno', 'Libre', '2026-11-03 10:15:00', 1, 1),
(50, '20261103_101501-00050.png', 2, '2026-11-03 10:15:01', 'Ficha e infografía completa de la receta Café con Coffee Green y Stevia con ingredientes, pasos de preparación, tips de consumo y beneficios nutricionales', 'cafe,coffeegreen,stevia,receta,infografia,preparacion,beneficios,tips,ingredientes', 'Propietaria', '2026-11-03 10:15:01', 1, 1),
(51, '20261103_101502-00051.jpg', 1, '2026-11-03 10:15:02', 'Café tostado y molido fino para preparación filtrada o infusión energizante rica en cafeína y polifenoles', 'cafe,cafemolido,ingrediente,cafeina,antioxidantes,energia', 'Libre', '2026-11-03 10:15:02', 1, 1),
(52, '20261103_101503-00052.jpg', 1, '2026-11-03 10:15:03', 'Café verde en polvo obtenido de granos sin tostar, rico en ácido clorogénico para acelerar el metabolismo y aportar antioxidantes', 'coffeegreen,cafeverde,polvo,acidoclorogenico,antioxidante,metabolismo,ingrediente', 'Libre', '2026-11-03 10:15:03', 1, 1),
(53, '20261103_101504-00053.jpg', 1, '2026-11-03 10:15:04', 'Stevia natural en hojas y polvo endulzante sin calorías ni impacto glucémico', 'stevia,endulzante,hojas,sinazucar,natural,ingrediente', 'Libre', '2026-11-03 10:15:04', 1, 1)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  idformatoimagen = VALUES(idformatoimagen),
  fechacaptura = VALUES(fechacaptura),
  descripcion = VALUES(descripcion),
  palabrasclave = VALUES(palabrasclave),
  licencia = VALUES(licencia),
  idordenador = VALUES(idordenador),
  iddirectorio = VALUES(iddirectorio);

-- 7. ImagenReceta (Asociar plato servido e infografía a la receta 14: Café con Coffee Green y Stevia)
INSERT INTO `imagenreceta` (`idimagenreceta`, `idimagen`, `idreceta`) VALUES
(19, 49, 14),
(20, 50, 14)
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idreceta = VALUES(idreceta);

-- 8. ImagenAlimento (Asociar imágenes a los ingredientes correspondientes)
INSERT INTO `imagenalimento` (`idimagenalimento`, `idimagen`, `idalimento`) VALUES
(33, 51, 54),  -- Café Molido
(34, 52, 55),  -- Coffee Green
(35, 53, 56)   -- Stevia
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idalimento = VALUES(idalimento);

SET foreign_key_checks = 1;
