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
    <title>Dunkleosteus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Dunkleosteus</h1>

<a href="../../../img/Dunkleosteus.jpg" target="_blank">
    <img src="../../../img/Dunkleosteus.jpg" alt="Dunkleosteus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Dunkleosteus</strong> significa "pez de Dunkle", en honor al paleontólogo David Dunkle, quien descubrió los primeros fósiles de este animal en los años 50.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Placodermi</li>
    <li><strong>Orden:</strong> Arthrodira</li>
    <li><strong>Familia:</strong> Dunkleosteidae</li>
    <li><strong>Género:</strong> Dunkleosteus</li>
    <li><strong>Especie:</strong> D. terrelli</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Devónico</strong>, hace aproximadamente <strong>358 a 382 millones de años</strong>, en un período de la historia de la Tierra conocido como la "Era de los peces."</p>

<h2>Distribución geográfica</h2>
<p>Los fósiles de Dunkleosteus se han encontrado en diversas partes del mundo, como:
<ul>
    <li>América del Norte</li>
    <li>Europa (en lo que hoy es Marruecos y Bélgica)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 10 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 4 toneladas</li>
    <li><strong>Constitución:</strong> Cuerpo robusto, cabeza grande con placas óseas en lugar de dientes</li>
    <li><strong>Mandíbula:</strong> Poseía poderosas mandíbulas con una mordida extremadamente fuerte, capaz de triturar huesos</li>
</ul>

<h2>Alimentación</h2>
<p>Dunkleosteus era un <strong>carnívoro</strong> y uno de los depredadores más formidables de su tiempo. Se alimentaba principalmente de peces más pequeños, y su poderosa mordida le permitía romper la armadura de otros placodermos.</p>

<h2>Comportamiento</h2>
<p>Probablemente era un cazador solitario. Su gran tamaño y fuerza lo convertían en uno de los principales depredadores marinos de su época.</p>

<h2>Reproducción</h2>
<p>Dunkleosteus se reproducía por <strong>ovoviviparidad</strong>, lo que significa que los huevos se desarrollaban internamente y nacían como crías vivas, una característica poco común entre los peces placodermos.</p>

<h2>Descubrimiento</h2>
<p>Los restos de Dunkleosteus fueron descubiertos por primera vez en el siglo XIX, y más tarde, el paleontólogo David Dunkle realizó importantes estudios sobre esta especie.</p>

<h2>Relación con otros animales</h2>
<p>Los Dunkleosteus eran parte de un grupo de peces placodermos, un linaje primitivo de peces armados que vivió en los océanos durante el Devónico.</p>

<h2>Importancia cultural</h2>
<p>Dunkleosteus ha sido un símbolo de la fauna prehistórica debido a su enorme tamaño y su impresionante armadura. A menudo aparece en libros y documentales sobre la vida marina prehistórica.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Era uno de los depredadores más grandes de su época, capaz de romper con facilidad las placas óseas de otros peces.</li>
    <li>Su mandíbula era extremadamente poderosa, capaz de ejercer una presión de hasta 2 toneladas.</li>
    <li>Aunque no tenía dientes, sus mandíbulas formaban una especie de "corteza" extremadamente afilada, similar a una guillotina.</li>
    <li>Al igual que otros placodermos, Dunkleosteus se extinguió al final del Devónico, cuando los ecosistemas marinos cambiaron radicalmente.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
