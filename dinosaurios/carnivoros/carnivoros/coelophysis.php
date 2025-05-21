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
    <title>Coelophysis - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Coelophysis</h1>

<a href="../../../img/coelophysis.jpg" target="_blank">
    <img src="../../../img/coelophysis.jpg" alt="Coelophysis" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Coelophysis</strong> significa "forma hueca", en referencia a sus huesos huecos que lo hacían más ligero. El nombre proviene del griego "koilos" (hueco) y "physis" (forma).</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Coelophysidae</li>
    <li><strong>Género:</strong> Coelophysis</li>
    <li><strong>Especie:</strong> C. bauri</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Triásico Tardío</strong>, hace aproximadamente <strong>210 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado principalmente en América del Norte, especialmente en el estado de Nuevo México, EE.UU.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 3 metros</li>
    <li><strong>Peso:</strong> Alrededor de 20-30 kg</li>
    <li><strong>Aspecto:</strong> Ligero y ágil, con cuello largo y mandíbula repleta de dientes afilados</li>
    <li><strong>Patas:</strong> Largas y delgadas, adaptadas para correr</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>carnívoro</strong>, se alimentaba de pequeños vertebrados, insectos e incluso posiblemente de miembros de su propia especie (canibalismo).</p>

<h2>Comportamiento</h2>
<p>Se han encontrado fósiles en grandes grupos, lo que sugiere que podría haber tenido un comportamiento social o al menos vivido en agregaciones.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, ponía <strong>huevos</strong>. Se han encontrado nidos asociados con fósiles, lo que indica una reproducción ovípara.</p>

<h2>Descubrimiento</h2>
<p>Fue descubierto en 1881 y descrito por Edward Drinker Cope. Más tarde, en 1947, se hallaron más de 100 esqueletos en Ghost Ranch, Nuevo México.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Es uno de los primeros terópodos conocidos y antecesor de muchos carnívoros posteriores, como el Dilophosaurus y Allosaurus.</p>

<h2>Importancia cultural</h2>
<p>Coelophysis ha aparecido en museos, libros y documentales como uno de los primeros depredadores dinosaurios conocidos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Sus huesos huecos eran similares a los de las aves actuales.</li>
    <li>Tenía una excelente visión gracias a sus grandes ojos.</li>
    <li>Es uno de los dinosaurios más comunes en el registro fósil del Triásico.</li>
    <li>Algunos fósiles contienen restos dentro del cuerpo, posiblemente evidencia de canibalismo.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
