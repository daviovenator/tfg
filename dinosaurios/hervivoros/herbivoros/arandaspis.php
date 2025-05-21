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
    <title>Arandaspis - Enciclopedia de Prehistoria</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Arandaspis</h1>

<a href="../../../img/arandaspis.jpeg" target="_blank">
    <img src="../../../img/arandaspis.jpeg" alt="Arandaspis" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Arandaspis</strong> significa “escudo de Aranda”, en honor al lugar donde se encontraron sus fósiles, en Australia Central.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Pteraspidomorphi</li>
    <li><strong>Orden:</strong> Arandaspida</li>
    <li><strong>Familia:</strong> Arandaspididae</li>
    <li><strong>Género:</strong> Arandaspis</li>
    <li><strong>Especie:</strong> A. prionotolepis</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Ordovícico Medio</strong>, hace aproximadamente <strong>480 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles han sido descubiertos en:
<ul>
    <li>Australia Central (región de Alice Springs)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 15 cm</li>
    <li><strong>Cuerpo:</strong> Fusiforme y cubierto de placas óseas en la parte frontal</li>
    <li><strong>Sin mandíbula:</strong> Como otros ostracodermos primitivos</li>
    <li><strong>Aberturas branquiales:</strong> A lo largo del cuerpo</li>
</ul>

<h2>Alimentación</h2>
<p>Se cree que era un <strong>filtrador</strong> o <strong>detritívoro</strong>, alimentándose de partículas orgánicas en suspensión en el agua.</p>

<h2>Importancia evolutiva</h2>
<p>Es uno de los vertebrados más antiguos conocidos. Su morfología proporciona información clave sobre la evolución de los primeros peces sin mandíbulas.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Probablemente nadaba cerca del fondo del océano primitivo.</li>
    <li>Ayudó a entender la transición evolutiva hacia vertebrados con mandíbulas.</li>
    <li>Tenía un escudo cefálico muy desarrollado para protegerse de depredadores.</li>
</ul>

<footer>
    <p>Enciclopedia de Prehistoria - © 2025</p>
</footer>

</body>
</html>
