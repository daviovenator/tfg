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
    <title>Microceratus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Microceratus</h1>

<a href="../../../img/Microceratus.webp" target="_blank">
    <img src="../../../img/Microceratus.webp" alt="Microceratus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Microceratus</strong> proviene del griego "micro" (pequeño) y "ceratus" (cuerno), lo que significa "pequeño cuerno", en referencia a sus cuernos frontales.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Familia:</strong> Hypsilophodontidae</li>
    <li><strong>Género:</strong> Microceratus</li>
    <li><strong>Especie:</strong> M. gravesi</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Temprano</strong>, hace aproximadamente <strong>125 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se ha encontrado principalmente en lo que hoy es China, donde se han descubierto varios fósiles de este pequeño dinosaurio.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 2 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 25-30 kg</li>
    <li><strong>Postura:</strong> Bípeda, con un cuerpo ligero y ágil.</li>
    <li><strong>Características distintivas:</strong> Su pequeño tamaño, cuernos en el cráneo y una estructura corporal ligera lo hacían rápido y ágil.</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong>, alimentándose de plantas bajas y vegetación suave. Su dentición estaba adaptada para cortar y triturar las plantas.</p>

<h2>Comportamiento</h2>
<p>El Microceratus probablemente era un animal social que vivía en grupos pequeños. Debido a su tamaño, su principal defensa era la rapidez y el escape frente a los depredadores más grandes.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios herbívoros, el Microceratus se reproducía por medio de <strong>huevos</strong>.</p>

<h2>Descubrimiento</h2>
<p>Los fósiles de Microceratus fueron descubiertos en China, con la especie más conocida, M. gravesi, siendo nombrada en 1979.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Microceratus es un miembro de la familia Hypsilophodontidae, relacionada con dinosaurios como el <em>Hypsilophodon</em>, que comparten una estructura corporal similar y son conocidos por su agilidad y pequeño tamaño.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Microceratus era uno de los dinosaurios más pequeños de su tiempo, lo que le ayudaba a escapar de los depredadores.</li>
    <li>Su agilidad y pequeño tamaño le permitían moverse rápidamente en su hábitat forestal o de sabana.</li>
    <li>Se cree que era un animal muy social y que vivía en pequeños grupos para protegerse mejor de los depredadores.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
