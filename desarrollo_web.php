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
    <title>Desarrollo Web - Temas de ASIR</title>
    <link rel="stylesheet" href="css/desarrollo_style.css"> <!-- Link al CSS profesional -->
</head>
<body>
    <!-- Contenedor principal para centrar contenido -->
    <div class="container">
        <!-- Botón de "Atrás" -->
        <button class="inicio-btn" onclick="window.history.back();">Atrás</button>

        <!-- Título de la página -->
        <h1>Desarrollo Web</h1>

        <!-- Sección de información sobre Desarrollo Web -->
        <div class="section-container">
            <!-- Cuadro 1: Introducción al Desarrollo Web -->
            <div class="section-box">
                <h2>¿Qué es el Desarrollo Web?</h2>
                <p>El desarrollo web es el proceso de crear y mantener sitios web. Se encarga de todos los aspectos relacionados con el desarrollo de un sitio web, desde el diseño visual hasta la programación del backend y la implementación de bases de datos.</p>
                <p>Existen varias tecnologías utilizadas en desarrollo web, tales como HTML, CSS, JavaScript, y frameworks como React o Angular para el frontend, y lenguajes como PHP, Python o Node.js para el backend.</p>
            </div>

            <!-- Cuadro 2: Lenguajes y Herramientas -->
            <div class="section-box">
                <h2>Lenguajes y Herramientas</h2>
                <ul>
                    <li><strong>HTML:</strong> El lenguaje de marcado para estructurar contenido en la web.</li>
                    <li><strong>CSS:</strong> El lenguaje utilizado para diseñar y maquetar las páginas web.</li>
                    <li><strong>JavaScript:</strong> El lenguaje de programación para hacer que las páginas web sean interactivas.</li>
                    <li><strong>PHP:</strong> Un lenguaje de programación del lado del servidor utilizado para gestionar bases de datos.</li>
                    <li><strong>Frameworks:</strong> Herramientas como React, Angular o Vue.js que facilitan el desarrollo de aplicaciones web modernas.</li>
                </ul>
            </div>
        </div>

        <!-- Pie de página con información adicional -->
        <footer>
            <p>© 2025 ASIR - Todos los derechos reservados.</p>
        </footer>
    </div>

    <!-- Aquí puedes añadir scripts adicionales si es necesario -->
</body>
</html>

