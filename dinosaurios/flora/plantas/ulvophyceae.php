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
    <title>Ulvophyceae - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Ulvophyceae</h1>

<a href="../../../img/Ulvophyceae.jpg" target="_blank">
    <img src="../../../img/Ulvophyceae.jpg" alt="Ulvophyceae" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Ulvophyceae</strong> es una clase de algas verdes, cuyo nombre proviene del género de algas verdes <em>Ulva</em>, comúnmente conocidas como lechugas de mar. La terminología "phyceae" hace referencia a su clasificación como algas.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Chlorophyta</li>
    <li><strong>Clase:</strong> Ulvophyceae</li>
    <li><strong>Orden:</strong> Ulvales</li>
    <li><strong>Familia:</strong> Ulvaceae</li>
    <li><strong>Género:</strong> Ulva</li>
</ul>

<h2>Periodo geológico</h2>
<p><strong>Ulvophyceae</strong> se encuentra entre las algas verdes que han existido durante millones de años. Aunque no se tienen registros fósiles exactos, se cree que estas algas han existido desde el Cámbrico o incluso antes.</p>

<h2>Distribución geográfica</h2>
<p>Las algas de la clase <strong>Ulvophyceae</strong> se encuentran principalmente en zonas costeras, donde crecen en agua salada y fresca. Son comunes en ambientes marinos y estuarios, a menudo formando densos tapices de vegetación en las rocas y en las orillas.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Tamaño:</strong> <strong>Ulvophyceae</strong> incluye algas de diversos tamaños, desde especies microscópicas hasta grandes algas multicelulares que pueden medir varios metros de largo.</li>
    <li><strong>Estructura:</strong> Estas algas tienen una estructura simple, generalmente una lámina delgada que puede ser de color verde brillante debido a su alta concentración de clorofila.</li>
    <li><strong>Forma:</strong> Su forma puede variar, pero muchas tienen una estructura aplanada o filamentosa, que les permite maximizar la exposición a la luz solar para la fotosíntesis.</li>
</ul>

<h2>Alimentación</h2>
<p>Al ser algas fotosintéticas, las <strong>Ulvophyceae</strong> obtienen su energía a través de la luz solar. Realizan la fotosíntesis para producir su propio alimento y liberar oxígeno al medio ambiente.</p>

<h2>Comportamiento</h2>
<p>Estas algas son principalmente bentónicas, creciendo adheridas a rocas o sustratos duros en el fondo marino o en las orillas. Se desarrollan mejor en áreas con abundante luz solar y agua limpia.</p>

<h2>Reproducción</h2>
<p><strong>Ulvophyceae</strong> se reproduce tanto sexual como asexualmente. La reproducción asexual ocurre mediante la formación de esporas, mientras que la reproducción sexual se produce mediante la fusión de gametos, lo que resulta en la formación de un cigoto que puede desarrollar una nueva planta.</p>

<h2>Descubrimiento</h2>
<p>El estudio de las <strong>Ulvophyceae</strong> se remonta a los primeros estudios de algas marinas. Fueron identificadas por su importancia ecológica en los ecosistemas marinos, particularmente en la producción primaria y el ciclo del carbono.</p>

<h2>Relación con otras plantas</h2>
<p>Las algas de la clase <strong>Ulvophyceae</strong> están relacionadas con otras algas verdes, como las de la clase <em>Chlorophyceae</em>, que también son fotosintéticas. Aunque las <strong>Ulvophyceae</strong> son muy simples, son esenciales para la producción primaria en los ecosistemas acuáticos.</p>

<h2>Curiosidades</h2>
<ul>
    <li><strong>Ulvophyceae</strong> es un grupo importante dentro del ecosistema marino, ya que forma una gran parte de la vegetación marina, siendo alimento para numerosos organismos marinos.</li>
    <li>La especie <em>Ulva lactuca</em> es conocida como lechuga de mar y se consume en algunas partes del mundo como alimento, debido a su sabor suave y sus beneficios nutricionales.</li>
    <li>Las <strong>Ulvophyceae</strong> tienen una gran capacidad de crecimiento y pueden formar enormes alfombrillas de algas en la costa, especialmente en ambientes ricos en nutrientes.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
