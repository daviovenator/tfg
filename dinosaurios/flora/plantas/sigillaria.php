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
    <title>Sigillaria - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Sigillaria</h1>

<a href="../../../img/sigillaria.jpg" target="_blank">
    <img src="../../../img/sigillaria.jpg" alt="Sigillaria" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Sigillaria</strong> debe su nombre al patrón de cicatrices en forma de sello (del latín "sigillum") que dejan sus hojas en el tallo.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Lycopodiophyta</li>
    <li><strong>Clase:</strong> Isoetopsida</li>
    <li><strong>Orden:</strong> Lepidodendrales</li>
    <li><strong>Familia:</strong> Sigillariaceae</li>
    <li><strong>Género:</strong> Sigillaria</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Pérmico y Carbonífero</strong>, hace aproximadamente <strong>300 a 250 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Los fósiles de Sigillaria se han encontrado principalmente en Europa y América del Norte, en antiguas zonas pantanosas y bosques de carbón.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Altura:</strong> Podía alcanzar hasta 30 metros de altura.</li>
    <li><strong>Tallo:</strong> Recto y columnar, con un patrón distintivo de cicatrices de hojas.</li>
    <li><strong>Hojas:</strong> Largas, similares a agujas, dispuestas en espiral.</li>
    <li><strong>Raíces:</strong> Tipo rizoma, adaptadas a suelos pantanosos.</li>
</ul>

<h2>Alimentación</h2>
<p>Como todas las plantas, Sigillaria era <strong>autótrofa</strong>, realizaba la fotosíntesis gracias a su gran superficie foliar.</p>

<h2>Comportamiento</h2>
<p>Se desarrollaba en ambientes húmedos y tenía un crecimiento rápido, lo cual le permitía formar grandes bosques junto a otras especies como Lepidodendron.</p>

<h2>Reproducción</h2>
<p>Se reproducía por <strong>esporas</strong>, que se liberaban desde estructuras especializadas llamadas esporangios, ubicadas en la parte superior del tallo.</p>

<h2>Descubrimiento</h2>
<p>Sigillaria fue descrita en el siglo XIX a partir de fósiles hallados en minas de carbón, donde sus impresiones vegetales eran comunes en estratos de carbón fósil.</p>

<h2>Relación con otras plantas</h2>
<p>Está relacionada con otras licofitas gigantes del Carbonífero, como <em>Lepidodendron</em>, y no debe confundirse con árboles modernos pese a su gran tamaño.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Formó parte de los grandes bosques del Carbonífero, que dieron origen a los actuales yacimientos de carbón.</li>
    <li>Su patrón de cicatrices le da un aspecto único, fácilmente reconocible en fósiles.</li>
    <li>Era una planta sin flores ni semillas, con reproducción por esporas como los helechos.</li>
    <li>Aunque se extinguió hace millones de años, sus restos son fundamentales en la paleobotánica.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
