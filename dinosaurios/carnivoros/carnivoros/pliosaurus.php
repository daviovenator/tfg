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
    <title>Pliosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Pliosaurus</h1>

<a href="../../../img/Pliosaurus.jpg" target="_blank">
    <img src="../../../img/Pliosaurus.jpg" alt="Pliosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Pliosaurus</strong> significa "lagarto más cercano al mar", en referencia a su vida en los mares del Jurásico. El nombre proviene del griego "plios" (más cercano) y "sauros" (lagarto).</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Plesiosauria</li>
    <li><strong>Suborden:</strong> Pliosauroidea</li>
    <li><strong>Familia:</strong> Pliosauridae</li>
    <li><strong>Género:</strong> Pliosaurus</li>
    <li><strong>Especie:</strong> P. funkei (una de las especies conocidas)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Superior</strong>, hace aproximadamente <strong>150 a 145 millones de años</strong>, en una época en la que los mares eran el hogar de muchos reptiles marinos.</p>

<h2>Distribución geográfica</h2>
<p>Los fósiles de Pliosaurus se han encontrado en varias partes del mundo, incluyendo:
<ul>
    <li>Europa (principalmente en el Reino Unido y Alemania)</li>
    <li>Sudamérica</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 12 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 5 a 10 toneladas</li>
    <li><strong>Cuerpo:</strong> Cuerpo robusto con una cola corta, adaptado para nadar a alta velocidad</li>
    <li><strong>Mandíbulas:</strong> Mandíbulas enormes con dientes afilados, diseñados para atrapar presas grandes como peces y otros reptiles marinos.</li>
</ul>

<h2>Alimentación</h2>
<p>El Pliosaurus era un <strong>depredador marino</strong> que cazaba peces grandes, otros reptiles marinos, y posiblemente incluso pequeños dinosaurios marinos. Su gran tamaño y poderosas mandíbulas lo convertían en uno de los depredadores más temidos de su tiempo.</p>

<h2>Comportamiento</h2>
<p>Se cree que el Pliosaurus era un cazador activo y muy rápido en el agua. Su cuerpo robusto y sus aletas grandes le proporcionaban una gran maniobrabilidad para capturar presas en los océanos del Jurásico.</p>

<h2>Reproducción</h2>
<p>Como muchos reptiles marinos, Pliosaurus se reproducía mediante <strong>huevos</strong>, aunque no se conocen detalles precisos de cómo construía sus nidos o de sus comportamientos reproductivos.</p>

<h2>Descubrimiento</h2>
<p>Los primeros restos de Pliosaurus fueron encontrados en el siglo XIX, pero fue hasta mucho después cuando se empezó a estudiar en profundidad. Los fósiles más completos pertenecen a especies como Pliosaurus funkei, que es una de las más conocidas.</p>

<h2>Relación con otros animales</h2>
<p>Pliosaurus pertenece a la familia de los pliosáuridos, que eran parientes cercanos de los plesiosaurios. Los pliosáuridos eran más grandes y tenían un cuerpo más robusto que los plesiosaurios, con un diseño adaptado para nadar a alta velocidad.</p>

<h2>Importancia cultural</h2>
<p>El Pliosaurus, aunque no tan conocido como otros reptiles marinos como el Mosasaurus, es una figura importante en el estudio de los reptiles prehistóricos marinos. Su enorme tamaño y habilidades como depredador lo convierten en un tema fascinante de estudio en paleontología.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Pliosaurus tenía una mandíbula tan poderosa que podría haber aplastado a sus presas con facilidad.</li>
    <li>Sus dientes eran grandes y afilados, ideales para desgarrar carne de grandes animales marinos.</li>
    <li>Se cree que podía nadar a velocidades relativamente altas, lo que le ayudaba a cazar presas rápidas.</li>
    <li>Su tamaño le permitía cazar en la parte superior de la cadena alimenticia, siendo uno de los principales depredadores marinos de su época.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
