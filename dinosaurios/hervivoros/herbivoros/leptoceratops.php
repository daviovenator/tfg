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
    <title>Leptoceratops - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Leptoceratops</h1>

<a href="../../../img/Leptoceratops.jpg" target="_blank">
    <img src="../../../img/Leptoceratops.jpg" alt="Leptoceratops" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Leptoceratops</strong> proviene del griego "leptos" (delgado) y "keratops" (cara con cuerno), lo que significa "cara delgada con cuerno", haciendo referencia a sus cuernos pequeños y su cuerpo más liviano en comparación con otros ceratópsidos.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Suborden:</strong> Cerapoda</li>
    <li><strong>Familia:</strong> Ceratopsidae</li>
    <li><strong>Género:</strong> Leptoceratops</li>
    <li><strong>Especie:</strong> L. gracilis</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Temprano</strong>, hace aproximadamente <strong>80 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado en América del Norte, específicamente en lo que hoy es Canadá y los Estados Unidos.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 2 metros</li>
    <li><strong>Peso:</strong> Alrededor de 50-60 kg</li>
    <li><strong>Postura:</strong> Bípedo, pero probablemente caminaba en cuadrúpedo en algunas ocasiones.</li>
    <li><strong>Cuerno:</strong> Tenía pequeños cuernos sobre su cara, aunque no tan prominentes como otros miembros de la familia Ceratopsidae.</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> que se alimentaba principalmente de plantas y vegetación baja, adaptado para pastar cerca del suelo.</p>

<h2>Comportamiento</h2>
<p>Leptoceratops probablemente vivía en pequeños grupos, aunque no se sabe mucho sobre su comportamiento social. Su pequeño tamaño y su dieta lo hacían menos vulnerable a los grandes depredadores de la época.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, el Leptoceratops se reproducía por medio de <strong>huevos</strong>. Se cree que sus crías nacían en nidos hechos en el suelo, aunque no se han encontrado evidencias claras de su comportamiento reproductivo.</p>

<h2>Descubrimiento</h2>
<p>Los primeros fósiles de Leptoceratops fueron descubiertos en 1912 en la Formación Horseshoe Canyon en Alberta, Canadá. Fue descrito formalmente en 1914 por el paleontólogo Lawrence Lambe.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Pertenece a la familia Ceratopsidae, que incluye a dinosaurios como <em>Triceratops</em>, <em>Centrosaurus</em> y <em>Psittacosaurus</em>. Aunque más pequeño que sus parientes, comparte la estructura básica de su cráneo, con un pequeño cuerno en la parte frontal de su cara.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Leptoceratops es uno de los ceratópsidos más pequeños que se conocen.</li>
    <li>Probablemente, al igual que otros ceratópsidos, utilizaba sus cuernos pequeños para defenderse de los depredadores.</li>
    <li>Era más ágil y rápido en comparación con los grandes ceratópsidos como el Triceratops, lo que le permitía escapar de los depredadores más grandes.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
