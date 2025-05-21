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
    <title>Stegosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Stegosaurus</h1>

<a href="../../../img/Stegosaurus.jpg" target="_blank">
    <img src="../../../img/Stegosaurus.jpg" alt="Stegosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Stegosaurus</strong> significa “lagarto con techo” o “lagarto techado”, en referencia a las placas óseas que recorren su espalda.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Suborden:</strong> Thyreophora</li>
    <li><strong>Familia:</strong> Stegosauridae</li>
    <li><strong>Género:</strong> Stegosaurus</li>
    <li><strong>Especie:</strong> S. stenops (principal especie)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Tardío</strong>, hace aproximadamente <strong>155 a 150 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles han sido encontrados en:
<ul>
    <li>Colorado (EE.UU.)</li>
    <li>Utah</li>
    <li>Wyoming</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 9 metros</li>
    <li><strong>Altura:</strong> Alrededor de 4 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 5 toneladas</li>
    <li><strong>Placas óseas:</strong> Grandes placas a lo largo del lomo, posiblemente para regulación térmica o defensa</li>
    <li><strong>Cola:</strong> Con púas llamadas "thagomizers", utilizadas como arma</li>
    <li><strong>Cerebro:</strong> Relativamente pequeño en comparación con su tamaño corporal</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> que se alimentaba de helechos, cícadas y plantas bajas. Tenía un pico sin dientes al frente y pequeñas muelas en la parte posterior.</p>

<h2>Comportamiento</h2>
<p>Probablemente vivía en pequeños grupos. Las placas dorsales podrían haber servido también para la exhibición y comunicación con otros miembros de su especie.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, el Stegosaurus se reproducía por <strong>huevos</strong>. Se han hallado nidos con huevos atribuidos a estegosáuridos, aunque no se han identificado especímenes juveniles con certeza.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Las placas no estaban alineadas simétricamente, sino en dos filas alternas.</li>
    <li>Su cola era muy musculosa y podía infligir heridas graves con sus púas.</li>
    <li>Vivía al mismo tiempo que otros grandes dinosaurios como Allosaurus y Apatosaurus.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
