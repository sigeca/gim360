<?php
// Configuración básica del archivo APK
$apkFilename = 'gim360.apk';
$apkPath = __DIR__ . '/' . $apkFilename;

// Si se solicita la descarga directa (?download=1)
if (isset($_GET['download']) && $_GET['download'] === '1') {
    if (file_exists($apkPath)) {
        // Limpiar buffers para evitar archivos corruptos
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        $filesize = filesize($apkPath);
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.android.package-archive');
        header('Content-Disposition: attachment; filename="' . $apkFilename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $filesize);
        header('Accept-Ranges: bytes');
        
        // Manejo eficiente de lectura en fragmentos para archivos de ~60MB
        $handle = fopen($apkPath, 'rb');
        if ($handle) {
            while (!feof($handle) && connection_status() == 0) {
                echo fread($handle, 1024 * 64);
                flush();
            }
            fclose($handle);
        } else {
            readfile($apkPath);
        }
        exit;
    } else {
        http_response_code(404);
        die('Error: El archivo APK no se encuentra en el servidor.');
    }
}

// Metadatos dinámicos
$fileExists = file_exists($apkPath);
$fileSizeFormatted = '57.1 MB';
$lastModified = date('d/m/Y');
$sha256Hash = 'Calculando...';

if ($fileExists) {
    $bytes = filesize($apkPath);
    $fileSizeFormatted = number_format($bytes / (1024 * 1024), 2) . ' MB';
    
    // Meses en español
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $mTime = filemtime($apkPath);
    $mesNum = (int)date('n', $mTime) - 1;
    $lastModified = date('d', $mTime) . ' de ' . $meses[$mesNum] . ', ' . date('Y', $mTime);
    
    // Hash SHA-256
    $sha256Hash = hash_file('sha256', $apkPath);
}

