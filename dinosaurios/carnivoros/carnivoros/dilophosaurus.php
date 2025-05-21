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
    <title>Dilophosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Dilophosaurus</h1>

<a href="../../../img/dilophosaurus.webp" target="_blank">
    <img src="../../../img/dilophosaurus.webp" alt="Dilophosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Dilophosaurus</strong> significa "lagarto de dos crestas", del griego “di” (dos), “lophos” (cresta) y “sauros” (lagarto), por las dos crestas óseas que tenía sobre su cabeza.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Dilophosauridae</li>
    <li><strong>Género:</strong> Dilophosaurus</li>
    <li><strong>Especie:</strong> D. wetherilli</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Temprano</strong>, hace aproximadamente <strong>193 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus restos fósiles se han encontrado en:
<ul>
    <li>Estados Unidos (Arizona)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> 6 a 7 metros</li>
    <li><strong>Peso:</strong> 400 a 500 kg</li>
    <li><strong>Distintivo:</strong> Dos crestas delgadas en el cráneo</li>
    <li><strong>Brazos:</strong> Largos con manos de tres dedos</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>carnívoro</strong> que probablemente cazaba animales pequeños y también podía carroñear. Su dentadura no era muy robusta, lo que indica que no estaba adaptado para presas muy grandes.</p>

<h2>Comportamiento</h2>
<p>Probablemente era un cazador ágil y rápido. Las crestas se cree que eran usadas con fines de exhibición o reconocimiento entre individuos.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, se reproducía por <strong>huevos</strong>. No se han hallado nidos confirmados, pero se presume que los ponía en el suelo.</p>

<h2>Descubrimiento</h2>
<p>Fue descrito en 1954 por Sam Welles, basándose en fósiles hallados en la Formación Kayenta, Arizona.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Pertenece a los terópodos primitivos. Aunque vivió antes que otros grandes carnívoros, presenta rasgos que anticipan la evolución de terópodos posteriores.</p>

<h2>Importancia cultural</h2>
<p>Su fama aumentó por su aparición en <em>Jurassic Park</em>, aunque la película le atribuyó características ficticias como una gola extensible y veneno, sin base científica.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Fue uno de los primeros grandes terópodos conocidos del Jurásico.</li>
    <li>Sus crestas eran huecas y probablemente poco resistentes.</li>
    <li>Tenía una constitución ligera que favorecía la velocidad.</li>
    <li>Su cola era larga y flexible, ideal para equilibrar su cuerpo durante el movimiento.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
