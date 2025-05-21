<?php
session_start();

// 🚨 Bloquear agentes vacíos o sospechosos
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
if (empty($user_agent) || preg_match('/(curl|wget|bot|spider|crawler)/i', $user_agent)) {
    http_response_code(403);
    exit('Acceso no permitido');
}

// 🧠 Validar IP (opcional: lista blanca o bloqueos)
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
if (!filter_var($ip, FILTER_VALIDATE_IP)) {
    http_response_code(400);
    exit('IP inválida');
}

// 🚫 Filtrar headers maliciosos
foreach (getallheaders() as $key => $value) {
    if (preg_match('/(base64|<script|data:|javascript:)/i', $value)) {
        http_response_code(403);
        exit('Header sospechoso');
    }
}

// 🧼 Limitar velocidad por sesión (rate limit)
$time = time();
if (!isset($_SESSION['last_request_time'])) {
    $_SESSION['last_request_time'] = $time;
    $_SESSION['request_count'] = 1;
} else {
    if ($time - $_SESSION['last_request_time'] < 5) {
        $_SESSION['request_count']++;
        if ($_SESSION['request_count'] > 10) {
            http_response_code(429); // Too Many Requests
            exit('Demasiadas solicitudes. Intenta más tarde.');
        }
    } else {
        $_SESSION['last_request_time'] = $time;
        $_SESSION['request_count'] = 1;
    }
}

// 🚫 Prevención XSS, Clickjacking, CSRF
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header("Referrer-Policy: no-referrer");

// 🔐 HSTS (HTTPS obligatorio, requiere HTTPS en servidor real)
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');

// 🧼 Función para limpiar datos
function limpiar_xss($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// 👮 Verificación de acceso
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIR - Aprendizaje en Ciberseguridad</title>
    <link rel="stylesheet" href="css/infor_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="matrix"></div> <!-- Fondo animado -->

    <!-- Botón Inicio -->
    <button class="inicio-btn"><a href="hackeo.php">Volver</a></button>

    <h1>Aprende ASIR</h1>

    <div class="section-container">
        <div class="section-box" onclick="location.href='sistemas_operativos.php'" style="cursor: pointer;">
            <h2>Sistemas Operativos</h2>
            <p>Domina Ubuntu y Windows aprendiendo a gestionar usuarios, permisos y redes. Explora Windows Server y DNS.</p>
        </div>
        <div class="section-box" onclick="location.href='desarrollo_web.php'" style="cursor: pointer;">
            <h2>Desarrollo Web</h2>
            <p>Construye páginas con PHP, CSS y JavaScript. Aprende a usar WordPress para crear sitios profesionales.</p>
        </div>
        <div class="section-box" onclick="location.href='base_datos.php'" style="cursor: pointer;">
            <h2>Bases de Datos</h2>
            <p>Administra datos con MySQL y MongoDB. Aprende sobre consultas, modelado y optimización de bases de datos.</p>
        </div>
    </div>

    <footer>
        <p> 2025 ASIR Academy - Ciberseguridad y Desarrollo</p>
    </footer>

    <script src="matrix.js"></script> <!-- Animación Matrix -->
</body>
</html>
