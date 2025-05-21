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
    <title>Bennettitales - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Bennettitales</h1>

<a href="../../../img/Bennettitales.webp" target="_blank">
    <img src="../../../img/Bennettitales.webp" alt="Bennettitales" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Bennettitales</strong> es un orden de plantas extintas que pertenecen a un grupo de gimnospermas prehistóricas. Su nombre se debe al botánico inglés John Bennett, quien fue clave en su descubrimiento y estudio.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Gymnospermae</li>
    <li><strong>Orden:</strong> Bennettitales</li>
    <li><strong>Familia:</strong> Bennettitaceae</li>
</ul>

<h2>Periodo geológico</h2>
<p>Las plantas de Bennettitales prosperaron durante el <strong>Jurásico</strong> y <strong> Cretácico</strong>, hace entre 200 y 65 millones de años. Durante este tiempo, fueron una parte importante de la flora de la era mesozoica.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles de Bennettitales en diferentes partes del mundo, incluidos continentes como Europa, América del Norte, y Australia. Esta planta fue parte de los ecosistemas dominados por los dinosaurios.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Las hojas de las Bennettitales eran similares a las de las coníferas, con una forma alargada y estrecha.</li>
    <li><strong>Semillas:</strong> Producían grandes semillas que eran liberadas en conos similares a los de las coníferas.</li>
    <li><strong>Reproducción:</strong> Estas plantas no producían flores, sino conos, como otros grupos de gimnospermas.</li>
</ul>

<h2>Alimentación</h2>
<p>Al igual que otras plantas, las Bennettitales eran autótrofas, lo que significa que obtenían su energía mediante la fotosíntesis, utilizando la luz solar, dióxido de carbono y agua para producir nutrientes.</p>

<h2>Comportamiento</h2>
<p>Las Bennettitales eran plantas arbóreas que se desarrollaron en ambientes subtropicales y templados. A pesar de ser parte de un ecosistema dominado por grandes dinosaurios, no se tiene evidencia de que fueran consumidas en grandes cantidades por ellos.</p>

<h2>Reproducción</h2>
<p>Las Bennettitales se reproducían mediante la liberación de esporas y semillas contenidas en conos. Estas plantas no desarrollaron flores, por lo que su reproducción era principalmente a través de estructuras reproductivas no florales, como otras gimnospermas.</p>

<h2>Descubrimiento</h2>
<p>El género Bennettitales fue descrito y catalogado a fines del siglo XIX, cuando los paleontólogos comenzaron a descubrir sus fósiles en depósitos geológicos. Este orden se destacó por su relación con otras especies de plantas primitivas que existieron durante la era Mesozoica.</p>

<h2>Relación con otras plantas</h2>
<p>Bennettitales están relacionados con otras gimnospermas, como las cícadas y las coníferas, pero se distinguen por sus conos únicos y características morfológicas que las separan de otros grupos de plantas de la misma época.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Las Bennettitales se extinguieron al final del Cretácico, probablemente debido al cambio climático y la competencia con otras plantas más modernas.</li>
    <li>Se cree que algunas de estas plantas tenían una relación simbiótica con los insectos polinizadores, similar a lo que ocurre con muchas plantas modernas.</li>
    <li>A pesar de su extinción, las Bennettitales fueron un componente clave de la vegetación mesozoica, y sus fósiles nos proporcionan valiosa información sobre los ecosistemas de esa era.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
