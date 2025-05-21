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
    <title>Eurypterus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Eurypterus</h1>

<a href="../../../img/Eurypterus.jpg" target="_blank">
    <img src="../../../img/Eurypterus.jpg" alt="Eurypterus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Eurypterus</strong> significa "escorpión ancho", debido a la forma de su cuerpo, que se asemejaba a un escorpión. El nombre proviene del griego "eurys" (ancho) y "pteron" (aleta).</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Arthropoda</li>
    <li><strong>Clase:</strong> Chelicerata</li>
    <li><strong>Orden:</strong> Eurypterida</li>
    <li><strong>Familia:</strong> Eurypteridae</li>
    <li><strong>Género:</strong> Eurypterus</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Paleozoico</strong>, específicamente entre <strong>430 y 300 millones de años</strong>, durante los períodos Silúrico y Devónico.</p>

<h2>Distribución geográfica</h2>
<p>Sus restos se han encontrado en diversas regiones de América del Norte y Europa:
<ul>
    <li>Estados Unidos (New York, Ohio)</li>
    <li>Escocia</li>
    <li>Rusia</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 2.5 metros</li>
    <li><strong>Distintivo:</strong> Cuerpo alargado con pinzas grandes y fuertes, similar a las de un escorpión.</li>
    <li><strong>Ojos:</strong> Ojos compuestos situados en la parte superior de su cabeza.</li>
    <li><strong>Segmentación:</strong> Su cuerpo estaba segmentado, lo que le permitía un movimiento flexible.</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>depredador</strong> que cazaba otros invertebrados marinos, como trilobites, y posiblemente peces pequeños. Sus pinzas le ayudaban a atrapar a sus presas.</p>

<h2>Comportamiento</h2>
<p>El Eurypterus se desplazaba por el agua utilizando sus patas y nadaba con las pinzas hacia adelante. Era un cazador activo, aunque también pudo haber sido carroñero.</p>

<h2>Reproducción</h2>
<p>Se reproducía a través de huevos, pero los detalles sobre su comportamiento reproductivo son limitados debido a la escasez de fósiles de crías.</p>

<h2>Descubrimiento</h2>
<p>El Eurypterus fue descrito por primera vez por el paleontólogo John Hall en 1841, basado en fósiles encontrados en los Estados Unidos.</p>

<h2>Relación con otros organismos</h2>
<p>El Eurypterus pertenece a un grupo primitivo de artrópodos que más tarde daría lugar a los modernos escorpiones y arañas. Aunque no es un ancestro directo, comparte muchas características con estos animales.</p>

<h2>Importancia cultural</h2>
<p>Aunque no es tan conocido como otros animales del Paleozoico, Eurypterus es un símbolo de los primeros depredadores marinos, y ha aparecido en documentales sobre la vida prehistórica.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Es conocido como uno de los artrópodos marinos más grandes de su tiempo.</li>
    <li>Su capacidad para moverse rápidamente y atrapar presas lo hacía un predador eficiente en su hábitat acuático.</li>
    <li>El Eurypterus es uno de los primeros ejemplos de artrópodos que conquistaron ambientes marinos antes de evolucionar hacia los escorpiones terrestres.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
