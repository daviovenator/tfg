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
    <title>Mosasaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Mosasaurus</h1>

<a href="../../../img/mosasaurus.jpg" target="_blank">
    <img src="../../../img/mosasaurus.jpg" alt="Mosasaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Mosasaurus</strong> significa "lagarto de los ríos Mosa". El nombre proviene del río Mosa en Europa, donde fueron descubiertos los primeros restos de este enorme reptil marino.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Squamata</li>
    <li><strong>Suborden:</strong> Lacertilia</li>
    <li><strong>Familia:</strong> Mosasauridae</li>
    <li><strong>Género:</strong> Mosasaurus</li>
    <li><strong>Especie:</strong> M. hoffmanni</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Superior</strong>, hace aproximadamente <strong>70 a 65 millones de años</strong>, en el último periodo de la era Mesozoica.</p>

<h2>Distribución geográfica</h2>
<p>Sus restos han sido encontrados en diversas regiones del mundo, incluyendo:
<ul>
    <li>Europa</li>
    <li>América del Norte</li>
    <li>África</li>
    <li>Australia</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 17 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 15 toneladas</li>
    <li><strong>Cuerpo:</strong> Cuerpo largo y serpenteante, con una cola poderosa y una cabeza alargada</li>
    <li><strong>Mandíbulas:</strong> Mandíbulas muy potentes con dientes cónicos para atrapar presas resbaladizas, como peces y reptiles marinos.</li>
</ul>

<h2>Alimentación</h2>
<p>El Mosasaurus era un <strong>depredador marino</strong> que cazaba grandes peces, otros reptiles marinos e incluso pequeños dinosaurios acuáticos. Su estructura corporal lo hacía un excelente nadador, capaz de moverse rápidamente para capturar a sus presas.</p>

<h2>Comportamiento</h2>
<p>Probablemente cazaba de manera activa, usando su velocidad y agilidad para emboscar a sus presas. Al igual que otros reptiles marinos, tenía un estilo de vida totalmente acuático y estaba bien adaptado para la caza en los océanos.</p>

<h2>Reproducción</h2>
<p>Como otros reptiles marinos, Mosasaurus se reproducía mediante <strong>huevos</strong>, aunque no se tienen detalles precisos sobre los nidos. Se cree que era vivíparo, es decir, paría crías vivas, como sus parientes cercanos.</p>

<h2>Descubrimiento</h2>
<p>El primer fósil de Mosasaurus fue encontrado en 1764 en los Países Bajos. Fue descrito por primera vez por el paleontólogo Georges Cuvier en el siglo XIX, y su descubrimiento fue clave en el desarrollo de la paleontología moderna.</p>

<h2>Relación con otros animales</h2>
<p>Mosasaurus pertenece a la familia Mosasauridae, un grupo de reptiles marinos estrechamente relacionados con los actuales lagartos, pero mucho más grandes y adaptados a la vida acuática. Estaba relacionado con otros grandes mosasaurios como Tylosaurus y Platecarpus.</p>

<h2>Importancia cultural</h2>
<p>El Mosasaurus ha ganado notoriedad debido a su aparición en películas como *Jurassic World*, donde se presenta como uno de los grandes depredadores marinos del pasado. Su imagen de enorme reptil acuático ha cautivado la imaginación de muchas personas.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Mosasaurus podía nadar a grandes velocidades, lo que lo hacía un cazador muy eficiente.</li>
    <li>Era un depredador ápice en su ecosistema marino, sin competidores cercanos en su tamaño.</li>
    <li>Su mandíbula podía abrirse extremadamente amplia, permitiéndole capturar presas mucho más grandes que su cabeza.</li>
    <li>Su cola larga y musculosa le proporcionaba un impulso excelente para nadar rápidamente.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
