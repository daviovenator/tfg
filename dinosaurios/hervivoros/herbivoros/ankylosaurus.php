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
    <title>Ankylosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Ankylosaurus</h1>

<a href="../../../img/Ankylosaurus.jpeg" target="_blank">
    <img src="../../../img/Ankylosaurus.jpeg" alt="Ankylosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Ankylosaurus</strong> significa "lagarto fusionado", en referencia a sus huesos fuertemente unidos que formaban una armadura corporal muy resistente.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Suborden:</strong> Thyreophora</li>
    <li><strong>Familia:</strong> Ankylosauridae</li>
    <li><strong>Género:</strong> Ankylosaurus</li>
    <li><strong>Especie:</strong> A. magniventris</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Tardío</strong>, entre hace <strong>68 y 66 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Fósiles encontrados principalmente en:
<ul>
    <li>Montana</li>
    <li>Wyoming</li>
    <li>Alberta (Canadá)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 8 metros</li>
    <li><strong>Peso:</strong> Unas 6 toneladas</li>
    <li><strong>Armadura:</strong> Placas óseas y espinas cubrían su lomo y costados</li>
    <li><strong>Cola:</strong> Terminaba en una gran maza ósea usada como defensa</li>
    <li><strong>Piernas:</strong> Cortas y robustas</li>
    <li><strong>Cabeza:</strong> Ancha, baja y también protegida por placas óseas</li>
</ul>

<h2>Alimentación</h2>
<p><strong>Herbívoro</strong>. Se alimentaba de plantas bajas como helechos y cicadáceas. Tenía un pico córneo para arrancar vegetación y dientes pequeños para masticar.</p>

<h2>Comportamiento</h2>
<p>Era un dinosaurio de movimientos lentos, pero extremadamente bien defendido. Su cola acorazada podía fracturar huesos de posibles depredadores como el T. rex.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios, ponía <strong>huevos</strong>. Se piensa que las crías nacían ya con una armadura parcial y crecían rápidamente.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Su armadura estaba compuesta de osteodermos, huesos incrustados en la piel.</li>
    <li>Tenía fosas nasales grandes, lo que sugiere un buen sentido del olfato.</li>
    <li>Aunque robusto, tenía un cerebro pequeño.</li>
    <li>Era uno de los últimos dinosaurios acorazados antes de la extinción masiva.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
