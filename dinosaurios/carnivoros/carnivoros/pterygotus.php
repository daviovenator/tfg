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
    <title>Pterygotus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Pterygotus</h1>

<a href="../../../img/Pterygotus.jpg" target="_blank">
    <img src="../../../img/Pterygotus.jpg" alt="Pterygotus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Pterygotus</strong> significa "pez con alas", un nombre que hace referencia a las grandes aletas de este artrópodo marino. El nombre proviene del griego "pteryx" (ala) y "ichthys" (pez).</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Arthropoda</li>
    <li><strong>Clase:</strong> Chelicerata</li>
    <li><strong>Orden:</strong> Eurypterida</li>
    <li><strong>Familia:</strong> Pterygotidae</li>
    <li><strong>Género:</strong> Pterygotus</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Paleozoico</strong>, entre los <strong>Devónico</strong> y <strong>Silúrico</strong>, hace aproximadamente entre <strong>430 y 370 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se ha encontrado en varias regiones del mundo, especialmente en:
<ul>
    <li>Europa (Escocia, Alemania)</li>
    <li>América del Norte (Estados Unidos)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 2.5 metros</li>
    <li><strong>Distintivo:</strong> Cuerpo alargado con grandes aletas, y pinzas fuertes para capturar presas.</li>
    <li><strong>Ojos:</strong> Ojos compuestos en la parte superior de la cabeza, que le proporcionaban un campo de visión amplio.</li>
</ul>

<h2>Alimentación</h2>
<p>El Pterygotus era un <strong>depredador</strong> que cazaba otros invertebrados marinos, como trilobites y peces primitivos. Sus grandes pinzas le ayudaban a capturar a sus presas.</p>

<h2>Comportamiento</h2>
<p>Probablemente se desplazaba con rapidez a través del agua, usando sus aletas para nadar. Era un cazador activo y muy ágil en su entorno acuático.</p>

<h2>Reproducción</h2>
<p>Se reproducía por medio de huevos, pero no hay información suficiente sobre su comportamiento reproductivo debido a la falta de fósiles que muestren nidos o crías.</p>

<h2>Descubrimiento</h2>
<p>El Pterygotus fue descrito por primera vez por el paleontólogo Richard Owen en 1855, basándose en fósiles encontrados en Europa.</p>

<h2>Relación con otros organismos</h2>
<p>El Pterygotus pertenece a la misma familia que otros eurípteros, como Eurypterus, y comparte características con los modernos escorpiones y arañas.</p>

<h2>Importancia cultural</h2>
<p>Es un ejemplo de los primeros grandes depredadores marinos y ha aparecido en diversas representaciones de la vida prehistórica, aunque no es tan conocido como otros organismos del Paleozoico.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Pterygotus es conocido por sus impresionantes aletas y pinzas, que lo hacían un depredador eficaz.</li>
    <li>Algunos estudios sugieren que el Pterygotus tenía un estilo de vida similar al de los modernos cangrejos, acechando a sus presas en el fondo marino.</li>
    <li>Este animal es uno de los primeros ejemplos de artrópodos marinos que dominaron los ecosistemas acuáticos del Paleozoico.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
