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
    <title>Equisetum - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Equisetum</h1>

<a href="../../../img/Equisetum.jpg" target="_blank">
    <img src="../../../img/Equisetum.jpg" alt="Equisetum" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Equisetum</strong> proviene del latín "equus" (caballo) y "seta" (cerda), haciendo referencia a su aspecto filamentoso y delgado. También se le conoce como <em>cola de caballo</em>.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Equisetophyta</li>
    <li><strong>Clase:</strong> Equisetopsida</li>
    <li><strong>Orden:</strong> Equisetales</li>
    <li><strong>Familia:</strong> Equisetaceae</li>
    <li><strong>Género:</strong> Equisetum</li>
</ul>

<h2>Periodo geológico</h2>
<p>Este género tiene una larga historia evolutiva, con antecesores que datan del <strong>Devónico</strong> y alcanzaron su auge en el <strong>Carbonífero</strong>. Las especies actuales son los últimos representantes vivos del grupo.</p>

<h2>Distribución geográfica</h2>
<p>El Equisetum se encuentra en todo el mundo, principalmente en zonas templadas y húmedas, en bordes de ríos, pantanos y suelos húmedos.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Tamaño:</strong> De 10 cm hasta 1.5 metros, dependiendo de la especie.</li>
    <li><strong>Tallos:</strong> Segmentados, huecos y con anillos marcados.</li>
    <li><strong>Hojas:</strong> Pequeñas y dispuestas en verticilos alrededor de los nudos del tallo.</li>
    <li><strong>Textura:</strong> Áspera por su contenido en sílice.</li>
</ul>

<h2>Alimentación</h2>
<p>Realiza <strong>fotosíntesis</strong>, como todas las plantas verdes, absorbiendo dióxido de carbono y utilizando la luz solar para producir energía.</p>

<h2>Comportamiento</h2>
<p>Prefiere hábitats húmedos y sombreados, se reproduce eficientemente por rizomas subterráneos y puede formar colonias densas.</p>

<h2>Reproducción</h2>
<p>Se reproduce por <strong>esporas</strong> en estructuras llamadas estróbilos en la punta de los tallos fértiles, sin flores ni semillas.</p>

<h2>Descubrimiento</h2>
<p>Fósiles de plantas similares al Equisetum datan de hace más de 300 millones de años. Las especies modernas son consideradas "fósiles vivientes".</p>

<h2>Relación con otras plantas</h2>
<p>Son parientes de otros helechos, pero forman su propia división dentro de las plantas vasculares sin semillas.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Su alto contenido de sílice lo hacía útil como abrasivo natural para limpiar utensilios.</li>
    <li>Fue usado en medicina tradicional para tratar problemas urinarios.</li>
    <li>Son de las pocas plantas vasculares que no tienen hojas verdaderas ni semillas.</li>
    <li>Las especies del género Equisetum son consideradas fósiles vivientes, con poco cambio morfológico desde tiempos prehistóricos.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
