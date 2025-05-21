<?php
session_start();

// 🚨 Bloqueo de agentes vacíos o sospechosos
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
if (empty($user_agent) || preg_match('/(curl|wget|bot|spider|crawler|httpclient|python|java|libwww)/i', $user_agent)) {
    http_response_code(403);
    exit('Acceso no permitido');
}

// 🧠 Validación básica de IP
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
if (!filter_var($ip, FILTER_VALIDATE_IP)) {
    http_response_code(400);
    exit('IP inválida');
}

// 🚫 Filtrado de headers con patrones peligrosos
foreach (getallheaders() as $key => $value) {
    if (preg_match('/(base64|<script|data:|javascript:)/i', $value)) {
        http_response_code(403);
        exit('Header sospechoso');
    }
}

// 🧼 Rate limit por sesión
$now = time();
if (!isset($_SESSION['rate_limit'])) {
    $_SESSION['rate_limit'] = ['last' => $now, 'count' => 1];
} else {
    if ($now - $_SESSION['rate_limit']['last'] < 5) {
        $_SESSION['rate_limit']['count']++;
        if ($_SESSION['rate_limit']['count'] > 10) {
            http_response_code(429); // Too Many Requests
            exit('Demasiadas solicitudes. Intenta más tarde.');
        }
    } else {
        $_SESSION['rate_limit'] = ['last' => $now, 'count' => 1];
    }
}

// 👮 Verificación de acceso
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// 🔐 Encabezados de protección
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; object-src 'none'; frame-ancestors 'none'; base-uri 'self';");
header("Referrer-Policy: no-referrer");
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Solo si usas HTTPS
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cyber Crime - Hacking the Pentagon</title>
	<link rel="stylesheet" href="css/juegos_style.css"> <!-- Enlace al nuevo CSS -->
</head>
<body>
	<div id="matrix"></div> <!-- Fondo de Matrix -->

	<!-- Cuadro con los botones -->
	<div class="button-container">
    	<h2>Salón de Juegos</h2>

    <!-- Contenedor de botones arriba a la izquierda -->
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

    	<button class="sistema-btn"><a href="snake.html">Snake</a></button> <!-- Aquí se cambió el enlace a snake.html -->
        <button class="personaje-btn"><a href="vaso.html">Juego del Vaso</a></button> <!-- Aquí se cambió el enlace a snake.html -->
	</div>
</body>
</html>
