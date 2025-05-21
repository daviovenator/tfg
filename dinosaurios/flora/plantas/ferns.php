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
    <title>Helechos (Ferns) - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Helechos (Ferns)</h1>

<a href="../../../img/Ferns(helechos).jpg" target="_blank">
    <img src="../../../img/Ferns(helechos).jpg" alt="Helechos" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p>La palabra <strong>helecho</strong> proviene del latín <em>filix</em>, mientras que en inglés <em>fern</em> deriva del inglés antiguo <em>fearn</em>. Son plantas sin flores, conocidas por sus hojas ornamentales y su antigua historia evolutiva.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Pteridophyta</li>
    <li><strong>Clase:</strong> Polypodiopsida</li>
    <li><strong>Orden:</strong> Diversos</li>
    <li><strong>Familia:</strong> Múltiples familias</li>
    <li><strong>Grupo:</strong> Helechos (Ferns)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Los helechos existen desde el <strong>Devónico</strong> (hace más de 360 millones de años) y alcanzaron gran diversidad durante el <strong>Pérmico y Mesozoico</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se encuentran en todo el mundo, especialmente en regiones tropicales y húmedas, aunque también prosperan en zonas templadas.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Llamadas frondes, divididas y muchas veces grandes y decorativas.</li>
    <li><strong>Raíces:</strong> Subterráneas, desarrolladas a partir de un rizoma.</li>
    <li><strong>Tamaño:</strong> Desde pequeños helechos de unos pocos centímetros hasta helechos arborescentes de varios metros.</li>
    <li><strong>Reproducción:</strong> Esporas producidas en el envés de las frondes.</li>
</ul>

<h2>Alimentación</h2>
<p>Realizan <strong>fotosíntesis</strong>, utilizando la energía solar para producir sus nutrientes a partir de dióxido de carbono y agua.</p>

<h2>Comportamiento</h2>
<p>Los helechos no tienen flores ni semillas. Viven en ambientes húmedos y sombreados, y muchos son epífitos (viven sobre otras plantas).</p>

<h2>Reproducción</h2>
<p>Se reproducen por <strong>esporas</strong> y tienen un ciclo de vida complejo con alternancia de generaciones: esporofito y gametofito.</p>

<h2>Descubrimiento</h2>
<p>Fósiles de helechos se han encontrado en depósitos del Devónico. Son conocidos por su gran abundancia en formaciones de carbón fósil.</p>

<h2>Relación con otras plantas</h2>
<p>Son parientes de otras plantas sin semillas como las licofitas, pero están más avanzados evolutivamente, con tejidos vasculares más desarrollados.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Algunos helechos pueden vivir más de 100 años.</li>
    <li>Los helechos arborescentes actuales son similares a los del Mesozoico.</li>
    <li>Han sido utilizados tradicionalmente como plantas ornamentales y medicinales.</li>
    <li>Son importantes indicadores ecológicos de ambientes húmedos.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
