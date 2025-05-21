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
    <title>Therizinosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Therizinosaurus</h1>

<a href="../../../img/Therizinosaurus.jpeg" target="_blank">
    <img src="../../../img/Therizinosaurus.jpeg" alt="Therizinosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Therizinosaurus</strong> significa "lagarto guadaña", en referencia a sus enormes garras en forma de hoz.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Therizinosauridae</li>
    <li><strong>Género:</strong> Therizinosaurus</li>
    <li><strong>Especie:</strong> T. cheloniformis</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Superior</strong>, hace aproximadamente <strong>70 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles fueron encontrados en <strong>Mongolia</strong>.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 10 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 5 toneladas</li>
    <li><strong>Garras:</strong> Garras de hasta 1 metro de largo</li>
    <li><strong>Postura:</strong> Bípedo, con cuello largo y cuerpo voluminoso</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> o posiblemente omnívoro, utilizando sus largas garras para atraer ramas o defenderse.</p>

<h2>Comportamiento</h2>
<p>Aunque era un terópodo, tenía una dieta muy distinta a la de sus parientes carnívoros, y se cree que era más lento y pacífico.</p>

<h2>Reproducción</h2>
<p>Se reproducía por <strong>huevos</strong>. Algunos restos fósiles relacionados sugieren comportamientos de anidación.</p>

<h2>Descubrimiento</h2>
<p>Fue descrito en 1954 por Evgeny Maleev, aunque inicialmente se pensaba que sus garras pertenecían a una tortuga gigante.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Pese a su apariencia extraña, está relacionado con otros terópodos, lo que sugiere una evolución divergente dentro del grupo.</p>

<h2>Importancia cultural</h2>
<p>Su aspecto único lo ha hecho popular en documentales y videojuegos, y ha capturado la imaginación de muchos aficionados a los dinosaurios.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Sus garras son las más largas conocidas de cualquier animal terrestre.</li>
    <li>Es uno de los pocos terópodos adaptados a una dieta herbívora.</li>
    <li>Su esqueleto revela una mezcla única de rasgos de terópodos y herbívoros.</li>
    <li>Su clasificación fue un misterio durante décadas debido a su forma inusual.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
