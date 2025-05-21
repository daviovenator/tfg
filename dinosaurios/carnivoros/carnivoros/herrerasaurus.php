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
    <title>Herrerasaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Herrerasaurus</h1>

<a href="../../../img/herrerasaurus.jpg" target="_blank">
    <img src="../../../img/herrerasaurus.jpg" alt="Herrerasaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Herrerasaurus</strong> significa "lagarto de Herrera", en honor a su descubridor, Victorino Herrera, quien encontró los primeros restos en Argentina en la década de 1950.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda (posición aún debatida)</li>
    <li><strong>Familia:</strong> Herrerasauridae</li>
    <li><strong>Género:</strong> Herrerasaurus</li>
    <li><strong>Especie:</strong> H. ischigualastensis</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Triásico Tardío</strong>, hace aproximadamente <strong>231 millones de años</strong>, siendo uno de los primeros dinosaurios conocidos.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado en:
<ul>
    <li>Argentina (Formación Ischigualasto, provincia de San Juan)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> 3 a 6 metros</li>
    <li><strong>Peso:</strong> 250 a 350 kg</li>
    <li><strong>Constitución:</strong> Ágil, cuerpo esbelto y extremidades largas</li>
    <li><strong>Mandíbula:</strong> Dentadura afilada con dientes curvos y aserrados</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>carnívoro</strong> que se alimentaba de reptiles más pequeños y posiblemente de otros dinosaurios primitivos. Su agilidad y dientes sugieren una dieta activa.</p>

<h2>Comportamiento</h2>
<p>Probablemente era un cazador solitario. Su morfología indica que podía moverse rápidamente y atrapar presas con eficacia.</p>

<h2>Reproducción</h2>
<p>Se reproducía mediante <strong>huevos</strong>, como todos los dinosaurios. No se han hallado nidos directamente relacionados a la especie.</p>

<h2>Descubrimiento</h2>
<p>Fue descubierto en 1958 por Victorino Herrera y descrito formalmente por Osvaldo Reig en 1963. Su hallazgo ha sido clave para entender la evolución temprana de los dinosaurios.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Es uno de los dinosaurios más primitivos conocidos. Su posición filogenética ha sido debatida, pero se considera cercano a la base de los saurisquios.</p>

<h2>Importancia cultural</h2>
<p>Aunque menos conocido por el público general, Herrerasaurus es muy importante para la paleontología por su antigüedad y características primitivas.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Compartía su hábitat con otros dinosaurios primitivos como Eoraptor.</li>
    <li>Su estructura esquelética muestra una mezcla de rasgos avanzados y primitivos.</li>
    <li>Poseía una mandíbula que permitía un movimiento deslizante, inusual entre los dinosaurios carnívoros posteriores.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
