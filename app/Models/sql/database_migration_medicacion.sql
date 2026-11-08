-- ==============================================================================
-- Migración Consolidada: Sección de Salud, Medicamentos y Medicaciones (Gim360)
-- Tablas incluidas:
--   1. afeccion
--   2. medicamento
--   3. medicacion (receta/tratamiento para aliviar una afección)
--   4. medicacionmedicamento (relación N:M entre medicacion y medicamento con dosis/indicaciones)
--   5. mimedicacion (personalización de medicación por persona)
--   6. mimedicacionmedicamento (medicamentos personalizados en la medicación de la persona)
-- ==============================================================================
-- Script 100% seguro e idempotente (CREATE TABLE IF NOT EXISTS / INSERT IGNORE)
-- ==============================================================================

-- 1. Tabla afeccion
CREATE TABLE IF NOT EXISTS `afeccion` (
  `idafeccion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `sintomas` text DEFAULT NULL,
  PRIMARY KEY (`idafeccion`),
  UNIQUE KEY `uk_afeccion_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Afeccion` AS
SELECT `idafeccion`, `nombre`, `descripcion`, `sintomas`
FROM `afeccion`;

-- 2. Tabla medicamento
CREATE TABLE IF NOT EXISTS `medicamento` (
  `idmedicamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `principioactivo` varchar(150) DEFAULT NULL,
  `concentracion` varchar(100) DEFAULT NULL,
  `presentacion` varchar(100) DEFAULT NULL,
  `laboratorio` varchar(150) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `indicaciones` text DEFAULT NULL,
  `contraindicaciones` text DEFAULT NULL,
  PRIMARY KEY (`idmedicamento`),
  UNIQUE KEY `uk_medicamento_nombre_conc` (`nombre`, `concentracion`, `presentacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Medicamento` AS
SELECT `idmedicamento`, `nombre`, `principioactivo`, `concentracion`, `presentacion`, `laboratorio`, `descripcion`, `indicaciones`, `contraindicaciones`
FROM `medicamento`;

-- 3. Tabla medicacion (receta o protocolo médico para aliviar una afección)
CREATE TABLE IF NOT EXISTS `medicacion` (
  `idmedicacion` int(11) NOT NULL AUTO_INCREMENT,
  `idafeccion` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `duracion` varchar(100) DEFAULT NULL,
  `recomendaciones` text DEFAULT NULL,
  PRIMARY KEY (`idmedicacion`),
  KEY `fk_med_afeccion` (`idafeccion`),
  CONSTRAINT `fk_med_afeccion` FOREIGN KEY (`idafeccion`) REFERENCES `afeccion` (`idafeccion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `Medicacion` AS
SELECT `idmedicacion`, `idafeccion`, `nombre`, `descripcion`, `duracion`, `recomendaciones`
FROM `medicacion`;

-- 4. Tabla relacional medicacionmedicamento
CREATE TABLE IF NOT EXISTS `medicacionmedicamento` (
  `idmedicacionmedicamento` int(11) NOT NULL AUTO_INCREMENT,
  `idmedicacion` int(11) NOT NULL,
  `idmedicamento` int(11) NOT NULL,
  `dosis` varchar(150) DEFAULT NULL,
  `frecuencia` varchar(150) DEFAULT NULL,
  `instrucciones` text DEFAULT NULL,
  PRIMARY KEY (`idmedicacionmedicamento`),
  UNIQUE KEY `uk_medicacion_medicamento` (`idmedicacion`, `idmedicamento`),
  KEY `fk_mm_medicacion` (`idmedicacion`),
  KEY `fk_mm_medicamento` (`idmedicamento`),
  CONSTRAINT `fk_mm_medicacion` FOREIGN KEY (`idmedicacion`) REFERENCES `medicacion` (`idmedicacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mm_medicamento` FOREIGN KEY (`idmedicamento`) REFERENCES `medicamento` (`idmedicamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `MedicacionMedicamento` AS
SELECT `idmedicacionmedicamento`, `idmedicacion`, `idmedicamento`, `dosis`, `frecuencia`, `instrucciones`
FROM `medicacionmedicamento`;

-- 5. Tabla mimedicacion (personalización de medicación por persona)
CREATE TABLE IF NOT EXISTS `mimedicacion` (
  `idmimedicacion` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  `idafeccion` int(11) DEFAULT NULL,
  `idmedicacion` int(11) DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `medicotratante` varchar(150) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'Activa',
  PRIMARY KEY (`idmimedicacion`),
  KEY `fk_mm_persona` (`idpersona`),
  KEY `fk_mm_base_afeccion` (`idafeccion`),
  KEY `fk_mm_base_medicacion` (`idmedicacion`),
  CONSTRAINT `fk_mm_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mm_base_afeccion` FOREIGN KEY (`idafeccion`) REFERENCES `afeccion` (`idafeccion`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_mm_base_medicacion` FOREIGN KEY (`idmedicacion`) REFERENCES `medicacion` (`idmedicacion`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `MiMedicacion` AS
SELECT `idmimedicacion`, `idpersona`, `idafeccion`, `idmedicacion`, `nombre`, `descripcion`, `fechainicio`, `fechafin`, `medicotratante`, `estado`
FROM `mimedicacion`;

-- 6. Tabla mimedicacionmedicamento (medicamentos de la medicación personalizada)
CREATE TABLE IF NOT EXISTS `mimedicacionmedicamento` (
  `idmimedicacionmedicamento` int(11) NOT NULL AUTO_INCREMENT,
  `idmimedicacion` int(11) NOT NULL,
  `idmedicamento` int(11) NOT NULL,
  `dosis` varchar(150) DEFAULT NULL,
  `frecuencia` varchar(150) DEFAULT NULL,
  `instrucciones` text DEFAULT NULL,
  PRIMARY KEY (`idmimedicacionmedicamento`),
  UNIQUE KEY `uk_mimedicacion_medicamento` (`idmimedicacion`, `idmedicamento`),
  KEY `fk_mmm_mimedicacion` (`idmimedicacion`),
  KEY `fk_mmm_medicamento` (`idmedicamento`),
  CONSTRAINT `fk_mmm_mimedicacion` FOREIGN KEY (`idmimedicacion`) REFERENCES `mimedicacion` (`idmimedicacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mmm_medicamento` FOREIGN KEY (`idmedicamento`) REFERENCES `medicamento` (`idmedicamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE OR REPLACE VIEW `MiMedicacionMedicamento` AS
SELECT `idmimedicacionmedicamento`, `idmimedicacion`, `idmedicamento`, `dosis`, `frecuencia`, `instrucciones`
FROM `mimedicacionmedicamento`;

-- ==============================================================================
-- Datos semilla iniciales (INSERT IGNORE)
-- ==============================================================================

-- Afecciones comunes en el ámbito de la salud y el entrenamiento
INSERT IGNORE INTO `afeccion` (`idafeccion`, `nombre`, `descripcion`, `sintomas`) VALUES
(1, 'Dolor Muscular Tardío (DOMS) e Inflamación Post-Entreno', 'Inflamación y microrroturas de fibras musculares producto de esfuerzo físico intenso no habitual.', 'Dolor al tacto, rigidez articular, debilidad temporal e hinchazón leve.'),
(2, 'Tendinitis Rotuliana o Aquílea', 'Inflamación de los tendones provocada por sobrecarga repetitiva o impacto en saltos y carreras.', 'Dolor localizado en el tendón, calor, rigidez matutina y molestia al iniciar movimiento.'),
(3, 'Hipertensión Arterial Grado 1', 'Elevación crónica de la presión arterial sistólica y/o diastólica controlable con hábitos y fármacos.', 'Cefalea occipital leve, mareos ocasionales o asintomático.'),
(4, 'Contractura y Espasmo Muscular Cervical/Lumbar', 'Contracción mantenida e involuntaria de grupos musculares de la columna.', 'Dolor constante, nudos palpables, limitación de rango de movimiento.'),
(5, 'Asma Inducida por Ejercicio', 'Estrechamiento temporal de las vías respiratorias durante o después de la actividad física aeróbica.', 'Dificultad respiratoria, sibilancias al exhalar, tos seca y opresión torácica.');

-- Medicamentos esenciales
INSERT IGNORE INTO `medicamento` (`idmedicamento`, `nombre`, `principioactivo`, `concentracion`, `presentacion`, `laboratorio`, `descripcion`, `indicaciones`, `contraindicaciones`) VALUES
(1, 'Ibuprofeno 400 mg', 'Ibuprofeno', '400 mg', 'Tabletas / Cápsulas blandas', 'Genfar / Mk', 'Antiinflamatorio no esteroideo (AINE) con acción analgésica y antipirética.', 'Alivio del dolor e inflamación muscular y articular.', 'Úlcera péptica activa, insuficiencia renal grave.'),
(2, 'Paracetamol 500 mg', 'Paracetamol / Acetaminofén', '500 mg', 'Tabletas', 'Bayer / Genérico', 'Analgésico y antipirético de primera línea con excelente tolerancia gástrica.', 'Dolor leve a moderado y control de temperatura corporal.', 'Insuficiencia hepática grave.'),
(3, 'Diclofenaco Gel 1%', 'Diclofenaco Sódico', '1%', 'Gel tópico 50g', 'Novartis / Voltaren', 'Antiinflamatorio y analgésico de uso tópico para penetración articular y muscular.', 'Torceduras, esguinces, tendinitis y contusiones.', 'Hipersensibilidad al diclofenaco, heridas abiertas.'),
(4, 'Tizanidina 2 mg', 'Tizanidina Clorhidrato', '2 mg', 'Tabletas', 'Novartis / Sirdalud', 'Relajante muscular de acción central para espasmos y contracturas.', 'Espasmos musculares dolorosos agudos o crónicos.', 'Insuficiencia hepática severa, uso concomitante con fluvoxamina.'),
(5, 'Losartán Potásico 50 mg', 'Losartán', '50 mg', 'Tabletas recubiertas', 'Pfizer / Genfar', 'Antagonista de receptores de angiotensina II (ARA II) para control de presión arterial.', 'Tratamiento de la hipertensión arterial esencial.', 'Embarazo, hipersensibilidad al principio activo.'),
(6, 'Salbutamol Inhalador 100 mcg', 'Salbutamol Sulfato', '100 mcg/dosis', 'Aerosol inhalador 200 dosis', 'GSK / Ventolin', 'Broncodilatador agonista beta-2 adrenérgico de acción rápida.', 'Prevención y alivio del broncoespasmo inducido por ejercicio físico.', 'Hipersensibilidad conocida a salbutamol.');

-- Medicaciones (Protocolos terapéuticos recomendados según afección)
INSERT IGNORE INTO `medicacion` (`idmedicacion`, `idafeccion`, `nombre`, `descripcion`, `duracion`, `recomendaciones`) VALUES
(1, 1, 'Protocolo de Recuperación Muscular y Analgesia', 'Medicación recomendada para dolor muscular intenso poscompetición o sobrecarga severa.', '3 a 5 días', 'Tomar los comprimidos acompañados de abundante agua y después de ingerir alimentos. Hidratación constante.'),
(2, 2, 'Terapia Antiinflamatoria Local y Sistémica para Tendinitis', 'Abordaje dual (tópico y oral) para control de inflamación del tendón y desinflamación.', '7 a 10 días', 'Aplicar el gel con masajes suaves circulares. No forzar la articulación afectada durante el tratamiento.'),
(3, 4, 'Tratamiento Relajante para Contractura y Espasmo Agudo', 'Combinación analgésica y miorrelajante para descontracturar fibras cervicales o dorsolumbares.', '5 días', 'Tomar la tizanidina preferiblemente en la noche para evitar somnolencia durante el entrenamiento.');

-- Medicamentos asociados a las medicaciones
INSERT IGNORE INTO `medicacionmedicamento` (`idmedicacionmedicamento`, `idmedicacion`, `idmedicamento`, `dosis`, `frecuencia`, `instrucciones`) VALUES
(1, 1, 1, '1 tableta (400 mg)', 'Cada 8 horas con comida', 'Máximo por 5 días consecutivos si persiste dolor.'),
(2, 1, 2, '1 tableta (500 mg)', 'Cada 8 horas intercalado', 'Usar como analgésico de rescate si el dolor no cede.'),
(3, 2, 3, 'Capa fina (2 a 4 gramos)', 'Cada 8 horas en la zona', 'Frotar suavemente hasta absorber. Lavarse las manos tras aplicar.'),
(4, 2, 1, '1 tableta (400 mg)', 'Cada 12 horas', 'Tomar tras el desayuno y la cena con el estómago lleno.'),
(5, 3, 4, '1 tableta (2 mg)', 'Cada 24 horas antes de dormir', 'Favorece la relajación muscular nocturna.'),
(6, 3, 2, '1 tableta (500 mg)', 'Cada 8 horas según dolor', 'Tomar durante el día para alivio sintomático.');

-- Mi Medicación inicial personalizada (para el primer usuario registrado si existe)
INSERT IGNORE INTO `mimedicacion` (`idmimedicacion`, `idpersona`, `idafeccion`, `idmedicacion`, `nombre`, `descripcion`, `fechainicio`, `fechafin`, `medicotratante`, `estado`)
SELECT 1, p.idpersona, 1, 1, 'Mi Tratamiento Personal para DOMS y Recuperación', 'Medicación personalizada adaptada a mis sesiones de fuerza intensa.', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'Dr. Médico Deportólogo GIM360', 'Activa'
FROM (SELECT MIN(`idpersona`) AS idpersona FROM `persona`) p
WHERE p.idpersona IS NOT NULL;

INSERT IGNORE INTO `mimedicacionmedicamento` (`idmimedicacionmedicamento`, `idmimedicacion`, `idmedicamento`, `dosis`, `frecuencia`, `instrucciones`)
SELECT 1, 1, 1, '1 tableta (400 mg)', 'Cada 8 horas después de almorzar y cenar', 'Tomar con abundante agua'
FROM `mimedicacion` WHERE `idmimedicacion` = 1;

INSERT IGNORE INTO `mimedicacionmedicamento` (`idmimedicacionmedicamento`, `idmimedicacion`, `idmedicamento`, `dosis`, `frecuencia`, `instrucciones`)
SELECT 2, 1, 3, '1 aplicación en cuádriceps/gemelos', 'Cada 12 horas post-entreno', 'Masaje suave 3 minutos'
FROM `mimedicacion` WHERE `idmimedicacion` = 1;
