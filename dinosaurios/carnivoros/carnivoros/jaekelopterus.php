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
    <title>Jaekelopterus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Jaekelopterus</h1>

<a href="../../../img/Jaekelopterus.webp" target="_blank">
    <img src="../../../img/Jaekelopterus.webp" alt="Jaekelopterus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Jaekelopterus</strong> significa "patarra de Jaekel", en honor al paleontólogo alemán Karl Jaekel, quien descubrió los primeros fósiles de este gigantesco artrópodo. El nombre proviene del griego "pteron" (ala o aleta) y "Jaekel", en referencia al científico.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Arthropoda</li>
    <li><strong>Clase:</strong> Chelicerata</li>
    <li><strong>Orden:</strong> Eurypterida</li>
    <li><strong>Familia:</strong> Jaekelopteridae</li>
    <li><strong>Género:</strong> Jaekelopterus</li>
    <li><strong>Especie:</strong> J. rhenaniae (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Devónico</strong>, hace aproximadamente <strong>395 millones de años</strong>, en una era en la que los euriptéridos dominaban los mares y zonas costeras.</p>

<h2>Distribución geográfica</h2>
<p>Los fósiles de Jaekelopterus han sido encontrados en lo que hoy es Alemania, en la región de Renania, donde se encuentra la Formación de Rhenania.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 2.5 metros, lo que lo convierte en uno de los euriptéridos más grandes conocidos.</li>
    <li><strong>Características distintivas:</strong> Cuerpo alargado y segmentado, con grandes pinzas frontales (como las de un escorpión), adaptadas para capturar presas.</li>
    <li><strong>Exoesqueleto:</strong> Con una serie de segmentos de exoesqueleto que le daban una gran resistencia.</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>carnívoro</strong> que probablemente cazaba y se alimentaba de peces y otros invertebrados marinos, utilizando sus poderosas pinzas para atrapar y desgarrar a sus presas.</p>

<h2>Comportamiento</h2>
<p>Se cree que Jaekelopterus habitaba en las costas de los mares primitivos, moviéndose tanto en agua como en tierra. Probablemente cazaba en grupos, lo que le habría permitido dominar sus hábitats costeros.</p>

<h2>Reproducción</h2>
<p>Como otros euriptéridos, se reproducía por medio de <strong>huevos</strong>. No se tienen detalles precisos sobre sus nidos o cuidado parental, pero es probable que sus crías fueran acuáticas desde el principio.</p>

<h2>Descubrimiento</h2>
<p>El Jaekelopterus fue descrito por el paleontólogo alemán Karl Jaekel en 1911, basándose en fósiles encontrados en la región de Renania, Alemania. Su tamaño impresionante lo convirtió en una de las especies más notables de los euriptéridos.</p>

<h2>Relación con otros animales</h2>
<p>El Jaekelopterus pertenecía al orden Eurypterida, una familia de artrópodos marinos que son conocidos como "escorpiones de mar". Aunque se extinguieron hace más de 250 millones de años, los euriptéridos fueron uno de los grupos dominantes de la era Paleozoica.</p>

<h2>Importancia cultural</h2>
<p>Aunque no es tan conocido como otros animales prehistóricos, Jaekelopterus es popular en el ámbito paleontológico debido a su tamaño impresionante y su relación con los antiguos escorpiones marinos. Ha aparecido en documentales y libros de paleontología.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Es uno de los artrópodos más grandes que jamás haya existido.</li>
    <li>A pesar de su tamaño, era un animal marino que vivía en aguas poco profundas, como en estuarios o en la costa.</li>
    <li>Jaekelopterus compartió hábitat con otros grandes euriptéridos y peces primitivos.</li>
    <li>Su gran tamaño lo hacía una de las especies más temibles de su época.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
