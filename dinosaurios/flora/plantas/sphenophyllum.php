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
    <title>Sphenophyllum - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Sphenophyllum</h1>

<a href="../../../img/Sphenophyllum.jpeg" target="_blank">
    <img src="../../../img/Sphenophyllum.jpeg" alt="Sphenophyllum" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Sphenophyllum</strong> proviene del griego, donde <em>sphen</em> significa "cuña" y <em>phyllon</em> significa "hoja", refiriéndose a la forma particular de sus hojas, que son similares a pequeñas cuñas o triángulos.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Pteridophyta</li>
    <li><strong>Clase:</strong> Sphenopsida</li>
    <li><strong>Orden:</strong> Sphenophyllales</li>
    <li><strong>Familia:</strong> Sphenophyllaceae</li>
    <li><strong>Género:</strong> Sphenophyllum</li>
</ul>

<h2>Periodo geológico</h2>
<p><strong>Sphenophyllum</strong> fue predominante durante el <strong>Devónico</strong> y el <strong>Carbonífero</strong>, hace aproximadamente entre 380 y 300 millones de años. Fue una planta común en los ecosistemas de esos períodos.</p>

<h2>Distribución geográfica</h2>
<p>Las plantas de <strong>Sphenophyllum</strong> se encontraron principalmente en los ecosistemas pantanosos y boscosos del supercontinente <strong>Gondwana</strong>, que incluye lo que hoy son África, América del Sur, y partes de Asia.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Las hojas de <strong>Sphenophyllum</strong> eran pequeñas, con una forma triangular o cuñada, organizadas en espiral a lo largo del tallo.</li>
    <li><strong>Tamaño:</strong> Eran plantas de pequeño tamaño, típicamente alcanzando solo unos pocos metros de altura.</li>
    <li><strong>Tallos:</strong> Su tallo era de forma ramificada, a menudo segmentado, y cubierto de pequeñas ramas que sostenían las hojas en forma de espiral.</li>
</ul>

<h2>Alimentación</h2>
<p><strong>Sphenophyllum</strong> era una planta autótrofa que realizaba fotosíntesis para producir su propio alimento, utilizando la luz solar, el dióxido de carbono y el agua.</p>

<h2>Comportamiento</h2>
<p>Las plantas de <strong>Sphenophyllum</strong> se desarrollaban en hábitats húmedos y pantanosos, formando parte de los bosques primitivos de la era Paleozoica. Se adaptaron bien a estos ecosistemas, donde su tamaño pequeño y estructura les permitían prosperar.</p>

<h2>Reproducción</h2>
<p><strong>Sphenophyllum</strong> se reproducía por esporas, similar a los helechos. Las esporas eran liberadas de las estructuras reproductivas que se encontraban en los tallos de la planta, y germinaban para dar lugar a nuevas plantas.</p>

<h2>Descubrimiento</h2>
<p>Los primeros fósiles de <strong>Sphenophyllum</strong> fueron descritos a partir de restos de hojas y tallos, y han proporcionado valiosa información sobre la flora del Paleozoico, especialmente sobre las primeras plantas que comenzaron a adaptarse a la vida terrestre.</p>

<h2>Relación con otras plantas</h2>
<p><strong>Sphenophyllum</strong> está relacionado con otros miembros de la clase Sphenopsida, como los modernos equisetos (cola de caballo). Estas plantas compartían una estructura similar y pertenecen a un grupo antiguo de plantas que no produce semillas, sino esporas.</p>

<h2>Curiosidades</h2>
<ul>
    <li><strong>Sphenophyllum</strong> es uno de los primeros ejemplos de plantas con tallos segmentados, lo que indica una adaptación temprana en la evolución de las plantas terrestres.</li>
    <li>Durante el Carbonífero, <strong>Sphenophyllum</strong> era una planta importante en los bosques pantanosos, contribuyendo a la formación de grandes depósitos de carbón.</li>
    <li>Su forma única de hojas y su estructura de tallos segmentados lo convierten en una planta fascinante para los estudios paleobotánicos.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
