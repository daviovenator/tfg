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
    <title>Quetzalcoatlus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Quetzalcoatlus</h1>

<a href="../../../img/quetzalcoatlus.jpg" target="_blank">
    <img src="../../../img/quetzalcoatlus.jpg" alt="Quetzalcoatlus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Quetzalcoatlus</strong> es un nombre que proviene del dios azteca "Quetzalcoatl", que representaba una serpiente emplumada. El nombre hace referencia al tamaño impresionante de este pterosaurio, similar a un ave majestuosa. El término "quetzal" proviene del náhuatl, una palabra que designa a un ave con plumas brillantes, y "coatl" significa serpiente.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Pterosauria</li>
    <li><strong>Familia:</strong> Azhdarchidae</li>
    <li><strong>Género:</strong> Quetzalcoatlus</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Superior</strong>, hace aproximadamente <strong>70 a 65 millones de años</strong>, justo antes de la extinción masiva que acabó con los dinosaurios.</p>

<h2>Distribución geográfica</h2>
<p>Los fósiles de Quetzalcoatlus han sido encontrados en América del Norte, específicamente en lo que hoy es Texas, Estados Unidos.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Envergadura:</strong> Hasta 10-11 metros</li>
    <li><strong>Longitud:</strong> Hasta 10 metros</li>
    <li><strong>Peso:</strong> Se estima que pesaba alrededor de 200-250 kg</li>
    <li><strong>Distintivo:</strong> Su cuello largo y delgado y su pico sin dientes</li>
    <li><strong>Alas:</strong> Al igual que otros pterosaurios, tenía grandes alas membranosas que le permitían volar distancias largas</li>
</ul>

<h2>Alimentación</h2>
<p>El Quetzalcoatlus era un <strong>carnívoro</strong> que probablemente se alimentaba de pequeños dinosaurios, reptiles y peces. Algunos estudios sugieren que también podría haber sido carroñero.</p>

<h2>Comportamiento</h2>
<p>Este pterosaurio es conocido por su gran tamaño y habilidad para volar largas distancias. Es probable que pasara mucho tiempo en el aire, buscando comida o explorando nuevos territorios.</p>

<h2>Reproducción</h2>
<p>Como todos los pterosaurios, el Quetzalcoatlus se reproducía poniendo huevos. No se tiene mucha información sobre sus comportamientos reproductivos específicos debido a la falta de fósiles de nidos o crías.</p>

<h2>Descubrimiento</h2>
<p>El Quetzalcoatlus fue descubierto en 1971 por el paleontólogo Douglas A. Lawson en Texas. El hallazgo fue importante, ya que proporcionó información sobre los pterosaurios gigantes del Cretácico.</p>

<h2>Relación con otros organismos</h2>
<p>Pertenecía a la familia Azhdarchidae, un grupo de pterosaurios caracterizados por su cuello largo, pico sin dientes y gran envergadura. Los pterosaurios relacionados incluyen a otros como Arambourgiania.</p>

<h2>Importancia cultural</h2>
<p>El Quetzalcoatlus ha sido representado en diversas películas y documentales sobre dinosaurios, a menudo siendo destacado por su tamaño colosal y sus características únicas como pterosaurio.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Quetzalcoatlus es uno de los pterosaurios más grandes que jamás haya existido.</li>
    <li>Su gran tamaño lo hacía una de las criaturas voladoras más imponentes del Cretácico.</li>
    <li>Es posible que el Quetzalcoatlus haya practicado un comportamiento de vuelo similar al de los albatros, planeando largas distancias sin mucho esfuerzo.</li>
    <li>Aunque su pico era sin dientes, podría haber utilizado su pico largo y flexible para atrapar presas pequeñas en el suelo.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
