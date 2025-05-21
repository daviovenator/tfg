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
    <title>Cordaiteae - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Cordaiteae</h1>

<a href="../../../img/Cordaiteae.jpg" target="_blank">
    <img src="../../../img/Cordaiteae.jpg" alt="Cordaiteae" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p>El nombre <strong>Cordaiteae</strong> proviene del género <em>Cordaites</em>, que es un género extinto de plantas prehistóricas, consideradas antecesores de las modernas coníferas. Su nombre hace referencia a las hojas alargadas y fibrosas que poseían.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Pteridophyta</li>
    <li><strong>Clase:</strong> Cordaitopsida</li>
    <li><strong>Orden:</strong> Cordaitales</li>
    <li><strong>Familia:</strong> Cordaiteae</li>
    <li><strong>Género:</strong> Cordaites</li>
</ul>

<h2>Periodo geológico</h2>
<p>Las plantas del género <strong>Cordaiteae</strong> vivieron durante el <strong>Carbonífero</strong> y el <strong>Permiano</strong>, hace aproximadamente entre 300 y 250 millones de años.</p>

<h2>Distribución geográfica</h2>
<p>Las especies de Cordaiteae se distribuyeron en lo que ahora son América del Norte, Europa y partes de Asia. Estas plantas dominaban los paisajes de bosques y pantanos durante su época.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Grandes, largas y estrechas, similares a las de los modernos pinos o cipreses, con una textura fibrosa.</li>
    <li><strong>Tamaño:</strong> Algunas especies podían alcanzar alturas de hasta 30 metros, lo que les permitía dominar el paisaje prehistórico.</li>
    <li><strong>Tronco:</strong> El tronco era recto y robusto, adaptado para resistir condiciones de crecimiento en terrenos pantanosos.</li>
</ul>

<h2>Alimentación</h2>
<p>Las plantas de la familia <strong>Cordaiteae</strong> eran autótrofas, realizando fotosíntesis para generar su propio alimento utilizando la luz solar, el dióxido de carbono y el agua del ambiente.</p>

<h2>Comportamiento</h2>
<p>Estas plantas se adaptaban a ambientes húmedos y pantanosos, y se desarrollaban principalmente en ecosistemas donde las coníferas modernas y otras plantas dominaban los paisajes.</p>

<h2>Reproducción</h2>
<p>Las especies de Cordaiteae se reproducían sexualmente, con estructuras reproductivas que incluían conos, similares a los de las coníferas actuales, que liberaban polen que fecundaba las semillas femeninas.</p>

<h2>Descubrimiento</h2>
<p>Las plantas del grupo Cordaiteae se conocen principalmente por los fósiles de hojas, conos y otros restos vegetales encontrados en estratos geológicos del Carbonífero y Permiano. Fueron reconocidos como antecesores de las modernas coníferas.</p>

<h2>Relación con otras plantas</h2>
<p>El grupo Cordaiteae está estrechamente relacionado con las coníferas modernas, como los pinos y los cipreses. Sin embargo, se consideran un grupo primitivo, que ha dejado descendientes indirectos, ya que se extinguieron a finales del Permiano.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Las Cordaiteae fueron una de las primeras plantas en adaptarse a la vida terrestre durante el Carbonífero, y contribuyeron a la formación de los primeros grandes bosques de coníferas.</li>
    <li>Algunos fósiles de Cordaiteae han sido encontrados en yacimientos de carbón, lo que indica su relación con los paisajes pantanosos del pasado.</li>
    <li>La extinción de las Cordaiteae marcó el fin de una era en la evolución de las plantas coníferas, dando paso a nuevas especies de árboles que dominarían los paisajes terrestres.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
