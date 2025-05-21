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
    <title>Mamenchisaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Mamenchisaurus</h1>

<a href="../../../img/mamenchisaurus.jpg" target="_blank">
    <img src="../../../img/mamenchisaurus.jpg" alt="Mamenchisaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Mamenchisaurus</strong> proviene de "Mamenchi" (un lugar en China) y "sauros" (lagarto en griego), lo que significa "lagarto de Mamenchi". Este dinosaurio fue nombrado por el paleontólogo chino Dong en 1988.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Sauropoda</li>
    <li><strong>Familia:</strong> Mamenchisauridae</li>
    <li><strong>Género:</strong> Mamenchisaurus</li>
    <li><strong>Especie:</strong> M. constructus (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Tardío</strong>, hace aproximadamente <strong>160 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Los fósiles de Mamenchisaurus se han encontrado en:
<ul>
    <li>China, especialmente en la región de Sichuan</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 22 a 30 metros</li>
    <li><strong>Peso:</strong> Entre 20 y 30 toneladas</li>
    <li><strong>Forma del cuerpo:</strong> De gran tamaño, con cuello extremadamente largo y cuerpo robusto</li>
    <li><strong>Cuello:</strong> Inusualmente largo, compuesto por hasta 19 vértebras, lo que le permitió alcanzar la vegetación más alta</li>
    <li><strong>Cabeza:</strong> Relativamente pequeña en comparación con su largo cuello, con dientes en forma de cuchara para arrancar vegetación</li>
    <li><strong>Patas:</strong> Fuertes y gruesas, adaptadas para soportar el peso del cuerpo</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> que se alimentaba principalmente de plantas de alto crecimiento. Su cuello largo le permitía alimentarse de la vegetación más alta sin tener que moverse mucho.</p>

<h2>Comportamiento</h2>
<p>Se cree que el Mamenchisaurus vivía en grandes manadas, lo que le permitía protegerse de los depredadores. Su gran tamaño le daba una ventaja natural para defenderse de los carnívoros.</p>

<h2>Reproducción</h2>
<p>Como todos los sauropodos, el Mamenchisaurus se reproducía por medio de <strong>huevos</strong>. Los huevos probablemente eran puestos en nidos en el suelo.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Mamenchisaurus es famoso por su largo cuello, uno de los más largos de cualquier dinosaurio conocido.</li>
    <li>Sus fósiles fueron descubiertos en China, lo que lo convierte en un ejemplo importante de la fauna del Jurásico Tardío de Asia.</li>
    <li>Era uno de los sauropodos más grandes, tanto en longitud como en peso, lo que lo hacía muy impresionante en su ecosistema.</li>
    <li>Su tamaño y su cuello largo le permitieron acceder a una amplia variedad de vegetación, desde árboles hasta plantas bajas.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
