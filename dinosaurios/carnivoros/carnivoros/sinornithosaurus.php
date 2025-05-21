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
    <title>Sinornithosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Sinornithosaurus</h1>

<a href="../../../img/Sinornithosaurus.webp" target="_blank">
    <img src="../../../img/Sinornithosaurus.webp" alt="Sinornithosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Sinornithosaurus</strong> significa "lagarto pájaro chino", en referencia a su descubrimiento en China y sus características similares a las de las aves.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Dromaeosauridae</li>
    <li><strong>Género:</strong> Sinornithosaurus</li>
    <li><strong>Especie:</strong> S. millenii</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Temprano</strong>, hace aproximadamente <strong>124 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles fueron hallados en la provincia de Liaoning, <strong>China</strong>, una región famosa por su excepcional preservación de fósiles con plumas.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Tamaño:</strong> Alrededor de 1 metro de largo</li>
    <li><strong>Peso:</strong> Unos pocos kilogramos</li>
    <li><strong>Plumas:</strong> Cubierto de plumas, lo que sugiere una estrecha relación con las aves</li>
    <li><strong>Dientes:</strong> Posiblemente venenosos, una característica única entre dinosaurios</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>carnívoro</strong> que probablemente cazaba pequeños reptiles, mamíferos y aves primitivas.</p>

<h2>Comportamiento</h2>
<p>Se cree que era un cazador ágil y posiblemente arborícola, moviéndose entre los árboles y emboscando a sus presas.</p>

<h2>Reproducción</h2>
<p>Como otros terópodos, ponía <strong>huevos</strong>. Es probable que construyera nidos y cuidara de sus crías.</p>

<h2>Descubrimiento</h2>
<p>Fue descubierto en 1999 y rápidamente se convirtió en una figura clave en el debate sobre la evolución de las aves a partir de dinosaurios terópodos.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Estaba estrechamente relacionado con otros dromeosáuridos como Velociraptor y Microraptor, todos ellos con evidencias de plumas.</p>

<h2>Importancia cultural</h2>
<p>Sinornithosaurus es uno de los principales dinosaurios utilizados para ilustrar el vínculo entre aves y dinosaurios, apareciendo en documentales y libros científicos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Uno de los primeros dinosaurios no avianos descubiertos con plumas bien preservadas.</li>
    <li>Podría haber tenido glándulas venenosas en sus dientes, según algunos estudios.</li>
    <li>Era tan liviano que se cree que pudo planear o incluso haber tenido un vuelo limitado.</li>
    <li>Su descubrimiento apoyó firmemente la teoría de que las aves evolucionaron de dinosaurios terópodos.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
