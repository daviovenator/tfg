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
    <title>Nymphaea - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Nymphaea</h1>

<a href="../../../img/Nymphaea.webp" target="_blank">
    <img src="../../../img/Nymphaea.webp" alt="Nymphaea" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Nymphaea</strong> es el nombre científico del género comúnmente conocido como <em>lirio de agua</em>, que proviene del griego "nymphé" (ninfa), refiriéndose a las ninfas acuáticas de la mitología, pues estas plantas crecen en cuerpos de agua, flotando sobre la superficie.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Angiospermae</li>
    <li><strong>Clase:</strong> Magnoliopsida</li>
    <li><strong>Orden:</strong> Nymphaeales</li>
    <li><strong>Familia:</strong> Nymphaeaceae</li>
    <li><strong>Género:</strong> Nymphaea</li>
</ul>

<h2>Periodo geológico</h2>
<p><strong>Nymphaea</strong> es un género moderno, pero sus antepasados evolucionaron durante el Cretácico, hace aproximadamente 100 millones de años. Hoy en día, las lirios de agua siguen siendo comunes en cuerpos de agua dulce en todo el mundo.</p>

<h2>Distribución geográfica</h2>
<p>El género <strong>Nymphaea</strong> se encuentra distribuido en áreas de agua dulce en regiones tropicales y templadas, principalmente en América, Asia, África y algunas zonas de Europa.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Las hojas de <strong>Nymphaea</strong> son grandes, redondas y flotan sobre el agua. Tienen un borde ondulado y a menudo están cubiertas de una capa de cera que las hace impermeables.</li>
    <li><strong>Flores:</strong> Las flores de <strong>Nymphaea</strong> son grandes, atractivas y pueden ser de colores blancos, rosados, amarillos o lilas. Se abren durante el día y cierran por la noche.</li>
    <li><strong>Raíces:</strong> Las raíces están ancladas en el fondo del cuerpo de agua, y el tallo es largo, flotante, permitiendo que las hojas y flores se eleven sobre la superficie del agua.</li>
</ul>

<h2>Alimentación</h2>
<p><strong>Nymphaea</strong> es una planta autotrófica que realiza fotosíntesis, utilizando la luz solar, el dióxido de carbono del aire y el agua para producir su propio alimento.</p>

<h2>Comportamiento</h2>
<p>Estas plantas son completamente acuáticas y están adaptadas a la vida flotante. <strong>Nymphaea</strong> se desarrolla en cuerpos de agua tranquilos, donde sus hojas flotantes le permiten recibir suficiente luz solar para su fotosíntesis.</p>

<h2>Reproducción</h2>
<p><strong>Nymphaea</strong> se reproduce sexualmente a través de flores que se polinizan, y también de forma asexual mediante la producción de rizomas. Los rizomas crecen horizontalmente bajo el agua, generando nuevas plantas.</p>

<h2>Descubrimiento</h2>
<p>El género <strong>Nymphaea</strong> fue conocido desde tiempos antiguos, pero su descripción formal en la ciencia moderna se dio en el siglo XVIII. Desde entonces, ha sido ampliamente cultivado como planta ornamental en jardines acuáticos.</p>

<h2>Relación con otras plantas</h2>
<p><strong>Nymphaea</strong> está relacionada con otras plantas acuáticas como las <strong>lotus</strong>, pertenecientes a la familia Nelumbonaceae. Aunque ambas crecen en ambientes acuáticos, las <strong>lotus</strong> tienen una estructura diferente, con flores y hojas más elevadas sobre el agua.</p>

<h2>Curiosidades</h2>
<ul>
    <li><strong>Nymphaea</strong> es famosa por su belleza y es utilizada en muchos jardines acuáticos y estanques ornamentales en todo el mundo.</li>
    <li>En algunas culturas, las flores de <strong>Nymphaea</strong> tienen un simbolismo importante, representando la pureza, la iluminación y el renacimiento.</li>
    <li>Las flores de <strong>Nymphaea</strong> siguen un patrón de apertura y cierre, que ocurre durante el día y la noche, un fenómeno conocido como "efecto diurno nocturno".</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
