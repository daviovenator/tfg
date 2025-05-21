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
    <title>Eugenia - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Eugenia</h1>

<a href="../../../img/Eugenia.webp" target="_blank">
    <img src="../../../img/Eugenia.webp" alt="Eugenia" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Eugenia</strong> es un género de plantas de la familia Myrtaceae. Su nombre proviene del griego "eugenes", que significa "bien nacido" o "de noble linaje". Este nombre hace referencia a la calidad y características sobresalientes de las plantas de este género.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Angiospermae</li>
    <li><strong>Clase:</strong> Dicotiledóneas</li>
    <li><strong>Orden:</strong> Myrtales</li>
    <li><strong>Familia:</strong> Myrtaceae</li>
    <li><strong>Género:</strong> Eugenia</li>
</ul>

<h2>Periodo geológico</h2>
<p>El género Eugenia ha existido desde hace millones de años, aunque la mayoría de sus especies modernas se han diversificado durante el Cretácico. Hoy en día, se encuentran ampliamente distribuidas, especialmente en zonas tropicales.</p>

<h2>Distribución geográfica</h2>
<p>Las plantas de Eugenia son nativas de áreas tropicales y subtropicales de América, África, Asia y Oceanía. Son comúnmente encontradas en bosques húmedos y en la cuenca amazónica.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Las hojas de Eugenia son usualmente opuestas, simples y de forma ovalada. Son de color verde brillante y a menudo tienen un aroma agradable cuando se frotan.</li>
    <li><strong>Flores:</strong> Las flores de Eugenia son generalmente blancas o rosadas, con numerosos estambres que les dan un aspecto exuberante.</li>
    <li><strong>Frutos:</strong> Los frutos de Eugenia varían en tamaño y forma, desde bayas pequeñas hasta frutas más grandes, como las guayabas, que pertenecen a este género.</li>
</ul>

<h2>Alimentación</h2>
<p>Las plantas de Eugenia son autótrofas, realizando fotosíntesis para producir su propio alimento a partir de la luz solar, el dióxido de carbono y el agua. Algunas especies también producen frutos comestibles que son aprovechados por diversos animales.</p>

<h2>Comportamiento</h2>
<p>Las especies de Eugenia son principalmente arbustos o pequeños árboles. Algunas especies crecen como plantas de sotobosque, mientras que otras pueden alcanzar una mayor altura y prosperar en áreas de clima tropical húmedo.</p>

<h2>Reproducción</h2>
<p>La reproducción de Eugenia es sexual, mediante flores que se polinizan por insectos o aves. Tras la polinización, se desarrolla un fruto carnoso que contiene las semillas, que son dispersadas por animales o el viento.</p>

<h2>Descubrimiento</h2>
<p>El género Eugenia fue descrito por el botánico sueco Carl Linnaeus en el siglo XVIII. Desde entonces, se han identificado muchas especies dentro de este género, algunas de las cuales son cultivadas por sus frutos comestibles, como la guayaba.</p>

<h2>Relación con otras plantas</h2>
<p>Eugenia pertenece a la familia Myrtaceae, que incluye otros géneros notables como Myrtus (el mirto) y Psidium (el género de la guayaba). Todas estas plantas comparten características como flores con estambres numerosos y frutos carnosos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>La guayaba, una de las frutas más conocidas, pertenece al género Eugenia, siendo su especie más famosa el <em>Eugenia guajava</em>.</li>
    <li>El aceite esencial de Eugenia es utilizado en la medicina tradicional en algunas culturas, y tiene propiedades antimicrobianas y antioxidantes.</li>
    <li>Las especies de Eugenia tienen importancia ecológica al proporcionar alimento a diversos animales, incluyendo aves y mamíferos pequeños.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
