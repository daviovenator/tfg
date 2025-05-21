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
    <title>Anomalocaris - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Anomalocaris</h1>

<a href="../../../img/Anomalocaris.avif" target="_blank">
    <img src="../../../img/Anomalocaris.avif" alt="Anomalocaris" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Anomalocaris</strong> significa "gamba anómala" debido a sus extrañas características físicas, como sus grandes ojos y su cuerpo segmentado. El nombre proviene del griego "anomalos" (anómalo) y "karis" (gamba).</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Arthropoda</li>
    <li><strong>Clase:</strong> Malacostraca</li>
    <li><strong>Orden:</strong> Anomalocaridida</li>
    <li><strong>Familia:</strong> Anomalocarididae</li>
    <li><strong>Género:</strong> Anomalocaris</li>
    <li><strong>Especie:</strong> A. canadensis (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cámbrico</strong>, hace aproximadamente <strong>520 a 485 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus restos se han encontrado en:
<ul>
    <li>Canadá</li>
    <li>Estados Unidos</li>
    <li>China</li>
    <li>Australia</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 1.5 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 10 kg</li>
    <li><strong>Distintivo:</strong> Gran tamaño, ojos compuestos y cuerpo segmentado</li>
    <li><strong>Mandíbulas:</strong> Grandes y con dientes, utilizadas para capturar presas</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>depredador</strong> que cazaba trilobites y otros pequeños invertebrados marinos. Sus mandíbulas eran extremadamente fuertes y eficaces para atrapar a sus presas.</p>

<h2>Comportamiento</h2>
<p>Se cree que Anomalocaris era un cazador activo, capaz de nadar rápidamente para capturar sus presas. Su cuerpo segmentado le proporcionaba flexibilidad y velocidad en el agua.</p>

<h2>Reproducción</h2>
<p>Como otros artrópodos, se reproducía por medio de huevos. Los detalles sobre su comportamiento reproductivo son limitados debido a la falta de fósiles de nidos.</p>

<h2>Descubrimiento</h2>
<p>Fue descubierto a finales del siglo XIX, aunque se pensaba inicialmente que sus restos pertenecían a varios organismos diferentes debido a su extraño aspecto.</p>

<h2>Relación con otros organismos</h2>
<p>El Anomalocaris es uno de los más famosos de los artrópodos primitivos, y su estructura refleja la complejidad de la vida en los mares del Cámbrico. Estaba relacionado con otros organismos marinos primitivos.</p>

<h2>Importancia cultural</h2>
<p>Aunque no tan conocido como otros animales prehistóricos, Anomalocaris ha sido un tema interesante en paleontología y ha aparecido en varios documentales sobre la fauna del Cámbrico.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Fue uno de los depredadores más grandes de su época.</li>
    <li>Sus ojos eran unos de los más complejos del reino animal en el Cámbrico.</li>
    <li>Se pensaba que Anomalocaris estaba relacionado con los modernos camarones, pero su anatomía era muy distinta.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
