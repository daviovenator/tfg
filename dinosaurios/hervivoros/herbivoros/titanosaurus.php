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
    <title>Titanosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Titanosaurus</h1>

<a href="../../../img/titanosaurus.jpg" target="_blank">
    <img src="../../../img/titanosaurus.jpg" alt="Titanosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Titanosaurus</strong> recibe su nombre del griego "Titan" (titanes) y "sauros" (lagarto), lo que significa "lagarto titán", en referencia a su enorme tamaño.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Sauropodomorpha</li>
    <li><strong>Familia:</strong> Sauropodidae</li>
    <li><strong>Género:</strong> Titanosaurus</li>
    <li><strong>Especie:</strong> T. indicus</li>
</ul>

<h2>Periodo geológico</h2>
<p>El Titanosaurus vivió durante el <strong>Cretácico Superior</strong>, hace aproximadamente <strong>70 a 65 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Este dinosaurio fue encontrado en lo que hoy es la India, donde vivió en un entorno de llanuras y bosques densos. Sus fósiles han sido principalmente excavados en el subcontinente indio.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Se estima que alcanzaba los 25 a 30 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 50 a 70 toneladas</li>
    <li><strong>Cuerpo:</strong> Su cuerpo era masivo y robusto, con un cuello largo y una cola igualmente extensa.</li>
    <li><strong>Cabeza:</strong> Relativamente pequeña en comparación con su cuerpo</li>
    <li><strong>Columna vertebral:</strong> Sostenía su cuerpo masivo, adaptada para soportar su gran tamaño</li>
</ul>

<h2>Alimentación</h2>
<p>El Titanosaurus era un <strong>herbívoro</strong> que se alimentaba de plantas, arbustos y árboles altos. Su gran cuello le permitía alcanzar la vegetación a grandes alturas, lo que lo hacía uno de los dinosaurios más eficientes para comer en su época.</p>

<h2>Comportamiento</h2>
<p>Este dinosaurio vivía probablemente en grupos, lo que le habría permitido defenderse de los depredadores y desplazarse de manera más eficiente en su entorno. Debido a su tamaño, el Titanosaurus no tenía muchos depredadores naturales, aunque algunos dinosaurios carnívoros pudieron haber atacado a crías o individuos débiles.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios, el Titanosaurus se reproducía mediante <strong>huevos</strong>. No se sabe exactamente cómo cuidaba a sus crías, pero es probable que, al igual que otros sauropodos, los jóvenes eran vulnerables y necesitaban protección al principio de su vida.</p>

<h2>Descubrimiento</h2>
<p>El Titanosaurus fue descrito por primera vez en 1861 por el paleontólogo Richard Lydekker, a partir de fragmentos de huesos encontrados en la India. Aunque en su momento fue considerado un miembro de una familia más amplia de sauropodos, hoy se le reconoce como un representante clave de los titanosaurios, una familia de sauropodos con huesos más robustos y una estructura corporal distinta.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Titanosaurus pertenece a la familia Titanosauridae, que incluye a otros gigantes herbívoros como el <em>Argentinosaurus</em> y el <em>Futalognkosaurus</em>. Estos dinosaurios comparten características como su tamaño masivo, cuello largo y cola extensa.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Titanosaurus es uno de los dinosaurios más grandes conocidos en la India y uno de los últimos grandes sauropodos que existieron antes de la extinción masiva del Cretácico.</li>
    <li>Su nombre, "lagarto titán", refleja su enorme tamaño, similar al de los titanes de la mitología griega.</li>
    <li>Se cree que el Titanosaurus tenía un gran corazón, necesario para bombear sangre a su enorme cuerpo, aunque no se han encontrado fósiles de su corazón.</li>
    <li>Al igual que otros sauropodos, su tamaño y peso le daban una ventaja significativa sobre los depredadores de su tiempo.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
