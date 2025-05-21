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
    <title>Troodon - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Troodon</h1>

<a href="../../../img/troodon.jpeg" target="_blank">
    <img src="../../../img/troodon.jpeg" alt="Troodon" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Troodon</strong> significa "diente que hiere", en referencia a sus dientes con bordes aserrados, únicos en su época.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Troodontidae</li>
    <li><strong>Género:</strong> Troodon</li>
    <li><strong>Especie:</strong> T. formosus</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Tardío</strong>, hace aproximadamente <strong>75 a 66 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Fósiles de Troodon han sido hallados principalmente en América del Norte, incluyendo:
<ul>
    <li>Montana</li>
    <li>Wyoming</li>
    <li>Alberta</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> 2 a 3 metros</li>
    <li><strong>Altura:</strong> Alrededor de 1 metro</li>
    <li><strong>Peso:</strong> Aproximadamente 50 kg</li>
    <li><strong>Dientes:</strong> Asimétricos y dentados, ideales para cortar carne</li>
    <li><strong>Cerebro:</strong> De gran tamaño en proporción a su cuerpo, lo que sugiere alta inteligencia</li>
    <li><strong>Ojos:</strong> Grandes, posiblemente con visión nocturna</li>
</ul>

<h2>Alimentación</h2>
<p>Probablemente era un <strong>omnívoro</strong>. Su dentadura sugiere que comía tanto carne como plantas o huevos.</p>

<h2>Comportamiento</h2>
<p>Se cree que era un animal ágil e inteligente, con buena visión y coordinación. Puede haber sido un cazador solitario o vivía en pequeños grupos.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios terópodos, ponía <strong>huevos</strong>. Se han encontrado nidos con huevos atribuidos a Troodon, y evidencias de que incubaba sus huevos como las aves.</p>

<h2>Descubrimiento</h2>
<p>Fue nombrado por Joseph Leidy en 1856. Inicialmente se le conocía solo por sus dientes, lo que generó muchas confusiones taxonómicas. Su clasificación aún es tema de debate.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Troodon pertenece a los Troodontidae, una familia cercana a las aves, que incluye a:
<ul>
    <li>Mei</li>
    <li>Saurornithoides</li>
    <li>Byronosaurus</li>
</ul>
Estos comparten características como cráneos estrechos y cerebros grandes.</p>

<h2>Importancia cultural</h2>
<p>Troodon es famoso por ser considerado uno de los dinosaurios más inteligentes. Ha sido objeto de especulación sobre cómo podría haber evolucionado si no se hubiera extinguido.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Su cociente de encefalización es uno de los más altos entre los dinosaurios.</li>
    <li>Algunos científicos especularon sobre una evolución hacia una criatura humanoide, el "dinosauroide".</li>
    <li>Podía utilizar sus garras prensiles para sujetar objetos o presas pequeñas.</li>
    <li>Probablemente tenía plumas.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
