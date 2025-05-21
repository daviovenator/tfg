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
    <title>Oviraptor - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Oviraptor</h1>

<a href="../../../img/Oviraptor.jpeg" target="_blank">
    <img src="../../../img/Oviraptor.jpeg" alt="Oviraptor" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Oviraptor</strong> significa "ladrón de huevos", nombre que se le dio erróneamente cuando fue descubierto cerca de un nido de huevos que se pensaba pertenecían a otro dinosaurio.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Oviraptoridae</li>
    <li><strong>Género:</strong> Oviraptor</li>
    <li><strong>Especie:</strong> O. philoceratops</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Tardío</strong>, hace aproximadamente <strong>75 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado en Mongolia, específicamente en el desierto de Gobi.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Alrededor de 2 metros</li>
    <li><strong>Peso:</strong> Cerca de 20 kg</li>
    <li><strong>Cráneo:</strong> Con cresta y pico sin dientes</li>
    <li><strong>Brazos:</strong> Largos con garras curvas</li>
</ul>

<h2>Alimentación</h2>
<p>Era probablemente <strong>omnivoro</strong>, alimentándose de huevos, insectos, pequeños vertebrados y plantas duras.</p>

<h2>Comportamiento</h2>
<p>Estudios recientes indican que cuidaba de sus nidos, lo que contradice la idea original de que robaba huevos.</p>

<h2>Reproducción</h2>
<p>Ponía <strong>huevos</strong> en nidos cuidadosamente dispuestos en círculos. Se han encontrado fósiles de Oviraptor adultos sobre sus nidos, lo que sugiere cuidado parental.</p>

<h2>Descubrimiento</h2>
<p>Fue descubierto en 1924 por Roy Chapman Andrews. Su nombre refleja una interpretación equivocada del hallazgo original.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Forma parte del grupo Oviraptorosauria, parientes cercanos de las aves actuales.</p>

<h2>Importancia cultural</h2>
<p>El Oviraptor ha sido ampliamente representado en documentales y museos, especialmente como ejemplo de malentendidos paleontológicos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Su pico era fuerte, ideal para romper huevos o frutos duros.</li>
    <li>Algunos fósiles muestran plumas en sus extremidades.</li>
    <li>Probablemente tenía un comportamiento social avanzado en la crianza de sus crías.</li>
    <li>Su cresta pudo haber servido para la exhibición entre individuos.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
