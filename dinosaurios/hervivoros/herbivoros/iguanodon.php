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
    <title>Iguanodon - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Iguanodon</h1>

<a href="../../../img/Iguanodon.webp" target="_blank">
    <img src="../../../img/Iguanodon.webp" alt="Iguanodon" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Iguanodon</strong> significa "diente de iguana", ya que sus dientes se parecían a los de las iguanas modernas, aunque mucho más grandes y fuertes.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Familia:</strong> Iguanodontidae</li>
    <li><strong>Género:</strong> Iguanodon</li>
    <li><strong>Especie:</strong> I. bernissartensis</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Temprano</strong>, hace entre <strong>126 y 113 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus restos se han encontrado en:
<ul>
    <li>Europa (especialmente en Bélgica e Inglaterra)</li>
    <li>África del Norte</li>
    <li>Asia</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 10 metros</li>
    <li><strong>Peso:</strong> Hasta 4 toneladas</li>
    <li><strong>Patas:</strong> Caminaba en dos o cuatro patas</li>
    <li><strong>Pulgar:</strong> Poseía un espolón óseo afilado en el pulgar para defensa</li>
    <li><strong>Mandíbulas:</strong> Equipadas con numerosos dientes adaptados para masticar plantas</li>
</ul>

<h2>Alimentación</h2>
<p><strong>Herbívoro</strong>. Comía vegetación como helechos, cicadáceas y coníferas. Sus dientes estaban diseñados para triturar eficientemente el material vegetal.</p>

<h2>Comportamiento</h2>
<p>Se cree que vivía en grupos para protección. Caminaba sobre sus patas traseras pero podía usar las delanteras al pastar o desplazarse lentamente.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, se reproducía por <strong>huevos</strong>. Los nidos probablemente eran cavidades en el suelo, y las crías nacían relativamente desarrolladas.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Fue uno de los primeros dinosaurios descubiertos y nombrados científicamente (1825).</li>
    <li>Inicialmente se pensaba que su pulgar era un cuerno en la nariz.</li>
    <li>Uno de los primeros esqueletos completos se encontró en una mina de carbón en Bélgica en 1878.</li>
    <li>Sus mandíbulas tenían un complejo mecanismo de masticación único entre los dinosaurios.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
