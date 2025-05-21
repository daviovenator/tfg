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
    <title>Hadrosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Hadrosaurus</h1>

<a href="../../../img/Hadrosaurus.jpg" target="_blank">
    <img src="../../../img/Hadrosaurus.jpg" alt="Hadrosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Hadrosaurus</strong> proviene del griego "hadros" (grande, grueso) y "sauros" (lagarto), lo que significa "gran lagarto". Fue el primer dinosaurio herbívoro descrito que pertenecía a la familia de los hadrosaurios.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Suborden:</strong> Cerapoda</li>
    <li><strong>Familia:</strong> Hadrosauridae</li>
    <li><strong>Género:</strong> Hadrosaurus</li>
    <li><strong>Especie:</strong> H. foulki</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Inferior</strong>, aproximadamente hace <strong>75 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se ha encontrado en lo que hoy es América del Norte, específicamente en el estado de Nueva Jersey, Estados Unidos.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 9 metros</li>
    <li><strong>Peso:</strong> Alrededor de 3 toneladas</li>
    <li><strong>Postura:</strong> Cuadrúpeda, aunque también se cree que podía caminar sobre dos patas cuando lo necesitaba.</li>
    <li><strong>Características distintivas:</strong> Su rostro era similar al de otros hadrosaurios, con un pico en forma de pato y dientes especializados para triturar plantas.</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong>, alimentándose principalmente de plantas, como helechos y otras vegetación baja.</p>

<h2>Comportamiento</h2>
<p>Viviendo en manadas, el Hadrosaurus probablemente se protegía de los depredadores mediante su número y su habilidad para correr a gran velocidad.</p>

<h2>Reproducción</h2>
<p>Al igual que otros dinosaurios herbívoros, el Hadrosaurus se reproducía a través de <strong>huevos</strong>, y las hembras probablemente los colocaban en nidos construidos en el suelo.</p>

<h2>Descubrimiento</h2>
<p>El Hadrosaurus fue descubierto en 1858 por el paleontólogo William Parker Foulke en Nueva Jersey. Fue el primer dinosaurio norteamericano que fue montado y exhibido, lo que lo convirtió en una figura clave en la historia de la paleontología.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Hadrosaurus pertenece a la familia Hadrosauridae, relacionada con otros dinosaurios como el <em>Parasaurolophus</em> y el <em>Edmontosaurus</em>. Los hadrosaurios son conocidos por sus adaptaciones para la masticación y su capacidad de caminar tanto en dos como en cuatro patas.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Fue el primer dinosaurio de su tipo en ser montado y exhibido públicamente.</li>
    <li>El Hadrosaurus fue crucial para el desarrollo de la paleontología en América del Norte durante el siglo XIX.</li>
    <li>Aunque no es tan conocido como otros hadrosaurios, jugó un papel importante en el estudio de la evolución de los dinosaurios herbívoros.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
