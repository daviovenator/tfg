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
    <title>Cyperaceae - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Cyperaceae</h1>

<a href="../../../img/Cyperaceae.jpg" target="_blank">
    <img src="../../../img/Cyperaceae.jpg" alt="Cyperaceae" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Cyperaceae</strong> es una familia de plantas que incluye principalmente a los juncos y algunas especies similares. El nombre proviene del género <em>Cyperus</em>, que es el género tipo de la familia, y se deriva de la palabra griega "kypressos", que significa "junco".</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Angiospermae</li>
    <li><strong>Clase:</strong> Monocotiledóneas</li>
    <li><strong>Orden:</strong> Poales</li>
    <li><strong>Familia:</strong> Cyperaceae</li>
</ul>

<h2>Periodo geológico</h2>
<p>Las plantas de la familia Cyperaceae tienen una larga historia evolutiva, con algunas especies actuales que datan de hace más de 100 millones de años, aunque la mayoría de las especies conocidas se distribuyen en la actualidad.</p>

<h2>Distribución geográfica</h2>
<p>Las especies de la familia Cyperaceae se distribuyen principalmente en áreas húmedas, como márgenes de ríos, lagos, pantanos y humedales, tanto en regiones tropicales como templadas. Son comunes en diversas partes del mundo, especialmente en zonas de agua dulce.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Las hojas suelen ser estrechas, lineales y dispuestas en espiral alrededor del tallo.</li>
    <li><strong>Flores:</strong> Las flores son generalmente pequeñas, sin pétalos visibles y dispuestas en inflorescencias en forma de espigas o umbelas.</li>
    <li><strong>Tallo:</strong> Los tallos son erectos y a menudo triangulares, con una textura fibrosa que les permite resistir las condiciones húmedas.</li>
</ul>

<h2>Alimentación</h2>
<p>Las plantas de la familia Cyperaceae son autótrofas y realizan la fotosíntesis, utilizando la luz solar, el dióxido de carbono y el agua para producir su propio alimento.</p>

<h2>Comportamiento</h2>
<p>Las especies de Cyperaceae son importantes en ecosistemas acuáticos, donde proporcionan hábitats para diversos organismos acuáticos. Algunas especies también tienen usos humanos, como el cultivo de plantas para la producción de fibras.</p>

<h2>Reproducción</h2>
<p>La mayoría de las especies de Cyperaceae se reproducen mediante semillas, aunque algunas también pueden reproducirse vegetativamente a través de estolones o rizomas. Las flores son polinizadas por viento o insectos.</p>

<h2>Descubrimiento</h2>
<p>La familia Cyperaceae fue descrita por el botánico sueco Carl Linnaeus en el siglo XVIII. Desde entonces, se han identificado y clasificado miles de especies dentro de esta familia, muchas de las cuales tienen importancia ecológica y económica.</p>

<h2>Relación con otras plantas</h2>
<p>Las plantas de la familia Cyperaceae están estrechamente relacionadas con las gramíneas (Poaceae) y las juncáceas (Juncaceae), formando parte del orden Poales. Aunque comparten algunas características, como las hojas lineales, se diferencian por la disposición de las flores y la estructura del tallo.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El <em>Cyperus papyrus</em> es conocido históricamente por ser utilizado para fabricar papel en el antiguo Egipto, en lugar de las hojas de plantas como el papiro.</li>
    <li>Las plantas de Cyperaceae, como el junco, a menudo se encuentran en ambientes húmedos y son esenciales para la estabilización del suelo en humedales y zonas ribereñas.</li>
    <li>Algunas especies, como el <em>Cyperus alternifolius</em>, son populares en jardinería de interior debido a su resistencia a las condiciones de humedad y su atractiva apariencia.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
