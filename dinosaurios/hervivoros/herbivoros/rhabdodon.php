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
    <title>Rhabdodon - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Rhabdodon</h1>

<a href="../../../img/Rhabdodon.jpg" target="_blank">
    <img src="../../../img/Rhabdodon.jpg" alt="Rhabdodon" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Rhabdodon</strong> proviene del griego "rhabdos" (bastón) y "odon" (diente), lo que significa "diente en forma de bastón", debido a la forma de sus dientes.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Suborden:</strong> Cerapoda</li>
    <li><strong>Familia:</strong> Hypsilophodontidae</li>
    <li><strong>Género:</strong> Rhabdodon</li>
    <li><strong>Especie:</strong> R. priscus</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Inferior</strong>, hace aproximadamente <strong>120 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles han sido encontrados en lo que hoy es Europa, especialmente en Francia y España.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 4 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 500 kg</li>
    <li><strong>Postura:</strong> Bípeda, con una postura erguida y adaptada para el desplazamiento rápido.</li>
    <li><strong>Características distintivas:</strong> Sus dientes eran estrechos y puntiagudos, adaptados para cortar plantas.</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong>, y se alimentaba de plantas bajas como helechos y coníferas. Su dentadura estaba adaptada para cortar y masticar vegetación.</p>

<h2>Comportamiento</h2>
<p>El Rhabdodon probablemente vivía en grupos y se desplazaba rápidamente en busca de alimento. Su postura bípeda le habría permitido escapar de los depredadores con mayor facilidad.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios herbívoros, el Rhabdodon se reproducía a través de <strong>huevos</strong>, que las hembras colocaban en nidos construidos en el suelo.</p>

<h2>Descubrimiento</h2>
<p>El primer fósil de Rhabdodon fue descubierto en 1852 en Francia. Su nombre fue dado por el paleontólogo Henri Gauthier.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Rhabdodon pertenece a la familia Hypsilophodontidae, relacionada con otros dinosaurios bípodos pequeños como el <em>Hypsilophodon</em> y el <em>Thescelosaurus</em>.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Rhabdodon fue uno de los primeros dinosaurios en ser descritos en Europa, lo que ayudó a establecer el campo de la paleontología en la región.</li>
    <li>A pesar de su tamaño relativamente pequeño, era un herbívoro ágil que podía escapar rápidamente de los depredadores.</li>
    <li>Sus dientes especializados en cortar plantas indican que probablemente se alimentaba de vegetación de bajo crecimiento.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
