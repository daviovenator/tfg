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
    <title>Pterodaustro - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Pterodaustro</h1>

<a href="../../../img/Pterodaustro.jpg" target="_blank">
    <img src="../../../img/Pterodaustro.jpg" alt="Pterodaustro" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Pterodaustro</strong> proviene del griego "ptero" que significa "ala" y "daustros", que se refiere a un tipo de ave primitiva. El nombre hace referencia a sus alas membranosas y su apariencia similar a los modernos flamencos.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Pterosauria</li>
    <li><strong>Familia:</strong> Pterodactylidae</li>
    <li><strong>Género:</strong> Pterodaustro</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Temprano</strong>, hace aproximadamente <strong>120 a 100 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado en <strong>Sudamérica</strong>, específicamente en lo que hoy es Argentina.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Envergadura:</strong> Aproximadamente 2-3 metros</li>
    <li><strong>Longitud:</strong> Cerca de 1 metro</li>
    <li><strong>Peso:</strong> Estimado en unos 5-10 kg</li>
    <li><strong>Distintivo:</strong> Su pico largo y fino, con una serie de dientes diminutos, que usaba para filtrar pequeños organismos acuáticos</li>
    <li><strong>Alas:</strong> Tenía alas membranosas que le permitían volar con gran maniobrabilidad</li>
</ul>

<h2>Alimentación</h2>
<p>El Pterodaustro era un <strong>alimentador filtrador</strong>, lo que significa que usaba su pico largo y lleno de pequeños dientes para filtrar agua y extraer pequeños organismos acuáticos, como crustáceos y plancton.</p>

<h2>Comportamiento</h2>
<p>Este pterosaurio probablemente pasaba mucho tiempo volando sobre cuerpos de agua, donde se alimentaba mediante la filtración. Su estructura corporal le permitía maniobrar eficazmente sobre el agua en busca de su alimento.</p>

<h2>Reproducción</h2>
<p>Como otros pterosaurios, el Pterodaustro se reproducía por huevos. Los detalles sobre su comportamiento reproductivo no se conocen bien debido a la falta de fósiles de crías o nidos específicos.</p>

<h2>Descubrimiento</h2>
<p>El Pterodaustro fue descrito por el paleontólogo argentino José Bonaparte en 1970, a partir de fósiles hallados en Argentina, que proporcionaron una valiosa información sobre los pterosaurios del Cretácico Temprano.</p>

<h2>Relación con otros organismos</h2>
<p>Pertenecía a la familia Pterodactylidae, un grupo de pterosaurios que incluía otras especies con morfologías adaptadas al vuelo. Su forma de pico filtrador lo diferencia de otros miembros de esta familia.</p>

<h2>Importancia cultural</h2>
<p>Aunque menos conocido que los grandes pterosaurios como el Pteranodon o el Quetzalcoatlus, el Pterodaustro ha sido objeto de estudio debido a sus adaptaciones únicas para la alimentación filtradora.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Pterodaustro vivió cerca de grandes cuerpos de agua, donde probablemente pasaba la mayor parte de su vida.</li>
    <li>El diseño de su pico y dientes es similar al de algunas aves actuales, como los flamencos, que también filtran agua para obtener alimento.</li>
    <li>Se cree que su vuelo era muy diferente al de otros pterosaurios, debido a su tamaño más pequeño y su morfología adaptada a un vuelo más controlado sobre el agua.</li>
    <li>El Pterodaustro comparte su entorno con otros pterosaurios y reptiles marinos que habitaban en el Cretácico Temprano.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
