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
    <title>Glossopteris - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Glossopteris</h1>

<a href="../../../img/Glossopteris.webp" target="_blank">
    <img src="../../../img/Glossopteris.webp" alt="Glossopteris" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Glossopteris</strong> proviene del griego, donde <em>glossa</em> significa "lengua" y <em>pteris</em> significa "helecho". El nombre se refiere a las hojas de esta planta, que tienen una forma triangular o en forma de lengua.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Pteridophyta</li>
    <li><strong>Clase:</strong> Glossopteridopsida</li>
    <li><strong>Orden:</strong> Glossopteridales</li>
    <li><strong>Familia:</strong> Glossopteridaceae</li>
    <li><strong>Género:</strong> Glossopteris</li>
</ul>

<h2>Periodo geológico</h2>
<p>El género <strong>Glossopteris</strong> fue predominante durante el <strong>Carbonífero</strong> y el <strong>Permiano</strong>, hace aproximadamente entre 300 y 250 millones de años. Fue uno de los grupos vegetales más importantes de la época.</p>

<h2>Distribución geográfica</h2>
<p>Las plantas de <strong>Glossopteris</strong> fueron comunes en el supercontinente <strong>Gondwana</strong>, que incluía lo que hoy son África, Sudamérica, India, Australia y la Antártida. Se cree que el clima era templado y húmedo en esas regiones.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Las hojas de <strong>Glossopteris</strong> eran grandes, de forma lanceolada o triangular, y presentaban nervaduras prominentes que les daban un aspecto distintivo.</li>
    <li><strong>Raíz:</strong> La planta tenía un sistema de raíces desarrollado que le permitía adaptarse a su ambiente, que incluía áreas de pantanos y bosques densos.</li>
    <li><strong>Tamaño:</strong> <strong>Glossopteris</strong> era una planta de tamaño considerable, con algunas especies alcanzando hasta 10 metros de altura.</li>
</ul>

<h2>Alimentación</h2>
<p><strong>Glossopteris</strong> era una planta autótrofa, lo que significa que realizaba fotosíntesis para producir su propio alimento utilizando la luz solar, el dióxido de carbono y el agua.</p>

<h2>Comportamiento</h2>
<p>Estas plantas se encontraban en los ecosistemas forestales del período Carbonífero y Permiano, donde formaban parte de vastos bosques y pantanos. Debido a su capacidad para adaptarse a una amplia variedad de condiciones, fue un componente esencial de los bosques primitivos.</p>

<h2>Reproducción</h2>
<p><strong>Glossopteris</strong> se reproducía mediante esporas, lo que la hacía similar a los helechos modernos en cuanto a su método de reproducción. Las esporas se liberaban en el aire y germinaban para formar nuevas plantas.</p>

<h2>Descubrimiento</h2>
<p>El fósil de <strong>Glossopteris</strong> fue descubierto por primera vez en el siglo XIX y es fundamental para el estudio de la paleobotánica. Su descubrimiento proporcionó pruebas clave de la existencia del supercontinente Gondwana, ya que los restos de esta planta se encuentran en continentes actualmente separados.</p>

<h2>Relación con otras plantas</h2>
<p>Glossopteris es uno de los grupos vegetales más antiguos y está relacionado con los helechos y las primeras plantas con semillas. También es antecesor de las modernas plantas coníferas y otras especies relacionadas con las gimnospermas.</p>

<h2>Curiosidades</h2>
<ul>
    <li><strong>Glossopteris</strong> desempeñó un papel clave en la formación de los primeros bosques de tierras bajas y pantanos en el supercontinente Gondwana.</li>
    <li>Su descubrimiento en varios continentes ayudó a confirmar la teoría de la deriva continental propuesta por Alfred Wegener en el siglo XX.</li>
    <li>Las hojas de <strong>Glossopteris</strong> fueron adaptadas para soportar un clima frío y húmedo, lo que las convirtió en una planta resistente a diversas condiciones ambientales.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
