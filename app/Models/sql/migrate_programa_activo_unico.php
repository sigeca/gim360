<?php
/**
 * Script de migración en la nube / local para Gim360:
 * Garantizar que cada cliente tenga a lo sumo un programa de entrenamiento activo.
 * Los programas anteriores quedan en estado 'Pausado' (idestadoprogramacliente = 4).
 */

$envFiles = [
    __DIR__ . '/.env',
    dirname(__DIR__, 2) . '/.env',
    dirname(__DIR__, 3) . '/.env',
    dirname(__DIR__) . '/.env',
];

$envFile = null;
foreach ($envFiles as $ef) {
    if (file_exists($ef)) {
        $envFile = $ef;
        break;
    }
}

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'PIWIIB1234';
$dbName = 'gim360';
$dbPort = 3306;

if ($envFile && file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (strpos($line, '#') === 0) continue;
        if (preg_match('/^database\.default\.hostname\s*=\s*(.+)$/i', $line, $m)) $dbHost = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.database\s*=\s*(.+)$/i', $line, $m)) $dbName = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.username\s*=\s*(.+)$/i', $line, $m)) $dbUser = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.password\s*=\s*(.+)$/i', $line, $m)) $dbPass = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.port\s*=\s*(.+)$/i', $line, $m)) $dbPort = (int)trim($m[1], " '\"");
    }
}

$dbHost = getenv('DB_HOST') ?: (isset($_GET['db_host']) ? $_GET['db_host'] : $dbHost);
$dbUser = getenv('DB_USER') ?: (isset($_GET['db_user']) ? $_GET['db_user'] : $dbUser);
$dbPass = getenv('DB_PASS') ?: (isset($_GET['db_pass']) ? $_GET['db_pass'] : $dbPass);
$dbName = getenv('DB_NAME') ?: (isset($_GET['db_name']) ? $_GET['db_name'] : $dbName);

$isCli = (php_sapi_name() === 'cli');

function outputMsg($msg, $isCli) {
    if ($isCli) {
        echo $msg . PHP_EOL;
    } else {
        echo nl2br(htmlspecialchars($msg)) . "<br>\n";
    }
}

outputMsg("=== MIGRACIÓN: UNICO PROGRAMA ACTIVO POR CLIENTE (GIM360) ===", $isCli);
outputMsg("Conectando a base de datos '$dbName' en $dbHost:$dbPort...", $isCli);

try {
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    outputMsg("Conexión exitosa a la base de datos.", $isCli);

    // Contar duplicados antes
    $stmt = $pdo->query("
        SELECT idcliente, COUNT(*) AS total_activos
        FROM programacliente
        WHERE idestadoprogramacliente = 1
        GROUP BY idcliente
        HAVING COUNT(*) > 1
    ");
    $duplicados = $stmt->fetchAll();

    if (empty($duplicados)) {
        outputMsg("No hay clientes con múltiples programas activos.", $isCli);
    } else {
        outputMsg("Se encontraron " . count($duplicados) . " cliente(s) con múltiples programas activos.", $isCli);
        foreach ($duplicados as $d) {
            outputMsg(" - Cliente #{$d['idcliente']}: {$d['total_activos']} programas activos.", $isCli);
        }

        // Ejecutar actualización
        $sql = "
            UPDATE programacliente pc
            JOIN (
                SELECT idcliente, MAX(idprogramacliente) AS max_id
                FROM programacliente
                WHERE idestadoprogramacliente = 1
                GROUP BY idcliente
                HAVING COUNT(*) > 1
            ) multi ON pc.idcliente = multi.idcliente
            SET pc.idestadoprogramacliente = 4
            WHERE pc.idestadoprogramacliente = 1
              AND pc.idprogramacliente < multi.max_id;
        ";
        $affected = $pdo->exec($sql);
        outputMsg("Se actualizaron $affected programa(s) a estado Pausado (4).", $isCli);
    }

    // Comprobación final
    $checkStmt = $pdo->query("
        SELECT idcliente, COUNT(*) AS total_activos
        FROM programacliente
        WHERE idestadoprogramacliente = 1
        GROUP BY idcliente
        HAVING COUNT(*) > 1
    ");
    $restantes = $checkStmt->fetchAll();
    if (empty($restantes)) {
        outputMsg("VERIFICACIÓN EXITOSA: Cada cliente tiene máximo 1 programa activo.", $isCli);
    } else {
        outputMsg("ADVERTENCIA: Aún existen clientes con más de un programa activo.", $isCli);
    }

} catch (PDOException $e) {
    outputMsg("ERROR: " . $e->getMessage(), $isCli);
    if ($isCli) exit(1);
}
