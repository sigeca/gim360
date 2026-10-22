/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: gim360
-- ------------------------------------------------------
-- Server version	10.11.18-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Temporary table structure for view `DisponibilidadEquipo`
--

DROP TABLE IF EXISTS `DisponibilidadEquipo`;
/*!50001 DROP VIEW IF EXISTS `DisponibilidadEquipo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `DisponibilidadEquipo` AS SELECT
 NULL AS `iddisponibilidadequipo`,
 NULL AS `nombre` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `EjercicioEquipo`
--

DROP TABLE IF EXISTS `EjercicioEquipo`;
/*!50001 DROP VIEW IF EXISTS `EjercicioEquipo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `EjercicioEquipo` AS SELECT
 NULL AS `idejercicioequipo`,
 NULL AS `idejercicio`,
 NULL AS `idequipo` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `EquipoMusculo`
--

DROP TABLE IF EXISTS `EquipoMusculo`;
/*!50001 DROP VIEW IF EXISTS `EquipoMusculo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `EquipoMusculo` AS SELECT
 NULL AS `idequipomusculo`,
 NULL AS `idequipo`,
 NULL AS `idmusculo` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `EstadoProgramaCliente`
--

DROP TABLE IF EXISTS `EstadoProgramaCliente`;
/*!50001 DROP VIEW IF EXISTS `EstadoProgramaCliente`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `EstadoProgramaCliente` AS SELECT
 NULL AS `idestadoprogramacliente`,
 NULL AS `nombre` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `Musculo`
--

DROP TABLE IF EXISTS `Musculo`;
/*!50001 DROP VIEW IF EXISTS `Musculo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `Musculo` AS SELECT
 NULL AS `idmusculo`,
 NULL AS `nombre`,
 NULL AS `imagen` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `MusculoEjercicio`
--

DROP TABLE IF EXISTS `MusculoEjercicio`;
/*!50001 DROP VIEW IF EXISTS `MusculoEjercicio`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `MusculoEjercicio` AS SELECT
 NULL AS `idmusculoejecicio`,
 NULL AS `idejercicio`,
 NULL AS `idmusculo` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `PlanEjercicio`
--

DROP TABLE IF EXISTS `PlanEjercicio`;
/*!50001 DROP VIEW IF EXISTS `PlanEjercicio`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `PlanEjercicio` AS SELECT
 NULL AS `idplanejercicio`,
 NULL AS `idejercicio`,
 NULL AS `diassemanas`,
 NULL AS `repeticiones`,
 NULL AS `series`,
 NULL AS `tiempodescanso`,
 NULL AS `peso` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `ProgramaCliente`
--

DROP TABLE IF EXISTS `ProgramaCliente`;
/*!50001 DROP VIEW IF EXISTS `ProgramaCliente`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `ProgramaCliente` AS SELECT
 NULL AS `idprogramacliente`,
 NULL AS `idprogramaentrenamiento`,
 NULL AS `idcliente`,
 NULL AS `fechainicio`,
 NULL AS `idestadoprogramacliente` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `ProgramaEntrenamiento`
--

DROP TABLE IF EXISTS `ProgramaEntrenamiento`;
/*!50001 DROP VIEW IF EXISTS `ProgramaEntrenamiento`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `ProgramaEntrenamiento` AS SELECT
 NULL AS `idprogramaentrenamiento`,
 NULL AS `nombre`,
 NULL AS `idmotivoentrenamiento`,
 NULL AS `idrangoedad` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `RangoEdad`
--

DROP TABLE IF EXISTS `RangoEdad`;
/*!50001 DROP VIEW IF EXISTS `RangoEdad`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `RangoEdad` AS SELECT
 NULL AS `idrangoedad`,
 NULL AS `nombre`,
 NULL AS `edadminima`,
 NULL AS `edadmaxima` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `RutinaPlan`
--

DROP TABLE IF EXISTS `RutinaPlan`;
/*!50001 DROP VIEW IF EXISTS `RutinaPlan`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `RutinaPlan` AS SELECT
 NULL AS `id_rutina_plan`,
 NULL AS `idrutinaejercicio`,
 NULL AS `idplanejercicio` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `RutinaPrograma`
--

DROP TABLE IF EXISTS `RutinaPrograma`;
/*!50001 DROP VIEW IF EXISTS `RutinaPrograma`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `RutinaPrograma` AS SELECT
 NULL AS `idrutinaprograma`,
 NULL AS `idprogramaentrenamiento`,
 NULL AS `idrutinaejercicio` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  PRIMARY KEY (`idcliente`),
  UNIQUE KEY `idpersona` (`idpersona`),
  CONSTRAINT `fk_cliente_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES
(1,1),
(2,2),
(6,7),
(7,8),
(8,9),
(9,11),
(10,12),
(11,13),
(12,14),
(13,15),
(14,16),
(15,17);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `correo`
--

DROP TABLE IF EXISTS `correo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `correo` (
  `idcorreo` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `fechaoptencion` date DEFAULT NULL,
  PRIMARY KEY (`idcorreo`),
  KEY `fk_correo_persona` (`idpersona`),
  CONSTRAINT `fk_correo_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `correo`
--

LOCK TABLES `correo` WRITE;
/*!40000 ALTER TABLE `correo` DISABLE KEYS */;
INSERT INTO `correo` VALUES
(1,1,'carlos.mendoza@email.com','2024-01-10'),
(2,1,'cmendoza_gym@hotmail.com','2024-02-15'),
(3,2,'maria.torres@gmail.com','2024-03-01'),
(4,3,'juandiego.castillo@yahoo.com','2024-03-20'),
(8,7,'educaysoft@gmail.com','2026-10-06');
/*!40000 ALTER TABLE `correo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `direccion` (
  `iddireccion` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  PRIMARY KEY (`iddireccion`),
  KEY `fk_direccion_persona` (`idpersona`),
  CONSTRAINT `fk_direccion_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
INSERT INTO `direccion` VALUES
(1,1,'Av. 9 de Octubre y Malecón Simón Bolívar 102'),
(2,2,'Calle Sucre y Rocafuerte, Barrio Las Palmas'),
(3,3,'Cdla. Los Ceibos, Manzana 14 Solar 8'),
(7,7,'tachina');
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disponibilidadequipo`
--

DROP TABLE IF EXISTS `disponibilidadequipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `disponibilidadequipo` (
  `iddisponibilidadequipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`iddisponibilidadequipo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disponibilidadequipo`
--

LOCK TABLES `disponibilidadequipo` WRITE;
/*!40000 ALTER TABLE `disponibilidadequipo` DISABLE KEYS */;
INSERT INTO `disponibilidadequipo` VALUES
(1,'Disponible'),
(2,'En Uso'),
(3,'En Mantenimiento'),
(4,'En Reparación'),
(5,'Fuera de Servicio'),
(6,'Reservado');
/*!40000 ALTER TABLE `disponibilidadequipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ejecucionprograma`
--

DROP TABLE IF EXISTS `ejecucionprograma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ejecucionprograma` (
  `idejecucionprograma` int(11) NOT NULL AUTO_INCREMENT,
  `idprogramacliente` int(11) NOT NULL,
  `idejercicio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `horainicio` time NOT NULL,
  `horafin` time DEFAULT NULL,
  PRIMARY KEY (`idejecucionprograma`),
  KEY `idx_ejecucionprograma_pc` (`idprogramacliente`),
  KEY `idx_ejecucionprograma_ejercicio` (`idejercicio`),
  KEY `idx_ejecucionprograma_fecha` (`fecha`),
  CONSTRAINT `fk_ep_ejercicio` FOREIGN KEY (`idejercicio`) REFERENCES `ejercicio` (`idejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ep_programacliente` FOREIGN KEY (`idprogramacliente`) REFERENCES `programacliente` (`idprogramacliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ejecucionprograma`
--

LOCK TABLES `ejecucionprograma` WRITE;
/*!40000 ALTER TABLE `ejecucionprograma` DISABLE KEYS */;
INSERT INTO `ejecucionprograma` VALUES
(1,1,1,'2026-10-14','08:00:00','08:15:00'),
(2,1,2,'2026-10-14','08:17:00','08:32:00'),
(3,1,7,'2026-10-14','08:35:00','08:50:00'),
(4,3,4,'2026-10-15','09:10:00','09:25:00'),
(5,4,355,'2026-10-15','18:00:00','18:20:00'),
(6,6,3,'2026-10-16','15:11:00','15:21:00'),
(7,7,253,'2026-10-16','15:13:00','15:50:00'),
(8,7,253,'2026-10-16','15:13:00','15:50:00'),
(9,7,339,'2026-10-16','16:16:00','17:00:00'),
(10,5,268,'2026-10-21','06:25:15','06:35:15'),
(11,9,2,'2026-10-21','08:25:52','08:35:52'),
(12,5,466,'2026-10-21','09:25:09','09:26:09'),
(13,9,2,'2026-10-21','09:53:54','09:55:13'),
(14,9,1,'2026-10-21','09:56:20','09:57:20'),
(15,4,356,'2026-10-21','19:11:08','19:22:00'),
(16,5,131,'2026-10-21','22:38:04','22:39:04'),
(17,5,223,'2026-10-22','08:05:13','08:06:41'),
(18,5,356,'2026-10-22','08:55:50','09:25:30'),
(19,5,383,'2026-10-22','09:34:39','09:36:18'),
(20,5,466,'2026-10-22','13:24:36','13:25:36'),
(21,5,28,'2026-10-22','15:18:43','15:19:43'),
(22,18,388,'2026-10-22','15:33:17','15:34:17'),
(23,21,2,'2026-10-22','15:42:17','15:43:17');
/*!40000 ALTER TABLE `ejecucionprograma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ejercicio`
--

DROP TABLE IF EXISTS `ejercicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ejercicio` (
  `idejercicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombreespanol` varchar(150) NOT NULL,
  `nombreingles` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `urlvideo` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idejercicio`)
) ENGINE=InnoDB AUTO_INCREMENT=470 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ejercicio`
--

LOCK TABLES `ejercicio` WRITE;
/*!40000 ALTER TABLE `ejercicio` DISABLE KEYS */;
INSERT INTO `ejercicio` VALUES
(1,'Sentadilla Trasera con Barra','Barbell Back Squat','Un movimiento compuesto de tren inferior que trabaja cuádriceps, glúteos e isquiotibiales.\n\nInstrucciones de ejecución:\n1. Coloca la barra sobre tus trapecios superiores.\n2. Desrackea y da un paso atrás, con los pies al ancho de los hombros.\n3. Contrae el core y haz la sentadilla hasta que los muslos queden paralelos.\n4. Empuja a través de los talones para volver a la posición de pie.\n5. Repite.\n\nConsejos técnicos:\n• Mantén el pecho arriba durante todo el movimiento.\n• Empuja las rodillas hacia afuera en línea con los dedos de los pies.\n\nMúsculos principales: gluteus_maximus, quadriceps','https://www.youtube.com/watch?v=bEv6CCg2BC8','squat.webp'),
(2,'Press de Banca con Barra','Barbell Bench Press','Un movimiento compuesto de empuje que trabaja el pecho, los hombros y los tríceps.\n\nInstrucciones de ejecución:\n1. Acuéstate en el banco con los ojos bajo la barra.\n2. Agarra la barra ligeramente más ancho que la anchura de los hombros.\n3. Saca la barra del rack y bájala hasta el centro del pecho.\n4. Empuja la barra de vuelta hasta la extensión completa de los brazos.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén los pies planos en el suelo.\n• Conserva una ligera curvatura en la zona lumbar.\n• Impulsa con las piernas para dar estabilidad.\n\nMúsculos principales: pectoralis_major','https://www.youtube.com/watch?v=rT7DgCr-3pg','bench-press.webp'),
(3,'Peso Muerto con Barra','Barbell Deadlift','Un levantamiento compuesto de cuerpo completo que trabaja principalmente la cadena posterior.\n\nInstrucciones de ejecución:\n1. De pie con los pies a la anchura de las caderas y la barra sobre el medio del pie.\n2. Bisagra en las caderas y agarra la barra.\n3. Contrae el core y levanta extendiendo caderas y rodillas.\n4. Ponte completamente erguido arriba y luego baja de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Mantén la barra cerca del cuerpo.\n• No redondees la zona lumbar.\n\nMúsculos principales: erector_spinae, gluteus_maximus, hamstrings','https://www.youtube.com/watch?v=op9kVnSso6Q','deadlift.webp'),
(4,'Dominada','Pull-Up','Un ejercicio compuesto con el peso corporal que trabaja el dorsal ancho y el bíceps.\n\nInstrucciones de ejecución:\n1. Cuélgate de una barra con agarre prono, ligeramente más ancho que el ancho de los hombros.\n2. Súbete hasta que la barbilla quede por encima de la barra.\n3. Baja con control hasta el cuelgue completo.\n4. Repite.\n\nConsejos técnicos:\n• Evita balancearte o usar impulso.\n• Activa el dorsal ancho jalando los codos hacia abajo.\n\nMúsculos principales: latissimus_dorsi','https://www.youtube.com/watch?v=eGo4IYlbE5g','pull-up.webp'),
(5,'Press de Barra sobre la Cabeza Sentado','Seated Barbell Overhead Press','Un press de barra sobre la cabeza estricto en posición sentada, que elimina el impulso de caderas y aísla los deltoides y los tríceps.\n\nInstrucciones de ejecución:\n1. Ajusta un banco vertical dentro del rack con los pines a la altura aproximada de los hombros cuando estés sentado.\n2. Siéntate con la espalda plana contra el pad y desrackea la barra en la parte frontal de los hombros.\n3. Empuja la barra sobre la cabeza hasta extender completamente los brazos, pasando la cabeza por delante en la parte superior.\n4. Baja la barra de vuelta a las clavículas con control.\n5. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Mantén las costillas abajo y los glúteos apretados; no te inclines hacia atrás como en un press de banca.\n• Empuja la barra recto hacia arriba, no hacia adelante.\n\nMúsculos principales: anterior_deltoid','https://www.youtube.com/watch?v=2yjwXTZQDDI','seated-barbell-overhead-press.webp'),
(6,'Rueda Abdominal','Ab Wheel Rollout','Un ejercicio de core haciendo rodar una rueda adelante y atrás, que entrena la antiextensión de la columna.\n\nInstrucciones de ejecución:\n1. Arrodíllate en el suelo y agarra las asas de la rueda a la anchura de los hombros.\n2. Activa fuertemente el core para que la zona lumbar quede neutra.\n3. Rueda la rueda lentamente hacia adelante, extendiendo el cuerpo lo más lejos que puedas controlar.\n4. Detente antes de que las caderas se hundan o la espalda se arquee.\n5. Tira de la rueda de regreso hacia las rodillas contrayendo los abdominales.\n\nConsejos técnicos:\n• Activa el core antes de cada repetición — no dejes que la lumbar se arquee.\n• Aumenta el rango progresivamente, parando antes de que las caderas se hundan.\n• Usa un tope contra la pared si no puedes controlar la posición baja.\n\nMúsculos principales: rectus_abdominis, transverse_abdominis',NULL,'ab-wheel-rollout.webp'),
(7,'Dominadas Arquero','Archer Pull Ups','Una dominada unilateral desplazando el cuerpo hacia una mano mientras el otro brazo permanece estirado, desarrollando fuerza de tracción a un brazo.\n\nInstrucciones de ejecución:\n1. Agarra la barra más ancha que la anchura de los hombros con las palmas mirando hacia afuera.\n2. Tírate hacia arriba desplazando el cuerpo hacia una mano.\n3. Mantén el brazo opuesto extendido como soporte.\n4. Bájate de forma controlada hasta quedar colgado.\n5. Alterna lados en cada repetición o completa las repeticiones de un lado primero.\n\nConsejos técnicos:\n• Mantén el brazo estirado completamente extendido y úsalo solo como guía.\n• Lleva la barbilla hacia la mano que trabaja, no directamente hacia arriba.\n• Domina las dominadas con agarre ancho antes de progresar a las arqueras.\n\nMúsculos principales: latissimus_dorsi',NULL,'archer-pull-ups.webp'),
(8,'Push-Ups Arquero','Archer Push Ups','Una flexión ancha bajando hacia una mano mientras el brazo contrario permanece estirado, cargando un lado cada vez.\n\nInstrucciones de ejecución:\n1. Colócate en posición de push-up amplia con los brazos extendidos.\n2. Bájate hacia una mano mientras mantienes el otro brazo extendido.\n3. Mantén el core apretado y el cuerpo en línea recta.\n4. Empuja de vuelta a la posición inicial.\n5. Alterna lados en cada repetición el número de veces deseado.\n\nConsejos técnicos:\n• Mantén las caderas paralelas al suelo mientras te desplazas hacia el lado.\n• Deja que el brazo estirado ayude lo menos posible.\n• Empieza con flexiones anchas y desplázate un poco más en cada sesión.\n\nMúsculos principales: pectoralis_major',NULL,'archer-push-ups.webp'),
(9,'Press Arnold','Arnold Press','Un press de hombros con mancuernas que rota las palmas durante el ascenso, dirigido al deltoides anterior y lateral.\n\nInstrucciones de ejecución:\n1. Sostén un par de mancuernas a la altura de los hombros con las palmas mirando hacia ti.\n2. Empuja las mancuernas sobre la cabeza mientras rotas las palmas hacia adelante.\n3. Extiende los brazos por completo en la parte superior sin bloquear los codos.\n4. Invierte el movimiento y rota de vuelta a la posición inicial.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Evita arquear la zona lumbar al empujar hacia arriba.\n• Mantén las muñecas firmes y alineadas con los antebrazos.\n• Controla la bajada en lugar de dejar caer el peso.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'arnold-press.webp'),
(10,'Fondos en Máquina Asistida','Machine Assisted Dips','Un ejercicio de fondos en máquina asistida que descarga parte del peso corporal para fortalecer pecho y tríceps.\n\nInstrucciones de ejecución:\n1. Sube a la máquina de fondos asistidos con las rodillas en el pad.\n2. Agarra las barras paralelas y soporta tu peso con los brazos extendidos.\n3. Baja el cuerpo flexionando los codos hasta que los hombros queden por debajo de los codos.\n4. Empuja de vuelta a la posición inicial.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Baja de forma controlada, sin rebotar en la parte inferior.\n• Mantén los hombros alejados de las orejas durante todo el recorrido.\n• Reduce la asistencia de forma gradual a medida que ganes fuerza.\n\nMúsculos principales: pectoralis_major, triceps_brachii',NULL,'assisted-dips.webp'),
(11,'Dominadas Asistidas','Assisted Pull Ups','Una dominada en máquina asistida que contrarresta parte del peso corporal, pensada para construir la fuerza de espalda necesaria para dominadas estrictas.\n\nInstrucciones de ejecución:\n1. Coloca las rodillas en el pad de la máquina de dominadas asistidas.\n2. Agarra la barra con las palmas mirando hacia afuera, ligeramente más ancho que los hombros.\n3. Tira del pecho hacia la barra impulsando los codos hacia abajo.\n4. Bájate de forma controlada hasta quedar colgado con los brazos extendidos.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Inicia el movimiento bajando los omóplatos antes de doblar los codos.\n• Evita balancearte para no restar trabajo a la espalda.\n• Ajusta el contrapeso para completar todas las repeticiones con buena técnica.\n\nMúsculos principales: latissimus_dorsi',NULL,'assisted-pull-ups.webp'),
(12,'Extensión de Espalda','Back Extension','Un movimiento de aislamiento que trabaja los erectores espinales de la zona lumbar en un banco de hiperextensión.\n\nInstrucciones de ejecución:\n1. Acuéstate boca abajo en un banco de hiperextensión con las caderas en el borde del pad.\n2. Baja el torso hacia el suelo.\n3. Sube el torso hasta que el cuerpo quede recto.\n4. Repite.\n\nConsejos técnicos:\n• Mantén los movimientos controlados.\n• No hiperextiendas más allá de la posición neutra de la columna.\n\nMúsculos principales: erector_spinae',NULL,'back-extension.webp'),
(13,'Curl de Piernas con Pelota de Estabilidad','Stability Ball Leg Curl','Un curl de isquiotibiales con el propio peso usando una pelota de estabilidad, rodando los talones hacia los glúteos mientras se eleva la cadera.\n\nInstrucciones de ejecución:\n1. Acuéstate boca arriba en el suelo con los talones y la parte inferior de las pantorrillas sobre la pelota de estabilidad y los brazos estirados para hacer equilibrio.\n2. Presiona con los talones para elevar las caderas formando una línea recta desde los hombros hasta los tobillos.\n3. Manteniendo las caderas arriba, flexiona las rodillas para rodar la pelota hacia los glúteos.\n4. Extiende las piernas de vuelta de forma controlada sin bajar las caderas.\n5. Completa todas las repeticiones, luego baja las caderas y sepárate de la pelota.\n\nConsejos técnicos:\n• Las caderas permanecen arriba durante toda la serie: es una combinación de puente y curl.\n• Empieza con ambos pies; progresa a una sola pierna cuando se vuelva fácil.\n\nMúsculos principales: hamstrings',NULL,'ball-leg-curl.webp'),
(14,'Pike con Pelota','Ball Pike','Un ejercicio avanzado de core en el que las caderas se elevan mientras los pies ruedan una pelota suiza hacia el pecho.\n\nInstrucciones de ejecución:\n1. Coloca las espinillas sobre una pelota suiza y las manos en el suelo en plancha alta.\n2. Activa el core y mantén las piernas rectas.\n3. Eleva las caderas, rodando la pelota hacia el pecho hasta formar una V invertida.\n4. Pausa brevemente arriba.\n5. Rueda la pelota de vuelta a la posición inicial de plancha.\n\nConsejos técnicos:\n• Mantén las piernas rectas todo el tiempo — sin doblar las rodillas.\n• Mueve desde la cadera, no desde la zona lumbar.\n• Trabaja primero con flexiones de rodilla si el pike es demasiado difícil.\n\nMúsculos principales: obliques, rectus_abdominis',NULL,'ball-pike.webp'),
(15,'Dominadas Asistidas con Banda','Band Assisted Pull Ups','Una dominada con banda elástica enganchada a la barra que reduce el peso corporal a vencer en cada repetición.\n\nInstrucciones de ejecución:\n1. Engancha una banda elástica en la barra de dominadas e introduce un pie en ella.\n2. Agarra la barra con las palmas mirando hacia afuera, a la anchura de los hombros.\n3. Tira del pecho hacia la barra impulsando los codos hacia abajo.\n4. Bájate de forma controlada hasta quedar colgado con los brazos extendidos.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Comprueba que la banda esté bien sujeta antes de colgarte.\n• No tomes impulso con las piernas, deja que trabaje la espalda.\n• Usa una banda más fina a medida que progreses.\n\nMúsculos principales: latissimus_dorsi',NULL,'band-assisted-pull-ups.webp'),
(16,'Separación de Banda Elástica','Band Pull Apart','Un ejercicio de alto volumen para el deltoides posterior y los retractores escapulares que se realiza separando una banda elástica a la altura de los hombros.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo una banda elástica ligera con ambas manos, brazos extendidos al frente a la altura de los hombros.\n2. Las manos comienzan a la anchura de los hombros, palmas mirando hacia abajo.\n3. Manteniendo los brazos extendidos, separa la banda llevando las manos hacia los lados.\n4. Termina con la banda tocando el pecho y los omóplatos juntos.\n5. Vuelve lentamente a la posición inicial y repite.\n\nConsejos técnicos:\n• Lidera el movimiento con los meñiques: esto rota externamente los hombros.\n• Usa una banda lo suficientemente ligera para hacer 15-30 repeticiones limpias; es un ejercicio preventivo de alto número de repeticiones.\n\nMúsculos principales: posterior_deltoid',NULL,'band-pull-apart.webp'),
(17,'Almeja con Banda','Banded Clamshell','Una abducción de cadera tipo almeja con una banda circular por encima de las rodillas, que aísla el glúteo medio.\n\nInstrucciones de ejecución:\n1. Túmbate de lado con las caderas y rodillas flexionadas a unos 45 grados y los pies juntos uno sobre otro.\n2. Coloca una banda circular alrededor de ambas piernas por encima de las rodillas.\n3. Mantén los pies pegados y la pelvis estable; no rotes hacia atrás durante el movimiento.\n4. Abre la rodilla de arriba contra la banda, como una almeja al abrirse, hasta notar que el glúteo se activa.\n5. Haz una breve pausa arriba y baja de forma controlada hasta la posición inicial.\n6. Completa todas las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• La pelvis se queda fija; en cuanto rotas hacia atrás, el glúteo deja de trabajar.\n• Un tempo lento y controlado vale más que una banda dura.\n• Si te da un calambre en el lateral de la cadera, acorta la serie.\n\nMúsculos principales: gluteus_medius',NULL,'banded-clamshell.webp'),
(18,'Hidrante de Fuego con Banda','Banded Fire Hydrant','Este ejercicio de aislamiento utiliza una banda de resistencia para fortalecer el glúteo medio y mayor, mejorando la abducción y estabilidad de la cadera.\n\nInstrucciones de ejecución:\n1. Coloca una banda de resistencia justo por encima de tus rodillas y ponte en posición de cuadrupedia, manos bajo los hombros y rodillas bajo las caderas.\n2. Mantén tu core activado y la espalda recta, conservando una columna vertebral neutra durante todo el movimiento.\n3. Levanta lentamente una rodilla hacia un lado, manteniendo la rodilla flexionada a 90 grados, hasta que tu muslo esté paralelo al suelo.\n4. Sostén brevemente en la parte superior, contrayendo el glúteo, luego baja la pierna de forma controlada a la posición inicial.\n5. Completa todas las repeticiones de un lado antes de cambiar al otro lado.\n\nConsejos técnicos:\n• Concéntrate en un movimiento controlado; evita usar el impulso para levantar la pierna.\n• Mantén tus caderas estables y evita que tu torso rote o se incline.\n• Asegúrate de que la banda permanezca tensa durante todo el rango de movimiento.\n\nMúsculos principales: gluteus_medius',NULL,'banded-fire-hydrant.webp'),
(19,'Puente de Glúteos con Banda','Banded Glute Bridge','Un puente de glúteos con una banda circular por encima de las rodillas que suma tensión de abducción al empuje de cadera.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con las rodillas flexionadas y los pies apoyados en el suelo a la anchura de los hombros.\n2. Coloca una banda circular alrededor de ambas piernas justo por encima de las rodillas.\n3. Presiona la zona lumbar contra el suelo y activa el core.\n4. Empuja con los talones y aprieta los glúteos para elevar las caderas en puente, manteniendo la tensión de la banda al empujar las rodillas hacia afuera.\n5. Arriba, el cuerpo forma una línea recta de los hombros a las rodillas. Haz una breve pausa.\n6. Baja de forma controlada hasta la posición inicial y repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Las rodillas tienden a irse hacia dentro; empújalas hacia afuera contra la banda.\n• Detén la subida cuando las caderas queden a la altura de hombros y rodillas; no hiperextiendas la lumbar.\n• Aprieta fuerte arriba; un puente rápido a medio recorrido se siente fácil porque lo es.\n\nMúsculos principales: gluteus_maximus',NULL,'banded-glute-bridge.webp'),
(20,'Buenos Días con Banda','Banded Good Morning','Un hip-hinge con banda elástica sobre la espalda alta, que trabaja isquiotibiales y glúteos.\n\nInstrucciones de ejecución:\n1. Pisa una banda elástica con ambos pies y pásala por la nuca.\n2. Coloca los pies a la anchura de las caderas, ligera flexión de rodillas.\n3. Flexiona desde la cadera empujándola atrás, espalda recta.\n4. Baja hasta sentir el estiramiento en los isquiotibiales.\n5. Empuja las caderas adelante para volver a la posición inicial.\n\nConsejos técnicos:\n• Mueve desde la cadera, no desde la zona lumbar.\n• Pecho arriba y espalda recta.\n• Usa una banda lo bastante ligera para permitir el rango completo.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'banded-good-morning.webp'),
(21,'Empuje de Cadera con Banda','Banded Hip Thrust','Este ejercicio utiliza una banda de bucle para aumentar la activación de los glúteos durante un empuje de cadera, trabajando eficazmente el glúteo mayor, los isquiotibiales y el glúteo medio para mejorar la fuerza de la parte inferior del cuerpo.\n\nInstrucciones de ejecución:\n1. Coloca una banda de bucle justo por encima de tus rodillas y siéntate en el suelo con la parte superior de tu espalda contra un banco.\n2. Dobla las rodillas, apoya los pies al ancho de las caderas y posiciona la banda para crear tensión.\n3. Impúlsate a través de los talones, extiende las caderas y levanta los glúteos del suelo hasta que tu cuerpo forme una línea recta.\n4. Aprieta los glúteos con fuerza en la parte superior, asegurándote de empujar las rodillas hacia afuera contra la banda.\n5. Baja lentamente las caderas a la posición inicial con control.\n\nConsejos técnicos:\n• Mantén una tensión constante en la banda durante todo el movimiento.\n• Concéntrate en una fuerte contracción de los glúteos en el pico del empuje.\n• Mantén la barbilla metida y la mirada al frente para una columna vertebral neutra.\n• Asegúrate de que tus espinillas estén verticales en la parte superior del movimiento.\n\nMúsculos principales: gluteus_maximus',NULL,'banded-hip-thrust.webp'),
(22,'Empuje de Cadera Arrodillado con Banda','Banded Kneeling Hip Thrust','Este ejercicio fortalece los glúteos y los isquiotibiales al impulsar las caderas hacia adelante contra la resistencia de una banda desde una posición arrodillada.\n\nInstrucciones de ejecución:\n1. Coloca una banda de bucle justo por encima de tus rodillas. Arrodíllate en el suelo con el torso erguido y las rodillas separadas al ancho de las caderas.\n2. Inclínate ligeramente hacia adelante desde las caderas, manteniendo la espalda recta y el core contraído.\n3. Inicia el movimiento apretando los glúteos, impulsando las caderas hacia adelante hasta que tu torso esté erguido.\n4. Aprieta los glúteos con fuerza en la parte superior, manteniendo la tensión en la banda.\n5. Invierte lentamente el movimiento, controlando la resistencia de la banda mientras regresas a la posición inicial.\n\nConsejos técnicos:\n• Concéntrate en una fuerte contracción de los glúteos en la parte superior del movimiento.\n• Mantén el core activado en todo momento para evitar arquear la espalda baja.\n• Mantén una tensión constante en la banda empujando las rodillas ligeramente hacia afuera.\n\nMúsculos principales: gluteus_maximus',NULL,'banded-kneeling-hip-thrust.webp'),
(23,'Caminata Lateral con Banda','Banded Lateral Walk','Un desplazamiento lateral a pasos con una banda circular por encima de las rodillas o en los tobillos, que activa el glúteo medio.\n\nInstrucciones de ejecución:\n1. Coloca una banda circular alrededor de las piernas por encima de las rodillas (o en los tobillos para una versión más difícil).\n2. Ponte en cuarto de sentadilla: pies a la anchura de los hombros, caderas atrás, pecho alto y rodillas alineadas con los pies.\n3. Da un paso lateral con un pie directamente hacia el lado contra la tensión de la banda.\n4. Acerca el pie de atrás hacia el de delante manteniendo la tensión de la banda en todo momento; no dejes que los pies se junten de golpe.\n5. Sigue dando pasos laterales en una dirección durante las repeticiones o la distancia indicada y luego invierte.\n6. Permanece abajo todo el rato; no te incorpores entre paso y paso.\n\nConsejos técnicos:\n• Mantén las puntas de los pies hacia el frente; no dejes que el pie de delante se abra.\n• Las caderas se quedan niveladas; no te balancees de lado a lado al caminar.\n• Si las rodillas se van hacia dentro, la banda es demasiado dura; usa una más suave.\n\nMúsculos principales: gluteus_medius',NULL,'banded-lateral-walk.webp'),
(24,'Peso Muerto Rumano con Banda','Banded Romanian Deadlift','Un peso muerto rumano con banda elástica, ideal para calentar y aprender el patrón de hip-hinge.\n\nInstrucciones de ejecución:\n1. Pisa una banda elástica con ambos pies y agarra el extremo superior.\n2. Coloca los pies a la anchura de las caderas, ligera flexión de rodillas.\n3. Flexiona desde la cadera, deslizando las manos por las piernas.\n4. Baja hasta sentir el estiramiento en los isquiotibiales.\n5. Empuja las caderas adelante para volver a la posición inicial.\n\nConsejos técnicos:\n• Mantén la banda cerca de las piernas.\n• Detente en el punto bajo de tu rango limpio — no redondees la espalda.\n• El movimiento es un hinge, no una sentadilla — las rodillas casi no se flexionan.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'banded-romanian-deadlift.webp'),
(25,'Abducción de Cadera Sentado con Banda','Banded Seated Hip Abduction','Este ejercicio de aislamiento trabaja el glúteo medio y mayor al rotar externamente las caderas contra la resistencia de una banda mientras estás sentado.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco o silla con una banda elástica alrededor de tus rodillas.\n2. Mantén los pies apoyados en el suelo, separados al ancho de tus caderas, y conserva una postura erguida.\n3. Empuja tus rodillas hacia afuera contra la banda, activando tus glúteos.\n4. Sostén la contracción máxima brevemente, luego regresa lentamente tus rodillas a la posición inicial.\n5. Controla el movimiento a lo largo de todo el rango de movimiento.\n\nConsejos técnicos:\n• Concéntrate en apretar tus glúteos para iniciar el movimiento.\n• Evita inclinarte hacia atrás o usar el impulso; mantén tu torso estable.\n• Elige una resistencia de banda que permita un movimiento controlado.\n• Mantén la tensión en la banda incluso en la posición inicial.\n\nMúsculos principales: gluteus_medius',NULL,'banded-seated-hip-abduction.webp'),
(26,'Sentadilla con Banda','Banded Squat','Una sentadilla con peso corporal y banda sobre las rodillas para enseñar a sacar las rodillas afuera.\n\nInstrucciones de ejecución:\n1. Coloca una banda elástica justo sobre las rodillas.\n2. Pies a la anchura de los hombros, puntas ligeramente afuera.\n3. Empuja las rodillas hacia afuera contra la banda al bajar.\n4. Desciende hasta que los muslos queden paralelos o más abajo.\n5. Empuja con los talones para volver a subir.\n\nConsejos técnicos:\n• Empuja las rodillas contra la banda durante toda la repetición.\n• Pecho arriba y espalda recta.\n• No dejes que las rodillas se vayan hacia adentro.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'banded-squat.webp'),
(27,'Curl de Pierna de Pie con Banda','Banded Standing Leg Curl','Un curl femoral de pie con una banda elástica alrededor del tobillo, útil para viajes o como finalizador con poca carga para isquiotibiales.\n\nInstrucciones de ejecución:\n1. Coloca una banda elástica alrededor de un tobillo y ancla el otro extremo bajo el pie de apoyo o en un punto fijo delante de ti.\n2. Mantente erguido, sujétate a algo si necesitas equilibrio, con ligera flexión en la pierna de apoyo.\n3. Sube el talón con la banda hacia el glúteo, manteniendo el muslo quieto.\n4. Contrae el isquiotibial arriba, luego baja con control hasta el estiramiento completo.\n5. Completa todas las repeticiones de un lado y cambia de pierna.\n\nConsejos técnicos:\n• Mantén el muslo quieto — solo se mueve la parte inferior de la pierna.\n• Evita balancear la cadera para tomar impulso.\n• Usa una banda más ligera si no puedes controlar el descenso.\n\nMúsculos principales: hamstrings',NULL,'banded-standing-curl.webp'),
(28,'Abducción de Cadera de Pie con Banda','Banded Standing Hip Abduction','Este ejercicio de aislamiento trabaja el glúteo medio y mayor, mejorando la estabilidad y fuerza de la cadera al abducir la pierna contra la resistencia de la banda.\n\nInstrucciones de ejecución:\n1. Coloca una banda elástica alrededor de tus tobillos o justo encima de tus rodillas.\n2. Ponte de pie con una ligera flexión de rodillas y activa tu core.\n3. Transfiere tu peso a una pierna, manteniendo el torso estable.\n4. Abduce lentamente la pierna libre hacia un lado, sintiendo la contracción del glúteo.\n5. Controla el movimiento mientras regresas la pierna a la posición inicial.\n6. Completa todas las repeticiones por lado antes de cambiar.\n\nConsejos técnicos:\n• Mantén tu torso erguido y evita inclinarte hacia un lado.\n• Concéntrate en un movimiento controlado, no en el impulso.\n• Asegúrate de que la banda mantenga la tensión durante todo el rango de movimiento.\n• Inicia el movimiento desde tu cadera, no desde tu pie.\n\nMúsculos principales: gluteus_medius',NULL,'banded-standing-hip-abduction.webp'),
(29,'Aducción de Cadera de Pie con Banda','Banded Standing Hip Adduction','Una aducción de cadera de pie con banda elástica, aislando los aductores del muslo interno.\n\nInstrucciones de ejecución:\n1. Ancla una banda elástica a un poste firme a la altura del tobillo.\n2. Pasa el bucle por la pierna que trabaja, orientada hacia el anclaje.\n3. Aléjate algunos pasos para que la banda quede tensa.\n4. Lleva la pierna que trabaja cruzando el cuerpo hacia la otra pierna.\n5. Regresa lentamente. Completa las repeticiones por lado y cambia.\n\nConsejos técnicos:\n• Mantén la pierna de apoyo ligeramente flexionada para estabilidad.\n• Mueve solo la pierna que trabaja — el torso permanece quieto.\n• Controla la fase excéntrica para un estiramiento completo del aductor.\n\nMúsculos principales: adductors',NULL,'banded-standing-hip-adduction.webp'),
(30,'Caminata Sumo con Banda','Banded Sumo Walk','Una caminata en posición sumo con banda sobre las rodillas, que trabaja el glúteo medio y mayor.\n\nInstrucciones de ejecución:\n1. Coloca una banda elástica justo sobre las rodillas.\n2. Baja a una media sentadilla con los pies más anchos que los hombros.\n3. Avanza un paso al frente en posición ancha, mantén tensión en la banda.\n4. Sigue avanzando alternando los pies por la distancia indicada.\n5. Permanece bajo — no te incorpores entre pasos.\n\nConsejos técnicos:\n• Mantén tensión en la banda durante toda la serie.\n• Quédate en media sentadilla — no te levantes entre pasos.\n• Da pasos cortos y controlados con las puntas ligeramente afuera.\n\nMúsculos principales: gluteus_maximus, gluteus_medius',NULL,'banded-sumo-walk.webp'),
(31,'Extensión Terminal de Rodilla con Banda','Banded Terminal Knee Extension','Un ejercicio de aislamiento que extiende la rodilla contra la banda, usado para el VMO y rehabilitación.\n\nInstrucciones de ejecución:\n1. Ancla una banda elástica a un poste firme a la altura de la rodilla.\n2. Pasa el bucle de modo que la banda quede detrás de una rodilla.\n3. Da un paso atrás para que la banda flexione ligeramente la rodilla.\n4. Extiende la rodilla completamente contra la banda, contrayendo el cuádriceps.\n5. Regresa lentamente. Repeticiones por lado y cambia.\n\nConsejos técnicos:\n• Contrae fuerte el cuádriceps en la extensión completa.\n• Mantén el pie plano — no levantes el talón.\n• Mueve solo la rodilla — la cadera permanece inmóvil.\n\nMúsculos principales: quadriceps',NULL,'banded-terminal-knee-extension.webp'),
(32,'Rueda Abdominal con Barra','Barbell Ab Rollout','Una rueda abdominal de rodillas usando una barra cargada con discos, que ofrece un rodamiento más suave y carga ajustable en comparación con la rueda abdominal.\n\nInstrucciones de ejecución:\n1. Carga discos del mismo tamaño en ambos extremos de la barra y colócala en el suelo.\n2. Arrodíllate detrás de la barra y agárrala a la anchura de los hombros con los brazos extendidos.\n3. Contrae el core con fuerza, luego rueda la barra hacia adelante alejándola del cuerpo.\n4. Avanza hasta donde puedas mantener la columna neutra: detente antes de que las caderas se hundan.\n5. Tira de la barra de vuelta a la posición inicial contrayendo los abdominales y el dorsal.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Empieza con discos pequeños para un rango limitado; pasa a los de 20 kg para rodamientos completos.\n• En el momento en que la zona lumbar se arquee o caiga, detente: has superado tu rango.\n\nMúsculos principales: rectus_abdominis',NULL,'barbell-ab-rollout.webp'),
(33,'Elevación de Talones con Barra','Barbell Calf Raise','Una elevación de talones con barra sobre la espalda realizada en una plataforma, que aísla los gemelos con un rango completo.\n\nInstrucciones de ejecución:\n1. Coloca una barra en la parte alta de la espalda como en una sentadilla.\n2. Párate con las puntas de los pies en una plataforma elevada.\n3. Sube sobre los dedos de los pies lo más alto posible.\n4. Haz una pausa y aprieta los gemelos en la parte superior.\n5. Baja los talones por debajo de la plataforma y repite.\n\nConsejos técnicos:\n• Evita rebotar en la parte baja del movimiento.\n• Mantén las rodillas extendidas pero sin bloquearlas con fuerza.\n• Sube y baja en vertical, sin dejar que los tobillos se venzan hacia fuera.\n\nMúsculos principales: gastrocnemius',NULL,'barbell-calf-raise.webp'),
(34,'Curl con Barra','Barbell Curl','Un ejercicio clásico de aislamiento de bíceps que usa la barra para una carga máxima.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo una barra con agarre supino a la anchura de los hombros.\n2. Sube la barra hacia los hombros.\n3. Aprieta en la parte superior, luego baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• Evita balancear el torso.\n• Mantén los codos pegados a los costados.\n\nMúsculos principales: biceps_brachii',NULL,'barbell-curl.webp'),
(35,'Elevación Frontal con Barra','Barbell Front Raise','Una elevación frontal con barra que aísla el deltoides anterior al subir el peso con los brazos rectos hasta la altura de los hombros.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo una barra con agarre prono a la altura de los muslos.\n2. Mantén los brazos extendidos y el core contraído.\n3. Eleva la barra frente a ti hasta la altura de los hombros.\n4. Haz una breve pausa en la parte superior.\n5. Baja de forma controlada y repite.\n\nConsejos técnicos:\n• Usa un peso moderado para no balancear el cuerpo.\n• Evita encoger los hombros mientras subes la barra.\n• Mantén las muñecas neutras, sin dejar que se doblen hacia atrás.\n\nMúsculos principales: anterior_deltoid',NULL,'barbell-front-raise.webp'),
(36,'Puente de Glúteos con Barra','Barbell Glute Bridge','Un puente de glúteos con carga usando una barra para mayor resistencia.\n\nInstrucciones de ejecución:\n1. Acuéstate en el suelo con una barra sobre las caderas y las rodillas flexionadas.\n2. Eleva las caderas apretando los glúteos.\n3. Aguanta en la parte superior con las caderas completamente extendidas.\n4. Baja con control.\n5. Repite.\n\nConsejos técnicos:\n• Evita arquear la zona lumbar al extender la cadera.\n• Empuja con los talones, no con las puntas de los pies.\n• Mete la barbilla y mantén la parte alta de la espalda apoyada.\n\nMúsculos principales: gluteus_maximus',NULL,'barbell-glute-bridge.webp'),
(37,'Extensión de Barra por Encima de la Cabeza','Barbell Overhead Extension','Este ejercicio de aislamiento trabaja eficazmente el tríceps braquial al extender los codos por encima de la cabeza, promoviendo la hipertrofia y fuerza muscular.\n\nInstrucciones de ejecución:\n1. Carga una barra con el peso adecuado y ponte de pie o siéntate con la columna neutra.\n2. Agarra la barra con un agarre prono, al ancho de los hombros, y presiónala por encima de tu cabeza.\n3. Baja lentamente la barra detrás de tu cabeza flexionando los codos, manteniendo los brazos estables.\n4. Extiende los codos para presionar la barra de vuelta a la posición inicial por encima de la cabeza, contrayendo tus tríceps.\n5. Mantén el control durante todo el movimiento, evitando el impulso.\n\nConsejos técnicos:\n• Mantén los codos pegados y apuntando hacia adelante para maximizar la activación del tríceps y proteger tus hombros.\n• Controla la fase excéntrica (descenso) para mejorar la tensión muscular y el crecimiento.\n• Evita arquear demasiado la espalda baja; contrae tu core para mantener la estabilidad.\n\nMúsculos principales: triceps_brachii',NULL,'barbell-overhead-extension.webp'),
(38,'Curl Predicador con Barra','Barbell Preacher Curl','Este ejercicio de aislamiento trabaja el bíceps braquial y el braquial al fijar los brazos en un banco predicador, minimizando el impulso y maximizando la tensión muscular.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco predicador con el pecho contra la almohadilla, sujetando una barra con agarre supino al ancho de los hombros.\n2. Apoya firmemente tus brazos en la almohadilla, asegurándote de que tus codos estén ligeramente flexionados al inicio.\n3. Sube la barra contrayendo tus bíceps, manteniendo tus brazos inmóviles sobre la almohadilla.\n4. Aprieta los bíceps en la parte superior del movimiento, enfocándote en la contracción máxima.\n5. Baja lentamente la barra a la posición inicial, controlando la fase excéntrica.\n6. Extiende completamente tus brazos en la parte inferior para lograr un estiramiento completo en los bíceps.\n\nConsejos técnicos:\n• Mantén una tensión constante en los bíceps durante todo el rango de movimiento.\n• Evita levantar los codos de la almohadilla; esto indica que estás usando demasiado peso o impulso.\n• Concéntrate en una fase excéntrica (bajada) controlada para maximizar el daño muscular y el crecimiento.\n• Mantén tus muñecas rectas y alineadas con tus antebrazos para prevenir tensiones.\n\nMúsculos principales: biceps_brachii',NULL,'barbell-preacher-curl.webp'),
(39,'Pullover con Barra','Barbell Pullover','Un movimiento compuesto que estira y trabaja el dorsal y el pectoral a través de un arco amplio.\n\nInstrucciones de ejecución:\n1. Acuéstate en un banco con una barra sostenida sobre el pecho.\n2. Baja la barra hacia atrás sobre tu cabeza en un arco.\n3. Tírala de vuelta al inicio sobre el pecho.\n4. Repite.\n\nConsejos técnicos:\n• Mantén una ligera flexión en los codos.\n• Activa el dorsal para impulsar la barra de vuelta.\n\nMúsculos principales: latissimus_dorsi, pectoralis_major',NULL,'barbell-pullover.webp'),
(40,'Remo con Barra para Deltoides Posterior','Barbell Rear Delt Row','Un remo con barra inclinado con los codos abiertos que traslada el énfasis de los dorsales a los deltoides posteriores y la parte alta de la espalda.\n\nInstrucciones de ejecución:\n1. Inclínate en las caderas con la espalda plana hasta que el torso quede casi paralelo al suelo.\n2. Sostén una barra con agarre prono, más ancho que la anchura de los hombros, brazos colgando.\n3. Rema la barra hacia el pecho superior con los codos abiertos hacia los lados.\n4. Haz una pausa y aprieta los deltoides posteriores y la parte alta de la espalda en la cima.\n5. Baja la barra de forma controlada y repite.\n\nConsejos técnicos:\n• Jala con los codos, no con las manos: piensa en impulsarlos hacia arriba y hacia afuera.\n• Usa una carga menor que en un remo estándar; el agarre ancho reduce el brazo de palanca.\n\nMúsculos principales: posterior_deltoid',NULL,'barbell-rear-delt-row.webp'),
(41,'Zancada Inversa con Barra','Barbell Reverse Lunge','Una zancada con barra dando el paso hacia atrás en lugar de hacia delante, manteniendo la tibia delantera vertical mientras carga cuádriceps y glúteos.\n\nInstrucciones de ejecución:\n1. Coloca una barra en la parte alta de la espalda y párate erguido.\n2. Da un paso hacia atrás con un pie en una zancada larga.\n3. Baja la rodilla trasera hacia el suelo de forma controlada.\n4. Impulsa a través del talón delantero para volver a la posición inicial.\n5. Completa las repeticiones de un lado, luego cambia.\n\nConsejos técnicos:\n• Da el paso atrás lo bastante largo para que la tibia delantera quede casi vertical.\n• Baja la rodilla trasera en línea recta en lugar de inclinarte hacia delante.\n• Mantén el pecho erguido y las caderas alineadas.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'barbell-reverse-lunge.webp'),
(42,'Remo con Barra Inclinado','Bent-Over Barbell Row','Un movimiento de jalón compuesto que trabaja la parte superior e intermedia de la espalda.\n\nInstrucciones de ejecución:\n1. Inclínate en las caderas con una ligera flexión de rodillas.\n2. Agarra la barra ligeramente más ancho que la anchura de los hombros.\n3. Tira de la barra hacia el pecho inferior apretando los omóplatos.\n4. Baja la barra de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Mantén el torso a aproximadamente 45 grados.\n• No uses el impulso para balancear el peso.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'barbell-row.webp'),
(43,'Curl de Muñeca con Barra','Barbell Wrist Curl','Un curl de muñeca con barra que aísla los flexores del antebrazo para fuerza de agarre y tamaño.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con los antebrazos sobre los muslos, palmas hacia arriba.\n2. Sujeta una barra con las manos a la anchura de los hombros, muñecas fuera de las rodillas.\n3. Deja que la barra ruede hasta las puntas de los dedos.\n4. Sube la barra flexionando las muñecas.\n5. Baja con control.\n\nConsejos técnicos:\n• Mueve solo la muñeca — los antebrazos permanecen quietos.\n• Rueda la barra a las puntas de los dedos para el rango completo.\n• Usa un agarre sin pulgar si te resulta más cómodo.\n\nMúsculos principales: forearm_flexors',NULL,'barbell-wrist-curl.webp'),
(44,'Golpe Doble con Cuerdas de Batalla','Battle Rope Double Slam','Un ejercicio de acondicionamiento en el que ambos extremos de la cuerda suben y se golpean contra el suelo a la vez, generando una gran onda por repetición en lugar de las ondas alternas del ejercicio clásico.\n\nInstrucciones de ejecución:\n1. Toma un extremo de la cuerda en cada mano y colócate frente al anclaje, lo bastante atrás como para que las cuerdas queden algo destensadas.\n2. Separa los pies algo más que la anchura de las caderas y baja a una sentadilla de cuarto, con el pecho alto.\n3. Sube ambos brazos a la vez, dejando que las cuerdas se eleven por delante mientras extiendes la cadera.\n4. Golpea ambos extremos contra el suelo al mismo tiempo, flexionando por la cadera y empujando desde los dorsales.\n5. Aprovecha el rebote para encadenar el siguiente golpe, manteniendo ambos brazos al unísono en lugar de alternarlos.\n6. Sigue golpeando el tiempo o las repeticiones deseadas.\n\nConsejos técnicos:\n• Los dos brazos se mueven juntos — en cuanto empiezan a alternarse estás haciendo el ejercicio de ondas clásico, que es otro ejercicio distinto.\n• Impulsa el golpe con la cadera y los dorsales en vez de con los brazos, o los hombros se agotarán mucho antes que los pulmones.\n• Colócate a la distancia correcta del anclaje: demasiado cerca la cuerda queda floja, demasiado lejos no consigues meterle onda.\n\nMúsculos principales: anterior_deltoid, latissimus_dorsi',NULL,'battle-rope-double-slam.webp'),
(45,'Caminata del Oso','Bear Crawl','Un gateo en cuadrupedia sobre manos y puntas de los pies con las rodillas suspendidas justo por encima del suelo, que desarrolla la estabilidad del hombro y el control del core al desplazarse hacia adelante.\n\nInstrucciones de ejecución:\n1. Empieza en cuadrupedia con las manos bajo los hombros y las rodillas bajo las caderas.\n2. Apoya las puntas de los pies y eleva las rodillas unos centímetros del suelo.\n3. Con la espalda plana y las caderas bajas, avanza juntos la mano derecha y el pie izquierdo.\n4. Luego mueve la mano izquierda y el pie derecho, gateando hacia adelante con ritmo controlado.\n5. Mantén el core firme y evita que las caderas se balanceen de lado a lado.\n\nConsejos técnicos:\n• Mueve juntos la mano y el pie opuestos, como un gateo exagerado.\n• Mantén las rodillas bajas y las caderas niveladas: que no suban ni se balanceen.\n\nMúsculos principales: anterior_deltoid, rectus_abdominis',NULL,'bear-crawl.webp'),
(46,'Encogimiento de Hombros con Barra Detrás de la Espalda','Behind the Back Barbell Shrug','Un encogimiento de hombros con la barra sujeta por detrás del cuerpo, una variante que concentra el trabajo en el trapecio.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo una barra detrás de la espalda con agarre prono.\n2. Mantén los brazos extendidos y el pecho hacia arriba.\n3. Encoge los hombros directamente hacia las orejas.\n4. Haz una pausa y aprieta en la parte superior.\n5. Baja de forma controlada y repite.\n\nConsejos técnicos:\n• Evita hacer círculos con los hombros al subir.\n• Mantén la cabeza neutra, sin adelantar la barbilla.\n• Elige un peso que permita un recorrido completo hacia arriba.\n\nMúsculos principales: trapezius',NULL,'behind-the-back-barbell-shrug.webp'),
(47,'Jalón al Cuello Detrás de la Cabeza','Behind-the-Neck Lat Pulldown','Un jalón al dorsal con agarre ancho llevado detrás de la cabeza, que trabaja la parte superior del dorsal y los trapecios: requiere movilidad de hombro completa sobre la cabeza.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de jalón con los muslos asegurados bajo el pad.\n2. Agarra la barra con un agarre ancho prono, más ancho que la anchura de los hombros.\n3. Mantén el torso erguido e inclina la barbilla ligeramente hacia adelante.\n4. Tira de la barra hacia abajo detrás de la cabeza hasta que toque la base del cuello.\n5. Vuelve de forma controlada al estiramiento completo sobre la cabeza.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Solo realiza este ejercicio si tienes movilidad de hombro completa y sin dolor sobre la cabeza.\n• Usa una carga moderada: no es un levantamiento de fuerza, es un accesorio de hipertrofia.\n\nMúsculos principales: latissimus_dorsi',NULL,'behind-the-neck-lat-pulldown.webp'),
(48,'Press Detrás del Cuello','Behind the Neck Press','Un press vertical con barra realizado por detrás de la nuca, dirigido al deltoides anterior y lateral.\n\nInstrucciones de ejecución:\n1. Siéntate o párate con una barra descansando en la parte alta de los trapecios detrás del cuello.\n2. Agarra la barra más ancho que la anchura de los hombros.\n3. Empuja la barra directamente sobre la cabeza hasta que los brazos estén extendidos.\n4. Baja la barra de vuelta a la posición inicial de forma controlada.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Trabaja primero la movilidad de hombros si la posición resulta incómoda.\n• Baja la barra solo hasta donde tu rango lo permita.\n• Mantén el core firme para no arquear la zona lumbar.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'behind-the-neck-press.webp'),
(49,'Dominada tras nuca','Behind-the-Neck Pull-Up','Una dominada con agarre ancho en la que se tira lo suficientemente alto como para que la barra pase por detrás de la cabeza en lugar de por debajo de la barbilla, lo que obliga a los hombros a llegar al final de su rotación externa.\n\nInstrucciones de ejecución:\n1. Sujeta la barra de dominadas en pronación, con las manos más separadas que los hombros, y cuélgate con los brazos extendidos y las piernas juntas.\n2. Mantén el torso vertical en lugar de inclinarte hacia atrás y tira de los codos hacia abajo y hacia los lados.\n3. Sigue tirando hasta que la barra pase por detrás de la cabeza y la nuca quede a su altura, sin que la barra llegue a tocarte el cuello.\n4. Baja de forma controlada hasta la suspensión completa, manteniendo la cabeza quieta en lugar de dejar que se desplace hacia adelante.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Esta variante está desaconsejada de forma generalizada. Terminar por detrás de la cabeza carga el hombro en el final de su rotación externa, donde la articulación tiene menos capacidad de protegerse, y cualquier contacto entre la barra y el cuello transmite esa carga a la columna cervical.\n• Una dominada normal o con agarre ancho trabaja los mismos músculos en el mismo rango de movimiento del hombro: nada en el desarrollo de la espalda exige que la barra pase por detrás de la cabeza, así que no hay ningún beneficio que compense el riesgo.\n• Si aun así la haces, detente bastante antes de que la barra toque el cuello, y descártala por completo si no tienes movilidad de hombro completa y sin dolor por encima de la cabeza o si tienes antecedentes de problemas de hombro o cuello.\n\nMúsculos principales: latissimus_dorsi',NULL,'behind-the-neck-pull-ups.webp'),
(50,'Fondos en Banco','Bench Dips','Un ejercicio de fondos apoyado en un banco que trabaja principalmente el tríceps con el propio peso corporal.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco y coloca las manos en el borde junto a las caderas.\n2. Desliza las caderas fuera del banco con las piernas extendidas.\n3. Baja el cuerpo flexionando los codos hasta 90 grados.\n4. Empuja con las palmas para volver a la posición inicial.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén la espalda cerca del banco durante todo el recorrido.\n• No dejes que los hombros se hundan hacia las orejas.\n• Flexiona las rodillas si necesitas una versión más fácil.\n\nMúsculos principales: triceps_brachii',NULL,'bench-dips.webp'),
(51,'Encogimiento de Piernas en Banco','Bench Leg Pull-In','Un ejercicio de core en decúbito supino sobre un banco plano que trabaja el recto abdominal llevando las rodillas hacia el pecho.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba sobre un banco plano y agárrate a los lados por encima de la cabeza.\n2. Extiende las piernas rectas con los talones justo por encima de la superficie del banco.\n3. Lleva las rodillas hacia el pecho levantando ligeramente las caderas del banco.\n4. Devuelve las piernas a la posición extendida de forma controlada sin apoyar los talones.\n5. Repite el número de repeticiones indicado.\n\nConsejos técnicos:\n• Presiona la zona lumbar contra el banco para reducir la participación del psoas.\n• Controla la fase excéntrica; no dejes que la gravedad baje las piernas sin control.\n• Contrae el abdomen en el punto más alto de cada repetición.\n\nMúsculos principales: rectus_abdominis',NULL,'bench-leg-pull-in.webp'),
(52,'Remo en Banco','Bench Pull','Un remo tumbado boca abajo sobre un banco elevado que centra el trabajo en la espalda al apoyar el torso.\n\nInstrucciones de ejecución:\n1. Acuéstate boca abajo en un banco elevado con los brazos colgando rectos hacia abajo.\n2. Agarra una barra o mancuernas debajo de ti.\n3. Rema el peso hasta la parte inferior del banco.\n4. Aprieta los omóplatos en la parte superior.\n5. Baja de forma controlada y repite.\n\nConsejos técnicos:\n• Mantén el pecho pegado al banco durante toda la serie.\n• Tira con los codos en lugar de con las manos.\n• Evita los tirones bruscos al iniciar cada repetición.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'bench-pull.webp'),
(53,'Pullover con Barra y Brazos Flexionados','Bent Arm Barbell Pullover','Un pullover con barra y codos flexionados que lleva el peso por detrás de la cabeza para trabajar dorsales y pectoral.\n\nInstrucciones de ejecución:\n1. Acuéstate en un banco sosteniendo una barra sobre el pecho con los codos flexionados.\n2. Mantén los codos flexionados durante todo el movimiento.\n3. Baja la barra detrás de la cabeza en un arco.\n4. Tira de la barra de vuelta sobre el pecho usando el dorsal.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén la cadera y la zona lumbar en contacto con el banco.\n• Baja solo hasta donde notes un estiramiento cómodo.\n• Empieza con un peso ligero hasta dominar la trayectoria.\n\nMúsculos principales: latissimus_dorsi, pectoralis_major',NULL,'bent-arm-barbell-pullover.webp'),
(54,'Pullover con Barra Z y Brazos Flexionados','Bent-Arm EZ-Bar Pullover','Un pullover con brazos flexionados en un banco plano usando una barra Z, más amigable para las muñecas que la versión con barra recta, manteniendo el estiramiento profundo del dorsal y el pectoral.\n\nInstrucciones de ejecución:\n1. Acuéstate en un banco plano sosteniendo una barra Z con un agarre prono estrecho en las curvas internas.\n2. Comienza con la barra sobre el pecho, codos flexionados a aproximadamente 90 grados.\n3. Mantén el ángulo de los codos fijo y baja la barra en un arco sobre la cabeza hasta sentir un estiramiento profundo en el dorsal y el pectoral.\n4. Tira de la barra de vuelta sobre el pecho por el mismo arco, sin extender los codos.\n5. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• El ángulo de los codos permanece fijo: solo se mueve el hombro.\n• Carga menor que en un pullover con brazos extendidos: el rango es mayor y el brazo de palanca es menor.\n• Si la zona lumbar se arquea, planta los pies con más firmeza y aprieta el abdomen.\n\nMúsculos principales: latissimus_dorsi, pectoralis_major',NULL,'bent-arm-ez-bar-pullover.webp'),
(55,'Remo con Mancuernas Inclinado','Bent-Over Dumbbell Row','Un remo inclinado a dos brazos con una mancuerna en cada mano, que trabaja la espalda y exige estabilidad.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies a la anchura de las caderas, sujetando una mancuerna en cada mano a los lados, con las palmas hacia dentro.\n2. Flexiona las caderas con la espalda recta hasta que el torso quede a unos 30–45 grados de la horizontal, con las mancuernas colgando justo debajo de los hombros.\n3. Activa el core y tira de ambas mancuernas hacia arriba y ligeramente atrás, llevando los codos por detrás de las costillas.\n4. Aprieta la parte alta de la espalda arriba, manteniendo los codos pegados.\n5. Baja de forma controlada hasta la posición inicial con los brazos completamente estirados.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• El ángulo del torso se mantiene fijo todo el rato; no te incorpores para ayudar al peso.\n• Tira hacia las costillas bajas o el abdomen, no hacia el pecho; así mantienes el dorsal cargado.\n• Si la lumbar se redondea, flexiona menos y recoloca antes de la siguiente serie.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'bent-over-db-row.webp'),
(56,'Remo con Barra Z Inclinado','Bent-Over EZ-Bar Row','Un movimiento de jalón horizontal con barra Z para un ejercicio de remo de espalda amigable con las muñecas.\n\nInstrucciones de ejecución:\n1. Sostén una barra Z con agarre prono e inclínate en las caderas a 45 grados.\n2. Tira de la barra hacia la parte inferior de las costillas.\n3. Baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• Mantén la espalda plana durante todo el movimiento.\n• Inicia el movimiento con los codos, no con las manos.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'bent-over-ez-bar-row.webp'),
(57,'Curl de Bíceps con Mancuernas','Dumbbell Bicep Curl','Un ejercicio de aislamiento que trabaja los bíceps.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo mancuernas a los lados, palmas hacia adelante.\n2. Sube las mancuernas hacia los hombros.\n3. Aprieta en la parte superior, luego baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• Mantén los codos pegados a los costados.\n• Evita balancear las mancuernas.\n\nMúsculos principales: biceps_brachii',NULL,'bicep-curl.webp'),
(58,'Crunch de Bicicleta','Bicycle Crunch','Una variación dinámica del crunch que trabaja tanto el recto abdominal como los oblicuos.\n\nInstrucciones de ejecución:\n1. Acuéstate boca arriba con las manos detrás de la cabeza y las piernas elevadas.\n2. Acerca una rodilla al pecho mientras rotas el torso para encontrarla con el codo opuesto.\n3. Extiende esa pierna mientras traes la otra rodilla hacia adentro.\n4. Continúa alternando en un movimiento de pedaleo.\n5. Repite.\n\nConsejos técnicos:\n• No tires del cuello con las manos.\n• Lleva el hombro hacia la rodilla, no solo el codo.\n• Mantén la zona lumbar apoyada en el suelo.\n\nMúsculos principales: obliques, rectus_abdominis',NULL,'bicycle-crunch.webp'),
(59,'Bird-Dog','Bird-Dog','Un ejercicio de estabilidad del core que extiende el brazo y la pierna opuestos para trabajar los erectores espinales y el core profundo.\n\nInstrucciones de ejecución:\n1. Comienza a cuatro patas con la columna en posición neutra.\n2. Extiende el brazo derecho hacia adelante y la pierna izquierda hacia atrás simultáneamente.\n3. Aguanta un momento, luego vuelve.\n4. Repite en el otro lado.\n5. Alterna.\n\nConsejos técnicos:\n• Muévete lentamente y con control.\n• Mantén las caderas niveladas en todo momento.\n\nMúsculos principales: erector_spinae, transverse_abdominis',NULL,'bird-dog.webp'),
(60,'Elevación de Talones con Peso Corporal','Bodyweight Calf Raise','Una elevación de talones con el propio peso corporal, un ejercicio básico para fortalecer los gemelos.\n\nInstrucciones de ejecución:\n1. Colócate de pie con los pies separados al ancho de las caderas sobre una superficie plana.\n2. Sube de puntillas lo más alto posible.\n3. Aprieta los gemelos en la parte superior.\n4. Baja los talones al suelo de forma controlada.\n5. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Reparte el peso entre todos los dedos al subir.\n• Mantén las piernas rectas para centrar el trabajo en el gemelo.\n• Fija la mirada en un punto para mantener el equilibrio.\n\nMúsculos principales: gastrocnemius',NULL,'bodyweight-calf-raise.webp'),
(61,'Buenos Días con Peso Corporal','Bodyweight Good Morning','Una bisagra de cadera con el propio peso corporal que fortalece los erectores espinales y los isquiotibiales.\n\nInstrucciones de ejecución:\n1. Colócate de pie con los pies separados al ancho de las caderas y las manos detrás de la cabeza.\n2. Mantén una ligera flexión en las rodillas y contrae el core.\n3. Bisagra en las caderas y baja el torso hasta quedar casi paralelo al suelo.\n4. Impulsa las caderas hacia adelante para volver a la posición erguida.\n5. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Empuja la cadera hacia atrás como si cerraras un cajón.\n• Mantén la espalda recta durante toda la bajada.\n• Detén el descenso si notas que la zona lumbar se redondea.\n\nMúsculos principales: erector_spinae, hamstrings',NULL,'bodyweight-good-morning.webp'),
(62,'Elevación Lateral con Peso Corporal','Bodyweight Lateral Raise','Un movimiento de aislamiento de hombros sin equipamiento para desarrollar el ancho del deltoides lateral.\n\nInstrucciones de ejecución:\n1. Párate erguido con los brazos colgando a los lados.\n2. Levanta ambos brazos hacia los lados con un ligero codo doblado hasta la altura de los hombros.\n3. Haz una pausa breve arriba.\n4. Baja lentamente a la posición inicial.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Lidera el movimiento con los codos, no con las manos.\n• Evita encoger los hombros en la parte superior.\n• Controla el descenso para maximizar el tiempo bajo tensión.\n\nMúsculos principales: lateral_deltoid',NULL,'bodyweight-lateral-raise.webp'),
(63,'Press por Encima de la Cabeza con Peso Corporal','Bodyweight Overhead Press','Un press vertical de peso corporal en posición de pica que imita el patrón del press de hombros sin material.\n\nInstrucciones de ejecución:\n1. Colócate de pie frente a una pared en posición de pica con las manos en el suelo.\n2. Acerca los pies a la pared para lograr una línea corporal más vertical.\n3. Baja la cabeza hacia el suelo flexionando los codos.\n4. Presiona con las manos para extender los brazos.\n5. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Da pasos cortos con los pies para ajustar la dificultad.\n• Mantén el cuello neutro, con la mirada entre las manos.\n• Reparte el peso por toda la palma para aliviar las muñecas.\n\nMúsculos principales: anterior_deltoid, triceps_brachii',NULL,'bodyweight-overhead-press.webp'),
(64,'Zancada Inversa con Peso Corporal','Bodyweight Reverse Lunge','Una variante de zancada usando solo el peso corporal, dando un paso hacia atrás para mayor estabilidad de rodilla que una zancada hacia adelante.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies separados a la altura de las caderas.\n2. Da un paso hacia atrás con una pierna y baja la rodilla hacia el suelo.\n3. Baja hasta que tu muslo delantero quede paralelo al suelo.\n4. Empuja a través del talón delantero para volver a la posición de pie.\n5. Repite con ambas piernas.\n\nConsejos técnicos:\n• No necesitas peso -- concéntrate en el equilibrio y un descenso controlado.\n• Mantén el torso erguido en lugar de inclinarte hacia adelante.\n• Da un paso lo suficientemente atrás para que tu rodilla delantera quede detrás de los dedos del pie.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'bodyweight-reverse-lunge.webp'),
(65,'Sentadilla con Peso Corporal','Bodyweight Squat','Una sentadilla con el propio peso corporal, apta para principiantes, que desarrolla los glúteos y los cuádriceps.\n\nInstrucciones de ejecución:\n1. Colócate de pie con los pies separados al ancho de los hombros y los brazos extendidos al frente.\n2. Siéntate hacia atrás y hacia abajo flexionando caderas y rodillas.\n3. Baja hasta que los muslos queden paralelos al suelo.\n4. Empuja con los talones para volver a la posición de pie.\n5. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Empuja las rodillas hacia afuera en línea con los pies.\n• Mantén el pecho erguido y la mirada al frente.\n• Evita que los talones se despeguen del suelo al bajar.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'bodyweight-squat.webp'),
(66,'Salto al Cajón','Box Jump','Un salto pliométrico desde media sentadilla a un cajón estable, que entrena la potencia del tren inferior.\n\nInstrucciones de ejecución:\n1. Mantente a unos 30 cm frente a un cajón firme con los pies a la anchura de los hombros.\n2. Baja a una media sentadilla y balancea los brazos atrás.\n3. Lanza los brazos arriba y salta explosivamente al cajón.\n4. Aterriza suave con los pies planos y rodillas flexionadas.\n5. Baja caminando — no saltando — y reinicia.\n\nConsejos técnicos:\n• Baja siempre caminando — los saltos hacia abajo repetidos sobrecargan el Aquiles.\n• Aterriza suave con todo el pie, rodillas alineadas con los dedos.\n• Elige una altura que puedas superar sin doblar la cadera.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'box-jump.webp'),
(67,'Sentadilla en Caja','Box Squat','Una sentadilla realizada hasta una caja o banco, que fija la profundidad y enseña a sentarse hacia atrás en las caderas.\n\nInstrucciones de ejecución:\n1. Ponte de pie frente a una caja o banco, con los pies al ancho de los hombros y los brazos extendidos hacia adelante para el equilibrio.\n2. Empuja las caderas hacia atrás y flexiona las rodillas, sentándote hacia la caja en lugar de bajar en línea recta.\n3. Toca la caja ligeramente con los glúteos sin dejarte caer sobre ella.\n4. Empuja con los pies para volver a ponerte de pie, apretando los glúteos arriba.\n5. Repite las repeticiones deseadas.\n\nConsejos técnicos:\n• Usa una altura de caja que permita que los muslos queden aproximadamente paralelos al suelo, y bájala a medida que mejore tu movilidad.\n• Mantén el peso en el centro de los pies — no te inclines hacia los dedos.\n• No te sientes por completo en la caja: relajar todo el peso sobre ella te hace perder tensión en el core y sobrecarga la columna.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'box-squat.webp'),
(68,'Sentadilla Búlgara','Bulgarian Split Squat','Una variante de sentadilla unilateral con el pie trasero elevado.\n\nInstrucciones de ejecución:\n1. Colócate de pie frente a un banco y apoya un pie detrás sobre el banco.\n2. Sujeta mancuernas a los lados.\n3. Baja el cuerpo hasta que el muslo delantero quede paralelo al suelo.\n4. Empuja con el talón delantero para volver a la posición de pie.\n5. Repite en ambos lados.\n\nConsejos técnicos:\n• Mantén casi todo el peso sobre la pierna adelantada.\n• Ajusta la distancia al banco hasta que la zancada sea estable.\n• Completa todas las repeticiones con una pierna antes de cambiar.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'bulgarian-split-squat.webp'),
(69,'Remo Inclinado con Cable','Cable Bent-Over Row','Una variante de remo con cable que proporciona tensión constante durante todo el movimiento.\n\nInstrucciones de ejecución:\n1. Engancha una barra recta o un agarre en V a la polea baja.\n2. Inclínate hacia adelante desde las caderas con las rodillas ligeramente flexionadas.\n3. Tira del agarre hacia la parte inferior del pecho.\n4. Aprieta los omóplatos en la parte superior.\n5. Baja de forma controlada y repite.\n\nConsejos técnicos:\n• Mantén la espalda recta y el torso estable durante toda la serie.\n• Piensa en llevar los codos hacia atrás, no en tirar con las manos.\n• No dejes que el peso te arrastre hacia delante al bajar.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'cable-bent-over-row.webp'),
(70,'Press de Pecho con Cable','Cable Chest Press','Un press de pecho de pie en polea que ofrece tensión constante sobre el pectoral durante todo el recorrido.\n\nInstrucciones de ejecución:\n1. Ajusta los cables a la altura del pecho y colócate de espaldas a la máquina.\n2. Sujeta un agarre en cada mano y da un paso adelante adoptando una postura escalonada.\n3. Empuja los agarres hacia adelante hasta extender los brazos completamente.\n4. Aprieta el pecho en la parte superior.\n5. Vuelve de forma controlada y repite.\n\nConsejos técnicos:\n• Evita que los hombros se adelanten al extender los brazos.\n• Mantén el core activo para no perder el equilibrio.\n• Mantén las muñecas rectas durante la fase de empuje.\n\nMúsculos principales: pectoralis_major',NULL,'cable-chest-press.webp'),
(71,'Crunch con Cable','Cable Crunch','Un encogimiento abdominal de rodillas en polea alta con cuerda, que permite añadir carga progresiva al trabajo del recto abdominal.\n\nInstrucciones de ejecución:\n1. Arrodíllate frente a una máquina de cable con el accesorio de cuerda en la parte superior.\n2. Sujeta la cuerda cerca de la frente con los codos flexionados.\n3. Baja flexionando la columna y llevando los codos hacia los muslos.\n4. Aprieta fuerte los abdominales en la parte inferior.\n5. Vuelve a la posición inicial y repite.\n\nConsejos técnicos:\n• Flexiona la columna en lugar de tirar con los brazos.\n• Evita sentarte hacia atrás con la cadera en cada repetición.\n• Exhala con fuerza al bajar para contraer mejor el abdomen.\n\nMúsculos principales: rectus_abdominis',NULL,'cable-crunch.webp'),
(72,'Curl con Cable','Cable Curl','Un curl de bíceps con resistencia de cable para tensión constante.\n\nInstrucciones de ejecución:\n1. Colócate de pie frente a una polea baja con una barra recta o barra Z.\n2. Agarra la barra con agarre supino y los codos pegados a los costados.\n3. Sube la barra hacia los hombros.\n4. Baja de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Evita que los codos se adelanten al subir la barra.\n• No balancees el torso para ayudarte con el peso.\n• Aleja un poco el cuerpo de la polea para mantener la tensión.\n\nMúsculos principales: biceps_brachii',NULL,'cable-curl.webp'),
(73,'Rotación Externa con Cable','Cable External Rotation','Un ejercicio de rotación externa en polea, con el codo pegado al costado, que fortalece el deltoides posterior y la parte alta de la espalda.\n\nInstrucciones de ejecución:\n1. Ajusta la polea a la altura del codo y agarra el handle.\n2. Colócate de lado a la máquina con el codo de trabajo flexionado a 90 grados.\n3. Mantén el codo pegado al costado y rota el antebrazo hacia afuera.\n4. Pausa al final del movimiento.\n5. Vuelve de forma controlada. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Evita encoger los hombros mientras giras el brazo.\n• Trabaja con poco peso y de forma lenta y controlada.\n• Mantén la muñeca firme, alineada con el antebrazo.\n\nMúsculos principales: posterior_deltoid',NULL,'cable-external-rotation.webp'),
(74,'Aperturas con Cable','Cable Fly','Un ejercicio de aislamiento para el pecho con resistencia de cable para tensión constante.\n\nInstrucciones de ejecución:\n1. Colócate entre dos columnas de cable con los agarres enganchados a las poleas altas.\n2. Con una ligera flexión en los codos, abre los brazos hacia los lados.\n3. Junta las manos frente al pecho en un movimiento de abrazo.\n4. Vuelve lentamente a la posición inicial.\n5. Repite.\n\nConsejos técnicos:\n• Mantén el ángulo de los codos constante para no convertirlo en un press.\n• Aprieta el pecho un segundo cuando las manos se encuentren.\n• No adelantes los hombros cuando los brazos están abiertos.\n\nMúsculos principales: pectoralis_major',NULL,'cable-fly.webp'),
(75,'Elevación Frontal con Cable','Cable Front Raise','Una elevación frontal en polea que aísla el deltoides anterior con tensión constante durante todo el recorrido.\n\nInstrucciones de ejecución:\n1. Colócate de espaldas a una polea baja con un agarre.\n2. Sujeta el agarre con el brazo extendido a la altura del muslo.\n3. Levanta el brazo hacia adelante hasta la altura del hombro manteniéndolo recto.\n4. Pausa en la parte superior.\n5. Baja de forma controlada y repite.\n\nConsejos técnicos:\n• Evita balancear el torso para ayudarte a subir.\n• Mantén el codo casi recto, sin bloquearlo.\n• Baja más despacio de lo que subes para aprovechar la tensión del cable.\n\nMúsculos principales: anterior_deltoid',NULL,'cable-front-raise.webp'),
(76,'Curl de Martillo en Cable','Cable Hammer Curl','Un curl en cable con cuerda y agarre neutro que trabaja el braquial y braquiorradial con tensión constante.\n\nInstrucciones de ejecución:\n1. Engancha una cuerda a la polea baja y párate frente a la máquina.\n2. Agarra la cuerda con agarre neutro, palmas enfrentadas.\n3. Sube la cuerda hacia los hombros manteniendo los codos fijos a los lados.\n4. Aprieta arriba, luego baja lentamente hasta la extensión completa.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén los codos inmóviles durante todo el movimiento.\n• Separa ligeramente los extremos de la cuerda arriba para mayor contracción.\n• Evita balancear el torso.\n\nMúsculos principales: biceps_brachii, brachialis, brachioradialis',NULL,'cable-hammer-curl.webp'),
(77,'Patada Trasera de Glúteos en Cable','Cable Glute Kickback','Un ejercicio de aislamiento en cable para el glúteo mayor que extiende la cadera hacia atrás contra resistencia constante.\n\nInstrucciones de ejecución:\n1. Coloca una correa de tobillo en la polea baja y sujétala alrededor de un tobillo.\n2. De pie frente a la máquina, agárrate ligeramente al soporte e inclínate un poco desde las caderas.\n3. Lleva la pierna con la correa hacia atrás extendiendo la cadera completamente y manteniendo la rodilla casi recta.\n4. Aprieta el glúteo en la extensión máxima y regresa el pie lentamente a la posición inicial.\n5. Completa todas las repeticiones de un lado antes de cambiar.\n\nConsejos técnicos:\n• Conduce el movimiento con el talón para maximizar la activación del glúteo.\n• Mantén las caderas paralelas; evita rotar la pelvis al patear hacia atrás.\n• El movimiento viene solo de la cadera: mantén la espalda y la pierna de apoyo estables.\n\nMúsculos principales: gluteus_maximus',NULL,'cable-kickback.webp'),
(78,'Elevación Lateral en Polea','Cable Lateral Raise','Una elevación lateral unilateral en polea, que ofrece tensión constante sobre el deltoides lateral.\n\nInstrucciones de ejecución:\n1. Colócate de lado a una polea baja y agarra el asa con la mano externa.\n2. Mantén una ligera flexión en el codo y el cable por delante de la pierna que trabaja.\n3. Sube el brazo hacia el lado hasta quedar paralelo al suelo.\n4. Baja con control. Repeticiones por lado, luego cambia.\n5. Mantén la tensión — no dejes que el peso descanse abajo.\n\nConsejos técnicos:\n• Lidera con el codo, no con la mano.\n• Pausa brevemente arriba, sin balanceo.\n• Usa menos carga que con mancuerna — la tensión del cable es constante.\n\nMúsculos principales: lateral_deltoid',NULL,'cable-lateral-raise.webp'),
(79,'Press Pallof en Polea','Cable Pallof Press','Un ejercicio de core antirrotación en el que la polea tira de ti hacia un lado mientras empujas el agarre recto desde el pecho y te niegas a dejar que el torso gire.\n\nInstrucciones de ejecución:\n1. Coloca la polea a la altura del pecho y toma el agarre con ambas manos, situado de lado respecto a la máquina.\n2. Sepárate hasta que haya tensión real en el cable, con los pies a la anchura de los hombros y las rodillas ligeramente flexionadas.\n3. Lleva el agarre al centro del pecho y aprieta el tronco y los glúteos.\n4. Empuja el agarre recto hacia delante hasta extender los brazos, resistiendo el tirón que quiere rotarte hacia la máquina.\n5. Mantén un instante la posición extendida y devuelve después el agarre al pecho de forma controlada.\n6. Completa las repeticiones deseadas, luego date la vuelta y repite hacia el otro lado.\n\nConsejos técnicos:\n• Nada debe rotar. Si los hombros giran hacia la polea al empujar, baja el peso — lo que entrena es la rotación que no llega a ocurrir.\n• Cuanto más te alejes de la máquina, más largo es el brazo de palanca y más cuesta, así que puedes cambiar la dificultad sin tocar el stack.\n• Mantén los brazos a la altura del pecho y los hombros abajo; dejar que el agarre suba lo convierte en una elevación frontal.\n\nMúsculos principales: obliques, transverse_abdominis',NULL,'cable-pallof-press.webp'),
(80,'Patada de Tríceps con Cable','Cable Tricep Kickback','Una extensión de tríceps en polea baja, realizada con el torso inclinado, que mantiene la tensión en el bloqueo final.\n\nInstrucciones de ejecución:\n1. Engancha un handle a la polea baja e inclínate hacia adelante desde las caderas.\n2. Pega la parte superior del brazo al costado con el codo flexionado a 90 grados.\n3. Extiende el codo para empujar el handle hacia atrás.\n4. Aprieta el tríceps al final del movimiento.\n5. Vuelve de forma controlada. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Evita que el codo caiga o se abra durante la extensión.\n• Mantén la espalda recta mientras el torso está inclinado.\n• Usa un peso ligero para no recurrir al impulso.\n\nMúsculos principales: triceps_brachii',NULL,'cable-tricep-kickback.webp'),
(81,'Remo al Mentón con Cable','Cable Upright Row','Un remo al mentón con cable para tensión constante en los deltoides laterales y el trapecio.\n\nInstrucciones de ejecución:\n1. Colócate frente a la máquina de cable y agarra una barra recta o cuerda a la altura de los muslos.\n2. Tira de la barra hacia el mentón llevando los codos por delante.\n3. Baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• Mantén los codos más altos que las muñecas.\n• Evita encoger los hombros en exceso.\n\nMúsculos principales: lateral_deltoid, trapezius',NULL,'cable-upright-row.webp'),
(82,'Curl de Muñeca con Cable','Cable Wrist Curl','Un curl de muñeca en polea baja, con los antebrazos apoyados en un banco, que fortalece los flexores del antebrazo.\n\nInstrucciones de ejecución:\n1. Engancha una barra recta a la polea baja.\n2. Arrodíllate o siéntate con los antebrazos sobre un banco, palmas hacia arriba.\n3. Deja que las muñecas se flexionen sobre el borde del banco.\n4. Sube la barra flexionando las muñecas.\n5. Baja de forma controlada y repite.\n\nConsejos técnicos:\n• Mueve solo las muñecas, sin levantar los antebrazos del banco.\n• Usa cargas moderadas para no castigar las muñecas.\n• Sube y baja despacio, sin rebotes en el estiramiento.\n\nMúsculos principales: forearm_flexors',NULL,'cable-wrist-curl.webp'),
(83,'Elevación de Rodillas en Silla Romana','Captain\'s Chair Knee Raise','Un ejercicio de peso corporal en silla romana que trabaja el abdomen bajo y los flexores de cadera.\n\nInstrucciones de ejecución:\n1. Colócate en la silla romana con la espalda plana contra el respaldo y los antebrazos en los apoyos.\n2. Deja las piernas colgando rectas hacia abajo.\n3. Activa el core y sube las rodillas hacia el pecho.\n4. Mantén brevemente arriba, luego baja despacio a la posición inicial.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Evita balancear las piernas para tomar impulso.\n• Exhala al subir las rodillas.\n• Mantén la espalda contra el respaldo durante todo el ejercicio.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'captains-chair-knee-raise.webp'),
(84,'Elevación de Piernas en Silla Romana','Captain\'s Chair Leg Raise','Un ejercicio de peso corporal en silla romana para el abdomen bajo con piernas rectas, de mayor dificultad.\n\nInstrucciones de ejecución:\n1. Colócate en la silla romana con la espalda plana contra el respaldo y los antebrazos en los apoyos.\n2. Deja las piernas colgando rectas hacia abajo.\n3. Con las piernas rectas, súbelas hasta la horizontal o más arriba.\n4. Mantén brevemente arriba, luego baja despacio.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén las piernas lo más rectas posible.\n• Evita el balanceo — controla el movimiento con el core.\n• Dobla ligeramente las rodillas para reducir la dificultad si es necesario.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'captains-chair-leg-raise.webp'),
(85,'Gato-Vaca','Cat-Cow','Un flujo a cuatro apoyos que alterna entre redondear la columna hacia el techo y dejarla descender mientras el pecho se abre, moviendo cada segmento de la espalda por su recorrido.\n\nInstrucciones de ejecución:\n1. Colócate a cuatro apoyos con las manos bajo los hombros y las rodillas bajo las caderas.\n2. Exhala y redondea la columna hacia el techo, metiendo el coxis y dejando caer la cabeza.\n3. Inhala e inviértelo: deja descender el abdomen, eleva el pecho y el coxis y mira ligeramente al frente.\n4. Alterna entre ambas formas despacio, una respiración por posición.\n5. Termina en columna neutra y siéntate sobre los talones.\n\nConsejos técnicos:\n• Deja que la respiración marque el ritmo en lugar de correr entre las dos posiciones.\n• Presiona las manos por igual para que los hombros no se hundan hacia el suelo.\n• Mueve toda la columna, incluido el cuello, en lugar de doblar solo la zona lumbar.\n\nMúsculos principales: erector_spinae, rectus_abdominis',NULL,'cat-cow.webp'),
(86,'Curl con Impulso','Cheat Curl','Un curl de bíceps que emplea un ligero impulso de cadera para iniciar la subida y enfatiza una bajada lenta y controlada.\n\nInstrucciones de ejecución:\n1. Colócate de pie sujetando el peso a la altura de los muslos con agarre supino.\n2. Usa un ligero impulso de cadera para iniciar el curl.\n3. Sube el peso hacia los hombros de forma explosiva.\n4. Baja el peso lentamente de forma controlada por todo el rango de movimiento.\n5. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Evita convertir el ejercicio en un balanceo de todo el cuerpo.\n• Si no puedes controlar la bajada, reduce la carga.\n• Mantén el abdomen firme para proteger la zona lumbar.\n\nMúsculos principales: biceps_brachii',NULL,'cheat-curl.webp'),
(87,'Press de Pecho en Máquina','Machine Chest Press','Un movimiento de empuje para el pecho en máquina, ideal para principiantes.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina con la espalda plana contra el respaldo.\n2. Agarra los mangos a la altura del pecho.\n3. Empuja los mangos hacia adelante hasta extender los brazos completamente.\n4. Vuelve lentamente a la posición inicial.\n5. Repite.\n\nConsejos técnicos:\n• Ajusta el asiento para que las manijas queden a la altura del pecho.\n• Empuja sin bloquear los codos de golpe.\n• Vuelve atrás con control, sin soltar el peso de golpe.\n\nMúsculos principales: pectoralis_major',NULL,'chest-press-machine.webp'),
(88,'Remo con Mancuernas con Apoyo en el Pecho','Chest-Supported Dumbbell Row','Un remo con mancuernas con apoyo en el pecho para eliminar la tensión en la zona lumbar y aislar los músculos de la espalda.\n\nInstrucciones de ejecución:\n1. Túmbate boca abajo en un banco inclinado con las mancuernas colgando por debajo.\n2. Rema las mancuernas hacia los lados.\n3. Aprieta en la parte superior y baja.\n4. Repite.\n\nConsejos técnicos:\n• El apoyo en el pecho elimina la fatiga de la espalda.\n• Concéntrate en juntar los omóplatos.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'chest-supported-db-row.webp'),
(89,'Encogimiento de Hombros con Mancuernas y Apoyo en el Pecho','Chest Supported Dumbbell Shrug','Un encogimiento de hombros boca abajo en un banco inclinado, donde el apoyo del pecho aísla el trapecio y elimina el impulso.\n\nInstrucciones de ejecución:\n1. Ajusta un banco inclinado a unos 30 grados.\n2. Túmbate boca abajo en el banco sujetando mancuernas con los brazos extendidos.\n3. Encoge los hombros hacia arriba y hacia atrás en dirección a las orejas.\n4. Aprieta el trapecio superior en la parte superior.\n5. Baja de forma controlada y repite.\n\nConsejos técnicos:\n• Encoge hacia arriba y atrás hacia las orejas, no solo recto hacia arriba.\n• Mantén el pecho pegado a la almohadilla para no usar impulso.\n• Haz una pausa y aprieta arriba antes de bajar con control.\n\nMúsculos principales: trapezius',NULL,'chest-supported-dumbbell-shrug.webp'),
(90,'Remo con Kettlebell Apoyado en el Pecho','Chest-Supported Kettlebell Row','Este ejercicio trabaja los músculos de tu espalda, principalmente el dorsal ancho y los romboides, al tirar de una kettlebell hacia tu pecho mientras tu torso está apoyado.\n\nInstrucciones de ejecución:\n1. Acuéstate boca abajo en un banco inclinado, dejando que tus brazos cuelguen libremente con una kettlebell en cada mano.\n2. Contrae tu abdomen y retrae tus escápulas.\n3. Tira de las kettlebells hacia tus caderas, apretando tus escápulas.\n4. Haz una breve pausa en la parte superior, sintiendo la contracción en tu espalda.\n5. Baja lentamente las kettlebells a la posición inicial con control.\n\nConsejos técnicos:\n• Mantén el torso estable durante todo el movimiento; evita balancearte.\n• Concéntrate en iniciar el tirón con los músculos de la espalda, no solo con los brazos.\n• Mantén los codos cerca de tu cuerpo para enfatizar el dorsal ancho.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'chest-supported-kettlebell-row.webp'),
(91,'Remo con Apoyo en el Pecho en Máquina Smith','Chest-Supported Smith Machine Row','Un remo contra un respaldo inclinado dentro de la máquina Smith, donde el apoyo del pecho saca la zona lumbar del movimiento y la barra guiada mantiene el tirón en una sola línea.\n\nInstrucciones de ejecución:\n1. Coloca un banco inclinado dentro de la máquina Smith mirando hacia la barra, y baja la barra lo suficiente para que tus brazos cuelguen rectos al apoyarte en el respaldo.\n2. Ponte de pie a horcajadas del banco con los pies firmes y el pecho apoyado en la parte alta del respaldo.\n3. Toma un agarre prono algo más ancho que los hombros y desengancha la barra con los brazos extendidos.\n4. Tira de la barra hacia la parte baja del pecho, guiando con los codos y juntando las escápulas arriba.\n5. Baja la barra de forma controlada hasta estirar los brazos de nuevo y repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén el pecho en el respaldo en cada repetición. En cuanto te separas de él para mover el peso lo has convertido otra vez en un remo inclinado y has perdido la razón del montaje.\n• Guía con los codos y detente cuando pasen del torso. Tirar más solo adelanta los hombros, y la trayectoria fija de la barra no les deja escapatoria.\n• Como aquí la zona lumbar no hace nada, este es el remo para los días en que un remo inclinado no es opción: ajusta el peso a lo que tu espalda puede tirar, no a lo que tus piernas podrían aguantar.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'chest-supported-smith-machine-row.webp'),
(92,'Dominadas en Supinación','Chin-Ups','Una variante de dominadas con agarre supino que activa fuertemente los bíceps junto con el dorsal ancho.\n\nInstrucciones de ejecución:\n1. Cuélgate de una barra con agarre supino a la anchura de los hombros.\n2. Sube hasta que el mentón supere la barra.\n3. Baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• Mantén el core contraído durante todo el ejercicio.\n• Evita el balanceo excesivo.\n\nMúsculos principales: biceps_brachii, latissimus_dorsi',NULL,'chin-ups.webp'),
(93,'Almejas','Clamshells','Un ejercicio de abducción de cadera, realizado tumbado de lado, que activa el glúteo medio sin material adicional.\n\nInstrucciones de ejecución:\n1. Túmbate de lado con las rodillas dobladas y apiladas una sobre la otra.\n2. Mantén los pies juntos y las caderas alineadas.\n3. Abre la rodilla superior hacia el techo sin rotar las caderas.\n4. Aprieta el glúteo externo en la posición superior.\n5. Baja de forma controlada. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Sube la rodilla solo hasta donde la pelvis no se mueva.\n• Hazlo lento y controlado para notar bien el glúteo medio.\n• Exhala al abrir la rodilla y mantén el abdomen activo.\n\nMúsculos principales: abductors, gluteus_medius',NULL,'clamshells.webp'),
(94,'Flexiones con Palmada','Clap Push-Ups','Una flexión pliométrica explosiva que desarrolla la potencia del pecho y las fibras musculares de contracción rápida.\n\nInstrucciones de ejecución:\n1. Comienza en la posición estándar de flexión.\n2. Baja el pecho hacia el suelo.\n3. Empuja hacia arriba de forma explosiva para que las manos despeguen del suelo.\n4. Da una palmada y aterriza suavemente, volviendo a la posición inicial.\n5. Repite.\n\nConsejos técnicos:\n• Aterriza con los codos ligeramente flexionados para absorber el impacto.\n• Asegúrate de tener suficiente fuerza en la parte superior del cuerpo antes de intentarlo.\n\nMúsculos principales: pectoralis_major',NULL,'clap-push-ups.webp'),
(95,'Clean and Jerk','Clean and Jerk','Un levantamiento olímpico en dos partes: cargas la barra hasta los hombros y luego la impulsas por encima de la cabeza en posición de tijera.\n\nInstrucciones de ejecución:\n1. Lleva la barra cargada desde el suelo hasta los hombros como en un clean.\n2. Ponte completamente erguido con la barra apoyada en los deltoides anteriores.\n3. Flexiona ligeramente las rodillas y lanza la barra sobre la cabeza de forma explosiva.\n4. Separa las piernas para recibir la barra con los brazos extendidos.\n5. Recupera la posición juntando los pies.\n\nConsejos técnicos:\n• Ponte de pie por completo y recoloca tu posición antes de iniciar el envión.\n• Impulsa la barra con las piernas, no solo con los brazos.\n• Bloquea los brazos mientras los pies aterrizan en la tijera.\n\nMúsculos principales: anterior_deltoid, gluteus_maximus, quadriceps',NULL,'clean-and-jerk.webp'),
(96,'Clean','Clean','Un levantamiento olímpico en el que tiras de la barra de forma explosiva desde el suelo hasta la posición de rack frontal sobre los hombros.\n\nInstrucciones de ejecución:\n1. Colócate sobre una barra cargada con los pies a la anchura de las caderas.\n2. Agarra la barra justo por fuera de las rodillas con un agarre prono.\n3. Empuja de forma explosiva con las piernas y extiende las caderas.\n4. Métete bajo la barra y recíbela sobre los deltoides anteriores.\n5. Ponte completamente erguido para completar el levantamiento.\n\nConsejos técnicos:\n• Mantén la barra cerca del cuerpo mientras sube.\n• Completa el empuje de piernas antes de tirar por debajo de la barra.\n• Recibe con los codos altos para que la barra descanse en los hombros.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'clean.webp'),
(97,'Curl de Barra con Agarre Cerrado','Close-Grip Barbell Curl','Un curl de barra de pie con agarre estrecho que enfatiza la cabeza larga del bíceps y el braquial.\n\nInstrucciones de ejecución:\n1. De pie, sujeta la barra con un agarre supino con las manos más juntas que la anchura de los hombros.\n2. Comienza con la barra a la altura de los muslos, brazos extendidos y codos pegados a los costados.\n3. Sube la barra hasta los hombros flexionando los codos.\n4. Aprieta los bíceps en la parte superior y luego baja de forma controlada.\n5. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Mantén los codos pegados a los costados; no dejes que se desplacen hacia adelante.\n• Si el agarre estrecho molesta las muñecas, usa una barra Z.\n\nMúsculos principales: biceps_brachii',NULL,'close-grip-barbell-curl.webp'),
(98,'Press de Banca con Agarre Cerrado','Close-Grip Bench Press','Una variación del press de banca con agarre estrecho que desplaza el énfasis hacia los tríceps.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco plano y agarra la barra con las manos a la anchura de los hombros.\n2. Baja la barra hasta el pecho inferior manteniendo los codos cerca de los costados.\n3. Vuelve a empujar hasta la extensión completa.\n4. Repite.\n\nConsejos técnicos:\n• Mantén los codos pegados para maximizar la activación de los tríceps.\n• Evita un agarre demasiado estrecho para prevenir tensión en las muñecas.\n\nMúsculos principales: triceps_brachii',NULL,'close-grip-bench-press.webp'),
(99,'Press de Banca con Mancuernas y Agarre Cerrado','Close-Grip Dumbbell Bench Press','Un press de banca con mancuernas sostenidas juntas para aumentar la participación de los tríceps.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco plano y sostén dos mancuernas juntas sobre el pecho.\n2. Bájalas hasta el pecho manteniendo los codos cerca.\n3. Empuja hacia arriba.\n4. Repite.\n\nConsejos técnicos:\n• Mantén las mancuernas presionadas entre sí durante todo el movimiento.\n• Mantén los codos pegados.\n\nMúsculos principales: triceps_brachii',NULL,'close-grip-db-bench-press.webp'),
(100,'Press de Banca con Barra Z y Agarre Cerrado','Close-Grip EZ-Bar Bench Press','Un press enfocado en los tríceps con barra Z y agarre estrecho para mayor comodidad en las muñecas.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco plano y agarra las curvas internas de la barra Z.\n2. Baja la barra hasta el pecho con los codos pegados.\n3. Empuja hacia arriba hasta la extensión completa.\n4. Repite.\n\nConsejos técnicos:\n• La barra Z reduce la incomodidad en las muñecas.\n• Mantén el movimiento controlado.\n\nMúsculos principales: triceps_brachii',NULL,'close-grip-ez-bar-bench-press.webp'),
(101,'Curl con Barra Z y Agarre Cerrado','Close-Grip EZ-Bar Curl','Un curl de bíceps con barra Z y manos juntas, que carga más la cabeza larga del bíceps.\n\nInstrucciones de ejecución:\n1. Sujeta una barra Z con las manos en las curvas internas, palmas arriba.\n2. Mantén los codos pegados al cuerpo.\n3. Sube la barra hasta los hombros contrayendo el bíceps.\n4. Baja con control hasta el estiramiento completo.\n5. Repite el número de repeticiones indicado.\n\nConsejos técnicos:\n• Mantén los codos pegados — no dejes que se vayan adelante.\n• Contrae fuerte arriba.\n• Evita balancear el torso para tomar impulso.\n\nMúsculos principales: biceps_brachii',NULL,'close-grip-ez-bar-curl.webp'),
(102,'Press de Banca Inclinado con Agarre Cerrado','Close-Grip Incline Bench Press','Un press de banca inclinado con agarre cerrado que trabaja los tríceps y el pecho superior.\n\nInstrucciones de ejecución:\n1. Ajusta el banco en inclinación. Agarra la barra con las manos a la anchura de los hombros o más juntas.\n2. Baja la barra hasta el pecho superior.\n3. Empuja hacia arriba.\n4. Repite.\n\nConsejos técnicos:\n• La inclinación aumenta el estiramiento de la cabeza larga de los tríceps.\n• Mantén los codos pegados para mantener el foco en los tríceps.\n\nMúsculos principales: triceps_brachii',NULL,'close-grip-incline-bench.webp'),
(103,'Jalón al Pecho con Agarre Cerrado','Close Grip Lat Pulldown','Una variante del jalón al pecho con agarre cerrado y paralelo que enfatiza la parte baja del dorsal y el bíceps.\n\nInstrucciones de ejecución:\n1. Siéntate en una máquina de jalón al pecho y asegura tus muslos bajo la almohadilla.\n2. Sujeta el agarre cerrado con las palmas enfrentadas.\n3. Tira de la barra hacia la parte superior del pecho.\n4. Contrae el dorsal en la parte baja.\n5. Vuelve con control y repite.\n\nConsejos técnicos:\n• Inclínate hacia atrás solo ligeramente, no en exceso.\n• Evita usar impulso para bajar la barra.\n• Lleva los codos hacia abajo y atrás, no solo las manos.\n\nMúsculos principales: latissimus_dorsi',NULL,'close-grip-lat-pulldown.webp'),
(104,'Dominadas con Agarre Cerrado','Close-Grip Pull-Ups','Una dominada con agarre prono estrecho que aumenta la activación de los bíceps y la parte interna de la espalda.\n\nInstrucciones de ejecución:\n1. Cuélgate de la barra de dominadas con las manos a la anchura de los hombros o más juntas, palmas mirando hacia afuera.\n2. Súbete hasta que la barbilla supere la barra.\n3. Baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• El agarre estrecho aumenta la participación de los bíceps.\n• Evita los impulsos para el desarrollo de fuerza.\n\nMúsculos principales: biceps_brachii, latissimus_dorsi',NULL,'close-grip-pull-ups.webp'),
(105,'Flexiones con Agarre Cerrado','Close Grip Push Ups','Una variante de flexión con las manos juntas que enfatiza el tríceps.\n\nInstrucciones de ejecución:\n1. Adopta una posición de flexión con las manos directamente bajo los hombros.\n2. Mantén los codos pegados a las costillas.\n3. Baja el pecho hacia el suelo.\n4. Empuja de vuelta a la posición inicial.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Lleva los codos hacia atrás, no hacia los lados.\n• Mantén el cuerpo rígido como una tabla durante todo el movimiento.\n• Baja despacio para mayor activación del tríceps.\n\nMúsculos principales: pectoralis_major, triceps_brachii',NULL,'close-grip-push-ups.webp'),
(106,'Prensa de piernas con postura cerrada','Close-Stance Leg Press','Una prensa de piernas con los pies juntos, que aumenta la flexión de rodilla y mantiene el énfasis en los cuádriceps con la espalda apoyada.\n\nInstrucciones de ejecución:\n1. Ajusta el asiento y el respaldo para que la zona lumbar permanezca apoyada durante toda la repetición.\n2. Coloca los pies juntos cerca del centro de la plataforma y alinea rodillas y puntas de los pies.\n3. Baja el carro flexionando rodillas y caderas mientras mantienes ambos pies planos.\n4. Empuja la plataforma con todo el pie y extiende las piernas sin golpear el bloqueo de las rodillas.\n5. Regresa bajo control y repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Usa solo la postura más cerrada que permita que las rodillas sigan cómodamente a los pies.\n• Mantén los talones abajo y evita que las rodillas se junten al descender.\n• No sacrifiques la posición de la pelvis para conseguir más profundidad.\n\nMúsculos principales: quadriceps',NULL,'close-stance-leg-press.webp'),
(107,'Cocoons','Cocoons','Un ejercicio abdominal dinámico que combina un encogimiento de rodillas con un crunch desde una posición extendida boca arriba.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con los brazos extendidos sobre la cabeza; manos y pies ligeramente elevados.\n2. Lleva las rodillas al pecho y balancea los brazos hacia adelante en un crunch simultáneamente.\n3. Intenta tocar las espinillas con las manos en el punto máximo.\n4. Extiende brazos y piernas de forma controlada sin tocar el suelo.\n5. Repite el movimiento durante las repeticiones indicadas.\n\nConsejos técnicos:\n• Las manos y los pies no tocan el suelo entre repeticiones.\n• Exhala con fuerza al llegar al punto máximo.\n\nMúsculos principales: rectus_abdominis',NULL,'cocoons.webp'),
(108,'Curl de Concentración','Concentration Curl','Un curl de aislamiento realizado sentado para la máxima contracción del bíceps.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con las piernas separadas y sujeta una mancuerna en una mano.\n2. Apoya el codo en la cara interna del muslo.\n3. Sube la mancuerna hacia el hombro.\n4. Baja con control.\n5. Repite en ambos lados.\n\nConsejos técnicos:\n• No balancees el torso para ayudarte a subir.\n• Gira ligeramente la muñeca hacia fuera para contraer más el bíceps.\n• Trabaja ambos brazos por igual, empezando por el más débil.\n\nMúsculos principales: biceps_brachii',NULL,'concentration-curl.webp'),
(109,'Sentadilla cosaca','Cossack Squat','Una sentadilla lateral de base amplia que hunde el cuerpo profundamente sobre una pierna flexionada mientras la otra permanece recta, entrenando fuerza unilateral, movilidad de cadera y flexibilidad de aductores.\n\nInstrucciones de ejecución:\n1. Ponte en una postura amplia con las puntas de los pies ligeramente hacia afuera.\n2. Desplaza el peso hacia un lado, flexiona esa rodilla y húndete en una sentadilla profunda.\n3. Mantén la pierna contraria recta, con el talón en el suelo y los dedos hacia arriba.\n4. Baja tanto como te permita tu movilidad, manteniendo el pecho erguido.\n5. Empuja con la pierna flexionada para volver al centro y repite hacia el otro lado.\n\nConsejos técnicos:\n• Mantén el talón de la pierna que trabaja apoyado: no ruedes hacia las puntas.\n• Apunta con los dedos de la pierna recta hacia arriba para mantener tensión en los aductores.\n• Sujeta un peso ligero frente al pecho como contrapeso si lo necesitas.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'cossack-squat.webp'),
(110,'Fondos de Cangrejo','Crab Dips','Un ejercicio de tríceps en el suelo desde la mesa invertida: con las manos detrás de las caderas y el tronco elevado, los codos se flexionan y estiran para subir y bajar el cuerpo.\n\nInstrucciones de ejecución:\n1. Siéntate con las rodillas flexionadas, los pies apoyados y las manos en el suelo detrás de ti, con los dedos hacia los talones.\n2. Empuja con manos y pies y eleva las caderas hasta que el tronco quede a la altura de las rodillas.\n3. Flexiona los codos hacia atrás para bajar las caderas hacia el suelo sin sentarte.\n4. Empuja de nuevo hasta estirar los brazos, manteniendo las caderas elevadas.\n5. Repite las veces indicadas y baja las caderas para terminar.\n\nConsejos técnicos:\n• Mantén los codos apuntando hacia atrás, sin abrirlos hacia los lados.\n• Sostén las caderas altas toda la serie; dejarlas caer convierte el ejercicio en un descanso.\n• Aleja más los pies para alargar la palanca y exigir más al tríceps.\n\nMúsculos principales: triceps_brachii',NULL,'crab-dips.webp'),
(111,'Crunch Cruzado','Cross-Body Crunch','Un crunch de oblicuos en el suelo que acerca el codo y la rodilla opuestos entre sí, trabajando los oblicuos y el recto abdominal juntos.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba en el suelo con las rodillas dobladas y las manos ligeramente detrás de las orejas.\n2. Contrae y rota llevando el codo derecho hacia la rodilla izquierda mientras la rodilla sube.\n3. Regresa a la posición inicial de forma controlada.\n4. Repite del otro lado, alternando en cada repetición.\n\nConsejos técnicos:\n• Gira desde la caja torácica, no desde los brazos; los codos siguen a los hombros.\n• La zona lumbar permanece en el suelo durante todo el ejercicio.\n\nMúsculos principales: obliques',NULL,'cross-body-crunch.webp'),
(112,'Curl Martillo Cruzado','Cross Body Hammer Curl','Un curl con agarre neutro que lleva la mancuerna cruzando el cuerpo hacia el hombro opuesto, enfatizando el braquial y los antebrazos.\n\nInstrucciones de ejecución:\n1. De pie, sujeta una mancuerna en cada mano con agarre neutro.\n2. Sube una mancuerna cruzando el cuerpo hacia el hombro opuesto.\n3. Mantén el codo fijo a tu costado.\n4. Baja de forma controlada y repite del otro lado.\n5. Continúa alternando el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén el codo pegado al costado durante todo el curl.\n• Evita balancear el torso para levantar el peso.\n• Baja con control en lugar de dejar caer la mancuerna.\n\nMúsculos principales: brachialis, brachioradialis',NULL,'cross-body-hammer-curl.webp'),
(113,'Crunches','Crunches','Un ejercicio abdominal básico enfocado en el recto abdominal.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con las rodillas dobladas y las manos detrás de la cabeza.\n2. Enrolla el tronco superior hacia las rodillas levantando los omóplatos del suelo.\n3. Aprieta el abdomen en la posición superior.\n4. Baja con control.\n5. Repite.\n\nConsejos técnicos:\n• No tires del cuello con las manos al subir.\n• Exhala al subir y mantén la zona lumbar pegada al suelo.\n• Piensa en acercar las costillas a la pelvis, no en sentarte.\n\nMúsculos principales: rectus_abdominis',NULL,'crunches.webp'),
(114,'Press de Banca con Mancuernas','Dumbbell Bench Press','Un ejercicio compuesto de pecho con mancuernas que permite mayor rango de movimiento que el press de banca con barra.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco plano sosteniendo una mancuerna en cada mano a la altura del pecho.\n2. Empuja las mancuernas hacia arriba hasta extender completamente los brazos.\n3. Bájalas lentamente hasta la posición inicial.\n4. Repite.\n\nConsejos técnicos:\n• Mantén las muñecas neutras durante todo el ejercicio.\n• Aprieta el pecho en la parte superior del movimiento.\n\nMúsculos principales: pectoralis_major',NULL,'db-bench-press.webp'),
(115,'Aperturas con Mancuernas','Dumbbell Fly','Un ejercicio de aislamiento que estira y contrae el pectoral a través de un amplio arco de movimiento.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco con las mancuernas sobre el pecho y las palmas mirándose entre sí.\n2. Con una ligera flexión de codos, baja las mancuernas hacia los lados.\n3. Regresa a la posición inicial apretando el pecho.\n4. Repite.\n\nConsejos técnicos:\n• Mantén una flexión constante en los codos durante todo el ejercicio.\n• No bajes demasiado las mancuernas.\n\nMúsculos principales: pectoralis_major',NULL,'db-fly.webp'),
(116,'Peso Muerto Kickstand con Mancuerna','Dumbbell Kickstand Deadlift','Un movimiento de bisagra de cadera en postura escalonada con una mancuerna que carga la pierna delantera mientras el pie trasero ofrece apoyo ligero.\n\nInstrucciones de ejecución:\n1. Coloca un pie detrás de modo que solo los dedos rocen el suelo.\n2. Sostén una mancuerna en la mano del lado del pie trasero.\n3. Bisagra en la cadera bajando la mancuerna hacia la espinilla con la espalda recta.\n4. Mantén la mayor parte del peso en el pie delantero.\n5. Empuja con el talón delantero para volver a la posición inicial. Completa todas las repeticiones antes de cambiar de lado.\n\nConsejos técnicos:\n• Mantén la mancuerna cerca de la pierna durante el descenso.\n• Para cuando notes el estiramiento en el isquiotibial de la pierna delantera.\n• Completa todas las repeticiones en un lado antes de cambiar.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'db-kickstand-deadlift.webp'),
(117,'Zancada con Mancuernas','Dumbbell Lunge','Un ejercicio unilateral de tren inferior con mancuernas que trabaja los cuádriceps y los glúteos mediante un paso adelante.\n\nInstrucciones de ejecución:\n1. De pie, sujeta mancuernas a los costados.\n2. Da un paso adelante con un pie y baja la rodilla trasera hacia el suelo.\n3. Empuja con el pie delantero para volver.\n4. Alterna las piernas.\n5. Repite.\n\nConsejos técnicos:\n• Mantén el torso erguido.\n• La rodilla delantera debe seguir la dirección de los pies.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'db-lunge.webp'),
(118,'Pullover con Mancuerna','Dumbbell Pullover','Un movimiento compuesto que trabaja los dorsales y el pecho con un movimiento de estiramiento.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco plano con una mancuerna sobre el pecho y los brazos extendidos.\n2. Baja la mancuerna detrás de la cabeza en arco, manteniendo una ligera flexión de codos.\n3. Estira hasta sentir tensión en los dorsales y el pecho.\n4. Tira de la mancuerna de vuelta a la posición inicial.\n5. Repite.\n\nConsejos técnicos:\n• Baja la mancuerna solo hasta donde el hombro lo permita.\n• Evita arquear la zona lumbar en la fase de estiramiento.\n• Mantén la flexión de los codos constante durante todo el arco.\n\nMúsculos principales: latissimus_dorsi, pectoralis_major',NULL,'db-pullover.webp'),
(119,'Curl Inverso con Mancuernas','Dumbbell Reverse Curl','Una variación del curl con agarre prono que trabaja el braquial y los extensores del antebrazo.\n\nInstrucciones de ejecución:\n1. Sujeta las mancuernas con agarre prono a los costados.\n2. Súbelas hasta la altura de los hombros.\n3. Baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• Mantén las muñecas neutras durante todo el ejercicio.\n• El movimiento controlado es clave.\n\nMúsculos principales: brachialis, forearm_extensors',NULL,'db-reverse-curl.webp'),
(120,'Curl de Muñeca Inverso con Mancuerna','Dumbbell Reverse Wrist Curl','Un curl de muñeca con mancuerna y palma hacia abajo, que entrena los extensores del antebrazo.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con el antebrazo sobre el muslo, palma hacia abajo.\n2. Sujeta una mancuerna con la muñeca fuera de la rodilla.\n3. Deja caer la muñeca, bajando la mancuerna.\n4. Levanta el dorso de la mano hacia el techo extendiendo la muñeca.\n5. Baja con control. Repeticiones por lado.\n\nConsejos técnicos:\n• Usa una carga mucho más ligera que en el curl de muñeca normal.\n• Mueve solo la muñeca.\n• Contrae la parte posterior del antebrazo arriba.\n\nMúsculos principales: forearm_extensors',NULL,'db-reverse-wrist-curl.webp'),
(121,'Encogimiento de Hombros con Mancuernas','Dumbbell Shrug','Un encogimiento de hombros con mancuernas que trabaja el trapecio superior para dar volumen al cuello y la espalda alta.\n\nInstrucciones de ejecución:\n1. De pie, sujeta mancuernas a los costados.\n2. Encoge los hombros hacia arriba lo más alto posible.\n3. Mantén brevemente y luego baja.\n4. Repite.\n\nConsejos técnicos:\n• No hagas círculos con los hombros.\n• Concéntrate en apretar el trapecio en la posición superior.\n\nMúsculos principales: trapezius',NULL,'db-shrug.webp'),
(122,'Skull Crusher con Mancuernas','Dumbbell Skull Crusher','Una extensión de tríceps tumbado con mancuernas que permite el movimiento independiente de cada brazo.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco plano sosteniendo mancuernas sobre el pecho.\n2. Baja las mancuernas hacia los lados de la cabeza.\n3. Extiende los brazos hacia arriba.\n4. Repite.\n\nConsejos técnicos:\n• Mantén los codos apuntando hacia el techo.\n• Usa un tempo controlado.\n\nMúsculos principales: triceps_brachii',NULL,'db-skull-crusher.webp'),
(123,'Sentadilla Somersault con Mancuerna','Dumbbell Somersault Squat','Una sentadilla unilateral con alcance y mancuerna, que añade rotación y movilidad de hombro al patrón de sentadilla.\n\nInstrucciones de ejecución:\n1. Pies a la anchura de los hombros, sostén una mancuerna en una mano a la altura del hombro.\n2. Baja en sentadilla mientras llevas la mancuerna al frente y cruzando el cuerpo.\n3. Alcanza el punto bajo con la mancuerna extendida pasando la rodilla opuesta.\n4. Empuja con los talones para subir, regresando la mancuerna al hombro.\n5. Repeticiones por lado, luego cambia.\n\nConsejos técnicos:\n• Mueve lento durante la rotación para mantener la columna controlada.\n• Usa una mancuerna ligera — la palanca larga exige al hombro.\n• Empuja las rodillas afuera para mantener la trayectoria estable.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'db-somersault-squat.webp'),
(124,'Sentadilla con Mancuernas','Dumbbell Squat','Un patrón de sentadilla cargado con una mancuerna en cada mano, accesible sin barra.\n\nInstrucciones de ejecución:\n1. Pies a la anchura de los hombros, una mancuerna en cada mano a los lados.\n2. Activa el core y mantén el pecho arriba.\n3. Baja en sentadilla flexionando caderas y rodillas.\n4. Desciende hasta que los muslos queden paralelos o más abajo.\n5. Empuja con los talones para volver a subir.\n\nConsejos técnicos:\n• Mantén el pecho arriba y la espalda recta.\n• Empuja las rodillas en línea con los dedos del pie.\n• Usa straps si el agarre se convierte en el factor limitante.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'db-squat.webp'),
(125,'Sentadilla Sumo con Mancuernas','Dumbbell Sumo Squat','Una sentadilla de pies anchos con mancuernas sujetadas a los lados, que enfatiza la cara interna de los muslos y los glúteos.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies más anchos que los hombros y las puntas giradas hacia afuera unos 30 grados.\n2. Sujeta una mancuerna en cada mano a los lados.\n3. Activa el core y mantén el pecho alto.\n4. Flexiona caderas y rodillas para bajar recto en una sentadilla profunda.\n5. Empuja con los talones para volver a ponerte de pie.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Alinea las rodillas con las puntas de los pies; no dejes que se vayan hacia dentro.\n• Mantén el torso tan erguido como te permita la movilidad de cadera.\n• Elige mancuernas más ligeras que en una sentadilla normal; el agarre es el límite.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'db-sumo-squat.webp'),
(126,'Press Svend con Mancuernas','Dumbbell Svend Press','Un ejercicio de pecho de pie presionando dos mancuernas entre sí frente al cuerpo, aísla el pecho interno.\n\nInstrucciones de ejecución:\n1. De pie, junta dos mancuernas horizontalmente a la altura del pecho.\n2. Mantén la presión hacia adentro sobre las mancuernas todo el tiempo.\n3. Empuja las mancuernas al frente hasta extender los brazos.\n4. Tíralas de regreso al pecho con control.\n5. Repite el número de repeticiones indicado.\n\nConsejos técnicos:\n• La presión entre las mancuernas hace el ejercicio — no dejes que se separen.\n• Usa carga ligera — el objetivo es activar el pecho, no levantar mucho.\n• Mantén los codos ligeramente flexionados en el lockout.\n\nMúsculos principales: pectoralis_major',NULL,'db-svend-press.webp'),
(127,'Dead Bug','Dead Bug','Un ejercicio de core en decúbito supino que coordina la extensión de extremidades opuestas para entrenar la estabilidad del core profundo.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con los brazos extendidos hacia el techo y las rodillas a 90 grados.\n2. Baja el brazo derecho y la pierna izquierda hacia el suelo manteniendo la zona lumbar presionada contra el suelo.\n3. Regresa a la posición inicial.\n4. Repite del otro lado.\n5. Alterna.\n\nConsejos técnicos:\n• Presiona la zona lumbar contra el suelo en todo momento.\n• Muévete despacio.\n\nMúsculos principales: rectus_abdominis, transverse_abdominis',NULL,'dead-bug.webp'),
(128,'Press de Banca Declinado con Barra','Decline Barbell Bench Press','Un press compuesto con barra en banco declinado que enfatiza el pecho inferior.\n\nInstrucciones de ejecución:\n1. Ajusta el banco en declinación. Túmbate y asegura los pies.\n2. Agarra la barra ligeramente más ancha que la anchura de los hombros.\n3. Baja la barra hasta el pecho inferior y luego empuja hacia arriba.\n4. Repite.\n\nConsejos técnicos:\n• Controla el descenso.\n• Mantén los codos a unos 45 grados respecto al torso.\n\nMúsculos principales: pectoralis_major',NULL,'decline-bench-press-barbell.webp'),
(129,'Press de Banca Declinado con Barra Z','Decline EZ-Bar Bench Press','Un press declinado con barra Z y agarre cómodo para las muñecas que trabaja el pecho inferior.\n\nInstrucciones de ejecución:\n1. Ajusta el banco en declinación. Asegura los pies y agarra la barra Z.\n2. Baja la barra hasta el pecho inferior.\n3. Empuja hacia arriba de forma explosiva.\n4. Repite.\n\nConsejos técnicos:\n• El agarre angulado reduce la tensión en las muñecas.\n• Mantén el core contraído.\n\nMúsculos principales: pectoralis_major',NULL,'decline-bench-press-ez-bar.webp'),
(130,'Press de Banca Declinado','Decline Bench Press','Un press de pecho compuesto en banco declinado que trabaja el pectoral inferior.\n\nInstrucciones de ejecución:\n1. Ajusta el banco en declinación. Túmbate y asegura los pies.\n2. Descuelga la barra y bájala hasta el pecho inferior.\n3. Vuelve a empujar hasta la posición inicial.\n4. Repite.\n\nConsejos técnicos:\n• Mantén la espalda plana sobre el banco.\n• Usa un ayudante cuando trabajes con cargas más pesadas.\n\nMúsculos principales: pectoralis_major',NULL,'decline-bench-press.webp'),
(131,'Crunch Declinado','Decline Crunch','Un crunch realizado en banco declinado, aumentando el rango de movimiento y la resistencia sobre los abdominales.\n\nInstrucciones de ejecución:\n1. Asegura los pies en la parte superior del banco declinado.\n2. Recuéstate con las manos cruzadas sobre el pecho o detrás de la cabeza.\n3. Sube contrayendo la columna hacia las rodillas.\n4. Aprieta el abdomen en la posición superior.\n5. Baja de forma controlada y repite.\n\nConsejos técnicos:\n• Enrolla la columna en lugar de tirar del cuello.\n• Exhala al subir y aprieta los abdominales arriba.\n• Baja despacio en lugar de dejarte caer sobre el banco.\n\nMúsculos principales: rectus_abdominis',NULL,'decline-crunch.webp'),
(132,'Aperturas con Mancuernas en Banco Declinado','Decline Dumbbell Fly','Un movimiento de apertura en banco declinado para enfatizar el pecho inferior.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco declinado sosteniendo mancuernas sobre el pecho.\n2. Con una ligera flexión de codos, baja las mancuernas ampliamente hacia los lados.\n3. Aprieta el pecho para subirlas de nuevo.\n4. Repite.\n\nConsejos técnicos:\n• No extiendas completamente los codos.\n• Concéntrate en el estiramiento en la posición inferior.\n\nMúsculos principales: pectoralis_major',NULL,'decline-db-fly.webp'),
(133,'Flexión Declinada','Decline Push-Up','Una flexión con los pies elevados para aumentar la activación del pecho superior y los hombros.\n\nInstrucciones de ejecución:\n1. Coloca los pies en una superficie elevada y las manos en el suelo.\n2. Baja el pecho hacia el suelo de forma controlada.\n3. Vuelve a empujar hasta la posición inicial.\n4. Repite.\n\nConsejos técnicos:\n• Mantén el cuerpo en línea recta.\n• Cuanto mayor sea la elevación, más se trabaja el pecho superior.\n\nMúsculos principales: pectoralis_major',NULL,'decline-push-up.webp'),
(134,'Peso Muerto en Déficit','Deficit Deadlift','Un peso muerto ejecutado sobre una plataforma baja que amplía el recorrido y exige más a isquiotibiales y glúteos.\n\nInstrucciones de ejecución:\n1. De pie sobre una plataforma pequeña con una barra cargada sobre el medio del pie.\n2. Bisagra hacia abajo y agarra la barra justo por fuera de las rodillas.\n3. Empuja con las piernas para ponerte erguido manteniendo la barra cerca.\n4. Bloquea caderas y rodillas en la parte superior.\n5. Baja de forma controlada y repite.\n\nConsejos técnicos:\n• Mantén la columna neutra en todo el recorrido ampliado.\n• Usa menos peso del que mueves en tu peso muerto habitual.\n• Domina el peso muerto convencional antes de probar esta variante.\n\nMúsculos principales: erector_spinae, gluteus_maximus, hamstrings',NULL,'deficit-deadlift.webp'),
(135,'Flexiones en Déficit','Deficit Push Ups','Una flexión de brazos con las manos sobre soportes elevados, que aumenta el rango de movimiento y el estiramiento del pectoral.\n\nInstrucciones de ejecución:\n1. Coloca las manos en dos superficies elevadas como parallettes o bloques.\n2. Adopta la posición de plancha con las manos bajo los hombros.\n3. Baja el pecho por debajo del nivel de las manos.\n4. Empuja hacia arriba para extender los brazos.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Baja solo hasta donde tus hombros toleren el estiramiento.\n• Mantén el cuerpo en línea recta, sin hundir la cadera.\n• Progresa desde las flexiones normales antes de añadir déficit.\n\nMúsculos principales: pectoralis_major',NULL,'deficit-push-ups.webp'),
(136,'Flexiones en Diamante','Diamond Push Ups','Una flexión con las manos juntas formando un diamante con pulgares e índices, trasladando el énfasis a los tríceps.\n\nInstrucciones de ejecución:\n1. Adopta la posición de flexión con las manos juntas formando un diamante.\n2. Mantén los codos pegados a los costados.\n3. Baja el pecho hacia las manos.\n4. Empuja hacia arriba para extender los brazos.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Lleva los codos hacia atrás pegados a los costados, sin abrirlos.\n• Mantén el cuerpo en una línea recta y rígida de la cabeza a los talones.\n• Baja con control hasta que el pecho llegue a las manos.\n\nMúsculos principales: pectoralis_major, triceps_brachii',NULL,'diamond-push-ups.webp'),
(137,'Fondos para Pecho','Chest Dips','Un ejercicio compuesto de peso corporal que trabaja el pecho inferior y los tríceps.\n\nInstrucciones de ejecución:\n1. Agarra las barras paralelas y súbete a la posición superior con los brazos extendidos.\n2. Inclina el torso ligeramente hacia adelante.\n3. Baja el cuerpo doblando los codos hasta que los hombros queden por debajo de los codos.\n4. Vuelve a empujar hasta la posición inicial.\n5. Repite.\n\nConsejos técnicos:\n• Acentúa la inclinación del torso si quieres más trabajo de pecho.\n• Detén la bajada si notas molestia en el hombro.\n• Evita encoger los hombros hacia las orejas al empujar.\n\nMúsculos principales: pectoralis_major, triceps_brachii',NULL,'dips.webp'),
(138,'Elevación de Pantorrilla a la Burra','Donkey Calf Raise','Una elevación de pantorrilla inclinada que maximiza el estiramiento al flexionar las caderas.\n\nInstrucciones de ejecución:\n1. Flexiona las caderas y apoya los antebrazos sobre un banco.\n2. Coloca las puntas de los pies en una plataforma elevada, talones al aire.\n3. Baja los talones por debajo de la plataforma para un estiramiento completo.\n4. Empuja arriba sobre las puntas tanto como puedas, contrayendo las pantorrillas.\n5. Baja con control hasta el estiramiento profundo.\n\nConsejos técnicos:\n• Pausa brevemente arriba para maximizar la contracción.\n• Usa una excéntrica lenta para el estiramiento completo.\n• Añade un compañero o peso sobre la zona lumbar para más resistencia.\n\nMúsculos principales: gastrocnemius',NULL,'donkey-calf-raise.webp'),
(139,'Peso Muerto Kickstand con Doble Mancuerna','Double Dumbbell Kickstand Deadlift','Un movimiento de bisagra de cadera en postura escalonada con dos mancuernas que carga principalmente la pierna delantera con el pie trasero como apoyo de equilibrio.\n\nInstrucciones de ejecución:\n1. Coloca un pie detrás de modo que solo los dedos toquen el suelo.\n2. Sostén una mancuerna en cada mano a la altura de la cadera.\n3. Bisagra en la cadera bajando ambas mancuernas hacia la espinilla con la espalda recta.\n4. Mantén la mayor parte del peso en el pie delantero.\n5. Empuja con el talón delantero para volver a posición inicial. Cambia de lado.\n\nConsejos técnicos:\n• Mantén las mancuernas cerca de las piernas.\n• Para al notar el estiramiento en el isquiotibial de la pierna delantera.\n• Completa todas las repeticiones en un lado antes de cambiar.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'double-db-kickstand-deadlift.webp'),
(140,'Curl de Bíceps con Dos Pesas Rusas','Double Kettlebell Bicep Curl','Un curl de bíceps de pie con una pesa rusa en cada mano, sujeta por el asa. La masa descentrada en la parte inferior de la pesa añade un ligero reto de agarre y estabilidad.\n\nInstrucciones de ejecución:\n1. Ponte de pie sujetando una pesa rusa en cada mano por el asa, con las palmas mirando hacia adelante.\n2. Mantén los codos pegados a los costados y las pesas colgando a lo largo de los brazos.\n3. Sube ambas pesas rusas hacia los hombros flexionando los codos.\n4. Aprieta los bíceps en la parte superior, luego baja de forma controlada hasta la posición inicial.\n5. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• No dejes que las pesas oscilen — controla la fase excéntrica.\n• Los codos permanecen pegados a los costados; sin flexión de hombros.\n• Agarra con fuerza durante todo el movimiento; la pesa tiende a extender la muñeca.\n\nMúsculos principales: biceps_brachii',NULL,'double-kettlebell-bicep-curl.webp'),
(141,'Clean and press con doble kettlebell','Double Kettlebell Clean and Press','Un ejercicio de fuerza de cuerpo completo que sube dos kettlebells desde el suelo hasta la posición de rack en los hombros y luego las presiona por encima de la cabeza hasta la extensión completa en una secuencia continua.\n\nInstrucciones de ejecución:\n1. Colócate con dos kettlebells en el suelo entre los pies, separados a la anchura de las caderas, y flexiona las caderas para agarrar un asa con cada mano.\n2. Empuja con las piernas y extiende las caderas de forma explosiva para tirar de ambas kettlebells hacia arriba; luego rota los codos por debajo y recibe las pesas en la posición de rack, al frente de los hombros.\n3. Activa el core y presiona ambas kettlebells por encima de la cabeza hasta bloquear los brazos por completo.\n4. Baja las kettlebells de vuelta a la posición de rack y después al suelo de forma controlada.\n5. Repite las repeticiones deseadas.\n\nConsejos técnicos:\n• Mantén las kettlebells cerca del cuerpo durante el clean y pasa las manos alrededor y a través de las asas al recibirlas, para que las pesas se asienten sobre los antebrazos en lugar de golpearlos.\n• Inicia la presión con un breve impulso de piernas y caderas (dip-drive) y termina con los hombros; mantén el core firme para no inclinarte hacia atrás bajo la carga.\n• En el bloqueo mantén las muñecas rectas y las kettlebells alineadas sobre los codos y los hombros, con la cabeza en posición neutra entre las pesas.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'double-kettlebell-clean-and-press.webp'),
(142,'Clean con Dos Pesas Rusas','Double Kettlebell Clean','Un jalón de cadera explosivo que lleva dos pesas rusas simultáneamente hasta los hombros en posición de rack, base para los press y jerk con doble pesa rusa.\n\nInstrucciones de ejecución:\n1. Ponte de pie con dos pesas rusas en el suelo entre tus pies, con las asas ligeramente giradas hacia adentro.\n2. Inclínate desde las caderas, agarra las asas y envía las pesas rusas hacia atrás entre las piernas.\n3. Extiende las caderas de forma explosiva para impulsar las pesas rusas hacia arriba a lo largo del cuerpo.\n4. Cuando lleguen a la altura del pecho, mete las manos por las asas para recibirlas en la posición de rack sobre los hombros.\n5. Baja de vuelta a la posición colgante inclinándote desde las caderas y guiando las pesas entre las piernas.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Mete las manos por las asas — no dejes que las pesas se vuelquen y golpeen las muñecas.\n• El impulso viene de las caderas; los brazos solo guían el trayecto.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'double-kettlebell-clean.webp'),
(143,'Dead Clean con Dos Pesas Rusas','Double Kettlebell Dead Clean','Un clean con dos pesas rusas desde el suelo que desarrolla potencia de cadera llevando ambas pesas a la posición de rack.\n\nInstrucciones de ejecución:\n1. Coloca dos pesas rusas en el suelo entre tus pies.\n2. Inclínate y agarra ambas asas.\n3. Empuja de forma explosiva con las piernas y las caderas.\n4. Tira de las pesas rusas hacia arriba y gíralas hasta la posición de rack.\n5. Bájalas de vuelta al suelo y repite.\n\nConsejos técnicos:\n• Genera la fuerza con las caderas, no con los brazos.\n• Mantén las pesas cerca del cuerpo durante la subida.\n• Recibe en el rack con suavidad, sin golpear los antebrazos.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'double-kettlebell-dead-clean.webp'),
(144,'Dead Split Snatch con Dos Pesas Rusas','Double Kettlebell Dead Split Snatch','Un snatch con dos pesas rusas desde el suelo que se recibe en posición de tijera con los brazos bloqueados arriba.\n\nInstrucciones de ejecución:\n1. Coloca dos pesas rusas en el suelo entre tus pies.\n2. Inclínate y agarra ambas asas con firmeza.\n3. Tira de las pesas rusas por encima de la cabeza de forma explosiva en un solo movimiento.\n4. Cae en postura dividida para recibirlas con los brazos bloqueados.\n5. Recupera la posición juntando los pies.\n\nConsejos técnicos:\n• Practica la tijera sin peso hasta dominar la recepción.\n• Recibe con los codos completamente bloqueados.\n• Mantén el torso erguido al entrar en la tijera.\n\nMúsculos principales: anterior_deltoid, gluteus_maximus',NULL,'double-kettlebell-dead-split-snatch.webp'),
(145,'Jerk con Dos Pesas Rusas','Double Kettlebell Jerk','Un levantamiento por encima de la cabeza que utiliza un doble impulso de piernas para elevar dos pesas rusas desde el rack hasta el bloqueo, el movimiento emblema del deporte de pesas rusas.\n\nInstrucciones de ejecución:\n1. Comienza con dos pesas rusas en rack sobre los hombros, con los codos apoyados sobre las caderas.\n2. Realiza una pequeña flexión de rodillas y luego extiende las piernas de forma explosiva para impulsar las pesas hacia arriba.\n3. Cuando suban, realiza una segunda flexión de rodillas por debajo de ellas.\n4. Recibe las pesas rusas por encima de la cabeza con los brazos bloqueados y ponte completamente de pie.\n5. Bájalas de vuelta al rack de forma controlada y repite.\n\nConsejos técnicos:\n• El jerk tiene dos impulsos, no uno — el segundo impulso es el que te permite bloquear con los brazos relajados.\n• Respira en cada repetición; el hold es una habilidad aparte.\n\nMúsculos principales: anterior_deltoid, quadriceps',NULL,'double-kettlebell-jerk.webp'),
(146,'Press por Encima de la Cabeza con Dos Pesas Rusas','Double Kettlebell Overhead Press','Un press vertical con dos pesas rusas desde la posición de rack que desarrolla hombros y tríceps con gran exigencia del core.\n\nInstrucciones de ejecución:\n1. Lleva dos pesas rusas al rack sobre los hombros.\n2. Ponte de pie con los pies separados al ancho de las caderas.\n3. Empuja ambas pesas rusas directamente hacia arriba.\n4. Bloquea los brazos en la parte superior.\n5. Baja de vuelta a la posición de rack y repite.\n\nConsejos técnicos:\n• Aprieta el abdomen para evitar arquear la zona lumbar.\n• Adelanta ligeramente la cabeza cuando las pesas pasen la frente.\n• Baja al rack con control entre repeticiones.\n\nMúsculos principales: anterior_deltoid, triceps_brachii',NULL,'double-kettlebell-overhead-press.webp'),
(147,'Push Press con Dos Pesas Rusas','Double Kettlebell Push Press','Un push press con dos pesas rusas en rack. El impulso de piernas (un solo descenso) permite lanzar más carga por encima de la cabeza que en un press estricto — el nivel intermedio entre el press militar estricto y el jerk.\n\nInstrucciones de ejecución:\n1. Ponte de pie con dos pesas rusas en rack sobre los hombros, codos hacia abajo y pegados.\n2. Pies al ancho de los hombros, core contraído.\n3. Flexiona ligeramente las rodillas manteniendo el torso vertical.\n4. Extiende las piernas de forma explosiva y empuja ambas pesas por encima de la cabeza en un solo movimiento.\n5. Bloquea los brazos con las pesas sobre el punto medio del pie.\n6. Baja de vuelta al rack de forma controlada.\n7. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Solo UN descenso — si vuelves a doblar las rodillas bajo las pesas, eso es un jerk.\n• El impulso viene de las piernas; los brazos terminan el movimiento.\n• El torso permanece vertical en todo momento; sin inclinación.\n\nMúsculos principales: anterior_deltoid',NULL,'double-kettlebell-push-press.webp'),
(148,'Remo con Dos Pesas Rusas para Deltoides Posterior','Double Kettlebell Rear Delt Row','Un remo inclinado con una pesa rusa en cada mano y los codos abiertos hacia fuera, lejos del torso, que traslada el trabajo de los dorsales a los deltoides posteriores y la parte alta de la espalda.\n\nInstrucciones de ejecución:\n1. Coloca una pesa rusa justo por fuera de cada pie, con los pies separados a la anchura de las caderas.\n2. Inclínate desde las caderas con la espalda plana hasta que el torso quede casi paralelo al suelo, con las rodillas ligeramente flexionadas.\n3. Sujeta ambas asas con agarre prono y deja los brazos colgando rectos desde los hombros.\n4. Rema ambas pesas llevando los codos hacia los lados, alejándolos de las costillas en lugar de deslizarlos hacia atrás junto a ellas.\n5. Detente cuando los brazos queden más o menos en línea con los hombros y aprieta los omóplatos.\n6. Baja las pesas de forma controlada hasta que los brazos vuelvan a colgar rectos y repite las repeticiones deseadas.\n\nConsejos técnicos:\n• El codo abierto es toda la clave. Si se pega a las costillas estarás haciendo un remo con dos pesas rusas normal y trabajando los dorsales en lugar de los deltoides posteriores.\n• Usa menos carga que en un remo convencional. El codo abierto es una palanca larga y el deltoides posterior es un motor mucho más pequeño que el dorsal.\n• Mantén constante el ángulo de la inclinación. Enderezarte al tirar traslada el trabajo al trapecio y a la zona lumbar y acorta justo el rango en el que trabaja el deltoides posterior.\n\nMúsculos principales: posterior_deltoid, rhomboids',NULL,'double-kettlebell-rear-delt-row.webp'),
(149,'Remo con Dos Pesas Rusas','Double Kettlebell Row','Un remo inclinado con dos pesas rusas que desarrolla dorsales y romboides con fuerte trabajo postural.\n\nInstrucciones de ejecución:\n1. Sujeta una pesa rusa en cada mano e inclínate hacia adelante desde las caderas.\n2. Deja los brazos colgando rectos desde los hombros.\n3. Rema ambas pesas rusas hacia las caderas llevando los codos hacia atrás.\n4. Aprieta los omóplatos en la parte superior.\n5. Baja de forma controlada y repite.\n\nConsejos técnicos:\n• No redondees la zona lumbar al mantener la inclinación.\n• Evita los tirones y rema con un movimiento fluido.\n• Si la fatiga rompe tu postura, termina la serie.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'double-kettlebell-row.webp'),
(150,'Split Jerk con Dos Pesas Rusas','Double Kettlebell Split Jerk','Un jerk con dos pesas rusas que combina un impulso de piernas con una recepción en tijera bajo la carga.\n\nInstrucciones de ejecución:\n1. Lleva dos pesas rusas al rack sobre los hombros.\n2. Flexiona ligeramente las rodillas.\n3. Impulsa las pesas rusas por encima de la cabeza de forma explosiva.\n4. Separa las piernas para recibirlas con los brazos bloqueados.\n5. Recupera la posición juntando los pies.\n\nConsejos técnicos:\n• Haz el dip corto y vertical, sin inclinar el torso.\n• Genera el empuje con las piernas, no con los hombros.\n• Bloquea los codos antes de juntar los pies.\n\nMúsculos principales: anterior_deltoid, quadriceps',NULL,'double-kettlebell-split-jerk.webp'),
(151,'Swing Snatch con Dos Pesas Rusas','Double Kettlebell Swing Snatch','Un snatch con dos pesas rusas iniciado con un swing entre las piernas y finalizado con ambas pesas bloqueadas arriba.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies al ancho de los hombros sujetando dos pesas rusas.\n2. Inclínate desde las caderas para balancear las pesas entre las piernas.\n3. Extiende las caderas de forma explosiva para balancear las pesas hacia arriba.\n4. Empuja hacia arriba para recibir ambas pesas rusas por encima de la cabeza con los brazos bloqueados.\n5. Baja de forma controlada y repite.\n\nConsejos técnicos:\n• Genera la potencia con un golpe seco de cadera.\n• Mantén la espalda plana cuando las pesas pasan entre las piernas.\n• Suaviza la recepción arriba para que las pesas no golpeen tus antebrazos.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'double-kettlebell-swing-snatch.webp'),
(152,'Rodilla al Pecho en Perro Boca Abajo','Downward Dog Knee Tuck','Un ejercicio dinámico de core sostenido en perro boca abajo: las caderas se mantienen altas mientras una rodilla se lleva bajo el pecho y vuelve al inicio, alternando lados. Los hombros sostienen toda la serie, de modo que el tronco trabaja sin la posición baja de cadera de una plancha.\n\nInstrucciones de ejecución:\n1. Colócate en perro boca abajo con las manos a la anchura de los hombros y las caderas altas.\n2. Empuja el suelo y aprieta el tronco para que la zona lumbar siga larga.\n3. Lleva una rodilla hacia el pecho, redondeando ligeramente la espalda alta al entrar.\n4. Extiende la pierna de vuelta a la posición inicial de forma controlada.\n5. Repite con la otra pierna y sigue alternando las veces indicadas.\n\nConsejos técnicos:\n• Mantén las caderas altas; si caen, esto se convierte en un escalador.\n• Lleva la rodilla con el abdomen en lugar de impulsarte con el pie de apoyo.\n• Aleja los hombros de las orejas para que el tronco no se hunda entre los brazos.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'downward-dog-knee-tuck.webp'),
(153,'Pedaleo en Perro Boca Abajo','Downward Dog Pedal','Un calentamiento dentro del perro boca abajo: las rodillas se flexionan alternando, de modo que cada talón presiona hacia el suelo por turnos y la pantorrilla y el tobillo reciben un estiramiento en movimiento en lugar de un mantenimiento estático.\n\nInstrucciones de ejecución:\n1. Colócate en perro boca abajo con las manos a la anchura de los hombros y las caderas altas.\n2. Flexiona una rodilla y deja que ese talón se eleve mientras el talón contrario presiona hacia el suelo.\n3. Cambia de lado con fluidez, como pedaleando, manteniendo las caderas altas todo el tiempo.\n4. Presiona las manos por igual para que los hombros se mantengan estables.\n5. Sigue alternando las veces o el tiempo indicados.\n\nConsejos técnicos:\n• Mantén las caderas altas; el objetivo son las pantorrillas, no una flexión más profunda.\n• Presiona toda la mano contra el suelo para que las muñecas no carguen con todo.\n• Muévete lo bastante despacio como para sentir cada lado en lugar de rebotar.\n\nMúsculos principales: gastrocnemius, soleus',NULL,'downward-dog-pedal.webp'),
(154,'Rodilla al Codo desde Perro de Tres Patas','Downward Dog to Knee Drive','Desde el perro de tres patas, la pierna elevada se pliega hacia delante para llevar la rodilla hacia el codo o la nariz y vuelve a extenderse. Los hombros sostienen la posición y el tronco hace el plegado, un lado cada vez.\n\nInstrucciones de ejecución:\n1. Colócate en perro boca abajo y eleva una pierna por detrás a perro de tres patas.\n2. Presiona ambas manos contra el suelo y desplaza el peso ligeramente hacia delante.\n3. Redondea la espalda alta y lleva esa rodilla hacia el codo o la nariz.\n4. Extiende la pierna de vuelta arriba de forma controlada.\n5. Termina las repeticiones de ese lado y cambia.\n\nConsejos técnicos:\n• Deja que la espalda alta se redondee al entrar la rodilla; con la espalda plana la rodilla se queda corta.\n• Mantén los hombros sobre las muñecas al desplazarte en lugar de pasarte por delante.\n• Eleva la pierna solo hasta donde las caderas sigan niveladas al salir.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'downward-dog-to-knee-drive.webp'),
(155,'Perro Boca Abajo a Zancada Baja','Downward Dog to Low Lunge','El paso al frente clásico: desde el perro boca abajo un pie viaja entre las manos hasta una zancada baja y regresa. Abre el flexor de la cadera de la pierna trasera y ensaya la transición que aparece en toda práctica de flujo.\n\nInstrucciones de ejecución:\n1. Empieza en perro boca abajo con las manos a la anchura de los hombros.\n2. Desplaza el peso hacia delante y lleva un pie entre las manos.\n3. Baja la rodilla trasera al suelo y hunde las caderas en una zancada baja.\n4. Empuja con las manos, levanta la rodilla trasera y devuelve el pie delantero al perro boca abajo.\n5. Repite del otro lado y sigue alternando.\n\nConsejos técnicos:\n• Lleva el pie hasta la altura de las manos en lugar de quedarte corto y arrastrarlo.\n• Acolcha la rodilla trasera con una esterilla doblada si el suelo es duro.\n• Mantén la rodilla delantera sobre el tobillo cuando bajen las caderas.\n\nMúsculos principales: hip_flexors',NULL,'downward-dog-to-low-lunge.webp'),
(156,'Perro Boca Abajo a Plancha','Downward Dog to Plank','Una transición en movimiento entre el perro boca abajo y la plancha alta: las caderas viajan de arriba a la horizontal y de vuelta, de modo que hombros y tronco trabajan en recorrido completo en lugar de sostener una posición.\n\nInstrucciones de ejecución:\n1. Colócate en perro boca abajo con las caderas altas y las manos a la anchura de los hombros.\n2. Desplaza el peso hacia delante y baja las caderas hasta formar una línea recta en plancha alta.\n3. Sostén la plancha un instante con las costillas cerradas y los glúteos activos.\n4. Empuja el suelo y eleva las caderas de vuelta al perro boca abajo.\n5. Sigue alternando las veces indicadas.\n\nConsejos técnicos:\n• Lo que se mueve son las caderas, no las manos; las palmas se quedan en el mismo sitio toda la serie.\n• Mantén los hombros alejados de las orejas en ambas posiciones.\n• Frena la transición si la zona lumbar se hunde al entrar en la plancha.\n\nMúsculos principales: anterior_deltoid, rectus_abdominis',NULL,'downward-dog-to-plank.webp'),
(157,'Perro Boca Abajo a Perro Boca Arriba','Downward Dog to Upward Dog','La transición del vinyasa: el cuerpo viaja desde el perro boca abajo hacia delante al perro boca arriba y de vuelta, alternando entre una V invertida cargada en los hombros y una extensión con el pecho abierto.\n\nInstrucciones de ejecución:\n1. Empieza en perro boca abajo con las caderas altas y las manos a la anchura de los hombros.\n2. Desplázate hacia delante pasando por la plancha, baja un poco y lleva el pecho al frente hasta el perro boca arriba con los muslos despegados.\n3. Lleva los hombros atrás y abajo y mantén el cuello largo.\n4. Mete los dedos de los pies, empuja el suelo y eleva las caderas de vuelta al perro boca abajo.\n5. Sigue moviéndote entre ambas posiciones las veces indicadas.\n\nConsejos técnicos:\n• Lo que se mueve son las caderas, no las manos; las palmas siguen plantadas toda la serie.\n• Presiona el empeine en el perro boca arriba para que los muslos se despeguen de verdad.\n• Frena en mitad de la transición en lugar de balancearte entre los extremos.\n\nMúsculos principales: anterior_deltoid, erector_spinae',NULL,'downward-dog-to-upward-dog.webp'),
(158,'Drag Curl','Drag Curl','Un curl con barra en el que los codos viajan hacia atrás y la barra se desliza por el torso, eliminando la asistencia del deltoides anterior y enfatizando la cabeza larga del bíceps.\n\nInstrucciones de ejecución:\n1. Ponte de pie sujetando una barra con agarre supino, con las manos al ancho de los hombros.\n2. Comienza con la barra en los muslos y los codos a los costados.\n3. Sube la barra deslizándola (arrastrándola) hacia arriba a lo largo del cuerpo.\n4. A medida que sube, deja que los codos viajen hacia atrás para que la barra permanezca en contacto con el torso.\n5. Para cuando la barra llegue a la altura del pecho; los bíceps estarán completamente contraídos.\n6. Baja de forma controlada siguiendo el mismo trayecto y repite.\n\nConsejos técnicos:\n• Usa significativamente menos peso que en un curl estándar — la mecánica modificada lo hace mucho más difícil.\n• La barra nunca debe separarse del cuerpo.\n\nMúsculos principales: biceps_brachii',NULL,'drag-curl.webp'),
(159,'Dragon Flag','Dragon Flag','Un exigente ejercicio de core en banco: agarrando detrás de la cabeza, elevas todo el cuerpo en una línea recta y rígida apoyada solo en la parte alta de la espalda.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco y agárralo firmemente detrás de la cabeza.\n2. Eleva el cuerpo de forma que solo la parte superior de la espalda permanezca apoyada en el banco.\n3. Mantén el cuerpo rígido en línea recta.\n4. Baja el cuerpo de forma controlada hasta quedar casi horizontal.\n5. Sube de vuelta y repite.\n\nConsejos técnicos:\n• Mantén el cuerpo rígido de hombros a pies y muévete solo desde los hombros.\n• Baja tan despacio como puedas: la fase excéntrica es el ejercicio.\n• Empieza con progresiones con piernas recogidas o a una pierna antes del dragon flag completo.\n\nMúsculos principales: rectus_abdominis',NULL,'dragon-flag.webp'),
(160,'Remo en Banco con Mancuernas','Dumbbell Bench Pull','Un movimiento de remo boca abajo sobre un banco para trabajar la parte superior de la espalda de forma estricta.\n\nInstrucciones de ejecución:\n1. Túmbate boca abajo en un banco inclinado sujetando mancuernas.\n2. Deja los brazos colgando rectos hacia abajo.\n3. Tira de las mancuernas hacia el pecho apretando los omóplatos.\n4. Baja de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Mantén el pecho pegado al banco en todo momento.\n• Inicia el tirón con la espalda, no con los bíceps.\n• Controla la bajada hasta estirar por completo los brazos.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'dumbbell-bench-pull.webp'),
(161,'Elevación de Talones con Mancuernas','Dumbbell Calf Raise','Una elevación de talones con mancuernas sobre una superficie elevada que trabaja gemelos y sóleo en rango completo.\n\nInstrucciones de ejecución:\n1. Ponte de pie sujetando una mancuerna en cada mano a los costados.\n2. Coloca las puntas de los pies sobre una superficie elevada con los talones colgando.\n3. Empuja a través de las puntas de los pies para subir los talones lo más alto posible.\n4. Aprieta los gemelos en la parte superior del movimiento.\n5. Baja los talones por debajo de la plataforma para estirar los gemelos.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Evita rebotar abajo y haz una pausa breve en el estiramiento.\n• Mantén las rodillas extendidas pero sin bloquearlas.\n• Sube y baja despacio para no perder el equilibrio.\n\nMúsculos principales: gastrocnemius, soleus',NULL,'dumbbell-calf-raise.webp'),
(162,'Peso Muerto con Mancuernas','Dumbbell Deadlift','Un peso muerto con mancuernas que fortalece la cadena posterior mediante un patrón de bisagra de cadera.\n\nInstrucciones de ejecución:\n1. Ponte de pie con las mancuernas frente a los muslos y los pies al ancho de las caderas.\n2. Inclínate desde las caderas y baja las mancuernas a lo largo de las piernas con la espalda recta.\n3. Mantén las mancuernas cerca de las espinillas durante el descenso.\n4. Empuja a través de los talones para volver a la posición de pie.\n5. Extiende completamente las caderas en la parte superior sin hiperlordosis lumbar.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Empuja la cadera hacia atrás en lugar de redondear la espalda.\n• Mira al frente o ligeramente hacia abajo para alinear el cuello.\n• Levanta con las piernas y la cadera, no con la zona lumbar.\n\nMúsculos principales: erector_spinae, gluteus_maximus, hamstrings',NULL,'dumbbell-deadlift.webp'),
(163,'Face Pull con Mancuernas','Dumbbell Face Pull','Un ejercicio para el deltoides posterior y la espalda alta, tirando de mancuernas hacia la cara con los codos muy abiertos.\n\nInstrucciones de ejecución:\n1. Ponte de pie o siéntate sosteniendo una mancuerna en cada mano con los brazos extendidos hacia adelante.\n2. Flexiona los codos y tira de las mancuernas hacia la cara.\n3. Abre los codos hasta la altura de los hombros.\n4. Contrae el deltoides posterior y la espalda alta en el punto máximo.\n5. Baja las mancuernas con control.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Lidera el movimiento con los codos, no con las manos.\n• Mantén los brazos superiores casi paralelos al suelo.\n• Usa un peso ligero y prioriza la técnica.\n\nMúsculos principales: posterior_deltoid, rhomboids',NULL,'dumbbell-face-pull.webp'),
(164,'Press de Suelo con Mancuernas','Dumbbell Floor Press','Un press con mancuernas realizado tumbado en el suelo, que limita el rango de movimiento para un press más amigable con las articulaciones.\n\nInstrucciones de ejecución:\n1. Túmbate en el suelo con una mancuerna en cada mano a la altura del pecho.\n2. Empuja las mancuernas hacia arriba hasta que los brazos queden extendidos.\n3. Baja de forma controlada hasta que los codos toquen el suelo.\n4. Repite.\n\nConsejos técnicos:\n• El suelo limita la tensión en el hombro en la posición inferior.\n• Mantén las muñecas alineadas sobre los codos.\n\nMúsculos principales: pectoralis_major',NULL,'dumbbell-floor-press.webp'),
(165,'Elevación Frontal con Mancuernas','Dumbbell Front Raise','Un ejercicio de aislamiento que trabaja el deltoides anterior mediante una elevación hacia adelante.\n\nInstrucciones de ejecución:\n1. Ponte de pie con las mancuernas a los costados, palmas frente a los muslos.\n2. Sube una o ambas mancuernas hacia adelante hasta la altura de los hombros.\n3. Baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• Evita usar el impulso.\n• Una ligera flexión de codo reduce el estrés articular.\n\nMúsculos principales: anterior_deltoid',NULL,'dumbbell-front-raise.webp'),
(166,'Sentadilla Frontal con Mancuernas','Dumbbell Front Squat','Una sentadilla sosteniendo mancuernas apoyadas en los hombros, manteniendo el torso erguido y enfatizando los cuádriceps.\n\nInstrucciones de ejecución:\n1. Sujeta una mancuerna en cada mano apoyadas sobre los hombros.\n2. Mantén los codos en alto y el torso erguido.\n3. Baja las caderas flexionando las rodillas hasta que los muslos queden paralelos al suelo.\n4. Empuja a través de los talones para ponerte de pie.\n5. Mantén la columna en posición neutra durante todo el movimiento.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén los codos altos para que las mancuernas queden apoyadas en los hombros.\n• Siéntate entre las caderas en lugar de plegarte hacia delante.\n• Empuja con todo el pie y mantén los talones en el suelo.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'dumbbell-front-squat.webp'),
(167,'Empuje de Cadera con Mancuerna','Dumbbell Hip Thrust','El Empuje de Cadera con Mancuerna es un ejercicio compuesto muy eficaz para construir glúteos y isquiotibiales fuertes, realizado empujando las caderas hacia arriba con una mancuerna sobre la pelvis.\n\nInstrucciones de ejecución:\n1. Siéntate en el suelo con la parte superior de la espalda contra un banco, rodillas flexionadas, pies planos y una mancuerna sobre tus caderas.\n2. Contrae tu abdomen y empuja a través de tus talones, levantando las caderas del suelo hasta que tu cuerpo forme una línea recta de hombros a rodillas.\n3. Aprieta tus glúteos con fuerza en la parte superior del movimiento, asegurando una extensión completa de la cadera.\n4. Baja lentamente tus caderas a la posición inicial con control, manteniendo la tensión.\n5. Repite el ejercicio por el número deseado de repeticiones.\n\nConsejos técnicos:\n• Mantén la barbilla pegada al pecho para mantener una columna vertebral neutra durante todo el movimiento.\n• Concéntrate en empujar a través de los talones para maximizar la activación de los glúteos.\n• Controla la fase excéntrica (descenso) para mejorar el crecimiento muscular.\n• Usa una almohadilla o toalla debajo de la mancuerna para mayor comodidad.\n\nMúsculos principales: gluteus_maximus',NULL,'dumbbell-hip-thrust.webp'),
(168,'Sentadilla Pistola con Mancuerna','Dumbbell Pistol Squat','La Sentadilla Pistola con Mancuerna es una variación avanzada de sentadilla a una pierna que desarrolla fuerza significativa en la parte inferior del cuerpo, equilibrio y movilidad, apuntando principalmente a los cuádriceps y glúteos.\n\nInstrucciones de ejecución:\n1. Ponte de pie, sosteniendo una mancuerna en cada mano con los brazos colgando a los lados.\n2. Levanta una pierna recta hacia adelante, manteniéndola extendida durante todo el movimiento.\n3. Baja tu cuerpo doblando la rodilla de tu pierna de apoyo, manteniendo el pecho erguido y la espalda recta.\n4. Desciende hasta que tus glúteos estén cerca de tu talón o tu muslo esté paralelo al suelo, manteniendo el equilibrio.\n5. Empuja a través de tu talón para volver a la posición inicial, extendiendo completamente tu pierna de apoyo.\n6. Completa todas las repeticiones de un lado, luego cambia de pierna y repite para el otro lado por serie.\n\nConsejos técnicos:\n• Empieza con sentadillas pistola sin peso para dominar el patrón de movimiento antes de añadir mancuernas.\n• Deja que las mancuernas cuelguen rectas a los lados y mantén el pecho erguido para conservar el equilibrio sobre el pie que trabaja.\n• Concéntrate en controlar la fase excéntrica (de descenso) para mejorar la estabilidad y la fuerza.\n• Eleva ligeramente el talón sobre un disco pequeño si la movilidad del tobillo es un factor limitante.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'dumbbell-pistol-squat.webp'),
(169,'Press de Empuje con Mancuernas','Dumbbell Push Press','Un press de hombros compuesto que usa el impulso de las piernas para desarrollar potencia en hombros y tríceps.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo mancuernas a la altura de los hombros, palmas hacia adelante.\n2. Dobla ligeramente las rodillas en una cuarta sentadilla.\n3. Empuja con las piernas para generar impulso y presiona las mancuernas hacia arriba.\n4. Extiende los brazos completamente arriba.\n5. Baja las mancuernas con control a la altura de los hombros.\n\nConsejos técnicos:\n• Usa un descenso poco profundo — no es una sentadilla completa.\n• Empuja los talones contra el suelo para iniciar el press.\n• Mantén el core activado para proteger la zona lumbar.\n\nMúsculos principales: anterior_deltoid, triceps_brachii',NULL,'dumbbell-push-press.webp'),
(170,'Pájaro Invertido con Mancuernas','Dumbbell Reverse Fly','Un ejercicio de aislamiento inclinado que levanta las mancuernas hacia los lados, trabajando los deltoides posteriores y la espalda alta.\n\nInstrucciones de ejecución:\n1. Inclínate hacia adelante desde las caderas sujetando mancuernas con los brazos colgando.\n2. Mantén la espalda recta y las rodillas ligeramente dobladas.\n3. Sube las mancuernas hacia los lados hasta la altura de los hombros.\n4. Aprieta los omóplatos en la parte superior.\n5. Baja las mancuernas de forma controlada.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Usa un peso ligero para que trabajen los deltoides posteriores, no el impulso.\n• Aprieta los omóplatos juntos arriba.\n• Mantén una flexión suave y fija en los codos en todo momento.\n\nMúsculos principales: posterior_deltoid',NULL,'dumbbell-reverse-fly.webp'),
(171,'Peso Muerto Rumano con Mancuernas','Dumbbell Romanian Deadlift','Un peso muerto rumano con mancuernas que enfatiza el estiramiento de los isquiotibiales mediante una bisagra de cadera.\n\nInstrucciones de ejecución:\n1. Ponte de pie sujetando mancuernas frente a los muslos con una ligera flexión de rodillas.\n2. Inclínate desde las caderas y empuja los glúteos hacia atrás.\n3. Baja las mancuernas a lo largo de las piernas hasta sentir el estiramiento en los isquiotibiales.\n4. Mantén la espalda recta y los hombros hacia atrás.\n5. Empuja las caderas hacia adelante para volver a la posición de pie.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Baja hasta donde tu flexibilidad lo permita, sin forzar.\n• Mantén la misma flexión suave de rodillas en todo el recorrido.\n• No conviertas el movimiento en una sentadilla.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'dumbbell-romanian-deadlift.webp'),
(172,'Press de Hombros con Mancuernas','Dumbbell Shoulder Press','Un press vertical con mancuernas, sentado o de pie, que desarrolla las porciones anterior y lateral del deltoides.\n\nInstrucciones de ejecución:\n1. Siéntate o ponte de pie sujetando mancuernas a la altura de los hombros con las palmas mirando hacia adelante.\n2. Empuja ambas mancuernas por encima de la cabeza hasta que los brazos queden completamente extendidos.\n3. Mantén el core contraído y evita arquear la zona lumbar.\n4. Baja las mancuernas de forma controlada hasta la altura de los hombros.\n5. No dejes que las mancuernas se desplacen detrás de la cabeza.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Sube las mancuernas en línea recta, sin chocarlas arriba.\n• Mantén las muñecas firmes, alineadas con los antebrazos.\n• Si tu zona lumbar se arquea, reduce el peso.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'dumbbell-shoulder-press.webp'),
(173,'Flexión Lateral con Mancuerna','Dumbbell Side Bend','Un ejercicio de aislamiento de oblicuos de pie con mancuerna para desarrollar la fuerza lateral del core.\n\nInstrucciones de ejecución:\n1. Párate erguido sosteniendo una mancuerna a un lado.\n2. Coloca la otra mano en la cadera o detrás de la cabeza.\n3. Inclínate lateralmente hacia el lado de la mancuerna, bajándola por el muslo.\n4. Vuelve a la posición erguida, luego inclínate al lado opuesto con los oblicuos.\n5. Completa todas las repeticiones por lado.\n\nConsejos técnicos:\n• Evita inclinarte hacia adelante o atrás — muévete estrictamente de lado.\n• Usa un tempo controlado en ambas direcciones.\n• Mantén el peso cerca de la pierna durante todo el movimiento.\n\nMúsculos principales: obliques',NULL,'dumbbell-side-bend.webp'),
(174,'Snatch con Mancuerna','Dumbbell Snatch','Un levantamiento explosivo a un brazo que impulsa la mancuerna desde el suelo hasta encima de la cabeza en un movimiento fluido.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies al ancho de los hombros y la mancuerna en el suelo entre tus pies.\n2. Inclínate y agarra la mancuerna con una mano.\n3. Extiende caderas, rodillas y tobillos de forma explosiva para tirar de la mancuerna hacia arriba.\n4. Empuja la mancuerna por encima de la cabeza en un movimiento fluido.\n5. Bloquea el brazo y estabiliza en la parte superior.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Extiende completamente caderas y rodillas antes de tirar con el brazo.\n• Empuja la mancuerna hacia arriba hasta un bloqueo estable sobre la cabeza.\n• Mantén la mancuerna cerca del cuerpo mientras sube.\n\nMúsculos principales: anterior_deltoid, gluteus_maximus, trapezius',NULL,'dumbbell-snatch.webp'),
(175,'Sentadilla en Postura Dividida con Mancuernas','Dumbbell Split Squat','Una sentadilla en posición de tijera sosteniendo mancuernas a los lados, que trabaja los cuádriceps y glúteos una pierna a la vez.\n\nInstrucciones de ejecución:\n1. Ponte en postura dividida sujetando mancuernas a los costados.\n2. Mantén el torso erguido y el core contraído.\n3. Baja la rodilla trasera hacia el suelo doblando ambas rodillas.\n4. Para cuando el muslo delantero quede paralelo al suelo.\n5. Empuja a través del talón delantero para volver a la posición de pie.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén la mayor parte del peso en la pierna delantera.\n• Baja la rodilla trasera recta hacia el suelo.\n• Lleva la rodilla delantera sobre los dedos sin dejar que se hunda hacia dentro.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'dumbbell-split-squat.webp'),
(176,'Extensión de Tríceps con Mancuerna','Dumbbell Tricep Extension','Una extensión de tríceps en una mano por encima de la cabeza para un desarrollo equilibrado del brazo.\n\nInstrucciones de ejecución:\n1. Ponte de pie sujetando una mancuerna en una mano por encima de la cabeza.\n2. Baja la mancuerna detrás de la cabeza doblando el codo.\n3. Extiende el brazo de vuelta a la posición inicial.\n4. Mantén el codo cerca de la cabeza.\n5. Repite en ambos lados.\n\nConsejos técnicos:\n• Mantén el codo apuntando al techo durante todo el movimiento.\n• Baja la mancuerna despacio hasta sentir el estiramiento del tríceps.\n• Evita arquear la espalda baja manteniendo el abdomen firme.\n\nMúsculos principales: triceps_brachii',NULL,'dumbbell-tricep-extension.webp'),
(177,'Remo al Mentón con Mancuernas','Dumbbell Upright Row','Un movimiento de tirón compuesto con mancuernas que trabaja los deltoides laterales y el trapecio superior.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo dos mancuernas frente a los muslos, palmas hacia el cuerpo.\n2. Tira de las mancuernas recto hacia arriba a lo largo del cuerpo, liderando con los codos.\n3. Sube hasta la altura del mentón con los codos por encima de las muñecas.\n4. Pausa brevemente, luego baja con control.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén las mancuernas cerca del cuerpo durante todo el movimiento.\n• Lidera con los codos, no con las manos.\n• Evita un agarre muy estrecho para reducir el riesgo de impingement de hombro.\n\nMúsculos principales: lateral_deltoid, trapezius',NULL,'dumbbell-upright-row.webp'),
(178,'Molino con Mancuerna','Dumbbell Windmill','Este ejercicio de cuerpo completo desarrolla estabilidad del core, fuerza de hombros y movilidad de cadera al rotar el torso con una mancuerna sobre la cabeza, trabajando principalmente los oblicuos y deltoides laterales.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies al ancho de los hombros, sosteniendo una mancuerna sobre la cabeza con un brazo extendido.\n2. Gira tus pies ligeramente alejándolos del lado de la mancuerna, manteniendo el brazo recto y la vista en el peso.\n3. Inclínate desde las caderas, empujándolas hacia el lado de la mancuerna, y baja lentamente el torso hacia el suelo.\n4. Mantén la espalda recta y el brazo de la mancuerna vertical mientras alcanzas con tu mano libre el pie o el suelo.\n5. Invierte el movimiento impulsándote con las caderas y los oblicuos para regresar a la posición inicial.\n6. Completa todas las repeticiones por lado, luego cambia y repite para el otro lado.\n\nConsejos técnicos:\n• Mantén el core contraído durante todo el movimiento para proteger tu columna y mejorar la estabilidad.\n• Mantén la vista fija en la mancuerna sobre la cabeza para ayudar a mantener el equilibrio y el brazo recto.\n• Concéntrate en inclinarte desde las caderas, no en redondear la espalda, para activar los isquiotibiales y glúteos.\n• Comienza con un peso ligero para dominar la forma antes de progresar a cargas más pesadas.\n\nMúsculos principales: lateral_deltoid, obliques',NULL,'dumbbell-windmill.webp'),
(179,'Curl de Muñeca con Mancuerna','Dumbbell Wrist Curl','Un curl de muñeca con mancuerna que aísla los flexores del antebrazo y trabaja ambos brazos por separado.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con el antebrazo sobre el muslo, palma hacia arriba.\n2. Sujeta una mancuerna con la muñeca fuera de la rodilla.\n3. Deja que la mancuerna ruede hasta las puntas de los dedos.\n4. Sube la mancuerna flexionando la muñeca.\n5. Baja con control. Repeticiones por lado.\n\nConsejos técnicos:\n• Mueve solo la muñeca — el antebrazo permanece quieto.\n• Rueda la mancuerna a las puntas de los dedos para el rango completo.\n• Entrena ambos brazos con la misma carga y repeticiones.\n\nMúsculos principales: forearm_flexors',NULL,'dumbbell-wrist-curl.webp'),
(180,'Press de Banca con Barra Z','EZ-Bar Bench Press','Un press de pecho en banco plano realizado con una barra Z, cuyos agarres angulados son más cómodos para las muñecas mientras trabajan el pectoral, los deltoides anteriores y los tríceps.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco plano con los pies apoyados en el suelo y agarra las curvas anguladas de la barra Z sobre el pecho.\n2. Desengancha la barra y sostenla sobre la parte baja del pecho con los brazos extendidos.\n3. Baja la barra de forma controlada hacia la parte baja del pecho.\n4. Empuja la barra de nuevo hacia arriba hasta extender completamente los brazos.\n5. Repite durante el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén los pies apoyados en el suelo y un ligero arco en la zona lumbar para una base estable.\n• El agarre angulado de la barra Z es más cómodo para las muñecas que una barra recta.\n• Baja la barra hacia la parte baja del pecho y mantén los codos a unos 45 grados para proteger los hombros.\n\nMúsculos principales: pectoralis_major',NULL,'ez-bar-bench-press.webp'),
(181,'Curl con Barra Z','EZ-Bar Curl','Un ejercicio de aislamiento para el bíceps con barra Z, que reduce la tensión en las muñecas en comparación con una barra recta.\n\nInstrucciones de ejecución:\n1. Ponte de pie sujetando la barra Z con agarre supino en las partes anguladas.\n2. Sube la barra hacia los hombros manteniendo los codos fijos.\n3. Aprieta en la parte superior y luego baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• Usa el agarre interior o exterior para variar el énfasis.\n• Mantén las muñecas en posición neutra en los agarres angulados.\n\nMúsculos principales: biceps_brachii',NULL,'ez-bar-curl.webp'),
(182,'Elevación Frontal con Barra Z','EZ-Bar Front Raise','Una elevación frontal con ambas manos usando una barra Z. El agarre angulado es más cómodo para las muñecas que una barra recta y permite a ambas manos manejar la misma carga.\n\nInstrucciones de ejecución:\n1. Ponte de pie sujetando la barra Z con agarre prono en las curvas internas, con los brazos colgando frente a los muslos.\n2. Mantén los codos ligeramente doblados y fijos durante todo el movimiento.\n3. Sube la barra en un arco suave hasta la altura de los hombros.\n4. Haz una breve pausa en la parte superior y luego baja de forma controlada.\n5. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• La barra debe desplazarse en línea recta frente al cuerpo.\n• No balancees el torso; mantén el core contraído y las rodillas ligeramente flexionadas.\n• Para a la altura de los hombros — subir más desplaza la tensión fuera de los deltoides anteriores.\n\nMúsculos principales: anterior_deltoid',NULL,'ez-bar-front-raise.webp'),
(183,'Extensión de Tríceps Tumbado con Barra Z','EZ-Bar Lying Triceps Extension','Una extensión de tríceps tumbado realizada con una barra Z para aislar el tríceps a lo largo de todo el rango de movimiento.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco plano sujetando una barra Z sobre el pecho con un agarre estrecho.\n2. Baja la barra hacia la frente flexionando los codos.\n3. Extiende los brazos de vuelta a la posición inicial.\n4. Repite.\n\nConsejos técnicos:\n• Mantén los brazos superiores verticales en todo momento para que trabaje el tríceps.\n• El agarre angulado de la barra Z es más cómodo para las muñecas que una barra recta.\n• Baja despacio para proteger los codos.\n\nMúsculos principales: triceps_brachii',NULL,'ez-bar-lying-tricep-extension.webp'),
(184,'Extensión de Tríceps por Encima de la Cabeza con Barra Z','EZ-Bar Overhead Tricep Extension','Extensión de tríceps por encima de la cabeza con barra Z — el agarre angulado es más cómodo para las muñecas que una barra recta y mantiene la cabeza larga bajo un estiramiento profundo.\n\nInstrucciones de ejecución:\n1. Ponte de pie o siéntate sujetando la barra Z por encima de la cabeza con agarre prono en las curvas internas.\n2. Brazos completamente extendidos con la barra sobre la cabeza.\n3. Dobla solo los codos para bajar la barra detrás de la cabeza en un arco.\n4. Mantén los brazos verticales y cerca de la cabeza; solo los antebrazos se mueven.\n5. Extiende los codos para volver la barra a la posición inicial.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Si los codos se abren hacia afuera, baja el peso — significa que los hombros están ayudando.\n• Cuanto más profundo sea el estiramiento en la parte inferior, mayor será el estímulo de hipertrofia en la cabeza larga.\n• La versión sentada es más cómoda para la zona lumbar.\n\nMúsculos principales: triceps_brachii',NULL,'ez-bar-overhead-extension.webp'),
(185,'Pullover con Barra EZ','EZ Bar Pullover','Este ejercicio compuesto trabaja los dorsales y pectorales extendiendo los brazos por encima de la cabeza con una barra EZ, promoviendo la fuerza y la hipertrofia del tren superior.\n\nInstrucciones de ejecución:\n1. Acuéstate boca arriba en un banco plano con la cabeza ligeramente fuera del extremo, sosteniendo una barra EZ con agarre pronado.\n2. Extiende la barra directamente sobre tu pecho, manteniendo una ligera flexión en los codos.\n3. Baja lentamente la barra en un arco detrás de tu cabeza, sintiendo un estiramiento en tus dorsales y pecho.\n4. Jala la barra de regreso a la posición inicial usando tus dorsales y pectorales.\n5. Mantén el control durante todo el movimiento, evitando el impulso.\n\nConsejos técnicos:\n• Mantén tu core contraído para evitar arquear excesivamente la espalda baja.\n• Concéntrate en un estiramiento profundo en la parte inferior del movimiento.\n• Usa un compañero para cargas más pesadas y asegurar la seguridad.\n• Controla la fase excéntrica (descenso) para una máxima activación muscular.\n\nMúsculos principales: latissimus_dorsi, pectoralis_major',NULL,'ez-bar-pullover.webp'),
(186,'Curl Inverso con Barra Z','EZ-Bar Reverse Curl','Un curl inverso con barra Z que trabaja el braquial y los extensores del antebrazo con un agarre cómodo.\n\nInstrucciones de ejecución:\n1. Sujeta una barra Z con agarre prono.\n2. Sube la barra hacia tus hombros.\n3. Baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• Mantén los codos cerca del torso.\n• La barra Z reduce la tensión en las muñecas.\n\nMúsculos principales: brachialis, forearm_extensors',NULL,'ez-bar-reverse-curl.webp'),
(187,'Remo con Barra EZ y Agarre Supino','EZ Bar Reverse Grip Row','Este ejercicio compuesto de tracción trabaja el dorsal ancho y el bíceps, desarrollando eficazmente el grosor de la espalda y la fuerza de los brazos con un agarre supinado.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies al ancho de los hombros, sujetando una barra EZ con un agarre supino al ancho de los hombros.\n2. Inclínate desde las caderas, manteniendo una ligera flexión de rodillas y la espalda recta, hasta que tu torso esté casi paralelo al suelo.\n3. Deja que la barra cuelgue directamente debajo de tus hombros con los brazos completamente extendidos.\n4. Tira de la barra hacia tu abdomen inferior, apretando los omóplatos y llevando los codos hacia arriba.\n5. Controla la fase excéntrica, bajando lentamente la barra a la posición inicial con los brazos completamente extendidos.\n\nConsejos técnicos:\n• Mantén una columna vertebral neutra durante todo el movimiento para proteger tu espalda baja.\n• Concéntrate en iniciar la tracción con los dorsales, no solo con los bíceps.\n• Evita encogerte de hombros; manténlos deprimidos y retraídos.\n• Utiliza un rango completo de movimiento, extendiendo los brazos por completo en la parte inferior.\n\nMúsculos principales: biceps_brachii, latissimus_dorsi',NULL,'ez-bar-reverse-grip-row.webp'),
(188,'Encogimiento de Hombros con Barra Z','EZ-Bar Shrug','Un encogimiento de hombros con barra Z para un agarre cómodo mientras se carga el trapecio.\n\nInstrucciones de ejecución:\n1. De pie, sujeta la barra Z frente a ti.\n2. Encoge los hombros directamente hacia arriba.\n3. Mantén la posición arriba y luego baja.\n4. Repite.\n\nConsejos técnicos:\n• Evita girar los hombros en círculos.\n• Usa un rango completo de movimiento.\n\nMúsculos principales: trapezius',NULL,'ez-bar-shrug.webp'),
(189,'Spider Curl con Barra Z','EZ Bar Spider Curl','Un curl con el pecho apoyado sobre un banco inclinado usando barra Z, aislando el bíceps con técnica estricta.\n\nInstrucciones de ejecución:\n1. Túmbate boca abajo en un banco inclinado sujetando una barra Z con agarre supino.\n2. Deja que tus brazos cuelguen rectos desde los hombros.\n3. Sube la barra hacia tus hombros.\n4. Aprieta los bíceps en la parte alta del movimiento.\n5. Baja la barra de forma controlada.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Deja los brazos colgando verticales y mantén fijos los brazos superiores.\n• Haz el curl solo con el bíceps: el banco elimina cualquier excusa para balancearte.\n• Baja hasta el estiramiento completo antes de empezar la siguiente repetición.\n\nMúsculos principales: biceps_brachii',NULL,'ez-bar-spider-curl.webp'),
(190,'Remo al Mentón con Barra Z','EZ-Bar Upright Row','Una variación del remo vertical con barra Z para una posición de muñecas más cómoda.\n\nInstrucciones de ejecución:\n1. De pie, sujeta la barra Z con agarre a la anchura de los hombros en las partes anguladas.\n2. Tira de la barra hacia arriba a lo largo del cuerpo hasta la altura del mentón.\n3. Lidera el movimiento con los codos, manteniéndolos por encima de las manos.\n4. Baja de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Mantén las muñecas relajadas, sin doblarlas hacia arriba.\n• Evita balancear el torso para subir la barra.\n• Si notas molestias en los hombros, reduce el rango o la carga.\n\nMúsculos principales: lateral_deltoid, trapezius',NULL,'ez-bar-upright-row.webp'),
(191,'Curl de Muñeca con Barra Z','EZ-Bar Wrist Curl','Un curl de muñeca con barra Z, más amigable con las muñecas que la barra recta.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con los antebrazos sobre los muslos, palmas hacia arriba.\n2. Sujeta una barra Z por las curvas internas a la anchura de los hombros.\n3. Deja que la barra ruede hasta las puntas de los dedos.\n4. Sube la barra flexionando las muñecas.\n5. Baja con control.\n\nConsejos técnicos:\n• El ángulo de la barra Z es más amable con las muñecas.\n• Mueve solo la muñeca — los antebrazos permanecen quietos.\n• Rueda la barra a las puntas de los dedos para el rango completo.\n\nMúsculos principales: forearm_flexors',NULL,'ez-bar-wrist-curl.webp'),
(192,'Face Pull en Polea','Cable Face Pull','Un ejercicio de cable que trabaja los deltoides posteriores y los rotadores externos.\n\nInstrucciones de ejecución:\n1. Engancha una cuerda en una polea alta.\n2. Tira de la cuerda hacia tu cara, separando los extremos.\n3. Aprieta los deltoides posteriores y los rotadores externos.\n4. Regresa a la posición inicial de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Mantén los codos altos, alineados con los hombros.\n• Junta las escápulas al final de cada repetición.\n• Trabaja con peso ligero para no perder la técnica.\n\nMúsculos principales: posterior_deltoid, rhomboids',NULL,'face-pull.webp'),
(193,'Press en Suelo con Barra Z','Floor EZ-Bar Press','Una variación del press en suelo con barra Z para una posición más cómoda de muñecas y codos.\n\nInstrucciones de ejecución:\n1. Túmbate en el suelo sujetando una barra Z sobre el pecho.\n2. Baja la barra hasta que los codos toquen el suelo.\n3. Empuja de vuelta hasta la extensión completa.\n4. Repite.\n\nConsejos técnicos:\n• La barra Z reduce la tensión en las muñecas en comparación con una barra recta.\n• Mantén los pies planos sobre el suelo.\n\nMúsculos principales: pectoralis_major',NULL,'floor-ez-bar-press.webp'),
(194,'Pullover con Pesa Rusa en Suelo','Floor Kettlebell Pullover','Un pullover realizado tumbado en el suelo con una pesa rusa sujetada por el asa o por las asas laterales. El suelo limita el rango de movimiento en comparación con la versión en banco, lo que reduce la tensión en los hombros y lo convierte en una buena opción para entrenar en casa o como ejercicio de prehabilitación.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba en el suelo con las rodillas flexionadas y los pies planos.\n2. Sujeta una pesa rusa por el asa con ambas manos sobre el pecho, brazos casi extendidos (ligera flexión de codos).\n3. Manteniendo el ángulo de los codos fijo, baja la pesa hacia atrás en arco hasta que los brazos toquen el suelo.\n4. Tira de la pesa de vuelta sobre el pecho siguiendo el mismo arco.\n5. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• El suelo limita el rango de movimiento; si te parece demasiado corto, usa la versión en banco.\n• Agarra el asa con firmeza y aprieta los dorsales en la parte alta.\n• Mantén la zona lumbar pegada al suelo durante todo el ejercicio.\n\nMúsculos principales: latissimus_dorsi, pectoralis_major',NULL,'floor-kettlebell-pullover.webp'),
(195,'Press en Suelo','Floor Press','Un movimiento de press con barra realizado en el suelo, limitando el rango de movimiento y eliminando la participación del tren inferior.\n\nInstrucciones de ejecución:\n1. Túmbate en el suelo y colócate bajo una barra en el rack.\n2. Baja la barra hasta el pecho hasta que los codos toquen el suelo.\n3. Empuja de vuelta hasta el bloqueo.\n4. Repite.\n\nConsejos técnicos:\n• El contacto de los codos con el suelo proporciona un punto de parada natural.\n• Útil para trabajar la debilidad en la fase final de extensión.\n\nMúsculos principales: pectoralis_major',NULL,'floor-press.webp'),
(196,'Flutter Kicks','Flutter Kicks','Un ejercicio de core tumbado boca arriba alternando pequeñas patadas arriba y abajo mientras la zona lumbar permanece pegada al suelo.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con las piernas extendidas.\n2. Coloca las manos bajo los glúteos como apoyo.\n3. Levanta ambas piernas unos centímetros del suelo.\n4. Alterna las piernas arriba y abajo en un rango pequeño.\n5. Mantén el core contraído y la zona lumbar presionada contra el suelo.\n6. Continúa durante el tiempo o las repeticiones deseadas.\n\nConsejos técnicos:\n• Presiona la zona lumbar contra el suelo durante toda la serie.\n• Mantén las patadas pequeñas y constantes en lugar de grandes y descontroladas.\n• Eleva más las piernas si notas que la zona lumbar se arquea.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'flutter-kicks.webp'),
(197,'Sentadilla Frontal','Front Squat','Una sentadilla con barra sostenida al frente sobre los deltoides, enfatizando cuádriceps y core.\n\nInstrucciones de ejecución:\n1. Limpia o coloca la barra en los deltoides frontales con los codos altos.\n2. Baja en sentadilla manteniendo el torso erguido hasta que los muslos estén paralelos al suelo.\n3. Vuelve a subir.\n4. Repite.\n\nConsejos técnicos:\n• Mantén los codos altos para estabilizar la barra.\n• Un torso más vertical aumenta la activación de los cuádriceps.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'front-squat.webp'),
(198,'Puente de Glúteos','Glute Bridge','Un ejercicio de activación de glúteos con el peso corporal realizado tumbado en el suelo.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con las rodillas flexionadas y los pies planos en el suelo.\n2. Eleva las caderas apretando los glúteos.\n3. Mantén brevemente en la parte alta con las caderas totalmente extendidas.\n4. Baja las caderas de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Empuja con los talones para activar mejor los glúteos.\n• Evita arquear la zona lumbar al extender las caderas.\n• Mantén las rodillas alineadas con los pies durante todo el recorrido.\n\nMúsculos principales: gluteus_maximus',NULL,'glute-bridge.webp'),
(199,'Patada de Glúteo','Glute Kickback','Un ejercicio de aislamiento de glúteos con peso corporal en posición de cuatro puntos para desarrollar el glúteo mayor.\n\nInstrucciones de ejecución:\n1. Comienza a cuatro patas con las manos bajo los hombros y las rodillas bajo las caderas.\n2. Manteniendo la rodilla doblada a 90 grados, empuja el talón hacia el techo.\n3. Aprieta el glúteo en la parte superior del movimiento.\n4. Baja la pierna a la posición inicial con control.\n5. Completa todas las repeticiones y cambia de lado.\n\nConsejos técnicos:\n• Mantén las caderas paralelas al suelo — evita rotar.\n• Concéntrate en apretar el glúteo, no solo en levantar la pierna.\n• Agrega una banda de resistencia o cable para sobrecarga progresiva.\n\nMúsculos principales: gluteus_maximus',NULL,'glute-kickback.webp'),
(200,'Sentadilla Goblet','Goblet Squat','Una sentadilla apta para principiantes con una pesa rusa sujetada a la altura del pecho que mejora la postura y la profundidad.\n\nInstrucciones de ejecución:\n1. Sujeta una pesa rusa a la altura del pecho con ambas manos.\n2. Baja en sentadilla manteniendo el peso cerca del pecho.\n3. Vuelve a subir.\n4. Repite.\n\nConsejos técnicos:\n• La posición goblet favorece de forma natural un torso erguido.\n• Empuja las rodillas hacia afuera en la parte baja.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'goblet-squat.webp'),
(201,'Buenos Días','Good Morning','Un movimiento de bisagra de cadera con barra en la espalda para el desarrollo de la cadena posterior.\n\nInstrucciones de ejecución:\n1. De pie con una barra sobre la parte superior de la espalda.\n2. Realiza una bisagra de cadera empujando las caderas hacia atrás mientras mantienes la espalda plana.\n3. Baja el torso hasta que quede casi paralelo al suelo.\n4. Impulsa las caderas hacia adelante para volver a la posición erguida.\n5. Repite.\n\nConsejos técnicos:\n• Mantén una ligera flexión de rodillas durante todo el movimiento.\n• Empieza con la barra vacía hasta dominar la bisagra de cadera.\n• Si la espalda se redondea, reduce el rango de movimiento.\n\nMúsculos principales: erector_spinae, gluteus_maximus, hamstrings',NULL,'good-morning.webp'),
(202,'Elevación de Talones en Máquina Hack Squat','Hack Squat Calf Raise','Una elevación de talones en la máquina de sentadilla hack, cargando los gemelos con mucho peso sin tener que equilibrar una barra.\n\nInstrucciones de ejecución:\n1. Colócate en la máquina hack squat con los hombros bajo los apoyos.\n2. Apoya los metatarsos en la plataforma con los talones colgando.\n3. Mantén las piernas rectas con una ligera flexión de rodillas.\n4. Empuja con los metatarsos para elevar los talones.\n5. Baja los talones por debajo de la plataforma para hacer el estiramiento.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Sube tan alto como puedas sobre las puntas de los pies.\n• Haz una pausa en el estiramiento inferior en lugar de rebotar.\n• Mantén las rodillas rectas pero sin bloquear para conservar la tensión en los gemelos.\n\nMúsculos principales: gastrocnemius, soleus',NULL,'hack-squat-calf-raise.webp'),
(203,'Hack Squat','Hack Squat','Un ejercicio guiado en la máquina hack squat que trabaja principalmente los cuádriceps mediante un patrón de sentadilla controlado sobre el trineo.\n\nInstrucciones de ejecución:\n1. Carga la máquina hack squat y colócate con la espalda y los hombros contra los almohadillados.\n2. Sitúa los pies a la anchura de los hombros sobre la plataforma con los pies ligeramente girados hacia fuera.\n3. Suelta los asideros de seguridad y baja el trineo flexionando rodillas y caderas.\n4. Desciende hasta que los muslos estén al menos paralelos a la plataforma.\n5. Empuja con los talones para extender las piernas y devolver el trineo a la posición inicial.\n6. Vuelve a enganchar los asideros de seguridad al terminar la serie.\n\nConsejos técnicos:\n• Mantén la zona lumbar pegada al almohadillado durante todo el movimiento.\n• Colocar los pies más arriba en la plataforma desplaza el énfasis hacia glúteos e isquiotibiales.\n• Controla la bajada; no te impulses desde el punto más bajo.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'hack-squat.webp'),
(204,'Balanceo de Flexor de Cadera en Media Rodilla','Half-Kneeling Hip Flexor Rock','La versión dinámica del estiramiento de flexor de cadera de rodillas: desde media rodilla las caderas se balancean hacia el estiramiento y vuelven, repetido en lugar de mantenido.\n\nInstrucciones de ejecución:\n1. Apóyate sobre una rodilla con el otro pie plano en el suelo por delante.\n2. Mete ligeramente el coxis y aprieta el tronco para que la zona lumbar quede neutra.\n3. Balancea las caderas hacia delante hasta notar el alargamiento en la parte frontal del muslo trasero.\n4. Vuelve de forma controlada y repite con ritmo.\n5. Cambia de lado y repite el mismo número de veces.\n\nConsejos técnicos:\n• Mantén el movimiento en las caderas; si la zona lumbar se arquea, acorta el recorrido.\n• Aprieta el glúteo de la pierna arrodillada durante el balanceo hacia delante.\n• Acolcha la rodilla de apoyo con una esterilla doblada si el suelo es duro.\n\nMúsculos principales: hip_flexors',NULL,'half-kneeling-hip-flexor-rock.webp'),
(205,'Curl de Martillo con Mancuernas','Dumbbell Hammer Curl','Una variación del curl de bíceps con agarre neutro que trabaja el braquiorradial.\n\nInstrucciones de ejecución:\n1. De pie, sujeta las mancuernas a los lados con las palmas enfrentadas.\n2. Sube las mancuernas manteniendo las palmas hacia adentro.\n3. Aprieta en la parte alta y baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• Mantén los codos pegados al torso durante todo el recorrido.\n• Evita balancear el cuerpo para impulsar las mancuernas.\n• Las muñecas van firmes y neutras durante todo el curl.\n\nMúsculos principales: biceps_brachii, brachialis',NULL,'hammer-curl.webp'),
(206,'Flexiones en Pino','Handstand Push Ups','Un empuje invertido contra la pared, bajando la cabeza hacia el suelo y empujando de vuelta hasta el pino completo.\n\nInstrucciones de ejecución:\n1. Sube a un pino contra la pared con las manos a la anchura de los hombros.\n2. Contrae el core y mantén el cuerpo recto.\n3. Baja la cabeza hacia el suelo flexionando los codos.\n4. Detente justo antes de que la cabeza toque el suelo.\n5. Empuja con las manos para volver al pino completo.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén los codos a unos 45 grados en lugar de abrirlos por completo.\n• Contrae el core para que la espalda no se arquee alejándose de la pared.\n• Progresa primero con flexiones pike y rangos parciales.\n\nMúsculos principales: anterior_deltoid, triceps_brachii',NULL,'handstand-push-ups.webp'),
(207,'Cargada desde Colgante','Hang Clean','Una variante de la cargada que comienza con la barra a la altura de los muslos, entrenando la triple extensión explosiva y una recepción rápida.\n\nInstrucciones de ejecución:\n1. De pie, sujeta la barra con agarre a la anchura de los hombros a la altura de los muslos.\n2. Realiza una bisagra de cadera para bajar la barra justo por encima de las rodillas.\n3. Extiende caderas, rodillas y tobillos de forma explosiva.\n4. Encoge los hombros y tira de la barra hacia arriba.\n5. Recibe la barra sobre los deltoides frontales en un cuarto de sentadilla.\n6. Ponte erguido y luego vuelve a la posición de colgante.\n\nConsejos técnicos:\n• Flexiona las caderas hasta justo por encima de las rodillas antes de explotar hacia arriba.\n• Encoge los hombros y tira de la barra cerca del cuerpo.\n• Recibe la barra sobre los hombros en un cuarto de sentadilla.\n\nMúsculos principales: gluteus_maximus, quadriceps, trapezius',NULL,'hang-clean.webp'),
(208,'Power Clean desde Colgante','Hang Power Clean','Una cargada desde el colgado recibida en una sentadilla parcial, que desarrolla potencia explosiva sin bajar a una sentadilla completa.\n\nInstrucciones de ejecución:\n1. De pie con los pies a la anchura de las caderas sujetando la barra a la altura de los muslos.\n2. Realiza una bisagra de cadera para bajar la barra justo por encima de las rodillas.\n3. Extiende caderas y piernas de forma explosiva.\n4. Tira de la barra hacia arriba y recíbela sobre los deltoides frontales en una sentadilla parcial.\n5. Ponte erguido con la barra apoyada en los hombros.\n6. Baja la barra de vuelta a la posición de colgante.\n\nConsejos técnicos:\n• Impulsa con caderas y piernas antes de que tiren los brazos.\n• Recibe la barra con los muslos por encima de la paralela.\n• Mantén la espalda plana al flexionar hacia la posición inicial.\n\nMúsculos principales: gluteus_maximus, quadriceps, trapezius',NULL,'hang-power-clean.webp'),
(209,'Elevación de Rodillas Colgado','Hanging Knee Raise','Un ejercicio de core colgado de una barra que trabaja el abdomen bajo y los flexores de cadera con rodillas dobladas.\n\nInstrucciones de ejecución:\n1. Cuélgate de una barra con agarre prono y los brazos completamente extendidos.\n2. Activa el core y sube las rodillas hacia el pecho.\n3. Mantén brevemente arriba.\n4. Baja las piernas despacio a la posición inicial.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Evita el balanceo — inicia el movimiento desde el core.\n• Exhala al subir las rodillas.\n• Progresa a elevaciones de piernas rectas cuando esto resulte fácil.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'hanging-knee-raise.webp'),
(210,'Elevación de Piernas Colgado','Hanging Leg Raise','Un ejercicio avanzado de core realizado colgado de una barra.\n\nInstrucciones de ejecución:\n1. Cuélgate de una barra de dominadas con agarre prono.\n2. Sube las piernas hacia adelante hasta que queden paralelas al suelo.\n3. Mantén brevemente y baja de forma controlada.\n4. Evita balancearte.\n5. Repite.\n\nConsejos técnicos:\n• Inclina la pelvis hacia atrás al subir las piernas.\n• Empieza cada repetición desde una posición completamente quieta.\n• Flexiona las rodillas si con las piernas rectas resulta demasiado difícil.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'hanging-leg-raise.webp'),
(211,'Pike Colgado','Hanging Pike','Una elevación de piernas estricta colgado de la barra hasta tocarla: las piernas se mantienen rectas y los pies suben hasta las manos.\n\nInstrucciones de ejecución:\n1. Cuélgate de una barra de dominadas con agarre prono a la anchura de los hombros.\n2. Activa los dorsales y contrae el core para crear un cuerpo hueco.\n3. Manteniendo las piernas completamente rectas, súbelas en un arco suave hasta la barra.\n4. Intenta tocar los pies a la barra entre las manos.\n5. Baja las piernas lentamente a la posición de cuelgue y repite.\n\nConsejos técnicos:\n• Sin balanceo: cada repetición empieza desde un cuelgue muerto con el tronco activado.\n• Si el rango completo es demasiado difícil, sube solo hasta la horizontal y ve progresando.\n\nMúsculos principales: rectus_abdominis',NULL,'hanging-pike.webp'),
(212,'Sentadilla con Talones Elevados','Heel-Elevated Squat','Una variante de sentadilla con los talones elevados sobre discos para enfatizar los cuádriceps y mejorar la profundidad.\n\nInstrucciones de ejecución:\n1. Coloca discos de peso o una cuña bajo los talones, pies al ancho de los hombros.\n2. Sostén una barra en la parte superior de la espalda o mancuernas a los lados.\n3. Activa el core y baja en sentadilla manteniendo el torso erguido.\n4. Baja hasta que los muslos estén paralelos al suelo o más abajo.\n5. Empuja a través de los pies para volver a la posición inicial.\n\nConsejos técnicos:\n• Los talones elevados permiten un torso más erguido y mayor recorrido de rodilla.\n• Mantén las rodillas alineadas con los dedos del pie durante todo el movimiento.\n• Comienza con una elevación pequeña y auméntala a medida que mejore la movilidad.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'heel-elevated-squat.webp'),
(213,'Peso Muerto con Barra Hexagonal','Hex Bar Deadlift','Un peso muerto de pie dentro de una barra hexagonal, manteniendo la carga centrada para un tirón más erguido y amable con la espalda.\n\nInstrucciones de ejecución:\n1. Colócate dentro de una barra trampa cargada con los pies a la anchura de los hombros.\n2. Flexiona caderas y rodillas para agarrar las asas.\n3. Contrae el core y mantén la espalda plana.\n4. Empuja con los talones y extiende caderas y rodillas para ponerte erguido.\n5. Bloquea en la parte alta con los hombros hacia atrás.\n6. Baja la barra al suelo de forma controlada.\n\nConsejos técnicos:\n• Mantén el pecho arriba y la espalda plana mientras ajustas el agarre.\n• Empuja el suelo en lugar de tirar de la barra con la espalda.\n• Ponte completamente erguido arriba sin inclinarte hacia atrás.\n\nMúsculos principales: erector_spinae, gluteus_maximus, quadriceps',NULL,'hex-bar-deadlift.webp'),
(214,'Prensa de piernas con pies altos','High-Foot Leg Press','Una prensa de piernas con los pies colocados altos en la plataforma, que desplaza más trabajo hacia la extensión de cadera y el glúteo mayor con la espalda apoyada.\n\nInstrucciones de ejecución:\n1. Ajusta el respaldo para que la zona lumbar permanezca apoyada y la pelvis no se redondee al bajar.\n2. Coloca ambos pies altos y aproximadamente al ancho de los hombros, alineando rodillas y puntas de los pies.\n3. Baja el carro flexionando caderas y rodillas hasta una profundidad cómoda sin despegar la zona lumbar del respaldo.\n4. Empuja con todo el pie y extiende caderas y rodillas sin bloquearlas con fuerza.\n5. Baja el carro bajo control y repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Mantén la pelvis pesada contra el respaldo; una posición alta de los pies no justifica redondear la espalda baja.\n• Mantén los talones y todo el pie apoyados en lugar de empujar solo con los dedos.\n• Elige una profundidad que conserve la posición de la pelvis.\n\nMúsculos principales: gluteus_maximus',NULL,'high-foot-leg-press.webp'),
(215,'Abducción de Cadera en Máquina','Machine Hip Abduction','Un ejercicio en máquina que trabaja los músculos de la cadera externa.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de abducción de cadera con los apoyos contra la parte externa de los muslos.\n2. Empuja las piernas hacia afuera contra la resistencia.\n3. Mantén brevemente en el punto más amplio.\n4. Vuelve a la posición inicial de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Mantén la espalda apoyada en el respaldo de la máquina.\n• Abre las piernas sin impulso, con un ritmo controlado.\n• Resiste la vuelta al centro en lugar de soltar el peso de golpe.\n\nMúsculos principales: gluteus_medius',NULL,'hip-abduction.webp'),
(216,'Aducción de cadera','Hip Adduction','Un ejercicio en máquina apretando las piernas una contra otra frente a la resistencia, aislando y fortaleciendo los aductores de la cara interna del muslo.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de aducción de cadera con la espalda contra el respaldo.\n2. Coloca las piernas contra las almohadillas con la máquina ajustada a un estiramiento cómodo.\n3. Aprieta las piernas hasta que las almohadillas se junten en el centro.\n4. Mantén brevemente la contracción en la posición completamente cerrada.\n5. Deja que las piernas se abran de vuelta con control hasta el inicio.\n6. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Elige una apertura inicial que estire sin forzar la ingle.\n• Recorre todo el rango a una velocidad uniforme y controlada.\n• No dejes que la placa de peso golpee al abrir las piernas.\n\nMúsculos principales: adductors',NULL,'hip-adduction.webp'),
(217,'Hip thrust con barra','Barbell Hip Thrust','Un ejercicio compuesto para glúteos que utiliza una barra apoyada sobre las caderas.\n\nInstrucciones de ejecución:\n1. Siéntate en el suelo con la parte superior de la espalda contra un banco y la barra sobre las caderas.\n2. Empuja las caderas hacia arriba hasta que los muslos queden paralelos al suelo.\n3. Aprieta los glúteos en la parte superior.\n4. Baja las caderas de nuevo con control.\n5. Repite.\n\nConsejos técnicos:\n• Mantén la barbilla recogida y las costillas abajo.\n• Empuja a través de los talones, no de las puntas.\n• Evita arquear la zona lumbar en la parte alta.\n\nMúsculos principales: gluteus_maximus, gluteus_medius',NULL,'hip-thrust.webp'),
(218,'Prensa de piernas horizontal','Horizontal Leg Press','Una prensa de piernas en máquina realizada en posición horizontal, que trabaja cuádriceps, glúteos e isquiotibiales.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de prensa de piernas horizontal y coloca los pies a la anchura de los hombros.\n2. Desbloquea la máquina y baja la plataforma hacia tu pecho.\n3. Empuja la plataforma de vuelta a la posición inicial.\n4. Repite.\n\nConsejos técnicos:\n• No dejes que la zona lumbar se separe del asiento.\n• Evita bloquear completamente las rodillas.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'horizontal-leg-press.webp'),
(219,'Press en banco inclinado con barra Z','Incline EZ-Bar Bench Press','Un press en banco inclinado con barra Z que trabaja la parte superior del pecho con un agarre cómodo para las articulaciones.\n\nInstrucciones de ejecución:\n1. Ajusta el banco a 30–45 grados. Agarra la barra Z con las manos en las secciones anguladas.\n2. Baja la barra hasta la parte superior del pecho.\n3. Empuja de vuelta hasta la extensión completa.\n4. Repite.\n\nConsejos técnicos:\n• La inclinación desplaza el énfasis hacia la parte superior del pectoral.\n• Controla el descenso para evitar tensión en los hombros.\n\nMúsculos principales: pectoralis_major',NULL,'incline-bench-ez-bar-press.webp'),
(220,'Press en banco inclinado con barra','Incline Barbell Bench Press','Un movimiento de press con barra en banco inclinado que trabaja la parte superior del pecho.\n\nInstrucciones de ejecución:\n1. Acuéstate en un banco inclinado a 30-45 grados.\n2. Agarra la barra ligeramente más ancha que los hombros y desrackea.\n3. Baja la barra hasta la parte superior del pecho.\n4. Empuja la barra de vuelta hasta la extensión completa.\n5. Repite.\n\nConsejos técnicos:\n• Retrae las escápulas y mantenlas pegadas al banco.\n• Evita rebotar la barra en el pecho.\n• Pide asistencia cuando trabajes con cargas pesadas.\n\nMúsculos principales: pectoralis_major',NULL,'incline-bench-press.webp'),
(221,'Curl con mancuernas en banco inclinado','Incline Dumbbell Curl','Un curl de bíceps en banco inclinado para un mayor estiramiento de la cabeza larga.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco inclinado a 45 grados con mancuernas a los lados.\n2. Deja que los brazos cuelguen rectos con las palmas hacia adelante.\n3. Sube las mancuernas hacia los hombros.\n4. Baja con control hasta la extensión completa.\n5. Repite.\n\nConsejos técnicos:\n• Mantén los hombros y la espalda apoyados en el banco.\n• No adelantes los hombros al subir las mancuernas.\n• Aprovecha el estiramiento abajo con una bajada lenta.\n\nMúsculos principales: biceps_brachii',NULL,'incline-db-curl.webp'),
(222,'Press con mancuernas en banco inclinado','Incline Dumbbell Press','Un movimiento de press en banco inclinado que enfatiza la parte superior del pecho.\n\nInstrucciones de ejecución:\n1. Ajusta el banco a 30 grados de inclinación y siéntate con las mancuernas a la altura de los hombros.\n2. Empuja las mancuernas hacia arriba y juntas hasta que los brazos estén completamente extendidos.\n3. Baja las mancuernas de vuelta a la altura de los hombros con control.\n4. Repite.\n\nConsejos técnicos:\n• Mantén los pies firmes en el suelo y las escápulas retraídas.\n• Evita chocar las mancuernas en la parte alta.\n• Baja hasta sentir un estiramiento suave en el pecho.\n\nMúsculos principales: pectoralis_major',NULL,'incline-db-press.webp'),
(223,'Apertura con mancuernas en banco inclinado','Incline Dumbbell Fly','Un ejercicio de aislamiento en banco inclinado que abre las mancuernas en un arco amplio, estirando y trabajando el pecho superior.\n\nInstrucciones de ejecución:\n1. Acuéstate en un banco inclinado con mancuernas sobre el pecho.\n2. Sube las mancuernas con las palmas enfrentadas.\n3. Mantén una ligera flexión en los codos durante todo el movimiento.\n4. Baja las mancuernas en un arco amplio hasta sentir el estiramiento del pecho.\n5. Aprieta el pecho para juntar las mancuernas de nuevo.\n6. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Mantén una ligera flexión fija en los codos en todo momento.\n• Baja solo hasta donde permita un estiramiento cómodo del pecho.\n• Aprieta el pecho para volver a juntar las mancuernas.\n\nMúsculos principales: pectoralis_major',NULL,'incline-dumbbell-fly.webp'),
(224,'Curl martillo en banco inclinado','Incline Hammer Curl','Un curl martillo realizado en banco inclinado para mayor estiramiento y activación de la cabeza larga del bíceps.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco inclinado con mancuernas en agarre neutro.\n2. Deja que los brazos cuelguen rectos.\n3. Sube las mancuernas en un movimiento de martillo.\n4. Baja lentamente.\n5. Repite.\n\nConsejos técnicos:\n• La inclinación proporciona un mayor estiramiento.\n• Evita balancear el cuerpo.\n\nMúsculos principales: biceps_brachii, brachialis',NULL,'incline-hammer-curl.webp'),
(225,'Push-up inclinado','Incline Push-Up','Una variación del push-up apta para principiantes con las manos elevadas sobre un banco o escalón.\n\nInstrucciones de ejecución:\n1. Coloca las manos sobre un banco o superficie elevada, a la anchura de los hombros.\n2. Extiende las piernas hacia atrás en posición de plancha.\n3. Baja el pecho hacia el banco flexionando los codos.\n4. Empuja de vuelta a la posición inicial.\n5. Repite.\n\nConsejos técnicos:\n• Aprieta el abdomen para que la cadera no se hunda.\n• Cuanto más alta la superficie, más fácil el ejercicio.\n• Asegúrate de que el banco no se mueva antes de empezar.\n\nMúsculos principales: pectoralis_major',NULL,'incline-push-ups.webp'),
(226,'Remo invertido','Inverted Row','Un ejercicio de jalón horizontal con el peso corporal realizado bajo una barra fija, tirando del pecho hacia la barra mientras se mantiene el cuerpo rígido.\n\nInstrucciones de ejecución:\n1. Coloca una barra en un rack a la altura de la cintura aproximadamente.\n2. Acuéstate debajo y agarra la barra ligeramente más ancha que los hombros con agarre prono.\n3. Cuélgate con los brazos extendidos, los talones en el suelo y el cuerpo recto de la cabeza a los tobillos.\n4. Tira del pecho hacia la barra, apretando los omóplatos.\n5. Bájate con control hasta que los brazos estén completamente extendidos.\n6. Repite.\n\nConsejos técnicos:\n• Mantén el core contraído — sin que las caderas se hundan.\n• Para hacerlo más difícil, eleva los pies; para hacerlo más fácil, camina los pies hacia la barra.\n• Haz una breve pausa en la parte superior con el pecho contra la barra.\n\nMúsculos principales: latissimus_dorsi, rhomboids, trapezius',NULL,'inverted-row.webp'),
(227,'Abdominal navaja','Jackknife Sit-Up','Un crunch de cuerpo completo realizado desde el suelo, levantando las piernas y el torso simultáneamente para tocar las manos con los pies.\n\nInstrucciones de ejecución:\n1. Acuéstate boca arriba en el suelo con los brazos extendidos por encima de la cabeza y las piernas estiradas.\n2. Levanta simultáneamente el torso y las piernas rectas del suelo.\n3. Lleva las manos hacia los pies mientras estos suben — encuéntralos sobre las caderas.\n4. Baja el torso y las piernas de vuelta al suelo con control.\n5. Repite el número recomendado de repeticiones.\n\nConsejos técnicos:\n• Brazos y piernas se mueven a la misma velocidad — evita hacer trampa levantando primero las piernas.\n• Si la zona lumbar se arquea al bajar, reduce la velocidad y no toques completamente el suelo.\n\nMúsculos principales: rectus_abdominis',NULL,'jackknife-sit-up.webp'),
(228,'Jefferson curl','Jefferson Curl','Un ejercicio de flexión espinal con carga: de pie y con un peso ligero, redondeas la columna vértebra a vértebra y la vuelves a apilar, desarrollando control segmentario y flexibilidad de isquiotibiales y erectores bajo carga.\n\nInstrucciones de ejecución:\n1. Ponte de pie sujetando una mancuerna ligera con los brazos estirados, pies aproximadamente al ancho de las caderas.\n2. Mete la barbilla y empieza a redondear la columna desde arriba, vértebra a vértebra.\n3. Baja despacio dejando colgar el peso y manteniendo las piernas casi rectas.\n4. Llega abajo con la espalda totalmente redondeada y un estiramiento en los isquiotibiales.\n5. Invierte el movimiento, reapilando la columna de abajo hacia arriba hasta ponerte de pie.\n\nConsejos técnicos:\n• Usa un peso muy ligero: es un ejercicio de movilidad controlado, no un levantamiento pesado.\n• Redondea segmento a segmento; no bisagres desde la cadera como en un peso muerto rígido.\n• Muévete despacio y nunca rebotes abajo.\n\nMúsculos principales: erector_spinae, hamstrings',NULL,'jefferson-curl.webp'),
(229,'Sentadilla con Salto','Jump Squat','Una sentadilla pliométrica con peso corporal donde explotas hacia arriba en un salto vertical.\n\nInstrucciones de ejecución:\n1. Mantente con los pies a la anchura de los hombros.\n2. Baja a una media sentadilla con los brazos atrás.\n3. Explota hacia arriba, balanceando los brazos y saltando lo más alto posible.\n4. Aterriza suave en media sentadilla para absorber el impacto.\n5. Repite sin pausa el número de repeticiones indicado.\n\nConsejos técnicos:\n• Aterriza suave con las rodillas flexionadas.\n• Lanza los brazos arriba para ganar altura en el salto.\n• Mantén el pecho arriba — no dejes que el torso colapse.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'jump-squat.webp'),
(230,'Saltos de Tijera','Jumping Jacks','Este clásico ejercicio dinámico de cuerpo completo eleva la frecuencia cardíaca y trabaja pantorrillas, hombros, cuádriceps y glúteos, siendo excelente para calentar o acondicionar.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies juntos y los brazos a los lados.\n2. Simultáneamente, salta abriendo las piernas y levantando los brazos por encima de la cabeza.\n3. Asegúrate de que tus brazos se junten o casi se junten por encima de tu cabeza.\n4. Salta juntando los pies de nuevo mientras bajas los brazos a los lados.\n5. Mantén un movimiento continuo y rítmico.\n\nConsejos técnicos:\n• Aterriza suavemente sobre las puntas de los pies para absorber el impacto.\n• Mantén tu core activado durante todo el movimiento.\n• Controla tu respiración; inhala al saltar hacia afuera, exhala al saltar hacia adentro.\n• Aumenta la velocidad para un mayor desafío cardiovascular.\n\nMúsculos principales: gastrocnemius, gluteus_medius, lateral_deltoid',NULL,'jumping-jacks.webp'),
(231,'Sentadilla Búlgara con Kettlebell','Kettlebell Bulgarian Split Squat','Esta variación unilateral de sentadilla desarrolla fuerza, músculo y estabilidad en la parte inferior del cuerpo al elevar el pie trasero y sostener una kettlebell, apuntando principalmente a los cuádriceps y glúteos.\n\nInstrucciones de ejecución:\n1. Párate de espaldas a un banco, colocando un pie sobre él detrás de ti, con los cordones hacia abajo. Sostén una kettlebell en la mano opuesta.\n2. Mantén el torso erguido y activa tu core.\n3. Baja tu cuerpo doblando ambas rodillas, permitiendo que tu rodilla delantera se alinee con tus dedos del pie.\n4. Desciende hasta que tu muslo delantero esté paralelo al suelo o ligeramente por debajo, manteniendo tu rodilla trasera cerca del suelo.\n5. Impúlsate a través del talón delantero para regresar a la posición inicial, extendiendo tus caderas y rodillas.\n6. Completa todas las repeticiones por lado antes de cambiar.\n\nConsejos técnicos:\n• Asegúrate de que tu pie delantero esté lo suficientemente lejos del banco para permitir un rango completo de movimiento sin molestias.\n• Mantén tu torso erguido durante todo el movimiento para maximizar la activación de glúteos y cuádriceps.\n• Controla la fase excéntrica (descenso) para desarrollar fuerza y estabilidad.\n• Experimenta sosteniendo la kettlebell en la misma mano que la pierna que trabaja (ipsilateral) o en la mano opuesta (contralateral) para diferentes desafíos.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'kettlebell-bulgarian-split-squat.webp'),
(232,'Press de Suelo con Agarre Cerrado con Pesa Rusa','Kettlebell Close-Grip Floor Press','Un press de suelo con una sola pesa rusa agarrada con ambas manos juntas, que desplaza el énfasis del pecho a los tríceps.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba en el suelo con las rodillas flexionadas y los pies apoyados.\n2. Sujeta una única pesa rusa por el asa con ambas manos juntas, con la pesa apoyada en el pecho y los codos bien pegados a las costillas.\n3. Activa el core y empuja la pesa rusa recto hacia arriba hasta estirar del todo los brazos.\n4. Baja de forma controlada hasta que la parte alta de los brazos toque el suelo y haz una breve pausa.\n5. Vuelve a empujar hacia arriba hasta la extensión completa.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Mantén los codos pegados a unos 30–45 grados del torso; abrirlos lo convierte en press de pecho.\n• La breve pausa al tocar el suelo con los codos elimina el rebote y fuerza un empuje limpio.\n• Elige una pesa que puedas controlar con dos manos; el agarre estrecho no perdona si se ladea.\n\nMúsculos principales: triceps_brachii',NULL,'kettlebell-close-grip-floor-press.webp'),
(233,'Curl de concentración con kettlebell','Kettlebell Concentration Curl','Un ejercicio de aislamiento de bíceps a una mano, sentado: el codo se apoya contra la cara interna del muslo mientras se curla una kettlebell, manteniendo el brazo quieto para que el bíceps haga todo el trabajo.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con los pies bien separados, sujetando una kettlebell con una mano.\n2. Apoya la parte posterior del brazo contra la cara interna del muslo y deja colgar la kettlebell.\n3. Curla la kettlebell hacia el hombro, manteniendo el codo fijo contra la pierna.\n4. Contrae el bíceps arriba y luego baja despacio y de forma controlada.\n5. Termina todas las repeticiones de un lado y cambia de brazo.\n\nConsejos técnicos:\n• Mantén el brazo fijo y quieto: solo el antebrazo se mueve.\n• Rota ligeramente la muñeca al curlar para una contracción máxima más fuerte.\n• Usa un peso más ligero que en un curl normal: aquí importa más la técnica estricta.\n\nMúsculos principales: biceps_brachii',NULL,'kettlebell-concentration-curl.webp'),
(234,'Peso muerto con pesa rusa','Kettlebell Deadlift','Un peso muerto con pesa rusa que fortalece glúteos, isquiotibiales y zona lumbar con un patrón de bisagra de cadera.\n\nInstrucciones de ejecución:\n1. Párate con los pies a la anchura de los hombros y la pesa rusa entre los pies.\n2. Bisagra en las caderas y flexiona las rodillas para agarrar el asa.\n3. Contrae el core y mantén la espalda plana.\n4. Empuja a través de los talones para ponerte de pie con la pesa rusa.\n5. Bloquea en la parte superior con los hombros hacia atrás.\n6. Baja la pesa rusa de vuelta al suelo con control.\n\nConsejos técnicos:\n• Mantén la pesa rusa cerca del cuerpo durante todo el recorrido.\n• Piensa en empujar el suelo con los talones, no en tirar con la espalda.\n• Lleva las caderas atrás, no las rodillas adelante, al bajar.\n\nMúsculos principales: erector_spinae, gluteus_maximus, hamstrings',NULL,'kettlebell-deadlift.webp'),
(235,'Press de suelo con pesas rusas','Kettlebell Floor Press','Un press de pecho con dos brazos realizado tumbado en el suelo con una pesa rusa en cada mano. El suelo limita el rango de movimiento (los tríceps tocan el suelo antes del estiramiento completo), haciéndolo amigable para los hombros y una excelente opción en casa.\n\nInstrucciones de ejecución:\n1. Acuéstate boca arriba en el suelo con las rodillas flexionadas y los pies apoyados.\n2. Sostén una pesa rusa en cada mano a la altura del pecho, con las campanas apoyadas en el antebrazo externo.\n3. Empuja ambas pesas rusas hacia arriba hasta que los brazos estén completamente extendidos.\n4. Baja con control hasta que los tríceps toquen el suelo — no rebotes.\n5. Repite el número recomendado de repeticiones.\n\nConsejos técnicos:\n• Los codos se mantienen a unos 45 grados del torso; no los abras.\n• El agarre importa: mantén las campanas estables contra el exterior de los antebrazos.\n• El suelo limita el rango de movimiento por diseño — esta es la ventaja, no el problema.\n\nMúsculos principales: pectoralis_major',NULL,'kettlebell-floor-press.webp'),
(236,'Zancada Goblet con Kettlebell','Kettlebell Goblet Lunge','Este ejercicio compuesto unilateral fortalece los cuádriceps, glúteos e isquiotibiales al realizar una zancada con una kettlebell en posición de copa, mejorando la fuerza y estabilidad del tren inferior.\n\nInstrucciones de ejecución:\n1. Ponte de pie sosteniendo una kettlebell por sus cuernos a la altura del pecho, con los codos pegados al cuerpo, en la posición de copa.\n2. Da un paso controlado hacia adelante con una pierna, bajando las caderas hasta que ambas rodillas estén flexionadas aproximadamente a 90 grados.\n3. Asegúrate de que tu rodilla delantera esté alineada sobre tu tobillo y tu rodilla trasera flote justo por encima del suelo.\n4. Impúlsate a través del talón de tu pie delantero para volver a la posición inicial, manteniendo el equilibrio y la tensión del core.\n5. Completa todas las repeticiones por lado antes de cambiar, o alterna las piernas por serie.\n\nConsejos técnicos:\n• Mantén el pecho erguido y el core contraído durante todo el movimiento para proteger tu columna y mantener la estabilidad.\n• Concéntrate en un descenso controlado y un impulso potente hacia arriba, activando tus glúteos y cuádriceps.\n• Evita que tu rodilla delantera se colapse hacia adentro; mantenla alineada con tus dedos del pie.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'kettlebell-goblet-lunge.webp'),
(237,'Halo con pesa rusa','Kettlebell Halo','Un ejercicio de movilidad de hombros donde se hace girar una pesa rusa alrededor de la cabeza. Calienta el manguito rotador, la columna torácica y la cintura escapular con carga mínima.\n\nInstrucciones de ejecución:\n1. Párate erguido con el core contraído, sosteniendo una pesa rusa ligera por las asas (boca abajo) a la altura del pecho.\n2. Sube la campana a un lado de la cabeza y hazla pasar por detrás en un círculo suave.\n3. Tráela de vuelta a la posición inicial frente a tu cara.\n4. Invierte la dirección cada pocas repeticiones.\n5. Repite el número recomendado de repeticiones o tiempo.\n\nConsejos técnicos:\n• Solo peso ligero — esto es movilidad, no fuerza.\n• Mantén la cabeza quieta; la campana gira alrededor, no la cabeza.\n• Si la campana se aleja, reduce el círculo — órbita ajustada, cerca del cráneo.\n\nMúsculos principales: lateral_deltoid',NULL,'kettlebell-halo.webp'),
(238,'Curl martillo con pesa rusa','Kettlebell Hammer Curl','Un curl con agarre neutro sosteniendo el asa de una pesa rusa de modo que la campana cuelgue junto a la muñeca. La masa descentrada y el agarre neutro trabajan principalmente el braquial y el braquiorradial.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo una pesa rusa en una mano, agarrando el asa en posición neutra (palma hacia el cuerpo).\n2. La campana descansa sobre o junto al antebrazo.\n3. Mantén el codo pegado al costado y sube la campana hacia el hombro.\n4. Aprieta en la parte superior y baja con control.\n5. Completa todas las repeticiones en un lado y luego cambia.\n\nConsejos técnicos:\n• Controla la masa descentrada — la campana tiende a rotar en la parte inferior del recorrido.\n• El codo se mantiene quieto; solo el antebrazo se mueve.\n• Carga ligera — esto trabaja el braquial, no el volumen máximo del bíceps.\n\nMúsculos principales: biceps_brachii, brachialis',NULL,'kettlebell-hammer-curl.webp'),
(239,'Empuje de Cadera con Kettlebell','Kettlebell Hip Thrust','Este ejercicio trabaja eficazmente el glúteo mayor y los isquiotibiales, utilizando una kettlebell para añadir resistencia y lograr una potente extensión de cadera y desarrollo de glúteos.\n\nInstrucciones de ejecución:\n1. Siéntate en el suelo con la parte superior de tu espalda apoyada en un banco, las rodillas flexionadas y los pies planos.\n2. Coloca una kettlebell sobre tus caderas, sujetándola firmemente con ambas manos.\n3. Impúlsate a través de tus talones, levantando tus caderas del suelo hasta que tu cuerpo forme una línea recta desde los hombros hasta las rodillas.\n4. Contrae tus glúteos con fuerza en la parte superior del movimiento.\n5. Baja lentamente tus caderas de vuelta a la posición inicial con control.\n\nConsejos técnicos:\n• Mantén tu barbilla pegada al pecho para mantener una columna vertebral neutra.\n• Concéntrate en empujar a través de tus talones para maximizar la activación de los glúteos.\n• Asegúrate de que tus rodillas sigan la línea de tus dedos de los pies durante todo el movimiento.\n• Controla la fase excéntrica, resistiendo el peso mientras bajas tus caderas.\n\nMúsculos principales: gluteus_maximus',NULL,'kettlebell-hip-thrust.webp'),
(240,'Peso Muerto Kickstand con Kettlebell','Kettlebell Kickstand Deadlift','Un movimiento de bisagra de cadera en postura escalonada con una kettlebell que carga la pierna delantera mientras el pie trasero estabiliza.\n\nInstrucciones de ejecución:\n1. Coloca un pie detrás de modo que solo los dedos toquen el suelo.\n2. Sostén una kettlebell en la mano del lado del pie trasero.\n3. Bisagra en la cadera bajando la kettlebell hacia la espinilla con la espalda recta.\n4. Mantén la mayor parte del peso en el pie delantero.\n5. Empuja con el talón delantero para volver a la posición inicial. Cambia de lado.\n\nConsejos técnicos:\n• Mantén la kettlebell cerca de la pierna.\n• Para al sentir el estiramiento en el isquiotibial.\n• Todas las repeticiones en un lado antes de cambiar.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'kettlebell-kickstand-deadlift.webp'),
(241,'Zancada con press de pesa rusa','Kettlebell Lunge Press','Un ejercicio de cuerpo completo que combina una zancada con un press de pesa rusa a un brazo.\n\nInstrucciones de ejecución:\n1. Sostén una pesa rusa a la altura del hombro con un brazo.\n2. Da un paso adelante en zancada con la pierna contraria.\n3. Mientras haces la zancada, empuja la pesa rusa por encima de la cabeza.\n4. Bloquea el brazo en la parte superior del press.\n5. Da un paso atrás de vuelta a la posición de pie mientras bajas la pesa rusa.\n6. Completa las repeticiones en un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén el abdomen firme para no inclinarte hacia el lado cargado.\n• La rodilla delantera debe apuntar en la dirección del pie.\n• Empieza con poco peso hasta dominar la coordinación del movimiento.\n\nMúsculos principales: anterior_deltoid, gluteus_maximus, quadriceps',NULL,'kettlebell-lunge-press.webp'),
(242,'Zancada inversa con press desequilibrado de pesa rusa','Kettlebell Offset Reverse Lunge and Press','Una zancada inversa combinada con un press de pesa rusa a un brazo, con carga descompensada que exige estabilidad del core.\n\nInstrucciones de ejecución:\n1. Sostén una pesa rusa a la altura del hombro en un lado.\n2. Da un paso hacia atrás en zancada inversa con la pierna contraria.\n3. Al llegar a la parte inferior de la zancada, empuja la pesa rusa por encima de la cabeza.\n4. Empuja con el talón delantero para volver a ponerte de pie.\n5. Baja la pesa rusa de vuelta a la altura del hombro.\n6. Completa las repeticiones en un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén el torso erguido frente a la carga descompensada.\n• Bloquea el codo arriba con la muñeca firme y recta.\n• Si pierdes el equilibrio, acorta un poco el paso atrás.\n\nMúsculos principales: anterior_deltoid, gluteus_maximus, quadriceps',NULL,'kettlebell-offset-reverse-lunge-and-press.webp'),
(243,'Extensión de tríceps por encima de la cabeza con pesa rusa','Kettlebell Overhead Tricep Extension','Una extensión de tríceps por encima de la cabeza sosteniendo una pesa rusa por las asas con ambas manos. La carga descentrada jala la campana detrás de la cabeza para un estiramiento profundo de la cabeza larga.\n\nInstrucciones de ejecución:\n1. Párate o siéntate sosteniendo una pesa rusa por las asas (boca abajo) con ambas manos por encima de la cabeza.\n2. Brazos completamente extendidos, campana sobre la cabeza.\n3. Flexiona solo los codos para bajar la campana detrás de la cabeza en un arco controlado.\n4. Mantén los brazos verticales y pegados a la cabeza; solo los antebrazos se mueven.\n5. Extiende los codos para devolver la campana por encima de la cabeza.\n6. Repite el número recomendado de repeticiones.\n\nConsejos técnicos:\n• Agarra las asas firmemente — la campana tiende a rotar en la parte inferior.\n• Los codos se mantienen pegados; si se abren, reduce la carga.\n• Una versión sentado en un banco con respaldo es más fácil para la zona lumbar.\n\nMúsculos principales: triceps_brachii',NULL,'kettlebell-overhead-tricep-extension.webp'),
(244,'Sentadilla pistola con pesa rusa','Kettlebell Pistol Squat','Una sentadilla a una pierna con la pesa rusa al pecho que exige fuerza y equilibrio avanzados.\n\nInstrucciones de ejecución:\n1. Sostén una pesa rusa a la altura del pecho con ambas manos.\n2. Párate en una pierna con la otra extendida hacia adelante.\n3. Baja las caderas en una sentadilla a una sola pierna.\n4. Mantén la pierna elevada fuera del suelo durante todo el movimiento.\n5. Empuja a través del talón de apoyo para volver a ponerte de pie.\n6. Completa las repeticiones en un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén la pesa rusa cerca del pecho como contrapeso.\n• Baja despacio para no desplomarte en la parte final.\n• El talón de apoyo no se despega del suelo.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'kettlebell-pistol-squat.webp'),
(245,'Pullover con pesa rusa','Kettlebell Pullover','Un pullover en banco plano con una pesa rusa sostenida por las asas. El profundo estiramiento por encima de la cabeza trabaja los dorsales, el tríceps (cabeza larga) y el serrato.\n\nInstrucciones de ejecución:\n1. Acuéstate en un banco plano sosteniendo una pesa rusa por las asas con ambas manos sobre el pecho, brazos casi rectos (ligera flexión de codos).\n2. Con el ángulo de los codos fijo, baja la campana por encima de la cabeza en arco hasta que los brazos estén en línea con el torso.\n3. Tira de la campana de vuelta sobre el pecho siguiendo el mismo arco.\n4. Repite el número recomendado de repeticiones.\n\nConsejos técnicos:\n• Mantén la zona lumbar presionada contra el banco — no arquees para ganar recorrido.\n• Agarra las asas con fuerza; la campana intentará voltearse en la parte inferior.\n• Baja solo hasta donde tu movilidad de hombros lo permita sin dolor.\n\nMúsculos principales: latissimus_dorsi, pectoralis_major',NULL,'kettlebell-pullover.webp'),
(246,'Zancada Inversa con Kettlebell','Kettlebell Reverse Lunge','Este ejercicio compuesto unilateral desarrolla fuerza y estabilidad en la parte inferior del cuerpo, trabajando principalmente glúteos y cuádriceps, e involucrando isquiotibiales, glúteo medio y oblicuos.\n\nInstrucciones de ejecución:\n1. Ponte de pie con una kettlebell en una mano, el brazo extendido hacia abajo, en el mismo lado de la pierna que retrocederá.\n2. Da un paso hacia atrás con una pierna, bajando las caderas hasta que ambas rodillas estén flexionadas aproximadamente a 90 grados.\n3. Mantén la espinilla delantera vertical y el pecho erguido, asegurándote de que la rodilla trasera flote justo por encima del suelo.\n4. Impúlsate a través del talón delantero para volver a la posición inicial.\n5. Completa todas las repeticiones por lado antes de cambiar al otro lado.\n\nConsejos técnicos:\n• Mantén un core estable durante todo el movimiento para proteger tu columna vertebral.\n• Concéntrate en un descenso controlado y un ascenso potente.\n• Mantén el pie delantero plano y distribuye el peso uniformemente entre el talón y la parte media del pie.\n• Evita que la rodilla delantera se colapse hacia adentro; mantenla alineada con los dedos del pie.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'kettlebell-reverse-lunge.webp'),
(247,'Curl de Muñeca Inverso con Kettlebell','Kettlebell Reverse Wrist Curl','Un curl de muñeca inverso unilateral con kettlebell, que entrena los extensores del antebrazo.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con el antebrazo sobre el muslo, palma hacia abajo.\n2. Sujeta una kettlebell por el asa, muñeca fuera de la rodilla.\n3. Deja caer la muñeca, bajando la kettlebell.\n4. Levanta el dorso de la mano extendiendo la muñeca.\n5. Baja con control. Repeticiones por lado.\n\nConsejos técnicos:\n• Usa una kettlebell muy ligera — los extensores se fatigan rápido.\n• Mueve solo la muñeca.\n• Sujeta el asa, no la bola.\n\nMúsculos principales: forearm_extensors',NULL,'kettlebell-reverse-wrist-curl.webp'),
(248,'Zancada rotacional con pesa rusa','Kettlebell Rotational Lunge','Una zancada lateral con pesa rusa y rotación del torso que trabaja piernas, glúteos y oblicuos en varios planos.\n\nInstrucciones de ejecución:\n1. Sostén una pesa rusa con ambas manos a la altura del pecho.\n2. Da un paso hacia un lado en una zancada lateral.\n3. Rota el torso hacia la pierna que hace la zancada.\n4. Lleva la pesa rusa hacia la rodilla flexionada.\n5. Empuja con la pierna de la zancada para volver al centro.\n6. Completa las repeticiones en un lado y luego cambia.\n\nConsejos técnicos:\n• Gira desde el torso, no desde las rodillas.\n• Mantén la espalda larga al bajar la pesa hacia la rodilla.\n• Controla la rotación, sin movimientos bruscos.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'kettlebell-rotational-lunge.webp'),
(249,'Giro ruso con pesa rusa','Kettlebell Russian Twist','Un Russian Twist con pesa rusa realizado sentado con los pies en el aire, que entrena los oblicuos mediante rotaciones del torso.\n\nInstrucciones de ejecución:\n1. Siéntate en el suelo con las rodillas flexionadas y los pies levantados del suelo.\n2. Sostén una pesa rusa con ambas manos frente al pecho.\n3. Inclínate ligeramente hacia atrás para activar el core.\n4. Rota el torso hacia un lado llevando la pesa rusa junto a la cadera.\n5. Rota hacia el lado opuesto en un movimiento controlado.\n6. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Gira los hombros, no solo los brazos.\n• Mantén la espalda recta aunque el torso esté inclinado hacia atrás.\n• Apoya los pies en el suelo si te cuesta mantener el equilibrio.\n\nMúsculos principales: obliques',NULL,'kettlebell-russian-twist.webp'),
(250,'Encogimiento de Hombros con Kettlebell','Kettlebell Shrug','Este ejercicio de aislamiento trabaja los músculos trapecios superiores elevando los hombros, mejorando la estabilidad del hombro y la fuerza del cuello.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies al ancho de las caderas, sosteniendo una kettlebell en cada mano con las palmas hacia tu cuerpo.\n2. Mantén los brazos rectos y los hombros relajados.\n3. Eleva los hombros directamente hacia tus orejas, contrayendo los trapecios en la parte superior.\n4. Mantén la contracción brevemente.\n5. Baja lentamente los hombros a la posición inicial con control.\n6. Repite el movimiento para el número deseado de repeticiones.\n\nConsejos técnicos:\n• Concéntrate en mover solo los hombros, manteniendo los brazos rectos durante todo el movimiento.\n• Evita rodar los hombros; muévelos directamente hacia arriba y hacia abajo.\n• Mantén una columna vertebral neutra y el core activado para prevenir la tensión en la espalda baja.\n• Usa un peso que permita un rango completo de movimiento y una ejecución controlada.\n\nMúsculos principales: trapezius',NULL,'kettlebell-shrug.webp'),
(251,'Peso muerto a una pierna con pesa rusa','Kettlebell Single Leg Deadlift','Un peso muerto a una pierna con pesa rusa que fortalece glúteos e isquiotibiales y pone a prueba el equilibrio.\n\nInstrucciones de ejecución:\n1. Sostén una pesa rusa en una mano y párate en la pierna contraria.\n2. Bisagra en la cadera y baja la pesa rusa hacia el suelo.\n3. Extiende la pierna libre hacia atrás para mantener el equilibrio.\n4. Baja hasta que el torso quede paralelo al suelo.\n5. Empuja a través del talón de apoyo para volver a ponerte de pie.\n6. Completa las repeticiones en un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén la cadera cuadrada, sin abrirla hacia el lado libre.\n• Fija la mirada en un punto del suelo para equilibrarte mejor.\n• Flexiona ligeramente la rodilla de apoyo durante la bisagra.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'kettlebell-single-leg-deadlift.webp'),
(252,'Skull crusher con pesa rusa','Kettlebell Skull Crusher','Un skull crusher tumbado en un banco plano, sosteniendo una pesa rusa por las asas con ambas manos. La masa descentrada cuelga por debajo de las muñecas, añadiendo un reto de agarre y control.\n\nInstrucciones de ejecución:\n1. Acuéstate en un banco plano sosteniendo una pesa rusa por las asas con ambas manos, brazos extendidos sobre el pecho.\n2. Flexiona solo los codos para bajar la campana hacia la frente en un arco controlado.\n3. Mantén los brazos verticales; solo los antebrazos se mueven.\n4. Extiende los codos para empujar la campana de vuelta arriba.\n5. Repite el número recomendado de repeticiones.\n\nConsejos técnicos:\n• Agarra las asas firmemente — la campana tiende a rotar hacia adelante en la parte inferior.\n• Los codos se mantienen pegados — si se abren, la carga es demasiado pesada.\n• Inclina los brazos ligeramente hacia atrás en dirección a la cabeza para mantener tensión en los tríceps al bloquear.\n\nMúsculos principales: triceps_brachii',NULL,'kettlebell-skull-crusher.webp'),
(253,'Sentadilla con Kettlebell','Kettlebell Squat','Una variante de sentadilla sosteniendo una kettlebell con ambas manos colgando baja entre las piernas, añadiendo carga a un patrón de sentadilla estándar.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies separados al ancho de los hombros, sosteniendo una kettlebell con ambas manos frente a ti.\n2. Deja que la kettlebell cuelgue naturalmente entre tus piernas mientras contraes el core.\n3. Flexiona las caderas y las rodillas para bajar en sentadilla, manteniendo la kettlebell cerca del cuerpo.\n4. Empuja con los pies para volver a la posición inicial.\n5. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Mantén el pecho arriba y la espalda recta durante todo el movimiento.\n• Usa la kettlebell como contrapeso para ayudarte a bajar más profundo en la sentadilla.\n• Empuja las rodillas hacia afuera, en línea con los dedos de los pies, al descender.\n\nMúsculos principales: quadriceps',NULL,'kettlebell-squat.webp'),
(254,'Peso muerto sumo con pesa rusa','Kettlebell Sumo Deadlift','Un peso muerto con postura amplia usando una sola pesa rusa entre los pies. La postura amplia y la carga cerca del cuerpo hacen de este un patrón dominante de cuádriceps y glúteos que es fácil de aprender.\n\nInstrucciones de ejecución:\n1. Párate con una postura amplia y los pies ligeramente girados hacia afuera, con una pesa rusa en el suelo entre los pies.\n2. Baja con la espalda plana, las rodillas alineadas con los pies, y agarra el asa con ambas manos.\n3. Empuja el suelo y extiende caderas y rodillas juntas para ponerte de pie.\n4. Aprieta los glúteos en la parte superior.\n5. Baja la campana con control de vuelta al suelo empujando las caderas hacia atrás.\n6. Repite el número recomendado de repeticiones.\n\nConsejos técnicos:\n• Las rodillas se alinean con los pies — no dejes que colapsen hacia adentro.\n• Los hombros permanecen por encima de las caderas en la parte inferior; si los hombros caen, estrecha la postura.\n• Mantén la campana cerca del cuerpo durante todo el levantamiento.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'kettlebell-sumo-deadlift.webp'),
(255,'Jalón sumo al mentón con pesa rusa','Kettlebell Sumo High Pull','Un jalón con pesa rusa desde el suelo hasta la altura del mentón con postura amplia, combinando una bisagra con un remo en pie para desarrollar el trapecio superior de forma explosiva.\n\nInstrucciones de ejecución:\n1. Párate con los pies más anchos que los hombros, los dedos ligeramente girados hacia afuera y una pesa rusa en el suelo entre los pies.\n2. Bisagra hacia abajo y agarra el asa con ambas manos.\n3. Empuja con los pies y extiende las caderas de forma explosiva para jalar la pesa rusa hacia arriba.\n4. Al subir, lleva los codos hacia arriba y afuera hasta que el asa alcance la altura del mentón.\n5. Baja la pesa rusa de vuelta entre las piernas con control.\n6. Repite el número recomendado de repeticiones.\n\nConsejos técnicos:\n• Impulsa primero con las caderas; los brazos terminan el movimiento.\n• Mantén los codos más altos que las manos en la parte superior — piensa: ancho y alto, no estrecho.\n\nMúsculos principales: adductors, lateral_deltoid, trapezius',NULL,'kettlebell-sumo-high-pull.webp'),
(256,'Press Svend con Kettlebells','Kettlebell Svend Press','Un ejercicio de pecho de pie presionando dos kettlebells unidas por las bolas, aísla el pecho interno.\n\nInstrucciones de ejecución:\n1. De pie, junta dos kettlebells por las bolas a la altura del pecho.\n2. Mantén las kettlebells horizontales — bolas tocándose, asas hacia afuera.\n3. Empuja las kettlebells al frente hasta extender los brazos.\n4. Tíralas de regreso al pecho con control.\n5. Repite el número de repeticiones indicado.\n\nConsejos técnicos:\n• La presión entre las bolas hace el ejercicio.\n• Usa kettlebells muy ligeras — el agarre incómodo dicta la carga.\n• Mantén los codos ligeramente flexionados en el lockout.\n\nMúsculos principales: pectoralis_major',NULL,'kettlebell-svend-press.webp'),
(257,'Swing y cargada con pesa rusa','Kettlebell Swing Clean','Un clean con pesa rusa iniciado desde el swing, que lleva el peso hasta la posición de rack en el hombro.\n\nInstrucciones de ejecución:\n1. Párate con los pies a la anchura de los hombros y la pesa rusa entre los pies.\n2. Bisagra en las caderas y agarra el asa con una mano.\n3. Balancea la pesa rusa hacia atrás entre las piernas.\n4. Extiende las caderas hacia adelante para jalar la pesa rusa hasta el hombro.\n5. Recibe la pesa rusa en la posición de rack sobre el hombro.\n6. Completa las repeticiones en un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén la pesa cerca del cuerpo en la subida.\n• Recibe la pesa con suavidad, sin golpearte el antebrazo.\n• Genera la potencia con la cadera, no tirando con el brazo.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'kettlebell-swing-clean.webp'),
(258,'Swing con pesa rusa','Kettlebell Swing','Un movimiento explosivo de bisagra de cadera con pesa rusa para potencia y acondicionamiento físico.\n\nInstrucciones de ejecución:\n1. Párate con los pies a la anchura de los hombros y la pesa rusa en el suelo por delante.\n2. Bisagra en las caderas, agarra la pesa rusa y llévala hacia atrás entre las piernas.\n3. Extiende las caderas de forma explosiva para balancear la pesa rusa hasta la altura del pecho.\n4. Deja que la pesa rusa vuelva a balancearse entre las piernas.\n5. Repite en un movimiento fluido.\n\nConsejos técnicos:\n• La fuerza nace de la cadera, no de los brazos.\n• Aprieta glúteos y abdomen en la parte alta del swing.\n• Es una bisagra de cadera, no una sentadilla.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'kettlebell-swing.webp'),
(259,'Levantamiento Turco con Kettlebell','Kettlebell Turkish Get Ups','Un ejercicio de cuerpo completo con kettlebell que pasa de estar tumbado a de pie mientras se mantiene el peso bloqueado por encima de la cabeza, trabajando la fuerza, la estabilidad y la movilidad de todo el cuerpo.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba sosteniendo una kettlebell por encima de la cabeza con una mano.\n2. Flexiona la rodilla del mismo lado y apoya el pie plano.\n3. Rueda hasta apoyarte en el codo opuesto y luego en la mano.\n4. Empuja las caderas hacia arriba y lleva la pierna estirada hacia atrás a una zancada.\n5. Ponte de pie por completo manteniendo la kettlebell bloqueada por encima de la cabeza.\n6. Invierte la secuencia para volver a la posición inicial.\n\nConsejos técnicos:\n• Mantén la vista en la kettlebell hasta que estés de pie, luego mira al frente.\n• Muévete despacio en cada paso: el levantamiento es una secuencia, no un solo movimiento.\n\nMúsculos principales: anterior_deltoid, gluteus_maximus, rectus_abdominis',NULL,'kettlebell-turkish-get-ups.webp'),
(260,'Molino de Viento con Pesa Rusa','Kettlebell Windmills','Un ejercicio de pesa rusa con el brazo bloqueado por encima de la cabeza, que combina estabilidad de hombro y bisagra lateral de cadera.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo una pesa rusa bloqueada sobre la cabeza con una mano.\n2. Gira los pies unos 45 grados alejándolos del brazo de trabajo.\n3. Con la pesa rusa arriba, inclínate lateralmente desde las caderas.\n4. Lleva la mano opuesta hacia el pie.\n5. Empuja las caderas hacia atrás para volver a la posición erguida.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• No pierdas de vista la pesa durante todo el movimiento.\n• El brazo de arriba permanece bloqueado y vertical en todo momento.\n• Empieza sin peso para aprender el patrón del movimiento.\n\nMúsculos principales: adductors, anterior_deltoid, obliques',NULL,'kettlebell-windmills.webp'),
(261,'Curl de Muñeca con Kettlebell','Kettlebell Wrist Curl','Un curl de muñeca unilateral con kettlebell — el peso descentrado añade un reto extra al agarre.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con el antebrazo sobre el muslo, palma hacia arriba.\n2. Sujeta una kettlebell por el asa, muñeca fuera de la rodilla.\n3. Deja que la kettlebell rote hacia las puntas de los dedos.\n4. Súbela flexionando la muñeca, controlando el peso descentrado.\n5. Baja con control. Repeticiones por lado.\n\nConsejos técnicos:\n• Sujeta el asa, no la bola, para que el peso descentrado cargue el agarre.\n• Mueve solo la muñeca.\n• Usa una carga más ligera que con una mancuerna.\n\nMúsculos principales: forearm_flexors',NULL,'kettlebell-wrist-curl.webp'),
(262,'Push-Up en Rodillas','Knee Push Ups','Una variante de flexión apta para principiantes, con las rodillas apoyadas en el suelo para reducir la carga sobre el tren superior.\n\nInstrucciones de ejecución:\n1. Comienza en posición de push-up con las rodillas en el suelo.\n2. Coloca las manos a la anchura de los hombros en el suelo.\n3. Mantén el cuerpo en línea recta desde las rodillas hasta los hombros.\n4. Baja el pecho hacia el suelo doblando los codos.\n5. Empuja con las manos para volver a la posición inicial.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• No abras los codos en exceso hacia los lados.\n• Aprieta los glúteos y el abdomen durante todo el movimiento.\n• Mira al suelo para mantener el cuello neutro.\n\nMúsculos principales: pectoralis_major',NULL,'knee-push-ups.webp'),
(263,'Remo en Polea Arrodillado','Kneeling Cable Row','Un remo en polea ejecutado desde una posición de rodillas erguida, eliminando el impulso de cadera y manteniendo la tensión en la parte superior de la espalda durante todo el movimiento.\n\nInstrucciones de ejecución:\n1. Ajusta la polea a la altura del pecho y conecta una cuerda o un mango doble en D.\n2. Arrodíllate erguido frente a la máquina lo suficientemente lejos para que el peso no llegue al tope.\n3. Agarra el mango con ambas manos y sostenlo extendido frente a ti a la altura del pecho.\n4. Lleva el mango hacia el esternón llevando los codos hacia atrás y apretando los omóplatos.\n5. Regresa de forma controlada a la posición inicial con estiramiento.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Mantente erguido: no te inclines hacia atrás para terminar la repetición.\n• La postura de rodillas erguidas obliga al core a resistir la rotación en cada tirón.\n\nMúsculos principales: latissimus_dorsi',NULL,'kneeling-cable-row.webp'),
(264,'Press Landmine','Landmine Press','Un press de hombros a dos manos con una barra fijada en un accesorio landmine, cuyo arco natural reduce el estrés en la articulación del hombro.\n\nInstrucciones de ejecución:\n1. Inserta un extremo de la barra en el accesorio landmine y carga el extremo libre con un disco.\n2. Párate en postura escalonada o paralela y sujeta el extremo libre de la barra con ambas manos a la altura del pecho.\n3. Activa el core y empuja la barra hacia adelante y arriba siguiendo su arco natural.\n4. Extiende completamente los brazos sin bloquear los codos, luego baja con control.\n5. Mantén ambas manos en la barra y repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén el torso erguido y evita inclinarte excesivamente hacia el press.\n• La trayectoria angular es más amigable para el hombro que un press estricto sobre la cabeza.\n• Usa impulso de piernas estilo push press para cargas más pesadas.\n\nMúsculos principales: anterior_deltoid, pectoralis_major',NULL,'landmine-press.webp'),
(265,'Jalón al Pecho','Lat Pulldown','Un ejercicio en máquina de polea que trabaja el dorsal ancho.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de jalón con los muslos sujetos bajo los rodillos.\n2. Agarra la barra ancha con un agarre en pronación.\n3. Jala la barra hasta la parte superior del pecho apretando los dorsales.\n4. Regresa la barra lentamente a la posición inicial.\n5. Repite.\n\nConsejos técnicos:\n• Inicia el tirón bajando los omóplatos, no doblando los codos.\n• Evita balancear el torso para mover el peso.\n• Dirige los codos hacia abajo y atrás, no hacia fuera.\n\nMúsculos principales: latissimus_dorsi',NULL,'lat-pulldown.webp'),
(266,'Elevación Lateral con Mancuernas','Dumbbell Lateral Raise','Un movimiento de aislamiento que trabaja el deltoides lateral para ganar anchura en los hombros.\n\nInstrucciones de ejecución:\n1. Párate con mancuernas a los costados.\n2. Eleva las mancuernas hacia los lados hasta que los brazos queden paralelos al suelo.\n3. Baja de forma controlada.\n4. Repite.\n\nConsejos técnicos:\n• Ligera flexión en los codos.\n• Guía con los codos, no con las manos.\n\nMúsculos principales: lateral_deltoid',NULL,'lateral-raise.webp'),
(267,'Curl de Piernas Tumbado','Lying Leg Curl','Un ejercicio de aislamiento para los isquiotibiales usando la máquina de curl de piernas.\n\nInstrucciones de ejecución:\n1. Túmbate boca abajo en la máquina de curl de piernas con los tobillos bajo el rodillo.\n2. Lleva los talones hacia los glúteos.\n3. Aprieta los isquiotibiales en la parte superior.\n4. Baja con control.\n5. Repite.\n\nConsejos técnicos:\n• Mantén las caderas pegadas al banco durante todo el recorrido.\n• Evita arquear la zona lumbar al subir los talones.\n• Elige un peso que permita un recorrido completo y controlado.\n\nMúsculos principales: hamstrings',NULL,'leg-curl.webp'),
(268,'Extensión de Piernas','Leg Extension','Un ejercicio de aislamiento para los cuádriceps usando una máquina.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de extensión de piernas con los tobillos detrás del rodillo.\n2. Extiende las piernas hasta que queden rectas.\n3. Aprieta los cuádriceps en la parte superior.\n4. Baja con control.\n5. Repite.\n\nConsejos técnicos:\n• Alinea las rodillas con el eje de giro de la máquina.\n• Sube el peso sin lanzarlo con impulso.\n• Agárrate a las asas para mantener la cadera estable en el asiento.\n\nMúsculos principales: quadriceps',NULL,'leg-extension.webp'),
(269,'Prensa de Piernas','Leg Press','Un movimiento compuesto en máquina para cuádriceps y glúteos.\n\nInstrucciones de ejecución:\n1. Siéntate en la prensa de piernas con los pies a la anchura de los hombros sobre la plataforma.\n2. Suelta los seguros y baja la plataforma doblando las rodillas.\n3. Empuja la plataforma hacia arriba hasta que las piernas queden casi rectas.\n4. No bloquees las rodillas en la parte superior.\n5. Repite.\n\nConsejos técnicos:\n• Mantén la zona lumbar pegada al respaldo en todo momento.\n• Baja solo hasta donde la cadera no se despegue.\n• Alinea las rodillas con las puntas de los pies.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'leg-press.webp'),
(270,'Zancada Baja a Medio Split','Low Lunge to Half Split','Una secuencia en movimiento para isquiotibiales y flexores de cadera: desde una zancada baja las caderas retroceden sobre la rodilla trasera y la pierna delantera se estira en medio split, y después las caderas vuelven a deslizarse hacia delante.\n\nInstrucciones de ejecución:\n1. Empieza en zancada baja con la rodilla trasera en el suelo y la delantera sobre el tobillo.\n2. Apoya las manos en el suelo o en bloques a ambos lados del pie delantero.\n3. Lleva las caderas atrás sobre la rodilla trasera y estira la pierna delantera con el pie en flexión.\n4. Sostén el medio split un instante y desliza las caderas hacia delante otra vez a la zancada.\n5. Repite las veces indicadas y cambia de lado.\n\nConsejos técnicos:\n• Mantén larga la parte posterior de la pierna delantera: flexiona un poco la rodilla en lugar de redondear la columna para llegar.\n• Se mueven las caderas, no el pie delantero; el pie se queda donde estaba.\n• Acolcha la rodilla trasera y usa bloques bajo las manos si el suelo queda lejos.\n\nMúsculos principales: hamstrings',NULL,'low-lunge-to-half-split.webp'),
(271,'Zancada','Lunge','Una zancada hacia delante con el peso corporal, entrenando cuádriceps, glúteos y equilibrio una pierna a la vez.\n\nInstrucciones de ejecución:\n1. Párate erguido con los pies a la anchura de las caderas.\n2. Da un paso adelante largo con una pierna.\n3. Baja la rodilla trasera hacia el suelo hasta que ambas rodillas formen ángulos de 90 grados.\n4. Empuja con el talón delantero para volver a la posición de pie.\n5. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Da una zancada lo bastante larga para que ambas rodillas lleguen a unos 90 grados.\n• Mantén el torso erguido y la mirada al frente.\n• Empuja con el talón delantero para volver en un solo movimiento potente.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'lunge.webp'),
(272,'Elevación de Piernas Acostado','Lying Leg Raise','Un ejercicio de suelo para el abdomen bajo y los flexores de cadera que consiste en elevar las piernas rectas desde posición supina.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con las piernas rectas y las manos bajo la zona lumbar o sujetando una superficie estable detrás de la cabeza.\n2. Con las piernas juntas y el core activado, eleva las piernas hasta la vertical.\n3. Pausa brevemente arriba.\n4. Baja las piernas despacio hacia el suelo sin llegar a apoyarlas.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén la zona lumbar pegada al suelo durante todo el ejercicio.\n• Evita el balanceo — controla el descenso para maximizar la tensión.\n• Dobla ligeramente las rodillas si la flexibilidad de los isquiotibiales lo requiere.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'lying-leg-raise.webp'),
(273,'Extensión de Tríceps Tumbado','Lying Tricep Extension','Un ejercicio de aislamiento tumbado que baja el peso hacia la frente y extiende los codos para trabajar los tríceps.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco con una barra o mancuernas sostenidas sobre la cabeza.\n2. Mantén los brazos superiores verticales y los codos apuntando hacia adelante.\n3. Baja el peso hacia la frente doblando los codos.\n4. Extiende los brazos de vuelta a la posición inicial.\n5. Aprieta los tríceps en la parte superior.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén los brazos verticales y los codos apuntando hacia delante.\n• Mueve solo los codos, no los hombros.\n• Baja el peso con control en lugar de dejarlo caer.\n\nMúsculos principales: triceps_brachii',NULL,'lying-tricep-extension.webp'),
(274,'Extensión de Espalda en Máquina','Machine Back Extension','Un ejercicio de aislamiento sentado para la zona lumbar: con la cadera y las piernas fijas, el torso empuja hacia atrás contra un rodillo acolchado y extiende la columna venciendo la placa de pesas.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de extensión de espalda con los pies apoyados en la plataforma y ajusta el rodillo para que quede sobre la parte alta de la espalda, justo por debajo de los omóplatos.\n2. Agarra las manijas laterales y deja que el torso venga ligeramente hacia delante: esta es la posición inicial.\n3. Empuja hacia atrás contra el rodillo extendiendo la columna hasta que el torso quede inclinado hacia atrás y la zona lumbar esté totalmente contraída.\n4. Haz una pausa breve en la extensión completa y regresa a la posición inicial de forma controlada, resistiendo el peso durante el recorrido.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Coloca el rodillo justo por debajo de los omóplatos: más arriba presiona el cuello y más abajo pierdes recorrido.\n• Extiende desde la zona lumbar en lugar de lanzar la cabeza y los hombros hacia atrás, y mantén lento el movimiento en ambos sentidos.\n• Detente con el torso extendido en posición neutra en lugar de forzar la columna más allá, y empieza con poco peso: la zona lumbar responde mejor a repeticiones controladas que a cargas altas.\n\nMúsculos principales: erector_spinae',NULL,'machine-back-extension.webp'),
(275,'Curl de Bíceps en Máquina','Machine Bicep Curl','Un curl de bíceps en máquina para el entrenamiento aislado de brazos.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina y ajusta el rodillo a la longitud de tus brazos.\n2. Agarra las manijas con agarre en supinación.\n3. Lleva las manijas hacia los hombros.\n4. Baja con control.\n5. Repite.\n\nConsejos técnicos:\n• Mantén los codos apoyados en la almohadilla en todo momento.\n• Evita encoger los hombros al subir las asas.\n• Baja hasta casi extender los brazos sin perder la tensión.\n\nMúsculos principales: biceps_brachii',NULL,'machine-bicep-curl.webp'),
(276,'Elevación de Pantorrillas en Máquina','Machine Calf Raise','Un ejercicio de aislamiento en máquina de pie que trabaja los gemelos y el sóleo con un recorrido completo del tobillo.\n\nInstrucciones de ejecución:\n1. Párate en la máquina de elevación de pantorrillas con los metatarsos sobre la plataforma.\n2. Coloca los rodillos de hombro firmemente.\n3. Baja los talones por debajo de la plataforma para un estiramiento completo.\n4. Empuja con los metatarsos para elevarte en los dedos de los pies.\n5. Aprieta las pantorrillas en la parte superior.\n6. Baja con control y repite.\n\nConsejos técnicos:\n• Evita rebotar en la parte baja para no perder tensión.\n• Mantén las rodillas extendidas pero sin llegar a bloquearlas.\n• Sube en vertical, sin inclinar los tobillos hacia fuera.\n\nMúsculos principales: gastrocnemius, soleus',NULL,'machine-calf-raise.webp'),
(277,'Aperturas en Máquina','Machine Chest Fly','Un ejercicio de aislamiento de pecho realizado en una máquina que junta las palancas en un arco frente al cuerpo.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de aperturas y ajusta el asiento para que las palancas queden a la altura del pecho.\n2. Sujeta las palancas con una ligera flexión de codos.\n3. Junta las palancas frente al pecho en un arco suave.\n4. Contrae el pectoral en el punto de máxima contracción.\n5. Vuelve con control a la posición inicial sin dejar caer el peso.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén una flexión de codo ligera y constante durante todo el movimiento.\n• Enfócate en contraer el pecho en lugar de empujar con los brazos.\n• Controla el regreso en vez de dejar caer la pila de pesas.\n\nMúsculos principales: pectoralis_major',NULL,'machine-chest-fly.webp'),
(278,'Curl en Máquina de Predicador','Machine Preacher Curl','Un curl de bíceps en máquina de predicador que fija los codos sobre el almohadillado y ofrece una curva de fuerza guiada.\n\nInstrucciones de ejecución:\n1. Siéntate y ajusta el asiento para que las axilas queden en la parte superior del almohadillado.\n2. Coloca los brazos sobre el soporte y sujeta las asas.\n3. Comienza con los brazos ligeramente flexionados, sin bloquear los codos.\n4. Flexiona los codos hacia arriba y aprieta en la posición máxima.\n5. Baja lentamente hasta la posición inicial y repite.\n\nConsejos técnicos:\n• No separes los codos del almohadillado.\n• Para justo antes de la extensión completa para proteger los tendones del codo.\n\nMúsculos principales: biceps_brachii',NULL,'machine-preacher-curl.webp'),
(279,'Abdominales en Máquina Sentado','Machine Seated Crunch','Un ejercicio de aislamiento abdominal en una máquina sentada que flexiona la columna contra resistencia.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de abdominales y sujeta las manijas.\n2. Coloca la almohadilla de pecho contra tu torso.\n3. Contrae el abdomen para flexionar el torso hacia adelante y abajo.\n4. Contrae al final del recorrido.\n5. Vuelve a la posición inicial con control.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Inicia el movimiento con el abdomen, no con los brazos.\n• Exhala mientras flexionas el torso.\n• Evita el impulso balanceando el cuerpo.\n\nMúsculos principales: rectus_abdominis',NULL,'machine-seated-crunch.webp'),
(280,'Press de Hombros en Máquina','Machine Shoulder Press','Un movimiento de press por encima de la cabeza en máquina para los hombros.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina con la espalda contra el rodillo.\n2. Agarra las manijas a la altura de los hombros.\n3. Presiona las manijas sobre la cabeza hasta que los brazos queden completamente extendidos.\n4. Baja con control a la posición inicial.\n5. Repite.\n\nConsejos técnicos:\n• No arquees la zona lumbar al empujar hacia arriba.\n• Evita bloquear los codos de golpe en la parte alta.\n• Mantén las muñecas firmes y alineadas con los antebrazos.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'machine-shoulder-press.webp'),
(281,'Extensión de Tríceps en Máquina','Machine Triceps Extension','Un ejercicio de aislamiento sentado en máquina: los brazos quedan apoyados sobre un rodillo mientras los codos se extienden contra dos manijas, de modo que el tríceps trabaja por un recorrido guiado sin ayuda de los hombros ni del torso.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de extensión de tríceps con la espalda apoyada en el respaldo y los brazos apoyados de plano sobre el rodillo, delante del pecho.\n2. Toma una manija con cada mano, con los codos flexionados y las manos a la altura de los hombros.\n3. Manteniendo los brazos pegados al rodillo, extiende los codos para empujar las manijas hacia abajo y hacia delante hasta estirar los brazos por completo.\n4. Aprieta el tríceps en la extensión completa y flexiona los codos para volver al inicio de forma controlada.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Ajusta la altura del asiento para que los brazos queden planos sobre el rodillo y los codos alineados con el eje de giro de la máquina: esa alineación es lo que mantiene el trabajo en el tríceps.\n• Mantén los brazos pegados al rodillo; si se despegan, el movimiento se convierte en un press y el tríceps deja de trabajar.\n• Estira los brazos del todo sin bloquear de golpe los codos, y frena la vuelta en lugar de dejar caer las placas.\n\nMúsculos principales: triceps_brachii',NULL,'machine-triceps-extension.webp'),
(282,'Golpe con Balón Medicinal','Medicine Ball Slam','Un ejercicio explosivo de cuerpo completo donde se levanta un slam ball sobre la cabeza y se lanza contra el suelo con la máxima fuerza.\n\nInstrucciones de ejecución:\n1. Párate con los pies a la anchura de los hombros sosteniendo un slam ball frente a las caderas.\n2. Levanta el balón sobre la cabeza extendiendo las caderas y alargándote hacia arriba.\n3. Golpea el balón contra el suelo entre los pies con fuerza, contrayendo el core.\n4. Atrapa el balón en el rebote o recógelo del suelo.\n5. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Usa un slam ball de rebote suave, no un balón medicinal tradicional: los balones normales pueden rebotar hacia la cara.\n• Termina con todo el cuerpo: es un swing completo, no solo un lanzamiento de brazos.\n\nMúsculos principales: rectus_abdominis',NULL,'medicine-ball-slam.webp'),
(283,'Mountain Climbers','Mountain Climbers','Un ejercicio dinámico de peso corporal que combina trabajo de core con cardio.\n\nInstrucciones de ejecución:\n1. Comienza en posición de plancha alta.\n2. Lleva una rodilla hacia el pecho.\n3. Cambia rápidamente de pierna llevando la otra rodilla hacia adelante.\n4. Continúa alternando a un ritmo brioso.\n5. Repite.\n\nConsejos técnicos:\n• Mantén los hombros encima de las muñecas todo el tiempo.\n• No dejes que la cadera se eleve hacia el techo.\n• Acelera solo mientras puedas mantener la técnica.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'mountain-climbers.webp'),
(284,'Muscle Snatch','Muscle Snatch','Una variante de la arrancada que tira de la barra por encima de la cabeza sin caer debajo, desarrollando potencia de tirón y fuerza de bloqueo.\n\nInstrucciones de ejecución:\n1. Párate con los pies a la anchura de las caderas y agarra la barra en ancho con agarre de gancho.\n2. Tira de la barra explosivamente desde el suelo manteniéndola cerca del cuerpo.\n3. Encoge los hombros con fuerza y lleva la barra sobre la cabeza sin flexionar las piernas.\n4. Bloquea la barra sobre la cabeza con los brazos rectos.\n5. Baja la barra con control a la posición inicial.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Encoge los hombros con fuerza y sigue tirando de la barra hacia arriba.\n• Mantente erguido; no te metas debajo de la barra para recibirla.\n• Mantén la barra cerca del cuerpo durante todo el tirón.\n\nMúsculos principales: lateral_deltoid, trapezius',NULL,'muscle-snatch.webp'),
(285,'Muscle-Ups','Muscle Ups','Un movimiento avanzado en barra que combina una dominada explosiva con una transición a fondo para terminar por encima de la barra.\n\nInstrucciones de ejecución:\n1. Cuélgate de una barra de dominadas con agarre falso.\n2. Tírate hacia arriba de forma explosiva hacia la barra.\n3. Cuando el pecho llegue a la barra, rota los codos por encima y transiciona a un dip.\n4. Empuja el cuerpo hacia arriba hasta que los brazos queden completamente extendidos sobre la barra.\n5. Baja con control por el mismo recorrido.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Usa agarre falso para que las muñecas ya estén sobre la barra en la transición.\n• Tira explosivamente hacia el esternón, no solo hasta la barbilla.\n• Practica la transición en anillas bajas o con bandas antes de hacer repeticiones completas.\n\nMúsculos principales: latissimus_dorsi, triceps_brachii',NULL,'muscle-ups.webp'),
(286,'Dominadas Negativas','Negative Pull Ups','Una progresión de dominada centrada en la fase excéntrica, en la que se desciende lentamente desde la barra con control.\n\nInstrucciones de ejecución:\n1. Usa un cajón o salta para colocarte en la parte superior de una dominada.\n2. Agarra la barra con las manos a la anchura de los hombros.\n3. Mantén el mentón por encima de la barra un momento.\n4. Bájate lentamente durante 3-5 segundos con control.\n5. Extiende los brazos completamente en la parte inferior.\n6. Vuelve a la posición inicial y repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Resiste la bajada durante todo el recorrido, sin dejarte caer al final.\n• Mantén los hombros activos, lejos de las orejas.\n• Aprieta el core para no balancearte durante el descenso.\n\nMúsculos principales: latissimus_dorsi',NULL,'negative-pull-ups.webp'),
(287,'Dominadas en Agarre Neutro','Neutral Grip Pull Ups','Una dominada con agarre neutro y palmas enfrentadas que trabaja el dorsal ancho con fuerte participación de los brazos.\n\nInstrucciones de ejecución:\n1. Agarra las barras paralelas con las palmas enfrentadas.\n2. Cuelga con los brazos completamente extendidos.\n3. Tírate hacia arriba hasta que el mentón supere la barra.\n4. Aprieta los dorsales en la parte superior del movimiento.\n5. Bájate con control a la posición inicial.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Piensa en llevar los codos hacia las costillas al subir.\n• Evita balancearte; sube en una línea vertical limpia.\n• Lleva el pecho hacia las barras en la parte alta.\n\nMúsculos principales: latissimus_dorsi',NULL,'neutral-grip-pull-ups.webp'),
(288,'Curl Nórdico de Isquiotibiales','Nordic Hamstring Curl','Un ejercicio de flexión de rodilla bajando el torso hacia delante desde una posición arrodillada, trabajando los isquiotibiales de forma excéntrica.\n\nInstrucciones de ejecución:\n1. Arrodíllate sobre una colchoneta con los tobillos anclados bajo un soporte fijo.\n2. Mantén el torso erguido y las caderas extendidas.\n3. Baja el cuerpo hacia adelante lentamente resistiendo con los isquiotibiales.\n4. Amortigua la caída con las manos justo antes de tocar el suelo.\n5. Empuja con las manos para volver y tírate hacia la posición inicial.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Baja tan despacio como sea posible: la fase excéntrica es el objetivo.\n• Mantén las caderas extendidas; no te dobles por la cintura.\n• Frénate con las manos y empuja ligeramente mientras ganas fuerza.\n\nMúsculos principales: hamstrings',NULL,'nordic-hamstring-curl.webp'),
(289,'Press Militar con Barra','Barbell Overhead Press','Un movimiento de empuje compuesto por encima de la cabeza que trabaja los hombros y el tríceps.\n\nInstrucciones de ejecución:\n1. De pie con los pies a la anchura de los hombros y la barra a la altura de las clavículas.\n2. Contrae el core y empuja la barra por encima de la cabeza.\n3. Bloquea los codos arriba con la barra sobre el punto medio del pie.\n4. Baja la barra hasta la altura de las clavículas.\n5. Repite.\n\nConsejos técnicos:\n• No te eches demasiado hacia atrás.\n• Aprieta los glúteos para mayor estabilidad.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'ohp.webp'),
(290,'Push Press con Mancuerna a Un Brazo','One-Arm Dumbbell Push Press','Un push press unilateral con una sola mancuerna. El impulso de piernas te permite lanzar cargas más pesadas por encima de la cabeza que un press estricto a un brazo, y la carga asimétrica exige una fuerte contención anti-flexión lateral.\n\nInstrucciones de ejecución:\n1. De pie con la mancuerna en un hombro, palma hacia adentro (neutro).\n2. Pies a la anchura de los hombros, core contraído, brazo libre al costado para equilibrio.\n3. Flexiona ligeramente las rodillas manteniendo el torso vertical.\n4. Extiende las piernas de forma explosiva y empuja la mancuerna por encima de la cabeza en un solo movimiento.\n5. Bloquea el codo arriba y baja la mancuerna al hombro con control.\n6. Completa todas las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• El impulso viene de las piernas; el brazo termina el movimiento, no lo inicia.\n• El torso debe mantenerse erguido y cuadrado; no te inclines hacia el lado contrario a la carga.\n• Menos peso y mejor impulso de piernas superan a más peso con el torso inclinado.\n\nMúsculos principales: anterior_deltoid',NULL,'one-arm-dumbbell-push-press.webp'),
(291,'Swing con Mancuerna a un Brazo','One-Arm Dumbbell Swing','Este ejercicio dinámico desarrolla potencia explosiva en glúteos e isquiotibiales mediante una potente bisagra de cadera, involucrando el core y los hombros para un entrenamiento de cuerpo completo.\n\nInstrucciones de ejecución:\n1. Párate con los pies al ancho de los hombros, una mancuerna en el suelo ligeramente delante de ti.\n2. Haz una bisagra de cadera, manteniendo la espalda recta, y agarra la mancuerna con una mano.\n3. Lleva la mancuerna hacia atrás entre tus piernas, luego impulsa explosivamente tus caderas hacia adelante.\n4. Balancea la mancuerna hasta la altura del pecho, manteniendo tu brazo relajado y estirado.\n5. Permite que la mancuerna baje, haciendo una bisagra de cadera mientras desciende.\n6. Repite las repeticiones deseadas por lado, manteniendo el control.\n\nConsejos técnicos:\n• Concéntrate en impulsar con tus caderas, no en tirar con tu brazo.\n• Mantén tu core contraído durante todo el movimiento para mayor estabilidad.\n• Mantén una columna vertebral neutra; evita redondear tu espalda.\n• Controla la fase excéntrica mientras la mancuerna baja.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'one-arm-dumbbell-swing.webp'),
(292,'Curl de Bíceps con Pesa Rusa a Un Brazo','One Arm Kettlebell Bicep Curl','Un curl de bíceps unilateral con pesa rusa que entrena cada brazo por separado e implica con fuerza el antebrazo.\n\nInstrucciones de ejecución:\n1. De pie, sostén una pesa rusa en una mano.\n2. Mantén el codo pegado al costado.\n3. Sube la pesa rusa hacia el hombro flexionando el bíceps.\n4. Aprieta en la parte superior del movimiento.\n5. Baja la pesa rusa con control.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén la muñeca recta aunque la pesa tire de ella.\n• Evita balancear el torso para ayudarte a subir el peso.\n• Empieza siempre por tu lado más débil.\n\nMúsculos principales: biceps_brachii',NULL,'one-arm-kettlebell-bicep-curl.webp'),
(293,'Press Strict con Pesa Rusa Invertida a Un Brazo','One-Arm Kettlebell Bottoms-Up Press','Un press estricto por encima de la cabeza con la pesa rusa boca abajo: la bola arriba y el asa en la palma. La carga invertida exige un agarre fuerte, estabilidad perfecta de hombro y una trayectoria impecable.\n\nInstrucciones de ejecución:\n1. Limpia una pesa rusa ligera a la posición de rack y luego inclínala para que la bola apunte hacia arriba y el asa quede en la palma.\n2. Agarra el asa con fuerza; la muñeca absolutamente recta y vertical.\n3. Contrae el core y empuja la bola recto hacia arriba sin dejarla caer.\n4. Bloquea el codo arriba con la bola todavía perfectamente vertical.\n5. Baja lentamente a la posición de rack manteniendo la pesa vertical durante todo el descenso.\n6. Completa todas las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Si la bola se inclina, la serie termina; no luches para bajarla.\n• Empieza con muy poco peso; es un ejercicio de habilidad y estabilidad, no un press pesado.\n• Aprieta fuerte durante todo el recorrido; cualquier relajación y la pesa cae.\n\nMúsculos principales: anterior_deltoid',NULL,'one-arm-kettlebell-bottoms-up-press.webp'),
(294,'Press en Puente de Glúteos en Suelo con Pesa Rusa a Un Brazo','One Arm Kettlebell Floor Glute Bridge Press','Un ejercicio combinado en el suelo que une un puente de glúteos con un press de pesa rusa a un brazo.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con las rodillas dobladas y los pies planos en el suelo.\n2. Sostén una pesa rusa en una mano a la altura del hombro.\n3. Eleva las caderas en un puente de glúteos.\n4. Empuja la pesa rusa recto hacia el techo.\n5. Baja la pesa rusa y las caderas con control.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén las caderas elevadas y firmes mientras haces el press.\n• Sujeta la pesa con la muñeca recta y firme.\n• Evita que la cadera rote hacia el lado cargado.\n\nMúsculos principales: gluteus_maximus, pectoralis_major',NULL,'one-arm-kettlebell-floor-glute-bridge-press.webp'),
(295,'Press en Suelo con Pesa Rusa a Un Brazo','One Arm Kettlebell Floor Press','Un press de pecho unilateral con pesa rusa ejecutado tumbado en el suelo, que acorta el recorrido y trabaja pectoral y tríceps.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba en el suelo con las rodillas dobladas.\n2. Sostén una pesa rusa en un hombro con una mano.\n3. Empuja la pesa rusa recto hacia arriba hasta que el brazo quede completamente extendido.\n4. Baja la pesa rusa hasta que la parte superior del brazo toque el suelo.\n5. Mantén el core contraído durante todo el ejercicio.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Apoya el brazo en el suelo con suavidad, sin rebotar.\n• Sujeta la pesa con la muñeca firme, sin dejar que se doble.\n• Evita abrir el codo en exceso hacia el lado.\n\nMúsculos principales: pectoralis_major',NULL,'one-arm-kettlebell-floor-press.webp'),
(296,'Sentadilla Frontal con Pesa Rusa a Un Brazo','One Arm Kettlebell Front Squat','Una sentadilla frontal con una pesa rusa apoyada en un solo hombro, que obliga al core a resistir la inclinación lateral.\n\nInstrucciones de ejecución:\n1. Sostén una pesa rusa en posición de rack en un hombro.\n2. De pie con los pies a la anchura de los hombros.\n3. Baja en sentadilla flexionando las rodillas y las caderas.\n4. Mantén el pecho alto y el torso erguido durante todo el ejercicio.\n5. Impulsa a través de los talones para volver a ponerte de pie.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Resiste la tendencia a inclinarte hacia el lado de la pesa.\n• Empuja las rodillas hacia afuera en la parte baja.\n• Mantén el codo pegado al cuerpo bajo la pesa.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'one-arm-kettlebell-front-squat.webp'),
(297,'Push Press con Pesa Rusa a Un Brazo','One Arm Kettlebell Push Press','Un press unilateral con pesa rusa que usa un impulso de piernas para llevar el peso por encima de la cabeza.\n\nInstrucciones de ejecución:\n1. Sostén una pesa rusa en posición de rack en un hombro.\n2. De pie con los pies a la anchura de los hombros.\n3. Flexiona ligeramente las rodillas.\n4. Extiende las piernas de forma explosiva y empuja la pesa rusa por encima de la cabeza.\n5. Bloquea el codo en la parte superior.\n6. Baja la pesa rusa al hombro con control.\n7. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Haz la flexión de piernas corta y rápida, sin inclinar el torso.\n• Sincroniza el empuje de piernas con la extensión del brazo.\n• Aprieta el core al recibir la pesa de vuelta en el hombro.\n\nMúsculos principales: anterior_deltoid',NULL,'one-arm-kettlebell-push-press.webp'),
(298,'Remo con Pesa Rusa a Un Brazo','One Arm Kettlebell Row','Un remo unilateral con pesa rusa y apoyo en banco, que fortalece el dorsal ancho y los romboides de cada lado.\n\nInstrucciones de ejecución:\n1. Apoya una mano y una rodilla sobre un banco para sujetarte.\n2. Sostén una pesa rusa en la mano contraria con el brazo extendido.\n3. Jala la pesa rusa hacia la cadera llevando el codo hacia atrás.\n4. Aprieta la espalda en la parte superior del movimiento.\n5. Baja la pesa rusa con control.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén la espalda plana y paralela al suelo.\n• Evita rotar el torso al subir la pesa.\n• Tira con la espalda, no solo con el bíceps.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'one-arm-kettlebell-row.webp'),
(299,'Press de Hombro con Pesa Rusa a Un Brazo','One Arm Kettlebell Shoulder Press','Un press de hombro estricto a un brazo con pesa rusa, que exige estabilidad del core para evitar la inclinación lateral.\n\nInstrucciones de ejecución:\n1. Sostén una pesa rusa en posición de rack en un hombro.\n2. De pie con los pies a la anchura de las caderas.\n3. Empuja la pesa rusa recto hacia arriba hasta bloquear el codo.\n4. Mantén el core apretado durante todo el ejercicio.\n5. Baja la pesa rusa a la posición de rack con control.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• No te inclines hacia el lado contrario al empujar.\n• Mantén el antebrazo vertical bajo la pesa durante el recorrido.\n• Exhala al empujar y evita encoger el hombro hacia la oreja.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'one-arm-kettlebell-shoulder-press.webp'),
(300,'Swing con Pesa Rusa a Un Brazo','One Arm Kettlebell Swing','Un swing de pesa rusa a un brazo, un movimiento balístico de bisagra de cadera que desarrolla potencia en glúteos e isquiotibiales.\n\nInstrucciones de ejecución:\n1. De pie con los pies a la anchura de los hombros y la pesa rusa en el suelo frente a ti.\n2. Bisagra en las caderas y agarra la pesa rusa con una mano.\n3. Lleva la pesa rusa hacia atrás entre las piernas.\n4. Impulsa las caderas hacia adelante para lanzar la pesa rusa hasta la altura del pecho.\n5. Deja que la gravedad lleve la pesa rusa de vuelta entre las piernas.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Genera la potencia con la cadera, no con el brazo.\n• Mantén la espalda recta cuando la pesa pase entre las piernas.\n• No dejes que la pesa tire del hombro hacia delante.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'one-arm-kettlebell-swing.webp'),
(301,'Extensión de Tríceps a Un Brazo con Pesa Rusa','One-Arm Kettlebell Tricep Kickback','Una extensión de tríceps unilateral con pesa rusa: inclínate, fija el brazo al costado paralelo al suelo y extiende el codo hacia atrás.\n\nInstrucciones de ejecución:\n1. Inclínate hacia delante flexionando las caderas con la espalda recta y las rodillas ligeramente flexionadas.\n2. Sujeta una pesa rusa por el asa con una mano, con la palma hacia el cuerpo.\n3. Fija la parte alta del brazo al costado de modo que quede paralela al suelo; el antebrazo cuelga recto hacia abajo.\n4. Extiende el codo hacia atrás para estirar el brazo del todo por detrás de ti, manteniendo inmóvil la parte alta del brazo.\n5. Aprieta el tríceps en la extensión completa y vuelve de forma controlada a la posición inicial.\n6. Completa todas las repeticiones de un lado y luego cambia de mano.\n\nConsejos técnicos:\n• La parte alta del brazo no se mueve, solo el antebrazo; balancear el hombro es trampa.\n• Bloquea la pesa un instante en la extensión completa; tiende a hundirte la muñeca.\n• Usa una pesa más ligera que en una extensión con mancuerna; la carga descentrada cuesta más de estabilizar.\n\nMúsculos principales: triceps_brachii',NULL,'one-arm-kettlebell-tricep-kickback.webp'),
(302,'Press Landmine con Un Brazo','One-Arm Landmine Press','Una variante de press sobre la cabeza unilateral con montaje landmine que sigue un arco natural, reduciendo el riesgo de impingement de hombro.\n\nInstrucciones de ejecución:\n1. Ancla un extremo de la barra en el accesorio landmine y carga el extremo libre.\n2. Arrodíllate en una rodilla o párate y sujeta el extremo libre a la altura del hombro con una mano.\n3. Empuja la barra hacia arriba y adelante siguiendo su arco hasta extender completamente el brazo.\n4. Baja la barra de regreso a la altura del hombro con control.\n5. Completa todas las repeticiones antes de cambiar de lado.\n\nConsejos técnicos:\n• Activa el core para evitar que el torso rote hacia el brazo de trabajo.\n• El movimiento en arco es más amigable para las articulaciones que un press estricto.\n• Arrodillarse en la rodilla contraria aumenta la demanda antirotacional del core.\n\nMúsculos principales: anterior_deltoid, pectoralis_major',NULL,'one-arm-landmine-press.webp'),
(303,'Jalón al Pecho con Un Brazo','One-Arm Lat Pulldown','Un jalón en cable unilateral con manija individual que trabaja el dorsal ancho permitiendo mayor rango de movimiento y corrección de desequilibrios.\n\nInstrucciones de ejecución:\n1. Sujeta una manija individual al jalón de cable y siéntate con los muslos asegurados bajo el soporte.\n2. Agarra la manija con una mano, brazo completamente extendido.\n3. Tira de la manija hacia tu hombro llevando el codo hacia la cadera.\n4. Pausa brevemente en la contracción máxima, luego vuelve con control.\n5. Completa todas las repeticiones en un lado antes de cambiar.\n\nConsejos técnicos:\n• Inclínate ligeramente alejándote del cable para maximizar el estiramiento del dorsal arriba.\n• Tira con el codo, no con la mano, para mantener el dorsal activado.\n• Controla la fase excéntrica para maximizar la tensión en el dorsal durante todo el rango.\n\nMúsculos principales: latissimus_dorsi',NULL,'one-arm-lat-pulldown.webp'),
(304,'Peso Muerto Rumano a Una Pierna con Mancuerna a Un Brazo','One-Arm Single-Leg Dumbbell Romanian Deadlift','Un peso muerto rumano a una pierna sosteniendo una mancuerna en una sola mano, generalmente la opuesta a la pierna de apoyo (contralateral). Carga los isquiotibiales y glúteos de la pierna de apoyo mientras exige una fuerte contención anti-rotación del core.\n\nInstrucciones de ejecución:\n1. De pie sobre una pierna, sostén una mancuerna en la mano contraria.\n2. Brazo libre al costado para equilibrarte, pierna libre suspendida justo por encima del suelo.\n3. Bisagra en la cadera de apoyo empujándola hacia atrás mientras la pierna libre se extiende detrás para contrarrestar el peso.\n4. Mantén las caderas cuadradas al suelo; no las abras hacia el lado.\n5. Baja la mancuerna hacia el pie de la pierna de apoyo sintiendo un estiramiento profundo en los isquiotibiales.\n6. Impulsa la cadera hacia adelante para volver a ponerte de pie con control.\n7. Completa todas las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Empieza con menos peso del que crees; el equilibrio y la demanda anti-rotación son el factor limitante, no la fuerza de los isquiotibiales.\n• Si rotas, haz una pausa y reinicia; un recorrido limpio más corto es mejor que uno completo con rotación.\n• Fijar la vista en un punto fijo en el suelo a un par de metros al frente ayuda con el equilibrio.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'one-arm-single-leg-dumbbell-romanian-deadlift.webp'),
(305,'Peso Muerto Rumano a Una Pierna con Pesa Rusa a Un Brazo','One-Arm Single-Leg Kettlebell Romanian Deadlift','La versión con pesa rusa del peso muerto rumano a una pierna y un brazo. La masa excéntrica de la pesa rusa y su centro de gravedad más bajo lo convierten en un reto sutilmente diferente al de la mancuerna; excelente para la fuerza de la cadena posterior y el equilibrio bajo carga asimétrica.\n\nInstrucciones de ejecución:\n1. De pie sobre una pierna, sostén una pesa rusa en la mano contraria por el asa.\n2. Brazo libre al costado para equilibrarte, pierna libre suspendida detrás.\n3. Bisagra en la cadera de apoyo empujándola hacia atrás mientras la pierna libre se extiende para contrarrestar el peso.\n4. Mantén las caderas cuadradas al suelo; la pesa rusa desciende recto por la espinilla.\n5. Siente un estiramiento profundo en los isquiotibiales de la pierna de apoyo en la parte inferior.\n6. Impulsa la cadera hacia adelante para volver a ponerte de pie.\n7. Completa todas las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• La pesa rusa cuelga más bajo que una mancuerna; acorta ligeramente el recorrido para mantener la espalda plana.\n• Si la pesa oscila, estás yendo demasiado rápido. Desacelera la fase excéntrica.\n• Primero domina el peso muerto rumano a una pierna con dos mancuernas antes de progresar a este ejercicio.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'one-arm-single-leg-kettlebell-romanian-deadlift.webp'),
(306,'Sentadilla con Barra en Alto','Overhead Squat','Una sentadilla con la barra bloqueada por encima de la cabeza con agarre ancho de arrancada, que exige movilidad, estabilidad y un core fuerte.\n\nInstrucciones de ejecución:\n1. Sostén una barra por encima de la cabeza con un agarre ancho de arrancada y los codos bloqueados.\n2. De pie con los pies ligeramente más abiertos que la anchura de los hombros.\n3. Baja en sentadilla empujando las caderas hacia atrás y doblando las rodillas.\n4. Mantén la barra directamente sobre el punto medio de los pies.\n5. Impulsa a través de los talones para volver a ponerte de pie.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Gira las axilas hacia delante para fijar la barra en su sitio.\n• Mantén la barra sobre el mediopié, con el torso más erguido que en una sentadilla trasera.\n• Trabaja la movilidad de hombros y tobillos antes de añadir peso.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'overhead-squat.webp'),
(307,'Extensión de Tríceps por Encima de la Cabeza','Overhead Tricep Extension','Un ejercicio de aislamiento para el tríceps que enfatiza la cabeza larga.\n\nInstrucciones de ejecución:\n1. De pie o sentado, sostén una mancuerna por encima de la cabeza con ambas manos.\n2. Baja la mancuerna detrás de la cabeza doblando los codos.\n3. Extiende los brazos de vuelta a la posición inicial.\n4. Mantén los codos cerca de la cabeza durante todo el ejercicio.\n5. Repite.\n\nConsejos técnicos:\n• Mueve solo los antebrazos y mantén quieto todo lo demás.\n• Evita arquear la zona lumbar cuando la mancuerna baje.\n• Agarra la mancuerna por debajo del disco superior con ambas palmas.\n\nMúsculos principales: triceps_brachii',NULL,'overhead-tricep-extension.webp'),
(308,'Dominada con Pausa','Pause Pull-Up','Una variante de dominada que añade una breve pausa isométrica en la parte superior del movimiento, con la barbilla sobre la barra, antes de bajar de nuevo.\n\nInstrucciones de ejecución:\n1. Cuélgate de una barra de dominadas con agarre prono, brazos completamente extendidos.\n2. Tira de tu cuerpo hacia arriba hasta que la barbilla supere la barra.\n3. Haz una pausa y mantén esa posición superior un momento.\n4. Baja con control de vuelta a la posición de colgado completo.\n5. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• La pausa elimina el impulso, así que el tirón es más difícil que en una dominada normal -- espera menos repeticiones.\n• Mantén los hombros activos durante la pausa en lugar de relajarte colgando de la barra.\n• Baja despacio en vez de caer directamente a la siguiente repetición.\n\nMúsculos principales: latissimus_dorsi',NULL,'pause-pull-up.webp'),
(309,'Sentadilla con Pausa','Pause Squat','Una sentadilla con barra que incluye una pausa de varios segundos en la posición baja para eliminar el rebote y reforzar la salida del fondo.\n\nInstrucciones de ejecución:\n1. Saca la barra del rack y apóyala sobre la parte superior de la espalda.\n2. De pie con los pies a la anchura de los hombros.\n3. Baja en sentadilla hasta que los muslos queden paralelos al suelo.\n4. Mantén la posición inferior durante 2-3 segundos.\n5. Impulsa a través de los talones para volver a ponerte de pie.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén la tensión en la pausa; no te relajes en el fondo.\n• Coge aire arriba y mantén el abdomen firme toda la repetición.\n• Mantén el pecho alto para que la barra no te venza hacia delante.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'pause-squat.webp'),
(310,'Press de Banca con Pausa','Paused Bench Press','Un press de banca con barra en el que la pausa sobre el pecho elimina el rebote y endurece la fase inicial del empuje.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco plano y agarra la barra ligeramente más abierta que la anchura de los hombros.\n2. Saca la barra del rack y bájala hasta el pecho.\n3. Haz una pausa sobre el pecho durante 1-2 segundos.\n4. Empuja la barra hacia arriba hasta que los brazos queden completamente extendidos.\n5. Controla el descenso en cada repetición.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• No dejes que la barra se hunda en el pecho durante la pausa.\n• Mantén los omóplatos retraídos y pegados al banco.\n• Pide que alguien te asista cuando muevas cargas altas.\n\nMúsculos principales: pectoralis_major',NULL,'paused-bench-press.webp'),
(311,'Press Inclinado con Pausa','Paused Incline Bench Press','Un press inclinado con barra y pausa sobre la parte alta del pecho, que elimina el rebote y enfatiza pectoral superior y deltoides anterior.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco inclinado y agarra la barra ligeramente más abierta que la anchura de los hombros.\n2. Saca la barra del rack y bájala hasta el pecho superior.\n3. Haz una pausa sobre el pecho durante 1-2 segundos.\n4. Empuja la barra hacia arriba hasta que los brazos queden completamente extendidos.\n5. Mantén los omóplatos retraídos durante todo el ejercicio.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• No acortes la pausa cuando la carga se haga pesada.\n• Mantén las muñecas firmes sobre los codos durante el recorrido.\n• Mantén los pies firmes en el suelo durante toda la serie.\n\nMúsculos principales: anterior_deltoid, pectoralis_major',NULL,'paused-incline-bench-press.webp'),
(312,'Pec Deck','Pec Deck','Una máquina de aislamiento de pecho con almohadillas de codo fijas que trabaja los pectorales mediante aducción horizontal.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina pec deck y coloca los antebrazos contra las almohadillas.\n2. Ajusta el asiento para que las almohadillas queden a la altura media del pecho.\n3. Junta las almohadillas frente al pecho apretando.\n4. Mantén la contracción brevemente en el centro.\n5. Regresa con control a la posición inicial.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• No dejes que los brazos viajen demasiado atrás al abrir.\n• Mantén la espalda y los hombros pegados al respaldo.\n• Exhala al juntar las almohadillas e inhala al abrir.\n\nMúsculos principales: pectoralis_major',NULL,'pec-deck.webp'),
(313,'Remo Pendlay','Pendlay Row','Un remo estricto con barra realizado desde una parada muerta en el suelo entre repeticiones con el torso paralelo al suelo. Popularizado por el entrenador Glenn Pendlay.\n\nInstrucciones de ejecución:\n1. Carga una barra y colócala en el suelo.\n2. Bisagra en las caderas hasta que el torso quede paralelo al suelo con las rodillas ligeramente dobladas.\n3. Agarra la barra ligeramente más abierta que la anchura de los hombros con un agarre en pronación.\n4. Jala la barra de forma explosiva hacia el pecho inferior.\n5. Baja la barra al suelo con control y haz una pausa antes de la siguiente repetición.\n6. Repite.\n\nConsejos técnicos:\n• Cada repetición debe comenzar desde el suelo sin rebote.\n• Mantén el torso fijo a aproximadamente 90 grados; no uses el impulso del cuerpo.\n• Lleva los codos hacia arriba y atrás, no hacia los lados.\n\nMúsculos principales: latissimus_dorsi, rhomboids, trapezius',NULL,'pendlay-row.webp'),
(314,'Flexiones en Pica','Pike Push Ups','Una flexión realizada con las caderas elevadas en posición de pica, empujando en un ángulo pronunciado para cargar los hombros.\n\nInstrucciones de ejecución:\n1. Comienza en posición de perro boca abajo con las caderas altas y las manos a la anchura de los hombros.\n2. Acerca los pies a las manos.\n3. Dobla los codos y baja la cabeza hacia el suelo.\n4. Mantén las caderas altas durante todo el ejercicio.\n5. Empuja hacia arriba hasta que los brazos queden completamente extendidos.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Cuanto más altas las caderas, más trabajan los hombros.\n• Baja la cabeza hacia un punto ligeramente por delante de las manos.\n• Acerca los pies a las manos para progresar hacia las flexiones en pino.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'pike-push-ups.webp'),
(315,'Patada Lateral de Rodillas de Pilates','Pilates Kneeling Side Kick','Un ejercicio clásico de suelo: de rodillas con la mano apoyada en el suelo, la pierna de arriba oscila adelante y atrás a la altura de la cadera mientras el tronco permanece inmóvil.\n\nInstrucciones de ejecución:\n1. Arrodíllate y apoya en el suelo la mano del mismo lado, con la otra mano detrás de la cabeza.\n2. Extiende la pierna de arriba hacia el lado a la altura de la cadera, con el pie en flexión.\n3. Mantén el tronco completamente quieto y lleva la pierna hacia delante mientras la pelvis siga cuadrada.\n4. Lleva la pierna por detrás de la línea del cuerpo sin arquear la zona lumbar.\n5. Repite las veces indicadas y cambia de lado.\n\nConsejos técnicos:\n• El tronco es el ejercicio: si se balancea con la pierna, acorta el recorrido.\n• Mantén el hombro de apoyo alejado de la oreja.\n• Trabaja a un ritmo controlado en lugar de lanzar la pierna.\n\nMúsculos principales: gluteus_medius, obliques',NULL,'pilates-kneeling-side-kick.webp'),
(316,'Leg Pull Back de Pilates','Pilates Leg Pull Back','Una plancha invertida con elevaciones alternas de pierna: las caderas se mantienen altas mientras se eleva una pierna cada vez, de modo que glúteos y parte posterior del tronco trabajan ante el apoyo cambiante.\n\nInstrucciones de ejecución:\n1. Siéntate con las piernas estiradas y las manos en el suelo detrás de las caderas, con los dedos hacia delante.\n2. Empuja con manos y talones y eleva las caderas a una plancha invertida.\n3. Con las caderas niveladas y altas, eleva una pierna estirada mientras la pelvis siga quieta.\n4. Baja la pierna de forma controlada y repite con la otra.\n5. Termina la serie y baja las caderas al suelo.\n\nConsejos técnicos:\n• Detén la elevación donde las caderas empiecen a caer; la altura no es el objetivo.\n• Mantén el pecho abierto y los hombros lejos de las orejas.\n• Flexiona un poco las rodillas si la versión con piernas estiradas tira de los isquiotibiales.\n\nMúsculos principales: erector_spinae, gluteus_maximus',NULL,'pilates-leg-pull-back.webp'),
(317,'Leg Pull Front de Pilates','Pilates Leg Pull Front','Una plancha alta con elevaciones alternas de pierna: los hombros permanecen sobre las muñecas mientras se eleva una pierna cada vez, lo que añade una demanda antirrotación a la plancha.\n\nInstrucciones de ejecución:\n1. Colócate en plancha alta con las manos bajo los hombros y el cuerpo en línea.\n2. Aprieta el tronco y los glúteos para que las caderas no puedan rotar.\n3. Eleva una pierna estirada unos centímetros por encima de la cadera sin que la pelvis se incline.\n4. Bájala de forma controlada y repite con la otra pierna.\n5. Sigue alternando las veces indicadas.\n\nConsejos técnicos:\n• Eleva la pierna desde el glúteo y no arqueando la zona lumbar.\n• Reparte el peso entre ambas manos; la tendencia es inclinarse lejos del lado que se eleva.\n• Reduce la altura hasta que las caderas se mantengan perfectamente niveladas.\n\nMúsculos principales: gluteus_maximus, rectus_abdominis',NULL,'pilates-leg-pull-front.webp'),
(318,'Roll Down de Pilates','Pilates Roll Down','Una articulación de la columna de pie: la cabeza guía un descenso vértebra a vértebra hacia el suelo y de vuelta, movilizando toda la espalda mientras las piernas se mantienen estables.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies a la anchura de las caderas y los brazos colgando a los lados.\n2. Lleva la barbilla al pecho y empieza a rodar hacia abajo vértebra a vértebra.\n3. Deja los brazos y la cabeza colgando pesados cuando la columna esté completamente descendida.\n4. Sube por el mismo camino, apilando las vértebras una a una, la cabeza al final.\n5. Repite las veces indicadas.\n\nConsejos técnicos:\n• Mantén las rodillas blandas para que el movimiento venga de la columna y no de los isquiotibiales.\n• Ve lo bastante despacio como para sentir cada segmento; la velocidad arruina el ejercicio.\n• Mantén el peso en el centro de los pies mientras bajas.\n\nMúsculos principales: erector_spinae',NULL,'pilates-roll-down.webp'),
(319,'Roll Over de Pilates','Pilates Roll Over','Una inversión controlada desde la colchoneta: con los brazos presionando el suelo, las piernas estiradas viajan por encima de la cabeza hasta que los pies apuntan al suelo, y después la columna vuelve a bajar segmento a segmento.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con las piernas estiradas y los brazos presionando la colchoneta a los lados.\n2. Eleva ambas piernas a la vertical sin dejar que la zona lumbar se arquee.\n3. Presiona los brazos hacia abajo y lleva las piernas por encima de la cabeza hasta dejarlas paralelas al suelo por detrás.\n4. Abre un poco las piernas, flexiona los pies y baja la columna vértebra a vértebra.\n5. Devuelve las piernas a la vertical y repite las veces indicadas.\n\nConsejos técnicos:\n• Impulsa el movimiento con el abdomen, no lanzando las piernas.\n• Mantén el peso fuera del cuello: el descenso se detiene en las escápulas.\n• Evita este ejercicio si tienes molestias cervicales y constrúyelo antes con curls más pequeños.\n\nMúsculos principales: rectus_abdominis, transverse_abdominis',NULL,'pilates-roll-over.webp'),
(320,'La Sierra de Pilates','Pilates Saw','Un giro con flexión sentado: sentado erguido con las piernas abiertas, el torso rota y después se pliega sobre la pierna contraria para que la mano que alcanza pase junto al dedo meñique como una sierra.\n\nInstrucciones de ejecución:\n1. Siéntate erguido con las piernas estiradas y algo más abiertas que las caderas, los brazos hacia los lados.\n2. Rota el torso hacia un lado manteniendo ambos isquiones en el suelo.\n3. Pliégate hacia delante sobre esa pierna y alcanza con la mano contraria más allá del dedo meñique.\n4. Vuelve a subir a través de la columna y regresa al centro.\n5. Repite hacia el otro lado y sigue alternando.\n\nConsejos técnicos:\n• Ancla ambos isquiones; si uno se levanta, el giro se convierte en una inclinación.\n• Primero rota y después pliégate: ese orden es lo que hace funcionar el ejercicio.\n• Siéntate sobre una manta doblada si la pelvis no puede mantenerse erguida.\n\nMúsculos principales: erector_spinae, obliques',NULL,'pilates-saw.webp'),
(321,'Flexión Lateral de Pilates','Pilates Side Bend','Un ejercicio lateral del tronco desde un apoyo de costado: las caderas se elevan y el brazo de arriba se estira por encima de la cabeza, curvando el cuerpo de lado sobre el brazo de apoyo.\n\nInstrucciones de ejecución:\n1. Siéntate sobre una cadera con las piernas dobladas hacia un lado y la mano de apoyo en el suelo bajo el hombro.\n2. Empuja con la mano y la pierna inferior para elevar las caderas del suelo.\n3. Estira el brazo de arriba por encima de la cabeza para formar un arco largo desde la mano hasta los pies.\n4. Baja las caderas de forma controlada hacia la colchoneta.\n5. Completa las repeticiones y cambia de lado.\n\nConsejos técnicos:\n• Empuja el suelo para que el hombro de apoyo quede estable y alineado.\n• Alarga el brazo de arriba en lugar de dejarte caer hacia el lado.\n• Mantén el movimiento fluido: subir y bajar duran lo mismo.\n\nMúsculos principales: gluteus_medius, obliques',NULL,'pilates-side-bend.webp'),
(322,'Spine Stretch Forward de Pilates','Pilates Spine Stretch Forward','Una articulación sentada: sentado erguido con las piernas abiertas, la columna se enrolla hacia delante segmento a segmento sobre las piernas y después vuelve a apilarse vértebra a vértebra.\n\nInstrucciones de ejecución:\n1. Siéntate erguido con las piernas estiradas y algo más abiertas que las caderas, los pies en flexión.\n2. Estira los brazos hacia delante a la altura de los hombros.\n3. Baja la barbilla y enrolla la columna hacia delante vértebra a vértebra, alcanzando más allá de los pies.\n4. Vuelve a apilar la columna desde la base hasta quedar sentado erguido.\n5. Repite las veces indicadas.\n\nConsejos técnicos:\n• Mantén la pelvis erguida: la curva viene de la columna, no de bascular la cadera.\n• Empuja los talones hacia fuera todo el tiempo para que las piernas sigan activas.\n• Siéntate sobre una manta doblada si ya sentarte erguido te redondea la zona lumbar.\n\nMúsculos principales: erector_spinae, rectus_abdominis',NULL,'pilates-spine-stretch-forward.webp'),
(323,'Spine Twist de Pilates','Pilates Spine Twist','Una rotación sentada con las piernas juntas y los brazos abiertos: el tronco gira a cada lado de forma controlada mientras la pelvis y las piernas permanecen completamente quietas.\n\nInstrucciones de ejecución:\n1. Siéntate erguido con las piernas estiradas y juntas, los pies en flexión y los brazos abiertos a la altura de los hombros.\n2. Crece a través de la columna y presiona ambos isquiones contra el suelo.\n3. Rota el tronco hacia un lado mientras las caderas sigan cuadradas y vuelve al centro.\n4. Rota hacia el otro lado del mismo modo.\n5. Sigue alternando las veces indicadas.\n\nConsejos técnicos:\n• Las piernas son el ancla: si un pie se adelanta, la pelvis se ha movido.\n• Alárgate hacia arriba antes de cada rotación en lugar de hundirte en ella.\n• Gira la cabeza con el tronco en lugar de que ella lidere.\n\nMúsculos principales: obliques',NULL,'pilates-spine-twist.webp'),
(324,'Sentadilla a una Pierna (Pistol)','Pistol Squat','Una sentadilla a una pierna con la pierna libre extendida adelante, que exige fuerza y equilibrio.\n\nInstrucciones de ejecución:\n1. Mantente sobre una pierna, la otra extendida al frente, brazos al lado para equilibrio.\n2. Flexiona la cadera y la rodilla de apoyo, manteniendo el pecho arriba.\n3. Baja lentamente hasta que la parte posterior del muslo toque la pantorrilla.\n4. Empuja con el talón de apoyo para volver a subir.\n5. Repeticiones por lado, luego cambia de pierna.\n\nConsejos técnicos:\n• Sostén un contrapeso ligero al pecho si te cuesta el equilibrio.\n• Construye la fuerza primero con pistol asistido sobre cajón.\n• Mantén el talón de trabajo plano en el suelo.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'pistol-squat.webp'),
(325,'Elevación de Pantorrilla a la Burra en Máquina','Plate-Loaded Donkey Calf Raise','Una elevación de pantorrilla a la burra en una máquina de discos, con una almohadilla sobre las caderas y el torso inclinado hacia delante para estirar los gemelos en la parte baja de cada repetición.\n\nInstrucciones de ejecución:\n1. Carga los soportes de discos y sube a la plataforma con los metatarsos en el borde y los talones al aire.\n2. Inclínate hacia delante desde las caderas, coloca la almohadilla sobre ellas y apoya los antebrazos en el soporte que tienes delante.\n3. Mantén las rodillas estiradas y la espalda plana, con el torso cerca de la paralela al suelo.\n4. Empuja con los metatarsos y eleva los talones tan alto como puedas, con una pausa breve arriba.\n5. Baja los talones por debajo de la plataforma hasta notar un estiramiento fuerte en los gemelos y repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• La inclinación hacia delante es el ejercicio. Ponerte erguido lo convierte en una elevación de talones de pie corriente y regala justo el estiramiento extra que venías a buscar.\n• Mantén las rodillas estiradas todo el tiempo. Flexionarlas traslada el trabajo del gemelo al sóleo, y eso es la elevación sentado, no esta.\n• Deja que los talones bajen del todo por debajo del borde de la plataforma. La parte baja del recorrido es lo que justifica esta máquina, y recortarla desperdicia todo el montaje.\n\nMúsculos principales: gastrocnemius',NULL,'plate-loaded-donkey-calf-raise.webp'),
(326,'Empuje de Glúteo en Máquina de Discos','Plate-Loaded Glute Drive','Un empuje de cadera en una máquina de glúteo de discos, donde el respaldo y la plataforma integrados fijan la posición para que las caderas extiendan contra la carga sin tener que montar un banco.\n\nInstrucciones de ejecución:\n1. Carga los soportes de discos por igual y siéntate en la máquina con la parte alta de la espalda contra el respaldo y los pies planos en la plataforma.\n2. Baja la almohadilla o barra sobre tus caderas y ajústala para que apoye en el pliegue de la cadera y no sobre el abdomen.\n3. Coloca los pies de modo que las espinillas queden verticales cuando las caderas estén arriba, y sujeta las empuñaduras.\n4. Empuja las caderas hacia arriba apretando los glúteos hasta que los muslos queden alineados con el torso, y mantén un instante arriba.\n5. Baja de forma controlada hasta justo antes del final del recorrido y repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Coloca la almohadilla en el pliegue de la cadera. Dejarla sobre el abdomen es lo único realmente incómodo de esta máquina, y se resuelve moviendo la almohadilla, no añadiendo acolchado.\n• Termina el movimiento con la cadera, no con la zona lumbar. Si arriba se te abren las costillas es que se acabó la extensión de cadera y has empezado a arquear, que es donde la máquina deja de entrenar el glúteo.\n• Este es el empuje de cadera al que recurrir cuando el banco y la barra están ocupados: el respaldo y la plataforma forman parte del bastidor, así que no hay montaje que hacer mal.\n\nMúsculos principales: gluteus_maximus',NULL,'plate-loaded-glute-drive.webp'),
(327,'Elevación Lateral en Máquina de Discos','Plate-Loaded Lateral Raise','Una elevación lateral sentado en una máquina de discos, donde unas almohadillas apoyan contra los brazos para que los deltoides laterales levanten la carga sin sujetarla con las manos.\n\nInstrucciones de ejecución:\n1. Ajusta la altura del asiento para que el eje de giro de las almohadillas quede alineado con la punta de tus hombros al sentarte.\n2. Carga los soportes de discos por igual en ambos lados y siéntate con la espalda apoyada en el respaldo.\n3. Coloca la cara externa de los brazos contra las almohadillas, con los codos flexionados y los brazos colgando.\n4. Empuja hacia fuera y hacia arriba contra las almohadillas hasta que los brazos queden aproximadamente a la altura de los hombros.\n5. Baja de forma controlada hasta que los brazos vuelvan a los costados y repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Ajusta primero el asiento. Si el eje queda por debajo del hombro, las almohadillas llevan el brazo cruzado por delante del cuerpo en lugar de hacia el lado, y el deltoides lateral deja de ser el músculo que trabaja.\n• Empuja con el brazo, no con la mano. Las empuñaduras solo sirven para que los brazos no resbalen de las almohadillas: apretarlas mete el bíceps y el antebrazo en una elevación que debería ser puro deltoides.\n• Detente a la altura del hombro. Subir más entrega la última parte de la repetición al trapecio, y la máquina te dejará hacerlo sin protestar.\n\nMúsculos principales: lateral_deltoid',NULL,'plate-loaded-lateral-raise.webp'),
(328,'Encogimiento de Hombros en Máquina de Discos','Plate-Loaded Shrug','Un encogimiento de hombros de pie en una máquina de discos, levantando unas empuñaduras que cuelgan a los costados para que el trapecio trabaje sin una barra por delante o por detrás de las piernas.\n\nInstrucciones de ejecución:\n1. Carga los soportes de discos por igual y súbete a la plataforma de la máquina, de espaldas al bastidor.\n2. Toma una empuñadura con cada mano, con los brazos colgando rectos a los costados y los hombros relajados.\n3. Ponte erguido con el pecho alto, la barbilla nivelada y las rodillas ligeramente flexionadas.\n4. Encoge los hombros en línea recta hacia las orejas todo lo que puedas y mantén un instante arriba.\n5. Baja de forma controlada hasta que los hombros queden completamente abajo y repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Encoge en línea recta hacia arriba. Rotar los hombros añade recorrido pero no trabajo extra del trapecio, y lleva la articulación del hombro a describir un círculo bajo carga para nada.\n• Mantén los brazos rectos y pasivos. Flexionar los codos convierte el movimiento en un remo vertical corto y quita la carga del trapecio.\n• Las empuñaduras colgando a los costados son la razón de ser de esta máquina: no hay barra que esquivar en los muslos, así que puedes estar erguido y usar todo el recorrido sin acortar la parte alta.\n\nMúsculos principales: trapezius',NULL,'plate-loaded-shrug.webp'),
(329,'Agarre de Discos','Plate Pinch','Un ejercicio clásico para el agarre: pellizca dos discos con la cara lisa hacia afuera y mantenlos durante un tiempo determinado, cargando los flexores del pulgar y los dedos en trabajo isométrico sostenido.\n\nInstrucciones de ejecución:\n1. Coloca dos discos en el suelo uno al lado del otro con las caras lisas hacia afuera.\n2. Baja en sentadilla, agarra ambos discos juntos entre los dedos y el pulgar de una mano — sin agarraderas, solo pellizca.\n3. Levántate y sostén los discos al costado durante el tiempo deseado, manteniendo el brazo recto.\n4. Devuélvelos al suelo con control.\n5. Repite con la otra mano.\n\nConsejos técnicos:\n• Empieza con dos discos de 5 kg / 10 lb y ve aumentando.\n• La magnesia en las manos marca una gran diferencia; con las manos sudadas el agarre falla rápido.\n\nMúsculos principales: forearm_flexors',NULL,'plate-pinch.webp'),
(330,'Pullover con Disco','Plate Pullover','Un pullover sosteniendo un disco, que trabaja dorsales, pecho y serrato.\n\nInstrucciones de ejecución:\n1. Acuéstate plano en un banco sujetando un disco con ambas manos.\n2. Empuja el disco sobre el pecho con los brazos casi rectos.\n3. Baja el disco en arco por detrás de la cabeza hasta sentir el estiramiento.\n4. Tira del disco de regreso sobre el pecho por el mismo arco.\n5. Repite el número de repeticiones indicado.\n\nConsejos técnicos:\n• Mantén los codos suaves pero con el mismo ángulo.\n• Detente al final de tu rango limpio — sin estiramiento excesivo del hombro.\n• Apoya bien los pies para mantener la estabilidad.\n\nMúsculos principales: latissimus_dorsi, pectoralis_major',NULL,'plate-pullover.webp'),
(331,'Zancada Pliométrica','Plyo Lunge','Un salto explosivo en posición de zancada que cambia las piernas en el aire, alternando cada repetición.\n\nInstrucciones de ejecución:\n1. Comienza en una zancada con un pie adelantado.\n2. Baja a una zancada profunda con la rodilla trasera casi tocando el suelo.\n3. Despega ambos pies y cambia las piernas en el aire.\n4. Aterriza suave en zancada con la pierna opuesta adelante.\n5. Continúa alternando sin pausa.\n\nConsejos técnicos:\n• Aterriza suave con las rodillas flexionadas.\n• Cambia la posición de las piernas por completo — no solo saltes en el sitio.\n• Mantén el torso erguido — no te inclines adelante.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'plyo-lunge.webp'),
(332,'Curl en Banco Scott','Preacher Curl','Una variación del curl que usa un banco Scott para aislar el bíceps.\n\nInstrucciones de ejecución:\n1. Siéntate en el banco Scott con los brazos apoyados en el pad.\n2. Sostén una barra Z con agarre supinado.\n3. Sube la barra hacia los hombros.\n4. Baja con control hasta que los brazos queden casi extendidos.\n5. Repite.\n\nConsejos técnicos:\n• Evita los rebotes en la parte baja del recorrido.\n• Mantén las muñecas neutras sobre la barra EZ.\n• Sube la barra sin impulso de hombros ni espalda.\n\nMúsculos principales: biceps_brachii',NULL,'preacher-curl.webp'),
(333,'Curl Martillo en Banco Scott','Preacher Hammer Curl','Un curl de bíceps en banco Scott con agarre neutro tipo martillo que enfatiza el braquial y los antebrazos.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco Scott con una mancuerna en cada mano.\n2. Apoya los brazos superiores en la almohadilla con las palmas enfrentadas.\n3. Flexiona las mancuernas hacia arriba manteniendo las muñecas neutras.\n4. Contrae el bíceps en la parte alta del movimiento.\n5. Baja las mancuernas con control.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén los brazos superiores apoyados en la almohadilla.\n• Evita bloquear completamente los codos en la parte baja.\n• Controla la bajada en lugar de dejar caer el peso.\n\nMúsculos principales: brachialis, brachioradialis',NULL,'preacher-hammer-curl.webp'),
(334,'Push-Ups de Pseudo Plancha','Pseudo Planche Push Ups','Una flexión con las manos giradas hacia atrás y los hombros inclinados muy por delante de las muñecas, imitando la carga de la plancha.\n\nInstrucciones de ejecución:\n1. Comienza en posición de push-up con las manos giradas de modo que los dedos apunten hacia atrás.\n2. Inclina los hombros hacia adelante por delante de las muñecas.\n3. Baja el pecho hacia el suelo flexionando los codos.\n4. Mantén el cuerpo en línea recta.\n5. Empuja hacia arriba manteniendo la inclinación hacia adelante.\n6. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Cuanto más te inclines hacia delante, más difícil será cada repetición.\n• Mantén los codos pegados al cuerpo al bajar.\n• Mantén las escápulas protraídas y el cuerpo rígido.\n\nMúsculos principales: anterior_deltoid, pectoralis_major',NULL,'pseudo-planche-push-ups.webp'),
(335,'Jerk de Empuje','Push Jerk','Un levantamiento por encima de la cabeza que usa una flexión y un impulso de piernas para lanzar la barra arriba, recibida en un cuarto de sentadilla.\n\nInstrucciones de ejecución:\n1. Sostén la barra en posición de rack frontal sobre los hombros.\n2. Párate con los pies a la anchura de las caderas.\n3. Flexiona ligeramente las rodillas.\n4. Impulsa explosivamente con las piernas y empuja la barra sobre la cabeza.\n5. Baja a una sentadilla de un cuarto debajo de la barra y bloquea los brazos.\n6. Levántate completamente y baja la barra para repetir.\n\nConsejos técnicos:\n• Mantén el torso erguido durante la flexión.\n• Impulsa con las piernas antes de empujar con los brazos.\n• Bloquea los brazos mientras bajas debajo de la barra.\n\nMúsculos principales: anterior_deltoid, triceps_brachii',NULL,'push-jerk.webp'),
(336,'Press de Empuje','Push Press','Un press de barra sobre la cabeza que usa el impulso de las piernas para empujar cargas más pesadas.\n\nInstrucciones de ejecución:\n1. Párate con la barra apoyada en los deltoides frontales.\n2. Flexiona ligeramente las rodillas.\n3. Impulsa con las piernas y empuja la barra sobre la cabeza.\n4. Bloquea completamente.\n5. Baja al inicio.\n6. Repite.\n\nConsejos técnicos:\n• Usa el impulso de las piernas solo para iniciar — termina con los hombros.\n• Mantén el core apretado en todo momento.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'push-press.webp'),
(337,'Push-Up','Push-Up','Un ejercicio fundamental con el peso corporal para el pecho, los hombros y los tríceps.\n\nInstrucciones de ejecución:\n1. Comienza en posición de plancha alta con las manos a la anchura de los hombros.\n2. Baja el cuerpo hasta que el pecho casi toque el suelo.\n3. Empuja hacia arriba hasta la posición inicial.\n4. Mantén el cuerpo en línea recta en todo momento.\n5. Repite.\n\nConsejos técnicos:\n• Aprieta el abdomen y los glúteos para evitar que la cadera caiga.\n• No abras los codos en exceso; mantenlos cerca del torso.\n• Mantén el cuello neutro mirando al suelo.\n\nMúsculos principales: pectoralis_major, triceps_brachii',NULL,'push-up.webp'),
(338,'Rack Pull','Rack Pull','Una variación de peso muerto en rango parcial desde pines a la altura de las rodillas, que enfatiza la parte superior de la espalda, el trapecio y la fuerza de bloqueo con cargas superiores al peso muerto completo.\n\nInstrucciones de ejecución:\n1. Coloca los pines de seguridad en un rack a la altura de las rodillas y apoya una barra cargada sobre ellos.\n2. Párate con los pies al ancho de caderas y agarra la barra justo fuera de las piernas.\n3. Activa el core, retrae las escápulas y empuja con las piernas para levantar la barra.\n4. Extiende completamente caderas y rodillas en la parte superior.\n5. Baja la barra a los pines con control y reposiciónate antes de la siguiente repetición.\n\nConsejos técnicos:\n• Usa una bisagra de cadera — mantén la barra cerca del cuerpo en todo momento.\n• Los rack pulls permiten cargas superiores a tu máximo de peso muerto para sobrecargar el bloqueo.\n• Enfócate en la tensión de la parte superior de la espalda para evitar el redondeo con cargas pesadas.\n\nMúsculos principales: erector_spinae, gluteus_maximus, hamstrings, trapezius',NULL,'rack-pull.webp'),
(339,'Apertura de Deltoides Posterior','Rear Delt Fly','Un movimiento de aislamiento que trabaja los deltoides posteriores y la parte superior de la espalda.\n\nInstrucciones de ejecución:\n1. Sostén las mancuernas e inclínate hacia adelante desde las caderas.\n2. Con una ligera flexión en los codos, eleva las mancuernas hacia los lados.\n3. Aprieta las escápulas en la parte superior.\n4. Baja con control.\n5. Repite.\n\nConsejos técnicos:\n• Elige un peso ligero para no usar impulso.\n• Mantén la espalda recta mientras estás inclinado hacia delante.\n• Lidera el movimiento con los codos, no con las manos.\n\nMúsculos principales: posterior_deltoid, rhomboids',NULL,'rear-delt-fly.webp'),
(340,'Crunches Inversos','Reverse Crunches','Un ejercicio de core en el suelo que enrolla la cadera hacia el pecho para trabajar la parte baja del abdomen.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con los brazos a los lados.\n2. Eleva las piernas con las rodillas flexionadas a 90 grados.\n3. Despega las caderas del suelo contrayendo el abdomen inferior.\n4. Lleva las rodillas hacia el pecho.\n5. Baja las caderas con control.\n6. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Despega la cadera con el abdomen, no con impulso de las piernas.\n• Exhala al subir para activar mejor el abdomen.\n• Presiona los brazos contra el suelo para mayor estabilidad.\n\nMúsculos principales: rectus_abdominis',NULL,'reverse-crunches.webp'),
(341,'Curl Inverso','Reverse Curl','Un curl con barra en agarre prono que trabaja el braquial y los extensores del antebrazo.\n\nInstrucciones de ejecución:\n1. Párate y sostén la barra con agarre prono.\n2. Sube la barra hacia los hombros.\n3. Baja con control.\n4. Repite.\n\nConsejos técnicos:\n• Mantén las muñecas rectas.\n• Realiza el movimiento en un rango completo de movimiento.\n\nMúsculos principales: brachialis, forearm_extensors',NULL,'reverse-curl.webp'),
(342,'Remo Inclinado con Agarre Invertido','Reverse Grip Bent Over Row','Un remo con barra y agarre supino que trabaja dorsales y romboides, con participación de los bíceps.\n\nInstrucciones de ejecución:\n1. Párate con los pies a la anchura de los hombros y agarra la barra con agarre supinado.\n2. Inclínate hacia adelante desde las caderas con una ligera flexión de rodillas.\n3. Deja que la barra cuelgue con los brazos extendidos.\n4. Jala la barra hacia el abdomen inferior llevando los codos hacia atrás.\n5. Aprieta la espalda en la parte superior.\n6. Baja la barra con control.\n7. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Mantén la espalda neutra y el core firme durante todo el recorrido.\n• No uses impulso con el torso; el cuerpo queda inclinado y estable.\n• Mantén las muñecas rectas para proteger los codos con este agarre.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'reverse-grip-bent-over-row.webp'),
(343,'Jalón al Pecho Agarre Supino','Reverse Grip Lat Pulldown','Una variante del jalón al pecho con agarre supino que aumenta la participación del bíceps.\n\nInstrucciones de ejecución:\n1. Coloca una barra recta en una máquina de jalón al pecho.\n2. Sujeta la barra con agarre supino, al ancho de los hombros.\n3. Siéntate y asegura tus muslos bajo la almohadilla.\n4. Tira de la barra hacia la parte superior del pecho.\n5. Contrae el dorsal y el bíceps en la parte baja.\n6. Vuelve la barra a la posición inicial con control.\n7. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén el pecho erguido y evita inclinarte demasiado hacia atrás.\n• Tira con los codos, no solo con las manos.\n• Contrae el dorsal en la parte baja del movimiento.\n\nMúsculos principales: biceps_brachii, latissimus_dorsi',NULL,'reverse-grip-lat-pulldown.webp'),
(344,'Zancada Inversa','Reverse Lunge','Una variación de la zancada que da un paso hacia atrás para mayor estabilidad de rodilla.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo mancuernas a los costados.\n2. Da un paso hacia atrás con una pierna y baja la rodilla hacia el suelo.\n3. Baja hasta que el muslo delantero quede paralelo al suelo.\n4. Empuja con el talón delantero para volver a la posición de pie.\n5. Repite en ambos lados.\n\nConsejos técnicos:\n• Da el paso atrás lo bastante largo para que la rodilla delantera no pase del pie.\n• Mantén el torso erguido y las mancuernas pegadas al cuerpo.\n• Completa el mismo número de repeticiones con cada pierna.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'reverse-lunge.webp'),
(345,'Nordic Curl Inverso','Reverse Nordic Curl','Un ejercicio de cuádriceps con el propio peso corporal, arrodillado, inclinando el torso hacia atrás con control mientras se mantiene la cadera extendida.\n\nInstrucciones de ejecución:\n1. Arrodíllate sobre una almohadilla con los pies planos y el torso erguido.\n2. Mantén la cadera extendida y el core activado.\n3. Inclina el torso lentamente hacia atrás manteniendo el cuerpo en línea recta.\n4. Baja tanto como puedas controlar con el cuádriceps.\n5. Vuelve a subir a la posición inicial.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén la cadera extendida en todo momento, sin que se doble.\n• Baja solo hasta donde puedas controlar el movimiento.\n• Usa una almohadilla bajo las rodillas para mayor comodidad.\n\nMúsculos principales: quadriceps',NULL,'reverse-nordic-curl.webp'),
(346,'Fondos en Plancha Invertida','Reverse Plank Dips','Fondos de tríceps desde una plancha invertida con las piernas estiradas: las piernas permanecen largas y las caderas altas mientras los codos se flexionan y estiran.\n\nInstrucciones de ejecución:\n1. Siéntate con las piernas estiradas y las manos en el suelo detrás de las caderas, con los dedos hacia delante.\n2. Empuja con manos y talones y eleva las caderas a una plancha invertida con las piernas estiradas.\n3. Flexiona los codos hacia atrás y baja un poco las caderas hacia el suelo.\n4. Empuja de nuevo hasta bloquear los brazos, manteniendo las caderas altas.\n5. Repite las veces indicadas.\n\nConsejos técnicos:\n• Mantén las caderas elevadas abajo; sentarte entre repeticiones quita la carga.\n• Lleva los codos rectos hacia atrás en lugar de abrirlos hacia fuera.\n• Flexiona las rodillas si la versión con piernas estiradas exige demasiado a los isquiotibiales.\n\nMúsculos principales: triceps_brachii',NULL,'reverse-plank-dips.webp'),
(347,'Pulsos de Cadera en Mesa Invertida','Reverse Tabletop Hip Pulses','Pulsos de glúteo desde la mesa invertida: los brazos permanecen estirados y solo las caderas bajan y suben, de modo que el trabajo se queda en el glúteo y no en el tríceps.\n\nInstrucciones de ejecución:\n1. Siéntate con las rodillas flexionadas, los pies apoyados y las manos en el suelo detrás de ti.\n2. Empuja con manos y pies y eleva las caderas hasta que el tronco quede a la altura de las rodillas.\n3. Con los codos estirados, baja las caderas unos centímetros.\n4. Aprieta los glúteos para volver a subirlas al nivel.\n5. Pulsa las veces indicadas y baja.\n\nConsejos técnicos:\n• Mantén los brazos bloqueados: flexionar los codos convierte esto en un fondo.\n• Impulsa desde los talones y los glúteos, no desde la zona lumbar.\n• Mantén el pecho abierto y los hombros lejos de las orejas.\n\nMúsculos principales: gluteus_maximus',NULL,'reverse-tabletop-hip-pulses.webp'),
(348,'Fondos en Anillas','Ring Dips','Un fondo con el peso corporal desafiante realizado en anillas de gimnasia, que exige mayor estabilización que los fondos en barra.\n\nInstrucciones de ejecución:\n1. Apóyate en las anillas con los brazos bloqueados.\n2. Baja el cuerpo flexionando los codos hasta que los brazos queden paralelos al suelo.\n3. Empuja hacia arriba hasta la posición inicial.\n4. Repite.\n\nConsejos técnicos:\n• Mantén las anillas cerca del cuerpo.\n• Gira las anillas hacia afuera en la parte superior para mayor activación del pecho.\n\nMúsculos principales: pectoralis_major, triceps_brachii',NULL,'ring-dips.webp'),
(349,'Face Pull en Anillas','Ring Face Pull','Un face pull en anillas de gimnasia para resistencia ajustable y mejora de la salud del hombro.\n\nInstrucciones de ejecución:\n1. Agarra las anillas e inclínate hacia atrás de modo que el cuerpo quede en ángulo.\n2. Jala las anillas hacia la cara, abriendo los codos hacia los lados.\n3. Mantén brevemente y luego regresa.\n4. Repite.\n\nConsejos técnicos:\n• Ajusta el ángulo del cuerpo para controlar la dificultad.\n• Rota los brazos externamente en la parte superior.\n\nMúsculos principales: posterior_deltoid, rhomboids',NULL,'ring-face-pull.webp'),
(350,'Muscle-Up en Anillas','Ring Muscle-Up','Un movimiento avanzado de calistenia que combina dominada y fondo en anillas de gimnasia.\n\nInstrucciones de ejecución:\n1. Cuelga de las anillas con agarre falso, palmas enfrentadas.\n2. Tira explosivamente, llevando el pecho hacia las anillas.\n3. Pasa los codos por encima de las anillas mientras sube el pecho.\n4. Empuja arriba hasta extender los brazos.\n5. Baja con control pasando por la transición hasta volver al colgado.\n\nConsejos técnicos:\n• El agarre falso es clave para la transición.\n• Empuja los codos hacia abajo con fuerza durante la transición.\n• Construye la fuerza primero con negativas y asistido con banda.\n\nMúsculos principales: latissimus_dorsi, pectoralis_major, triceps_brachii',NULL,'ring-muscle-up.webp'),
(351,'Flexión en Anillas','Ring Push-Up','Una flexión sobre anillas de gimnasia, que exige más a los estabilizadores del pecho, hombros y core.\n\nInstrucciones de ejecución:\n1. Coloca las anillas justo por encima del suelo.\n2. Sujeta las anillas y adopta posición de plank con los brazos rectos.\n3. Baja el pecho hacia las anillas, codos pegados al cuerpo.\n4. Empuja arriba hasta extender los brazos.\n5. Repite el número de repeticiones indicado.\n\nConsejos técnicos:\n• Gira las anillas hacia afuera arriba para activar más el pecho.\n• Activa el core — las anillas amplifican cualquier oscilación.\n• Apoya las rodillas para escalar la dificultad.\n\nMúsculos principales: pectoralis_major, triceps_brachii',NULL,'ring-push-up.webp'),
(352,'Remo en Anillas','Ring Row','Un remo con peso corporal en anillas de gimnasia, realizado en ángulo para trabajar espalda y bíceps.\n\nInstrucciones de ejecución:\n1. Coloca las anillas a la altura de la cadera o el pecho.\n2. Sujeta las anillas con las palmas enfrentadas, inclínate atrás con los brazos rectos.\n3. Activa el core y tira del pecho hacia las anillas.\n4. Junta los omóplatos arriba.\n5. Baja con control hasta extender los brazos.\n\nConsejos técnicos:\n• Cuanto más bajo el ángulo del cuerpo, más difícil el remo.\n• Mantén el cuerpo recto — no dejes caer las caderas.\n• Tira con los codos atrás, no abiertos, para más implicación dorsal.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'ring-row.webp'),
(353,'Remo Invertido en Anillas','Rings Inverted Row','Un remo horizontal con peso corporal en anillas cerca del suelo, más difícil que el remo de pie en anillas.\n\nInstrucciones de ejecución:\n1. Coloca las anillas justo por encima de la cadera.\n2. Acuéstate bajo las anillas y agárralas con las palmas enfrentadas.\n3. Camina con los pies adelante hasta que el cuerpo forme una línea recta.\n4. Tira del pecho hacia las anillas, juntando los omóplatos.\n5. Baja con control hasta extender los brazos.\n\nConsejos técnicos:\n• Mantén el cuerpo en línea recta — de los talones a la cabeza.\n• Activa glúteos y core para no hundirte.\n• Eleva los pies en un cajón para una versión más difícil.\n\nMúsculos principales: latissimus_dorsi, rhomboids, trapezius',NULL,'rings-inverted-row.webp'),
(354,'Peso Muerto Rumano','Romanian Deadlift','Un movimiento de bisagra de cadera que enfatiza los isquiotibiales y los glúteos.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo la barra a la altura de las caderas con agarre prono.\n2. Bisagra en las caderas empujándolas hacia atrás mientras mantienes las piernas casi rectas.\n3. Baja la barra a lo largo de las piernas hasta sentir el estiramiento de los isquiotibiales.\n4. Empuja las caderas hacia adelante para volver a la posición de pie.\n5. Repite.\n\nConsejos técnicos:\n• No redondees la espalda baja; mantén la columna neutra.\n• Baja solo hasta donde llegues sin perder la postura.\n• Aprieta los dorsales para mantener la barra cerca del cuerpo.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'romanian-deadlift.webp'),
(355,'Máquina de Remo','Rowing Machine','Un ejercicio cardiovascular de cuerpo completo en la máquina de remo: cada palada empuja con las piernas, lleva el torso hacia atrás y tira de la manija hasta las costillas, trabajando piernas, espalda y brazos en un ciclo continuo.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de remo, sujeta los pies con las correas de las plataformas y agarra la manija en pronación.\n2. Deslízate hacia delante hasta la posición de ataque: tibias verticales, torso ligeramente por delante de la cadera y brazos estirados hacia el volante.\n3. Empuja primero con las piernas y desplaza el asiento hacia atrás hasta dejar las rodillas casi estiradas.\n4. Lleva el torso hacia atrás pasando de la vertical y tira entonces de la manija hasta las costillas bajas, con los codos pasando junto a los costados.\n5. Invierte el orden en la recuperación — primero los brazos hacia delante, después el torso y por último flexionar las rodillas — y vuelve a deslizarte hasta la posición de ataque para la siguiente palada.\n6. Continúa durante el tiempo, la distancia o el número de paladas que quieras.\n\nConsejos técnicos:\n• Respeta el orden: piernas, torso y brazos en el tirón, y brazos, torso y piernas en la recuperación. Flexionar los brazos antes de tiempo desaprovecha la parte más fuerte de la palada.\n• Rema con la espalda plana y el core activado: redondear la zona lumbar en la posición de ataque es lo que convierte el remo en dolor de espalda en lugar de trabajo cardiovascular.\n• Lleva la manija en línea recta y horizontal hasta las costillas bajas, y haz la recuperación unas dos veces más lenta que el tirón en lugar de volver de golpe.\n\nMúsculos principales: latissimus_dorsi, quadriceps',NULL,'rowing-machine.webp'),
(356,'Correr','Running','Carrera al aire libre, con una fase de vuelo en cada zancada en la que ningún pie toca el suelo — el impacto y el esfuerzo que la separan de caminar.\n\nInstrucciones de ejecución:\n1. Empieza con un trote suave y sube hasta tu ritmo durante los primeros minutos, en lugar de salir directamente a la velocidad objetivo.\n2. Apoya el pie bajo la cadera, no por delante del cuerpo, y mantén el contacto con el suelo corto y silencioso.\n3. Corre erguido desde la cadera, con una ligera inclinación desde los tobillos y sin doblarte por la cintura.\n4. Flexiona los codos unos noventa grados y lleva los brazos adelante y atrás, sin cruzarlos sobre el pecho.\n5. Respira con ritmo y mantén sueltos los hombros, la mandíbula y las manos.\n6. Sostén el ritmo el tiempo o la distancia deseados, luego trota y camina unos minutos para terminar.\n\nConsejos técnicos:\n• Aumenta el volumen semanal poco a poco. Casi toda lesión al correr viene de sumar kilómetros más rápido de lo que se adaptan tendones y huesos, no de una sola tirada dura.\n• La mayor parte de tus carreras debe ser lo bastante suave como para poder hablar. Correr cada sesión a un ritmo medio-fuerte es la vía más rápida al estancamiento.\n• Si notas que pisas con estruendo, acorta la zancada y deja subir la cadencia — buscar un paso más largo pone el freno en cada apoyo.\n\nMúsculos principales: gastrocnemius, quadriceps',NULL,'running.webp'),
(357,'Giro Ruso','Russian Twist','Un ejercicio de core rotacional que trabaja los oblicuos.\n\nInstrucciones de ejecución:\n1. Siéntate en el suelo con las rodillas flexionadas e inclínate ligeramente hacia atrás.\n2. Junta las manos o sostén un peso a la altura del pecho.\n3. Rota el torso hacia un lado, luego hacia el otro.\n4. Mantén el core apretado en todo momento.\n5. Repite.\n\nConsejos técnicos:\n• Gira desde el torso, no solo con los brazos.\n• Mantén la espalda recta aunque estés ligeramente reclinado.\n• Hazlo lento y controlado; la velocidad resta trabajo a los oblicuos.\n\nMúsculos principales: obliques, rectus_abdominis',NULL,'russian-twist.webp'),
(358,'Dominadas Escapulares','Scapular Pull Ups','Un ejercicio en barra de dominadas con brazos extendidos, que entrena la depresión y retracción de las escápulas.\n\nInstrucciones de ejecución:\n1. Cuélgate de una barra de dominadas con los brazos completamente extendidos.\n2. Mantén los brazos rectos durante todo el movimiento.\n3. Deprime y retrae las escápulas para elevar el pecho.\n4. Haz una breve pausa en la parte superior del movimiento.\n5. Regresa a la posición de cuelgue completo.\n6. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Piensa en alejar los hombros de las orejas al subir el pecho.\n• No intentes convertirlo en una dominada; el recorrido es corto.\n• Controla la vuelta a la posición colgada sin desplomarte.\n\nMúsculos principales: latissimus_dorsi, trapezius',NULL,'scapular-pull-ups.webp'),
(359,'Tijeras','Scissor Kicks','Un ejercicio de core realizado boca arriba, cruzando alternadamente las piernas rectas para trabajar el abdomen bajo y los flexores de cadera.\n\nInstrucciones de ejecución:\n1. Recuéstate boca arriba con las manos bajo los glúteos.\n2. Eleva ambas piernas unos centímetros del suelo.\n3. Cruza alternadamente una pierna sobre la otra en un movimiento de tijera.\n4. Mantén la zona lumbar presionada contra el suelo.\n5. Mantén un ritmo constante durante todo el ejercicio.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Presiona la zona lumbar contra el suelo en todo momento.\n• Mantén las piernas rectas y cerca del suelo.\n• Muévete con control, no con velocidad.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'scissor-kicks.webp'),
(360,'Remo Sentado en Polea (Agarre Estrecho)','Seated Cable Row','Un ejercicio de espalda en una máquina de remo con polea, tirando de una manija hacia el torso estando sentado.\n\nInstrucciones de ejecución:\n1. Siéntate en la estación de remo y coloca los pies en los apoyos.\n2. Sujeta la manija y siéntate erguido con una ligera inclinación hacia adelante.\n3. Lleva los codos hacia atrás y tira de la manija hacia la parte baja del abdomen.\n4. Contrae los omóplatos al final del tirón.\n5. Extiende los brazos con control de vuelta a la posición inicial.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén el torso erguido con un balanceo mínimo.\n• Lleva los codos directamente hacia atrás, no hacia los lados.\n• Contrae los omóplatos al final del tirón.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'01_remo_sentado_agarre_estrecho.webp'),
(361,'Elevación de Talones Sentado','Seated Calf Raise','Una elevación de talones en máquina realizada sentado para trabajar específicamente el músculo sóleo.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de elevación de talones con los pads apoyados en los muslos.\n2. Baja los talones lo más posible.\n3. Elévate sobre las puntas de los pies.\n4. Baja con control.\n5. Repite.\n\nConsejos técnicos:\n• La posición sentada pre-estira el sóleo.\n• Utiliza un rango completo de movimiento.\n\nMúsculos principales: soleus',NULL,'seated-calf-raise.webp'),
(362,'Press de Hombro con Mancuernas Sentado','Seated Dumbbell Shoulder Press','Un movimiento de press sentado para los hombros usando mancuernas.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con respaldo sosteniendo mancuernas a la altura de los hombros.\n2. Empuja las mancuernas sobre la cabeza hasta extender completamente los brazos.\n3. Baja las mancuernas de vuelta a la altura de los hombros.\n4. Repite.\n\nConsejos técnicos:\n• No arquees la espalda baja; mantén el contacto con el respaldo.\n• Sube las mancuernas en línea recta, sin chocarlas arriba.\n• Exhala al empujar y mantén el core firme.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'seated-db-press.webp'),
(363,'Curl con Mancuernas Sentado','Seated Dumbbell Curl','Un curl de bíceps sentado con mancuernas, donde la posición sentada y erguida elimina el impulso para una técnica más estricta.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con una mancuerna en cada mano.\n2. Deja los brazos colgando a los lados con las palmas hacia adelante.\n3. Sube ambas mancuernas hacia los hombros flexionando los bíceps.\n4. Aprieta en la parte superior del movimiento.\n5. Baja las mancuernas con control.\n6. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Mantén los codos pegados a los costados en todo momento.\n• Evita inclinarte hacia atrás para ayudar a levantar el peso.\n• Estira los brazos por completo al final de cada repetición.\n\nMúsculos principales: biceps_brachii',NULL,'seated-dumbbell-curl.webp'),
(364,'Elevación Lateral con Mancuerna Sentado','Seated Dumbbell Lateral Raise','Un ejercicio de aislamiento sentado que levanta las mancuernas hacia los lados, trabajando los deltoides laterales sin impulso de piernas.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con una mancuerna en cada mano a los lados.\n2. Mantén la espalda erguida y el core contraído.\n3. Eleva ambas mancuernas hacia los lados hasta la altura de los hombros.\n4. Mantén una ligera flexión en los codos.\n5. Baja las mancuernas con control.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Usa un peso ligero para mantener la elevación estricta.\n• Lidera con los codos en lugar de con las manos.\n• Eleva hasta la altura de los hombros y baja con control.\n\nMúsculos principales: lateral_deltoid',NULL,'seated-dumbbell-lateral-raise.webp'),
(365,'Extensión de Tríceps con Mancuerna Sentado','Seated Dumbbell Tricep Extension','Una extensión por encima de la cabeza sentado que baja la mancuerna detrás de la cabeza, estirando y trabajando los tríceps.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco con una mancuerna sostenida sobre la cabeza con ambas manos.\n2. Mantén los brazos superiores verticales junto a las orejas.\n3. Baja la mancuerna detrás de la cabeza flexionando los codos.\n4. Extiende los brazos para empujar la mancuerna de vuelta arriba.\n5. Aprieta los tríceps en la parte superior.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén los brazos verticales junto a las orejas.\n• Mueve solo los antebrazos, manteniendo los codos quietos.\n• Contrae el core para evitar arquear la zona lumbar.\n\nMúsculos principales: triceps_brachii',NULL,'seated-dumbbell-tricep-extension.webp'),
(366,'Curl de Piernas Sentado','Seated Leg Curl','Un ejercicio de aislamiento de isquiotibiales en máquina en posición sentada, con tensión constante y menor implicación de los flexores de cadera respecto a la variante tumbada.\n\nInstrucciones de ejecución:\n1. Ajusta el respaldo y el cojín de tobillo para que las rodillas queden alineadas con el pivote de la máquina.\n2. Siéntate erguido, coloca la parte posterior de los tobillos sobre el cojín y sujeta las asas.\n3. Flexiona las piernas hacia abajo y atrás bajo el asiento hasta donde la máquina lo permita.\n4. Pausa en la contracción máxima, luego vuelve lentamente a la posición inicial.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén la espalda firmemente apoyada en el respaldo durante todo el movimiento.\n• Flexiona ligeramente los pies hacia las espinillas en la contracción máxima para mayor activación de los isquios.\n• Controla la fase excéntrica — no dejes que el peso jale las piernas de vuelta rápidamente.\n\nMúsculos principales: hamstrings',NULL,'seated-leg-curl.webp'),
(367,'Press de Hombros en Máquina Smith Sentado','Seated Smith Machine Shoulder Press','Un press de hombros sentado en máquina Smith, cuyo recorrido guiado facilita el aprendizaje del empuje vertical.\n\nInstrucciones de ejecución:\n1. Coloca un banco dentro de la máquina Smith.\n2. Siéntate mirando hacia adelante con la barra a la altura de los hombros.\n3. Agarra la barra ligeramente más ancho que el ancho de hombros.\n4. Desbloquea la barra y empuja hacia arriba hasta extender los brazos.\n5. Baja la barra de vuelta a la altura de los hombros con control.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Coloca el banco de modo que la barra baje justo delante de la cara.\n• No bloquees los codos con brusquedad en la parte alta.\n• Mantén el torso erguido y el core activo durante toda la serie.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'seated-smith-machine-shoulder-press.webp'),
(368,'Encogimiento con Barra','Barbell Shrug','Un movimiento de aislamiento para el trapecio superior.\n\nInstrucciones de ejecución:\n1. De pie, sostén una barra a lo largo de los brazos con agarre en pronación.\n2. Encoge los hombros directamente hacia las orejas.\n3. Mantén brevemente en la parte superior.\n4. Baja los hombros con control.\n5. Repite.\n\nConsejos técnicos:\n• Sube los hombros en vertical, sin hacer círculos.\n• No uses los brazos; los codos quedan extendidos todo el tiempo.\n• Evita impulsarte con las piernas para subir más peso.\n\nMúsculos principales: trapezius',NULL,'shrug.webp'),
(369,'Zancada Lateral','Side Lunge','Una zancada lateral que da un paso amplio hacia un lado, trabajando los cuádriceps, glúteos y la cara interna de los muslos en un patrón lateral.\n\nInstrucciones de ejecución:\n1. De pie con los pies al ancho de las caderas y las manos en el pecho.\n2. Da un paso amplio hacia un lado con una pierna, manteniendo la otra recta.\n3. Flexiona la rodilla de la pierna que dio el paso y empuja las caderas hacia atrás en una sentadilla lateral.\n4. Mantén el pecho erguido y el talón de trabajo apoyado.\n5. Empuja con la pierna flexionada para volver a la posición de pie.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Empuja las caderas hacia atrás mientras flexionas la rodilla del paso.\n• Mantén la pierna contraria estirada y ambos talones apoyados.\n• Mantén el pecho erguido en lugar de redondear hacia delante.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'side-lunge.webp'),
(370,'Abducción de Cadera Acostado de Lado','Side-Lying Hip Abduction','Un ejercicio de aislamiento con peso corporal que trabaja el glúteo medio y los abductores de cadera.\n\nInstrucciones de ejecución:\n1. Acuéstate de lado con las piernas apiladas.\n2. Mantén la pierna inferior ligeramente flexionada.\n3. Eleva la pierna superior hacia el techo.\n4. Baja con control.\n5. Repite de ambos lados.\n\nConsejos técnicos:\n• Mantén las caderas apiladas durante todo el ejercicio.\n• Evita inclinar la pelvis.\n\nMúsculos principales: abductors, gluteus_medius',NULL,'side-lying-hip-abduction.webp'),
(371,'Aducción de Cadera Acostado de Lado','Side Lying Hip Adduction','Un ejercicio de aducción tumbado de lado que eleva la pierna inferior contra la gravedad para trabajar la cadera con el propio peso.\n\nInstrucciones de ejecución:\n1. Acuéstate de lado con la pierna inferior recta.\n2. Flexiona la pierna superior y coloca su pie plano frente al muslo inferior.\n3. Apoya la cabeza con el brazo inferior.\n4. Eleva la pierna inferior hacia el techo.\n5. Baja la pierna con control.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Mueve solo la pierna; la cadera y el torso quedan quietos.\n• Sube la pierna sin impulso y baja despacio.\n• Alinea hombros, cadera y pies antes de empezar a moverte.\n\nMúsculos principales: adductors',NULL,'side-lying-hip-adduction.webp'),
(372,'Elevación Lateral Tumbado de Lado','Side-Lying Lateral Raise','Un ejercicio de aislamiento del deltoides lateral con mancuerna en posición lateral sobre un banco plano, que proporciona tensión constante sin impulso.\n\nInstrucciones de ejecución:\n1. Túmbate de lado sobre un banco plano usando el brazo inferior para apoyar la cabeza o sujetar el borde del banco.\n2. Sujeta una mancuerna con la mano superior con el brazo descansando a lo largo del costado.\n3. Con el codo ligeramente flexionado, eleva la mancuerna hasta que el brazo quede perpendicular al suelo.\n4. Pausa brevemente arriba, luego baja la mancuerna despacio hasta el costado.\n5. Completa todas las repeticiones en un lado antes de cambiar.\n\nConsejos técnicos:\n• Mantén el torso quieto — solo el brazo de trabajo debe moverse.\n• La posición tumbada elimina el impulso y aísla eficazmente el deltoides lateral.\n• Usa un peso más ligero que en la elevación lateral de pie — la palanca es más exigente.\n\nMúsculos principales: lateral_deltoid',NULL,'side-lying-lateral-raise.webp'),
(373,'Plancha Lateral con Elevación de Pierna','Side Plank with Leg Lift','Una plancha lateral con elevación de la pierna superior, que combina trabajo de core lateral con abducción de cadera.\n\nInstrucciones de ejecución:\n1. Túmbate de lado con el antebrazo en el suelo y el codo bajo el hombro.\n2. Coloca un pie sobre el otro y eleva las caderas hasta una plancha lateral.\n3. Desde esta plancha lateral estable, sube la pierna de arriba recta hacia el techo.\n4. Baja la pierna de forma controlada sin dejar caer las caderas.\n5. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén las caderas elevadas toda la serie; no dejes que se hundan.\n• Guía la elevación de la pierna con el talón, no con la punta.\n• Mantén el cuerpo en una sola línea recta de la cabeza al pie de abajo.\n\nMúsculos principales: gluteus_medius, obliques',NULL,'side-plank-leg-lift.webp'),
(374,'Remo con Mancuerna a Una Mano con Pecho Apoyado','Single-Arm Chest-Supported Dumbbell Row','Un remo unilateral realizado con un brazo a la vez sobre un banco inclinado con apoyo para el pecho, que aísla cada lado de la espalda y reduce el impulso.\n\nInstrucciones de ejecución:\n1. Túmbate boca abajo en un banco inclinado sujetando una mancuerna con una mano, con el brazo colgando recto hacia abajo.\n2. Rema la mancuerna hacia tu costado, llevando el codo más allá del torso.\n3. Aprieta el omóplato en la parte superior y luego baja de forma controlada.\n4. Completa todas las repeticiones de un lado antes de cambiar de brazo.\n\nConsejos técnicos:\n• Trabajar un lado a la vez te permite concentrarte en una contracción completa sin que el otro brazo compense.\n• Mantén el pecho presionado contra el banco durante todo el movimiento para evitar usar impulso.\n• Iguala el número de repeticiones en ambos lados para evitar desequilibrios.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'single-arm-chest-supported-dumbbell-row.webp'),
(375,'Remo con Mancuerna a Un Brazo','Single-Arm Dumbbell Row','Un ejercicio de espalda unilateral con mancuerna para un desarrollo equilibrado.\n\nInstrucciones de ejecución:\n1. Coloca una rodilla y una mano en un banco como apoyo.\n2. Sostén una mancuerna en la otra mano con el brazo extendido.\n3. Tira de la mancuerna hacia la cadera apretando el omóplato.\n4. Baja la mancuerna con control.\n5. Repite de ambos lados.\n\nConsejos técnicos:\n• No gires el torso al tirar; mantén la cadera estable.\n• Evita encoger el hombro hacia la oreja al iniciar el tirón.\n• Haz las mismas repeticiones con cada brazo.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'single-arm-db-row.webp'),
(376,'Extensión de Tríceps sobre la Cabeza con Mancuerna a Un Brazo','Single-Arm Dumbbell Overhead Tricep Extension','Una extensión de tríceps sobre la cabeza a un brazo que proporciona un estiramiento largo y unilateral de la cabeza larga y entrena la estabilidad del core contra la flexión lateral.\n\nInstrucciones de ejecución:\n1. De pie o sentado, sostén una mancuerna en una mano sobre la cabeza con el brazo completamente extendido.\n2. La palma mira hacia adelante; la otra mano puede apoyarse en la cadera o en un soporte para mayor estabilidad.\n3. Flexiona el codo para bajar la mancuerna detrás de la cabeza en un arco controlado.\n4. Mantén el brazo superior vertical y cerca de la cabeza durante todo el movimiento.\n5. Extiende el codo para regresar la mancuerna sobre la cabeza.\n6. Completa todas las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Solo el antebrazo se mueve — el brazo superior permanece fijo en su lugar.\n• No dejes que el torso se incline hacia un lado; este también es un ejercicio de core.\n\nMúsculos principales: triceps_brachii',NULL,'single-arm-dumbbell-overhead-tricep-extension.webp'),
(377,'Curl martillo unilateral','Single-Arm Hammer Curl','Un curl unilateral con mancuerna y agarre neutro que mantiene el codo de trabajo junto al torso mientras el braquial y el braquiorradial flexionan el codo.\n\nInstrucciones de ejecución:\n1. Colócate con los pies al ancho de las caderas y sostén una mancuerna al costado con la palma hacia dentro.\n2. Activa el tronco y mantén el brazo de trabajo junto a las costillas mientras cuelga extendido.\n3. Lleva la mancuerna hacia el hombro sin girar la palma ni balancear el torso.\n4. Aprieta los flexores del codo arriba y baja la mancuerna de forma controlada hasta extender el brazo.\n5. Completa las repeticiones de un lado y después cambia de brazo.\n\nConsejos técnicos:\n• Deja que el lado más débil marque el peso y las repeticiones para que ambos lados reciban el mismo trabajo.\n• Mantén la muñeca neutra y el hombro quieto; el movimiento debe venir del codo.\n• Controla la bajada en lugar de dejar caer la mancuerna desde arriba.\n\nMúsculos principales: brachialis, brachioradialis',NULL,'single-arm-hammer-curl.webp'),
(378,'Press de hombros unilateral en máquina','Single-Arm Machine Shoulder Press','Un press de hombros unilateral sentado en máquina que permite empujar cada brazo por separado mientras la espalda permanece apoyada y la máquina guía la resistencia.\n\nInstrucciones de ejecución:\n1. Ajusta el asiento para que el agarre de trabajo comience cerca del hombro y apoya firmemente la espalda en el respaldo.\n2. Sujeta un agarre con la muñeca recta y deja la mano libre sobre el soporte.\n3. Empuja el agarre hacia arriba sin separarte del respaldo ni girar el torso.\n4. Baja el agarre bajo control hasta que el codo quede justo por debajo de la posición inicial.\n5. Completa las repeticiones de un lado y después entrena el otro lado.\n\nConsejos técnicos:\n• Comienza con el brazo más débil y deja que marque el peso y las repeticiones de ambos lados.\n• Mantén las costillas abajo y la espalda contra el respaldo en lugar de inclinarte hacia un lado.\n• Detén el movimiento ante una posición dolorosa del hombro; el recorrido de la máquina debe sentirse controlado.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'single-arm-machine-shoulder-press.webp'),
(379,'Elevación Lateral a Un Brazo en Máquina de Discos','Single-Arm Plate-Loaded Lateral Raise','La elevación lateral en máquina de discos trabajando un brazo cada vez, de modo que cada lado levanta su propia carga y ambos pueden entrenarse hasta el mismo nivel.\n\nInstrucciones de ejecución:\n1. Ajusta la altura del asiento para que el eje de la almohadilla quede alineado con tu hombro y carga solo el lado que vas a trabajar.\n2. Siéntate con la espalda apoyada en el respaldo y coloca la cara externa del brazo que trabaja contra su almohadilla.\n3. Sujeta la empuñadura del lado libre o apoya esa mano en el regazo, y mantén el torso alineado con el asiento.\n4. Empuja el brazo que trabaja hacia fuera y hacia arriba contra la almohadilla hasta la altura del hombro, y baja de forma controlada.\n5. Completa todas las repeticiones de ese lado, luego carga y trabaja el otro lado.\n\nConsejos técnicos:\n• Iguala los lados por el brazo débil, no por el fuerte. Trabajar un lado cada vez solo revela un desequilibrio si dejas que el lado débil fije el número de repeticiones.\n• No dejes que el torso se incline hacia el lado que trabaja. Con carga en un solo brazo la máquina ya no se equilibra sola, y inclinarse convierte la elevación en una flexión lateral.\n• Empieza por el brazo débil para que marque el objetivo, y da el mismo descanso a los dos lados.\n\nMúsculos principales: lateral_deltoid',NULL,'single-arm-plate-loaded-lateral-raise.webp'),
(380,'Extensión de Tríceps a Un Brazo en Polea','Single Arm Tricep Pushdown','Un ejercicio de aislamiento de tríceps realizado con un brazo a la vez en una máquina de polea con una sola manija.\n\nInstrucciones de ejecución:\n1. Coloca una manija individual en una polea alta.\n2. Sujeta la manija con una mano y mantén el codo pegado al costado.\n3. Empuja la manija hacia abajo hasta extender completamente el brazo.\n4. Contrae el tríceps en la parte baja.\n5. Vuelve lentamente a la posición inicial.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén el codo pegado al costado en todo momento.\n• Evita inclinarte hacia adelante para generar impulso.\n• Extiende el brazo por completo en la parte baja para una contracción total.\n\nMúsculos principales: triceps_brachii',NULL,'single-arm-tricep-pushdown.webp'),
(381,'Press Svend con una Mancuerna','Single Dumbbell Svend Press','Un press de pecho de pie sosteniendo una sola mancuerna en vertical entre las palmas, donde lo que trabaja los pectorales es la presión hacia adentro y no la carga.\n\nInstrucciones de ejecución:\n1. De pie y erguido, sostén una sola mancuerna en vertical frente al esternón, con el mango entre las palmas planas.\n2. Aprieta con fuerza las palmas contra la mancuerna para que la tensión vaya al pecho y el peso no resbale.\n3. Empuja la mancuerna recto hacia adelante hasta extender por completo los brazos, manteniéndola a la altura del pecho todo el recorrido.\n4. Haz una breve pausa sin soltar la presión y devuelve la mancuerna al pecho con control.\n5. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• La presión sobre la mancuerna hace el ejercicio. Si agarras el mango en lugar de aplastar el peso entre las palmas planas, el pecho no trabaja.\n• Usa una mancuerna ligera. Las palmas la sostienen solo por fricción, así que el agarre marca el límite mucho antes que el pecho.\n• Mantén los codos ligeramente flexionados en el lockout y la mancuerna a la altura del esternón; si baja hacia las caderas, los pectorales dejan de trabajar.\n\nMúsculos principales: pectoralis_major',NULL,'single-db-svend-press.webp'),
(382,'Elevación de Pantorrilla a Una Pierna','Single Leg Calf Raise','Una elevación de pantorrilla unilateral que carga una pantorrilla a la vez y expone desequilibrios laterales.\n\nInstrucciones de ejecución:\n1. Mantente sobre un pie con la punta sobre una plataforma elevada, talón al aire.\n2. Sujétate a una pared o barandilla con una mano para equilibrio.\n3. Baja el talón por debajo de la plataforma para un estiramiento profundo.\n4. Empuja arriba sobre la punta tan alto como puedas.\n5. Baja con control. Repeticiones por lado, luego cambia.\n\nConsejos técnicos:\n• Pausa arriba para maximizar la contracción.\n• Usa una excéntrica lenta para el estiramiento completo.\n• Sostén una mancuerna del lado que trabaja cuando el peso corporal sea fácil.\n\nMúsculos principales: gastrocnemius',NULL,'single-leg-calf-raise.webp'),
(383,'Extensión de Cuádriceps a Una Pierna','Single Leg Extension','Un ejercicio de aislamiento de cuádriceps en una máquina de extensión de piernas, trabajando una pierna a la vez.\n\nInstrucciones de ejecución:\n1. Siéntate en una máquina de extensión de piernas y coloca un pie bajo la almohadilla.\n2. Deja el otro pie apoyado en el suelo o colgando.\n3. Extiende la pierna de trabajo hasta que quede casi recta.\n4. Contrae el cuádriceps en la parte alta.\n5. Baja la pierna con control.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Contrae con fuerza el cuádriceps en la parte alta del movimiento.\n• Baja el peso con control en lugar de dejarlo caer.\n• Mantén la espalda plana contra el respaldo.\n\nMúsculos principales: quadriceps',NULL,'single-leg-extension.webp'),
(384,'Puente de Glúteo a Una Pierna','Single Leg Glute Bridge','Un puente de glúteo unilateral que carga un glúteo a la vez y ayuda a corregir desequilibrios laterales.\n\nInstrucciones de ejecución:\n1. Acuéstate boca arriba con una rodilla flexionada y el pie plano, la otra pierna extendida recta.\n2. Activa el core y contrae el glúteo del lado que trabaja.\n3. Empuja las caderas arriba presionando con el talón de trabajo.\n4. Pausa arriba con el cuerpo en línea recta de hombros a rodilla.\n5. Baja con control. Repeticiones por lado, luego cambia.\n\nConsejos técnicos:\n• Mantén la pierna extendida en línea con el muslo de trabajo.\n• Contrae el glúteo arriba — no empujes desde la zona lumbar.\n• Ralentiza la fase de bajada para más estímulo.\n\nMúsculos principales: gluteus_maximus',NULL,'single-leg-glute-bridge.webp'),
(385,'Curl de Pierna Tumbado a Una Pierna','Single Leg Lying Leg Curl','Un curl femoral tumbado a una pierna en máquina, que aísla los isquiotibiales de cada lado por separado.\n\nInstrucciones de ejecución:\n1. Acuéstate boca abajo en la máquina de curl de piernas tumbado.\n2. Coloca un tobillo bajo el apoyo y deja el otro pie fuera de la máquina.\n3. Flexiona la pierna de trabajo llevando el talón hacia el glúteo.\n4. Aprieta los isquiotibiales en la parte superior.\n5. Baja la pierna con control.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén la cadera pegada al apoyo durante todo el recorrido.\n• Usa un peso que te permita subir y bajar sin tirones.\n• Empieza por la pierna más débil y repite igual con la otra.\n\nMúsculos principales: hamstrings',NULL,'single-leg-lying-leg-curl.webp'),
(386,'Prensa de Piernas a Una Pierna','Single Leg Press','Un ejercicio de tren inferior en una máquina de prensa, empujando la plataforma con una pierna a la vez.\n\nInstrucciones de ejecución:\n1. Siéntate en la máquina de prensa con un pie sobre la plataforma.\n2. Mantén la otra pierna fuera de la plataforma, apoyada a un lado.\n3. Suelta los seguros y baja la plataforma flexionando la rodilla.\n4. Detente cuando la rodilla forme un ángulo cercano a 90 grados.\n5. Empuja a través del talón para devolver la plataforma.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén el pie plano y centrado en la plataforma.\n• Evita que la rodilla se desplace hacia adentro.\n• No bloquees la rodilla con fuerza en la parte alta.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'single-leg-press.webp'),
(387,'Peso Muerto Rumano a Una Pierna','Single Leg Romanian Deadlift','Un peso muerto rumano a una pierna con mancuernas, que trabaja isquiotibiales y glúteos mientras exige equilibrio y estabilidad de cadera.\n\nInstrucciones de ejecución:\n1. Apóyate en una pierna sosteniendo una mancuerna en cada mano frente a los muslos.\n2. Mantén una ligera flexión en la rodilla de apoyo.\n3. Bisagra en la cadera extendiendo la pierna libre detrás.\n4. Baja las mancuernas a lo largo de la pierna de apoyo hasta sentir el estiramiento en los isquiotibiales.\n5. Empuja con el talón para volver a la posición erguida.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Mantén la cadera cuadrada; no dejes que se abra hacia el lado.\n• Si pierdes el equilibrio, reduce el rango o usa menos peso.\n• Mira un punto fijo en el suelo para estabilizarte.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'single-leg-romanian-deadlift.webp'),
(388,'Abdominales','Sit-Ups','Un ejercicio abdominal clásico con rango de movimiento completo.\n\nInstrucciones de ejecución:\n1. Acuéstate boca arriba con las rodillas flexionadas y los pies anclados.\n2. Cruza los brazos sobre el pecho o coloca las manos detrás de la cabeza.\n3. Siéntate completamente hasta que el torso quede erguido.\n4. Baja con control.\n5. Repite.\n\nConsejos técnicos:\n• No tires del cuello con las manos al subir.\n• Exhala mientras subes para mantener el abdomen activo.\n• Si notas tirantez lumbar, reduce el rango de movimiento.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'sit-ups.webp'),
(389,'Skull Crusher','Skull Crusher','Una extensión de tríceps tumbado con barra que aísla los tríceps a través de un rango de movimiento completo.\n\nInstrucciones de ejecución:\n1. Acuéstate en un banco plano sosteniendo una barra sobre el pecho con agarre estrecho.\n2. Baja la barra hacia la frente flexionando los codos.\n3. Extiende los brazos de vuelta a la posición inicial.\n4. Repite.\n\nConsejos técnicos:\n• Mantén los brazos superiores verticales durante todo el ejercicio.\n• Baja lentamente para proteger los codos.\n\nMúsculos principales: triceps_brachii',NULL,'skull-crusher.webp'),
(390,'Remo con Trineo','Sled Row','Un remo con carga: agarras el trineo y lo tiras hacia ti mientras caminas hacia atrás, trabajando la espalda con un arrastre continuo en lugar de repeticiones sueltas.\n\nInstrucciones de ejecución:\n1. Carga el trineo y agarra sus postes con ambas manos, una en cada poste.\n2. Ponte de pie frente al trineo con los brazos estirados y el torso ligeramente inclinado hacia atrás contra la carga.\n3. Tira del trineo hacia ti llevando los codos atrás y da un paso corto hacia atrás al mismo tiempo.\n4. Estira los brazos de nuevo, da otro paso atrás y repite el tirón.\n5. Continúa por distancia o por tiempo, manteniendo un ritmo constante de tirón y paso.\n\nConsejos técnicos:\n• Pecho arriba y espalda recta: deja que las piernas te lleven hacia atrás en vez de encorvarte sobre el trineo.\n• Usa una carga que puedas mover de forma continua; la idea es un arrastre constante, no un tirón máximo.\n• Si tu gimnasio tiene asas o una cuerda para el trineo, funcionan igual.\n\nMúsculos principales: latissimus_dorsi',NULL,'sled-row.webp'),
(391,'Press de Banca en Máquina Smith','Smith Machine Bench Press','Un press de banca en máquina Smith cuyo recorrido guiado permite entrenar el pecho con menos demanda de estabilización.\n\nInstrucciones de ejecución:\n1. Acuéstate en un banco plano dentro de la máquina Smith.\n2. Agarra la barra ligeramente más ancho que el ancho de hombros y desbloquéala.\n3. Baja la barra con control hasta el centro del pecho.\n4. Haz una breve pausa sin rebotar.\n5. Empuja la barra hacia arriba hasta extender completamente los brazos.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Alinea el banco para que la barra baje a la mitad del pecho.\n• Mantén los pies firmes en el suelo durante toda la serie.\n• Aprende el giro de muñeca para enganchar la barra antes de cargar peso.\n\nMúsculos principales: pectoralis_major',NULL,'smith-machine-bench-press.webp'),
(392,'Remo Inclinado en Máquina Smith','Smith Machine Bent Over Row','Un remo inclinado en máquina Smith que trabaja dorsales y romboides con una trayectoria de barra fija.\n\nInstrucciones de ejecución:\n1. De pie dentro de la máquina Smith con los pies al ancho de los hombros.\n2. Agarra la barra en pronación ligeramente más ancho que los hombros.\n3. Bisagra en las caderas hasta que el torso esté aproximadamente a 45 grados.\n4. Tira de la barra hacia el pecho inferior llevando los codos hacia atrás.\n5. Aprieta los omóplatos en la parte superior.\n6. Baja la barra con control y repite.\n\nConsejos técnicos:\n• Mantén la espalda recta y el core firme en la inclinación.\n• No te incorpores al tirar; el ángulo del torso no cambia.\n• Evita encoger los hombros hacia las orejas durante el remo.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'smith-machine-bent-over-row.webp'),
(393,'Sentadilla Búlgara en Máquina Smith','Smith Machine Bulgarian Split Squat','Una sentadilla búlgara realizada en la máquina Smith para mayor estabilidad y control de la carga.\n\nInstrucciones de ejecución:\n1. Coloca un banco detrás de la máquina Smith. Apoya la barra sobre los trapecios.\n2. Coloca el pie trasero en el banco y el pie delantero hacia adelante.\n3. Baja la rodilla trasera hacia el suelo.\n4. Empuja con el talón delantero para volver.\n5. Repite de ambos lados.\n\nConsejos técnicos:\n• La máquina Smith guía la trayectoria de la barra.\n• Concéntrate en mantener la rodilla delantera alineada sobre los dedos del pie.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'smith-machine-bulgarian-split.webp'),
(394,'Elevación de Talón en Máquina Smith','Smith Machine Calf Raise','Una elevación de talones en máquina Smith de pie sobre una plataforma, que aísla los gemelos con un estiramiento completo.\n\nInstrucciones de ejecución:\n1. Coloca la barra de la máquina Smith sobre la parte superior de la espalda y los hombros.\n2. De pie sobre una pequeña plataforma para que los talones puedan bajar por debajo de los dedos.\n3. Desbloquea la barra y elévate sobre las puntas de los pies.\n4. Aprieta las pantorrillas con fuerza en la parte superior.\n5. Baja los talones por debajo de la plataforma para un estiramiento completo.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Haz una pausa arriba y otra abajo para eliminar el rebote.\n• No dobles las rodillas; el movimiento sale solo del tobillo.\n• Mantén el cuerpo erguido, sin inclinarte hacia delante.\n\nMúsculos principales: gastrocnemius',NULL,'smith-machine-calf-raise.webp'),
(395,'Press de Banca Declinado en Máquina Smith','Smith Machine Decline Bench Press','Un press de banca en banco declinado bajo la máquina Smith, donde el ángulo con la cabeza abajo y la trayectoria guiada llevan el trabajo al pectoral inferior.\n\nInstrucciones de ejecución:\n1. Coloca un banco declinado en la máquina de modo que la barra quede alineada con tu pecho inferior al tumbarte, y engancha las piernas bajo los rodillos.\n2. Túmbate con la cabeza en el extremo bajo, toma un agarre prono algo más ancho que los hombros y desengancha la barra.\n3. Baja la barra de forma controlada hasta que toque el pecho inferior, manteniendo los codos a unos cuarenta y cinco grados del torso.\n4. Empuja la barra hacia arriba hasta extender los brazos, sin bloquear los codos con fuerza.\n5. Repite el número de repeticiones deseado y vuelve a enganchar la barra antes de soltar las piernas.\n\nConsejos técnicos:\n• Alinea el banco antes de cargarlo. La barra solo se mueve en un plano, así que si el banco está unos centímetros desviado la barra te llegará a la garganta o al estómago en lugar del pecho inferior.\n• Asegura primero las piernas bajo los rodillos. Con la cabeza abajo y sin sujeción, te deslizarás hacia el extremo bajo del banco en la primera repetición dura.\n• Incorpórate despacio entre series. Las series largas con la cabeza por debajo del corazón marean a mucha gente, y esta es la variante donde ocurre.\n\nMúsculos principales: pectoralis_major',NULL,'smith-machine-decline-bench-press.webp'),
(396,'Sentadilla Frontal en Máquina Smith','Smith Machine Front Squat','Una sentadilla en máquina Smith con la barra apoyada al frente sobre los hombros, donde la trayectoria fija y el torso erguido mantienen el trabajo en los cuádriceps.\n\nInstrucciones de ejecución:\n1. Coloca la barra a la altura del pecho alto y métete debajo para que se apoye al frente de los hombros, contra las clavículas.\n2. Cruza los brazos sobre la barra o toma un agarre frontal abierto, y sube los codos hasta que los brazos queden casi paralelos al suelo.\n3. Desengancha la barra y separa los pies aproximadamente al ancho de los hombros, ligeramente por delante de ella.\n4. Baja en línea recta manteniendo los codos altos y el torso erguido, hasta que los muslos queden al menos paralelos al suelo.\n5. Empuja desde el medio de los pies para volver a subir y repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Los codos altos son toda la ejercicio. En cuanto bajan, la barra rueda de los hombros hacia las manos y la posición frontal se desmorona.\n• Ajusta los topes de seguridad justo por debajo de tu posición más profunda antes de desenganchar nada: en una sentadilla frontal, soltar la barra es la salida más rápida de una repetición fallida.\n• Colocarte ligeramente por delante de la barra te permite mantener el torso vertical. Con una trayectoria fija, situarte justo debajo de la barra te obliga a inclinarte y empuja la barra fuera del apoyo frontal.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'smith-machine-front-squat.webp'),
(397,'Buenos Días en Máquina Smith','Smith Machine Good Morning','Una bisagra de cadera con la barra de la máquina Smith apoyada sobre la espalda alta, inclinándote hacia delante desde las caderas contra una trayectoria fija para cargar isquiotibiales y erectores espinales.\n\nInstrucciones de ejecución:\n1. Coloca la barra a la altura de la espalda alta, métete debajo y apóyala sobre los trapecios; desengánchala con los pies al ancho de las caderas.\n2. Flexiona ligeramente las rodillas y déjalas así: esto es una bisagra, no una sentadilla.\n3. Empuja las caderas rectas hacia atrás y deja que el torso se incline hacia delante, con la espalda plana y la cabeza en línea con la columna.\n4. Detente cuando sientas un estiramiento fuerte en los isquiotibiales, con el torso cerca de la paralela al suelo.\n5. Lleva las caderas hacia delante para volver a erguirte, aprieta los glúteos arriba y repite las repeticiones deseadas.\n\nConsejos técnicos:\n• Usa mucho menos peso del que usarías en una sentadilla. Abajo, la barra queda muy lejos de tus caderas, y ese brazo de palanca, no el número en la barra, es lo que cuesta el ejercicio.\n• Caderas atrás, no pecho abajo. Si el torso baja sin que las caderas retrocedan, estás flexionando la columna en lugar de hacer bisagra en la cadera.\n• Termina el recorrido donde tu espalda empezaría a redondearse. En un buenos días la profundidad la marcan tus isquiotibiales, y la máquina te llevará encantada más allá de ese punto.\n\nMúsculos principales: erector_spinae, hamstrings',NULL,'smith-machine-good-morning.webp'),
(398,'Hip Thrust en Máquina Smith','Smith Machine Hip Thrust','Un empuje de cadera con la barra en las guías de la máquina Smith, de modo que la carga recorre una línea vertical fija sobre las caderas mientras los hombros quedan apoyados en un banco.\n\nInstrucciones de ejecución:\n1. Coloca un banco plano dentro de la máquina Smith, paralelo a la barra y situado de forma que la barra quede sobre el pliegue de tu cadera.\n2. Baja la barra lo suficiente para poder pasar por debajo sentado en el suelo, y apoya la parte alta de la espalda en el banco.\n3. Rueda la barra sobre las caderas, ponle una almohadilla si la necesitas y desengánchala, con los pies planos y a la anchura de las caderas.\n4. Empuja con los talones y extiende las caderas hasta que muslos y torso formen una línea recta, apretando los glúteos arriba.\n5. Baja las caderas de forma controlada hasta quedar justo por encima del suelo y repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Alinea el banco antes de cargar la barra. La barra solo sube y baja en vertical, así que si el banco está desplazado la barra acaba sobre el abdomen o los muslos, y a mitad de serie no hay forma de corregirlo.\n• Pon los topes de seguridad donde queda la barra al final del recorrido. Salir de debajo de una barra Smith cargada estando en el suelo es incómodo, y con los topes deja de ser un problema.\n• Mira a un punto por delante de ti en lugar de al techo. Mantener la barbilla recogida evita que el movimiento acabe en un arqueo lumbar al bloquear arriba.\n\nMúsculos principales: gluteus_maximus, gluteus_medius',NULL,'smith-machine-hip-thrust.webp'),
(399,'Press Inclinado en Máquina Smith','Smith Machine Incline Bench Press','Un press inclinado en máquina Smith que enfatiza la parte superior del pecho y los deltoides anteriores con una trayectoria guiada.\n\nInstrucciones de ejecución:\n1. Ajusta un banco inclinado a 30-45 grados dentro de la máquina Smith.\n2. Recuéstate y agarra la barra ligeramente más ancho que el ancho de hombros.\n3. Desbloquea y baja la barra hasta la parte superior del pecho.\n4. Haz una breve pausa en la parte inferior.\n5. Empuja la barra hacia arriba hasta extender los brazos.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Ajusta la posición del banco para que la barra llegue a la parte alta del pecho.\n• Baja la barra sin rebotarla en el pecho.\n• Mantén los glúteos en el banco y los pies bien apoyados.\n\nMúsculos principales: anterior_deltoid, pectoralis_major',NULL,'smith-machine-incline-bench-press.webp'),
(400,'Peso Muerto Rumano en Máquina Smith','Smith Machine Romanian Deadlift','Un peso muerto rumano realizado en la máquina Smith, que fija la trayectoria de la barra para que puedas concentrarte en la bisagra de cadera y el estiramiento de la cadena posterior.\n\nInstrucciones de ejecución:\n1. Ajusta la barra de la máquina Smith a la altura de la mitad del muslo y colócate directamente debajo con los pies al ancho de las caderas.\n2. Desbloquea la barra con agarre en pronación justo por fuera de las caderas.\n3. Empuja las caderas hacia atrás mientras deslizas la barra por la parte delantera de las piernas.\n4. Baja hasta sentir un estiramiento profundo en los isquiotibiales, con la espalda plana y las rodillas ligeramente flexionadas.\n5. Empuja las caderas hacia adelante para volver a la posición de pie, manteniendo la barra cerca del cuerpo.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• La barra está guiada en una trayectoria recta — úsala para perfeccionar el patrón de bisagra.\n• No redondees la zona lumbar al bajar; detente al final del rango de los isquiotibiales.\n\nMúsculos principales: hamstrings',NULL,'smith-machine-rdl.webp'),
(401,'Remo Inclinado con Agarre Inverso en Máquina Smith','Smith Machine Reverse Grip Bent Over Row','Un remo inclinado con agarre supino en máquina Smith, que dirige el trabajo a los dorsales y bíceps.\n\nInstrucciones de ejecución:\n1. De pie dentro de la máquina Smith y agarra la barra con agarre en supinación.\n2. Bisagra hacia adelante en las caderas hasta que el torso esté aproximadamente a 45 grados.\n3. Mantén la espalda plana y el core contraído.\n4. Tira de la barra hacia el abdomen inferior.\n5. Aprieta los dorsales y los omóplatos en la parte superior.\n6. Baja la barra con control y repite.\n\nConsejos técnicos:\n• Mantén las muñecas rectas; el agarre supino las carga más.\n• No conviertas el remo en un curl; tira con la espalda.\n• Evita incorporarte al tirar; el torso mantiene su inclinación.\n\nMúsculos principales: biceps_brachii, latissimus_dorsi',NULL,'smith-machine-reverse-grip-bent-over-row.webp'),
(402,'Zancada Inversa en Máquina Smith','Smith Machine Reverse Lunge','Una zancada inversa bajo la barra de la máquina Smith, dando un paso atrás con un pie y devolviéndolo a la posición de pie en cada repetición mientras la barra guiada mantiene la carga estable.\n\nInstrucciones de ejecución:\n1. Coloca la barra de modo que descanse sobre los trapecios altos al estar de pie y desengánchala con los pies bajo las caderas.\n2. Da un paso recto hacia atrás con un pie y baja la rodilla trasera hacia el suelo, manteniendo la tibia delantera vertical y la mayor parte del peso en el pie delantero.\n3. Detente cuando la rodilla trasera esté a punto de tocar el suelo y el muslo delantero quede aproximadamente paralelo a él.\n4. Empuja con el talón delantero y devuelve el pie trasero a la posición de pie bajo la barra.\n5. Completa todas las repeticiones de un lado, o alterna piernas, y luego cambia.\n\nConsejos técnicos:\n• Da un paso atrás lo bastante largo. Un paso corto lleva la rodilla delantera muy por delante de los dedos, y la trayectoria fija de la barra no te dejará corregirlo una vez cargado.\n• El pie que se desplaza hace todo el recorrido; el pie delantero no se mueve en absoluto. Si cambia de sitio entre repeticiones, tu paso es demasiado largo o demasiado corto.\n• La máquina te quita el equilibrio, no la carga: mantén el tronco firme y levántate desde abajo en lugar de recostarte contra la barra.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'smith-machine-reverse-lunge.webp'),
(403,'Press de Hombros en Máquina Smith','Smith Machine Shoulder Press','Un press vertical para deltoides en máquina Smith realizado sentado en un banco, con la barra estabilizada por los raíles.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco colocado dentro de una máquina Smith.\n2. Agarra la barra ligeramente más ancha que el ancho de los hombros a la altura de los hombros.\n3. Desrackea la barra y empújala por encima de la cabeza hasta que los brazos estén extendidos.\n4. Baja la barra de vuelta a la altura de los hombros de forma controlada.\n5. Mantén el core contraído durante todo el ejercicio.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Sitúate de forma que la barra no roce la cabeza al subir.\n• Evita arquear la zona lumbar al empujar.\n• Suelta el aire en la subida de cada repetición.\n\nMúsculos principales: anterior_deltoid, lateral_deltoid',NULL,'smith-machine-shoulder-press.webp'),
(404,'Encogimiento de Hombros en Máquina Smith','Smith Machine Shrug','Un encogimiento de hombros en máquina Smith que aísla el trapecio sin necesidad de estabilizar la barra.\n\nInstrucciones de ejecución:\n1. Párate erguido dentro de una máquina Smith con la barra a la altura de los muslos.\n2. Agarra la barra ligeramente más ancha que el ancho de los hombros con agarre prono.\n3. Desrackea la barra y deja que cuelgue frente a tus muslos.\n4. Encoge los hombros hacia arriba en dirección a las orejas.\n5. Mantén la posición alta un momento, luego baja lentamente.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Evita rotar los hombros; súbelos y bájalos en vertical.\n• No tires con los bíceps; los brazos solo sostienen la barra.\n• Mantén el cuello relajado y la mirada al frente.\n\nMúsculos principales: trapezius',NULL,'smith-machine-shrug.webp'),
(405,'Sentadilla en Tijera en Máquina Smith','Smith Machine Split Squat','Una sentadilla en tijera estática bajo la barra de la máquina Smith, con el pie trasero apoyado en el suelo en lugar de un banco, de modo que la trayectoria guiada quita el equilibrio de un movimiento unilateral.\n\nInstrucciones de ejecución:\n1. Coloca la barra lo bastante baja para que siga librando tus hombros en el punto más bajo de la repetición, métete debajo y apóyala sobre los trapecios altos.\n2. Desengancha la barra y da una zancada larga hacia delante con un pie, dejando el pie trasero apoyado en el suelo con el talón elevado.\n3. Comprueba que la tibia delantera quedará vertical al bajar; ajusta la longitud de la zancada antes de empezar a cargarla.\n4. Baja en línea recta flexionando ambas rodillas hasta que la rodilla trasera quede justo por encima del suelo y el muslo delantero cerca de la paralela.\n5. Empuja con el talón delantero para volver al inicio sin mover los pies, y repite las repeticiones deseadas antes de cambiar de lado.\n\nConsejos técnicos:\n• Fija primero la longitud de la zancada sin carga. Una vez que la barra está sobre tu espalda, la trayectoria fija no te dejará avanzar para corregir una posición demasiado corta.\n• Baja recto, no hacia delante. La barra solo puede desplazarse en vertical, así que empujar la cadera hacia delante únicamente adelanta la rodilla más allá de los dedos.\n• Haz el mismo número de repeticiones por lado y empieza por la pierna más débil, ya que una sentadilla en tijera guiada oculta una diferencia entre lados que una barra libre dejaría en evidencia.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'smith-machine-split-squat.webp'),
(406,'Sentadilla en Máquina Smith','Smith Machine Squat','Una sentadilla guiada en máquina Smith con la barra sobre los trapecios, que trabaja cuádriceps y glúteos con trayectoria fija.\n\nInstrucciones de ejecución:\n1. Ajusta la barra de la máquina Smith a la altura de los hombros y colócate debajo de ella.\n2. Apoya la barra sobre tus trapecios superiores y desrackéala.\n3. Párate con los pies al ancho de los hombros, ligeramente por delante de la barra.\n4. Desciende hasta que los muslos queden paralelos al suelo.\n5. Empuja a través de los talones para volver a la posición de pie.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Coloca los pies ligeramente por delante de la barra.\n• Baja hasta que los muslos queden paralelos al suelo.\n• Empuja con los talones para volver a subir.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'smith-machine-squat.webp'),
(407,'Remo al Mentón en Máquina Smith','Smith Machine Upright Row','Un remo al mentón en máquina Smith, tirando de la barra guiada por delante del torso con los codos al frente, para trabajar los deltoides laterales y el trapecio superior.\n\nInstrucciones de ejecución:\n1. Coloca la barra a la altura de las caderas, toma un agarre prono algo más ancho que los hombros y sitúate cerca de ella con los brazos estirados.\n2. Desengancha la barra y ponte erguido con los hombros atrás y el core activado.\n3. Tira de la barra en línea recta por delante del cuerpo, guiando con los codos y manteniendo la barra cerca.\n4. Detente cuando la barra llegue al pecho inferior y los codos queden a la altura de los hombros, y haz una pausa breve.\n5. Baja la barra de forma controlada hasta estirar los brazos de nuevo y repite las repeticiones deseadas.\n\nConsejos técnicos:\n• Detente a la altura del pecho. Tirar de la barra hasta la clavícula rota el hombro hacia la posición que provoca el pinzamiento por el que este ejercicio es conocido.\n• Guía con los codos, no con las manos. Si las muñecas suben primero, toman el relevo los bíceps y los deltoides laterales apenas trabajan.\n• Abre el agarre si el movimiento pincha. Un agarre estrecho fuerza más rotación interna, y la trayectoria fija de la barra no te deja ninguna alternativa.\n\nMúsculos principales: lateral_deltoid, trapezius',NULL,'smith-machine-upright-row.webp'),
(408,'Arrancada','Snatch','Un levantamiento olímpico que tira de la barra desde el suelo hasta encima de la cabeza en un solo movimiento, recibida en una sentadilla por encima de la cabeza.\n\nInstrucciones de ejecución:\n1. Párate con los pies al ancho de las caderas y agarra la barra con un agarre ancho.\n2. Inclínate hacia abajo manteniendo la espalda plana y el pecho arriba.\n3. Extiende explosivamente caderas, rodillas y tobillos para impulsar la barra hacia arriba.\n4. Colócate debajo de la barra en una sentadilla por encima de la cabeza.\n5. Levántate con la barra bloqueada por encima de la cabeza.\n6. Devuelve la barra al suelo y repite.\n\nConsejos técnicos:\n• Mantén la barra cerca del cuerpo mientras sube.\n• Extiende completamente las caderas antes de tirar por debajo de la barra.\n• Bloquea los brazos y estabiliza antes de ponerte de pie.\n\nMúsculos principales: gluteus_maximus, quadriceps, trapezius',NULL,'snatch.webp'),
(409,'Curl Araña','Spider Curl','Un curl tumbado boca abajo en banco inclinado con los brazos colgando verticales, aislando el bíceps en un rango estricto.\n\nInstrucciones de ejecución:\n1. Túmbate boca abajo en un banco inclinado con los brazos colgando rectos hacia abajo.\n2. Sostén una mancuerna en cada mano con agarre supino.\n3. Mantén los brazos superiores verticales mientras curleas los pesos hacia arriba.\n4. Aprieta fuerte los bíceps en la parte superior.\n5. Baja las mancuernas de forma controlada hasta la extensión completa.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén el pecho pegado al respaldo durante toda la serie.\n• Aprieta arriba sin dejar que los codos se desplacen hacia atrás.\n• Usa el rango completo: el estiramiento abajo es la mitad del beneficio.\n\nMúsculos principales: biceps_brachii',NULL,'spider-curl.webp'),
(410,'Jerk con Tijera','Split Jerk','Un levantamiento por encima de la cabeza que impulsa la barra con una flexión de piernas y la recibe en posición de tijera con los brazos bloqueados.\n\nInstrucciones de ejecución:\n1. Sostén la barra en el rack frontal con los codos altos.\n2. Baja recto doblando ligeramente las rodillas.\n3. Impulsa la barra por encima de la cabeza explosivamente con piernas y brazos.\n4. Abre los pies hacia adelante y hacia atrás mientras la barra se bloquea.\n5. Levántate juntando los pies bajo la barra.\n6. Baja la barra y repite.\n\nConsejos técnicos:\n• Flexiona recto hacia abajo en lugar de inclinar el torso hacia delante.\n• Separa los pies adelante y atrás mientras la barra se bloquea.\n• Al recuperarte, lleva primero el pie delantero hacia atrás.\n\nMúsculos principales: anterior_deltoid, quadriceps',NULL,'split-jerk.webp'),
(411,'Sentadilla en Tijera','Split Squat','Una zancada estática bajando en línea recta con las piernas en tijera, desarrollando fuerza unilateral sin dar el paso.\n\nInstrucciones de ejecución:\n1. Párate en posición de tijera con un pie adelante y otro atrás.\n2. Mantén el torso erguido y el core contraído.\n3. Baja las caderas rectas hacia abajo doblando ambas rodillas.\n4. Detente cuando la rodilla trasera esté justo por encima del suelo.\n5. Empuja a través del talón delantero para volver al inicio.\n6. Completa las repeticiones de un lado y luego cambia.\n\nConsejos técnicos:\n• Baja en línea recta en lugar de lanzarte hacia delante.\n• Mantén la mayor parte del peso sobre el pie delantero.\n• Mantén el talón delantero apoyado durante toda la repetición.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'split-squat.webp'),
(412,'Press Spoto','Spoto Press','Un press de banca con barra que incluye una pausa con la barra suspendida sobre el pecho, eliminando el rebote.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco plano y agarra la barra ligeramente más ancha que los hombros.\n2. Desrackea la barra y sostenla sobre el pecho con los brazos extendidos.\n3. Baja la barra hasta que quede a un centímetro por encima del pecho.\n4. Mantén esa posición un segundo completo sin tocar el pecho.\n5. Empuja la barra hacia arriba hasta que los brazos estén extendidos.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Detén la barra a un par de centímetros del pecho.\n• Mantén la pausa un segundo completo sin tocar el pecho.\n• Conserva los omóplatos retraídos durante todo el recorrido.\n\nMúsculos principales: pectoralis_major',NULL,'spoto-press.webp'),
(413,'Puente de Cadera con Balón de Estabilidad','Stability Ball Hip Bridge','Un puente de glúteos con los pies sobre un balón de estabilidad, que añade demanda antirotación y de equilibrio al patrón básico del puente.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba en el suelo y coloca ambos pies sobre un balón de estabilidad.\n2. Los brazos descansan a los lados en el suelo para equilibrarte.\n3. Aprieta los glúteos y presiona los talones contra el balón para elevar las caderas.\n4. Termina con una línea recta desde los hombros hasta las rodillas.\n5. Baja las caderas de forma controlada sin que el balón ruede.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• El balón intentará desplazarse: mantén los pies presionados directamente hacia abajo.\n• Sin hiperextensión en la parte superior; detente cuando el cuerpo esté en línea.\n\nMúsculos principales: gluteus_maximus',NULL,'stability-ball-hip-bridge.webp'),
(414,'Encogimiento de Rodillas con Balón de Estabilidad','Stability Ball Knee Tuck','Un encogimiento de rodillas en posición de plancha con los pies sobre un balón de estabilidad, rodando el balón hacia las caderas para trabajar el abdomen dinámicamente.\n\nInstrucciones de ejecución:\n1. Comienza en plancha alta con las espinillas o el dorso de los pies sobre un balón de estabilidad.\n2. Las manos están bajo los hombros y el cuerpo en línea recta.\n3. Contrae el core y lleva el balón hacia el pecho encogiendo las rodillas.\n4. Rueda de vuelta hacia afuera extendiendo completamente las piernas a la posición de plancha.\n5. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Las caderas no se elevan; mantén el tronco nivelado durante todo el encogimiento.\n• Los hombros permanecen sobre las muñecas: no dejes que se desplacen hacia adelante.\n\nMúsculos principales: rectus_abdominis',NULL,'stability-ball-knee-tuck.webp'),
(415,'Flexión sobre pelota de estabilidad (manos en la pelota)','Stability Ball Push-Up (Hands on Ball)','Una flexión inclinada realizada con ambas manos sobre una pelota de estabilidad y los pies en el suelo. La superficie inestable exige más al pecho, los hombros y los tríceps, mientras el core mantiene el cuerpo rígido.\n\nInstrucciones de ejecución:\n1. Coloca ambas manos sobre una pelota de estabilidad y camina con los pies hacia atrás hasta una plancha con los brazos extendidos, el cuerpo en línea recta de la cabeza a los talones.\n2. Activa el core y mantén la pelota firme bajo las manos.\n3. Flexiona los codos para bajar el pecho hacia la pelota de forma controlada.\n4. Empuja de nuevo hasta la extensión completa de los brazos sin dejar que la pelota ruede.\n5. Repite las repeticiones deseadas.\n\nConsejos técnicos:\n• Mantén el cuerpo en una línea recta y rígida: no dejes que las caderas se hundan ni se eleven.\n• Muévete lento y con control; la inestabilidad de la pelota es lo que hace efectivo el ejercicio, así que resístela en lugar de combatirla con rapidez.\n• Coloca las manos algo más anchas que los hombros sobre la pelota y mantén los codos a unos 45 grados.\n\nMúsculos principales: pectoralis_major',NULL,'stability-ball-push-up-hands-on-ball.webp'),
(416,'Push-Up con Balón de Estabilidad','Stability Ball Push-Up','Un push-up realizado con los pies sobre un balón de estabilidad, que añade una fuerte demanda antirotación al push-up estándar.\n\nInstrucciones de ejecución:\n1. Arrodíllate frente a un balón de estabilidad y coloca las espinillas o los pies encima.\n2. Apoya las manos en el suelo bajo los hombros en posición de plancha alta.\n3. Contrae fuerte el core: el balón querrá rodar hacia los lados.\n4. Baja el pecho al suelo doblando los codos.\n5. Vuelve a empujar hasta la posición inicial sin dejar que el balón se tambalee.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Comienza con las espinillas sobre el balón; solo con los pies es mucho más difícil.\n• Si el balón se desplaza de lado a lado, falta contracción del core: reduce la velocidad.\n\nMúsculos principales: pectoralis_major',NULL,'stability-ball-push-up.webp'),
(417,'Sentadilla en Pared con Pelota','Stability Ball Wall Squat','Una sentadilla con peso corporal apoyando una pelota suiza entre la zona lumbar y la pared, que guía la columna.\n\nInstrucciones de ejecución:\n1. Coloca una pelota suiza entre tu zona lumbar y una pared.\n2. Adelanta los pies unos 30 cm, un poco más anchos que los hombros.\n3. Baja en sentadilla mientras la pelota rueda por la espalda.\n4. Detente cuando los muslos queden paralelos al suelo.\n5. Empuja con los talones para volver a subir.\n\nConsejos técnicos:\n• Carga el peso en talones y medio del pie.\n• No dejes que las rodillas pasen las puntas de los pies.\n• La pelota debe rodar suavemente — no te separes de ella.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'stability-ball-wall-squat.webp'),
(418,'Flexión de Pie a Media Elevación','Standing Forward Fold to Half Lift','La articulación conocida como media elevación: desde una flexión de pie el pecho sube hasta dejar la espalda plana y la columna larga, y luego vuelve a plegarse. Enseña la diferencia entre una flexión redondeada y una bisagra con la columna larga.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies a la anchura de las caderas y pliégate hacia delante desde las caderas.\n2. Apoya las manos en las espinillas, en el suelo o en bloques.\n3. Desliza las manos por las espinillas y eleva el pecho hasta dejar la espalda plana y la columna larga.\n4. Vuelve a plegarte dejando que la cabeza y el cuello se relajen.\n5. Sigue alternando entre ambas posiciones las veces indicadas.\n\nConsejos técnicos:\n• Deja una ligera flexión en las rodillas para que el movimiento venga de las caderas.\n• Sube a espalda plana en lugar de mirar hacia arriba; el cuello sigue a la columna.\n• Aleja los hombros de las orejas en la posición elevada.\n\nMúsculos principales: erector_spinae, hamstrings',NULL,'standing-forward-fold-to-half-lift.webp'),
(419,'Flexión Lateral de Pie Alterna','Standing Side Bend Flow','Un flujo lateral de pie: los brazos se estiran por encima de la cabeza y el tronco se inclina de lado a lado con un ritmo controlado, alargando el costado sin sostener ninguna posición final.\n\nInstrucciones de ejecución:\n1. Ponte de pie con los pies a la anchura de las caderas y estira ambos brazos por encima de la cabeza.\n2. Inclina el tronco hacia un lado manteniendo los pies apoyados y las caderas niveladas.\n3. Vuelve por el centro con las costillas alineadas sobre la pelvis.\n4. Inclínate hacia el otro lado del mismo modo.\n5. Sigue alternando las veces indicadas.\n\nConsejos técnicos:\n• Inclínate solo lateralmente: si el pecho rota, se convierte en un giro.\n• Mantén ambos talones apoyados para que el movimiento se quede en el tronco.\n• Muévete con la respiración en lugar de rebotar al final del recorrido.\n\nMúsculos principales: obliques',NULL,'standing-side-bend-flow.webp'),
(420,'Step Ups','Step Ups','Una subida a un cajón o banco con una pierna que entrena cuádriceps y glúteos de forma funcional.\n\nInstrucciones de ejecución:\n1. Párate frente a una caja o banco resistente.\n2. Coloca un pie completamente sobre la superficie de la caja.\n3. Empuja a través de ese talón para subir el cuerpo a la caja.\n4. Sube el pie de atrás para quedar completamente sobre la caja.\n5. Baja con el mismo pie que subió primero.\n6. Alterna piernas o completa todas las repeticiones de un lado antes de cambiar.\n\nConsejos técnicos:\n• Apoya todo el pie sobre la superficie del cajón.\n• Impulsa con el talón de la pierna que sube, no con la de atrás.\n• Controla el descenso en lugar de dejarte caer.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'step-ups.webp'),
(421,'Peso Muerto con Piernas Rígidas','Stiff Leg Deadlift','Una bisagra de cadera con las piernas casi rectas, bajando la barra a lo largo de los muslos para estirar y cargar los isquiotibiales.\n\nInstrucciones de ejecución:\n1. Párate con los pies al ancho de las caderas, sosteniendo una barra frente a los muslos.\n2. Mantén las piernas casi rectas con solo una ligera flexión de rodillas.\n3. Inclínate en las caderas y baja la barra a lo largo de las piernas.\n4. Baja hasta donde la flexibilidad de los isquiotibiales lo permita con la espalda plana.\n5. Empuja a través de los talones para volver a la posición erguida.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Lleva las caderas hacia atrás y mantén la barra cerca de las piernas.\n• Baja solo hasta donde te permita mantener la espalda plana.\n• Siente la carga en los isquiotibiales al estirar y luego empuja las caderas hacia delante para subir.\n\nMúsculos principales: gluteus_maximus, hamstrings',NULL,'stiff-leg-deadlift.webp'),
(422,'Jalón con Brazos Rectos','Straight-Arm Pulldown','Un ejercicio de aislamiento para los dorsales usando cable con los brazos rectos.\n\nInstrucciones de ejecución:\n1. Párate frente a una máquina de cable con una barra recta enganchada a la polea alta.\n2. Con los brazos casi rectos, empuja la barra hacia abajo en un arco hacia los muslos.\n3. Aprieta los dorsales en la parte inferior.\n4. Devuelve la barra lentamente a la posición inicial.\n5. Repite.\n\nConsejos técnicos:\n• Mantén los brazos casi rectos durante todo el movimiento.\n• Lleva la barra hacia los muslos describiendo un arco.\n• Aprieta los dorsales en la parte baja del recorrido.\n\nMúsculos principales: latissimus_dorsi',NULL,'straight-arm-pulldown.webp'),
(423,'Elevación frontal en polea con barra recta','Straight-Bar Cable Front Raise','Una elevación frontal en la polea baja sujetando una barra recta con ambas manos. A diferencia de la elevación frontal en polea a un brazo, los dos brazos mueven la misma barra y el cable mantiene la tensión sobre el deltoides anterior en todo el recorrido.\n\nInstrucciones de ejecución:\n1. Engancha una barra recta a la polea baja y colócate de espaldas a la máquina, con el cable pasando por delante de las piernas.\n2. Sujeta la barra en pronación con las manos a la anchura de los hombros y los brazos colgando estirados delante de los muslos.\n3. Mantén los codos casi extendidos y el core firme para que el torso no se incline hacia atrás.\n4. Eleva la barra hacia delante en un arco suave hasta la altura de los hombros.\n5. Bájala de forma controlada hasta los muslos y repite las repeticiones deseadas.\n\nConsejos técnicos:\n• Usa poco peso: impulsar la barra con las piernas o inclinarte hacia atrás quita el trabajo al deltoides anterior.\n• Detente a la altura de los hombros; subir más traslada la carga al trapecio.\n• Mantén las muñecas neutras en lugar de dejar que se doblen bajo la barra.\n\nMúsculos principales: anterior_deltoid',NULL,'straight-bar-cable-front-raise.webp'),
(424,'Fondos en Barra Recta','Straight Bar Dips','Una variante de fondos realizada colgando de una barra recta de dominadas en lugar de barras paralelas de fondos, empujando el cuerpo hacia arriba en un rango de movimiento reducido.\n\nInstrucciones de ejecución:\n1. Agarra una barra recta por encima de la cabeza con ambas manos, colgando con los brazos extendidos y los pies fuera del suelo.\n2. Manteniendo el cuerpo recto, empuja hacia abajo a través de la barra para elevar los hombros y el pecho.\n3. Haz una breve pausa en la parte superior del movimiento.\n4. Baja con control de vuelta a la posición colgante.\n5. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Mantén el movimiento controlado -- es un rango de movimiento pequeño comparado con los fondos en barras paralelas.\n• Contrae el core para evitar que el cuerpo se balancee.\n• Esta posición de muñeca y hombro es más exigente que los fondos estándar -- aumenta el volumen gradualmente.\n\nMúsculos principales: pectoralis_major',NULL,'straight-bar-dips.webp'),
(425,'Curl Estricto','Strict Curl','Un curl de pie realizado sin ningún impulso corporal — el torso permanece quieto y los codos se mantienen fijos, de modo que el bíceps hace todo el trabajo.\n\nInstrucciones de ejecución:\n1. Ponte de pie con una mancuerna en cada mano, los brazos a los costados y las palmas hacia adelante.\n2. Fija los codos a los costados y contrae el core para que el torso no pueda balancearse.\n3. Flexiona ambas mancuernas hacia arriba moviendo solo los codos.\n4. Bájalas de forma controlada hasta que los brazos queden rectos.\n5. Repite las repeticiones deseadas.\n\nConsejos técnicos:\n• Ponerte de pie con la espalda contra una pared o poste es una buena autoevaluación — si los hombros o las caderas se separan de ella, estás usando impulso.\n• Evita que los codos se adelanten; los brazos superiores deben permanecer verticales durante todo el movimiento.\n• Baja más lento de lo que subes — la versión estricta vive en el descenso.\n\nMúsculos principales: biceps_brachii',NULL,'strict-curl.webp'),
(426,'Peso Muerto Sumo','Sumo Deadlift','Una variante del peso muerto con postura amplia que desplaza el énfasis hacia glúteos, cuádriceps e interior de los muslos.\n\nInstrucciones de ejecución:\n1. Párate con los pies más anchos que el ancho de los hombros, con los pies apuntando hacia afuera.\n2. Agarra la barra entre las piernas.\n3. Contrae el core y empuja a través de los talones para levantarte.\n4. Baja de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Mantén la barra pegada al cuerpo.\n• Empuja las rodillas hacia afuera en línea con los dedos de los pies.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'sumo-deadlift.webp'),
(427,'Sentadilla Sumo','Sumo Squat','Una sentadilla con barra y postura amplia con las puntas hacia afuera, que enfatiza glúteos y cara interna de los muslos.\n\nInstrucciones de ejecución:\n1. Párate con los pies más anchos que el ancho de los hombros y los pies apuntando hacia afuera.\n2. Sostén una barra sobre la parte superior de la espalda.\n3. Contrae el core y mantén el pecho arriba.\n4. Dobla caderas y rodillas para bajar a una sentadilla profunda.\n5. Empuja a través de los talones para volver a la posición de pie.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Abre las puntas de los pies y empuja las rodillas hacia afuera.\n• Mantén el pecho alto y el core firme.\n• Baja en profundidad flexionando caderas y rodillas a la vez.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'sumo-squat.webp'),
(428,'Superman','Superman','Un ejercicio de peso corporal para la zona lumbar realizado en prono, levantando brazos y piernas simultáneamente.\n\nInstrucciones de ejecución:\n1. Túmbate boca abajo con los brazos extendidos por encima de la cabeza.\n2. Levanta simultáneamente los brazos, el pecho y las piernas del suelo.\n3. Mantén brevemente la posición superior.\n4. Baja de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Aprieta los glúteos al levantar.\n• Evita los movimientos bruscos.\n\nMúsculos principales: erector_spinae, gluteus_maximus',NULL,'superman.webp'),
(429,'Limpiaparabrisas Tumbado','Supine Windshield Wipers','Un ejercicio de rotación tumbado: con las rodillas flexionadas o las piernas elevadas, ambas piernas oscilan de lado a lado como limpiaparabrisas mientras los hombros permanecen pegados al suelo.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con los brazos abiertos a los lados y las rodillas flexionadas sobre las caderas.\n2. Aprieta el tronco para que la zona lumbar no se despegue del suelo.\n3. Baja ambas piernas juntas hacia un lado mientras los hombros sigan apoyados.\n4. Devuélvelas por el centro y bájalas hacia el otro lado.\n5. Sigue alternando las veces indicadas.\n\nConsejos técnicos:\n• Ambos hombros se quedan en el suelo; son ellos los que definen el recorrido, no las piernas.\n• Mantén las rodillas juntas para que la pelvis se mueva como una unidad.\n• Estira las piernas para una versión mucho más difícil cuando tengas el control.\n\nMúsculos principales: obliques, rectus_abdominis',NULL,'supine-windshield-wipers.webp'),
(430,'Press Svend','Svend Press','Un press con apretón de disco que carga los pectorales a través de la aducción isométrica mientras se extiende el peso alejándolo del pecho.\n\nInstrucciones de ejecución:\n1. Párate erguido sosteniendo un disco de pesas (o dos apretados juntos) entre las palmas a la altura del pecho.\n2. Aprieta fuerte los discos para generar tensión en los pectorales.\n3. Empuja los discos recto hacia adelante hasta que los brazos estén completamente extendidos.\n4. Haz una breve pausa manteniendo el apretón, luego devuelve los discos al pecho.\n5. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Cuanto más fuerte aprietes los discos, mayor activación del pecho obtendrás.\n• Mantén los discos a la altura del esternón durante todo el ejercicio: no dejes que caigan hacia las caderas.\n\nMúsculos principales: pectoralis_major',NULL,'svend-press.webp'),
(431,'Remo en T','T-Bar Row','Un remo compuesto con barra en T y torso inclinado, que desarrolla dorsales y romboides con cargas elevadas.\n\nInstrucciones de ejecución:\n1. Colócate a horcajadas sobre la barra en T con los pies al ancho de los hombros.\n2. Inclínate en las caderas hasta que el torso quede a unos 45 grados.\n3. Agarra los mangos y mantén la espalda plana.\n4. Tira de la barra hacia el pecho llevando los codos hacia atrás.\n5. Aprieta los omóplatos en la parte superior.\n6. Baja la barra de forma controlada y repite.\n\nConsejos técnicos:\n• Inclina el torso unos 45 grados manteniendo la espalda plana.\n• Tira llevando los codos hacia atrás, no solo con los brazos.\n• Junta los omóplatos en la parte alta del tirón.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'t-bar-row.webp'),
(432,'Enhebrar la Aguja Dinámico','Thread the Needle Flow','La versión en movimiento de enhebrar la aguja: desde cuatro apoyos el brazo pasa por debajo del cuerpo y después se abre hacia el techo, rotando la columna torácica por todo su recorrido.\n\nInstrucciones de ejecución:\n1. Comienza a cuatro apoyos con las manos bajo los hombros y las rodillas bajo las caderas.\n2. Desliza un brazo por debajo del cuerpo hasta que el hombro se acerque a la esterilla.\n3. Invierte el movimiento y abre ese brazo hacia el techo, siguiendo la mano con la mirada.\n4. Vuelve por el centro y repite las veces indicadas.\n5. Cambia de lado y repite.\n\nConsejos técnicos:\n• Mantén las caderas sobre las rodillas para que la rotación se quede en la espalda alta.\n• Trabaja a un ritmo uniforme en lugar de abrir el brazo de golpe.\n• Deja que la cabeza siga a la mano en lugar de liderar el movimiento.\n\nMúsculos principales: obliques, trapezius',NULL,'thread-the-needle-flow.webp'),
(433,'Thruster','Thruster','Un movimiento de cuerpo completo con barra que combina una sentadilla frontal con un press por encima de la cabeza en un solo impulso fluido.\n\nInstrucciones de ejecución:\n1. Sostén una barra en posición de rack frontal con los codos altos.\n2. Párate con los pies al ancho de los hombros.\n3. Baja en sentadilla hasta paralelo manteniendo el torso erguido.\n4. Impúlsate saliendo de la sentadilla y empuja la barra por encima de la cabeza en un solo movimiento.\n5. Bloquea los brazos en la parte superior con la barra sobre la cabeza.\n6. Baja la barra al rack frontal y repite.\n\nConsejos técnicos:\n• Aprovecha el impulso de la sentadilla para lanzar el press.\n• Mantén los codos altos para que la barra descanse en los hombros, no en las muñecas.\n• Termina cada repetición con la barra bloqueada sobre las orejas.\n\nMúsculos principales: anterior_deltoid, quadriceps',NULL,'thruster.webp'),
(434,'Toes to Bar','Toes to Bar','Un ejercicio avanzado de core colgado de una barra que requiere fuerza de flexión de cadera y activación del dorsal para llevar los pies hasta la barra.\n\nInstrucciones de ejecución:\n1. Cuélgate de una barra con agarre prono y los brazos completamente extendidos, cuerpo quieto.\n2. Activa los dorsales y el core para evitar balanceos.\n3. Eleva las piernas con rodillas rectas llevando los pies hacia la barra.\n4. Toca la barra con los pies, luego baja las piernas con control.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Inicia el movimiento desde el core, no con impulso de patada.\n• Exhala con fuerza al elevar las piernas para aumentar la presión intraabdominal.\n• Si no puedes alcanzar la barra, practica las elevaciones de piernas colgado como progresión.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'toes-to-bar.webp'),
(435,'Patada de Tríceps con Mancuerna','Dumbbell Tricep Kickback','Un ejercicio de aislamiento para los tríceps realizado en posición inclinada hacia adelante.\n\nInstrucciones de ejecución:\n1. Inclínate hacia adelante en las caderas sosteniendo una mancuerna con el codo doblado a 90 grados.\n2. Extiende el brazo recto hacia atrás apretando el tríceps.\n3. Mantén brevemente en la extensión completa.\n4. Baja con control.\n5. Repite en ambos lados.\n\nConsejos técnicos:\n• Mantén el codo pegado y fijo junto al torso.\n• Extiende el brazo por completo apretando el tríceps al final.\n• Trabaja un lado a la vez con control en la bajada.\n\nMúsculos principales: triceps_brachii',NULL,'tricep-kickback.webp'),
(436,'Jalón de Tríceps en Cable','Cable Tricep Pushdown','Un ejercicio de aislamiento para los tríceps usando una máquina de cable.\n\nInstrucciones de ejecución:\n1. Párate frente a una máquina de cable con un accesorio de barra recta.\n2. Agarra la barra y pega los codos a los costados.\n3. Empuja la barra hacia abajo hasta que los brazos estén completamente extendidos.\n4. Regresa lentamente a la posición inicial.\n5. Repite.\n\nConsejos técnicos:\n• Mantén el torso erguido.\n• Solo deben moverse los antebrazos.\n\nMúsculos principales: triceps_brachii',NULL,'tricep-pushdown.webp'),
(437,'Curl de Bíceps TRX','TRX Bicep Curl','Este ejercicio utiliza un entrenador de suspensión para aislar y fortalecer los músculos bíceps braquial y braquial, desarrollando fuerza e hipertrofia en la parte superior del brazo.\n\nInstrucciones de ejecución:\n1. Ajusta las correas del entrenador de suspensión a una longitud media.\n2. Párate frente al punto de anclaje, sujeta las asas con un agarre supino e inclínate hacia atrás hasta que tus brazos estén completamente extendidos.\n3. Mantén tu cuerpo recto y el core activado, jala tu pecho hacia tus manos doblando los codos.\n4. Contrae tus bíceps en la parte superior del movimiento.\n5. Extiende lentamente tus brazos de regreso a la posición inicial, controlando el descenso.\n6. Mantén la tensión durante toda la serie.\n\nConsejos técnicos:\n• Ajusta el ángulo de tu cuerpo para aumentar o disminuir la dificultad; inclinarte más hacia atrás lo hace más difícil.\n• Mantén los codos altos y fijos para aislar los bíceps de manera efectiva.\n• Evita balancear tu cuerpo o usar el impulso; concéntrate en una contracción controlada.\n• Asegura un rango completo de movimiento, desde la extensión total hasta una fuerte contracción máxima.\n\nMúsculos principales: biceps_brachii',NULL,'trx-bicep-curl.webp'),
(438,'Press de Pecho con TRX','TRX Chest Press','Un ejercicio compuesto de empuje que utiliza un entrenador de suspensión para desarrollar fuerza y estabilidad en el pecho.\n\nInstrucciones de ejecución:\n1. Ajusta las asas del entrenador de suspensión a la altura de la mitad de la pantorrilla.\n2. Ponte de espaldas al punto de anclaje, sosteniendo un asa en cada mano, con los brazos extendidos.\n3. Inclínate hacia adelante en una posición de plancha, manteniendo tu cuerpo recto de la cabeza a los talones.\n4. Baja tu pecho hacia tus manos doblando los codos, manteniendo la tensión en las correas.\n5. Empuja hacia arriba a la posición inicial, extendiendo completamente los brazos y contrayendo el pecho.\n\nConsejos técnicos:\n• Mantén tu core activado durante todo el movimiento para mantener una plancha rígida.\n• Controla la fase excéntrica (descenso) para una mejor activación muscular.\n• Ajusta la posición de tus pies para modificar la dificultad: más cerca del anclaje para más fácil, más lejos para más difícil.\n• Asegúrate de que tus codos se muevan ligeramente hacia afuera y hacia atrás, sin abrirlos demasiado.\n\nMúsculos principales: pectoralis_major',NULL,'trx-chest-press.webp'),
(439,'Face Pull con TRX','TRX Face Pull','El Face Pull con TRX es un ejercicio de tracción compuesto que trabaja los deltoides posteriores y los romboides, utilizando un entrenador de suspensión para mejorar la fuerza de la parte superior de la espalda y la postura.\n\nInstrucciones de ejecución:\n1. Sujeta las asas del TRX con un agarre prono, las palmas hacia abajo.\n2. Inclínate hacia atrás hasta que tus brazos estén completamente extendidos y tu cuerpo forme una línea recta.\n3. Tira de las asas hacia tu cara, llevando los codos altos y abiertos.\n4. Aprieta los omóplatos al máximo de la contracción.\n5. Extiende lentamente los brazos de vuelta a la posición inicial con control.\n\nConsejos técnicos:\n• Mantén el torso rígido durante todo el movimiento; evita arquear la espalda baja.\n• Concéntrate en iniciar la tracción con los músculos de la parte superior de la espalda, no solo con los brazos.\n• Ajusta el ángulo de tu cuerpo para modificar la dificultad: una posición más horizontal es más difícil.\n\nMúsculos principales: posterior_deltoid, rhomboids',NULL,'trx-face-pull.webp'),
(440,'Curl de Isquiotibiales con TRX','TRX Hamstring Curl','Este ejercicio de aislamiento utiliza un entrenador de suspensión para trabajar los isquiotibiales, glúteos y pantorrillas al flexionar los talones hacia los glúteos.\n\nInstrucciones de ejecución:\n1. Acuéstate boca arriba con los talones en los soportes del entrenador de suspensión, rodillas flexionadas a 90 grados.\n2. Levanta tus caderas del suelo, creando una línea recta desde las rodillas hasta los hombros.\n3. Extiende tus piernas hacia adelante, manteniendo las caderas elevadas y la tensión en el core.\n4. Tira de tus talones hacia tus glúteos, contrayendo los isquiotibiales con fuerza.\n5. Controla el movimiento, evitando que las caderas caigan durante toda la serie.\n\nConsejos técnicos:\n• Mantén tu core contraído para evitar que tus caderas se hundan.\n• Concéntrate en una fuerte contracción de los isquiotibiales en el punto máximo del curl.\n• Controla la fase excéntrica extendiendo lentamente tus piernas.\n\nMúsculos principales: hamstrings',NULL,'trx-hamstring-curl.webp'),
(441,'Zancada TRX','TRX Lunge','Un ejercicio unilateral de tren inferior apto para principiantes que utiliza un entrenador de suspensión para trabajar los cuádriceps y glúteos, mientras involucra los isquiotibiales y el glúteo medio para la estabilidad.\n\nInstrucciones de ejecución:\n1. Ponte de espaldas al punto de anclaje, sosteniendo las asas del entrenador de suspensión frente a ti.\n2. Coloca un pie en ambos estribos, extendiendo la pierna hacia atrás.\n3. Contrae tu abdomen y baja tu cuerpo doblando la rodilla delantera, manteniendo el torso erguido.\n4. Desciende hasta que tu muslo delantero esté paralelo al suelo o ligeramente por debajo, manteniendo la tensión en el entrenador de suspensión.\n5. Impúlsate a través del talón delantero para volver a la posición inicial, extendiendo la pierna delantera.\n6. Completa todas las repeticiones en un lado, luego cambia de pierna y repite por lado.\n\nConsejos técnicos:\n• Mantén tu rodilla delantera alineada con tus dedos del pie, evitando que colapse hacia adentro.\n• Conserva una columna vertebral neutra durante todo el movimiento, previniendo un arqueo o redondeo excesivo.\n• Controla la fase excéntrica (de descenso) para maximizar el compromiso muscular.\n• Ajusta tu distancia del punto de anclaje para modificar la dificultad.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'trx-lunge.webp'),
(442,'Sentadilla Pistola con TRX','TRX Pistol Squat','Un desafiante ejercicio unilateral de pierna que utiliza un entrenador de suspensión para asistir el equilibrio y la profundidad, trabajando principalmente los cuádriceps y glúteos.\n\nInstrucciones de ejecución:\n1. Ancla el entrenador de suspensión y sujeta las asas con ambas manos, con los brazos extendidos.\n2. Ponte de pie, levanta una pierna recta hacia adelante, manteniéndola separada del suelo.\n3. Inicia la sentadilla empujando las caderas hacia atrás y doblando la rodilla de la pierna de apoyo, bajando el cuerpo lo más profundo posible.\n4. Mantén el pecho erguido, la espalda recta y usa el TRX para el equilibrio y soporte según sea necesario.\n5. Impúlsate a través del talón para volver a la posición inicial, extendiendo completamente la pierna de apoyo.\n6. Completa todas las repeticiones por lado antes de cambiar de pierna.\n\nConsejos técnicos:\n• Mantén la tensión en las correas del TRX durante todo el movimiento para mayor estabilidad.\n• Concéntrate en un descenso controlado y un ascenso potente.\n• Mantén la pierna que no trabaja extendida y elevada para activar los flexores de la cadera.\n• Ajusta tu agarre en el TRX para modificar el nivel de asistencia.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'trx-pistol-squat.webp'),
(443,'Remo TRX','TRX Row','Este ejercicio de tracción con peso corporal utiliza un entrenador de suspensión para trabajar toda tu espalda, desarrollando fuerza en los dorsales, romboides y bíceps.\n\nInstrucciones de ejecución:\n1. Sujeta las asas de un entrenador de suspensión con un agarre prono, las palmas de las manos enfrentadas.\n2. Inclínate hacia atrás, extendiendo completamente los brazos y manteniendo el cuerpo recto de la cabeza a los talones.\n3. Activa tu core y tira del pecho hacia las manos, juntando los omóplatos.\n4. Haz una breve pausa en la parte superior, luego baja lentamente a la posición inicial con control.\n5. Mantén el cuerpo rígido durante todo el movimiento, evitando que las caderas se caigan.\n\nConsejos técnicos:\n• Ajusta la posición de tus pies: cuanto más cerca estén tus pies del punto de anclaje, más difícil será el ejercicio.\n• Mantén los codos cerca del cuerpo para enfatizar los dorsales, o ábrelos ligeramente para trabajar más la parte superior de la espalda.\n• Concéntrate en iniciar la tracción con los músculos de la espalda, no solo con los brazos.\n• Controla la fase excéntrica (de descenso) para maximizar el compromiso muscular.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'trx-row.webp'),
(444,'Sentadilla TRX','TRX Squat','Este ejercicio compuesto de peso corporal utiliza un entrenador de suspensión para asistir en la realización de una sentadilla, trabajando eficazmente cuádriceps, glúteos e isquiotibiales.\n\nInstrucciones de ejecución:\n1. Párate mirando hacia el punto de anclaje, sosteniendo las asas con las palmas enfrentadas y los brazos extendidos.\n2. Inclínate ligeramente hacia atrás, manteniendo tu cuerpo recto y el core activado, con los pies al ancho de los hombros.\n3. Inicia la sentadilla empujando las caderas hacia atrás y doblando las rodillas, bajando tu cuerpo como si te sentaras en una silla.\n4. Desciende hasta que tus muslos estén paralelos al suelo o tan profundo como te sea cómodo, manteniendo la tensión en las correas.\n5. Impúlsate a través de los talones para volver a la posición inicial, extendiendo completamente las caderas y las rodillas.\n\nConsejos técnicos:\n• Mantén el pecho erguido y la mirada al frente durante todo el movimiento para mantener una columna vertebral neutra.\n• Usa el entrenador de suspensión para ayudarte a controlar el descenso y el ascenso, especialmente si eres nuevo en las sentadillas.\n• Concéntrate en empujar las rodillas ligeramente hacia afuera para activar los glúteos de manera más efectiva.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'trx-squat.webp'),
(445,'Extensión de Tríceps TRX','TRX Triceps Extension','Este ejercicio trabaja el tríceps braquial utilizando un entrenador de suspensión, enfocándose en la extensión del codo para el desarrollo y la fuerza de la parte superior del brazo.\n\nInstrucciones de ejecución:\n1. Párate frente al punto de anclaje, sosteniendo las asas del TRX con un agarre por encima, las palmas hacia abajo.\n2. Inclínate hacia adelante, extendiendo tus brazos rectos frente a ti a la altura de los hombros, creando tensión en las correas.\n3. Manteniendo los codos altos y fijos, dóblalos para bajar tu cuerpo, llevando tus manos hacia tus sienes.\n4. Extiende los codos con fuerza para empujar tu cuerpo de vuelta a la posición inicial, contrayendo tus tríceps.\n5. Mantén una posición de plancha rígida durante todo el movimiento, activando tu core y glúteos.\n\nConsejos técnicos:\n• Ajusta el ángulo de tu cuerpo para aumentar o disminuir la dificultad; cuanto más horizontal, más difícil será el ejercicio.\n• Mantén los codos apuntando hacia adelante y altos para maximizar el aislamiento del tríceps y minimizar la participación del hombro.\n• Controla la fase excéntrica (descenso) para una mejor activación y crecimiento muscular.\n\nMúsculos principales: triceps_brachii',NULL,'trx-tricep-extension.webp'),
(446,'TRX Y-Fly','TRX Y-Fly','Este ejercicio con el entrenador de suspensión fortalece los deltoides posteriores y el trapecio, mejorando la salud del hombro y la postura al fortalecer la parte superior de la espalda.\n\nInstrucciones de ejecución:\n1. Párate frente al punto de anclaje, sujetando las asas con un agarre por encima, las palmas de las manos enfrentadas.\n2. Inclínate hacia atrás, extendiendo los brazos rectos hacia adelante, manteniendo tu cuerpo en posición de plancha.\n3. Inicia el movimiento juntando y bajando tus omóplatos, formando una \"Y\" con tu cuerpo.\n4. Mantén los brazos rectos y los codos ligeramente flexionados, apretando los omóplatos en la parte superior.\n5. Controla lentamente el descenso de vuelta a la posición inicial, resistiendo la tracción de las correas.\n\nConsejos técnicos:\n• Ajusta el ángulo de tu cuerpo para modificar la dificultad: inclinarte más hacia atrás aumenta el desafío.\n• Concéntrate en la retracción y depresión de tus omóplatos durante todo el movimiento.\n• Mantén un core rígido y una línea corporal recta para evitar que las caderas se caigan.\n\nMúsculos principales: posterior_deltoid, trapezius',NULL,'trx-y-fly.webp'),
(447,'Remo al Mentón con Barra','Barbell Upright Row','Un movimiento de tirón compuesto para los deltoides laterales y el trapecio superior.\n\nInstrucciones de ejecución:\n1. Párate sosteniendo una barra con un agarre en pronación a la anchura de los hombros.\n2. Tira de la barra hacia arriba a lo largo del cuerpo en dirección al mentón.\n3. Lidera con los codos, manteniéndolos por encima de las manos.\n4. Baja la barra de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Sube la barra pegada al cuerpo hacia la barbilla.\n• Guía el movimiento con los codos por encima de las manos.\n• Baja la barra de forma controlada en cada repetición.\n\nMúsculos principales: lateral_deltoid, trapezius',NULL,'upright-row.webp'),
(448,'Jalón al Pecho con Barra en V','V-Bar Lat Pulldown','Un jalón con agarre neutro realizado con una barra en V estrecha, maximizando el estiramiento del dorsal y permitiendo una contracción más profunda.\n\nInstrucciones de ejecución:\n1. Coloca una barra en V (mango doble-D) en el cable de jalón al pecho.\n2. Siéntate con los muslos asegurados bajo el pad y agarra el mango con las palmas enfrentadas.\n3. Comienza con los brazos completamente extendidos por encima de la cabeza.\n4. Tira del mango hacia el esternón empujando los codos hacia abajo y ligeramente hacia atrás.\n5. Aprieta los dorsales en la posición inferior y sube lentamente de forma controlada.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• El agarre neutro es más suave con los hombros que los agarres en pronación o supinación.\n• Imagina que acercas las costillas hacia las caderas: piensa en los dorsales, no en los brazos.\n\nMúsculos principales: latissimus_dorsi',NULL,'v-bar-lat-pulldown.webp'),
(449,'Extensión de Tríceps en Polea con Barra en V','V-Bar Tricep Pushdown','Una extensión de tríceps en polea con barra en V que fija las muñecas en posición pronada y ligeramente angulada, cargando la cabeza lateral.\n\nInstrucciones de ejecución:\n1. Coloca una barra en V en la polea alta.\n2. Párate frente a la pila y agarra la barra en V con ambas manos, palmas hacia abajo.\n3. Comienza con los codos pegados a los costados y los antebrazos paralelos al suelo.\n4. Empuja el mango hacia abajo hasta que los brazos estén completamente extendidos.\n5. Aprieta los tríceps y vuelve de forma controlada a la posición inicial.\n6. Repite el número de repeticiones recomendado.\n\nConsejos técnicos:\n• Mantén los codos pegados a los costados durante toda la serie.\n• No te apoyes en la barra; una pequeña inclinación hacia adelante está bien, pero deja que los tríceps hagan el trabajo.\n\nMúsculos principales: triceps_brachii',NULL,'v-bar-tricep-pushdown.webp'),
(450,'V-Ups','V Ups','Un ejercicio dinámico de core que eleva las piernas y el torso juntos formando una V, trabajando los abdominales y los flexores de la cadera.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba con los brazos extendidos por encima de la cabeza y las piernas rectas.\n2. Levanta simultáneamente las piernas y la parte superior del cuerpo hacia el centro.\n3. Alcanza las manos hacia los pies en la parte superior, formando una V.\n4. Mantén las piernas rectas durante todo el movimiento.\n5. Baja ambos extremos de forma controlada hasta el suelo.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén las piernas estiradas mientras las elevas.\n• Lleva las manos hacia los pies en la parte alta.\n• Baja ambos extremos con control en lugar de dejarte caer plano.\n\nMúsculos principales: hip_flexors, rectus_abdominis',NULL,'v-ups.webp'),
(451,'Zancada Caminando','Walking Lunge','Una zancada en movimiento que avanza pierna tras pierna, trabajando los cuádriceps y glúteos con un desafío de equilibrio adicional.\n\nInstrucciones de ejecución:\n1. Párate erguido con los pies separados al ancho de las caderas y las manos en las caderas.\n2. Da un paso adelante largo con un pie en zancada.\n3. Baja hasta que ambas rodillas estén en torno a 90 grados.\n4. Empuja con el talón delantero y lleva el pie trasero hacia adelante.\n5. Continúa alternando piernas al avanzar.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Baja hasta que ambas rodillas formen unos 90 grados.\n• Mantén el torso erguido al dar el paso.\n• Impulsa con el talón delantero para avanzar con fluidez.\n\nMúsculos principales: gluteus_maximus, quadriceps',NULL,'walking-lunge.webp'),
(452,'Push-Ups en Pared','Wall Push Ups','Una flexión de pie contra la pared apta para principiantes, que trabaja el pecho con carga reducida.\n\nInstrucciones de ejecución:\n1. Párate frente a una pared y coloca las palmas sobre ella a la altura de los hombros.\n2. Retrocede con los pies hasta que los brazos estén completamente extendidos.\n3. Flexiona los codos para acercar el pecho a la pared.\n4. Mantén el cuerpo en línea recta durante todo el movimiento.\n5. Empuja de vuelta a la posición inicial.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Apoya las palmas a la altura de los hombros.\n• Mantén el cuerpo en línea recta de la cabeza a los pies.\n• Acerca el pecho a la pared flexionando los codos.\n\nMúsculos principales: pectoralis_major',NULL,'wall-push-ups.webp'),
(453,'Fondos Lastrados','Weighted Dips','Un fondo en paralelas con carga añadida — normalmente un disco colgado de un cinturón de lastre entre las piernas — para mantener el ejercicio en un rango de fuerza cuando los fondos con el propio peso ya resultan fáciles.\n\nInstrucciones de ejecución:\n1. Cuelga un disco del cinturón de lastre y ajústalo a la cintura de modo que el peso quede suelto entre las piernas.\n2. Agarra las barras paralelas y súbete hasta la posición inicial con los brazos estirados y los pies separados del suelo.\n3. Inclina ligeramente el torso hacia delante y baja el cuerpo flexionando los codos hasta que los hombros queden por debajo de ellos.\n4. Empuja con las palmas para volver a subir hasta estirar los brazos, evitando que el disco colgante se balancee.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Añade peso solo cuando hagas fondos limpios con el propio peso en todo el recorrido: saltos de 2,5 a 5 kg son suficientes, porque la carga se suma a tu propio peso corporal.\n• Mantén las piernas juntas y el core apretado para que el disco no empiece a balancearse; un peso que oscila estropea la parte baja de la repetición.\n• Mantén los hombros alejados de las orejas y detén el descenso si notas pinzamiento en la parte delantera del hombro.\n\nMúsculos principales: pectoralis_major, triceps_brachii',NULL,'weighted-dips.webp'),
(454,'Dominada Lastrada','Weighted Pull-Up','Una dominada con carga añadida — normalmente un disco colgado de un cinturón de lastre entre las piernas — para mantener el ejercicio en un rango de fuerza cuando las dominadas con el propio peso ya resultan fáciles.\n\nInstrucciones de ejecución:\n1. Cuelga un disco del cinturón de lastre y ajústalo a la cintura de modo que el peso quede suelto entre las piernas; también puedes sujetar la carga entre los pies.\n2. Agarra la barra en pronación algo más abierto que la anchura de los hombros y cuélgate con los brazos estirados y las piernas juntas.\n3. Tira de los codos hacia abajo y hacia atrás llevando el pecho hacia la barra hasta que la barbilla la supere.\n4. Baja de forma controlada hasta la suspensión completa, mantén la tensión en los dorsales y deja que el peso se estabilice antes de la siguiente repetición.\n5. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Añade peso solo cuando hagas dominadas limpias con el propio peso en todo el recorrido: saltos de 2,5 a 5 kg son suficientes, porque la carga se suma a tu propio peso corporal.\n• Mantén las piernas juntas y el core apretado para que el disco colgante no empiece a balancearse; un peso que oscila convierte la repetición en un kipping.\n• No recortes la parte baja: vuelve a la suspensión completa en cada repetición y termina la serie cuando la barbilla deje de superar la barra, en lugar de forzar repeticiones parciales.\n\nMúsculos principales: latissimus_dorsi',NULL,'weighted-pull-up.webp'),
(455,'Crunch en Pared con Peso','Weighted Wall Crunch','Una variante del crunch con las piernas apartadas del movimiento —los pies apoyados contra una pared o un cajón, o simplemente las piernas en alto— para que la cadera no ayude y trabajen los abdominales.\n\nInstrucciones de ejecución:\n1. Túmbate boca arriba y coloca las piernas de modo que la cadera no pueda ayudar: apoya los pies contra una pared o un cajón, o mantén las piernas en alto con las rodillas flexionadas.\n2. Sujeta un peso contra el pecho con ambas manos: un disco, una mancuerna o una pesa rusa sirven igual.\n3. Haz el crunch hacia arriba, despegando los omóplatos del suelo.\n4. Baja de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Apoya los pies en la pared con las rodillas a 90 grados.\n• Sujeta el disco sobre el pecho durante todo el ejercicio.\n• Despega los omóplatos del suelo sin tirar del cuello.\n\nMúsculos principales: rectus_abdominis',NULL,'weighted-wall-crunch.webp'),
(456,'Press de Banca en Agarre Ancho','Wide-Grip Bench Press','Una variante del press de banca con un agarre más ancho que los hombros para maximizar la activación del pectoral.\n\nInstrucciones de ejecución:\n1. Túmbate en un banco plano. Agarra la barra más ancha que los hombros.\n2. Baja la barra hasta la mitad del pecho.\n3. Empuja de vuelta a la extensión completa.\n4. Repite.\n\nConsejos técnicos:\n• Un agarre más ancho reduce la participación de los tríceps.\n• Evita doblar las muñecas en exceso.\n\nMúsculos principales: pectoralis_major',NULL,'wide-grip-bench-press.webp'),
(457,'Dominadas en Agarre Ancho','Wide Grip Pull Ups','Una dominada con agarre prono más ancho que los hombros, que enfatiza el desarrollo de los dorsales.\n\nInstrucciones de ejecución:\n1. Agarra la barra de dominadas con un agarre en pronación más ancho que los hombros.\n2. Cuélgate con los brazos completamente extendidos y el core contraído.\n3. Tira del pecho hacia la barra empujando los codos hacia abajo.\n4. Mantén los hombros hacia atrás al subir.\n5. Baja de forma controlada hasta la extensión completa.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Cuelga con los brazos extendidos y el core firme.\n• Lleva el pecho hacia la barra bajando los codos.\n• Desciende con control hasta la extensión completa.\n\nMúsculos principales: latissimus_dorsi',NULL,'wide-grip-pull-ups.webp'),
(458,'Flexiones con Agarre Ancho','Wide Grip Push Ups','Una variante de flexión con las manos colocadas más separadas para enfatizar el pecho.\n\nInstrucciones de ejecución:\n1. Comienza en una plancha alta con las manos más separadas que el ancho de hombros.\n2. Mantén el cuerpo en línea recta de la cabeza a los talones.\n3. Baja el pecho hacia el suelo flexionando los codos.\n4. Mantén el core activado y los glúteos contraídos.\n5. Empuja de vuelta hasta extender los brazos.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén los codos a unos 45 grados respecto al torso.\n• Mantén una línea recta de la cabeza a los talones.\n• Baja hasta que el pecho quede cerca del suelo.\n\nMúsculos principales: pectoralis_major',NULL,'wide-grip-push-ups.webp'),
(459,'Remo Sentado con Barra Ancha en Polea','Wide Grip Seated Cable Row','Una variante del remo sentado con agarre ancho que hace énfasis en la parte superior de la espalda.\n\nInstrucciones de ejecución:\n1. Siéntate en la estación de remo con los pies en la plataforma.\n2. Agarra la barra ancha con un agarre en pronación.\n3. Tira de la barra hacia el abdomen superior apretando los omóplatos.\n4. Extiende los brazos de vuelta a la posición inicial de forma controlada.\n5. Repite.\n\nConsejos técnicos:\n• Sujeta la barra ancha con agarre prono.\n• Lleva la barra hacia el abdomen alto juntando los omóplatos.\n• Extiende los brazos al frente de forma controlada.\n\nMúsculos principales: latissimus_dorsi, rhomboids',NULL,'02_remo_sentado_barra_ancha.webp'),
(460,'Prensa de piernas con postura amplia','Wide-Stance Leg Press','Una prensa de piernas con una postura amplia y ligeramente abierta, que aumenta la participación de los aductores junto con la extensión de cadera y rodilla.\n\nInstrucciones de ejecución:\n1. Ajusta el asiento y el respaldo para que la zona lumbar permanezca apoyada en la parte baja del recorrido.\n2. Coloca los pies separados en la plataforma y gira las puntas hacia fuera solo hasta donde las rodillas puedan seguirlas.\n3. Baja el carro flexionando caderas y rodillas y mantén las rodillas en la misma dirección que los pies.\n4. Empuja con todo el pie y extiende caderas y rodillas sin forzar el bloqueo.\n5. Baja el carro bajo control y repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Elige una anchura y un ángulo de los pies que puedas controlar desde la cadera; más ancho no siempre es mejor.\n• Mantén las rodillas siguiendo a los pies y evita que se hundan hacia dentro.\n• Detén el descenso antes de que la pelvis se despegue y la espalda pierda contacto con el respaldo.\n\nMúsculos principales: adductors',NULL,'wide-stance-leg-press.webp'),
(461,'Curl de Muñeca con Mancuernas Bilateral','Bilateral Dumbbell Wrist Curl','Un curl de muñeca con mancuernas realizado con ambos brazos a la vez, que aísla los flexores del antebrazo para un entrenamiento eficiente.\n\nInstrucciones de ejecución:\n1. Siéntate en un banco sujetando una mancuerna en cada mano, con los antebrazos apoyados sobre los muslos, palmas hacia arriba.\n2. Deja que ambas mancuernas rueden hacia las puntas de los dedos.\n3. Flexiona las muñecas para levantar ambas mancuernas.\n4. Aprieta arriba y baja con control.\n5. Repite el número deseado de repeticiones.\n\nConsejos técnicos:\n• Mantén los antebrazos apoyados en los muslos durante todo el movimiento — solo se mueven las muñecas.\n• Usa una carga por mano más ligera que en la versión unilateral, ya que ambos lados trabajan a la vez.\n\nMúsculos principales: forearm_flexors',NULL,'wrist-curl.webp'),
(462,'Rodillo de Muñeca','Wrist Roller','Un ejercicio para el antebrazo que consiste en enrollar un peso con la cuerda mediante el giro de las muñecas.\n\nInstrucciones de ejecución:\n1. Agarra el mango del rodillo con los brazos extendidos al frente a la altura de los hombros.\n2. Deja que el peso cuelgue del cordón.\n3. Enrolla el mango hacia adelante con movimientos alternos de muñeca para subir el peso.\n4. Mantén los brazos rectos durante todo el movimiento.\n5. Una vez enrollado por completo, invierte la rotación para bajar el peso.\n6. Repite el número de repeticiones deseado.\n\nConsejos técnicos:\n• Mantén los brazos extendidos al frente a la altura de los hombros.\n• Enrolla la cuerda con giros alternos de las muñecas.\n• Invierte la rotación para bajar el peso de forma controlada.\n\nMúsculos principales: forearm_extensors, forearm_flexors',NULL,'wrist-roller.webp'),
(463,'Curl Zottman','Zottman Curl','Un curl con mancuernas de pie que sube con agarre supinado, gira las palmas hacia abajo en la parte superior y desciende en pronación para combinar el trabajo del bíceps con una fase excéntrica centrada en los antebrazos.\n\nInstrucciones de ejecución:\n1. Colócate de pie con los pies aproximadamente al ancho de las caderas, los brazos extendidos a los lados y una mancuerna en cada mano con las palmas hacia delante.\n2. Mantén los brazos junto a las costillas y lleva ambas mancuernas hacia los hombros sin balancear el torso.\n3. En la parte superior, conserva los codos flexionados y gira los antebrazos hasta que las palmas miren hacia abajo.\n4. Baja lentamente las mancuernas con el agarre pronado hasta extender los brazos.\n5. Vuelve a girar las palmas hacia delante en la parte inferior y repite las repeticiones deseadas.\n\nConsejos técnicos:\n• Usa menos peso que en un curl con mancuernas convencional; la bajada con las palmas hacia abajo suele ser la parte limitante.\n• Gira desde los antebrazos y mantén las muñecas rectas en lugar de doblarlas alrededor de las empuñaduras.\n• Mantén los codos cerca de las costillas y evita convertir el curl en un balanceo de hombros.\n\nMúsculos principales: biceps_brachii',NULL,'zottman-curl.webp'),
(464,'Remo Unilateral Sentado en Polea','Single-Arm Seated Cable Row','Variación unilateral del remo sentado en polea baja con maneral individual. Permite corregir desequilibrios musculares bilaterales y lograr un mayor rango de recorrido y contracción del dorsal ancho y romboides.',NULL,'03_remo_unilateral_sentado.webp'),
(465,'Face Pull Sentado con Cuerda','Seated Cable Rope Face Pull','Variación de face pull ejecutada sentado en máquina de polea baja / remo con agarre de cuerda hacia el rostro. Enfocada en el aislamiento del deltoides posterior, manguito rotador externo y trapecio medio/superior.',NULL,'04_face_pull_sentado_cuerda.webp'),
(466,'Curl de Bíceps Sentado en Polea','Seated Cable Bicep Curl','Curl de bíceps ejecutado sentado en el banco de la polea baja / long pull. Asegura tensión mecánica continua durante todo el rango de flexión del codo, maximizando la activación del bíceps braquial y braquial anterior.',NULL,'05_curl_biceps_sentado_polea.webp'),
(467,'Encogimiento de Hombros Sentado en Polea','Seated Cable Shrug','Encogimiento de hombros para trapecios realizado sentado frente a la polea baja. Elimina la sobrecarga lumbar de las variantes de pie y enfoca la tracción vertical de las escápulas directamente en el trapecio superior.',NULL,'06_encogimiento_hombros_sentado.webp'),
(468,'Pedaleo en Bicicleta Estática (Spinning)','Stationary Bike Cycling','Entrenamiento cardiovascular y de resistencia en bicicleta estática/spinning. Desarrolla potencia en el tren inferior (cuádriceps, glúteos, isquiotibiales y gemelos) con bajo impacto articular.','',''),
(469,'Sprint en Bicicleta de Aire (Air Bike HIIT)','Air Bike HIIT Sprints','Ejercicio metabólico de cuerpo entero en bicicleta de aire. Combina pedaleo potente con empuje y tirón sincronizado de brazos, reclutando piernas, pecho, espalda, hombros, brazos y core.','','');
/*!40000 ALTER TABLE `ejercicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ejerciciocliente`
--

DROP TABLE IF EXISTS `ejerciciocliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ejerciciocliente` (
  `idejerciciocliente` int(11) NOT NULL AUTO_INCREMENT,
  `idejercicio` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `duracionminutos` int(11) NOT NULL,
  PRIMARY KEY (`idejerciciocliente`),
  KEY `idx_ejerciciocliente_ejercicio` (`idejercicio`),
  KEY `idx_ejerciciocliente_cliente` (`idcliente`),
  KEY `idx_ejerciciocliente_fecha` (`fecha`),
  CONSTRAINT `fk_ejerciciocliente_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ejerciciocliente_ejercicio` FOREIGN KEY (`idejercicio`) REFERENCES `ejercicio` (`idejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ejerciciocliente`
--

LOCK TABLES `ejerciciocliente` WRITE;
/*!40000 ALTER TABLE `ejerciciocliente` DISABLE KEYS */;
INSERT INTO `ejerciciocliente` VALUES
(1,1,1,'2026-10-01',25),
(2,2,1,'2026-10-01',20),
(3,4,2,'2026-10-02',15),
(4,3,2,'2026-10-03',30),
(5,5,1,'2026-10-05',20),
(7,635,6,'2026-10-06',20),
(8,1,1,'2026-10-10',15),
(9,9,6,'2026-10-12',3);
/*!40000 ALTER TABLE `ejerciciocliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ejercicioequipo`
--

DROP TABLE IF EXISTS `ejercicioequipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ejercicioequipo` (
  `idejercicioequipo` int(11) NOT NULL AUTO_INCREMENT,
  `idejercicio` int(11) NOT NULL,
  `idequipo` int(11) NOT NULL,
  PRIMARY KEY (`idejercicioequipo`),
  UNIQUE KEY `uk_ejercicio_equipo` (`idejercicio`,`idequipo`),
  KEY `fk_ee_ejercicio` (`idejercicio`),
  KEY `fk_ee_equipo` (`idequipo`),
  CONSTRAINT `fk_ee_ejercicio` FOREIGN KEY (`idejercicio`) REFERENCES `ejercicio` (`idejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ee_equipo` FOREIGN KEY (`idequipo`) REFERENCES `equipo` (`idequipo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=385 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ejercicioequipo`
--

LOCK TABLES `ejercicioequipo` WRITE;
/*!40000 ALTER TABLE `ejercicioequipo` DISABLE KEYS */;
INSERT INTO `ejercicioequipo` VALUES
(1,1,17),
(2,1,24),
(4,2,11),
(3,2,17),
(5,2,24),
(6,3,17),
(7,3,24),
(8,4,14),
(9,5,17),
(10,6,59),
(11,7,14),
(12,9,29),
(13,10,45),
(14,11,36),
(15,13,55),
(16,14,55),
(17,15,13),
(18,16,13),
(19,17,12),
(20,18,12),
(21,19,12),
(22,20,12),
(23,21,12),
(24,22,12),
(25,23,12),
(26,24,12),
(27,25,12),
(28,26,12),
(29,27,12),
(30,28,12),
(31,29,12),
(32,30,12),
(33,31,12),
(34,32,17),
(35,33,17),
(36,34,17),
(37,35,17),
(38,36,17),
(39,37,17),
(40,38,17),
(41,39,17),
(42,40,17),
(43,41,17),
(44,42,17),
(45,43,17),
(46,44,20),
(47,46,17),
(48,47,50),
(49,48,17),
(50,49,14),
(51,52,17),
(52,53,17),
(53,54,16),
(54,55,29),
(55,56,16),
(56,57,29),
(57,66,19),
(58,68,29),
(59,69,57),
(60,70,57),
(61,71,57),
(62,72,57),
(63,73,57),
(64,74,57),
(65,75,57),
(66,76,57),
(67,77,57),
(68,78,57),
(69,79,57),
(70,80,57),
(71,81,57),
(72,82,57),
(73,86,17),
(74,87,52),
(75,88,29),
(76,89,29),
(77,90,56),
(78,91,53),
(79,92,14),
(80,95,17),
(81,96,17),
(82,97,17),
(83,98,17),
(84,99,29),
(85,100,16),
(86,101,16),
(87,102,17),
(88,103,57),
(89,104,14),
(90,106,3),
(91,108,29),
(92,112,29),
(93,114,29),
(94,115,29),
(95,116,29),
(96,117,29),
(97,118,29),
(98,119,29),
(99,120,29),
(100,121,29),
(101,122,29),
(102,123,29),
(103,124,29),
(104,125,29),
(105,126,29),
(106,128,17),
(107,129,16),
(108,130,29),
(109,132,29),
(110,134,17),
(111,137,26),
(112,139,29),
(113,140,56),
(114,141,56),
(115,142,56),
(116,143,56),
(117,144,56),
(118,145,56),
(119,146,56),
(120,147,56),
(121,148,56),
(122,149,56),
(123,150,56),
(124,151,56),
(125,158,17),
(126,160,29),
(127,161,29),
(128,162,29),
(129,163,29),
(130,164,29),
(131,165,29),
(132,166,29),
(133,167,29),
(134,168,29),
(135,169,29),
(136,170,29),
(137,171,29),
(138,172,29),
(139,173,29),
(140,174,29),
(141,175,29),
(142,176,29),
(143,177,29),
(144,178,29),
(145,179,29),
(146,180,16),
(147,181,16),
(148,182,16),
(149,183,16),
(150,184,16),
(151,185,16),
(152,186,16),
(153,187,16),
(154,188,16),
(155,189,16),
(156,190,16),
(157,191,16),
(158,192,57),
(159,193,16),
(160,194,56),
(161,195,17),
(162,197,17),
(163,200,56),
(164,201,17),
(165,202,48),
(166,203,48),
(167,205,29),
(168,207,17),
(169,208,17),
(170,209,14),
(171,210,14),
(172,211,14),
(173,212,17),
(174,213,15),
(175,214,3),
(176,215,33),
(177,216,34),
(178,217,17),
(179,218,3),
(180,219,16),
(181,220,17),
(182,221,29),
(183,222,29),
(184,223,29),
(185,224,29),
(186,226,17),
(187,228,29),
(188,231,56),
(189,232,56),
(190,233,56),
(191,234,56),
(192,235,56),
(193,236,56),
(194,237,56),
(195,238,56),
(196,239,56),
(197,240,56),
(198,241,56),
(199,242,56),
(200,243,56),
(201,244,56),
(202,245,56),
(203,246,56),
(204,247,56),
(205,248,56),
(206,249,56),
(207,250,56),
(208,251,56),
(209,252,56),
(210,253,56),
(211,254,56),
(212,255,56),
(213,256,56),
(214,257,56),
(215,258,56),
(216,259,56),
(217,260,56),
(218,261,56),
(219,263,57),
(220,264,17),
(221,265,57),
(222,266,29),
(223,267,23),
(224,268,27),
(225,269,3),
(226,273,29),
(227,274,43),
(228,275,31),
(229,276,38),
(230,277,35),
(231,278,32),
(232,279,30),
(233,280,51),
(234,281,44),
(235,282,7),
(236,284,17),
(237,285,14),
(238,286,14),
(239,287,14),
(240,288,9),
(241,289,17),
(242,290,29),
(243,291,29),
(244,292,56),
(245,293,56),
(246,294,56),
(247,295,56),
(248,296,56),
(249,297,56),
(250,298,56),
(251,299,56),
(252,300,56),
(253,301,56),
(254,302,17),
(255,303,57),
(256,304,29),
(257,305,56),
(258,306,17),
(259,307,29),
(260,308,14),
(261,309,17),
(262,310,17),
(263,311,17),
(264,312,54),
(265,313,17),
(266,325,37),
(267,326,49),
(268,327,40),
(269,328,42),
(270,329,24),
(271,330,24),
(272,332,16),
(273,333,29),
(274,335,17),
(275,336,17),
(276,338,17),
(277,339,29),
(278,341,17),
(279,342,17),
(280,343,57),
(281,344,29),
(282,348,5),
(283,349,5),
(284,350,5),
(285,351,5),
(286,352,5),
(287,353,5),
(288,354,17),
(289,355,46),
(290,358,14),
(291,360,57),
(377,360,62),
(292,361,39),
(293,362,29),
(294,363,29),
(295,364,29),
(296,365,29),
(297,366,23),
(298,367,53),
(299,368,17),
(300,372,29),
(301,374,29),
(302,375,29),
(303,376,29),
(304,377,29),
(305,378,51),
(306,379,40),
(307,380,57),
(308,381,29),
(309,383,27),
(310,385,23),
(311,386,3),
(312,387,29),
(313,389,17),
(314,390,61),
(315,391,53),
(316,392,53),
(317,393,53),
(318,394,53),
(319,395,53),
(320,396,53),
(321,397,53),
(322,398,53),
(323,399,53),
(324,400,53),
(325,401,53),
(326,402,53),
(327,403,53),
(328,404,53),
(329,405,53),
(330,406,53),
(331,407,53),
(332,408,17),
(333,409,29),
(334,410,17),
(335,412,17),
(336,413,55),
(337,414,55),
(338,415,55),
(339,416,55),
(340,417,55),
(341,421,17),
(342,422,57),
(343,423,57),
(344,424,14),
(345,425,29),
(346,426,17),
(347,427,17),
(348,430,24),
(349,431,17),
(350,433,17),
(351,434,14),
(352,435,29),
(353,436,57),
(354,437,60),
(355,438,60),
(356,439,60),
(357,440,60),
(358,441,60),
(359,442,60),
(360,443,60),
(361,444,60),
(362,445,60),
(363,446,60),
(364,447,17),
(365,448,50),
(366,449,57),
(367,453,26),
(368,454,14),
(369,455,24),
(370,456,17),
(371,457,14),
(372,459,57),
(378,459,62),
(373,460,3),
(374,461,29),
(375,462,58),
(376,463,29),
(379,464,62),
(380,465,62),
(381,466,62),
(382,467,62),
(383,468,2),
(384,469,18);
/*!40000 ALTER TABLE `ejercicioequipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipo`
--

DROP TABLE IF EXISTS `equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipo` (
  `idequipo` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(30) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `video` varchar(300) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `modelo` varchar(80) DEFAULT NULL,
  `numero_serie` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `id_ubicacion` int(11) DEFAULT NULL,
  `fecha_adquisicion` date DEFAULT NULL,
  `valor_adquisicion` decimal(10,2) DEFAULT NULL,
  `id_estado` int(11) DEFAULT 1,
  `iddisponibilidadequipo` int(11) DEFAULT 1,
  `activo` tinyint(1) DEFAULT 1,
  `observaciones` text DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idequipo`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `fk_equipo_disponibilidad` (`iddisponibilidadequipo`),
  CONSTRAINT `fk_equipo_disponibilidad` FOREIGN KEY (`iddisponibilidadequipo`) REFERENCES `disponibilidadequipo` (`iddisponibilidadequipo`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipo`
--

LOCK TABLES `equipo` WRITE;
/*!40000 ALTER TABLE `equipo` DISABLE KEYS */;
INSERT INTO `equipo` VALUES
(1,'EQ-001','Caminadora Profesional ProRun','cinta-de-correr.webp',NULL,1,1,'ProRun T900','SN-CAM-2023-001','Caminadora de alta resistencia con pantalla LED',1,'2023-01-15',2450.00,1,1,1,'Mantenimiento preventivo cada 3 meses','2026-10-05 19:33:34'),
(2,'EQ-002','Bicicleta Estática Spinning Pro','bicicleta-estatica.webp','https://www.youtube.com/watch?v=kYJv8y6_D60',1,2,'SpinMaster 500','SN-SPIN-2023-014','Bicicleta con volante de inercia de 22kg',1,'2023-02-20',890.00,1,1,1,'Correa en excelente estado','2026-10-05 19:33:34'),
(3,'EQ-003','Prensa de Piernas 45 Grados','prensa-piernas.webp','https://www.youtube.com/watch?v=IZxyjW7MPJQ',2,3,'Plate Loaded 45','SN-LEG-2023-088','Prensa inclinada a 45 grados con rieles lineales',2,'2023-03-15',2100.00,1,1,1,NULL,'2026-10-05 19:33:34'),
(5,'EQ-004','Anillas de Gimnasia','anillas.webp',NULL,4,1,'Gim360 Pro',NULL,'Anillas olímpicas de madera con correas de sujeción reforzadas para calistenia y gimnasia',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(6,'EQ-005','Balón Medicinal','balon-medicinal.webp',NULL,4,1,'Gim360 Pro',NULL,'Balón medicinal con peso para ejercicios pliométricos y acondicionamiento',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(7,'EQ-006','Balón Slam','balon-slam.webp',NULL,4,1,'Gim360 Pro',NULL,'Balón de impacto sin rebote para lanzamientos de potencia y resistencia',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(8,'EQ-007','Banco Declinado','banco-declinado.webp',NULL,3,1,'Gim360 Pro',NULL,'Banco declinado para press de pecho declinado y trabajo de abdominales',5,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(9,'EQ-008','Banco GHD (Glute Ham Developer)','banco-ghd.webp',NULL,2,1,'Gim360 Pro',NULL,'Banco especializado para hipertrofia y fortalecimiento de glúteos e isquiotibiales',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(10,'EQ-009','Banco Inclinado','banco-inclinado.webp',NULL,3,1,'Gim360 Pro',NULL,'Banco multiposición inclinado para press de pecho superior y hombros',5,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(11,'EQ-010','Banco Plano Olímpico','banco-plano.webp',NULL,3,1,'Gim360 Pro',NULL,'Banco horizontal plano para levantamiento de potencia y press de banca',5,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(12,'EQ-011','Banda de Resistencia Circular (Loop Band)','banda-de-resistencia-circular.webp',NULL,5,1,'Gim360 Pro',NULL,'Banda de látex cerrada para activación de glúteos y calentamiento',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(13,'EQ-012','Banda Elástica de Resistencia','banda-elastica.webp',NULL,5,1,'Gim360 Pro',NULL,'Banda elástica con diferentes niveles de resistencia para movilidad y fuerza',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(14,'EQ-013','Barra de Dominadas','barra-de-dominadas.webp',NULL,4,1,'Gim360 Pro',NULL,'Estructura metálica para dominadas, agarres pronos, supinos y neutros',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(15,'EQ-014','Barra Hexagonal (Trap Bar)','barra-hexagonal.webp',NULL,3,1,'Gim360 Pro',NULL,'Barra con marco hexagonal para peso muerto neutral y encogimientos',5,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(16,'EQ-015','Barra Z (EZ Bar)','barra-z.webp',NULL,3,1,'Gim360 Pro',NULL,'Barra curva ergonómica diseñada para reducir tensión en muñecas durante curls y extensiones',5,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(17,'EQ-016','Barra Olímpica Estándar (20 kg)','barra.webp',NULL,3,1,'Gim360 Pro',NULL,'Barra olímpica de acero con rodamientos y moleteado de competición',5,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(18,'EQ-017','Bicicleta de Aire (Air Bike)','bicicleta-de-aire.webp','https://www.youtube.com/watch?v=Fq2r7j2L2K4',1,1,'Gim360 Pro',NULL,'Bicicleta con resistencia de aire y ventilador para entrenamientos HIIT de máxima intensidad',1,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(19,'EQ-018','Caja Pliométrica (Plyo Box)','caja-pliometrica.webp',NULL,4,1,'Gim360 Pro',NULL,'Cajón de salto multifuncional con 3 alturas ajustables para potencia de salto',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(20,'EQ-019','Cuerda de Batalla (Battle Rope)','cuerda-de-batalla.webp',NULL,4,1,'Gim360 Pro',NULL,'Cuerda gruesa de polidacrón para acondicionamiento metabólico y core',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(21,'EQ-020','Cuerda de Escalada','cuerda-de-escalada.webp',NULL,4,1,'Gim360 Pro',NULL,'Cuerda de cáñamo reforzada suspendida para trepa y fuerza de tracción',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(22,'EQ-021','Cuerda de Saltar de Velocidad','cuerda-de-saltar.webp',NULL,1,1,'Gim360 Pro',NULL,'Cuerda de saltar con cable de acero y rodamientos de alta velocidad',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(23,'EQ-022','Máquina de Curl Femoral Tumbado','curl-femoral.webp',NULL,2,1,'Gim360 Pro',NULL,'Aparato selectorizado de placas para aislamiento del bíceps femoral',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(24,'EQ-023','Discos Olímpicos de Peso (Bumper Plates)','discos.webp',NULL,3,1,'Gim360 Pro',NULL,'Set de discos de goma maciza de alta densidad para barras olímpicas',5,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(25,'EQ-024','Máquina Elíptica Profesional','eliptica.webp',NULL,1,1,'Gim360 Pro',NULL,'Entrenador elíptico de bajo impacto articular con monitor de frecuencia cardíaca',1,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(26,'EQ-025','Estación de Fondos y Paralelas','estacion-de-fondos.webp',NULL,2,1,'Gim360 Pro',NULL,'Barras paralelas fijas para inmersiones de tríceps y pecho',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(27,'EQ-026','Máquina de Extensión de Piernas (Leg Extension)','extension-de-piernas.webp',NULL,2,1,'Gim360 Pro',NULL,'Máquina selectorizada para desarrollo y aislamiento de cuádriceps',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(28,'EQ-027','Soporte Landmine para Barra','landmine.webp',NULL,3,1,'Gim360 Pro',NULL,'Articulación multidireccional fijada al suelo para barra olímpica',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(29,'EQ-028','Mancuernas de Uretano / Goma','mancuerna.webp',NULL,3,1,'Gim360 Pro',NULL,'Juego de mancuernas fijas de diferentes pesos para levantamiento libre',5,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(30,'EQ-029','Máquina de Crunch Abdominal','maquina-crunch-abdominal.webp',NULL,2,1,'Gim360 Pro',NULL,'Máquina selectorizada de placas para sobrecarga progresiva en flexión de tronco',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(31,'EQ-030','Máquina de Curl de Bíceps','maquina-curl-de-biceps.webp',NULL,2,1,'Gim360 Pro',NULL,'Máquina de placas para aislamiento concéntrico y excéntrico de bíceps',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(32,'EQ-031','Máquina de Curl Predicador','maquina-curl-predicador.webp',NULL,2,1,'Gim360 Pro',NULL,'Banco Scott integrado con palancas selectorizadas para brazo',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(33,'EQ-032','Máquina de Abducción de Cadera','maquina-de-abduccion-de-cadera.webp',NULL,2,1,'Gim360 Pro',NULL,'Máquina para fortalecimiento de glúteo medio y cadera hacia afuera',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(34,'EQ-033','Máquina de Aducción de Cadera','maquina-de-aduccion-de-cadera.webp',NULL,2,1,'Gim360 Pro',NULL,'Máquina para trabajo de aductores de muslo hacia adentro',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(35,'EQ-034','Máquina de Aperturas de Pecho (Chest Fly)','maquina-de-aperturas-de-pecho.webp',NULL,2,1,'Gim360 Pro',NULL,'Aparato de brazos articulados para aducción horizontal de hombro',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(36,'EQ-035','Máquina de Dominadas y Fondos Asistidos','maquina-de-dominadas-asistidas.webp',NULL,2,1,'Gim360 Pro',NULL,'Torre con plataforma contrapesada para facilitar dominadas y fondos',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(37,'EQ-036','Máquina de Gemelos a la Burra (Donkey Calf)','maquina-de-elevaciones-de-pantorrilla-a-la-burra.webp',NULL,2,1,'Gim360 Pro',NULL,'Aparato para flexión plantar de tobillo con tronco flexionado a 90 grados',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(38,'EQ-037','Máquina de Gemelos de Pie (Standing Calf)','maquina-de-elevaciones-de-pantorrilla-de-pie.webp',NULL,2,1,'Gim360 Pro',NULL,'Máquina con almohadillas en hombros para hipertrofia del gastrocnemio',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(39,'EQ-038','Máquina de Gemelos Sentado (Seated Calf)','maquina-de-elevaciones-de-pantorrilla-sentado.webp',NULL,2,1,'Gim360 Pro',NULL,'Aparato con rodillera acolchada para trabajo selectivo del músculo sóleo',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(40,'EQ-039','Máquina de Elevaciones Laterales a Discos','maquina-de-elevaciones-laterales-de-discos.webp',NULL,2,1,'Gim360 Pro',NULL,'Máquina de palanca de carga directa de discos para deltoides lateral',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(41,'EQ-040','Máquina de Elevaciones Laterales (Selectorizada)','maquina-de-elevaciones-laterales.webp',NULL,2,1,'Gim360 Pro',NULL,'Aparato de placas guiado para aislamiento del hombro medio',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(42,'EQ-041','Máquina de Encogimientos de Hombros','maquina-de-encogimientos.webp',NULL,2,1,'Gim360 Pro',NULL,'Palancas de agarre neutro para trapecio superior',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(43,'EQ-042','Máquina de Extensión de Espalda / Lumbares','maquina-de-extension-de-espalda.webp',NULL,2,1,'Gim360 Pro',NULL,'Aparato de placas para fortalecimiento de erectores espinales',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(44,'EQ-043','Máquina de Extensión de Tríceps','maquina-de-extension-de-triceps.webp',NULL,2,1,'Gim360 Pro',NULL,'Máquina sentada con soporte de codos para empuje vertical de tríceps',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(45,'EQ-044','Máquina de Fondos Asistida / Selectorizada','maquina-de-fondos.webp',NULL,2,1,'Gim360 Pro',NULL,'Aparato con palancas para press hacia abajo de tríceps y pectoral inferior',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(46,'EQ-045','Máquina de Remo Ergométrico (Rower)','maquina-de-remo.webp',NULL,1,1,'Gim360 Pro',NULL,'Remo de aire y resistencia magnética para cardio total y espalda',1,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(47,'EQ-046','Máquina Escaladora (StairMaster)','maquina-escaladora.webp',NULL,1,1,'Gim360 Pro',NULL,'Escalera sin fin motorizada para entrenamiento cardiovascular y tren inferior',1,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(48,'EQ-047','Máquina Hack Squat (Sentadilla Hack)','maquina-hack-squat.webp',NULL,2,1,'Gim360 Pro',NULL,'Trineo inclinado con respaldo fijo para sobrecarga en cuádriceps',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(49,'EQ-048','Máquina de Hip Thrust (Empuje de Cadera)','maquina-hip-thrust.webp',NULL,2,1,'Gim360 Pro',NULL,'Aparato especializado con cinturón acolchado para extensión de cadera',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(50,'EQ-049','Máquina de Jalón al Pecho (Lat Pulldown)','maquina-jalon-al-pecho.webp',NULL,2,1,'Gim360 Pro',NULL,'Torre de polea alta con barra para dorsales y bíceps',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(51,'EQ-050','Máquina de Press Militar / Hombros','maquina-press-de-hombros.webp',NULL,2,1,'Gim360 Pro',NULL,'Aparato convergente para empuje vertical seguro de hombros',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(52,'EQ-051','Máquina de Press de Pecho (Chest Press)','maquina-press-de-pecho.webp',NULL,2,1,'Gim360 Pro',NULL,'Máquina con agarres múltiples para empuje horizontal de pectoral',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(53,'EQ-052','Máquina Smith (Multipower)','maquina-smith.webp',NULL,2,1,'Gim360 Pro',NULL,'Estructura con barra olímpica guiada por rieles y ganchos de seguridad',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(54,'EQ-053','Máquina Pec Deck / Contractora de Pectoral','pec-deck.webp',NULL,2,1,'Gim360 Pro',NULL,'Máquina clásica de almohadillas en codos para aperturas pectorales',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(55,'EQ-054','Pelota Suiza / Fitball','pelota-de-estabilidad.webp',NULL,5,1,'Gim360 Pro',NULL,'Balón inflable de PVC anti-explosión para estabilidad, core y rehabilitación',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(56,'EQ-055','Pesa Rusa de Competición (Kettlebell)','pesa-rusa.webp',NULL,3,1,'Gim360 Pro',NULL,'Pesa de hierro fundido con asa superior para swings, snatches y cleans',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(57,'EQ-056','Torre de Polea Cruzada (Cable Crossover)','polea.webp',NULL,2,1,'Gim360 Pro',NULL,'Estación doble de poleas regulables en altura para cruces y jalones',2,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(58,'EQ-057','Rodillo de Muñeca (Wrist Roller)','rodillo-de-muneca.webp',NULL,5,1,'Gim360 Pro',NULL,'Dispositivo cilíndrico con cuerda y soporte de discos para flexo-extensión de antebrazo',5,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(59,'EQ-058','Rueda Abdominal (Ab Wheel)','rueda-abdominal.webp',NULL,4,1,'Gim360 Pro',NULL,'Rodillo de doble rueda con manillares ergonómicos para despliegues de core',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(60,'EQ-059','Sistema de Suspensión (TRX)','suspension-trx.webp',NULL,4,1,'Gim360 Pro',NULL,'Arnés de correas ajustables ancladas para entrenamiento en suspensión con peso corporal',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(61,'EQ-060','Trineo de Empuje y Arrastre (Sled)','trineo.webp',NULL,4,1,'Gim360 Pro',NULL,'Trineo metálico de alta fricción para empuje y tracción sobre césped sintético',4,NULL,650.00,1,1,1,NULL,'2026-10-09 11:27:02'),
(62,'EQ-061','Máquina de Remo Sentado (Long Pull)','long_pull_seated_row_machine.jpg','https://www.youtube.com/watch?v=GZbfZ033f74',2,1,NULL,NULL,'Remo Sentado Long Pull para espalda',2,NULL,NULL,1,1,1,NULL,'2026-10-20 22:09:49');
/*!40000 ALTER TABLE `equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipomusculo`
--

DROP TABLE IF EXISTS `equipomusculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipomusculo` (
  `idequipomusculo` int(11) NOT NULL AUTO_INCREMENT,
  `idequipo` int(11) NOT NULL,
  `idmusculo` int(11) NOT NULL,
  PRIMARY KEY (`idequipomusculo`),
  UNIQUE KEY `uk_equipo_musculo` (`idequipo`,`idmusculo`),
  KEY `fk_em_equipo` (`idequipo`),
  KEY `fk_em_musculo` (`idmusculo`),
  CONSTRAINT `fk_em_equipo` FOREIGN KEY (`idequipo`) REFERENCES `equipo` (`idequipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_em_musculo` FOREIGN KEY (`idmusculo`) REFERENCES `musculo` (`idmusculo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=534 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipomusculo`
--

LOCK TABLES `equipomusculo` WRITE;
/*!40000 ALTER TABLE `equipomusculo` DISABLE KEYS */;
INSERT INTO `equipomusculo` VALUES
(513,2,6),
(518,2,13),
(516,2,15),
(515,2,16),
(514,2,18),
(519,2,21),
(517,2,24),
(1,3,2),
(2,3,6),
(3,3,16),
(4,3,18),
(5,5,3),
(6,5,7),
(7,5,9),
(8,5,10),
(9,5,14),
(10,5,20),
(11,5,21),
(12,5,22),
(13,5,23),
(14,5,26),
(15,5,27),
(16,7,10),
(17,7,16),
(18,7,19),
(19,7,21),
(20,9,15),
(21,9,16),
(22,9,18),
(23,11,7),
(24,11,20),
(25,11,27),
(26,12,2),
(27,12,6),
(28,12,11),
(29,12,15),
(30,12,16),
(31,12,17),
(32,12,18),
(33,13,3),
(34,13,9),
(35,13,10),
(36,13,14),
(37,13,22),
(38,13,26),
(39,14,3),
(40,14,4),
(41,14,7),
(42,14,9),
(43,14,10),
(44,14,13),
(45,14,14),
(46,14,19),
(47,14,20),
(48,14,21),
(49,14,22),
(50,14,26),
(51,14,27),
(52,15,6),
(53,15,11),
(54,15,14),
(55,15,16),
(56,15,18),
(57,15,26),
(58,16,3),
(59,16,4),
(60,16,5),
(61,16,7),
(62,16,8),
(63,16,9),
(64,16,10),
(65,16,12),
(66,16,14),
(67,16,20),
(68,16,22),
(69,16,23),
(70,16,26),
(71,16,27),
(72,17,2),
(73,17,3),
(74,17,4),
(75,17,5),
(76,17,6),
(77,17,7),
(78,17,8),
(79,17,9),
(80,17,10),
(81,17,11),
(82,17,12),
(83,17,14),
(84,17,15),
(85,17,16),
(86,17,17),
(87,17,18),
(88,17,19),
(89,17,20),
(90,17,21),
(91,17,22),
(92,17,23),
(93,17,24),
(94,17,25),
(95,17,26),
(96,17,27),
(530,18,3),
(520,18,6),
(526,18,7),
(529,18,10),
(525,18,13),
(523,18,15),
(522,18,16),
(521,18,18),
(533,18,19),
(527,18,20),
(532,18,21),
(531,18,22),
(524,18,24),
(528,18,27),
(97,19,6),
(98,19,15),
(99,19,16),
(100,19,18),
(101,19,24),
(102,20,6),
(103,20,7),
(104,20,10),
(105,20,14),
(106,20,16),
(107,20,19),
(108,20,21),
(109,20,26),
(110,23,15),
(111,23,18),
(112,24,6),
(113,24,7),
(114,24,10),
(115,24,11),
(116,24,14),
(117,24,16),
(118,24,18),
(119,24,19),
(120,24,20),
(121,24,21),
(122,24,23),
(123,24,26),
(124,24,27),
(125,26,7),
(126,26,20),
(127,26,27),
(128,27,6),
(129,29,2),
(130,29,3),
(131,29,4),
(132,29,5),
(133,29,6),
(134,29,7),
(135,29,8),
(136,29,9),
(137,29,10),
(138,29,11),
(139,29,12),
(140,29,14),
(141,29,15),
(142,29,16),
(143,29,17),
(144,29,18),
(145,29,19),
(146,29,20),
(147,29,21),
(148,29,22),
(149,29,23),
(150,29,24),
(151,29,25),
(152,29,26),
(153,29,27),
(154,30,19),
(155,30,21),
(156,30,25),
(157,31,3),
(158,31,4),
(159,32,3),
(160,32,4),
(161,33,1),
(162,33,17),
(163,34,2),
(164,35,7),
(165,35,20),
(166,35,23),
(167,36,3),
(168,36,9),
(169,36,10),
(170,36,14),
(171,36,22),
(172,37,15),
(173,37,24),
(174,38,15),
(175,38,24),
(176,39,15),
(177,39,24),
(178,40,7),
(179,40,8),
(180,40,26),
(181,42,14),
(182,42,26),
(183,43,11),
(184,43,16),
(185,43,18),
(186,44,27),
(187,45,7),
(188,45,20),
(189,45,22),
(190,45,27),
(191,46,3),
(192,46,6),
(193,46,10),
(194,46,11),
(195,46,16),
(196,46,18),
(197,46,22),
(198,46,26),
(199,48,6),
(200,48,15),
(201,48,16),
(202,48,18),
(203,48,24),
(204,49,6),
(205,49,16),
(206,49,17),
(207,49,18),
(208,50,3),
(209,50,9),
(210,50,10),
(211,50,22),
(212,50,26),
(213,51,7),
(214,51,8),
(215,51,26),
(216,51,27),
(217,52,7),
(218,52,20),
(219,52,27),
(220,53,3),
(221,53,6),
(222,53,7),
(223,53,8),
(224,53,9),
(225,53,10),
(226,53,11),
(227,53,14),
(228,53,15),
(229,53,16),
(230,53,17),
(231,53,18),
(232,53,20),
(233,53,22),
(234,53,24),
(235,53,26),
(236,53,27),
(237,54,7),
(238,54,20),
(239,54,23),
(240,55,6),
(241,55,7),
(242,55,13),
(243,55,15),
(244,55,16),
(245,55,18),
(246,55,19),
(247,55,20),
(248,55,21),
(249,55,23),
(250,55,27),
(251,56,2),
(252,56,3),
(253,56,4),
(254,56,5),
(255,56,6),
(256,56,7),
(257,56,8),
(258,56,9),
(259,56,10),
(260,56,11),
(261,56,12),
(262,56,13),
(263,56,14),
(264,56,16),
(265,56,17),
(266,56,18),
(267,56,19),
(268,56,20),
(269,56,21),
(270,56,22),
(271,56,23),
(272,56,26),
(273,56,27),
(274,57,3),
(275,57,4),
(276,57,5),
(277,57,7),
(278,57,8),
(279,57,9),
(280,57,10),
(281,57,11),
(282,57,12),
(283,57,14),
(284,57,16),
(285,57,17),
(286,57,18),
(287,57,19),
(288,57,20),
(289,57,21),
(290,57,22),
(291,57,23),
(292,57,25),
(293,57,26),
(294,57,27),
(295,58,7),
(296,58,12),
(297,58,14),
(298,59,7),
(299,59,10),
(300,59,19),
(301,59,21),
(302,59,23),
(303,59,25),
(304,60,3),
(305,60,4),
(306,60,5),
(307,60,6),
(308,60,7),
(309,60,8),
(310,60,9),
(311,60,10),
(312,60,15),
(313,60,16),
(314,60,17),
(315,60,18),
(316,60,20),
(317,60,21),
(318,60,22),
(319,60,26),
(320,60,27),
(321,61,3),
(322,61,9),
(323,61,10),
(324,61,16),
(325,61,22),
(326,61,26),
(327,62,3),
(328,62,4),
(329,62,5),
(330,62,8),
(331,62,9),
(332,62,10),
(333,62,11),
(334,62,22),
(335,62,26);
/*!40000 ALTER TABLE `equipomusculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!50001 DROP VIEW IF EXISTS `equipos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `equipos` AS SELECT
 NULL AS `id_equipo`,
 NULL AS `idequipo`,
 NULL AS `codigo`,
 NULL AS `nombre`,
 NULL AS `imagen`,
 NULL AS `video`,
 NULL AS `id_tipo`,
 NULL AS `id_marca`,
 NULL AS `modelo`,
 NULL AS `numero_serie`,
 NULL AS `descripcion`,
 NULL AS `id_ubicacion`,
 NULL AS `fecha_adquisicion`,
 NULL AS `valor_adquisicion`,
 NULL AS `id_estado`,
 NULL AS `iddisponibilidadequipo`,
 NULL AS `activo`,
 NULL AS `observaciones`,
 NULL AS `fecha_registro` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `estadocivil`
--

DROP TABLE IF EXISTS `estadocivil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `estadocivil` (
  `idestadocivil` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idestadocivil`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadocivil`
--

LOCK TABLES `estadocivil` WRITE;
/*!40000 ALTER TABLE `estadocivil` DISABLE KEYS */;
INSERT INTO `estadocivil` VALUES
(1,'Soltero/a'),
(2,'Casado/a'),
(3,'Divorciado/a'),
(4,'Viudo/a'),
(5,'Unión de Hecho');
/*!40000 ALTER TABLE `estadocivil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estadocivilpersona`
--

DROP TABLE IF EXISTS `estadocivilpersona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `estadocivilpersona` (
  `idestadocivilpersona` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  `idestadocivil` int(11) NOT NULL,
  PRIMARY KEY (`idestadocivilpersona`),
  KEY `fk_ecp_persona` (`idpersona`),
  KEY `fk_ecp_estadocivil` (`idestadocivil`),
  CONSTRAINT `fk_ecp_estadocivil` FOREIGN KEY (`idestadocivil`) REFERENCES `estadocivil` (`idestadocivil`) ON UPDATE CASCADE,
  CONSTRAINT `fk_ecp_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadocivilpersona`
--

LOCK TABLES `estadocivilpersona` WRITE;
/*!40000 ALTER TABLE `estadocivilpersona` DISABLE KEYS */;
INSERT INTO `estadocivilpersona` VALUES
(1,1,1),
(2,2,2),
(3,3,1),
(6,7,2);
/*!40000 ALTER TABLE `estadocivilpersona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estadoprogramacliente`
--

DROP TABLE IF EXISTS `estadoprogramacliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `estadoprogramacliente` (
  `idestadoprogramacliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idestadoprogramacliente`),
  UNIQUE KEY `uk_epc_nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadoprogramacliente`
--

LOCK TABLES `estadoprogramacliente` WRITE;
/*!40000 ALTER TABLE `estadoprogramacliente` DISABLE KEYS */;
INSERT INTO `estadoprogramacliente` VALUES
(1,'Activo'),
(5,'Cancelado'),
(3,'Completado'),
(2,'En Espera'),
(4,'Pausado');
/*!40000 ALTER TABLE `estadoprogramacliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genero`
--

DROP TABLE IF EXISTS `genero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `genero` (
  `idgenero` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idgenero`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genero`
--

LOCK TABLES `genero` WRITE;
/*!40000 ALTER TABLE `genero` DISABLE KEYS */;
INSERT INTO `genero` VALUES
(1,'Cisgénero Masculino'),
(2,'Cisgénero Femenino'),
(3,'Transgénero'),
(4,'No Binario'),
(5,'Otro');
/*!40000 ALTER TABLE `genero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generopersona`
--

DROP TABLE IF EXISTS `generopersona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `generopersona` (
  `idgeneropersona` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  `idgenero` int(11) NOT NULL,
  PRIMARY KEY (`idgeneropersona`),
  KEY `fk_gp_persona` (`idpersona`),
  KEY `fk_gp_genero` (`idgenero`),
  CONSTRAINT `fk_gp_genero` FOREIGN KEY (`idgenero`) REFERENCES `genero` (`idgenero`) ON UPDATE CASCADE,
  CONSTRAINT `fk_gp_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generopersona`
--

LOCK TABLES `generopersona` WRITE;
/*!40000 ALTER TABLE `generopersona` DISABLE KEYS */;
INSERT INTO `generopersona` VALUES
(1,1,1),
(2,2,2),
(3,3,1),
(6,7,1);
/*!40000 ALTER TABLE `generopersona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motivoentrenamiento`
--

DROP TABLE IF EXISTS `motivoentrenamiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `motivoentrenamiento` (
  `idmotivoentrenamiento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `objetivo` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `dimension` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idmotivoentrenamiento`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motivoentrenamiento`
--

LOCK TABLES `motivoentrenamiento` WRITE;
/*!40000 ALTER TABLE `motivoentrenamiento` DISABLE KEYS */;
INSERT INTO `motivoentrenamiento` VALUES
(1,'Hipertrofia Muscular','Aumentar la masa muscular magra mediante entrenamiento de sobrecarga progresiva y nutrición orientada al superávit calórico.','modelado_proporciones.webp','Estética Física'),
(2,'Pérdida de Grasa y Definición','Reducir el porcentaje de grasa corporal preservando la masa muscular a través de déficit calórico y circuitos metabólicos.','definicion_vascularizacion.webp','Estética Física'),
(3,'Fuerza Máxima y Potencia','Desarrollar niveles máximos de fuerza en levantamientos básicos (sentadilla, press banca, peso muerto) y ejercicios pliométricos.','longevidad_musculoesqueletica.webp','Salud'),
(4,'Acondicionamiento Físico y Salud','Mejorar la capacidad cardiovascular, resistencia muscular y bienestar general para optimizar la calidad de vida diaria.','salud_cardiovascular.webp','Salud'),
(5,'Rehabilitación y Movilidad Funcional','Recuperación de lesiones, corrección postural y fortalecimiento articular bajo supervisión kinésica y técnica controlada.','postura_alivio_dolor.webp','Salud'),
(6,'Salud metabólica y control glucémico','El entrenamiento de fuerza utiliza la contracción muscular para translocar los transportadores GLUT4 a la membrana celular sin depender de la insulina, reduciendo la resistencia a esta hormona, controlando la glucosa en sangre y minimizando el riesgo de síndrome metabólico y diabetes tipo 2.','salud_metabolica.webp','Salud'),
(7,'Longevidad y preservación musculoesquelética','La carga mecánica estimula la remodelación ósea (aumento de densidad mineral) y la hipertrofia muscular. Esto previene la osteopenia, la osteoporosis y la sarcopenia (pérdida de masa muscular asociada a la edad), garantizando autonomía funcional e independencia motriz a largo plazo.','longevidad_musculoesqueletica.webp','Salud'),
(8,'Salud cardiovascular y hemodinámica','Combinar ejercicios de fuerza con acondicionamiento aeróbico mejora el volumen sistólico del corazón, disminuye la rigidez arterial y reduce la presión arterial sistólica y diastólica en reposo.','salud_cardiovascular.webp','Salud'),
(9,'Biomecánica, postura y mitigación del dolor','Fortalecer la cadena posterior (glúteos, isquiotibiales, erectores de la columna y romboides) compensa los patrones del sedentarismo prolongado, corrigiendo la antepulsión de hombros, la inclinación pélvica y aliviando dolores lumbares y cervicales crónicos.','postura_alivio_dolor.webp','Salud'),
(10,'Salud cerebral y equilibrio neuroquímico','Aumenta la producción de BDNF (factor neurotrófico derivado del cerebro), mejora la plasticidad neuronal, regula los ritmos de cortisol y eleva los niveles de dopamina y serotonina, aliviando la fatiga mental y combatiendo el estrés crónico y el insomnio.','salud_cerebral.webp','Salud'),
(11,'Recomposición corporal (relación masa magra / masa grasa)','Aumentar el tejido muscular activo eleva el gasto energético en reposo (tasa metabólica basal). Esto facilita la oxidación de grasa subcutánea mientras se mantiene o aumenta el tejido muscular, evitando un aspecto flácido al perder peso.','recomposicion_corporal.webp','Estética Física'),
(12,'Modelado y proporciones anatómicas','A través de la selección específica de ejercicios y máquinas en el gimnasio, es posible enfatizar grupos musculares clave para crear proporciones visuales equilibradas (por ejemplo, desarrollo de dorsales y hombros para una silueta en \"V\", o glúteos y cuádriceps para dar firmeza y estructura al tren inferior).','modelado_proporciones.webp','Estética Física'),
(13,'Tono muscular y firmeza del tejido','La contracción muscular regular contra resistencia incrementa el tono basal del músculo y mejora la tensión general bajo la piel, combatiendo la flacidez dérmica tras pérdidas de peso o temporadas de inactividad.','tono_firmeza.webp','Estética Física'),
(14,'Impacto visual de la postura corporal','Un torso erguido, una cintura escapular retraída y una pelvis alineada modifican de inmediato la presencia corporal: proyectan una figura más estilizada, firme y esbelta sin necesidad de un cambio drástico de peso en la balanza.','impacto_postura.webp','Estética Física'),
(15,'Vascularización y definición superficial','La reducción controlada del porcentaje de grasa unida a la hipertrofia muscular resalta los surcos naturales de los grupos musculares (abdominales, brazos, piernas), generando un contorno definido y simétrico.','definicion_vascularizacion.webp','Estética Física');
/*!40000 ALTER TABLE `motivoentrenamiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `musculo`
--

DROP TABLE IF EXISTS `musculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `musculo` (
  `idmusculo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  PRIMARY KEY (`idmusculo`),
  UNIQUE KEY `uk_musculo_nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `musculo`
--

LOCK TABLES `musculo` WRITE;
/*!40000 ALTER TABLE `musculo` DISABLE KEYS */;
INSERT INTO `musculo` VALUES
(1,'Abductores','abductores.webp'),
(2,'Aductores','aductores.webp'),
(3,'Bíceps Braquial','biceps-braquial.webp'),
(4,'Braquial','braquial.webp'),
(5,'Braquiorradial','braquiorradial.webp'),
(6,'Cuádriceps','cuadriceps.webp'),
(7,'Deltoides Anterior','deltoides-anterior.webp'),
(8,'Deltoides Lateral','deltoides-lateral.webp'),
(9,'Deltoides Posterior','deltoides-posterior.webp'),
(10,'Dorsal Ancho','dorsal-ancho.webp'),
(11,'Erector Espinal','erector-espinal.webp'),
(12,'Extensores del Antebrazo','extensores-del-antebrazo.webp'),
(13,'Flexores de Cadera','flexores-de-cadera.webp'),
(14,'Flexores del Antebrazo','flexores-del-antebrazo.webp'),
(15,'Gastrocnemio (Gemelos)','gastrocnemio.webp'),
(16,'Glúteo Mayor','gluteo-mayor.webp'),
(17,'Glúteo Medio','gluteo-medio.webp'),
(18,'Isquiotibiales','isquiotibiales.webp'),
(19,'Oblicuos','oblicuos.webp'),
(20,'Pectoral Mayor','pectoral-mayor.webp'),
(21,'Recto Abdominal','recto-abdominal.webp'),
(22,'Romboides','romboides.webp'),
(23,'Serrato Anterior','serrato-anterior.webp'),
(24,'Sóleo','soleo.webp'),
(25,'Transverso Abdominal','transverso-abdominal.webp'),
(26,'Trapecio','trapecio.webp'),
(27,'Tríceps Braquial','triceps-braquial.webp');
/*!40000 ALTER TABLE `musculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `musculoejercicio`
--

DROP TABLE IF EXISTS `musculoejercicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `musculoejercicio` (
  `idmusculoejecicio` int(11) NOT NULL AUTO_INCREMENT,
  `idejercicio` int(11) NOT NULL,
  `idmusculo` int(11) NOT NULL,
  PRIMARY KEY (`idmusculoejecicio`),
  UNIQUE KEY `uk_ejercicio_musculo` (`idejercicio`,`idmusculo`),
  KEY `fk_me_ejercicio` (`idejercicio`),
  KEY `fk_me_musculo` (`idmusculo`),
  CONSTRAINT `fk_me_ejercicio` FOREIGN KEY (`idejercicio`) REFERENCES `ejercicio` (`idejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_me_musculo` FOREIGN KEY (`idmusculo`) REFERENCES `musculo` (`idmusculo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1702 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `musculoejercicio`
--

LOCK TABLES `musculoejercicio` WRITE;
/*!40000 ALTER TABLE `musculoejercicio` DISABLE KEYS */;
INSERT INTO `musculoejercicio` VALUES
(2,1,6),
(3,1,11),
(1,1,16),
(4,1,18),
(6,2,7),
(5,2,20),
(7,2,27),
(11,3,6),
(8,3,11),
(9,3,16),
(10,3,18),
(12,3,26),
(14,4,3),
(15,4,9),
(13,4,10),
(16,4,22),
(17,5,7),
(18,5,8),
(19,5,26),
(20,5,27),
(23,6,7),
(24,6,10),
(25,6,19),
(21,6,21),
(26,6,23),
(22,6,25),
(28,7,3),
(30,7,9),
(27,7,10),
(29,7,14),
(31,7,22),
(33,8,7),
(32,8,20),
(34,8,21),
(35,8,23),
(36,8,27),
(37,9,7),
(38,9,8),
(39,9,23),
(40,9,26),
(41,9,27),
(44,10,7),
(42,10,20),
(45,10,22),
(43,10,27),
(47,11,3),
(49,11,9),
(46,11,10),
(48,11,14),
(50,11,22),
(51,12,11),
(52,12,16),
(53,12,18),
(55,13,15),
(56,13,16),
(54,13,18),
(59,14,7),
(60,14,13),
(57,14,19),
(58,14,21),
(61,14,23),
(63,15,3),
(65,15,9),
(62,15,10),
(64,15,14),
(66,15,22),
(67,16,9),
(68,16,22),
(69,16,26),
(71,17,16),
(70,17,17),
(73,18,16),
(72,18,17),
(74,19,16),
(75,19,17),
(76,19,18),
(79,20,11),
(77,20,16),
(78,20,18),
(80,21,16),
(81,21,17),
(82,21,18),
(83,22,16),
(84,22,18),
(87,23,6),
(86,23,16),
(85,23,17),
(90,24,11),
(88,24,16),
(89,24,18),
(92,25,16),
(91,25,17),
(94,26,6),
(93,26,16),
(95,26,17),
(96,26,18),
(98,27,15),
(97,27,18),
(100,28,16),
(99,28,17),
(101,29,2),
(104,30,6),
(102,30,16),
(103,30,17),
(105,31,6),
(107,32,10),
(108,32,19),
(106,32,21),
(109,32,25),
(110,33,15),
(111,33,24),
(112,34,3),
(113,34,4),
(114,34,14),
(115,35,7),
(116,35,8),
(117,35,20),
(118,35,23),
(119,36,16),
(120,36,18),
(121,37,27),
(122,38,3),
(123,38,4),
(124,39,10),
(125,39,20),
(126,39,27),
(127,40,9),
(128,40,10),
(129,40,22),
(130,40,26),
(132,41,6),
(133,41,11),
(131,41,16),
(134,41,17),
(135,41,18),
(138,42,3),
(139,42,9),
(136,42,10),
(137,42,22),
(140,43,14),
(146,44,6),
(141,44,7),
(142,44,10),
(143,44,14),
(144,44,16),
(145,44,19),
(147,44,21),
(148,44,26),
(152,45,6),
(149,45,7),
(151,45,19),
(150,45,21),
(153,45,27),
(155,46,14),
(156,46,22),
(154,46,26),
(158,47,9),
(157,47,10),
(159,47,22),
(160,47,26),
(161,48,7),
(162,48,8),
(163,48,26),
(164,48,27),
(166,49,3),
(167,49,9),
(165,49,10),
(168,49,22),
(169,49,26),
(171,50,7),
(172,50,20),
(170,50,27),
(174,51,13),
(175,51,19),
(173,51,21),
(178,52,3),
(179,52,9),
(176,52,10),
(177,52,22),
(180,52,26),
(181,53,10),
(182,53,20),
(183,53,23),
(184,53,27),
(187,54,9),
(185,54,10),
(186,54,20),
(188,54,23),
(189,54,27),
(192,55,3),
(193,55,9),
(190,55,10),
(191,55,22),
(194,55,26),
(197,56,3),
(198,56,9),
(195,56,10),
(196,56,22),
(199,57,3),
(200,57,4),
(201,57,14),
(204,58,13),
(202,58,19),
(203,58,21),
(205,59,11),
(207,59,16),
(206,59,25),
(208,60,15),
(209,60,24),
(210,61,11),
(212,61,16),
(211,61,18),
(214,62,7),
(213,62,8),
(215,62,26),
(216,63,7),
(218,63,23),
(219,63,26),
(217,63,27),
(221,64,6),
(220,64,16),
(222,64,18),
(224,65,6),
(225,65,11),
(223,65,16),
(226,65,17),
(227,65,18),
(229,66,6),
(230,66,15),
(228,66,16),
(231,66,18),
(232,66,24),
(234,67,6),
(235,67,11),
(233,67,16),
(236,67,17),
(237,67,18),
(239,68,6),
(238,68,16),
(240,68,18),
(243,69,3),
(244,69,9),
(241,69,10),
(242,69,22),
(246,70,7),
(245,70,20),
(247,70,23),
(248,70,27),
(250,71,19),
(249,71,21),
(251,71,25),
(252,72,3),
(253,72,4),
(254,73,9),
(255,73,22),
(256,73,26),
(258,74,7),
(257,74,20),
(259,75,7),
(260,75,8),
(261,75,20),
(262,76,3),
(263,76,4),
(264,76,5),
(265,76,14),
(266,77,16),
(267,77,18),
(269,78,7),
(268,78,8),
(270,78,26),
(273,79,7),
(274,79,11),
(275,79,17),
(271,79,19),
(276,79,21),
(272,79,25),
(278,80,9),
(277,80,27),
(282,81,3),
(281,81,7),
(279,81,8),
(280,81,26),
(283,82,14),
(284,83,13),
(286,83,19),
(285,83,21),
(287,83,25),
(288,84,13),
(290,84,19),
(289,84,21),
(291,84,25),
(292,85,11),
(293,85,21),
(294,85,25),
(295,85,26),
(296,86,3),
(297,86,4),
(298,86,5),
(299,86,11),
(301,87,7),
(300,87,20),
(302,87,27),
(305,88,3),
(306,88,9),
(303,88,10),
(304,88,22),
(308,89,9),
(309,89,22),
(307,89,26),
(312,90,3),
(313,90,9),
(310,90,10),
(311,90,22),
(314,90,26),
(317,91,3),
(318,91,9),
(315,91,10),
(316,91,22),
(319,92,3),
(320,92,10),
(321,92,22),
(322,93,1),
(324,93,16),
(323,93,17),
(325,94,20),
(326,94,27),
(329,95,6),
(327,95,7),
(330,95,11),
(328,95,16),
(331,95,26),
(332,95,27),
(334,96,6),
(335,96,7),
(336,96,11),
(333,96,16),
(337,96,18),
(338,96,26),
(339,97,3),
(340,97,4),
(341,97,5),
(343,98,7),
(344,98,20),
(342,98,27),
(346,99,7),
(347,99,20),
(345,99,27),
(349,100,7),
(350,100,20),
(348,100,27),
(351,101,3),
(352,101,4),
(354,102,7),
(355,102,20),
(353,102,27),
(357,103,3),
(358,103,4),
(359,103,9),
(356,103,10),
(360,103,22),
(361,104,3),
(362,104,10),
(363,104,22),
(366,105,7),
(364,105,20),
(367,105,23),
(365,105,27),
(368,106,6),
(369,106,16),
(370,106,18),
(372,107,13),
(373,107,19),
(371,107,21),
(374,108,3),
(375,108,4),
(378,109,2),
(377,109,6),
(376,109,16),
(379,109,18),
(381,110,7),
(382,110,16),
(383,110,20),
(380,110,27),
(384,111,19),
(385,111,21),
(388,112,3),
(386,112,4),
(387,112,5),
(389,112,14),
(391,113,19),
(390,113,21),
(393,114,7),
(392,114,20),
(394,114,27),
(396,115,7),
(395,115,20),
(399,116,2),
(400,116,11),
(397,116,16),
(398,116,18),
(402,117,6),
(401,117,16),
(403,117,18),
(404,118,10),
(405,118,20),
(406,118,27),
(409,119,3),
(407,119,4),
(408,119,12),
(410,120,12),
(412,121,22),
(411,121,26),
(413,122,27),
(415,123,6),
(414,123,16),
(416,123,18),
(417,123,19),
(419,124,6),
(418,124,16),
(420,124,18),
(423,125,2),
(422,125,6),
(421,125,16),
(424,125,17),
(425,125,18),
(427,126,7),
(426,126,20),
(428,126,27),
(431,127,13),
(429,127,21),
(430,127,25),
(433,128,7),
(432,128,20),
(434,128,27),
(436,129,7),
(435,129,20),
(437,129,27),
(439,130,7),
(438,130,20),
(440,130,27),
(442,131,13),
(443,131,19),
(441,131,21),
(445,132,7),
(444,132,20),
(447,133,7),
(446,133,20),
(448,133,27),
(453,134,6),
(452,134,10),
(449,134,11),
(450,134,16),
(451,134,18),
(454,134,26),
(456,135,7),
(455,135,20),
(457,135,23),
(458,135,27),
(461,136,7),
(459,136,20),
(462,136,23),
(460,136,27),
(465,137,7),
(463,137,20),
(464,137,27),
(466,138,15),
(467,138,24),
(470,139,2),
(471,139,11),
(468,139,16),
(469,139,18),
(472,140,3),
(473,140,4),
(474,140,14),
(478,141,6),
(475,141,7),
(476,141,8),
(477,141,16),
(479,141,21),
(480,141,26),
(481,141,27),
(484,142,7),
(485,142,11),
(486,142,14),
(482,142,16),
(483,142,18),
(487,142,26),
(492,143,6),
(490,143,11),
(491,143,14),
(488,143,16),
(489,143,18),
(493,143,26),
(498,144,6),
(494,144,7),
(496,144,11),
(495,144,16),
(497,144,18),
(499,144,26),
(501,145,6),
(500,145,7),
(502,145,16),
(503,145,26),
(504,145,27),
(505,146,7),
(507,146,21),
(508,146,23),
(509,146,26),
(506,146,27),
(513,147,6),
(510,147,7),
(512,147,8),
(511,147,16),
(514,147,27),
(517,148,3),
(515,148,9),
(519,148,10),
(518,148,11),
(516,148,22),
(520,148,26),
(523,149,3),
(521,149,10),
(524,149,11),
(522,149,22),
(525,149,26),
(527,150,6),
(526,150,7),
(528,150,16),
(529,150,26),
(530,150,27),
(533,151,7),
(534,151,11),
(535,151,14),
(531,151,16),
(532,151,18),
(536,151,26),
(539,152,7),
(537,152,13),
(538,152,21),
(540,152,23),
(541,152,25),
(542,153,15),
(544,153,18),
(543,153,24),
(547,154,7),
(545,154,13),
(548,154,16),
(546,154,21),
(549,154,23),
(552,155,6),
(550,155,13),
(551,155,16),
(553,156,7),
(555,156,18),
(554,156,21),
(556,156,23),
(557,156,26),
(558,157,7),
(559,157,11),
(560,157,20),
(561,157,23),
(562,157,27),
(563,158,3),
(564,158,4),
(566,159,11),
(567,159,13),
(568,159,19),
(565,159,21),
(569,159,25),
(572,160,3),
(573,160,9),
(570,160,10),
(571,160,22),
(576,161,14),
(574,161,15),
(575,161,24),
(581,162,6),
(580,162,10),
(577,162,11),
(578,162,16),
(579,162,18),
(582,162,26),
(585,163,3),
(583,163,9),
(584,163,22),
(586,163,26),
(588,164,7),
(587,164,20),
(589,164,27),
(590,165,7),
(591,165,8),
(593,166,6),
(594,166,11),
(592,166,16),
(595,166,18),
(596,166,21),
(599,167,6),
(597,167,16),
(598,167,18),
(601,168,6),
(600,168,16),
(602,168,17),
(603,168,18),
(608,169,6),
(604,169,7),
(607,169,8),
(606,169,16),
(609,169,26),
(605,169,27),
(610,170,9),
(611,170,22),
(612,170,26),
(615,171,11),
(616,171,14),
(613,171,16),
(614,171,18),
(617,172,7),
(618,172,8),
(619,172,26),
(620,172,27),
(622,173,11),
(621,173,19),
(623,173,25),
(629,174,6),
(624,174,7),
(627,174,11),
(625,174,16),
(628,174,18),
(626,174,26),
(631,175,6),
(630,175,16),
(632,175,17),
(633,175,18),
(634,176,27),
(638,177,3),
(637,177,7),
(635,177,8),
(639,177,22),
(636,177,26),
(642,178,7),
(640,178,8),
(643,178,17),
(644,178,18),
(641,178,19),
(646,179,5),
(645,179,14),
(648,180,7),
(647,180,20),
(649,180,27),
(650,181,3),
(651,181,4),
(652,181,5),
(653,182,7),
(654,182,23),
(655,183,27),
(656,184,27),
(657,185,10),
(658,185,20),
(659,185,23),
(660,185,27),
(663,186,3),
(661,186,4),
(662,186,12),
(664,187,3),
(666,187,9),
(665,187,10),
(667,187,22),
(668,187,26),
(670,188,22),
(669,188,26),
(671,189,3),
(672,189,4),
(673,189,5),
(677,190,3),
(676,190,7),
(674,190,8),
(675,190,26),
(678,191,14),
(679,192,9),
(680,192,22),
(681,192,26),
(683,193,7),
(682,193,20),
(684,193,27),
(685,194,10),
(686,194,20),
(687,194,23),
(688,194,27),
(690,195,7),
(689,195,20),
(691,195,27),
(692,196,13),
(693,196,21),
(694,196,25),
(696,197,6),
(697,197,11),
(695,197,16),
(698,197,18),
(699,198,16),
(700,198,18),
(702,199,11),
(701,199,16),
(703,199,17),
(704,199,18),
(706,200,6),
(705,200,16),
(707,200,18),
(708,201,11),
(709,201,16),
(710,201,18),
(711,202,15),
(712,202,24),
(714,203,6),
(715,203,15),
(713,203,16),
(716,203,18),
(719,204,6),
(717,204,13),
(718,204,16),
(720,205,3),
(721,205,4),
(722,205,14),
(723,206,7),
(725,206,8),
(726,206,21),
(727,206,26),
(724,206,27),
(729,207,6),
(731,207,7),
(732,207,11),
(728,207,16),
(733,207,18),
(730,207,26),
(735,208,6),
(737,208,11),
(734,208,16),
(738,208,18),
(736,208,26),
(739,209,13),
(741,209,14),
(742,209,19),
(740,209,21),
(743,210,13),
(745,210,19),
(744,210,21),
(749,211,10),
(748,211,13),
(747,211,14),
(746,211,21),
(752,212,2),
(751,212,6),
(753,212,11),
(750,212,16),
(754,212,18),
(757,213,6),
(755,213,11),
(758,213,14),
(756,213,16),
(759,213,18),
(760,213,26),
(763,214,6),
(761,214,16),
(762,214,18),
(765,215,1),
(764,215,17),
(766,216,2),
(767,217,16),
(768,217,17),
(769,217,18),
(771,218,6),
(770,218,16),
(772,218,18),
(774,219,7),
(773,219,20),
(775,219,27),
(777,220,7),
(776,220,20),
(778,220,27),
(779,221,3),
(780,221,4),
(782,222,7),
(781,222,20),
(783,222,27),
(786,223,3),
(785,223,7),
(784,223,20),
(787,224,3),
(788,224,4),
(789,224,14),
(791,225,7),
(790,225,20),
(792,225,27),
(796,226,3),
(797,226,9),
(793,226,10),
(798,226,21),
(794,226,22),
(795,226,26),
(800,227,13),
(801,227,19),
(799,227,21),
(802,228,11),
(804,228,16),
(803,228,18),
(806,229,6),
(807,229,15),
(805,229,16),
(808,229,18),
(812,230,1),
(813,230,6),
(811,230,8),
(809,230,15),
(810,230,17),
(814,230,24),
(816,231,6),
(815,231,16),
(817,231,17),
(818,231,18),
(820,232,7),
(821,232,20),
(819,232,27),
(822,233,3),
(823,233,4),
(828,234,6),
(824,234,11),
(827,234,14),
(825,234,16),
(826,234,18),
(830,235,7),
(829,235,20),
(831,235,27),
(833,236,6),
(832,236,16),
(834,236,17),
(835,236,18),
(836,237,8),
(837,237,9),
(838,237,26),
(839,238,3),
(840,238,4),
(841,238,5),
(844,239,6),
(842,239,16),
(843,239,18),
(847,240,2),
(848,240,11),
(845,240,16),
(846,240,18),
(851,241,6),
(849,241,7),
(850,241,16),
(852,241,18),
(853,241,21),
(854,241,27),
(857,242,6),
(855,242,7),
(856,242,16),
(858,242,18),
(859,242,19),
(860,242,27),
(861,243,27),
(863,244,6),
(862,244,16),
(864,244,17),
(865,244,18),
(866,244,21),
(867,245,10),
(868,245,20),
(869,245,23),
(870,245,27),
(872,246,6),
(871,246,16),
(873,246,17),
(874,246,18),
(875,246,19),
(876,247,12),
(878,248,6),
(877,248,16),
(879,248,17),
(880,248,18),
(881,248,19),
(883,249,13),
(882,249,19),
(884,249,21),
(886,250,14),
(885,250,26),
(889,251,11),
(887,251,16),
(890,251,17),
(888,251,18),
(891,252,27),
(892,253,6),
(893,253,16),
(896,254,2),
(895,254,6),
(897,254,11),
(894,254,16),
(898,254,18),
(899,254,26),
(900,255,2),
(901,255,8),
(905,255,9),
(903,255,16),
(904,255,18),
(902,255,26),
(907,256,7),
(906,256,20),
(908,256,27),
(911,257,7),
(912,257,11),
(909,257,16),
(910,257,18),
(913,257,26),
(917,258,6),
(916,258,11),
(914,258,16),
(915,258,18),
(922,259,6),
(918,259,7),
(919,259,16),
(921,259,19),
(920,259,21),
(923,259,27),
(924,260,2),
(925,260,7),
(927,260,11),
(928,260,16),
(929,260,18),
(926,260,19),
(930,261,14),
(932,262,7),
(931,262,20),
(933,262,21),
(934,262,27),
(936,263,3),
(937,263,9),
(935,263,10),
(938,263,22),
(939,263,26),
(940,264,7),
(941,264,20),
(942,264,23),
(943,264,27),
(945,265,3),
(946,265,9),
(944,265,10),
(947,265,22),
(949,266,7),
(948,266,8),
(951,267,15),
(950,267,18),
(952,268,6),
(954,269,6),
(953,269,16),
(955,269,18),
(958,270,13),
(957,270,15),
(956,270,18),
(960,271,6),
(961,271,11),
(959,271,16),
(962,271,17),
(963,271,18),
(964,272,13),
(966,272,19),
(965,272,21),
(967,272,25),
(969,273,7),
(968,273,27),
(970,274,11),
(971,274,16),
(972,274,18),
(973,275,3),
(974,275,4),
(975,276,15),
(976,276,24),
(978,277,7),
(977,277,20),
(979,277,23),
(980,278,3),
(981,278,4),
(983,279,19),
(982,279,21),
(984,279,25),
(985,280,7),
(986,280,8),
(987,280,26),
(988,280,27),
(989,281,27),
(992,282,10),
(991,282,16),
(993,282,19),
(990,282,21),
(997,283,6),
(994,283,13),
(996,283,19),
(995,283,21),
(998,284,8),
(1000,284,11),
(1001,284,16),
(1002,284,18),
(999,284,26),
(1006,285,3),
(1005,285,7),
(1003,285,10),
(1007,285,20),
(1004,285,27),
(1009,286,3),
(1011,286,9),
(1008,286,10),
(1010,286,14),
(1012,286,22),
(1014,287,3),
(1015,287,4),
(1013,287,10),
(1016,287,14),
(1017,287,22),
(1019,288,15),
(1020,288,16),
(1018,288,18),
(1021,289,7),
(1022,289,8),
(1023,289,26),
(1024,289,27),
(1029,290,6),
(1025,290,7),
(1027,290,8),
(1026,290,16),
(1028,290,19),
(1030,290,27),
(1035,291,8),
(1033,291,11),
(1034,291,14),
(1031,291,16),
(1032,291,18),
(1036,292,3),
(1037,292,4),
(1038,292,14),
(1039,293,7),
(1041,293,8),
(1040,293,14),
(1042,293,23),
(1043,293,27),
(1046,294,7),
(1044,294,16),
(1047,294,18),
(1045,294,20),
(1048,294,27),
(1050,295,7),
(1049,295,20),
(1051,295,27),
(1053,296,6),
(1054,296,11),
(1052,296,16),
(1055,296,18),
(1056,296,19),
(1059,297,6),
(1057,297,7),
(1058,297,16),
(1060,297,26),
(1061,297,27),
(1064,298,3),
(1065,298,9),
(1062,298,10),
(1063,298,22),
(1066,298,26),
(1067,299,7),
(1068,299,8),
(1069,299,19),
(1070,299,26),
(1071,299,27),
(1074,300,7),
(1075,300,11),
(1072,300,16),
(1073,300,18),
(1076,300,19),
(1078,301,9),
(1077,301,27),
(1079,302,7),
(1081,302,19),
(1080,302,20),
(1082,302,23),
(1083,302,27),
(1085,303,3),
(1086,303,9),
(1084,303,10),
(1087,303,22),
(1090,304,11),
(1091,304,14),
(1088,304,16),
(1092,304,17),
(1089,304,18),
(1093,304,19),
(1096,305,11),
(1097,305,14),
(1094,305,16),
(1098,305,17),
(1095,305,18),
(1099,305,19),
(1101,306,6),
(1103,306,8),
(1102,306,11),
(1100,306,16),
(1104,306,26),
(1105,307,27),
(1107,308,3),
(1108,308,9),
(1106,308,10),
(1109,308,22),
(1110,308,26),
(1112,309,6),
(1113,309,11),
(1111,309,16),
(1114,309,17),
(1115,309,18),
(1117,310,7),
(1116,310,20),
(1118,310,27),
(1119,311,7),
(1120,311,20),
(1121,311,27),
(1123,312,7),
(1122,312,20),
(1124,312,23),
(1128,313,3),
(1130,313,9),
(1125,313,10),
(1129,313,11),
(1126,313,22),
(1127,313,26),
(1131,314,7),
(1132,314,8),
(1133,314,26),
(1134,314,27),
(1138,315,13),
(1137,315,16),
(1135,315,17),
(1136,315,19),
(1142,316,9),
(1139,316,11),
(1140,316,16),
(1141,316,18),
(1143,316,27),
(1146,317,7),
(1147,317,11),
(1144,317,16),
(1145,317,21),
(1148,317,25),
(1149,318,11),
(1150,318,18),
(1151,318,21),
(1154,319,11),
(1155,319,13),
(1152,319,21),
(1153,319,25),
(1158,320,2),
(1156,320,11),
(1159,320,18),
(1157,320,19),
(1162,321,7),
(1160,321,17),
(1161,321,19),
(1163,321,25),
(1164,322,11),
(1166,322,18),
(1165,322,21),
(1167,322,25),
(1169,323,11),
(1168,323,19),
(1170,323,25),
(1172,324,6),
(1175,324,13),
(1171,324,16),
(1173,324,17),
(1174,324,18),
(1176,325,15),
(1177,325,24),
(1181,326,6),
(1178,326,16),
(1179,326,17),
(1180,326,18),
(1183,327,7),
(1182,327,8),
(1184,327,26),
(1186,328,14),
(1185,328,26),
(1187,329,14),
(1188,329,26),
(1189,330,10),
(1190,330,20),
(1191,330,23),
(1192,330,27),
(1194,331,6),
(1193,331,16),
(1195,331,17),
(1196,331,18),
(1197,332,3),
(1198,332,4),
(1201,333,3),
(1199,333,4),
(1200,333,5),
(1202,334,7),
(1203,334,20),
(1204,334,23),
(1205,334,27),
(1209,335,6),
(1206,335,7),
(1208,335,16),
(1210,335,26),
(1207,335,27),
(1213,336,6),
(1211,336,7),
(1212,336,8),
(1214,336,27),
(1217,337,7),
(1215,337,20),
(1216,337,27),
(1223,338,10),
(1218,338,11),
(1222,338,14),
(1219,338,16),
(1220,338,18),
(1221,338,26),
(1224,339,9),
(1225,339,22),
(1226,339,26),
(1228,340,13),
(1229,340,19),
(1227,340,21),
(1230,340,25),
(1233,341,3),
(1231,341,4),
(1232,341,12),
(1236,342,3),
(1234,342,10),
(1237,342,11),
(1235,342,22),
(1238,342,26),
(1239,343,3),
(1241,343,9),
(1240,343,10),
(1242,343,22),
(1244,344,6),
(1243,344,16),
(1245,344,18),
(1246,345,6),
(1247,345,13),
(1248,345,21),
(1252,346,9),
(1250,346,11),
(1251,346,16),
(1249,346,27),
(1254,347,11),
(1253,347,16),
(1255,347,18),
(1258,348,7),
(1256,348,20),
(1257,348,27),
(1259,349,9),
(1260,349,22),
(1261,349,26),
(1266,350,3),
(1265,350,7),
(1262,350,10),
(1263,350,20),
(1267,350,22),
(1264,350,27),
(1270,351,7),
(1268,351,20),
(1271,351,23),
(1269,351,27),
(1274,352,3),
(1275,352,9),
(1272,352,10),
(1273,352,22),
(1276,352,26),
(1280,353,3),
(1282,353,9),
(1277,353,10),
(1281,353,14),
(1283,353,21),
(1278,353,22),
(1279,353,26),
(1286,354,11),
(1284,354,16),
(1285,354,18),
(1289,355,3),
(1288,355,6),
(1287,355,10),
(1290,355,11),
(1291,355,16),
(1292,355,18),
(1293,355,22),
(1294,355,26),
(1296,356,6),
(1299,356,13),
(1295,356,15),
(1297,356,16),
(1298,356,18),
(1300,356,24),
(1303,357,13),
(1301,357,19),
(1302,357,21),
(1304,358,10),
(1306,358,14),
(1307,358,22),
(1305,358,26),
(1308,359,13),
(1310,359,19),
(1309,359,21),
(1311,359,25),
(1314,360,3),
(1316,360,9),
(1312,360,10),
(1315,360,11),
(1313,360,22),
(1318,361,15),
(1317,361,24),
(1319,362,7),
(1320,362,8),
(1321,362,26),
(1322,362,27),
(1323,363,3),
(1324,363,4),
(1325,363,5),
(1327,364,7),
(1326,364,8),
(1328,364,26),
(1330,365,7),
(1329,365,27),
(1332,366,15),
(1331,366,18),
(1333,367,7),
(1334,367,8),
(1335,367,26),
(1336,367,27),
(1338,368,22),
(1337,368,26),
(1340,369,6),
(1343,369,13),
(1339,369,16),
(1341,369,17),
(1342,369,18),
(1344,370,1),
(1345,370,17),
(1346,371,2),
(1347,372,8),
(1348,372,26),
(1351,373,16),
(1349,373,17),
(1350,373,19),
(1352,373,21),
(1353,373,25),
(1356,374,3),
(1357,374,9),
(1354,374,10),
(1355,374,22),
(1360,375,3),
(1361,375,9),
(1358,375,10),
(1359,375,22),
(1363,376,19),
(1362,376,27),
(1366,377,3),
(1364,377,4),
(1365,377,5),
(1367,377,14),
(1368,378,7),
(1369,378,8),
(1370,378,26),
(1371,378,27),
(1373,379,7),
(1372,379,8),
(1374,379,26),
(1376,380,12),
(1375,380,27),
(1378,381,7),
(1377,381,20),
(1379,381,27),
(1380,382,15),
(1381,382,24),
(1382,383,6),
(1384,384,11),
(1383,384,16),
(1385,384,18),
(1387,385,15),
(1386,385,18),
(1389,386,6),
(1388,386,16),
(1390,386,18),
(1393,387,11),
(1391,387,16),
(1394,387,17),
(1392,387,18),
(1395,388,13),
(1397,388,19),
(1396,388,21),
(1398,389,27),
(1400,390,3),
(1402,390,9),
(1399,390,10),
(1401,390,16),
(1403,390,22),
(1404,390,26),
(1406,391,7),
(1405,391,20),
(1407,391,27),
(1410,392,3),
(1408,392,10),
(1411,392,11),
(1409,392,22),
(1412,392,26),
(1414,393,6),
(1413,393,16),
(1415,393,18),
(1416,394,15),
(1417,394,24),
(1419,395,7),
(1418,395,20),
(1420,395,27),
(1422,396,6),
(1423,396,11),
(1421,396,16),
(1424,396,17),
(1425,396,18),
(1426,397,11),
(1428,397,16),
(1427,397,18),
(1429,398,16),
(1430,398,17),
(1431,398,18),
(1432,399,7),
(1433,399,20),
(1434,399,27),
(1436,400,11),
(1437,400,16),
(1435,400,18),
(1438,400,26),
(1439,401,3),
(1440,401,10),
(1441,401,11),
(1442,401,22),
(1443,401,26),
(1445,402,6),
(1444,402,16),
(1446,402,17),
(1447,402,18),
(1448,403,7),
(1449,403,8),
(1450,403,26),
(1451,403,27),
(1453,404,14),
(1452,404,26),
(1455,405,6),
(1454,405,16),
(1456,405,18),
(1458,406,6),
(1459,406,11),
(1457,406,16),
(1460,406,17),
(1461,406,18),
(1465,407,3),
(1464,407,7),
(1462,407,8),
(1463,407,26),
(1467,408,6),
(1471,408,8),
(1469,408,11),
(1466,408,16),
(1470,408,18),
(1468,408,26),
(1472,409,3),
(1473,409,4),
(1475,410,6),
(1474,410,7),
(1476,410,16),
(1477,410,26),
(1478,410,27),
(1480,411,6),
(1479,411,16),
(1481,411,17),
(1482,411,18),
(1484,412,7),
(1483,412,20),
(1485,412,27),
(1486,413,16),
(1487,413,18),
(1488,413,21),
(1490,414,7),
(1491,414,13),
(1492,414,19),
(1489,414,21),
(1493,414,23),
(1495,415,7),
(1494,415,20),
(1496,415,21),
(1497,415,23),
(1498,415,27),
(1500,416,7),
(1499,416,20),
(1501,416,21),
(1502,416,23),
(1503,416,27),
(1505,417,6),
(1504,417,16),
(1506,417,18),
(1507,418,11),
(1509,418,16),
(1508,418,18),
(1511,419,10),
(1512,419,11),
(1510,419,19),
(1514,420,6),
(1515,420,15),
(1513,420,16),
(1516,420,17),
(1517,420,18),
(1520,421,11),
(1518,421,16),
(1519,421,18),
(1521,421,26),
(1523,422,9),
(1522,422,10),
(1524,422,27),
(1525,423,7),
(1526,423,8),
(1527,423,20),
(1528,424,20),
(1529,424,27),
(1530,425,3),
(1531,425,4),
(1532,425,14),
(1534,426,6),
(1535,426,11),
(1533,426,16),
(1536,426,18),
(1538,427,6),
(1539,427,11),
(1537,427,16),
(1540,427,17),
(1541,427,18),
(1542,428,11),
(1543,428,16),
(1544,428,18),
(1547,429,13),
(1545,429,19),
(1546,429,21),
(1548,429,25),
(1550,430,7),
(1549,430,20),
(1551,430,27),
(1554,431,3),
(1552,431,10),
(1555,431,11),
(1553,431,22),
(1556,431,26),
(1560,432,9),
(1559,432,11),
(1557,432,19),
(1558,432,26),
(1562,433,6),
(1561,433,7),
(1563,433,16),
(1564,433,26),
(1565,433,27),
(1569,434,10),
(1566,434,13),
(1568,434,14),
(1570,434,19),
(1567,434,21),
(1571,435,27),
(1572,436,27),
(1573,437,3),
(1574,437,4),
(1575,437,5),
(1577,438,7),
(1576,438,20),
(1578,438,21),
(1579,438,27),
(1580,439,9),
(1581,439,22),
(1582,439,26),
(1584,440,15),
(1585,440,16),
(1583,440,18),
(1587,441,6),
(1586,441,16),
(1588,441,17),
(1589,441,18),
(1591,442,6),
(1590,442,16),
(1592,442,17),
(1593,442,18),
(1596,443,3),
(1597,443,9),
(1594,443,10),
(1595,443,22),
(1598,443,26),
(1600,444,6),
(1599,444,16),
(1601,444,18),
(1602,445,27),
(1605,446,8),
(1603,446,9),
(1606,446,22),
(1604,446,26),
(1610,447,3),
(1609,447,7),
(1607,447,8),
(1608,447,26),
(1612,448,3),
(1611,448,10),
(1613,448,22),
(1614,448,26),
(1615,449,27),
(1616,450,13),
(1618,450,19),
(1617,450,21),
(1619,450,25),
(1621,451,6),
(1620,451,16),
(1622,451,17),
(1623,451,18),
(1625,452,7),
(1624,452,20),
(1626,452,27),
(1629,453,7),
(1627,453,20),
(1628,453,27),
(1631,454,3),
(1632,454,9),
(1630,454,10),
(1633,454,22),
(1634,454,26),
(1636,455,19),
(1635,455,21),
(1638,456,7),
(1637,456,20),
(1639,456,27),
(1641,457,3),
(1642,457,9),
(1640,457,10),
(1643,457,22),
(1644,457,26),
(1646,458,7),
(1645,458,20),
(1647,458,23),
(1648,458,27),
(1651,459,3),
(1652,459,9),
(1649,459,10),
(1650,459,22),
(1653,460,2),
(1656,460,6),
(1654,460,16),
(1655,460,18),
(1658,461,5),
(1657,461,14),
(1661,462,7),
(1659,462,12),
(1660,462,14),
(1662,463,3),
(1663,463,4),
(1664,463,5),
(1665,463,12),
(1668,464,3),
(1669,464,9),
(1666,464,10),
(1670,464,11),
(1667,464,22),
(1671,464,26),
(1675,465,8),
(1672,465,9),
(1674,465,22),
(1673,465,26),
(1676,466,3),
(1677,466,4),
(1678,466,5),
(1680,467,22),
(1679,467,26),
(1681,468,6),
(1686,468,13),
(1684,468,15),
(1683,468,16),
(1682,468,18),
(1687,468,21),
(1685,468,24),
(1698,469,3),
(1688,469,6),
(1694,469,7),
(1697,469,10),
(1693,469,13),
(1691,469,15),
(1690,469,16),
(1689,469,18),
(1701,469,19),
(1695,469,20),
(1700,469,21),
(1699,469,22),
(1692,469,24),
(1696,469,27);
/*!40000 ALTER TABLE `musculoejercicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(20) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `fechanacimiento` date DEFAULT NULL,
  `idsexo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpersona`),
  UNIQUE KEY `cedula` (`cedula`),
  KEY `fk_persona_sexo` (`idsexo`),
  CONSTRAINT `fk_persona_sexo` FOREIGN KEY (`idsexo`) REFERENCES `sexo` (`idsexo`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES
(1,'0801234567','Mendoza Reyes','Carlos Alberto','1995-04-12',1),
(2,'0807654321','Torres Loor','María Fernanda','1998-09-25',2),
(3,'0912345678','Castillo Ortiz','Juan Diego','2000-01-15',1),
(7,'0801560517','Francis Quinde','Stalin Adalberto','1980-07-01',1),
(8,'0803597285','San Luca Arroyo','Edwin','2001-03-18',1),
(9,'0804932341','QUIÑONEZ SANCHEZ','MIRKA GERALDY','2003-07-30',2),
(10,'0809999999','Gomez Perez','Andrea Carolina','1999-05-20',2),
(11,'0998877665','User','Test',NULL,1),
(12,'0850359514','Chávez Salazar','David Bolivar','2004-03-04',1),
(13,'0804028264','Glatzle Mina','Marion','2004-06-14',2),
(14,'0804297885','Arroyo','Milena','2002-02-23',2),
(15,'0850237843','Soliz Rosales','Lady','2004-05-26',2),
(16,'0850018003','Angulo Escobar','Kimberly','2001-09-01',2),
(17,'1758257834','Pineda Morales','Aljer Jesús','2005-10-17',1);
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `plan_ejercicio_personalizado`
--

DROP TABLE IF EXISTS `plan_ejercicio_personalizado`;
/*!50001 DROP VIEW IF EXISTS `plan_ejercicio_personalizado`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `plan_ejercicio_personalizado` AS SELECT
 NULL AS `idplanpersonalizado`,
 NULL AS `idplanejerciciomodelo`,
 NULL AS `nombre`,
 NULL AS `idejercicio`,
 NULL AS `diassemanas`,
 NULL AS `repeticiones`,
 NULL AS `series`,
 NULL AS `tiempodescanso`,
 NULL AS `peso`,
 NULL AS `fechainicio`,
 NULL AS `duracionsemana` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `planejercicio`
--

DROP TABLE IF EXISTS `planejercicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `planejercicio` (
  `idplanejercicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `idejercicio` int(11) NOT NULL,
  `diassemanas` int(11) DEFAULT NULL,
  `repeticiones` int(11) DEFAULT NULL,
  `series` int(11) DEFAULT NULL,
  `tiempodescanso` int(11) DEFAULT NULL,
  `peso` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`idplanejercicio`),
  KEY `fk_pej_ejercicio` (`idejercicio`),
  CONSTRAINT `fk_pej_ejercicio` FOREIGN KEY (`idejercicio`) REFERENCES `ejercicio` (`idejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planejercicio`
--

LOCK TABLES `planejercicio` WRITE;
/*!40000 ALTER TABLE `planejercicio` DISABLE KEYS */;
INSERT INTO `planejercicio` VALUES
(1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00),
(2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00),
(3,'Plan Dominada',4,4,12,3,60,50.00),
(4,'Plan Press de Barra sobre la Cabeza Sentado',5,4,15,3,60,45.00),
(5,'Plan Máquina de Remo',355,5,20,4,45,0.00),
(6,'Plan Rueda Abdominal',6,5,20,4,45,0.00),
(7,'Plan Peso Muerto con Barra',3,3,5,5,180,100.00),
(8,'Plan Sentadilla Trasera con Barra',1,3,5,5,180,85.00),
(9,'Plan Dominadas Arquero',7,4,15,3,60,30.00),
(11,'Plan Crunch Declinado',131,3,10,4,10,0.00),
(12,'Calentamiento persona de 56 años',28,3,10,4,20,0.00),
(14,'Plan Apertura con mancuernas en banco inclinado',223,3,10,4,10,5.00),
(15,'Plan Aperturas con Mancuernas en Banco Declinado adulto 18 - 29 años',132,3,5,4,60,10.00),
(16,'Plan Sentadilla con Kettlebell',253,2,15,4,60,5.00),
(17,'Plan Push Press con Mancuerna a Un Brazo',290,2,15,8,60,5.00),
(18,'Plan Apertura de Deltoides Posterior',339,2,15,4,60,10.00);
/*!40000 ALTER TABLE `planejercicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `planejerciciomodelo`
--

DROP TABLE IF EXISTS `planejerciciomodelo`;
/*!50001 DROP VIEW IF EXISTS `planejerciciomodelo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `planejerciciomodelo` AS SELECT
 NULL AS `idplanejercicio`,
 NULL AS `nombre`,
 NULL AS `idejercicio`,
 NULL AS `diassemanas`,
 NULL AS `repeticiones`,
 NULL AS `series`,
 NULL AS `tiempodescanso`,
 NULL AS `peso` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `planejerciciopersonalizado`
--

DROP TABLE IF EXISTS `planejerciciopersonalizado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `planejerciciopersonalizado` (
  `idplanpersonalizado` int(11) NOT NULL AUTO_INCREMENT,
  `idplanejerciciomodelo` int(11) DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `idejercicio` int(11) NOT NULL,
  `diassemanas` int(11) DEFAULT NULL,
  `repeticiones` int(11) DEFAULT NULL,
  `series` int(11) DEFAULT NULL,
  `tiempodescanso` int(11) DEFAULT NULL,
  `peso` decimal(8,2) DEFAULT 0.00,
  `fechainicio` date DEFAULT NULL,
  `duracionsemana` int(11) DEFAULT NULL,
  PRIMARY KEY (`idplanpersonalizado`),
  KEY `fk_pep_ejercicio` (`idejercicio`),
  KEY `fk_pep_planmodelo` (`idplanejerciciomodelo`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planejerciciopersonalizado`
--

LOCK TABLES `planejerciciopersonalizado` WRITE;
/*!40000 ALTER TABLE `planejerciciopersonalizado` DISABLE KEYS */;
INSERT INTO `planejerciciopersonalizado` VALUES
(1,1,'Plan Sentadilla Trasera con Barra',1,3,8,5,90,95.50,NULL,4),
(2,2,'Plan Press de Banca con Barra',2,3,10,4,120,40.00,NULL,4),
(3,10,'Plan Dominadas Arquero',7,3,12,3,60,20.00,NULL,4),
(4,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,NULL,4),
(5,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,NULL,4),
(6,10,'Plan Dominadas Arquero',7,3,12,3,60,20.00,NULL,4),
(7,3,'Plan Dominada',4,4,12,3,60,50.00,NULL,4),
(8,4,'Plan Press de Barra sobre la Cabeza Sentado',5,4,15,3,60,45.00,NULL,4),
(9,5,'Plan Máquina de Remo',355,5,20,4,45,0.00,NULL,4),
(12,12,'Calentamiento persona de 56 años',28,3,10,4,20,0.00,NULL,4),
(13,7,'Plan Peso Muerto con Barra',3,3,5,5,180,100.00,NULL,4),
(14,15,'Plan Aperturas con Mancuernas en Banco Declinado adulto 18 - 29 años',132,3,5,4,60,10.00,NULL,4),
(15,16,'Plan Sentadilla con Kettlebell',253,2,15,4,60,5.00,NULL,4),
(16,17,'Plan Push Press con Mancuerna a Un Brazo',290,2,15,8,60,5.00,NULL,4),
(17,18,'Plan Apertura de Deltoides Posterior',339,2,15,4,60,10.00,NULL,4),
(19,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,NULL,4),
(20,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,NULL,4),
(21,10,'Plan Dominadas Arquero',7,3,12,3,60,20.00,NULL,4),
(22,NULL,'Plan Extensión de Cuádriceps a Una Pierna',383,3,12,3,60,0.00,NULL,4),
(23,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,NULL,4),
(24,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,NULL,4),
(26,NULL,'Plan Press Arnold',9,3,10,5,120,5.00,NULL,4),
(27,NULL,'Plan Curl de Bíceps Sentado en Polea',466,3,12,3,60,0.00,NULL,4),
(28,NULL,'Plan Aperturas con Cable',74,2,12,3,120,20.00,NULL,4),
(29,NULL,'Plan Correr',356,3,12,3,60,0.00,NULL,4),
(30,NULL,'Plan Apertura con mancuernas en banco inclinado',223,3,12,3,120,0.00,NULL,4),
(31,NULL,'Plan Correr',356,3,50,5,60,0.00,NULL,4),
(32,5,'Plan Máquina de Remo',355,5,20,4,45,0.00,'2026-10-22',4),
(33,6,'Plan Rueda Abdominal',6,5,20,4,45,0.00,'2026-10-22',4),
(34,5,'Plan Máquina de Remo',355,5,20,4,45,0.00,'2026-10-22',4),
(35,6,'Plan Rueda Abdominal',6,5,20,4,45,0.00,'2026-10-22',4),
(36,5,'Plan Máquina de Remo',355,5,20,4,45,0.00,'2026-10-22',4),
(37,6,'Plan Rueda Abdominal',6,5,20,4,45,0.00,'2026-10-22',4),
(38,7,'Plan Peso Muerto con Barra',3,3,5,5,180,100.00,'2026-10-22',4),
(39,8,'Plan Sentadilla Trasera con Barra',1,3,5,5,180,85.00,'2026-10-22',4),
(40,5,'Plan Máquina de Remo',355,5,20,4,45,0.00,'2026-10-22',4),
(41,6,'Plan Rueda Abdominal',6,5,20,4,45,0.00,'2026-10-22',4),
(42,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,'2026-10-22',4),
(43,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,'2026-10-22',4),
(44,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,'2026-10-22',4),
(45,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,'2026-10-22',4),
(46,5,'Plan Máquina de Remo',355,5,20,4,45,0.00,'2026-10-22',4),
(47,6,'Plan Rueda Abdominal',6,5,20,4,45,0.00,'2026-10-22',4),
(48,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,'2026-10-22',4),
(49,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,'2026-10-22',4),
(50,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,'2026-10-22',4),
(51,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,'2026-10-22',4),
(52,NULL,'Plan Abdominales',388,3,12,3,60,0.00,'2026-10-22',4),
(55,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,'2026-10-22',4),
(56,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,'2026-10-22',4),
(57,3,'Plan Dominada',4,4,12,3,60,50.00,'2026-10-22',4),
(58,4,'Plan Press de Barra sobre la Cabeza Sentado',5,4,15,3,60,45.00,'2026-10-22',4),
(59,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,'2026-10-22',4),
(60,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,'2026-10-22',4),
(61,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,'2026-10-22',4),
(62,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,'2026-10-22',4),
(63,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,'2026-10-22',4),
(64,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,'2026-10-22',4),
(65,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,'2026-10-22',4),
(66,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,'2026-10-22',4),
(68,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,'2026-10-22',4),
(69,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,'2026-10-22',4),
(70,1,'Plan Sentadilla Trasera con Barra',1,3,12,4,90,60.00,'2026-10-22',4),
(71,2,'Plan Press de Banca con Barra',2,3,10,4,120,80.00,'2026-10-22',4);
/*!40000 ALTER TABLE `planejerciciopersonalizado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `planpersonalizado`
--

DROP TABLE IF EXISTS `planpersonalizado`;
/*!50001 DROP VIEW IF EXISTS `planpersonalizado`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `planpersonalizado` AS SELECT
 NULL AS `idplanpersonalizado`,
 NULL AS `idplanejerciciomodelo`,
 NULL AS `nombre`,
 NULL AS `idejercicio`,
 NULL AS `diassemanas`,
 NULL AS `repeticiones`,
 NULL AS `series`,
 NULL AS `tiempodescanso`,
 NULL AS `peso`,
 NULL AS `fechainicio`,
 NULL AS `duracionsemana` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `programacliente`
--

DROP TABLE IF EXISTS `programacliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `programacliente` (
  `idprogramacliente` int(11) NOT NULL AUTO_INCREMENT,
  `idprogramaentrenamiento` int(11) NOT NULL,
  `idprogramapersonalizado` int(11) DEFAULT NULL,
  `idcliente` int(11) NOT NULL,
  `fechainicio` date NOT NULL,
  `idestadoprogramacliente` int(11) NOT NULL,
  PRIMARY KEY (`idprogramacliente`),
  KEY `fk_pc_programa` (`idprogramaentrenamiento`),
  KEY `fk_pc_cliente` (`idcliente`),
  KEY `fk_pc_estado` (`idestadoprogramacliente`),
  CONSTRAINT `fk_pc_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pc_estado` FOREIGN KEY (`idestadoprogramacliente`) REFERENCES `estadoprogramacliente` (`idestadoprogramacliente`) ON UPDATE CASCADE,
  CONSTRAINT `fk_pc_programa` FOREIGN KEY (`idprogramaentrenamiento`) REFERENCES `programaentrenamiento` (`idprogramaentrenamiento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programacliente`
--

LOCK TABLES `programacliente` WRITE;
/*!40000 ALTER TABLE `programacliente` DISABLE KEYS */;
INSERT INTO `programacliente` VALUES
(1,1,1,1,'2026-01-15',1),
(2,2,2,1,'2026-02-01',1),
(3,3,3,2,'2026-03-10',1),
(4,5,4,6,'2026-04-05',1),
(5,12,5,6,'2026-10-15',1),
(6,13,6,7,'2026-10-16',1),
(7,14,7,8,'2026-10-16',1),
(8,1,8,2,'2026-10-20',1),
(9,1,NULL,10,'2026-10-21',1),
(10,1,9,10,'2026-10-21',1),
(15,5,14,11,'2026-10-22',1),
(18,6,17,12,'2026-10-22',1),
(19,1,18,11,'2026-10-22',1),
(21,1,20,13,'2026-10-22',1),
(22,1,21,13,'2026-10-22',1),
(29,1,28,14,'2026-10-22',1);
/*!40000 ALTER TABLE `programacliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programaentrenamiento`
--

DROP TABLE IF EXISTS `programaentrenamiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `programaentrenamiento` (
  `idprogramaentrenamiento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `idmotivoentrenamiento` int(11) NOT NULL,
  `idrangoedad` int(11) DEFAULT NULL,
  PRIMARY KEY (`idprogramaentrenamiento`),
  KEY `fk_pe_motivo` (`idmotivoentrenamiento`),
  KEY `fk_pe_rangoedad` (`idrangoedad`),
  CONSTRAINT `fk_pe_motivo` FOREIGN KEY (`idmotivoentrenamiento`) REFERENCES `motivoentrenamiento` (`idmotivoentrenamiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pe_rangoedad` FOREIGN KEY (`idrangoedad`) REFERENCES `rangoedad` (`idrangoedad`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programaentrenamiento`
--

LOCK TABLES `programaentrenamiento` WRITE;
/*!40000 ALTER TABLE `programaentrenamiento` DISABLE KEYS */;
INSERT INTO `programaentrenamiento` VALUES
(1,'Hipertrofia Muscular - Full Body A',1,2),
(2,'Hipertrofia Muscular - Full Body B',1,2),
(3,'Hipertrofia Torso y Pierna A',1,3),
(4,'Hipertrofia Torso y Pierna B',1,3),
(5,'Definición y Quema Grasa - HIIT A',2,2),
(6,'Definición y Quema Grasa - HIIT B',2,2),
(7,'Fuerza y Potencia 5x5 Básico',3,2),
(8,'Fuerza y Potencia 5x5 Avanzado',3,3),
(9,'Acondicionamiento Físico - PPL Pro',4,3),
(10,'Rehabilitación y Movilidad Funcional',5,5),
(12,'Acondicionamiento físico y salud 56 años',4,4),
(13,'fuerza y potencias adulto joven 18-29',3,2),
(14,'PROGRAMA MIRKA',1,2);
/*!40000 ALTER TABLE `programaentrenamiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `programaentrenamientomodelo`
--

DROP TABLE IF EXISTS `programaentrenamientomodelo`;
/*!50001 DROP VIEW IF EXISTS `programaentrenamientomodelo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `programaentrenamientomodelo` AS SELECT
 NULL AS `idprogramaentrenamiento`,
 NULL AS `nombre`,
 NULL AS `idmotivoentrenamiento`,
 NULL AS `idrangoedad` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `programaentrenamientopersonalizado`
--

DROP TABLE IF EXISTS `programaentrenamientopersonalizado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `programaentrenamientopersonalizado` (
  `idprogramapersonalizado` int(11) NOT NULL AUTO_INCREMENT,
  `idprogramaentrenamientomodelo` int(11) DEFAULT NULL,
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `idmotivoentrenamiento` int(11) NOT NULL,
  `idrangoedad` int(11) DEFAULT NULL,
  `fechacreacion` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idprogramapersonalizado`),
  KEY `fk_pep_cliente` (`idcliente`),
  KEY `fk_pep_modelo` (`idprogramaentrenamientomodelo`),
  KEY `fk_pep_motivo` (`idmotivoentrenamiento`),
  KEY `fk_pep_rango` (`idrangoedad`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programaentrenamientopersonalizado`
--

LOCK TABLES `programaentrenamientopersonalizado` WRITE;
/*!40000 ALTER TABLE `programaentrenamientopersonalizado` DISABLE KEYS */;
INSERT INTO `programaentrenamientopersonalizado` VALUES
(1,1,1,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-20 13:53:44'),
(2,2,1,'Hipertrofia Muscular - Full Body B',1,2,'2026-10-20 13:53:44'),
(3,3,2,'Hipertrofia Torso y Pierna A',1,3,'2026-10-20 13:53:44'),
(4,5,6,'Definición y Quema Grasa - HIIT A',2,2,'2026-10-20 13:53:44'),
(5,12,6,'Acondicionamiento físico y salud 56 años',4,4,'2026-10-20 13:53:44'),
(6,13,7,'fuerza y potencias adulto joven 18-29',3,2,'2026-10-20 13:53:44'),
(7,14,8,'PROGRAMA MIRKA',1,2,'2026-10-20 13:53:44'),
(8,1,2,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-20 18:58:48'),
(9,1,10,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-21 13:42:05'),
(10,5,15,'Definición y Quema Grasa - HIIT A',2,2,'2026-10-22 20:25:18'),
(11,5,15,'Definición y Quema Grasa - HIIT A',2,2,'2026-10-22 20:25:30'),
(12,5,15,'Definición y Quema Grasa - HIIT A',2,2,'2026-10-22 20:25:45'),
(13,8,15,'Fuerza y Potencia 5x5 Avanzado',3,3,'2026-10-22 20:26:05'),
(14,5,11,'Definición y Quema Grasa - HIIT A',2,2,'2026-10-22 20:26:49'),
(15,1,15,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-22 20:27:14'),
(16,2,15,'Hipertrofia Muscular - Full Body B',1,2,'2026-10-22 20:27:21'),
(17,6,12,'Definición y Quema Grasa - HIIT B',2,2,'2026-10-22 20:29:54'),
(18,1,11,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-22 20:30:38'),
(19,1,17,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-22 20:32:55'),
(20,1,13,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-22 20:34:12'),
(21,1,13,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-22 20:34:56'),
(22,4,18,'Hipertrofia Torso y Pierna B',1,3,'2026-10-22 20:35:24'),
(23,1,18,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-22 20:35:41'),
(24,1,18,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-22 20:35:53'),
(25,1,18,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-22 20:35:58'),
(26,1,18,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-22 20:36:04'),
(27,1,18,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-22 20:36:10'),
(28,1,14,'Hipertrofia Muscular - Full Body A',1,2,'2026-10-22 20:41:29');
/*!40000 ALTER TABLE `programaentrenamientopersonalizado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `programapersonalizado`
--

DROP TABLE IF EXISTS `programapersonalizado`;
/*!50001 DROP VIEW IF EXISTS `programapersonalizado`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `programapersonalizado` AS SELECT
 NULL AS `idprogramapersonalizado`,
 NULL AS `idprogramaentrenamientomodelo`,
 NULL AS `idcliente`,
 NULL AS `nombre`,
 NULL AS `idmotivoentrenamiento`,
 NULL AS `idrangoedad`,
 NULL AS `fechacreacion` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rangoedad`
--

DROP TABLE IF EXISTS `rangoedad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rangoedad` (
  `idrangoedad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `edadminima` int(11) NOT NULL,
  `edadmaxima` int(11) NOT NULL,
  PRIMARY KEY (`idrangoedad`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rangoedad`
--

LOCK TABLES `rangoedad` WRITE;
/*!40000 ALTER TABLE `rangoedad` DISABLE KEYS */;
INSERT INTO `rangoedad` VALUES
(1,'Juvenil / Adolescentes',14,17),
(2,'Adulto Joven',18,29),
(3,'Adulto General',30,49),
(4,'Master / Adulto Maduro',50,64),
(5,'Senior / Tercera Edad',65,99);
/*!40000 ALTER TABLE `rangoedad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rutinaejecicio`
--

DROP TABLE IF EXISTS `rutinaejecicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rutinaejecicio` (
  `idrutinaejercicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idrutinaejercicio`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rutinaejecicio`
--

LOCK TABLES `rutinaejecicio` WRITE;
/*!40000 ALTER TABLE `rutinaejecicio` DISABLE KEYS */;
INSERT INTO `rutinaejecicio` VALUES
(1,'Full Body Principiante'),
(2,'Torso / Pierna Intermedio'),
(3,'Push / Pull / Legs (PPL) Avanzado'),
(4,'Circuito Funcional HIIT'),
(5,'Rutina de Fuerza 5x5'),
(7,'Acondicionamiento físico y salud 56 años'),
(8,'fuerza y potencia para adunto 18-19'),
(9,'fuerza y potencia adunso 18- 29'),
(10,'RUTINA MIRKA');
/*!40000 ALTER TABLE `rutinaejecicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `rutinaejercicio`
--

DROP TABLE IF EXISTS `rutinaejercicio`;
/*!50001 DROP VIEW IF EXISTS `rutinaejercicio`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `rutinaejercicio` AS SELECT
 NULL AS `idrutinaejercicio`,
 NULL AS `nombre` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rutinaejerciciomodelo`
--

DROP TABLE IF EXISTS `rutinaejerciciomodelo`;
/*!50001 DROP VIEW IF EXISTS `rutinaejerciciomodelo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `rutinaejerciciomodelo` AS SELECT
 NULL AS `idrutinaejercicio`,
 NULL AS `nombre` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rutinaejerciciopersonalizada`
--

DROP TABLE IF EXISTS `rutinaejerciciopersonalizada`;
/*!50001 DROP VIEW IF EXISTS `rutinaejerciciopersonalizada`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `rutinaejerciciopersonalizada` AS SELECT
 NULL AS `idrutinapersonalizada`,
 NULL AS `idrutinaejerciciomodelo`,
 NULL AS `idcliente`,
 NULL AS `nombre`,
 NULL AS `fechacreacion` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rutinaejerciciopersonalizado`
--

DROP TABLE IF EXISTS `rutinaejerciciopersonalizado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rutinaejerciciopersonalizado` (
  `idrutinapersonalizada` int(11) NOT NULL AUTO_INCREMENT,
  `idrutinaejerciciomodelo` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `fechacreacion` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idrutinapersonalizada`),
  KEY `fk_rep_modelo` (`idrutinaejerciciomodelo`),
  KEY `fk_rep_cliente` (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rutinaejerciciopersonalizado`
--

LOCK TABLES `rutinaejerciciopersonalizado` WRITE;
/*!40000 ALTER TABLE `rutinaejerciciopersonalizado` DISABLE KEYS */;
INSERT INTO `rutinaejerciciopersonalizado` VALUES
(1,1,1,'Full Body Principiante','2026-10-20 13:53:44'),
(2,1,1,'Full Body Principiante','2026-10-20 13:53:44'),
(3,2,2,'Torso / Pierna Intermedio','2026-10-20 13:53:44'),
(4,4,6,'Circuito Funcional HIIT','2026-10-20 13:53:44'),
(5,7,6,'Acondicionamiento físico y salud 56 años','2026-10-20 13:53:44'),
(6,8,7,'fuerza y potencia para adunto 18-19','2026-10-20 13:53:44'),
(7,10,8,'RUTINA MIRKA','2026-10-20 13:53:44'),
(8,1,2,'Full Body Principiante','2026-10-20 18:58:48'),
(9,1,10,'Full Body Principiante','2026-10-21 13:42:05'),
(10,4,15,'Circuito Funcional HIIT','2026-10-22 20:25:18'),
(11,4,15,'Circuito Funcional HIIT','2026-10-22 20:25:30'),
(12,4,15,'Circuito Funcional HIIT','2026-10-22 20:25:45'),
(13,5,15,'Rutina de Fuerza 5x5','2026-10-22 20:26:05'),
(14,4,11,'Circuito Funcional HIIT','2026-10-22 20:26:49'),
(15,1,15,'Full Body Principiante','2026-10-22 20:27:14'),
(16,1,15,'Full Body Principiante','2026-10-22 20:27:21'),
(17,4,12,'Circuito Funcional HIIT','2026-10-22 20:29:54'),
(18,1,11,'Full Body Principiante','2026-10-22 20:30:38'),
(19,1,17,'Full Body Principiante','2026-10-22 20:32:55'),
(20,1,13,'Full Body Principiante','2026-10-22 20:34:12'),
(21,1,13,'Full Body Principiante','2026-10-22 20:34:56'),
(22,2,18,'Torso / Pierna Intermedio','2026-10-22 20:35:24'),
(23,1,18,'Full Body Principiante','2026-10-22 20:35:41'),
(24,1,18,'Full Body Principiante','2026-10-22 20:35:53'),
(25,1,18,'Full Body Principiante','2026-10-22 20:35:58'),
(26,1,18,'Full Body Principiante','2026-10-22 20:36:04'),
(27,1,18,'Full Body Principiante','2026-10-22 20:36:10'),
(28,1,14,'Full Body Principiante','2026-10-22 20:41:29');
/*!40000 ALTER TABLE `rutinaejerciciopersonalizado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `rutinapersonalizada`
--

DROP TABLE IF EXISTS `rutinapersonalizada`;
/*!50001 DROP VIEW IF EXISTS `rutinapersonalizada`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `rutinapersonalizada` AS SELECT
 NULL AS `idrutinapersonalizada`,
 NULL AS `idrutinaejerciciomodelo`,
 NULL AS `idcliente`,
 NULL AS `nombre`,
 NULL AS `fechacreacion` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rutinaplan`
--

DROP TABLE IF EXISTS `rutinaplan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rutinaplan` (
  `id_rutina_plan` int(11) NOT NULL AUTO_INCREMENT,
  `idrutinaejercicio` int(11) NOT NULL,
  `idplanejercicio` int(11) NOT NULL,
  PRIMARY KEY (`id_rutina_plan`),
  KEY `fk_rp_rutina` (`idrutinaejercicio`),
  KEY `fk_rp_plan` (`idplanejercicio`),
  CONSTRAINT `fk_rp_plan` FOREIGN KEY (`idplanejercicio`) REFERENCES `planejercicio` (`idplanejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rp_rutina` FOREIGN KEY (`idrutinaejercicio`) REFERENCES `rutinaejecicio` (`idrutinaejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rutinaplan`
--

LOCK TABLES `rutinaplan` WRITE;
/*!40000 ALTER TABLE `rutinaplan` DISABLE KEYS */;
INSERT INTO `rutinaplan` VALUES
(1,1,1),
(2,1,2),
(3,2,3),
(4,2,4),
(5,4,5),
(6,4,6),
(7,5,7),
(8,5,8),
(9,3,9),
(14,7,11),
(15,7,12),
(16,9,14),
(17,8,7),
(18,8,15),
(19,10,16),
(20,10,17),
(21,10,18);
/*!40000 ALTER TABLE `rutinaplan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `rutinaplanmodelo`
--

DROP TABLE IF EXISTS `rutinaplanmodelo`;
/*!50001 DROP VIEW IF EXISTS `rutinaplanmodelo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `rutinaplanmodelo` AS SELECT
 NULL AS `id_rutina_plan`,
 NULL AS `idrutinaejercicio`,
 NULL AS `idplanejercicio` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rutinaplanpersonalizado`
--

DROP TABLE IF EXISTS `rutinaplanpersonalizado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rutinaplanpersonalizado` (
  `idrutinaplanpersonalizado` int(11) NOT NULL AUTO_INCREMENT,
  `idrutinapersonalizada` int(11) NOT NULL,
  `idplanpersonalizado` int(11) NOT NULL,
  PRIMARY KEY (`idrutinaplanpersonalizado`),
  KEY `fk_rplp_rutina` (`idrutinapersonalizada`),
  KEY `fk_rplp_plan` (`idplanpersonalizado`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rutinaplanpersonalizado`
--

LOCK TABLES `rutinaplanpersonalizado` WRITE;
/*!40000 ALTER TABLE `rutinaplanpersonalizado` DISABLE KEYS */;
INSERT INTO `rutinaplanpersonalizado` VALUES
(1,1,1),
(2,1,2),
(3,1,3),
(4,2,4),
(5,2,5),
(6,2,6),
(7,3,7),
(8,3,8),
(9,4,9),
(12,5,12),
(13,6,13),
(14,6,14),
(15,7,15),
(16,7,16),
(17,7,17),
(19,8,19),
(20,8,20),
(21,8,21),
(22,5,22),
(23,9,23),
(24,9,24),
(26,1,26),
(27,5,27),
(28,1,28),
(29,4,29),
(30,5,30),
(31,5,31),
(32,10,32),
(33,10,33),
(34,11,34),
(35,11,35),
(36,12,36),
(37,12,37),
(38,13,38),
(39,13,39),
(40,14,40),
(41,14,41),
(42,15,42),
(43,15,43),
(44,16,44),
(45,16,45),
(46,17,46),
(47,17,47),
(48,18,48),
(49,18,49),
(50,19,50),
(51,19,51),
(52,17,52),
(55,21,55),
(56,21,56),
(57,22,57),
(58,22,58),
(59,23,59),
(60,23,60),
(61,24,61),
(62,24,62),
(63,25,63),
(64,25,64),
(65,26,65),
(66,26,66),
(68,27,68),
(69,27,69),
(70,28,70),
(71,28,71);
/*!40000 ALTER TABLE `rutinaplanpersonalizado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rutinaprograma`
--

DROP TABLE IF EXISTS `rutinaprograma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rutinaprograma` (
  `idrutinaprograma` int(11) NOT NULL AUTO_INCREMENT,
  `idprogramaentrenamiento` int(11) NOT NULL,
  `idrutinaejercicio` int(11) NOT NULL,
  PRIMARY KEY (`idrutinaprograma`),
  KEY `fk_rprog_programa` (`idprogramaentrenamiento`),
  KEY `fk_rprog_rutina` (`idrutinaejercicio`),
  CONSTRAINT `fk_rprog_programa` FOREIGN KEY (`idprogramaentrenamiento`) REFERENCES `programaentrenamiento` (`idprogramaentrenamiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rprog_rutina` FOREIGN KEY (`idrutinaejercicio`) REFERENCES `rutinaejecicio` (`idrutinaejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rutinaprograma`
--

LOCK TABLES `rutinaprograma` WRITE;
/*!40000 ALTER TABLE `rutinaprograma` DISABLE KEYS */;
INSERT INTO `rutinaprograma` VALUES
(1,1,1),
(2,2,1),
(3,10,1),
(4,3,2),
(5,4,2),
(6,9,3),
(7,5,4),
(8,6,4),
(9,7,5),
(10,8,5),
(16,12,7),
(17,13,8),
(18,14,10);
/*!40000 ALTER TABLE `rutinaprograma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `rutinaprogramamodelo`
--

DROP TABLE IF EXISTS `rutinaprogramamodelo`;
/*!50001 DROP VIEW IF EXISTS `rutinaprogramamodelo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8mb4;
/*!50001 CREATE VIEW `rutinaprogramamodelo` AS SELECT
 NULL AS `idrutinaprograma`,
 NULL AS `idprogramaentrenamiento`,
 NULL AS `idrutinaejercicio` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rutinaprogramapersonalizado`
--

DROP TABLE IF EXISTS `rutinaprogramapersonalizado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rutinaprogramapersonalizado` (
  `idrutinaprogramapersonalizado` int(11) NOT NULL AUTO_INCREMENT,
  `idprogramapersonalizado` int(11) NOT NULL,
  `idrutinapersonalizada` int(11) NOT NULL,
  PRIMARY KEY (`idrutinaprogramapersonalizado`),
  KEY `fk_rpp_prog` (`idprogramapersonalizado`),
  KEY `fk_rpp_rutina` (`idrutinapersonalizada`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rutinaprogramapersonalizado`
--

LOCK TABLES `rutinaprogramapersonalizado` WRITE;
/*!40000 ALTER TABLE `rutinaprogramapersonalizado` DISABLE KEYS */;
INSERT INTO `rutinaprogramapersonalizado` VALUES
(1,1,1),
(2,2,2),
(3,3,3),
(4,4,4),
(5,5,5),
(6,6,6),
(7,7,7),
(8,8,8),
(9,9,9),
(10,10,10),
(11,11,11),
(12,12,12),
(13,13,13),
(14,14,14),
(15,15,15),
(16,16,16),
(17,17,17),
(18,18,18),
(19,19,19),
(20,20,20),
(21,21,21),
(22,22,22),
(23,23,23),
(24,24,24),
(25,25,25),
(26,26,26),
(27,27,27),
(28,28,28);
/*!40000 ALTER TABLE `rutinaprogramapersonalizado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sexo`
--

DROP TABLE IF EXISTS `sexo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sexo` (
  `idsexo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idsexo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sexo`
--

LOCK TABLES `sexo` WRITE;
/*!40000 ALTER TABLE `sexo` DISABLE KEYS */;
INSERT INTO `sexo` VALUES
(1,'Masculino'),
(2,'Femenino'),
(3,'Intersexual');
/*!40000 ALTER TABLE `sexo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL,
  `nombreusuario` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `idx_usuario_nombreusuario` (`nombreusuario`),
  KEY `fk_usuario_persona` (`idpersona`),
  CONSTRAINT `fk_usuario_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES
(1,1,'carlos.admin','$2y$10$abcdefghijklmnopqrstuv1234567890abcdefghijklmnopqrstuv'),
(2,10,'andrea.fit','$2y$12$osUsQNr08fZ07X/70i0uxeJu6pkJ6hYAbPUpqOIG9nd/VpDdCSx4S'),
(3,2,'maria.torres','$2y$12$jyHOGOPaSzdyLOy44TcX9OYvtG.d/ZXPXZvJ3YQyhwV5HdKhhjRq2'),
(4,7,'admin','$2y$12$VpLb9p.YAQF7hwCRbPlI8OgHag1qmo/mY864jhpDSaC1QGCC6QAPO'),
(5,11,'testuser','$2y$12$SyijhCiTCi9Q0fcKUxJWDOjJGYaHKQO72AFujTNH1O0M.Rkt8GC8i'),
(6,12,'DavidCs4','$2y$10$U8KQg/OlktS/m9.QIBn39.nZ0mKbuVPcqW9D0Ox0jOTEDt2cIXWxa'),
(7,13,'Mari2004','$2y$10$hQuqckKasnDW9CFj3PVdceaUSSENmjyPV13Q.pCQN38/LlLkhR04q'),
(8,14,'Mile','$2y$10$MoHFbYurMsetomPbaAqm0.WUhRiyExAV8AngKJwskhuHhUKlRLOs.'),
(9,15,'Lady','$2y$10$3y6jYiQHYmfjrKOq1uwwt.44wclxUTX/Wv1KqcSymTYc52MbwrzCy'),
(10,16,'KimEscobar','$2y$10$WXhijNouVaQo2cod8GcLQuEKy3oR5tv/DjvLi42t4OjXRL3bsPRTG'),
(11,17,'Aljer','$2y$10$cBX.ykLnDQW4urjEp/M5wuZLfQQqgpek6V4tmSsAmbu9TlYIqL2Jq');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitasgim`
--

DROP TABLE IF EXISTS `visitasgim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `visitasgim` (
  `idvisitasgim` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `horaingreso` time NOT NULL,
  `horasalida` time DEFAULT NULL,
  PRIMARY KEY (`idvisitasgim`),
  KEY `idx_visitasgim_cliente` (`idcliente`),
  KEY `idx_visitasgim_fecha` (`fecha`),
  CONSTRAINT `fk_visitasgim_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitasgim`
--

LOCK TABLES `visitasgim` WRITE;
/*!40000 ALTER TABLE `visitasgim` DISABLE KEYS */;
INSERT INTO `visitasgim` VALUES
(1,1,'2026-10-01','07:15:00','08:30:00'),
(2,2,'2026-10-02','18:00:00','19:45:00'),
(3,1,'2026-10-05','06:45:00','08:00:00'),
(4,2,'2026-10-05','19:00:00','21:15:00'),
(6,1,'2026-10-10','17:30:00','18:45:00'),
(7,6,'2026-10-10','18:53:53','03:54:04'),
(8,6,'2026-10-21','09:25:41','09:25:45'),
(9,6,'2026-10-21','09:25:47','13:16:51'),
(10,10,'2026-10-21','09:51:45',NULL),
(11,6,'2026-10-22','13:23:45','15:05:52'),
(12,6,'2026-10-22','15:06:13',NULL),
(13,11,'2026-10-22','15:27:11','15:35:28'),
(14,13,'2026-10-22','15:33:35',NULL),
(15,12,'2026-10-22','15:33:43',NULL),
(16,14,'2026-10-22','15:42:06',NULL);
/*!40000 ALTER TABLE `visitasgim` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'gim360'
--

--
-- Final view structure for view `DisponibilidadEquipo`
--

/*!50001 DROP VIEW IF EXISTS `DisponibilidadEquipo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `DisponibilidadEquipo` AS select `disponibilidadequipo`.`iddisponibilidadequipo` AS `iddisponibilidadequipo`,`disponibilidadequipo`.`nombre` AS `nombre` from `disponibilidadequipo` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `EjercicioEquipo`
--

/*!50001 DROP VIEW IF EXISTS `EjercicioEquipo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `EjercicioEquipo` AS select `ejercicioequipo`.`idejercicioequipo` AS `idejercicioequipo`,`ejercicioequipo`.`idejercicio` AS `idejercicio`,`ejercicioequipo`.`idequipo` AS `idequipo` from `ejercicioequipo` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `EquipoMusculo`
--

/*!50001 DROP VIEW IF EXISTS `EquipoMusculo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `EquipoMusculo` AS select `equipomusculo`.`idequipomusculo` AS `idequipomusculo`,`equipomusculo`.`idequipo` AS `idequipo`,`equipomusculo`.`idmusculo` AS `idmusculo` from `equipomusculo` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `EstadoProgramaCliente`
--

/*!50001 DROP VIEW IF EXISTS `EstadoProgramaCliente`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `EstadoProgramaCliente` AS select `estadoprogramacliente`.`idestadoprogramacliente` AS `idestadoprogramacliente`,`estadoprogramacliente`.`nombre` AS `nombre` from `estadoprogramacliente` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `Musculo`
--

/*!50001 DROP VIEW IF EXISTS `Musculo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `Musculo` AS select `musculo`.`idmusculo` AS `idmusculo`,`musculo`.`nombre` AS `nombre`,`musculo`.`imagen` AS `imagen` from `musculo` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `MusculoEjercicio`
--

/*!50001 DROP VIEW IF EXISTS `MusculoEjercicio`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `MusculoEjercicio` AS select `musculoejercicio`.`idmusculoejecicio` AS `idmusculoejecicio`,`musculoejercicio`.`idejercicio` AS `idejercicio`,`musculoejercicio`.`idmusculo` AS `idmusculo` from `musculoejercicio` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `PlanEjercicio`
--

/*!50001 DROP VIEW IF EXISTS `PlanEjercicio`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `PlanEjercicio` AS select `planejercicio`.`idplanejercicio` AS `idplanejercicio`,`planejercicio`.`idejercicio` AS `idejercicio`,`planejercicio`.`diassemanas` AS `diassemanas`,`planejercicio`.`repeticiones` AS `repeticiones`,`planejercicio`.`series` AS `series`,`planejercicio`.`tiempodescanso` AS `tiempodescanso`,`planejercicio`.`peso` AS `peso` from `planejercicio` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `ProgramaCliente`
--

/*!50001 DROP VIEW IF EXISTS `ProgramaCliente`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ProgramaCliente` AS select `programacliente`.`idprogramacliente` AS `idprogramacliente`,`programacliente`.`idprogramaentrenamiento` AS `idprogramaentrenamiento`,`programacliente`.`idcliente` AS `idcliente`,`programacliente`.`fechainicio` AS `fechainicio`,`programacliente`.`idestadoprogramacliente` AS `idestadoprogramacliente` from `programacliente` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `ProgramaEntrenamiento`
--

/*!50001 DROP VIEW IF EXISTS `ProgramaEntrenamiento`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ProgramaEntrenamiento` AS select `programaentrenamiento`.`idprogramaentrenamiento` AS `idprogramaentrenamiento`,`programaentrenamiento`.`nombre` AS `nombre`,`programaentrenamiento`.`idmotivoentrenamiento` AS `idmotivoentrenamiento`,`programaentrenamiento`.`idrangoedad` AS `idrangoedad` from `programaentrenamiento` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `RangoEdad`
--

/*!50001 DROP VIEW IF EXISTS `RangoEdad`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `RangoEdad` AS select `rangoedad`.`idrangoedad` AS `idrangoedad`,`rangoedad`.`nombre` AS `nombre`,`rangoedad`.`edadminima` AS `edadminima`,`rangoedad`.`edadmaxima` AS `edadmaxima` from `rangoedad` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `RutinaPlan`
--

/*!50001 DROP VIEW IF EXISTS `RutinaPlan`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `RutinaPlan` AS select `rutinaplan`.`id_rutina_plan` AS `id_rutina_plan`,`rutinaplan`.`idrutinaejercicio` AS `idrutinaejercicio`,`rutinaplan`.`idplanejercicio` AS `idplanejercicio` from `rutinaplan` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `RutinaPrograma`
--

/*!50001 DROP VIEW IF EXISTS `RutinaPrograma`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `RutinaPrograma` AS select `rutinaprograma`.`idrutinaprograma` AS `idrutinaprograma`,`rutinaprograma`.`idprogramaentrenamiento` AS `idprogramaentrenamiento`,`rutinaprograma`.`idrutinaejercicio` AS `idrutinaejercicio` from `rutinaprograma` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `equipos`
--

/*!50001 DROP VIEW IF EXISTS `equipos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `equipos` AS select `equipo`.`idequipo` AS `id_equipo`,`equipo`.`idequipo` AS `idequipo`,`equipo`.`codigo` AS `codigo`,`equipo`.`nombre` AS `nombre`,`equipo`.`imagen` AS `imagen`,`equipo`.`video` AS `video`,`equipo`.`id_tipo` AS `id_tipo`,`equipo`.`id_marca` AS `id_marca`,`equipo`.`modelo` AS `modelo`,`equipo`.`numero_serie` AS `numero_serie`,`equipo`.`descripcion` AS `descripcion`,`equipo`.`id_ubicacion` AS `id_ubicacion`,`equipo`.`fecha_adquisicion` AS `fecha_adquisicion`,`equipo`.`valor_adquisicion` AS `valor_adquisicion`,`equipo`.`id_estado` AS `id_estado`,`equipo`.`iddisponibilidadequipo` AS `iddisponibilidadequipo`,`equipo`.`activo` AS `activo`,`equipo`.`observaciones` AS `observaciones`,`equipo`.`fecha_registro` AS `fecha_registro` from `equipo` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `plan_ejercicio_personalizado`
--

/*!50001 DROP VIEW IF EXISTS `plan_ejercicio_personalizado`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `plan_ejercicio_personalizado` AS select `planejerciciopersonalizado`.`idplanpersonalizado` AS `idplanpersonalizado`,`planejerciciopersonalizado`.`idplanejerciciomodelo` AS `idplanejerciciomodelo`,`planejerciciopersonalizado`.`nombre` AS `nombre`,`planejerciciopersonalizado`.`idejercicio` AS `idejercicio`,`planejerciciopersonalizado`.`diassemanas` AS `diassemanas`,`planejerciciopersonalizado`.`repeticiones` AS `repeticiones`,`planejerciciopersonalizado`.`series` AS `series`,`planejerciciopersonalizado`.`tiempodescanso` AS `tiempodescanso`,`planejerciciopersonalizado`.`peso` AS `peso`,`planejerciciopersonalizado`.`fechainicio` AS `fechainicio`,`planejerciciopersonalizado`.`duracionsemana` AS `duracionsemana` from `planejerciciopersonalizado` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `planejerciciomodelo`
--

/*!50001 DROP VIEW IF EXISTS `planejerciciomodelo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `planejerciciomodelo` AS select `planejercicio`.`idplanejercicio` AS `idplanejercicio`,`planejercicio`.`nombre` AS `nombre`,`planejercicio`.`idejercicio` AS `idejercicio`,`planejercicio`.`diassemanas` AS `diassemanas`,`planejercicio`.`repeticiones` AS `repeticiones`,`planejercicio`.`series` AS `series`,`planejercicio`.`tiempodescanso` AS `tiempodescanso`,`planejercicio`.`peso` AS `peso` from `planejercicio` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `planpersonalizado`
--

/*!50001 DROP VIEW IF EXISTS `planpersonalizado`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `planpersonalizado` AS select `planejerciciopersonalizado`.`idplanpersonalizado` AS `idplanpersonalizado`,`planejerciciopersonalizado`.`idplanejerciciomodelo` AS `idplanejerciciomodelo`,`planejerciciopersonalizado`.`nombre` AS `nombre`,`planejerciciopersonalizado`.`idejercicio` AS `idejercicio`,`planejerciciopersonalizado`.`diassemanas` AS `diassemanas`,`planejerciciopersonalizado`.`repeticiones` AS `repeticiones`,`planejerciciopersonalizado`.`series` AS `series`,`planejerciciopersonalizado`.`tiempodescanso` AS `tiempodescanso`,`planejerciciopersonalizado`.`peso` AS `peso`,`planejerciciopersonalizado`.`fechainicio` AS `fechainicio`,`planejerciciopersonalizado`.`duracionsemana` AS `duracionsemana` from `planejerciciopersonalizado` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `programaentrenamientomodelo`
--

/*!50001 DROP VIEW IF EXISTS `programaentrenamientomodelo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `programaentrenamientomodelo` AS select `programaentrenamiento`.`idprogramaentrenamiento` AS `idprogramaentrenamiento`,`programaentrenamiento`.`nombre` AS `nombre`,`programaentrenamiento`.`idmotivoentrenamiento` AS `idmotivoentrenamiento`,`programaentrenamiento`.`idrangoedad` AS `idrangoedad` from `programaentrenamiento` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `programapersonalizado`
--

/*!50001 DROP VIEW IF EXISTS `programapersonalizado`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `programapersonalizado` AS select `programaentrenamientopersonalizado`.`idprogramapersonalizado` AS `idprogramapersonalizado`,`programaentrenamientopersonalizado`.`idprogramaentrenamientomodelo` AS `idprogramaentrenamientomodelo`,`programaentrenamientopersonalizado`.`idcliente` AS `idcliente`,`programaentrenamientopersonalizado`.`nombre` AS `nombre`,`programaentrenamientopersonalizado`.`idmotivoentrenamiento` AS `idmotivoentrenamiento`,`programaentrenamientopersonalizado`.`idrangoedad` AS `idrangoedad`,`programaentrenamientopersonalizado`.`fechacreacion` AS `fechacreacion` from `programaentrenamientopersonalizado` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rutinaejercicio`
--

/*!50001 DROP VIEW IF EXISTS `rutinaejercicio`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `rutinaejercicio` AS select `rutinaejecicio`.`idrutinaejercicio` AS `idrutinaejercicio`,`rutinaejecicio`.`nombre` AS `nombre` from `rutinaejecicio` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rutinaejerciciomodelo`
--

/*!50001 DROP VIEW IF EXISTS `rutinaejerciciomodelo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `rutinaejerciciomodelo` AS select `rutinaejecicio`.`idrutinaejercicio` AS `idrutinaejercicio`,`rutinaejecicio`.`nombre` AS `nombre` from `rutinaejecicio` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rutinaejerciciopersonalizada`
--

/*!50001 DROP VIEW IF EXISTS `rutinaejerciciopersonalizada`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `rutinaejerciciopersonalizada` AS select `rutinaejerciciopersonalizado`.`idrutinapersonalizada` AS `idrutinapersonalizada`,`rutinaejerciciopersonalizado`.`idrutinaejerciciomodelo` AS `idrutinaejerciciomodelo`,`rutinaejerciciopersonalizado`.`idcliente` AS `idcliente`,`rutinaejerciciopersonalizado`.`nombre` AS `nombre`,`rutinaejerciciopersonalizado`.`fechacreacion` AS `fechacreacion` from `rutinaejerciciopersonalizado` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rutinapersonalizada`
--

/*!50001 DROP VIEW IF EXISTS `rutinapersonalizada`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `rutinapersonalizada` AS select `rutinaejerciciopersonalizado`.`idrutinapersonalizada` AS `idrutinapersonalizada`,`rutinaejerciciopersonalizado`.`idrutinaejerciciomodelo` AS `idrutinaejerciciomodelo`,`rutinaejerciciopersonalizado`.`idcliente` AS `idcliente`,`rutinaejerciciopersonalizado`.`nombre` AS `nombre`,`rutinaejerciciopersonalizado`.`fechacreacion` AS `fechacreacion` from `rutinaejerciciopersonalizado` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rutinaplanmodelo`
--

/*!50001 DROP VIEW IF EXISTS `rutinaplanmodelo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `rutinaplanmodelo` AS select `rutinaplan`.`id_rutina_plan` AS `id_rutina_plan`,`rutinaplan`.`idrutinaejercicio` AS `idrutinaejercicio`,`rutinaplan`.`idplanejercicio` AS `idplanejercicio` from `rutinaplan` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rutinaprogramamodelo`
--

/*!50001 DROP VIEW IF EXISTS `rutinaprogramamodelo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `rutinaprogramamodelo` AS select `rutinaprograma`.`idrutinaprograma` AS `idrutinaprograma`,`rutinaprograma`.`idprogramaentrenamiento` AS `idprogramaentrenamiento`,`rutinaprograma`.`idrutinaejercicio` AS `idrutinaejercicio` from `rutinaprograma` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-22 17:58:00