// Construcción de la URL de descarga para el código QR
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);
$protocol = $isHttps ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$requestUri = $_SERVER['REQUEST_URI'] ?? '/gim360/apk/index.php';
$currentDir = rtrim(dirname($requestUri), '/\\');
$downloadUrl = $protocol . $host . ($currentDir ? $currentDir : '') . '/' . $apkFilename;
$qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&margin=10&data=' . urlencode($downloadUrl);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Descargar GIM360 para Android (APK Oficial)</title>
    <meta name="description" content="Descarga oficial de la aplicación GIM360 para smartphones Android. Guía paso a paso para instalar el archivo APK de forma segura.">
    <meta name="theme-color" content="#0b1120">
    <link rel="icon" type="image/png" href="logo.png">

    <style>
        :root {
            --bg-body: #090d16;
            --bg-card: rgba(18, 26, 43, 0.85);
            --bg-card-hover: rgba(26, 37, 60, 0.95);
            --border-card: rgba(255, 255, 255, 0.08);
            --border-focus: rgba(249, 115, 22, 0.5);
            --accent-orange: #f97316;
            --accent-orange-hover: #ea580c;
            --accent-glow: rgba(249, 115, 22, 0.35);
            --accent-green: #10b981;
            --accent-cyan: #06b6d4;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-sub: #cbd5e1;
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 8px;
            --shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.7);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(249, 115, 22, 0.12) 0%, transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(6, 182, 212, 0.09) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(15, 23, 42, 0.7) 0%, transparent 100%);
            background-attachment: fixed;
            padding: 24px 16px 60px 16px;
        }

        .container {
            max-width: 860px;
            margin: 0 auto;
        }

        /* Header / Logo */
        header {
            text-align: center;
            padding: 20px 0 30px 0;
        }

        .logo-wrap {
            position: relative;
            display: inline-block;
            margin-bottom: 16px;
        }

        .logo-img {
            width: 104px;
            height: 104px;
            border-radius: 26px;
            object-fit: cover;
            box-shadow: 0 0 35px var(--accent-glow), 0 8px 24px rgba(0, 0, 0, 0.6);
            border: 2px solid rgba(249, 115, 22, 0.4);
            display: block;
            margin: 0 auto;
            background: #1e293b;
        }

        .android-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(16, 185, 129, 0.12);
            color: var(--accent-green);
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 4px 14px;
            border-radius: 9999px;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        h1 {
            font-size: clamp(2rem, 5vw, 2.75rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff 30%, #f97316 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 1.05rem;
            color: var(--text-muted);
            max-width: 580px;
            margin: 0 auto 24px auto;
        }

        /* Hero Card */
        .hero-card {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-card);
            border-radius: var(--radius-lg);
            padding: 32px 24px;
            box-shadow: var(--shadow);
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--accent-orange), transparent);
        }

        /* Meta tags badges */
        .meta-badges {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .badge-pill {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-card);
            padding: 6px 14px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            color: var(--text-sub);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-pill strong {
            color: var(--text-main);
        }

        /* Download Primary Button */
        .btn-download {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #ffffff;
            font-size: 1.15rem;
            font-weight: 700;
            padding: 18px 38px;
            border-radius: 9999px;
            text-decoration: none;
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.5), 0 0 15px rgba(249, 115, 22, 0.3);
            transition: all 0.25s ease;
            cursor: pointer;
            border: none;
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px -4px rgba(249, 115, 22, 0.65), 0 0 20px rgba(249, 115, 22, 0.4);
            background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
        }

        .btn-download:active {
            transform: translateY(1px);
        }

        .btn-download svg {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .btn-download:hover svg {
            transform: translateY(2px);
        }

        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--accent-green);
            margin-top: 16px;
            font-weight: 500;
        }

        .security-badge svg {
            width: 16px;
            height: 16px;
        }

        /* Actions Grid (QR + Details) */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (min-width: 720px) {
            .grid-2 {
                grid-template-columns: 1.1fr 0.9fr;
            }
        }

        .card {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-card);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow);
            transition: border-color 0.2s ease;
        }

        .card:hover {
            border-color: rgba(255, 255, 255, 0.15);
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-main);
        }

        .card-title svg {
            width: 20px;
            height: 20px;
            color: var(--accent-orange);
        }

        /* QR Section */
        .qr-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .qr-frame {
            background: #ffffff;
            padding: 12px;
            border-radius: var(--radius-md);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            margin: 10px 0 14px 0;
            display: inline-block;
        }

        .qr-frame img {
            width: 170px;
            height: 170px;
            display: block;
            border-radius: 6px;
        }

        .qr-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            max-width: 260px;
        }

        /* Tech specs list */
        .spec-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .spec-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.88rem;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .spec-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .spec-label {
            color: var(--text-muted);
        }

        .spec-val {
            font-weight: 600;
            color: var(--text-sub);
            text-align: right;
        }

        .hash-code {
            font-family: monospace;
            background: rgba(0, 0, 0, 0.4);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.78rem;
            max-width: 140px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
            vertical-align: middle;
            color: var(--accent-cyan);
            cursor: pointer;
        }

        /* Guide / Steps */
        .section-header {
            text-align: center;
            margin: 35px 0 24px 0;
        }

        .section-header h2 {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .section-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .steps-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 30px;
        }

        .step-card {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: var(--radius-md);
            padding: 20px;
            display: flex;
            gap: 18px;
            align-items: flex-start;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .step-card:hover {
            transform: translateX(4px);
            border-color: rgba(249, 115, 22, 0.4);
        }

        .step-num {
            background: linear-gradient(135deg, var(--accent-orange), #ea580c);
            color: #ffffff;
            font-weight: 800;
            font-size: 1.1rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
        }

        .step-content h3 {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: #ffffff;
        }

        .step-content p {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .step-highlight {
            background: rgba(249, 115, 22, 0.1);
            border-left: 3px solid var(--accent-orange);
            padding: 8px 12px;
            border-radius: 0 6px 6px 0;
            margin-top: 10px;
            font-size: 0.84rem;
            color: #fdba74;
        }

        /* Notice banner */
        .notice-card {
            background: rgba(6, 182, 212, 0.08);
            border: 1px solid rgba(6, 182, 212, 0.25);
            border-radius: var(--radius-md);
            padding: 16px 20px;
            margin-bottom: 30px;
            display: flex;
            gap: 14px;
            align-items: center;
        }

        .notice-card svg {
            width: 28px;
            height: 28px;
            color: var(--accent-cyan);
            flex-shrink: 0;
        }

        .notice-card p {
            font-size: 0.88rem;
            color: #bae6fd;
        }

        /* Brand tips accordion */
        .brands-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 14px;
            margin-top: 14px;
        }

        .brand-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            font-size: 0.84rem;
        }

        .brand-item strong {
            display: block;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .brand-item span {
            color: var(--text-muted);
        }

        /* FAQ Section */
        .faq-item {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: var(--radius-md);
            margin-bottom: 12px;
            overflow: hidden;
        }

        .faq-question {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            padding: 18px 20px;
            color: var(--text-main);
            font-size: 0.98rem;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .faq-question svg {
            width: 18px;
            height: 18px;
            color: var(--accent-orange);
            transition: transform 0.25s ease;
            flex-shrink: 0;
        }

        .faq-item.active .faq-question svg {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            padding: 0 20px;
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .faq-item.active .faq-answer {
            max-height: 250px;
            padding: 0 20px 18px 20px;
        }

        /* Footer */
        footer {
            text-align: center;
            padding-top: 40px;
            color: var(--text-muted);
            font-size: 0.85rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            margin-top: 40px;
        }

        footer a {
            color: var(--accent-orange);
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Toast notification */
        #toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #1e293b;
            color: #ffffff;
            border: 1px solid rgba(249, 115, 22, 0.5);
            padding: 12px 24px;
            border-radius: 9999px;
            font-size: 0.88rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            pointer-events: none;
        }

        #toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Header Principal -->
    <header>
        <div class="logo-wrap">
            <img src="logo.png" alt="Logo GIM360" class="logo-img" onerror="this.src='../gim360.png';">
        </div>
        <div>
            <div class="android-badge">
                <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                    <path d="M17.523 15.3414c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.551 0 .9993.4482.9993.9993.0001.5511-.4483.9997-.9993.9997m-11.046 0c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.5511 0 .9993.4482.9993.9993 0 .5511-.4482.9997-.9993.9997m11.4045-6.02l1.9973-3.4592a.416.416 0 00-.1521-.5676.416.416 0 00-.5676.1521l-2.0223 3.503C15.5902 8.414 13.8533 8.125 12 8.125c-1.8533 0-3.5902.289-5.1368.8247L4.8409 5.4467a.4161.4161 0 00-.5677-.1521.4157.4157 0 00-.152 5676l1.9973 3.4592C2.6889 11.1867.3432 14.6589 0 18.7844h24c-.3432-4.1255-2.6889-7.5977-6.1185-9.463"/>
                </svg>
                Android APK Oficial
            </div>
        </div>
        <h1>GIM360 Móvil</h1>
        <p class="subtitle">Gestiona tus entrenamientos, rutinas, planes de nutrición y seguimiento físico directamente desde tu smartphone Android.</p>
    </header>

    <!-- Tarjeta de Descarga Principal -->
    <div class="hero-card">
        <div class="meta-badges">
            <div class="badge-pill">
                <span>Versión:</span> <strong>1.0.0</strong>
            </div>
            <div class="badge-pill">
                <span>Tamaño:</span> <strong><?= $fileSizeFormatted ?></strong>
            </div>
            <div class="badge-pill">
                <span>Actualizado:</span> <strong><?= $lastModified ?></strong>
            </div>
            <div class="badge-pill">
                <span>Requisito:</span> <strong>Android 6.0+</strong>
            </div>
        </div>

        <a href="gim360.apk" class="btn-download" download="gim360.apk" id="mainDownloadBtn">
            <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Descargar APK (<?= $fileSizeFormatted ?>)
        </a>

        <div class="security-badge">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Archivo 100% libre de virus y malware • Paquete Oficial Verificado
        </div>
    </div>

    <!-- Sección de Código QR y Ficha Técnica -->
    <div class="grid-2">
        <!-- Código QR -->
        <div class="card qr-box">
            <div class="card-title">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                Instalar desde tu Smartphone
            </div>
            <p class="qr-desc">¿Estás en la computadora? Apunta la cámara de tu celular a este código QR para descargarlo al instante:</p>
            <div class="qr-frame">
                <img src="<?= htmlspecialchars($qrUrl) ?>" alt="Código QR para descargar GIM360 APK" loading="lazy">
            </div>
            <p class="qr-desc" style="font-size: 0.78rem;">También puedes compartir el enlace directo con tus compañeros del gimnasio.</p>
        </div>

        <!-- Ficha Técnica -->
        <div class="card">
            <div class="card-title">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                </svg>
                Detalles del Paquete
            </div>
            <ul class="spec-list">
                <li class="spec-item">
                    <span class="spec-label">Nombre del archivo:</span>
                    <span class="spec-val"><?= htmlspecialchars($apkFilename) ?></span>
                </li>
                <li class="spec-item">
                    <span class="spec-label">Paquete:</span>
                    <span class="spec-val">com.example.gim360</span>
                </li>
                <li class="spec-item">
                    <span class="spec-label">Versión actual:</span>
                    <span class="spec-val">1.0.0 (Release)</span>
                </li>
                <li class="spec-item">
                    <span class="spec-label">Compatibilidad:</span>
                    <span class="spec-val">Android 6.0 hasta Android 15</span>
                </li>
                <li class="spec-item">
                    <span class="spec-label">Arquitectura:</span>
                    <span class="spec-val">arm64-v8a, armeabi-v7a, x86_64</span>
                </li>
                <li class="spec-item">
                    <span class="spec-label">Checksum SHA-256:</span>
                    <span class="spec-val">
                        <span class="hash-code" id="shaHash" title="Toca para copiar el Hash SHA-256 completo"><?= substr($sha256Hash, 0, 12) ?>...</span>
                    </span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Guía Paso a Paso para Instalar en Android -->
    <div class="section-header">
        <h2>¿Cómo instalar GIM360 en tu teléfono?</h2>
        <p>Sigue estos 4 sencillos pasos para instalar el archivo APK en cualquier teléfono Android:</p>
    </div>

    <div class="steps-container">
        <!-- Paso 1 -->
        <div class="step-card">
            <div class="step-num">1</div>
            <div class="step-content">
                <h3>Descarga el archivo APK</h3>
                <p>Pulsa el botón naranja <strong>"Descargar APK"</strong> arriba. Tu navegador comenzará a descargar el archivo <code>gim360.apk</code>.</p>
                <div class="step-highlight">
                    ⚠️ <strong>Si te aparece:</strong> "¿Quieres descargar este archivo potencialmente dañino?", no te preocupes, es el mensaje estándar de Android para descargas fuera de Google Play. Toca en <strong>"Descargar de todos modos"</strong>.
                </div>
            </div>
        </div>

        <!-- Paso 2 -->
        <div class="step-card">
            <div class="step-num">2</div>
            <div class="step-content">
                <h3>Abre el archivo descargado</h3>
                <p>Cuando finalice la descarga, desliza la barra de notificaciones y toca en <strong>"gim360.apk"</strong> o ve a la carpeta <strong>Descargas</strong> en tu administrador de archivos.</p>
            </div>
        </div>

        <!-- Paso 3 -->
        <div class="step-card">
            <div class="step-num">3</div>
            <div class="step-content">
                <h3>Permite "Instalar aplicaciones desconocidas"</h3>
                <p>Si es la primera vez que instalas una app descargada desde el navegador, Android te pedirá un permiso de seguridad rápido.</p>
                <div class="step-highlight">
                    💡 Toca en <strong>Ajustes / Configuración</strong> en el aviso que aparece y activa la casilla <strong>"Confiar en esta fuente"</strong> o <strong>"Permitir desde esta fuente"</strong>. Luego regresa atrás.
                </div>
            </div>
        </div>

        <!-- Paso 4 -->
        <div class="step-card">
            <div class="step-num">4</div>
            <div class="step-content">
                <h3>Toca en "Instalar" y ¡a entrenar!</h3>
                <p>Confirma tocando el botón <strong>"Instalar"</strong>. En pocos segundos la app estará lista en tu menú de aplicaciones con el ícono de GIM360.</p>
            </div>
        </div>
    </div>

    <!-- Consejos específicos por fabricante -->
    <div class="card" style="margin-bottom: 30px;">
        <div class="card-title">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            Ubicación de "Orígenes desconocidos" según tu marca de celular
        </div>
        <div class="brands-grid">
            <div class="brand-item">
                <strong>Samsung (One UI)</strong>
                <span>Ajustes &gt; Seguridad y privacidad &gt; Instalar apps desconocidas &gt; Selecciona Chrome &gt; Activar.</span>
            </div>
            <div class="brand-item">
                <strong>Xiaomi / Redmi / POCO</strong>
                <span>Ajustes &gt; Protección de la privacidad &gt; Permisos especiales &gt; Instalar aplicaciones desconocidas.</span>
            </div>
            <div class="brand-item">
                <strong>Motorola / Google Pixel</strong>
                <span>Ajustes &gt; Apps &gt; Acceso especial de apps &gt; Instalar aplicaciones desconocidas &gt; Permitir.</span>
            </div>
            <div class="brand-item">
                <strong>Huawei / Honor</strong>
                <span>Ajustes &gt; Seguridad &gt; Ajustes adicionales &gt; Instalar aplicaciones de fuentes externas.</span>
            </div>
        </div>
    </div>

    <!-- Preguntas Frecuentes (FAQ) -->
    <div class="section-header">
        <h2>Preguntas Frecuentes</h2>
        <p>Aclaraciones y dudas comunes sobre la instalación del APK</p>
    </div>

    <div class="faq-item">
        <button class="faq-question">
            <span>¿Es seguro instalar este archivo APK en mi teléfono?</span>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div class="faq-answer">
            Totalmente seguro. Este archivo APK es compilado y servido directamente desde el servidor oficial de GIM360. No contiene publicidad invasiva ni software espía. El aviso de Android es una advertencia estándar que se muestra con cualquier archivo APK descargado fuera de Google Play Store.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">
            <span>¿Por qué me dice "No se puede abrir el archivo"?</span>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div class="faq-answer">
            Esto sucede a veces cuando la descarga no ha terminado por completo o cuando el visor del navegador no asocia la extensión .apk. Abre la aplicación "Mis Archivos" o "Archivos" de tu teléfono, ingresa a la carpeta <strong>Descargas</strong> y pulsa directamente sobre <code>gim360.apk</code>.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">
            <span>¿Cómo se actualizará la aplicación en el futuro?</span>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div class="faq-answer">
            Cuando esté disponible una nueva versión, simplemente vuelve a ingresar a esta misma página web y descarga la nueva versión. Al instalarla sobre la anterior, tus datos y sesión se conservarán intactos sin necesidad de desinstalar.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">
            <span>¿Necesito conexión a internet para usar la app?</span>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div class="faq-answer">
            Sí, la aplicación se comunica en tiempo real con la base de datos de GIM360 para sincronizar tus rutinas, asistencias, ejercicios y planes de alimentación asignados por tu entrenador.
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?= date('Y') ?> <strong>GIM360</strong> - Sistema de Gestión de Gimnasio. Todos los derechos reservados.</p>
        <p style="margin-top: 6px;">
            <a href="../public/">Acceder al Portal Web GIM360</a> &bull; 
            <a href="index.php?download=1">Descarga Directa Alternativa</a>
        </p>
    </footer>

</div>

<!-- Toast -->
<div id="toast">Copiado al portapapeles</div>

<script>
    // FAQ Accordion
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.parentElement;
            item.classList.toggle('active');
        });
    });

    // Copiar SHA-256
    const hashEl = document.getElementById('shaHash');
    const fullHash = "<?= $sha256Hash ?>";
    const toast = document.getElementById('toast');

    if (hashEl) {
        hashEl.addEventListener('click', () => {
            navigator.clipboard.writeText(fullHash).then(() => {
                toast.textContent = "Hash SHA-256 copiado";
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2500);
            }).catch(() => {
                prompt("Hash SHA-256:", fullHash);
            });
        });
    }

    // Efecto de feedback al presionar descarga
    const dlBtn = document.getElementById('mainDownloadBtn');
    if (dlBtn) {
        dlBtn.addEventListener('click', () => {
            toast.textContent = "Iniciando descarga de gim360.apk...";
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3500);
        });
    }
</script>

</body>
</html>
