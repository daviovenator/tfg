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
    <title>Liopleurodon - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Liopleurodon</h1>

<a href="../../../img/Liopleurodon.webp" target="_blank">
    <img src="../../../img/Liopleurodon.webp" alt="Liopleurodon" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Liopleurodon</strong> significa "diente de lado liso", debido a sus dientes grandes y afilados que eran utilizados para cazar presas acuáticas.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Plesiosauria</li>
    <li><strong>Suborden:</strong> Pliosauroidea</li>
    <li><strong>Familia:</strong> Pliosauridae</li>
    <li><strong>Género:</strong> Liopleurodon</li>
    <li><strong>Especie:</strong> L. ferox</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Medio</strong>, hace aproximadamente <strong>160 millones de años</strong>, en los océanos prehistóricos que cubrían gran parte de la Tierra en ese momento.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado restos de Liopleurodon en diversas partes del mundo, como:
<ul>
    <li>Europa (Reino Unido)</li>
    <li>Sudamérica (Brasil)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 6 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 1-2 toneladas</li>
    <li><strong>Cuerpo:</strong> Cuerpo robusto y aerodinámico, con una cabeza grande y mandíbulas poderosas</li>
    <li><strong>Mandíbulas:</strong> Sus mandíbulas estaban equipadas con dientes afilados y curvados, ideales para capturar presas rápidas.</li>
</ul>

<h2>Alimentación</h2>
<p>Liopleurodon era un <strong>depredador marino</strong>, que cazaba peces y otros reptiles marinos más pequeños. Su gran tamaño y habilidades de caza lo convirtieron en uno de los depredadores más formidables de su tiempo.</p>

<h2>Comportamiento</h2>
<p>Probablemente cazaba de manera activa, utilizando su agilidad y velocidad en el agua para sorprender a sus presas. Como otros pliosaurios, era un animal altamente adaptado a la vida acuática.</p>

<h2>Reproducción</h2>
<p>Como otros reptiles marinos, se cree que Liopleurodon se reproducía mediante <strong>huevos</strong>, aunque no se han encontrado nidos fósiles que proporcionen información directa sobre su comportamiento reproductivo.</p>

<h2>Descubrimiento</h2>
<p>Los restos de Liopleurodon fueron encontrados por primera vez en el siglo XIX, y se han realizado importantes estudios sobre este reptil marino debido a su tamaño y su papel en los ecosistemas marinos del Jurásico.</p>

<h2>Relación con otros animales</h2>
<p>Liopleurodon es un miembro de los pliosaurios, un grupo de reptiles marinos que coexistieron con los dinosaurios durante la Era Mesozoica. Estaba relacionado con otros grandes depredadores como Pliosaurus y Kronosaurus.</p>

<h2>Importancia cultural</h2>
<p>Liopleurodon ha ganado popularidad gracias a su aparición en documentales como *Walking with Dinosaurs*, donde se presenta como un formidable depredador marino. Su aspecto y habilidades de caza lo han hecho famoso entre los fanáticos de los reptiles prehistóricos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Liopleurodon tenía una de las mordidas más poderosas de los reptiles marinos, capaz de destrozar a sus presas con facilidad.</li>
    <li>Sus ojos estaban adaptados para ver bien en las oscuras profundidades del océano.</li>
    <li>Aunque no era tan grande como algunos de sus parientes, como el Megalodon, era extremadamente ágil y rápido en el agua.</li>
    <li>Era uno de los principales depredadores marinos de su tiempo, al igual que los actuales tiburones grandes.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
