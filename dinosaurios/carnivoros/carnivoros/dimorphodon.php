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
    <title>Dimorphodon - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Dimorphodon</h1>

<a href="../../../img/Dimorphodon.webp" target="_blank">
    <img src="../../../img/Dimorphodon.webp" alt="Dimorphodon" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Dimorphodon</strong> proviene del griego, donde "di" significa dos y "morphos" significa forma, refiriéndose a la característica distintiva de este pterosaurio: su dentadura, que presentaba dos tipos diferentes de dientes. Es una referencia a las diferencias entre los dientes delanteros y los posteriores.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Pterosauria</li>
    <li><strong>Familia:</strong> Dimorphodontidae</li>
    <li><strong>Género:</strong> Dimorphodon</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Temprano</strong>, aproximadamente hace <strong>200 a 180 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado principalmente en <strong>Europa</strong>, particularmente en lo que hoy es el Reino Unido, donde se descubrió la primera especie.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Envergadura:</strong> Aproximadamente 1.5 a 2 metros</li>
    <li><strong>Longitud:</strong> Alrededor de 1 metro</li>
    <li><strong>Peso:</strong> Estimado en alrededor de 2-3 kg</li>
    <li><strong>Distintivo:</strong> Sus dientes delgados y puntiagudos en la parte frontal de la boca, y dientes más grandes y anchos en la parte posterior</li>
    <li><strong>Alas:</strong> Tenía alas membranosas con una estructura de huesos bastante flexible</li>
</ul>

<h2>Alimentación</h2>
<p>El Dimorphodon era un <strong>carnívoro</strong> que se alimentaba principalmente de pequeños animales como insectos, peces y otros invertebrados. Su dentadura especializada le permitía capturar y consumir diversas presas.</p>

<h2>Comportamiento</h2>
<p>Este pterosaurio es considerado un cazador activo. Sus alas le permitían volar de manera ágil, lo que le daba una ventaja para atrapar presas en el aire o en el agua.</p>

<h2>Reproducción</h2>
<p>Como otros pterosaurios, el Dimorphodon se reproducía por medio de huevos. No se conocen detalles específicos sobre sus comportamientos reproductivos debido a la falta de fósiles de nidos o crías.</p>

<h2>Descubrimiento</h2>
<p>El Dimorphodon fue descrito por el paleontólogo Richard Owen en 1859 a partir de fósiles encontrados en el Reino Unido. Desde entonces, se han encontrado varios ejemplares en distintas partes de Europa.</p>

<h2>Relación con otros organismos</h2>
<p>El Dimorphodon pertenece a la familia Dimorphodontidae, un grupo primitivo de pterosaurios que se caracterizan por su dentadura diferenciada. Otros pterosaurios relacionados incluyen a especies como Eudimorphodon.</p>

<h2>Importancia cultural</h2>
<p>Aunque no es tan famoso como algunos otros pterosaurios, el Dimorphodon ha sido representado en medios populares como documentales y películas sobre la prehistoria.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Dimorphodon es uno de los primeros pterosaurios conocidos por su peculiar dentadura.</li>
    <li>Su tamaño relativamente pequeño y sus alas le permitían maniobras rápidas en el aire.</li>
    <li>Se cree que su dieta incluía una variedad de animales pequeños que capturaba mientras volaba.</li>
    <li>Este pterosaurio compartió hábitat con otros reptiles voladores durante el Jurásico Temprano.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
