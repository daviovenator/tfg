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
    <title>Calamites - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Calamites</h1>

<a href="../../../img/Calamites.jpg" target="_blank">
    <img src="../../../img/Calamites.jpg" alt="Calamites" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Calamites</strong> proviene del latín "calamus", que significa caña, en referencia a su aspecto similar al bambú o a las cañas modernas.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Equisetophyta</li>
    <li><strong>Clase:</strong> Equisetopsida</li>
    <li><strong>Orden:</strong> Equisetales</li>
    <li><strong>Familia:</strong> Calamitaceae</li>
    <li><strong>Género:</strong> Calamites</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Carbonífero</strong>, hace aproximadamente <strong>360 a 290 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Fósiles de Calamites se han hallado en Europa, América del Norte y Asia, principalmente en antiguos depósitos de carbón.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Altura:</strong> Hasta 20 metros.</li>
    <li><strong>Tallos:</strong> Segmentados, parecidos a los de las colas de caballo actuales, con nudos y entrenudos visibles.</li>
    <li><strong>Hojas:</strong> Delgadas y dispuestas en verticilos alrededor de los nudos.</li>
    <li><strong>Raíces:</strong> Rizomatosas, extensas para anclarse en suelos pantanosos.</li>
</ul>

<h2>Alimentación</h2>
<p>Era una planta <strong>fotosintética</strong>, capaz de generar su propio alimento gracias a la luz solar y el dióxido de carbono.</p>

<h2>Comportamiento</h2>
<p>Formaba densos bosques en zonas húmedas y pantanosas, contribuyendo a los ecosistemas del Carbonífero y a la formación de carbón.</p>

<h2>Reproducción</h2>
<p>Se reproducía mediante <strong>esporas</strong>, como los helechos y equisetos modernos. Los esporangios estaban en estructuras cónicas llamadas estróbilos.</p>

<h2>Descubrimiento</h2>
<p>Calamites fue identificado a partir de fósiles bien conservados en minas de carbón del siglo XIX, donde se reconoció su estructura segmentada única.</p>

<h2>Relación con otras plantas</h2>
<p>Está emparentado con las <em>colas de caballo</em> actuales (género <em>Equisetum</em>), aunque estas son mucho más pequeñas.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Contribuyó significativamente a la formación de carbón fósil durante el Carbonífero.</li>
    <li>Sus tallos eran huecos y podían crecer rápidamente en condiciones húmedas.</li>
    <li>Sus restos fósiles son tan comunes que se usan como fósiles guía para este periodo.</li>
    <li>Era una de las pocas plantas arborescentes del grupo de las equisetales.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
