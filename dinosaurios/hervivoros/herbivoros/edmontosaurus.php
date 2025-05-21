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
    <title>Edmontosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Edmontosaurus</h1>

<a href="../../../img/edmontosaurus.jpg" target="_blank">
    <img src="../../../img/edmontosaurus.jpg" alt="Edmontosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Edmontosaurus</strong> significa "lagarto de Edmonton", en referencia a la ciudad canadiense de Edmonton, donde se han encontrado muchos de sus fósiles.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Familia:</strong> Hadrosauridae</li>
    <li><strong>Género:</strong> Edmontosaurus</li>
    <li><strong>Especie:</strong> E. regalis (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Tardío</strong>, hace aproximadamente <strong>73 a 65 millones de años</strong>, en la misma época que el Tyrannosaurus rex.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles en:
<ul>
    <li>Canadá (Alberta)</li>
    <li>Estados Unidos (Montana, Dakota del Sur, Wyoming)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 13 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 4-5 toneladas</li>
    <li><strong>Cabeza:</strong> De forma alargada, sin cuerno, con un pico similar al de un pato</li>
    <li><strong>Cola:</strong> Larga y robusta, utilizada para equilibrar el cuerpo mientras caminaba</li>
    <li><strong>Postura:</strong> Cuadrúpeda en movimiento lento, pero bípedo en posiciones rápidas</li>
</ul>

<h2>Alimentación</h2>
<p><strong>Herbívoro</strong>. Se alimentaba principalmente de plantas, como helechos, coníferas y angiospermas, utilizando su pico especializado para arrancar vegetación.</p>

<h2>Comportamiento</h2>
<p>Probablemente vivía en manadas, ya que se han encontrado múltiples fósiles de individuos juntos. Su gran tamaño y fuerza le permitían defenderse de predadores, como el Tyrannosaurus rex.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, el Edmontosaurus se reproducía por <strong>huevos</strong>, que probablemente ponía en nidos formados en el suelo.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Es uno de los hadrosáuridos más conocidos y mejor documentados.</li>
    <li>Su pico y dientes eran ideales para cortar plantas duras y fibrosas.</li>
    <li>Se cree que formaba parte de grandes manadas, lo que le ayudaba a protegerse de depredadores.</li>
    <li>Se encuentra entre los últimos dinosaurios herbívoros antes de la extinción masiva del Cretácico-Paleógeno.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
