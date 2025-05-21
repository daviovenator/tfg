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
    <title>Postosuchus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Postosuchus</h1>

<a href="../../../img/postosuchus.jpg" target="_blank">
    <img src="../../../img/postosuchus.jpg" alt="Postosuchus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Postosuchus</strong> significa "lagarto de Posto", en referencia a la localidad de Post, Texas, donde se encontraron los primeros fósiles de esta especie. Su nombre proviene del griego "sauros" (lagarto) y el nombre de la localidad.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Archosauria</li>
    <li><strong>Familia:</strong> Postosuchidae</li>
    <li><strong>Género:</strong> Postosuchus</li>
    <li><strong>Especie:</strong> P. kirkpatricki (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Triásico Tardío</strong>, hace aproximadamente <strong>225 a 210 millones de años</strong>, antes de la aparición de los dinosaurios dominantes.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado en <strong>América del Norte</strong>, principalmente en lo que hoy es Texas, Estados Unidos.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Alrededor de 4-5 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 200-250 kg</li>
    <li><strong>Distintivo:</strong> Cuerpo robusto y postura erguida similar a los dinosaurios, con una cabeza alargada y dientes afilados para la caza</li>
    <li><strong>Brazos:</strong> Cortos, pero con garras fuertes que podrían haber sido útiles para capturar presas</li>
    <li><strong>Cola:</strong> Larga, lo que le ayudaba a equilibrar su cuerpo mientras se desplazaba</li>
</ul>

<h2>Alimentación</h2>
<p>El Postosuchus era un <strong>carnívoro</strong>, que cazaba otros reptiles y animales más pequeños de su época. Sus dientes eran ideales para desgarrar carne, y su fuerza física le permitía capturar y matar presas relativamente grandes.</p>

<h2>Comportamiento</h2>
<p>Se cree que el Postosuchus era un cazador activo, probablemente solitario, que utilizaba su velocidad y fuerza para emboscar y capturar presas. Su estructura corporal sugiere que podría haber sido un corredor ágil para su tamaño.</p>

<h2>Reproducción</h2>
<p>Como otros reptiles, el Postosuchus se reproducía por medio de <strong>huevos</strong>, aunque no se tienen muchos detalles sobre sus comportamientos reproductivos debido a la falta de fósiles de nidos o crías.</p>

<h2>Descubrimiento</h2>
<p>El Postosuchus fue descrito por el paleontólogo Edward Drinker Cope en 1880, después de que se encontraran fósiles de esta especie en la Formación Post, en Texas.</p>

<h2>Relación con otros organismos</h2>
<p>El Postosuchus era un archosaurio, un grupo de reptiles que incluye a los antecesores de los dinosaurios. Aunque no era un dinosaurio, se considera uno de los parientes más cercanos de estos, debido a su postura erguida y características similares.</p>

<h2>Importancia cultural</h2>
<p>Aunque no es tan conocido como los dinosaurios, el Postosuchus ha sido un ejemplo importante de los animales precursores de los dinosaurios que dominarían la Tierra después. Su estudio ha ayudado a los paleontólogos a entender la evolución de los dinosaurios.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Postosuchus vivió en un ecosistema dominado por otros grandes reptiles, pero fue uno de los depredadores más importantes de su tiempo.</li>
    <li>Este reptil tiene una apariencia que se asemeja a los dinosaurios carnívoros, aunque pertenecía a un grupo diferente de reptiles.</li>
    <li>Su robusta constitución y dientes afilados indican que era un depredador eficiente y temido en su tiempo.</li>
    <li>El Postosuchus coexistió con otros reptiles primitivos como los arcosaurios y los pterosaurios.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
