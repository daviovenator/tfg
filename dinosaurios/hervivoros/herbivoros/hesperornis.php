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
    <title>Hesperornis - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Hesperornis</h1>

<a href="../../../img/hesperornis.jpg" target="_blank">
    <img src="../../../img/hesperornis.jpg" alt="Hesperornis" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Hesperornis</strong> proviene del griego "hesperos" (occidental) y "ornis" (ave), lo que se traduce como "ave occidental". Este nombre hace referencia a su descubrimiento en América del Norte.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Aves</li>
    <li><strong>Orden:</strong> Hesperornithiformes</li>
    <li><strong>Familia:</strong> Hesperornithidae</li>
    <li><strong>Género:</strong> Hesperornis</li>
    <li><strong>Especie:</strong> H. regalis</li>
</ul>

<h2>Periodo geológico</h2>
<p>El Hesperornis vivió durante el <strong>Cretácico Temprano</strong>, hace aproximadamente <strong>85 millones de años</strong>, en un periodo marcado por la abundancia de reptiles marinos.</p>

<h2>Distribución geográfica</h2>
<p>Este dinosaurio acuático se distribuyó principalmente en lo que hoy es América del Norte, particularmente en áreas que en ese tiempo eran cuerpos de agua costeros.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 1.2 metros</li>
    <li><strong>Peso:</strong> Se estima que pesaba alrededor de 1.5 kilogramos</li>
    <li><strong>Cuerpo:</strong> Su cuerpo estaba adaptado para nadar, con un pico largo y aplanado, y patas en forma de palas</li>
    <li><strong>Alas:</strong> No era capaz de volar, pero sus alas eran útiles para nadar</li>
    <li><strong>Cola:</strong> Larga y adaptada para maniobras acuáticas</li>
</ul>

<h2>Alimentación</h2>
<p>El Hesperornis era un <strong>carnívoro acuático</strong> que se alimentaba principalmente de peces, utilizando su pico largo y afilado para capturarlos bajo el agua.</p>

<h2>Comportamiento</h2>
<p>Se cree que el Hesperornis pasaba la mayor parte de su vida en el agua, nadando y buceando para capturar presas. Aunque no podía volar, era un excelente nadador.</p>

<h2>Reproducción</h2>
<p>Como muchas aves actuales, el Hesperornis se reproducía mediante <strong>huevos</strong>, los cuales probablemente depositaba en la orilla o en islas pequeñas dentro de su hábitat acuático.</p>

<h2>Descubrimiento</h2>
<p>El Hesperornis fue descubierto por primera vez en 1872 en América del Norte. Su descubrimiento proporcionó valiosa información sobre las aves que vivieron durante el Cretácico.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Hesperornis estaba relacionado con otros dinosaurios acuáticos y aves primitivas, siendo uno de los primeros en mostrar adaptaciones completas para la vida en el agua. Está relacionado con el <em>Ichthyornis</em>, otro dinosaurio acuático de la misma época.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Hesperornis tenía una habilidad excepcional para nadar, lo que lo hacía muy diferente a las aves modernas que están adaptadas para volar.</li>
    <li>Su pico largo y afilado le permitía capturar peces con gran eficacia.</li>
    <li>A pesar de ser un excelente nadador, el Hesperornis no podía volar debido a sus alas poco desarrolladas.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
