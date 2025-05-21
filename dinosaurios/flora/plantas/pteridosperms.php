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
    <title>Pteridosperms - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Pteridosperms</h1>

<a href="../../../img/Pteridosperms.png" target="_blank">
    <img src="../../../img/Pteridosperms.png" alt="Pteridosperms" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p>El nombre <strong>Pteridosperms</strong> proviene del griego, donde <em>pteron</em> significa "pluma" y <em>sperma</em> significa "semilla". Se refiere a las plantas que tenían semillas pero con características similares a las de los helechos, por lo que se les conoce como "helechos con semillas".</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Pteridophyta</li>
    <li><strong>Clase:</strong> Pteridospermatophyta</li>
    <li><strong>Orden:</strong> Pteridospermatales</li>
    <li><strong>Familia:</strong> Diversas familias dentro del orden</li>
    <li><strong>Género:</strong> Diversos géneros, como <em>Medullosa</em> y <em>Archaeopteris</em></li>
</ul>

<h2>Periodo geológico</h2>
<p>Los Pteridosperms existieron durante el <strong>Devónico</strong> y <strong>Carbonífero</strong>, hace aproximadamente entre 380 y 300 millones de años, marcando un importante periodo en la evolución de las plantas con semillas.</p>

<h2>Distribución geográfica</h2>
<p>Las Pteridosperms eran comunes en las zonas pantanosas y boscosas del <strong>Devónico</strong> y <strong>Carbonífero</strong>. Se distribuyeron en lo que hoy son América del Norte, Europa y Asia.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Hojas:</strong> Similares a las de los helechos modernos, compuestas y pinnadas.</li>
    <li><strong>Semillas:</strong> Contaban con semillas, una característica clave que las distingue de los helechos modernos, que no producen semillas.</li>
    <li><strong>Tamaño:</strong> Algunas especies de Pteridosperms alcanzaban tamaños grandes, formando parte de los bosques primitivos de la era Paleozoica.</li>
</ul>

<h2>Alimentación</h2>
<p>Al igual que los helechos modernos, los Pteridosperms eran plantas autótrofas, realizando fotosíntesis para generar su propio alimento a partir de la luz solar, el dióxido de carbono y el agua.</p>

<h2>Comportamiento</h2>
<p>Las Pteridosperms fueron plantas dominantes durante su época, contribuyendo a la formación de grandes bosques de la era Paleozoica. Al ser plantas con semillas, su capacidad para reproducirse sin la necesidad de agua libre fue un avance evolutivo importante.</p>

<h2>Reproducción</h2>
<p>Las Pteridosperms se reproducían mediante semillas. Aunque su mecanismo de fertilización era similar al de las coníferas, sus estructuras reproductivas eran más simples y primigenias, semejantes a las de los helechos.</p>

<h2>Descubrimiento</h2>
<p>Las primeras especies de Pteridosperms fueron identificadas a través de restos fósiles de hojas y semillas, y su descubrimiento ha proporcionado importantes claves sobre la evolución de las plantas terrestres con semillas.</p>

<h2>Relación con otras plantas</h2>
<p>Las Pteridosperms están relacionadas con las primeras plantas con semillas, y su existencia marcó la transición entre los helechos y las modernas plantas con semillas, como las coníferas y las angiospermas.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Las Pteridosperms fueron una de las primeras plantas en desarrollar semillas, lo que les permitió dispersarse de manera más eficiente que los helechos, que dependían de ambientes húmedos para reproducirse.</li>
    <li>Algunas especies de Pteridosperms formaban grandes árboles que dominaban los paisajes de los bosques primitivos de la era Paleozoica.</li>
    <li>Se cree que los Pteridosperms jugaron un papel crucial en la formación de los primeros ecosistemas forestales, con árboles de gran tamaño.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
