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
    <title>Hypsilophodon - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Hypsilophodon</h1>

<a href="../../../img/Hypsilophodon.jpg" target="_blank">
    <img src="../../../img/Hypsilophodon.jpg" alt="Hypsilophodon" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Hypsilophodon</strong> proviene del griego "hypsilos" (alto) y "ophis" (serpiente), haciendo referencia a su estructura corporal ágil y ligera. Su nombre puede traducirse como "lagarto serpiente de cuello alto".</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Suborden:</strong> Cerapoda</li>
    <li><strong>Familia:</strong> Hypsilophodontidae</li>
    <li><strong>Género:</strong> Hypsilophodon</li>
    <li><strong>Especie:</strong> H. foxii (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Tardío</strong>, hace aproximadamente <strong>145 a 161 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado principalmente en:</p>
<ul>
    <li>Reino Unido</li>
</ul>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Alrededor de 3 metros</li>
    <li><strong>Peso:</strong> Entre 50 y 100 kg</li>
    <li><strong>Distintivo:</strong> Cuerpo ligero y ágil con una cola larga y delgada</li>
    <li><strong>Postura:</strong> Bípedo, adaptado para moverse rápidamente</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong>, y se alimentaba principalmente de plantas bajas, hierbas y arbustos. Sus dientes eran adecuados para cortar vegetación.</p>

<h2>Comportamiento</h2>
<p>Se cree que el Hypsilophodon era un animal ágil y rápido, ideal para escapar de depredadores. Vivió en manadas, lo que le ofrecía protección contra los grandes carnívoros de su época.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios, el Hypsilophodon se reproducía por <strong>huevos</strong>. No se conocen detalles específicos sobre sus nidos o cuidados parentales.</p>

<h2>Descubrimiento</h2>
<p>El primer fósil de Hypsilophodon fue descubierto en 1857 por el paleontólogo Richard Owen en el Reino Unido. Desde entonces, se han encontrado más restos, lo que ha permitido reconstruir una imagen más completa de este dinosaurio.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Pertenece a la familia Hypsilophodontidae, un grupo de dinosaurios herbívoros y bípedos que compartían características similares con otros dinosaurios como <em>Hypsilophodon</em>, <em>Orodromeus</em> y <em>Thescelosaurus</em>.</p>

<h2>Importancia cultural</h2>
<p>Aunque no tan conocido como otros dinosaurios, Hypsilophodon es una parte importante de la historia evolutiva de los dinosaurios herbívoros. Su descubrimiento ayudó a entender la diversidad de especies que existieron en el Jurásico.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Sus extremidades traseras eran mucho más largas que las delanteras, lo que le permitía ser muy ágil.</li>
    <li>Tenía un cráneo relativamente pequeño comparado con su cuerpo.</li>
    <li>Hypsilophodon probablemente se desplazaba en grupos, lo que le proporcionaba mayor protección contra los depredadores.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
