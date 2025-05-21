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
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; frame-ancestors 'none'; object-src 'none'; base-uri 'self';");
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
    <title>Cyber Crime - Hacking the Pentagon</title>
    <link rel="stylesheet" href="css/hackeo_style.css">

    <!-- Meta headers extra seguros -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
</head>
<body>

    <div id="matrix"></div> <!-- Fondo de Matrix -->

    <div class="botones-superiores">
        <a href="hackeo.php" class="inicio-btn">Inicio</a>
        <a href="index.php" class="salir-btn">Salir</a>
    </div>

    <!-- Menú desplegable -->
    <div class="dropdown">
        <button class="dropbtn">Expándeme</button>
        <div class="dropdown-content">
            <a href="infor.php">Asir</a>
            <a href="virus_list.php">Listado virus</a>
            <a href="email.php">Email</a>
            <a href="osint.php">OSINT</a>
            <a href="links.php">Links</a>
            <a href="3D.php">3D</a>
            <a href="wiki_espace.php">Wiki Space</a>
            <a href="juegos.php">Juegos</a>
            <a href="peliculas.php">Películas</a>
        </div>
    </div>

    <h1>Bienvenido</h1>
    <p>Bienvenidos a la parte interesante de toda la página</p>

    <div class="text-box">
        <p>Bienvenidos a nuestra página variada! Aquí encontrareis unos cuantos link en el apartado "Expándeme", en el cual podrás interactuar y probar las diversas funciones. </p>
        <p>Cada apartado tiene una función exclusiva, ya sea descargar archivos, mandar mails anónimos o incluso ver una simulación de nuestro propio sistema solar.</p>
        <p>¿Por qué hay tantos fondos sobre la naturaleza te preguntarás? Son fondos que le dan un toque relajante y bueno de ver. A mucha gente le encanta la naturaleza.</p>
        <p>Esta página creada a partir de docker emplea los siguientes lenguajes:</p>
        <p>HTML/CSS</p>
        <p>JS</p>
        <p>PHP</p>
    </div>

    <script src="matrix.js"></script> <!-- Efecto de Matrix -->
</body>
</html>
