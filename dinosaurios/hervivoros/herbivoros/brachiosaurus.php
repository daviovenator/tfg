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
    <title>Brachiosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Brachiosaurus</h1>

<a href="../../../img/Brachiosaurus.jpg" target="_blank">
    <img src="../../../img/Brachiosaurus.jpg" alt="Brachiosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Brachiosaurus</strong> significa "lagarto brazo", en referencia a sus patas delanteras notablemente más largas que las traseras, lo que le daba una postura inclinada hacia arriba.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Sauropodomorpha</li>
    <li><strong>Familia:</strong> Brachiosauridae</li>
    <li><strong>Género:</strong> Brachiosaurus</li>
    <li><strong>Especie:</strong> B. altithorax</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Tardío</strong>, hace aproximadamente <strong>154 a 150 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Fósiles de Brachiosaurus han sido encontrados principalmente en:
<ul>
    <li>Colorado</li>
    <li>Utah</li>
    <li>Wyoming</li>
    <li>Tanzania (parientes cercanos del género)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 25 metros</li>
    <li><strong>Altura:</strong> Hasta 12 metros</li>
    <li><strong>Peso:</strong> Entre 30 y 50 toneladas</li>
    <li><strong>Cuello:</strong> Largo y elevado, le permitía alimentarse de las copas de los árboles</li>
    <li><strong>Postura:</strong> Patas delanteras más largas que las traseras, a diferencia de la mayoría de los saurópodos</li>
    <li><strong>Cola:</strong> Larga, pero no tan robusta como en otros saurópodos</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> que se alimentaba principalmente de hojas de coníferas, cicadáceas y otras plantas altas. No masticaba, sino que tragaba la vegetación entera.</p>

<h2>Comportamiento</h2>
<p>Probablemente vivía en grupos y se desplazaba lentamente. Su gran tamaño lo protegía de la mayoría de los depredadores.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios, se reproducía mediante <strong>huevos</strong>. Se cree que las hembras depositaban sus huevos en el suelo, en zonas seguras de anidación.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Era uno de los dinosaurios más altos conocidos.</li>
    <li>Fue uno de los primeros dinosaurios en aparecer en la película <em>Jurassic Park</em>.</li>
    <li>Durante años fue considerado el dinosaurio más grande, aunque ahora se conocen otros saurópodos más largos o pesados.</li>
    <li>Se piensa que podía levantar ligeramente sus patas delanteras para alcanzar aún mayor altura.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
