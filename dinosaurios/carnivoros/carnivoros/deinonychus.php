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
    <title>Deinonychus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Deinonychus</h1>

<a href="../../../img/Deinonychus.jpg" target="_blank">
    <img src="../../../img/Deinonychus.jpg" alt="Deinonychus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Deinonychus</strong> significa "garra terrible", en referencia a la gran garra curva en forma de hoz en cada uno de sus pies.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Dromaeosauridae</li>
    <li><strong>Género:</strong> Deinonychus</li>
    <li><strong>Especie:</strong> D. antirrhopus</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Inferior</strong>, hace aproximadamente <strong>115 a 108 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Fósiles de Deinonychus han sido hallados en:
<ul>
    <li>Montana</li>
    <li>Wyoming</li>
    <li>Oklahoma</li>
    <li>Texas</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Alrededor de 3 metros</li>
    <li><strong>Altura:</strong> Aproximadamente 1,2 metros a la cadera</li>
    <li><strong>Peso:</strong> Hasta 70 kilogramos</li>
    <li><strong>Garras:</strong> Una garra curva de hasta 12 cm en cada pie</li>
    <li><strong>Plumas:</strong> Se presume que tenía plumaje</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>carnívoro</strong>, y probablemente cazaba en grupo. Se cree que atacaba con sus patas traseras, usando su garra para desgarrar a sus presas.</p>

<h2>Comportamiento</h2>
<p>Deinonychus fue uno de los primeros dinosaurios que cambió la percepción del público y los científicos sobre los dinosaurios como animales activos y ágiles. Es posible que tuviera comportamientos sociales y estrategias de caza en grupo.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, Deinonychus se reproducía mediante <strong>huevos</strong>. Es posible que cuidara de sus crías, como otros dromeosáuridos emparentados con las aves.</p>

<h2>Descubrimiento</h2>
<p>Fue descubierto en 1964 por John H. Ostrom. Su hallazgo fue clave en el desarrollo de la teoría de que las aves descienden de dinosaurios terópodos.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Deinonychus pertenece a la familia Dromaeosauridae, que incluye a:
<ul>
    <li>Velociraptor</li>
    <li>Utahraptor</li>
    <li>Microraptor</li>
</ul>
Todos presentan garras especiales en los pies y muchas evidencias de plumas.</p>

<h2>Importancia cultural</h2>
<p>Inspiró a los velociraptores de <em>Jurassic Park</em>, aunque estos últimos son más parecidos en tamaño y comportamiento al Deinonychus real.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Su nombre significa "garra terrible" en griego.</li>
    <li>Tenía un gran cerebro en proporción a su cuerpo, lo que sugiere una buena coordinación y posible inteligencia.</li>
    <li>Podía saltar y atacar con ambas patas traseras simultáneamente.</li>
    <li>Es uno de los principales vínculos entre aves y dinosaurios.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
