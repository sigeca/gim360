-- ==============================================================================
-- Migración Gim360: Registro de Encebollado de Pescado (Albacora), Ingredientes,
-- Componentes Nutricionales e Imágenes Asociadas.
-- ==============================================================================

SET NAMES utf8mb4;
SET foreign_key_checks = 0;

-- 1. Nuevos Alimentos (Ingredientes del Encebollado)
INSERT INTO `alimento` (`idalimento`, `idgrupo`, `nombre`, `descripcion`) VALUES
(24, 1, 'Pescado Albacora', 'Pescado azul rico en proteínas de alto valor biológico, ácidos grasos esenciales omega-3 (EPA y DHA), potasio, fósforo, magnesio y vitaminas del complejo B (especialmente B12).'),
(25, 3, 'Yuca', 'Tubérculo rico en almidones complejos y carbohidratos de absorción gradual, libre de gluten, con fibra dietética, potasio, magnesio y vitamina C.'),
(26, 6, 'Cebolla Colorada', 'Hortaliza rica en quercetina, compuestos sulfurados antioxidantes, potasio y vitamina C, con propiedades antiinflamatorias y diuréticas.'),
(27, 6, 'Tomate Riñón', 'Hortaliza rica en licopeno (carotenoide antioxidante), vitamina C, potasio y ácido fólico, favorecedora de la salud cardiovascular.'),
(28, 6, 'Pimiento Verde', 'Hortaliza rica en vitamina C, antioxidantes, agua y fibra vegetal, de mínimo aporte calórico.'),
(29, 6, 'Ajo', 'Hortaliza con alicina y fitoquímicos azufrados de probada acción antioxidante, antimicrobiana y reguladora de la tensión.'),
(30, 6, 'Cilantro Fresco', 'Hierba aromática rica en fitonutrientes, flavonoides digestivos, vitamina C, vitamina K y minerales como hierro y potasio.'),
(31, 6, 'Comino Molido', 'Especia aromática rica en aceites esenciales, terpenos, hierro y magnesio que estimula la secreción de enzimas digestivas.'),
(32, 7, 'Achiote (Pasta o Aceite)', 'Condimento natural a base de semillas de Bixa orellana rico en bixina, norbixina (carotenoides) y tocotrienoles protectores.'),
(33, 5, 'Limón', 'Fruto cítrico con elevada concentración de vitamina C y ácido cítrico que estimula la absorción de hierro y balance electrolítico.')
ON DUPLICATE KEY UPDATE 
  idgrupo = VALUES(idgrupo),
  nombre = VALUES(nombre),
  descripcion = VALUES(descripcion);

-- 2. Receta: Encebollado de Pescado (Albacora)
INSERT INTO `receta` (`idreceta`, `nombre`, `instrucciones`, `porciones`, `tiempopreparacion`) VALUES
(6, 'Encebollado de Pescado (Albacora)', 
'1. Cocina la yuca en una olla con agua y sal hasta que esté suave. Retira, corta en trozos y reserva.
2. En la misma olla, prepara un refrito con achiote, ajo, tomate y pimiento picados.
3. Agrega agua, sal, comino y pimienta. Cocina por unos minutos.
4. Incorpora el pescado albacora en trozos y cocina hasta que esté tierno.
5. Aplasta ligeramente parte de la yuca en la sopa para espesar.
6. Sirve caliente, acompañado de cebolla colorada encurtida con limón y cilantro picado.', 
4, 45)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  instrucciones = VALUES(instrucciones),
  porciones = VALUES(porciones),
  tiempopreparacion = VALUES(tiempopreparacion);

-- 3. AlimentoReceta (Ingredientes y cantidades para la Receta 6)
INSERT INTO `alimentoreceta` (`idalimentoreceta`, `idreceta`, `idalimento`, `cantidad`, `idunidadalimento`) VALUES
(12, 6, 24, 500.00, 1),   -- 500 g de pescado albacora
(13, 6, 25, 1000.00, 1),  -- 1 kg (1000 g) de yuca
(14, 6, 26, 2.00, 8),     -- 2 cebollas coloradas (unidades)
(15, 6, 27, 2.00, 8),     -- 2 tomates riñón (unidades)
(16, 6, 28, 1.00, 8),     -- 1 pimiento verde (unidad)
(17, 6, 29, 2.00, 8),     -- 2 dientes de ajo (unidades)
(18, 6, 30, 1.00, 8),     -- 1 rama de cilantro (unidad)
(19, 6, 31, 1.00, 5),     -- 1 cucharada de comino
(20, 6, 32, 1.00, 5),     -- 1 cucharada de achiote
(21, 6, 33, 2.00, 8)      -- 2 limones para servir (unidades)
ON DUPLICATE KEY UPDATE
  idreceta = VALUES(idreceta),
  idalimento = VALUES(idalimento),
  cantidad = VALUES(cantidad),
  idunidadalimento = VALUES(idunidadalimento);

