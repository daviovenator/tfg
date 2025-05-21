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
    <title>Psilophyton - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Psilophyton</h1>

<a href="../../../img/Psilophyton.png" target="_blank">
    <img src="../../../img/Psilophyton.png" alt="Psilophyton" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Psilophyton</strong> deriva del griego <em>psilos</em> (desnudo) y <em>phyton</em> (planta), lo que significa "planta desnuda", en referencia a su estructura simple y sin hojas verdaderas.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Tracheophyta</li>
    <li><strong>Clase:</strong> Rhyniopsida</li>
    <li><strong>Orden:</strong> Rhyniales</li>
    <li><strong>Género:</strong> Psilophyton</li>
</ul>

<h2>Periodo geológico</h2>
<p>Psilophyton vivió durante el <strong>Devónico</strong>, hace aproximadamente <strong>420 a 370 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles han sido encontrados en América del Norte y Europa, especialmente en sedimentos que corresponden a ambientes húmedos y ribereños.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Tamaño:</strong> Alcanzaba hasta 80 cm de altura.</li>
    <li><strong>Tallos:</strong> Ramificados y fotosintéticos, sin hojas ni raíces verdaderas.</li>
    <li><strong>Rizomas:</strong> Estructuras subterráneas que actuaban como raíces primitivas.</li>
    <li><strong>Esporangios:</strong> En el extremo de las ramas, donde producía esporas.</li>
</ul>

<h2>Alimentación</h2>
<p>Era una planta <strong>fotosintética</strong>, que captaba la energía solar a través de sus tallos verdes y delgados.</p>

<h2>Comportamiento</h2>
<p>Crecía en ambientes húmedos y formaba parte de las primeras comunidades vegetales terrestres, junto a otras plantas primitivas.</p>

<h2>Reproducción</h2>
<p>Se reproducía por <strong>esporas</strong>, contenidas en esporangios terminales. Este mecanismo fue común en las plantas del Devónico.</p>

<h2>Descubrimiento</h2>
<p>Fósiles de Psilophyton fueron descritos por primera vez a mediados del siglo XIX, y ayudaron a definir las primeras etapas de evolución de las plantas vasculares.</p>

<h2>Relación con otras plantas</h2>
<p>Psilophyton está relacionado con otras plantas primitivas como <em>Rhynia</em>. Es uno de los primeros ejemplos conocidos de plantas con tejido vascular.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Psilophyton representa una etapa clave en la evolución de las plantas terrestres.</li>
    <li>No tenía hojas ni raíces verdaderas, pero sí tejidos vasculares simples.</li>
    <li>Su estructura nos muestra cómo eran las primeras plantas que colonizaron tierra firme.</li>
    <li>Es fundamental para entender la transición de plantas acuáticas a terrestres.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
