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
    <title>Plateosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Plateosaurus</h1>

<a href="../../../img/Plateosaurus.webp" target="_blank">
    <img src="../../../img/Plateosaurus.webp" alt="Plateosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Plateosaurus</strong> proviene del griego "plateia" (ancha) y "sauros" (lagarto), lo que significa "lagarto ancho". Fue nombrado debido a su gran cuerpo y complexión robusta.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Sauropodomorpha</li>
    <li><strong>Familia:</strong> Plateosauridae</li>
    <li><strong>Género:</strong> Plateosaurus</li>
    <li><strong>Especie:</strong> P. engelhardti (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Triásico Tardío</strong>, hace aproximadamente <strong>214 a 204 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado principalmente en:</p>
<ul>
    <li>Europa (principalmente en Alemania y Suiza)</li>
    <li>Argentina (en menor cantidad)</li>
</ul>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 8 metros</li>
    <li><strong>Peso:</strong> Alrededor de 1.5 toneladas</li>
    <li><strong>Postura:</strong> Bípedo, aunque probablemente también caminaba en cuatro patas en ocasiones</li>
    <li><strong>Cola:</strong> Larga y gruesa, probablemente usada para equilibrar su cuerpo mientras se desplazaba</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> que se alimentaba de plantas y vegetación baja. Se cree que también podía alimentarse de árboles jóvenes y arbustos.</p>

<h2>Comportamiento</h2>
<p>Plateosaurus era un dinosaurio relativamente lento, pero su tamaño y su dieta de plantas lo hacían menos vulnerable a los depredadores. Probablemente vivía en grupos pequeños o medianos para protegerse.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, el Plateosaurus se reproducía por medio de <strong>huevos</strong>. Aunque no se conocen muchos detalles sobre su comportamiento reproductivo, se estima que los nidos eran probablemente construidos en el suelo.</p>

<h2>Descubrimiento</h2>
<p>Los primeros restos de Plateosaurus fueron descubiertos en el siglo XIX en Alemania. Desde entonces, se han encontrado más fósiles en varias partes de Europa, lo que ha permitido una mejor comprensión de su biología y ecología.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Pertenece a la familia Plateosauridae, que incluye otros dinosaurios similares como <em>Riojasaurus</em> y <em>Massospondylus</em>. Todos estos dinosaurios comparten características de cuerpo largo y cuello largo, además de un cuerpo relativamente robusto para su época.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Plateosaurus fue uno de los primeros grandes dinosaurios herbívoros conocidos.</li>
    <li>Sus dientes eran adecuados para cortar y masticar plantas duras, lo que le permitió sobrevivir durante el Triásico.</li>
    <li>Se cree que Plateosaurus pudo haber sido un antecesor temprano de los grandes dinosaurios sauropodomorfos que vivieron en el Jurásico.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
