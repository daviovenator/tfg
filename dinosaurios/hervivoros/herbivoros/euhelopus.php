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
    <title>Euhelopus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Euhelopus</h1>

<a href="../../../img/euhelopus.jpg" target="_blank">
    <img src="../../../img/euhelopus.jpg" alt="Euhelopus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Euhelopus</strong> proviene del griego "eu" (bueno, verdadero) y "helops" (palo o tronco), lo que podría traducirse como "el verdadero tronco", en referencia a su cuerpo largo y su apariencia arbórea.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Sauropoda</li>
    <li><strong>Familia:</strong> Shunosauridae</li>
    <li><strong>Género:</strong> Euhelopus</li>
    <li><strong>Especie:</strong> E. zdanskyi (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Temprano</strong>, hace aproximadamente <strong>120 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles de Euhelopus en:
<ul>
    <li>China, especialmente en la región de Xinjiang</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 10 metros</li>
    <li><strong>Peso:</strong> Entre 5 y 7 toneladas</li>
    <li><strong>Forma del cuerpo:</strong> Cuerpo largo con un cuello extendido y una cola relativamente corta en comparación con otros sauropodos</li>
    <li><strong>Cabeza:</strong> Pequeña en proporción al cuerpo, con un pico que probablemente se usaba para arrancar vegetación</li>
    <li><strong>Cuello:</strong> Extraordinariamente largo y flexible, lo que le permitía alcanzar ramas altas de árboles</li>
    <li><strong>Patas:</strong> Robustas, adaptadas para soportar el peso del cuerpo</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong>, alimentándose principalmente de vegetación de alto crecimiento, como árboles y plantas bajas. Su largo cuello le permitía alcanzar los árboles más altos para alimentarse de sus hojas.</p>

<h2>Comportamiento</h2>
<p>Es probable que el Euhelopus haya sido un animal lento pero que se movía en grandes manadas, aunque su tamaño y peso lo hacían vulnerable a los depredadores. Su largo cuello le daba una ventaja para alcanzar una amplia variedad de vegetación.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, el Euhelopus se reproducía por medio de <strong>huevos</strong>, que probablemente eran depositados en nidos en el suelo o cerca de vegetación densa.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Euhelopus es uno de los primeros sauropodos conocidos en China, ayudando a entender la evolución de estos grandes herbívoros en Asia.</li>
    <li>Su cuello largo y su cuerpo pesado lo hacían muy diferente de otros sauropodos contemporáneos.</li>
    <li>Se cree que el Euhelopus pudo haber migrado a través de grandes distancias, lo que le permitió encontrar nuevos territorios ricos en vegetación.</li>
    <li>La pequeña cabeza del Euhelopus, comparada con su cuerpo, lo hacía parecer un animal algo torpe, pero su largo cuello le ayudaba a alcanzar la comida de manera eficiente.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
