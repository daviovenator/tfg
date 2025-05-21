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
    <title>Phytosaurios - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Phytosaurios</h1>

<a href="../../../img/Phytosaurios.jpg" target="_blank">
    <img src="../../../img/Phytosaurios.jpg" alt="Phytosaurios" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Phytosaurios</strong> significa "lagartos planta", un nombre originalmente erróneo ya que se pensaba que eran herbívoros por la forma de sus dientes, aunque en realidad eran <strong>carnívoros</strong>.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Phytosauria</li>
    <li><strong>Familia:</strong> Varios géneros (como Rutiodon y Mystriosuchus)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivieron durante el <strong>Triásico Tardío</strong>, hace aproximadamente <strong>235 a 201 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Fósiles de Phytosaurios se han encontrado en:
<ul>
    <li>América del Norte</li>
    <li>Europa</li>
    <li>India</li>
    <li>África</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 12 metros en algunos casos</li>
    <li><strong>Aspecto:</strong> Muy similares a los cocodrilos modernos, con hocico alargado</li>
    <li><strong>Narinas:</strong> Situadas cerca de los ojos, no en la punta del hocico</li>
    <li><strong>Piel:</strong> Cubierta por placas óseas (osteodermos)</li>
</ul>

<h2>Alimentación</h2>
<p>Fueron <strong>carnívoros</strong>, se alimentaban de peces y otros animales acuáticos. Sus dientes puntiagudos eran ideales para atrapar presas resbaladizas.</p>

<h2>Comportamiento</h2>
<p>Probablemente eran <strong>acuáticos</strong> o semiacuáticos, emboscando a sus presas desde el agua como hacen los cocodrilos actuales.</p>

<h2>Reproducción</h2>
<p>Como la mayoría de los reptiles, ponían <strong>huevos</strong>. Es posible que enterraran sus huevos cerca de las orillas.</p>

<h2>Descubrimiento</h2>
<p>Los primeros fósiles fueron descubiertos en el siglo XIX. Su clasificación ha sido confusa, ya que no son dinosaurios ni cocodrilos, aunque están emparentados con ambos como miembros de los arcosaurios.</p>

<h2>Relación con otros reptiles</h2>
<p>Los Phytosaurios no eran dinosaurios, pero compartían un ancestro común. Están más estrechamente relacionados con los cocodrilos que con los dinosaurios.</p>

<h2>Importancia cultural</h2>
<p>Aunque menos conocidos que los dinosaurios, los Phytosaurios son un ejemplo clásico de evolución convergente por su similitud con los cocodrilos modernos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Las narinas cerca de los ojos los diferencian claramente de cocodrilos actuales.</li>
    <li>Se extinguieron al final del Triásico, antes del auge de los dinosaurios.</li>
    <li>Su aspecto cocodriliano ha causado confusión en su identificación fósil.</li>
    <li>Algunos géneros como Rutiodon tenían hocicos extremadamente largos y delgados.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
