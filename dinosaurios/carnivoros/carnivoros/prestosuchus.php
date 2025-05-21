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
    <title>Prestosuchus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Prestosuchus</h1>

<a href="../../../img/Prestosuchus.jpg" target="_blank">
    <img src="../../../img/Prestosuchus.jpg" alt="Prestosuchus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Prestosuchus</strong> significa "lagarto rápido", en referencia a su probable agilidad y velocidad para cazar. El nombre proviene del griego "presto" (rápido) y "sauros" (lagarto).</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Archosauria</li>
    <li><strong>Familia:</strong> Prestosuchidae</li>
    <li><strong>Género:</strong> Prestosuchus</li>
    <li><strong>Especie:</strong> P. chiniquensis (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Triásico Medio</strong>, hace aproximadamente <strong>230 a 220 millones de años</strong>, en un periodo previo a la aparición de los dinosaurios dominantes.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado en <strong>Sudamérica</strong>, específicamente en lo que hoy es Brasil.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 4-5 metros</li>
    <li><strong>Peso:</strong> Estimado en unos 200-300 kg</li>
    <li><strong>Distintivo:</strong> Cuerpo robusto con una postura erguida, una cabeza grande y dientes afilados</li>
    <li><strong>Brazos:</strong> Cortos pero fuertes, con garras en los dedos</li>
    <li><strong>Cola:</strong> Larga y flexible, probablemente utilizada para equilibrar su cuerpo mientras corría</li>
</ul>

<h2>Alimentación</h2>
<p>El Prestosuchus era un <strong>carnívoro</strong> que cazaba otros reptiles y animales más pequeños. Sus dientes afilados y su agilidad sugieren que era un depredador eficiente, probablemente emboscando a sus presas o persiguiéndolas activamente.</p>

<h2>Comportamiento</h2>
<p>Prestosuchus probablemente era un cazador solitario y activo. Su estructura corporal le habría permitido moverse rápidamente, lo que lo hacía un excelente depredador de su tiempo. Su agilidad y velocidad habrían sido sus principales ventajas para capturar presas.</p>

<h2>Reproducción</h2>
<p>Como otros reptiles de su época, el Prestosuchus se reproducía mediante <strong>huevos</strong>. Sin embargo, se sabe poco sobre su comportamiento reproductivo debido a la falta de fósiles de nidos o crías.</p>

<h2>Descubrimiento</h2>
<p>El Prestosuchus fue descrito por el paleontólogo brasileño A. F. B. de Souza en 1957, a partir de fósiles encontrados en el estado de Rio Grande do Sul, Brasil.</p>

<h2>Relación con otros organismos</h2>
<p>El Prestosuchus pertenecía a los arcosaurios, un grupo de reptiles que incluye a los antecesores de los dinosaurios. Aunque no era un dinosaurio, comparte muchas características con ellos, como su postura erguida y su especialización como depredador.</p>

<h2>Importancia cultural</h2>
<p>A pesar de no ser tan conocido como otros reptiles prehistóricos, el Prestosuchus ha sido un importante ejemplo de los animales previos a la aparición de los dinosaurios, proporcionando información clave sobre la evolución de los arcosaurios.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Prestosuchus es considerado uno de los precursores de los dinosaurios, mostrando características que más tarde serían comunes en muchos de ellos.</li>
    <li>Su agilidad sugiere que podría haber sido uno de los primeros grandes depredadores terrestres de su tiempo.</li>
    <li>El Prestosuchus compartió hábitat con otros reptiles prehistóricos, incluyendo los dinosaurios más primitivos y otros arcosaurios.</li>
    <li>Su estructura corporal y habilidades de caza lo convierten en uno de los animales más interesantes de su época.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
