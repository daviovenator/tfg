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
    <title>Salvinia - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Salvinia</h1>

<a href="../../../img/Salvinia.jpg" target="_blank">
    <img src="../../../img/Salvinia.jpg" alt="Salvinia" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Salvinia</strong> es un género de plantas acuáticas perteneciente a la familia Salviniaceae. Su nombre se deriva del botánico italiano <em>Giovanni Salvi</em>, quien fue el primero en describirlo.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Pteridophyta</li>
    <li><strong>Clase:</strong> Polypodiopsida</li>
    <li><strong>Orden:</strong> Salviniales</li>
    <li><strong>Familia:</strong> Salviniaceae</li>
    <li><strong>Género:</strong> Salvinia</li>
</ul>

<h2>Periodo geológico</h2>
<p><strong>Salvinia</strong> es un género moderno, por lo que no está restringido a un periodo geológico específico. Se encuentra ampliamente distribuido en las zonas tropicales y subtropicales del mundo.</p>

<h2>Distribución geográfica</h2>
<p>Las especies de <strong>Salvinia</strong> se encuentran en regiones de agua dulce de todo el mundo, especialmente en América, África y Asia. Prefieren aguas tranquilas, como estanques, lagos y pantanos.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Las hojas de <strong>Salvinia</strong> son flotantes y están cubiertas por una capa de pelos que les ayuda a mantenerse a flote. Tienen una forma ovalada o redondeada.</li>
    <li><strong>Tamaño:</strong> Las plantas de Salvinia pueden crecer en colonias flotantes que varían en tamaño desde unos pocos centímetros hasta varios metros de longitud.</li>
    <li><strong>Raíces:</strong> Las raíces de <strong>Salvinia</strong> cuelgan hacia el fondo del agua, pero no están ancladas, lo que les permite moverse con las corrientes.</li>
</ul>

<h2>Alimentación</h2>
<p><strong>Salvinia</strong> es una planta autotrófica que realiza fotosíntesis, utilizando la luz solar, el dióxido de carbono y el agua para producir su propio alimento.</p>

<h2>Comportamiento</h2>
<p>Al ser una planta acuática flotante, <strong>Salvinia</strong> es capaz de formar grandes colonias en el agua. Estas plantas se reproducen rápidamente y pueden cubrir la superficie de lagos y estanques, lo que puede afectar la vida acuática al bloquear la luz solar.</p>

<h2>Reproducción</h2>
<p><strong>Salvinia</strong> se reproduce tanto de manera sexual mediante esporas como a través de la reproducción asexual mediante estolones, que les permite formar nuevas colonias rápidamente.</p>

<h2>Descubrimiento</h2>
<p>El género Salvinia fue descrito por primera vez en el siglo XVIII por el botánico italiano Giovanni Salvi, aunque es una planta conocida desde mucho antes en las regiones tropicales del mundo.</p>

<h2>Relación con otras plantas</h2>
<p>Dentro del grupo de las plantas acuáticas, <strong>Salvinia</strong> está relacionada con otras especies flotantes como <strong>Azolla</strong> y <strong>Victoria</strong>. Aunque pertenecen a familias diferentes, todas comparten la adaptación a la vida acuática.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Las hojas de <strong>Salvinia</strong> tienen una peculiar capa de pelos que les da una apariencia "peluda" y les ayuda a mantenerse a flote, lo que es una adaptación única de las plantas acuáticas.</li>
    <li>Se ha utilizado en proyectos de bioremediación, debido a su capacidad para absorber nutrientes y metales pesados del agua, mejorando la calidad del agua en algunos ecosistemas acuáticos.</li>
    <li>En algunas regiones, las especies de <strong>Salvinia</strong> han sido consideradas invasoras, ya que su rápido crecimiento puede bloquear las vías de navegación y afectar la biodiversidad acuática.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
