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
    <title>Shantungosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Shantungosaurus</h1>

<a href="../../../img/Shantungosaurus.jpeg" target="_blank">
    <img src="../../../img/Shantungosaurus.jpeg" alt="Shantungosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Shantungosaurus</strong> proviene del nombre de la provincia china de Shandong, donde fueron encontrados los primeros fósiles de este dinosaurio. El sufijo "saurus" proviene del griego y significa "lagarto", por lo que su nombre significa "lagarto de Shandong".</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Familia:</strong> Hadrosauridae</li>
    <li><strong>Género:</strong> Shantungosaurus</li>
    <li><strong>Especie:</strong> S. giganteus</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Superior</strong>, hace aproximadamente <strong>70 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles han sido encontrados en lo que hoy es China, especialmente en la provincia de Shandong, de donde recibe su nombre.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 12 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 8 toneladas</li>
    <li><strong>Postura:</strong> Cuadrúpeda, con un cuerpo grande y robusto.</li>
    <li><strong>Características distintivas:</strong> Era uno de los hadrosaurios más grandes, con un pico ancho y aplanado, adaptado para masticar vegetación.</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> que se alimentaba de plantas como coníferas, helechos y otras vegetaciones bajas. Su pico adaptado le permitía cortar y masticar con eficiencia las plantas duras.</p>

<h2>Comportamiento</h2>
<p>El Shantungosaurus probablemente vivía en grandes grupos, lo que le ayudaba a protegerse de los depredadores. Era un animal social que se desplazaba en manadas, lo que le otorgaba ventajas frente a los carnívoros.</p>

<h2>Reproducción</h2>
<p>El Shantungosaurus se reproducía por medio de <strong>huevos</strong>, como otros dinosaurios herbívoros. Se cree que las hembras construían nidos en el suelo donde depositaban sus huevos.</p>

<h2>Descubrimiento</h2>
<p>Los fósiles de Shantungosaurus fueron descubiertos en la década de 1950 en la provincia de Shandong, China. Fue descrito formalmente en 1973 por el paleontólogo Yang Zhongjian.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Shantungosaurus es un miembro de la familia Hadrosauridae, una familia que incluye a otros dinosaurios como el <em>Parasaurolophus</em>, <em>Maiasaura</em> y <em>Edmontosaurus</em>, todos conocidos por su capacidad para alimentarse de grandes cantidades de vegetación.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Shantungosaurus era uno de los hadrosaurios más grandes que vivieron, con una longitud comparable a la de un autobús escolar.</li>
    <li>Se cree que, debido a su tamaño, podía defenderse de los depredadores mediante su gran fuerza y su postura en manada.</li>
    <li>Este dinosaurio es un ejemplo de la gran diversidad de los dinosaurios herbívoros del Cretácico, con adaptaciones especializadas para alimentarse de plantas duras.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