-- 4. AlimentoComponenteNutricional (Relaciones nutricionales de los ingredientes)
-- Componentes: 1:Proteínas, 2:Carbohidratos, 3:Grasas Totales, 5:Monoinsaturadas, 6:Poliinsaturadas/Omega-3,
-- 7:Fibra, 8:Azúcares, 9:Calorías, 10:Sodio, 11:Potasio, 13:Magnesio, 14:Hierro, 15:Zinc, 16:Fósforo,
-- 17:Vitamina C, 18:Vitamina D, 19:Vitamina B12
INSERT IGNORE INTO `alimentocomponentenutricional` (`idalimento`, `idcomponentenutricional`) VALUES
-- Pescado Albacora (id 24)
(24, 1), (24, 3), (24, 6), (24, 9), (24, 10), (24, 11), (24, 13), (24, 14), (24, 16), (24, 18), (24, 19),
-- Yuca (id 25)
(25, 2), (25, 7), (25, 9), (25, 11), (25, 13), (25, 17),
-- Cebolla Colorada (id 26)
(26, 2), (26, 7), (26, 8), (26, 11), (26, 17),
-- Tomate Riñón (id 27)
(27, 2), (27, 7), (27, 11), (27, 17),
-- Pimiento Verde (id 28)
(28, 2), (28, 7), (28, 11), (28, 17),
-- Ajo (id 29)
(29, 11), (29, 13), (29, 14), (29, 15), (29, 16),
-- Cilantro Fresco (id 30)
(30, 7), (30, 11), (30, 14), (30, 17),
-- Comino Molido (id 31)
(31, 7), (31, 13), (31, 14),
-- Achiote (id 32)
(32, 3), (32, 5), (32, 9),
-- Limón (id 33)
(33, 7), (33, 11), (33, 17);

-- 5. RecetaComponenteNutricional (Componentes globales del Encebollado de Pescado)
INSERT IGNORE INTO `recetacomponentenutricional` (`idreceta`, `idcomponentenutricional`) VALUES
(6, 1),   -- Proteínas (Albacora)
(6, 2),   -- Carbohidratos Totales (Yuca)
(6, 3),   -- Grasas Totales
(6, 6),   -- Grasas Poliinsaturadas / Omega-3 (Albacora)
(6, 7),   -- Fibra Dietética (Yuca, cebolla, vegetales)
(6, 9),   -- Calorías / Valor Energético
(6, 10),  -- Sodio (Caldo y sazón)
(6, 11),  -- Potasio (Yuca, albacora, verduras)
(6, 13),  -- Magnesio (Albacora y yuca)
(6, 14),  -- Hierro (Albacora y cilantro)
(6, 16),  -- Fósforo (Albacora)
(6, 17),  -- Vitamina C (Limón, tomate, pimiento, cilantro)
(6, 19);  -- Vitamina B12 (Albacora)

-- 6. Imágenes
INSERT INTO `imagen` (`idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio`) VALUES
(4, '20261031_143000-00004.jpg', 1, '2026-10-31 14:30:00', 'Encebollado de pescado tradicional ecuatoriano servido en tazón con chifles y limón', 'encebollado,pescado,albacora,ecuador,receta,gastronomia', 'Libre', '2026-10-31 14:30:00', 1, 1),
(5, '20261031_143001-00005.png', 2, '2026-10-31 14:30:01', 'Ficha e infografía de la receta Encebollado de Pescado Albacora con ingredientes y preparación', 'encebollado,receta,infografia,ingredientes,preparacion', 'Propietaria', '2026-10-31 14:30:01', 1, 1),
(6, '20261031_143002-00006.jpg', 1, '2026-10-31 14:30:02', 'Lomo fresco de pescado albacora de alta calidad nutricional', 'albacora,pescado,proteina,omega3,ingrediente', 'Libre', '2026-10-31 14:30:02', 1, 1),
(7, '20261031_143003-00007.jpg', 1, '2026-10-31 14:30:03', 'Yuca fresca entera y en trozos para cocción', 'yuca,tuberculo,carbohidratos,energia,ingrediente', 'Libre', '2026-10-31 14:30:03', 1, 1),
(8, '20261031_143004-00008.jpg', 1, '2026-10-31 14:30:04', 'Cebolla colorada fresca entera y en rodajas', 'cebolla,colorada,morada,antioxidante,ingrediente', 'Libre', '2026-10-31 14:30:04', 1, 1)
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre),
  idformatoimagen = VALUES(idformatoimagen),
  fechacaptura = VALUES(fechacaptura),
  descripcion = VALUES(descripcion),
  palabrasclave = VALUES(palabrasclave),
  licencia = VALUES(licencia),
  idordenador = VALUES(idordenador),
  iddirectorio = VALUES(iddirectorio);

-- 7. ImagenReceta (Asociar imágenes 4 y 5 a la receta 6)
INSERT INTO `imagenreceta` (`idimagenreceta`, `idimagen`, `idreceta`) VALUES
(3, 4, 6),
(4, 5, 6)
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idreceta = VALUES(idreceta);

-- 8. ImagenAlimento (Asociar imágenes de ingredientes: albacora, yuca, cebolla)
INSERT INTO `imagenalimento` (`idimagenalimento`, `idimagen`, `idalimento`) VALUES
(4, 6, 24),
(5, 7, 25),
(6, 8, 26)
ON DUPLICATE KEY UPDATE
  idimagen = VALUES(idimagen),
  idalimento = VALUES(idalimento);

SET foreign_key_checks = 1;
