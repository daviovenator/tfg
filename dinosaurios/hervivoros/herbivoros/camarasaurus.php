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
    <title>Camarasaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Camarasaurus</h1>

<a href="../../../img/Camarasaurus.webp" target="_blank">
    <img src="../../../img/Camarasaurus.webp" alt="Camarasaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Camarasaurus</strong> proviene del griego "kamara", que significa "cámara" o "cúpula", y "sauros", que significa "lagarto". Su nombre hace referencia a las cavidades en el cráneo de este dinosaurio, que podrían haber estado relacionadas con un sistema de respiración o acústica especializado.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Sauropoda</li>
    <li><strong>Familia:</strong> Camarasauridae</li>
    <li><strong>Género:</strong> Camarasaurus</li>
    <li><strong>Especie:</strong> C. supremus</li>
</ul>

<h2>Periodo geológico</h2>
<p>El Camarasaurus vivió durante el <strong>Jurásico Superior</strong>, hace aproximadamente <strong>154 a 153 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles han sido encontrados principalmente en lo que hoy es América del Norte, especialmente en los Estados de Wyoming, Colorado y Utah, en los Estados Unidos.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Alrededor de 18 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 20 toneladas</li>
    <li><strong>Cuello:</strong> Largo, pero no tan extenso como otros saurópodos.</li>
    <li><strong>Cola:</strong> Larga y delgada, lo que le ayudaba a equilibrar el cuerpo.</li>
    <li><strong>Cabeza:</strong> Relativamente pequeña en proporción al cuerpo, con un cráneo cuadrado y cámaras en los huesos.</li>
</ul>

<h2>Alimentación</h2>
<p>El Camarasaurus era un <strong>herbívoro</strong> que se alimentaba de vegetación alta como coníferas, helechos y otros tipos de plantas disponibles en su ecosistema jurásico.</p>

<h2>Comportamiento</h2>
<p>Se cree que el Camarasaurus vivía en grandes grupos, lo que le proporcionaba protección contra depredadores como el <em>Allosaurus</em>. A pesar de su tamaño, probablemente se desplazaba lentamente debido a su gran cuerpo.</p>

<h2>Reproducción</h2>
<p>Como otros saurópodos, el Camarasaurus se reproducía mediante <strong>huevos</strong>. Las hembras probablemente construían nidos en el suelo, donde depositaban sus huevos, que posteriormente eran incubados hasta su eclosión.</p>

<h2>Descubrimiento</h2>
<p>El Camarasaurus fue descrito por el paleontólogo Othniel Charles Marsh en 1877, después de que se descubrieran varios fósiles en el oeste de los Estados Unidos. Desde entonces, se han encontrado muchos más ejemplares de este dinosaurio.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Camarasaurus pertenece a la familia Camarasauridae, que incluye a otros saurópodos de tamaño mediano como el <em>Charonosaurus</em>. Su parentesco más cercano dentro de los saurópodos lo sitúa entre los <em>Brachiosaurus</em> y <em>Apatosaurus</em>.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Camarasaurus tenía un cuello largo, lo que le permitía alcanzar las copas de los árboles y alimentarse de hojas y vegetación de gran altura.</li>
    <li>Se cree que, debido a su tamaño, el Camarasaurus era uno de los dinosaurios más grandes de su ecosistema, y no tenía muchos depredadores naturales.</li>
    <li>El cráneo del Camarasaurus tiene una estructura de cámaras internas que posiblemente ayudaban a reducir el peso del cráneo.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
