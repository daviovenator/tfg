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
    <title>Ginkgophyta - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Ginkgophyta (Ginkgo)</h1>

<a href="../../../img/Ginkgophyta (Ginkgo).jpg" target="_blank">
    <img src="../../../img/Ginkgophyta (Ginkgo).jpg" alt="Ginkgophyta" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Ginkgophyta</strong> es el nombre del filo al que pertenece el Ginkgo biloba, único representante vivo de este grupo de plantas antiguas. Su nombre proviene del japonés "gin" (plata) y "kyo" (albaricoque), haciendo referencia a sus semillas.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Ginkgophyta</li>
    <li><strong>Clase:</strong> Ginkgoopsida</li>
    <li><strong>Orden:</strong> Ginkgoales</li>
    <li><strong>Familia:</strong> Ginkgoaceae</li>
    <li><strong>Género:</strong> Ginkgo</li>
    <li><strong>Especie:</strong> Ginkgo biloba</li>
</ul>

<h2>Periodo geológico</h2>
<p>El grupo Ginkgophyta apareció por primera vez en el <strong>Pérmico</strong>, hace más de <strong>270 millones de años</strong>, y fue abundante durante el <strong>Jurásico</strong> y <strong>Cretácico</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Actualmente, el <strong>Ginkgo biloba</strong> se encuentra en todo el mundo como árbol ornamental, pero es originario de China, donde también se considera una planta sagrada.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Altura:</strong> Hasta 35 metros.</li>
    <li><strong>Hojas:</strong> En forma de abanico, bilobuladas, únicas entre las plantas con semillas.</li>
    <li><strong>Semillas:</strong> Carnosas y de olor fuerte; no forman frutos verdaderos.</li>
    <li><strong>Madera:</strong> De crecimiento lento, resistente a enfermedades y contaminación.</li>
</ul>

<h2>Alimentación</h2>
<p>Como todas las plantas verdes, realiza <strong>fotosíntesis</strong> para convertir la energía solar en nutrientes.</p>

<h2>Comportamiento</h2>
<p>Es una planta extremadamente resistente, tolerante a la contaminación, enfermedades y condiciones urbanas. Puede vivir más de 1000 años.</p>

<h2>Reproducción</h2>
<p>Reproduce mediante <strong>semillas</strong> que se desarrollan tras la fecundación de los gametos producidos en órganos masculinos y femeninos separados (especie dioica).</p>

<h2>Descubrimiento</h2>
<p>Conocido en Asia desde hace siglos, fue redescubierto por botánicos europeos en el siglo XVII. Se considera un <strong>fósil viviente</strong> por su parecido con sus ancestros fósiles.</p>

<h2>Relación con otras plantas</h2>
<p>Está relacionado con otras gimnospermas como las coníferas y las cícadas, aunque posee características únicas que lo distinguen claramente.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Es la única especie viva de su división: Ginkgophyta.</li>
    <li>Algunos árboles de Ginkgo sobrevivieron a la bomba atómica en Hiroshima.</li>
    <li>Sus hojas se usan en medicina tradicional y suplementos para la memoria.</li>
    <li>Es símbolo de longevidad y resistencia en varias culturas orientales.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
