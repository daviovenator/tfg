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
    <title>Sarcosuchus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Sarcosuchus</h1>

<a href="../../../img/Sarcosuchus.webp" target="_blank">
    <img src="../../../img/Sarcosuchus.webp" alt="Sarcosuchus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Sarcosuchus</strong> significa "cocodrilo de carne", en referencia a su dieta carnívora y gran tamaño. El nombre proviene del griego "sarx" (carne) y "soukhos" (cocodrilo).</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Crocodyliformes</li>
    <li><strong>Familia:</strong> Pholidosauridae</li>
    <li><strong>Género:</strong> Sarcosuchus</li>
    <li><strong>Especie:</strong> S. imperator</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Inferior</strong>, hace aproximadamente <strong>133 a 112 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles han sido hallados en el norte de África, principalmente en Níger y otros países cercanos del Sahara.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 12 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 8 toneladas</li>
    <li><strong>Mandíbulas:</strong> Largas y llenas de dientes cónicos, similares a los de los cocodrilos actuales</li>
    <li><strong>Hocico:</strong> Ancho y redondeado en la punta, posiblemente para resonar sonidos</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>carnívoro</strong>. Se cree que cazaba peces grandes y posiblemente dinosaurios que se acercaban al agua a beber.</p>

<h2>Comportamiento</h2>
<p>Probablemente tenía un estilo de vida similar al de los cocodrilos modernos: acechaba a sus presas desde el agua y emboscaba con rapidez y fuerza.</p>

<h2>Reproducción</h2>
<p>Como todos los reptiles, se reproducía por <strong>huevos</strong>. Se cree que ponía nidos en tierra firme cerca de cuerpos de agua.</p>

<h2>Descubrimiento</h2>
<p>Los primeros restos se encontraron en la década de 1960, pero fue en el año 2000 cuando se descubrió un esqueleto más completo por el paleontólogo Paul Sereno.</p>

<h2>Relación con otros reptiles</h2>
<p>Sarcosuchus no es un ancestro directo de los cocodrilos actuales, pero sí un pariente cercano dentro del grupo Crocodyliformes.</p>

<h2>Importancia cultural</h2>
<p>Conocido como el "SuperCroc", ha aparecido en numerosos documentales, revistas y juguetes educativos debido a su tamaño impresionante.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Era mucho más grande que cualquier cocodrilo actual.</li>
    <li>Su hocico tenía una protuberancia que podría haber servido para vocalizaciones.</li>
    <li>Su mordida era lo suficientemente fuerte como para aplastar huesos grandes.</li>
    <li>Vivía en ambientes fluviales ricos en peces y otras presas.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
