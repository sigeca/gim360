<?php
/**
 * Diagnóstico rápido del estado del sistema GIM360
 * Accede desde el navegador: http://tudominio/gim360/check.php
 */

header('Content-Type: text/html; charset=utf-8');

function badge($ok, $textOk = 'OK', $textFail = 'ERROR') {
    return $ok 
        ? "<span style='color:green;font-weight:bold;'>[✓ {$textOk}]</span>" 
        : "<span style='color:red;font-weight:bold;'>[✗ {$textFail}]</span>";
}

echo "<html><head><title>Diagnóstico GIM360</title><style>
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 20px; background: #f8fafc; color: #1e293b; }
.card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
h2 { margin-top: 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; }
pre { background: #0f172a; color: #f8fafc; padding: 15px; border-radius: 6px; overflow-x: auto; font-size: 13px; }
table { width: 100%; border-collapse: collapse; }
td, th { padding: 8px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
</style></head><body>";

echo "<h1>Diagnóstico de Instalación - GIM360</h1>";

// 1. PHP y Extensiones
echo "<div class='card'><h2>1. Entorno PHP</h2><table>";
echo "<tr><td>Versión de PHP</td><td>" . PHP_VERSION . " " . badge(version_compare(PHP_VERSION, '8.1', '>=')) . "</td></tr>";
$exts = ['mysqli', 'intl', 'mbstring', 'json', 'curl'];
foreach ($exts as $ext) {
    echo "<tr><td>Extensión '{$ext}'</td><td>" . badge(extension_loaded($ext), 'Instalada', 'Falta instalar') . "</td></tr>";
}
echo "</table></div>";

// 2. Permisos de Writable
echo "<div class='card'><h2>2. Permisos de Escritura (writable)</h2><table>";
$paths = [
    'writable' => __DIR__ . '/writable',
    'writable/cache' => __DIR__ . '/writable/cache',
    'writable/logs' => __DIR__ . '/writable/logs',
    'writable/session' => __DIR__ . '/writable/session',
    'writable/debugbar' => __DIR__ . '/writable/debugbar',
];
foreach ($paths as $name => $path) {
    $isDir = is_dir($path);
    $isWritable = is_writable($path);
    echo "<tr><td>{$name}</td><td>" . ($isDir ? badge($isWritable, 'Escribible', 'Sin permisos de escritura') : badge(false, '', 'No existe el directorio')) . "</td></tr>";
}
echo "</table>";
echo "<p><small>Si hay errores de permisos, ejecuta en el servidor: <code>chmod -R 777 writable/</code> o <code>chown -R apache:apache writable/</code></small></p>";
echo "</div>";

// 3. Base de Datos
echo "<div class='card'><h2>3. Conexión a Base de Datos</h2>";
// Intentar leer configuración
$envFile = __DIR__ . '/.env';
$hasEnv = file_exists($envFile);
echo "<p>Archivo .env presente: " . badge($hasEnv, 'Sí', 'No (usando app/Config/Database.php)') . "</p>";

$host = 'localhost';
$user = 'root';
$pass = 'PIWIIB1234';
$db   = 'gim360';
$port = 3306;

if ($hasEnv) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $l) {
        $l = trim($l);
        if (preg_match('/^database\.default\.hostname\s*=\s*(.*)$/', $l, $m)) $host = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.username\s*=\s*(.*)$/', $l, $m)) $user = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.password\s*=\s*(.*)$/', $l, $m)) $pass = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.database\s*=\s*(.*)$/', $l, $m)) $db   = trim($m[1], " '\"");
        if (preg_match('/^database\.default\.port\s*=\s*(.*)$/', $l, $m))     $port = (int)trim($m[1], " '\"");
    }
}

echo "<table>";
echo "<tr><td>Host</td><td>{$host}:{$port}</td></tr>";
echo "<tr><td>Usuario</td><td>{$user}</td></tr>";
echo "<tr><td>Base de Datos</td><td>{$db}</td></tr>";

$conn = @new mysqli($host, $user, $pass, null, $port);
if ($conn->connect_error) {
    echo "<tr><td>Conexión al servidor MySQL</td><td>" . badge(false, '', 'Falló: ' . $conn->connect_error) . "</td></tr>";
} else {
    echo "<tr><td>Conexión al servidor MySQL</td><td>" . badge(true, 'Conectado exitosamente') . "</td></tr>";
    
    // Probar seleccionar BD
    $dbSelected = $conn->select_db($db);
    if (!$dbSelected) {
        echo "<tr><td>Seleccionar base '{$db}'</td><td>" . badge(false, '', "No existe la base de datos '{$db}'. Debes importarla: mysql -u {$user} -p -e 'CREATE DATABASE {$db};' &amp;&amp; mysql -u {$user} -p {$db} &lt; gim360.sql") . "</td></tr>";
    } else {
        $res = $conn->query("SHOW TABLES");
        $tableCount = $res ? $res->num_rows : 0;
        echo "<tr><td>Base de datos '{$db}'</td><td>" . badge($tableCount > 0, "OK ({$tableCount} tablas encontradas)", "Existe pero está vacía (0 tablas). Importa gim360.sql") . "</td></tr>";
    }
    $conn->close();
}
echo "</table></div>";

// 4. Últimos Errores en Logs de CodeIgniter
echo "<div class='card'><h2>4. Últimos Registros de Error en CodeIgniter (writable/logs)</h2>";
$logDir = __DIR__ . '/writable/logs';
$logFiles = glob($logDir . '/log-*.log');
if (empty($logFiles)) {
    echo "<p>No hay archivos de log generados aún en <code>writable/logs/</code>.</p>";
} else {
    // Tomar el más reciente
    rsort($logFiles);
    $latestLog = $logFiles[0];
    echo "<p>Archivo más reciente: <strong>" . basename($latestLog) . "</strong></p>";
    $content = file_get_contents($latestLog);
    $lines = explode("\n", trim($content));
    $lastLines = array_slice($lines, -30);
    echo "<pre>" . htmlspecialchars(implode("\n", $lastLines)) . "</pre>";
}
echo "</div>";

echo "</body></html>";
