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
    <title>Parasaurolophus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Parasaurolophus</h1>

<a href="../../../img/Parasaurolophus.jpg" target="_blank">
    <img src="../../../img/Parasaurolophus.jpg" alt="Parasaurolophus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Parasaurolophus</strong> significa "cerca del lagarto con cresta", refiriéndose a su similitud con Saurolophus, otro dinosaurio con cresta.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Familia:</strong> Hadrosauridae</li>
    <li><strong>Género:</strong> Parasaurolophus</li>
    <li><strong>Especie:</strong> P. walkeri (entre otras)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Tardío</strong>, hace aproximadamente <strong>76 a 73 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles en:
<ul>
    <li>Canadá (Alberta)</li>
    <li>Estados Unidos (Nuevo México y Utah)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 10 metros</li>
    <li><strong>Altura:</strong> Hasta 4 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 3 toneladas</li>
    <li><strong>Cresta craneal:</strong> Larga y hueca, posiblemente usada para la comunicación o regulación térmica</li>
    <li><strong>Pico:</strong> Sin dientes en la parte frontal, ideal para arrancar vegetación</li>
</ul>

<h2>Alimentación</h2>
<p><strong>Herbívoro</strong>. Su dieta consistía en plantas como coníferas, helechos y angiospermas. Su aparato masticador era uno de los más avanzados entre los dinosaurios herbívoros.</p>

<h2>Comportamiento</h2>
<p>Probablemente vivía en manadas. Se movía tanto en dos como en cuatro patas. Su cresta podría haber servido para emitir sonidos de baja frecuencia, útil para la comunicación a larga distancia.</p>

<h2>Reproducción</h2>
<p>Como los demás dinosaurios, ponía <strong>huevos</strong>. Es posible que las crías fueran precoces y estuvieran bien desarrolladas al nacer.</p>

<h2>Curiosidades</h2>
<ul>
    <li>La cresta podía medir más de 1.5 metros de largo.</li>
    <li>Algunos científicos creen que podía producir sonidos similares a un cuerno o trompeta.</li>
    <li>Era uno de los hadrosáuridos más conocidos por su forma llamativa.</li>
    <li>Fue representado en muchas películas y documentales por su aspecto único.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
