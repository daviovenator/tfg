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
    <title>Podozamites - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Podozamites</h1>

<a href="../../../img/Podozamites.jpeg" target="_blank">
    <img src="../../../img/Podozamites.jpeg" alt="Podozamites" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Podozamites</strong> deriva de dos raíces griegas: <em>podós</em> que significa "pie" y <em>zamites</em> que hace referencia a "cícada", indicando su pertenencia a un género relacionado con las cícadas, en particular aquellas con una distribución de hojas similar a las de los pinos.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Cycadophyta</li>
    <li><strong>Clase:</strong> Cycadopsida</li>
    <li><strong>Orden:</strong> Cycadales</li>
    <li><strong>Familia:</strong> Podozamiteaceae</li>
    <li><strong>Género:</strong> Podozamites</li>
</ul>

<h2>Periodo geológico</h2>
<p><strong>Podozamites</strong> existió principalmente durante el <strong>Mesozoico</strong>, específicamente en el <strong>Jurásico</strong> y el <strong>Cretácico</strong>, hace entre 180 y 65 millones de años, en un periodo en el que las cícadas dominaban una parte considerable de la flora terrestre.</p>

<h2>Distribución geográfica</h2>
<p>Las plantas de <strong>Podozamites</strong> fueron comunes en los ecosistemas de zonas tropicales y subtropicales del Mesozoico. Sus fósiles se han encontrado en lo que hoy son regiones de Europa, América del Norte y Asia.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Las hojas de <strong>Podozamites</strong> eran largas, estrechas y dispuestas en una forma pinnada, lo que les daba una apariencia similar a las hojas de los pinos modernos, pero pertenecían a una planta de la familia de las cícadas.</li>
    <li><strong>Tamaño:</strong> Las plantas de <strong>Podozamites</strong> podían alcanzar tamaños considerablemente grandes, con algunas especies alcanzando los 6 metros de altura.</li>
    <li><strong>Tallos:</strong> Presentaban troncos robustos y lenticulares que almacenaban nutrientes y agua, lo que les permitía resistir períodos de sequía.</li>
</ul>

<h2>Alimentación</h2>
<p><strong>Podozamites</strong> era una planta autótrofa que realizaba fotosíntesis, utilizando la luz solar, el dióxido de carbono y el agua para generar su propio alimento.</p>

<h2>Comportamiento</h2>
<p>Las plantas de <strong>Podozamites</strong> eran muy resistentes y se desarrollaban en ambientes cálidos y húmedos. Aunque adaptadas a climas tropicales, también podían sobrevivir en suelos pobres o arenosos, lo que les permitió extenderse en diversas zonas.</p>

<h2>Reproducción</h2>
<p><strong>Podozamites</strong> se reproducía mediante conos, un mecanismo característico de las cícadas. Los conos masculinos producían polen, mientras que los conos femeninos contenían las semillas que se dispersaban por el viento o con la ayuda de otros factores.</p>

<h2>Descubrimiento</h2>
<p>El descubrimiento de <strong>Podozamites</strong> se basa en varios fósiles de hojas y conos que han sido identificados en las formaciones geológicas del Mesozoico, proporcionándonos una visión más detallada sobre la flora de esa era.</p>

<h2>Relación con otras plantas</h2>
<p><strong>Podozamites</strong> está estrechamente relacionado con otras cícadas primitivas, como <strong>Zamia</strong>, y con el grupo de las plantas coníferas, compartiendo algunas características morfológicas y estructuras reproductivas.</p>

<h2>Curiosidades</h2>
<ul>
    <li><strong>Podozamites</strong> es un excelente ejemplo de cómo las cícadas primarias dominaron la flora terrestre durante el Mesozoico, junto con los helechos y las coníferas.</li>
    <li>Los fósiles de <strong>Podozamites</strong> han proporcionado información clave sobre los ecosistemas del Mesozoico y cómo estas plantas coexistían con los dinosaurios.</li>
    <li>Al igual que otras cícadas, <strong>Podozamites</strong> podría haber tenido una relación simbiótica con ciertos grupos de insectos, que ayudaban en la polinización.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
