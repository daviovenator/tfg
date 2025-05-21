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
    <title>Apatosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Apatosaurus</h1>

<a href="../../../img/Apatosaurus.webp" target="_blank">
    <img src="../../../img/Apatosaurus.webp" alt="Apatosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Apatosaurus</strong> significa "lagarto engañoso", un nombre que se refiere a la similitud de sus vértebras con las de otros reptiles marinos, lo que inicialmente confundió a los paleontólogos.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Sauropodomorpha</li>
    <li><strong>Familia:</strong> Diplodocidae</li>
    <li><strong>Género:</strong> Apatosaurus</li>
    <li><strong>Especie:</strong> A. ajax</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Tardío</strong>, hace entre <strong>152 y 151 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus restos fósiles se han encontrado en:
<ul>
    <li>Colorado</li>
    <li>Utah</li>
    <li>Wyoming</li>
    <li>Oklahoma</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 22 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 20 toneladas</li>
    <li><strong>Cuello:</strong> Largo y robusto, usado posiblemente para alimentación y defensa</li>
    <li><strong>Cola:</strong> Larga y flexible, posiblemente usada como látigo</li>
    <li><strong>Patas:</strong> Cuatro patas fuertes para soportar su gran masa</li>
</ul>

<h2>Alimentación</h2>
<p>Herbívoro. Se alimentaba de plantas bajas y medianas, usando su largo cuello para alcanzar vegetación a distintas alturas. No masticaba; tragaba piedras (gastrolitos) para ayudar a triturar la comida en el estómago.</p>

<h2>Comportamiento</h2>
<p>Probablemente vivía en grupos y se desplazaba lentamente. Su gran tamaño disuadía a los depredadores, aunque juveniles podían ser más vulnerables.</p>

<h2>Reproducción</h2>
<p>Se reproducía por <strong>huevos</strong>, como todos los dinosaurios. Es posible que las hembras pusieran los huevos en grandes nidos comunales.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Durante mucho tiempo fue confundido con el Brontosaurus, hasta que se aclaró su identidad en estudios recientes.</li>
    <li>Su cola podría haber producido un fuerte chasquido al moverla rápidamente, como una especie de látigo sónico.</li>
    <li>A pesar de su tamaño, su cerebro era bastante pequeño en proporción al cuerpo.</li>
    <li>Su estructura corporal robusta lo hacía uno de los saurópodos más poderosos del Jurásico.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
