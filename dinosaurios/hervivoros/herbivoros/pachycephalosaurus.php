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
    <title>Pachycephalosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Pachycephalosaurus</h1>

<a href="../../../img/Pachycephalosaurus.webp" target="_blank">
    <img src="../../../img/Pachycephalosaurus.webp" alt="Pachycephalosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Pachycephalosaurus</strong> significa "lagarto de cabeza gruesa", debido a su característico cráneo extremadamente grueso y abultado.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Familia:</strong> Pachycephalosauridae</li>
    <li><strong>Género:</strong> Pachycephalosaurus</li>
    <li><strong>Especie:</strong> P. wyomingensis (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Tardío</strong>, hace aproximadamente <strong>75 a 66 millones de años</strong>, en la misma época que otros dinosaurios herbívoros como el Triceratops y el Edmontosaurus.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles de Pachycephalosaurus en:
<ul>
    <li>Estados Unidos (principalmente en los estados de Wyoming, Montana y Dakota del Sur)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 4.5 metros</li>
    <li><strong>Peso:</strong> Alrededor de 450 kg</li>
    <li><strong>Cabeza:</strong> Con un cráneo grueso y abultado, que podía alcanzar hasta 25 cm de grosor</li>
    <li><strong>Postura:</strong> Bípedo, con una postura erguida</li>
    <li><strong>Cola:</strong> Larga y flexible, utilizada para equilibrio</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> que se alimentaba principalmente de plantas bajas, helechos y otras vegetaciones que encontraba en su entorno.</p>

<h2>Comportamiento</h2>
<p>El Pachycephalosaurus probablemente utilizaba su cabeza gruesa para pelear o defenderse de otros individuos. Se ha sugerido que podría haber chocado su cabeza contra la de otros miembros de su especie, similar al comportamiento de algunos animales actuales como los carneros.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios, el Pachycephalosaurus se reproducía por medio de <strong>huevos</strong>, que probablemente eran depositados en nidos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Su cráneo era extremadamente grueso, lo que sugiere que probablemente usaba su cabeza para defenderse de depredadores o para pelear con otros machos durante la temporada de apareamiento.</li>
    <li>Aunque su cabeza parece un tanto tosca, su cuerpo era ágil y ligero, lo que le permitía moverse con rapidez.</li>
    <li>Su cráneo grueso es uno de los más característicos entre los dinosaurios.</li>
    <li>Era un dinosaurio relativamente pequeño en comparación con otros herbívoros del Cretácico Tardío.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
