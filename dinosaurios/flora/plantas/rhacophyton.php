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
    <title>Rhacophyton - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Rhacophyton</h1>

<a href="../../../img/Rhacophyton.jpeg" target="_blank">
    <img src="../../../img/Rhacophyton.jpeg" alt="Rhacophyton" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Rhacophyton</strong> proviene del griego "rhachis" (eje) y "phyton" (planta), haciendo referencia a su sistema de ramificación que era muy característico de esta planta del periodo Devónico.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Tracheophyta</li>
    <li><strong>Clase:</strong> Lycopsida</li>
    <li><strong>Orden:</strong> Rhacophytales</li>
    <li><strong>Familia:</strong> Rhacophytaceae</li>
    <li><strong>Género:</strong> Rhacophyton</li>
</ul>

<h2>Periodo geológico</h2>
<p><strong>Rhacophyton</strong> vivió durante el periodo Devónico, hace aproximadamente 400 millones de años, cuando las primeras plantas vasculares comenzaron a colonizar los ambientes terrestres.</p>

<h2>Distribución geográfica</h2>
<p>Los restos fósiles de <strong>Rhacophyton</strong> se han encontrado en varias partes del mundo, principalmente en lo que hoy es Europa y América del Norte, donde vivió en zonas pantanosas y húmedas durante el Devónico.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Tamaño:</strong> <strong>Rhacophyton</strong> no alcanzaba grandes tamaños, sino que era una planta que crecía en forma de arbusto con ramas que se ramificaban a partir de un eje principal.</li>
    <li><strong>Corteza:</strong> Su corteza estaba formada por tejidos lechosos y fibrosos, que la hacían resistente al entorno en el que se desarrollaba.</li>
    <li><strong>Hojas:</strong> Presentaba hojas pequeñas y lineales dispuestas en espiral a lo largo de su tronco.</li>
</ul>

<h2>Alimentación</h2>
<p>Como muchas de las plantas primitivas, <strong>Rhacophyton</strong> era una planta fotosintética que utilizaba la luz solar para producir su energía a través de la fotosíntesis.</p>

<h2>Comportamiento</h2>
<p>Esta planta probablemente se desarrollaba en ambientes húmedos y pantanosos, donde podía aprovechar las condiciones favorables del Devónico para crecer y prosperar.</p>

<h2>Reproducción</h2>
<p><strong>Rhacophyton</strong> se reproducía mediante esporas, como la mayoría de las plantas del periodo Devónico. Estas esporas se liberaban y se dispersaban por el aire, para germinar y formar nuevos individuos en condiciones favorables.</p>

<h2>Descubrimiento</h2>
<p>El género <strong>Rhacophyton</strong> fue identificado y descrito a partir de fósiles que datan del Devónico. Estos fósiles son clave para entender la evolución de las plantas vasculares en la transición de los ambientes acuáticos a los terrestres.</p>

<h2>Relación con otras plantas</h2>
<p><strong>Rhacophyton</strong> es parte de un grupo de plantas primordiales que forman parte de la evolución de las plantas vasculares. Está relacionado con otras plantas del Devónico como <strong>Cooksonia</strong> y <strong>Baragwanathia</strong>.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Las plantas como <strong>Rhacophyton</strong> fueron cruciales en la colonización de la tierra por parte de las plantas, al introducir la capacidad de transporte de agua y nutrientes por todo el cuerpo de la planta.</li>
    <li>Su estructura de ramificación única es una de las razones por las que se considera un eslabón importante en la evolución de las plantas terrestres primitivas.</li>
    <li>Hoy en día, se pueden estudiar los fósiles de <strong>Rhacophyton</strong> para entender mejor cómo las primeras plantas comenzaron a adaptarse a los ambientes terrestres.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
