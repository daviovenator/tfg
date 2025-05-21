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
    <title>Cycads - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Cycads (Cícadas)</h1>

<a href="../../../img/Cycads (Cícadas).jpg" target="_blank">
    <img src="../../../img/Cycads (Cícadas).jpg" alt="Cycads" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p>El nombre <strong>Cycad</strong> proviene del griego "kykas", posiblemente una mala transcripción de "koikas", refiriéndose a una palmera, aunque no están directamente relacionadas con ellas.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Cycadophyta</li>
    <li><strong>Clase:</strong> Cycadopsida</li>
    <li><strong>Orden:</strong> Cycadales</li>
    <li><strong>Familia:</strong> Varias (incluyendo Cycadaceae y Zamiaceae)</li>
    <li><strong>Géneros:</strong> Cycas, Zamia, Encephalartos, entre otros</li>
</ul>

<h2>Periodo geológico</h2>
<p>Las cícadas aparecieron hace más de <strong>280 millones de años</strong>, en el <strong>Pérmico</strong>, y fueron muy abundantes durante el <strong>Mesozoico</strong>, razón por la cual a veces se las llama "plantas de dinosaurios".</p>

<h2>Distribución geográfica</h2>
<p>Actualmente, las cícadas habitan zonas tropicales y subtropicales del mundo, incluyendo África, Australia, América Central y Asia.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Altura:</strong> Generalmente entre 1 y 5 metros, aunque algunas especies alcanzan los 10 metros.</li>
    <li><strong>Hojas:</strong> Pinnadas, parecidas a las de las palmas, rígidas y coriáceas.</li>
    <li><strong>Tallos:</strong> Leñosos, con forma de tronco, muchas veces subterráneos.</li>
    <li><strong>Semillas:</strong> Grandes, en conos, algunas tóxicas para los humanos.</li>
</ul>

<h2>Alimentación</h2>
<p>Realizan <strong>fotosíntesis</strong> como todas las plantas verdes, transformando luz solar en energía.</p>

<h2>Comportamiento</h2>
<p>Las cícadas crecen muy lentamente y pueden vivir cientos de años. Algunas desarrollan relaciones simbióticas con cianobacterias en sus raíces para fijar nitrógeno.</p>

<h2>Reproducción</h2>
<p>Son <strong>plantas dioicas</strong>, lo que significa que hay plantas masculinas y femeninas separadas. Se reproducen por <strong>semillas</strong>, que se desarrollan en conos.</p>

<h2>Descubrimiento</h2>
<p>Fósiles de cícadas se conocen desde hace siglos y se han encontrado en todo el mundo. Muchas especies actuales se consideran fósiles vivientes.</p>

<h2>Relación con otras plantas</h2>
<p>Son gimnospermas, como las coníferas y el ginkgo, pero pertenecen a su propia división. No están emparentadas con las palmeras ni los helechos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Han cambiado poco desde la era de los dinosaurios.</li>
    <li>Algunas especies están altamente amenazadas y protegidas por leyes internacionales.</li>
    <li>Algunas producen toxinas peligrosas para humanos y animales si se consumen sin tratamiento.</li>
    <li>Se utilizan como ornamentales por su apariencia exótica y prehistórica.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
