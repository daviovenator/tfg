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
    <title>Shunosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Shunosaurus</h1>

<a href="../../../img/Shunosaurus.jpg" target="_blank">
    <img src="../../../img/Shunosaurus.jpg" alt="Shunosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Shunosaurus</strong> proviene del griego "Shuno" (de la región de Shandong, China, donde fue descubierto) y "sauros" (lagarto), lo que significa "lagarto de Shandong".</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Sauropodomorpha</li>
    <li><strong>Familia:</strong> Mamenchisauridae</li>
    <li><strong>Género:</strong> Shunosaurus</li>
    <li><strong>Especie:</strong> S. lii</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Medio</strong>, hace aproximadamente <strong>165 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado en lo que hoy es la provincia de Sichuan en China.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 9 metros</li>
    <li><strong>Peso:</strong> Alrededor de 3 toneladas</li>
    <li><strong>Postura:</strong> Cuadrúpeda, caminaba sobre cuatro patas</li>
    <li><strong>Cola:</strong> Corto y robusto, con una posible maza ósea en su extremo (como un mecanismo de defensa)</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> que se alimentaba principalmente de vegetación baja, como helechos, coníferas y otras plantas que crecían durante el Jurásico.</p>

<h2>Comportamiento</h2>
<p>El Shunosaurus probablemente vivió en grupos y utilizaba su cola maza para defenderse de posibles depredadores. Aunque no se conocen demasiados detalles sobre su comportamiento social, su tamaño modesto sugiere que no era un animal especialmente agresivo.</p>

<h2>Reproducción</h2>
<p>Se reproducía mediante <strong>huevos</strong>, como todos los dinosaurios. No se han encontrado fósiles que indiquen detalles sobre su comportamiento reproductivo, pero probablemente construía nidos en el suelo.</p>

<h2>Descubrimiento</h2>
<p>Los restos de Shunosaurus fueron descubiertos en 1983 en la provincia de Sichuan, China, y fueron descritos en 1985. Es uno de los pocos sauropodos con una cola maza.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Shunosaurus pertenece a la familia Mamenchisauridae, que incluye otros dinosaurios de cuello largo como <em>Mamenchisaurus</em> y <em>Yangchuanosaurus</em>. Estos dinosaurios comparten ciertas características, como su gran cuello y cuerpo masivo.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Shunosaurus es uno de los pocos dinosaurios con una cola maza, lo que sugiere que podría haber usado este apéndice para defenderse de depredadores.</li>
    <li>Su estructura corporal le permitía alcanzar grandes alturas para alimentarse de la vegetación más alta durante el Jurásico.</li>
    <li>Su tamaño relativamente pequeño en comparación con otros sauropodos lo hacía menos vulnerable a los depredadores gigantes de la época.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
