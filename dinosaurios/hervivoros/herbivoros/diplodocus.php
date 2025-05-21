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
    <title>Diplodocus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Diplodocus</h1>

<a href="../../../img/Diplodocus.jpg" target="_blank">
    <img src="../../../img/Diplodocus.jpg" alt="Diplodocus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Diplodocus</strong> proviene del griego "diplos" (doble) y "dokos" (viga), refiriéndose a la forma de las vértebras de su cola, que eran inusualmente alargadas y tenían un aspecto doble.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Sauropoda</li>
    <li><strong>Familia:</strong> Diplodocidae</li>
    <li><strong>Género:</strong> Diplodocus</li>
    <li><strong>Especie:</strong> D. longus (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Tardío</strong>, hace aproximadamente <strong>154 a 152 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles de Diplodocus en:
<ul>
    <li>Estados Unidos (en la Formación Morrison de Colorado, Wyoming y Utah)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 27 metros</li>
    <li><strong>Peso:</strong> Alrededor de 12 a 16 toneladas</li>
    <li><strong>Cabeza:</strong> Pequeña en proporción a su cuerpo, con un largo cuello</li>
    <li><strong>Cuerpo:</strong> Largo y delgado con una cola igualmente larga que le ayudaba a equilibrar su cuerpo</li>
    <li><strong>Cola:</strong> Extensa y fuerte, probablemente utilizada para defenderse o para mantener el equilibrio mientras se alimentaba de las copas de los árboles</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> que se alimentaba principalmente de plantas bajas y hojas de árboles, que alcanzaba con su largo cuello. También se alimentaba de helechos, cícadas y coníferas.</p>

<h2>Comportamiento</h2>
<p>El Diplodocus vivía en grandes manadas, lo que le ayudaba a protegerse de depredadores. Su tamaño y cola larga le permitían mantener el equilibrio mientras se alimentaba y moverse con relativa agilidad para un dinosaurio de su tamaño.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, el Diplodocus se reproducía por <strong>huevos</strong>, que probablemente eran depositados en nidos en zonas protegidas.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Diplodocus es uno de los dinosaurios más grandes conocidos, con una longitud de hasta 27 metros.</li>
    <li>Su larga cola probablemente tenía un papel importante en la defensa contra depredadores, ya que podría haber sido usada como un látigo.</li>
    <li>A pesar de su tamaño, el Diplodocus tenía un cuello sorprendentemente largo, lo que le permitía alcanzar vegetación a gran altura.</li>
    <li>Estudios sugieren que este dinosaurio era capaz de mover su cuello en todas direcciones, lo que le permitía acceder a una amplia variedad de plantas.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
