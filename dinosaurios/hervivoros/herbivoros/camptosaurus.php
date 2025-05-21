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
header("Referrer-Policy: no-referrer");
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Solo si usas HTTPS
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Camptosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Camptosaurus</h1>

<a href="../../../img/Camptosaurus.webp" target="_blank">
    <img src="../../../img/Camptosaurus.webp" alt="Camptosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Camptosaurus</strong> significa "lagarto doblado", en referencia a la forma arqueada de sus patas traseras, que le daban un aspecto peculiar.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Familia:</strong> Camptosauridae</li>
    <li><strong>Género:</strong> Camptosaurus</li>
    <li><strong>Especie:</strong> C. dispar (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Medio</strong>, hace aproximadamente <strong>168 a 161 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado en:
<ul>
    <li>Estados Unidos (Montana, Utah, Colorado)</li>
    <li>Portugal</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 6 metros</li>
    <li><strong>Peso:</strong> Alrededor de 1 tonelada</li>
    <li><strong>Cabeza:</strong> Pequeña en relación al cuerpo, con un pico herbívoro</li>
    <li><strong>Patas:</strong> Las traseras eran más largas que las delanteras, con un cuerpo que se mantenía erguido sobre ellas</li>
    <li><strong>Cola:</strong> Larga y rígida, probablemente usada para el equilibrio</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong>, alimentándose principalmente de plantas bajas, como helechos y plantas coníferas. Su pico estaba adaptado para arrancar vegetación.</p>

<h2>Comportamiento</h2>
<p>Probablemente vivía en pequeños grupos o manadas. Su tamaño relativamente pequeño lo hacía vulnerable a depredadores, pero su agilidad le ayudaba a escapar de los peligros.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, el Camptosaurus se reproducía por <strong>huevos</strong>, que probablemente ponía en nidos construidos en el suelo.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Es uno de los dinosaurios más primitivos dentro del grupo de los ornitischios.</li>
    <li>Sus patas traseras eran más fuertes que las delanteras, lo que le permitía moverse a gran velocidad.</li>
    <li>Se cree que vivió en un ambiente de sabanas y bosques.</li>
    <li>Fue uno de los primeros dinosaurios en presentar características de dinosaurios herbívoros de gran tamaño.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
