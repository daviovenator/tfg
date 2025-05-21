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
    <title>Baryonyx - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Baryonyx</h1>

<a href="../../../img/baryonix.webp" target="_blank">
    <img src="../../../img/baryonix.webp" alt="Baryonyx" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Baryonyx</strong> significa "garra pesada", en referencia a su enorme garra curvada de más de 30 cm de largo en el primer dedo de sus patas delanteras.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Spinosauridae</li>
    <li><strong>Género:</strong> Baryonyx</li>
    <li><strong>Especie:</strong> B. walkeri</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Inferior</strong>, hace aproximadamente <strong>130 a 125 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han encontrado principalmente en Europa, especialmente en:
<ul>
    <li>Sur de Inglaterra (Reino Unido)</li>
    <li>España</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 10 metros</li>
    <li><strong>Peso:</strong> Alrededor de 1.2 toneladas</li>
    <li><strong>Morfología:</strong> Hocico largo y estrecho similar al de un cocodrilo</li>
    <li><strong>Dientes:</strong> Cónicos y no serrados, ideales para atrapar peces</li>
    <li><strong>Garra:</strong> Muy grande y curva en sus patas delanteras</li>
</ul>

<h2>Alimentación</h2>
<p>Era principalmente <strong>piscívoro</strong> (comedores de peces), aunque también podía alimentarse de otros animales pequeños. Su morfología sugiere una dieta semiacuática, similar a la de los cocodrilos modernos.</p>

<h2>Comportamiento</h2>
<p>Probablemente cazaba cerca del agua, acechando peces y pequeñas presas. Su estructura corporal también le habría permitido nadar o moverse cómodamente en ambientes pantanosos o ribereños.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, el Baryonyx se reproducía por medio de <strong>huevos</strong>. Aunque no se han encontrado nidos confirmados, se asume que su reproducción era similar a la de otros terópodos.</p>

<h2>Descubrimiento</h2>
<p>Fue descubierto en 1983 en Surrey, Inglaterra, por el cazador de fósiles amateur William Walker. El hallazgo fue significativo por incluir gran parte del esqueleto, algo poco común para dinosaurios carnívoros.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Formaba parte de la familia Spinosauridae, al igual que:
<ul>
    <li>Spinosaurus</li>
    <li>Suchomimus</li>
</ul>
Estos dinosaurios compartían adaptaciones acuáticas y una dieta centrada en peces.</p>

<h2>Importancia cultural</h2>
<p>El Baryonyx ha ganado notoriedad en la cultura popular por su apariencia inusual y sus vínculos con ambientes acuáticos. Ha aparecido en documentales, museos y películas como <em>Jurassic World: El reino caído</em>.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Se encontraron escamas de pez y huesos de un joven Iguanodon en el área de su estómago fósil, lo que confirma su dieta variada.</li>
    <li>Su garra era tan grande que al principio se pensó que pertenecía a un dinosaurio completamente diferente.</li>
    <li>Es uno de los terópodos mejor preservados hallados en el Reino Unido.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
