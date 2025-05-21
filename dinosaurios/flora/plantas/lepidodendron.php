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
    <title>Lepidodendron - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Lepidodendron</h1>

<a href="../../../img/Lepidodendron.webp" target="_blank">
    <img src="../../../img/Lepidodendron.webp" alt="Lepidodendron" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Lepidodendron</strong> significa "árbol escamoso", derivado del griego <em>lepis</em> (escama) y <em>dendron</em> (árbol), por la forma de escamas que dejaban sus hojas al desprenderse.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Lycopodiophyta</li>
    <li><strong>Clase:</strong> Isoetopsida</li>
    <li><strong>Orden:</strong> Lepidodendrales</li>
    <li><strong>Familia:</strong> Lepidodendraceae</li>
    <li><strong>Género:</strong> Lepidodendron</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Carbonífero</strong>, hace aproximadamente <strong>359 a 299 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles de Lepidodendron en Europa, América del Norte, Asia y otras regiones que en ese entonces formaban parte de pantanos tropicales.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Altura:</strong> Hasta 40 metros de altura.</li>
    <li><strong>Tallo:</strong> Recto y cilíndrico, cubierto de marcas en forma de rombos (cicatrices de hojas).</li>
    <li><strong>Hojas:</strong> Largas, en forma de cinta, dispuestas helicoidalmente.</li>
    <li><strong>Raíces:</strong> Extensas y horizontales, llamadas <em>Stigmaria</em>.</li>
</ul>

<h2>Alimentación</h2>
<p>Realizaba <strong>fotosíntesis</strong> y crecía en ambientes húmedos y ricos en nutrientes, como pantanos y bosques fangosos.</p>

<h2>Comportamiento</h2>
<p>Formaba densos bosques junto a Sigillaria y Calamites. Su crecimiento era rápido, y se cree que vivía solo unos pocos años antes de liberar sus esporas.</p>

<h2>Reproducción</h2>
<p>Se reproducía por <strong>esporas</strong>, que se generaban en conos (estróbilos) situados en las ramas superiores del árbol.</p>

<h2>Descubrimiento</h2>
<p>Identificado en el siglo XIX, Lepidodendron fue uno de los primeros árboles fósiles ampliamente estudiados, gracias a su abundancia en yacimientos de carbón.</p>

<h2>Relación con otras plantas</h2>
<p>Estrechamente relacionado con otras licofitas arborescentes como <em>Sigillaria</em>. A diferencia de los árboles modernos, no tenía crecimiento secundario leñoso.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Es conocido como el "árbol escamoso" por las marcas romboidales en su corteza.</li>
    <li>Dominó los bosques del Carbonífero junto con otras plantas gigantes.</li>
    <li>Contribuyó significativamente a la formación de grandes yacimientos de carbón.</li>
    <li>Hoy no tiene equivalentes vivos con un tamaño comparable.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
