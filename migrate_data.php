<?php

$mysqli = new mysqli('localhost', 'root', 'PIWIIB1234', 'gim360');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}
$mysqli->set_charset("utf8mb4");

$res = $mysqli->query("SELECT * FROM programacliente WHERE idprogramapersonalizado IS NULL OR idprogramapersonalizado = 0");
$programasClientes = [];
while ($row = $res->fetch_assoc()) {
    $programasClientes[] = $row;
}

echo "Found " . count($programasClientes) . " programacliente records to migrate.\n";

foreach ($programasClientes as $pc) {
    $idPC = (int)$pc['idprogramacliente'];
    $idCliente = (int)$pc['idcliente'];
    $idProgModelo = (int)$pc['idprogramaentrenamiento'];

    $stmt = $mysqli->prepare("SELECT * FROM programaentrenamiento WHERE idprogramaentrenamiento = ?");
    $stmt->bind_param("i", $idProgModelo);
    $stmt->execute();
    $modelo = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$modelo) {
        echo "Model program not found: {$idProgModelo}\n";
        continue;
    }

    // 1. Insert personalized program
    $stmt = $mysqli->prepare("INSERT INTO programaentrenamientopersonalizado (idprogramaentrenamientomodelo, idcliente, nombre, idmotivoentrenamiento, idrangoedad, fechacreacion) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisii", $idProgModelo, $idCliente, $modelo['nombre'], $modelo['idmotivoentrenamiento'], $modelo['idrangoedad']);
    $stmt->execute();
    $idProgPers = $stmt->insert_id;
    $stmt->close();

    // 2. Fetch model routines
    $rutSql = "SELECT rp.*, r.nombre FROM rutinaprograma rp INNER JOIN rutinaejecicio r ON r.idrutinaejercicio = rp.idrutinaejercicio WHERE rp.idprogramaentrenamiento = ?";
    $stmt = $mysqli->prepare($rutSql);
    $stmt->bind_param("i", $idProgModelo);
    $stmt->execute();
    $rutRes = $stmt->get_result();
    $stmt->close();

    while ($rm = $rutRes->fetch_assoc()) {
        $idRutinaModelo = (int)$rm['idrutinaejercicio'];
        $rutNombre = $rm['nombre'];

        $stmt = $mysqli->prepare("INSERT INTO rutinaejerciciopersonalizado (idrutinaejerciciomodelo, idcliente, nombre, fechacreacion) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $idRutinaModelo, $idCliente, $rutNombre);
        $stmt->execute();
        $idRutinaPers = $stmt->insert_id;
        $stmt->close();

        $stmt = $mysqli->prepare("INSERT INTO rutinaprogramapersonalizado (idprogramapersonalizado, idrutinapersonalizada) VALUES (?, ?)");
        $stmt->bind_param("ii", $idProgPers, $idRutinaPers);
        $stmt->execute();
        $stmt->close();

        // 3. Fetch model plans
        $planSql = "SELECT rpl.*, p.* FROM rutinaplan rpl INNER JOIN planejercicio p ON p.idplanejercicio = rpl.idplanejercicio WHERE rpl.idrutinaejercicio = ?";
        $stmt = $mysqli->prepare($planSql);
        $stmt->bind_param("i", $idRutinaModelo);
        $stmt->execute();
        $planRes = $stmt->get_result();
        $stmt->close();

        while ($pm = $planRes->fetch_assoc()) {
            $idPlanModelo = (int)$pm['idplanejercicio'];
            $planNombre = $pm['nombre'];
            $idEjercicio = (int)$pm['idejercicio'];
            $dias = isset($pm['diassemanas']) ? (int)$pm['diassemanas'] : null;
            $reps = isset($pm['repeticiones']) ? (int)$pm['repeticiones'] : null;
            $series = isset($pm['series']) ? (int)$pm['series'] : null;
            $descanso = isset($pm['tiempodescanso']) ? (int)$pm['tiempodescanso'] : null;
            $peso = isset($pm['peso']) ? (float)$pm['peso'] : 0.0;

            $stmt = $mysqli->prepare("INSERT INTO planejerciciopersonalizado (idplanejerciciomodelo, nombre, idejercicio, diassemanas, repeticiones, series, tiempodescanso, peso) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isiiiiid", $idPlanModelo, $planNombre, $idEjercicio, $dias, $reps, $series, $descanso, $peso);
            $stmt->execute();
            $idPlanPers = $stmt->insert_id;
            $stmt->close();

            $stmt = $mysqli->prepare("INSERT INTO rutinaplanpersonalizado (idrutinapersonalizada, idplanpersonalizado) VALUES (?, ?)");
            $stmt->bind_param("ii", $idRutinaPers, $idPlanPers);
            $stmt->execute();
            $stmt->close();
        }
    }

    // 4. Update programacliente
    $stmt = $mysqli->prepare("UPDATE programacliente SET idprogramapersonalizado = ? WHERE idprogramacliente = ?");
    $stmt->bind_param("ii", $idProgPers, $idPC);
    $stmt->execute();
    $stmt->close();

    echo "Migrated programacliente #{$idPC} -> personalized program #{$idProgPers}\n";
}

echo "Migration completed successfully!\n";
$mysqli->close();
