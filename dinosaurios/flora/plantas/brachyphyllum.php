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
    <title>Brachyphyllum - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Brachyphyllum</h1>

<a href="../../../img/Brachyphyllum.webp" target="_blank">
    <img src="../../../img/Brachyphyllum.webp" alt="Brachyphyllum" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Brachyphyllum</strong> proviene del griego, donde <em>brachy</em> significa "corto" y <em>phyllum</em> significa "hoja", lo que hace referencia al tamaño relativamente pequeño y la forma de sus hojas en comparación con otras plantas de su época.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Pteridophyta</li>
    <li><strong>Clase:</strong> Filicopsida</li>
    <li><strong>Orden:</strong> Cyatheales</li>
    <li><strong>Familia:</strong> Brachyphyllaceae</li>
    <li><strong>Género:</strong> Brachyphyllum</li>
</ul>

<h2>Periodo geológico</h2>
<p><strong>Brachyphyllum</strong> vivió durante el <strong>Jurásico</strong> y el <strong>Cretácico</strong>, hace entre 200 y 65 millones de años, en los primeros ecosistemas terrestres dominados por plantas vasculares y grandes helechos.</p>

<h2>Distribución geográfica</h2>
<p>Las plantas de <strong>Brachyphyllum</strong> se distribuyeron principalmente en los ecosistemas templados de los supercontinentes de la era Mesozoica, como <strong>Laurasia</strong> y <strong>Gondwana</strong>, cubriendo lo que hoy son partes de Europa, América del Norte y Asia.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Las hojas de <strong>Brachyphyllum</strong> eran pequeñas y de forma lanceolada, adaptadas para maximizar la captación de luz en los bosques densos de su tiempo.</li>
    <li><strong>Tamaño:</strong> Esta planta era relativamente pequeña en comparación con otros helechos primitivos, alcanzando hasta 1 metro de altura en su mayoría.</li>
    <li><strong>Tallos:</strong> Su tallo era delgado, ramificado y cubierto de pequeñas ramas que sostenían las hojas de forma densa, creando una cobertura similar a un manto verde.</li>
</ul>

<h2>Alimentación</h2>
<p><strong>Brachyphyllum</strong> era una planta autótrofa que realizaba fotosíntesis, usando la luz solar, el dióxido de carbono y el agua para producir su propio alimento.</p>

<h2>Comportamiento</h2>
<p>Las plantas de <strong>Brachyphyllum</strong> se desarrollaban en ambientes húmedos y boscosos, adaptándose bien a las condiciones de sombra y alta humedad que prevalecían en el Mesozoico.</p>

<h2>Reproducción</h2>
<p><strong>Brachyphyllum</strong> se reproducía por esporas, al igual que otros helechos primitivos, liberando las esporas desde estructuras especializadas en sus hojas que germinaban para dar lugar a nuevas plantas.</p>

<h2>Descubrimiento</h2>
<p>El descubrimiento de <strong>Brachyphyllum</strong> se basa en fósiles de hojas y tallos, que han proporcionado información crucial sobre las primeras plantas en adaptarse a los bosques densos de la era Mesozoica.</p>

<h2>Relación con otras plantas</h2>
<p><strong>Brachyphyllum</strong> está relacionado con otros helechos primitivos y plantas como los helechos modernos, perteneciendo a un grupo de plantas vasculares sin semillas.</p>

<h2>Curiosidades</h2>
<ul>
    <li><strong>Brachyphyllum</strong> es un excelente ejemplo de los helechos primitivos que cubrían las áreas boscosas de la era Mesozoica, y que ayudaron a estabilizar los ecosistemas de su tiempo.</li>
    <li>Se cree que <strong>Brachyphyllum</strong> formaba parte de los densos bosques húmedos del Cretácico, contribuyendo a la formación de grandes depósitos de carbono que más tarde se convirtieron en carbón.</li>
    <li>Su pequeño tamaño y su estructura densa de hojas le permitieron adaptarse a condiciones de sombra en los bosques primitivos.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
