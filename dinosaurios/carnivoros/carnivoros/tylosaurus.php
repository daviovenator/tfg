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
    <title>Tylosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Tylosaurus</h1>

<a href="../../../img/tylosaurus.webp" target="_blank">
    <img src="../../../img/tylosaurus.webp" alt="Tylosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Tylosaurus</strong> significa "lagarto abultado", en referencia a su cuerpo robusto y su apariencia compacta. El nombre proviene del griego "tylos" (abultado) y "sauros" (lagarto).</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Squamata</li>
    <li><strong>Familia:</strong> Mosasauridae</li>
    <li><strong>Género:</strong> Tylosaurus</li>
    <li><strong>Especie:</strong> T. proriger</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Superior</strong>, hace aproximadamente <strong>85 a 70 millones de años</strong>, en el mar de lo que hoy es América del Norte.</p>

<h2>Distribución geográfica</h2>
<p>Los fósiles de Tylosaurus se han encontrado en:
<ul>
    <li>Estados Unidos (principalmente en Kansas y otras zonas del Cretácico)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 12 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 5 toneladas</li>
    <li><strong>Cuerpo:</strong> Cuerpo largo y robusto, adaptado para nadar rápidamente</li>
    <li><strong>Cabeza:</strong> Mandíbulas largas y poderosas, adaptadas para atrapar grandes presas marinas</li>
</ul>

<h2>Alimentación</h2>
<p>El Tylosaurus era un <strong>depredador marino</strong> que cazaba peces, cefalópodos y otros reptiles marinos. Su cuerpo esbelto y sus mandíbulas poderosas le permitían capturar presas rápidas y grandes.</p>

<h2>Comportamiento</h2>
<p>Se cree que el Tylosaurus era un cazador activo, nadando a gran velocidad y utilizando sus potentes mandíbulas para atrapar a sus presas. También es posible que utilizara su cola para impulsarse rápidamente en el agua.</p>

<h2>Reproducción</h2>
<p>Como muchos reptiles marinos, Tylosaurus se reproducía mediante <strong>huevos</strong>, aunque los detalles específicos sobre su reproducción no están completamente claros debido a la falta de nidos fósiles.</p>

<h2>Descubrimiento</h2>
<p>Fue descrito por primera vez a partir de fósiles encontrados en el Cretácico Superior, principalmente en áreas que hoy corresponden a los Estados Unidos. Su nombre científico fue asignado en 1874 por el paleontólogo Edward Drinker Cope.</p>

<h2>Relación con otros animales</h2>
<p>Tylosaurus pertenecía a la familia de los mosasaurios, que incluye a otros grandes depredadores marinos como el Mosasaurus. A pesar de sus similitudes, los tylosaurios se distinguen por su cuerpo más robusto y su capacidad para nadar con gran rapidez.</p>

<h2>Importancia cultural</h2>
<p>El Tylosaurus, como otros mosasaurios, es un reptil marino fascinante que aparece en varios documentales y películas sobre dinosaurios y reptiles prehistóricos. Es conocido por su gran tamaño y su poder como depredador marino.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Tylosaurus era uno de los mosasaurios más grandes y más temidos de su época.</li>
    <li>Su cola estaba perfectamente adaptada para nadar rápidamente, lo que le permitía cazar presas con eficacia.</li>
    <li>Las mandíbulas del Tylosaurus eran tan poderosas que podían triturar a sus presas con facilidad.</li>
    <li>Era uno de los depredadores dominantes en su ecosistema marino.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
