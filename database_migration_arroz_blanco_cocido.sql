-- ==============================================================================
-- Migración Gim360: Registro de Arroz Blanco Cocido, Ingredientes,
-- Componentes Nutricionales e Imágenes Asociadas.
-- ==============================================================================

SET NAMES utf8mb4;
SET foreign_key_checks = 0;

-- 1. Nuevos Alimentos (Ingredientes del Arroz Blanco Cocido y complementos)
INSERT INTO `alimento` (`idalimento`, `idgrupo`, `nombre`, `descripcion`) VALUES
(34, 8, 'Agua Purificada', 'Agua potable purificada esencial para la hidratación celular, equilibrio hidroelectrolítico y vehículo indispensable en la cocción de alimentos sin aporte calórico.'),
(35, 2, 'Mantequilla', 'Derivado lácteo graso rico en ácidos grasos de rápida disponibilidad energética, vitamina A, vitamina D y calcio, que aporta suavidad y palatabilidad a las preparaciones.'),
(36, 6, 'Sal Común / Sal Marina', 'Mineral esencial compuesto por cloruro de sodio, indispensable para el balance osmótico, conducción de impulsos nerviosos y realce del sabor.')
ON DUPLICATE KEY UPDATE 
  idgrupo = VALUES(idgrupo),
  nombre = VALUES(nombre),
  descripcion = VALUES(descripcion);

-- 2. Receta: Arroz Blanco Cocido
INSERT INTO `receta` (`idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`) VALUES
(7, 'Arroz Blanco Cocido', 
'1. Lava el arroz hasta que el agua salga clara.
2. En una olla, calienta el aceite o mantequilla y sofríe el arroz por 1 minuto.
3. Agrega las 2 tazas de agua y la sal. Mezcla y deja hervir.
4. Cuando hierva, baja el fuego, tapa la olla y cocina por 15-18 minutos, hasta que el agua se absorba.
5. Consejo: Deja reposar el arroz tapado 5 minutos antes de servir, para que quede más suelto y esponjoso.', 
4, 25)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  instrucciones = VALUES(instrucciones),
  porciones = VALUES(porciones),
  tiempopreparacion = VALUES(tiempopreparacion);

-- 3. AlimentoReceta (Ingredientes y cantidades para la Receta 7: Arroz Blanco Cocido)
-- idunidadalimento: 1=Gramo, 3=Mililitro, 6=Cucharadita, 7=Taza
INSERT INTO `alimentoreceta` (`idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`) VALUES
(22, 7, 9, 200.00, 1),   -- 200 g (1 taza) de Arroz Blanco
(23, 7, 34, 500.00, 3),  -- 500 ml (2 tazas) de Agua Purificada
(24, 7, 35, 1.00, 6),    -- 1 cdta de Mantequilla (o aceite) (opcional)
(25, 7, 36, 2.00, 1)     -- 2 g de Sal (al gusto)
ON DUPLICATE KEY UPDATE
  idreceta = VALUES(idreceta),
  idalimento = VALUES(idalimento),
  cantidad = VALUES(cantidad),
  idunidadalimento = VALUES(idunidadalimento);

-- 4. AlimentoComponenteNutricional (Relaciones nutricionales de los ingredientes)
-- Componentes: 1:Proteínas, 2:Carbohidratos Totales, 3:Grasas Totales, 4:Grasas Saturadas,
-- 7:Fibra Dietética, 9:Calorías, 10:Sodio, 11:Potasio, 12:Calcio, 13:Magnesio, 14:Hierro, 16:Fósforo, 18:Vitamina D
INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES
-- Arroz Blanco (id 9)
(9, 1), (9, 2), (9, 7), (9, 9), (9, 10), (9, 11), (9, 13), (9, 14), (9, 16),
-- Agua Purificada (id 34)
(34, 10), (34, 11), (34, 12), (34, 13),
-- Mantequilla (id 35)
(35, 3), (35, 4), (35, 9), (35, 12), (35, 18),
-- Sal (id 36)
(36, 10);

-- 5. RecetaComponenteNutricional (Componentes globales del Arroz Blanco Cocido)
INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES
(7, 1),   -- Proteínas (Arroz)
(7, 2),   -- Carbohidratos Totales (Aporte principal energético)
(7, 3),   -- Grasas Totales (Mantequilla/Aceite)
(7, 7),   -- Fibra Dietética (Arroz)
(7, 9),   -- Calorías / Valor Energético
(7, 10),  -- Sodio (Sal y agua)
(7, 11),  -- Potasio (Arroz)
(7, 12),  -- Calcio (Mantequilla y agua)
(7, 13),  -- Magnesio (Arroz)
(7, 14),  -- Hierro (Arroz)
(7, 16);  -- Fósforo (Arroz)

-- 6. Imágenes
INSERT INTO `imagen` (`idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio`) VALUES
(9, '20261031_171500-00009.jpg', 1, '2026-10-31 17:15:00', 'Plato de arroz blanco cocido esponjoso humeante servido en tazón de cerámica artesanal con cilantro', 'arroz,blanco,cocido,receta,guarnicion,carbohidrato', 'Libre', '2026-10-31 17:15:00', 1, 1),
(10, '20261031_171501-00010.png', 2, '2026-10-31 17:15:01', 'Ficha e infografía de la receta Arroz Blanco Cocido con ingredientes y preparación paso a paso', 'arroz,receta,infografia,ingredientes,preparacion,cocina', 'Propietaria', '2026-10-31 17:15:01', 1, 1),
(11, '20261031_171502-00011.jpg', 1, '2026-10-31 17:15:02', 'Bloque de mantequilla fresca artesanal sobre tabla de madera para cocinar', 'mantequilla,lacteo,grasa,cocina,ingrediente', 'Libre', '2026-10-31 17:15:02', 1, 1),
(12, '20261031_171503-00012.jpg', 1, '2026-10-31 17:15:03', 'Sal marina pura en cuenco rústico de madera con cuchara dosificadora', 'sal,mineral,sodio,condimento,ingrediente', 'Libre', '2026-10-31 17:15:03', 1, 1),
(13, '20261031_171504-00013.jpg', 1, '2026-10-31 17:15:04', 'Vaso de agua pura y fresca cristalina con gotas de condensación', 'agua,hidratacion,liquido,pureza,ingrediente', 'Libre', '2026-10-31 17:15:04', 1, 1)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  idformatoimagen = VALUES(idformatoimagen),
  fechacaptura = VALUES(fechacaptura),
  descripcion = VALUES(descripcion),
  palabrasclave = VALUES(palabrasclave),
  licencia = VALUES(licencia),
  idordenador = VALUES(idordenador),
  iddirectorio = VALUES(iddirectorio);

-- 7. ImagenReceta (Asociar imágenes 9 y 10 a la receta 7: Arroz Blanco Cocido)
INSERT INTO `imagenreceta` (`idimagenreceta`, `idimagen`, `idreceta`) VALUES
(5, 9, 7),
(6, 10, 7)
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idreceta = VALUES(idreceta);

-- 8. ImagenAlimento (Asociar imágenes de alimentos e ingredientes)
INSERT INTO `imagenalimento` (`idimagenalimento`, `idimagen`, `idalimento`) VALUES
(7, 13, 34),  -- Agua
(8, 11, 35),  -- Mantequilla
(9, 12, 36)   -- Sal
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idalimento = VALUES(idalimento);

SET foreign_key_checks = 1;
