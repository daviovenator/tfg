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
    <title>Helechos Arbóreos (Tree Ferns) - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Helechos Arbóreos (Tree Ferns)</h1>

<a href="../../../img/Tree ferns(helechos arbóreos).jpg" target="_blank">
    <img src="../../../img/Tree ferns(helechos arbóreos).jpg" alt="Helechos Arbóreos" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Helechos arbóreos</strong> se refiere a especies de helechos con un tronco vertical que les da la apariencia de pequeños árboles. En inglés se les conoce como <em>Tree Ferns</em>.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Pteridophyta</li>
    <li><strong>Clase:</strong> Polypodiopsida</li>
    <li><strong>Orden:</strong> Cyatheales</li>
    <li><strong>Familias:</strong> Cyatheaceae, Dicksoniaceae y otras</li>
</ul>

<h2>Periodo geológico</h2>
<p>Los helechos arbóreos existen desde el <strong>Devónico Tardío</strong> y han persistido hasta la actualidad. Alcanzaron su apogeo en el <strong>Mesozoico</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Hoy en día se encuentran principalmente en regiones tropicales y subtropicales, como Nueva Zelanda, Australia, América del Sur y Asia.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Altura:</strong> Pueden alcanzar entre 3 y 20 metros.</li>
    <li><strong>Tronco:</strong> Falso tallo erguido formado por la base de frondes antiguas y raíces adventicias.</li>
    <li><strong>Frondes:</strong> Grandes, arqueadas y muy divididas, que emergen en forma de espiral.</li>
    <li><strong>Reproducción:</strong> Esporas situadas en la parte inferior de las frondes.</li>
</ul>

<h2>Alimentación</h2>
<p>Realizan <strong>fotosíntesis</strong> como otras plantas, utilizando la luz solar para sintetizar nutrientes a partir del dióxido de carbono y agua.</p>

<h2>Comportamiento</h2>
<p>Prefieren ambientes húmedos, sombra parcial y suelos ricos en materia orgánica. Son comunes en bosques nubosos y selvas.</p>

<h2>Reproducción</h2>
<p>Se reproducen mediante <strong>esporas</strong>, que dan lugar a gametofitos en ambientes húmedos. No producen flores ni semillas.</p>

<h2>Descubrimiento</h2>
<p>Restos fósiles de helechos arbóreos han sido encontrados en capas del Carbonífero y del Mesozoico. Muchas especies actuales conservan una morfología ancestral.</p>

<h2>Relación con otras plantas</h2>
<p>Están emparentados con otros helechos no arbóreos, pero destacan por su tamaño y porte. No deben confundirse con palmas u otras plantas leñosas.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Son considerados "fósiles vivientes" por su antigüedad evolutiva.</li>
    <li>En algunos lugares se utilizan como ornamentales en jardines húmedos y sombreados.</li>
    <li>Su "tronco" no es leñoso, sino una estructura fibrosa y porosa.</li>
    <li>Algunas especies están protegidas debido a su sensibilidad ecológica.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
