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
    <title>Mapusaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Mapusaurus</h1>

<a href="../../../img/mapusaurus.jpg" target="_blank">
    <img src="../../../img/mapusaurus.jpg" alt="Mapusaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Mapusaurus</strong> significa "lagarto de la tierra" o "lagarto de la tierra madre", del mapuche "Mapu" (tierra) y el griego "sauros" (lagarto).</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Carcharodontosauridae</li>
    <li><strong>Género:</strong> Mapusaurus</li>
    <li><strong>Especie:</strong> M. roseae</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Superior</strong>, hace aproximadamente <strong>97 a 93 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus restos se han encontrado en:
<ul>
    <li>Neuquén, Argentina</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 12 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 5 toneladas</li>
    <li><strong>Craneo:</strong> Grande, con dientes afilados en forma de cuchilla</li>
    <li><strong>Físico:</strong> Robusto, con patas poderosas</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>carnívoro</strong> de gran tamaño, que probablemente se alimentaba de grandes saurópodos como Argentinosaurus. Se cree que pudo cazar en grupo.</p>

<h2>Comportamiento</h2>
<p>Se han encontrado múltiples individuos juntos, lo que sugiere un posible comportamiento gregario o de caza en grupo, algo inusual en grandes terópodos.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, se reproducía por <strong>huevos</strong>. Se desconoce si cuidaba de sus crías.</p>

<h2>Descubrimiento</h2>
<p>Fue descubierto en 1997 por un equipo argentino dirigido por Rodolfo Coria y Leonardo Salgado. El nombre "roseae" honra a la filántropa Rose Letwin.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Mapusaurus pertenece a la familia Carcharodontosauridae, junto a:
<ul>
    <li>Carcharodontosaurus</li>
    <li>Giganotosaurus</li>
</ul>
Estos depredadores se caracterizan por su gran tamaño y potentes mandíbulas.</p>

<h2>Importancia cultural</h2>
<p>Es uno de los grandes carnívoros de Sudamérica menos conocidos, pero ha ganado atención por su posible caza en grupo y relación con Giganotosaurus.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Su nombre incluye palabras de la lengua mapuche.</li>
    <li>Vivió en la misma región que el enorme saurópodo Argentinosaurus.</li>
    <li>Podría haber rivalizado en tamaño con el T. rex.</li>
    <li>Su hallazgo apoya la hipótesis de caza en grupo en grandes terópodos.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
