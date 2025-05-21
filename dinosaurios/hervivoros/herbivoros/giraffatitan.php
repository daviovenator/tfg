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
    <title>Giraffatitan - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Giraffatitan</h1>

<a href="../../../img/giraffatitan.jpg" target="_blank">
    <img src="../../../img/giraffatitan.jpg" alt="Giraffatitan" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Giraffatitan</strong> proviene de "giraffa" (jirafa en latín) y "titan" (titan en griego), debido a su largo cuello que recuerda a una jirafa moderna. Fue nombrado por el paleontólogo <strong>Walter J. Janensch</strong> en 1914.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Sauropoda</li>
    <li><strong>Familia:</strong> Brachiosauridae</li>
    <li><strong>Género:</strong> Giraffatitan</li>
    <li><strong>Especie:</strong> G. brancai</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Temprano</strong>, hace aproximadamente <strong>154 a 153 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles de Giraffatitan en:
<ul>
    <li>Tanzania, en la región de Tendaguru</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 22 metros</li>
    <li><strong>Peso:</strong> Entre 30 y 40 toneladas</li>
    <li><strong>Forma del cuerpo:</strong> De gran tamaño, con un cuello extremadamente largo y una postura erguida similar a la de los braquiosaurios</li>
    <li><strong>Cuello:</strong> Inusualmente largo, permitiéndole alcanzar vegetación a gran altura, lo que lo hace similar a una jirafa moderna en cuanto a alimentación</li>
    <li><strong>Cabeza:</strong> Relativamente pequeña en comparación con el tamaño de su cuerpo, adaptada a su dieta herbívora</li>
    <li><strong>Patas:</strong> Robustas y fuertes, con los miembros delanteros más largos que los traseros, algo característico de los braquiosaurios</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> que se alimentaba principalmente de las copas de los árboles, utilizando su cuello largo para acceder a una variedad de plantas y vegetación alta.</p>

<h2>Comportamiento</h2>
<p>El Giraffatitan probablemente se desplazaba en manadas para protegerse de depredadores. Aunque no era el dinosaurio más rápido, su enorme tamaño y su postura erguida le proporcionaban una ventaja para alimentarse de vegetación inaccesible para otros herbívoros.</p>

<h2>Reproducción</h2>
<p>Como todos los sauropodos, el Giraffatitan se reproducía por medio de <strong>huevos</strong>. Se cree que sus crías nacían en el suelo, y se desarrollaban rápidamente para alcanzar el tamaño de los adultos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Giraffatitan es a menudo confundido con el Brachiosaurus debido a las similitudes en su cuerpo, pero en realidad son dos géneros distintos.</li>
    <li>Su cuello largo y sus patas delanteras más largas que las traseras lo hacían parecerse a una jirafa, pero mucho más masivo.</li>
    <li>El Giraffatitan vivió en lo que ahora es África, lo que lo convierte en un ejemplo importante de la fauna del Cretácico Temprano en ese continente.</li>
    <li>Era uno de los animales más grandes de su tiempo, y se cree que su tamaño lo hacía inmune a los depredadores de su época.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
