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
    <title>Ichthyovenator - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Ichthyovenator</h1>

<a href="../../../img/Ichthyovenator.webp" target="_blank">
    <img src="../../../img/Ichthyovenator.webp" alt="Ichthyovenator" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Ichthyovenator</strong> significa "cazador de peces", en referencia a su probable dieta basada en peces y su adaptación acuática.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Spinosauridae</li>
    <li><strong>Género:</strong> Ichthyovenator</li>
    <li><strong>Especie:</strong> I. laosensis</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Inferior</strong>, hace aproximadamente <strong>125 a 113 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus restos fueron descubiertos en Laos, en el sudeste asiático.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 8-9 metros</li>
    <li><strong>Peso:</strong> Alrededor de 2 toneladas</li>
    <li><strong>Rasgo distintivo:</strong> Una vela dorsal dividida en dos secciones</li>
    <li><strong>Adaptaciones:</strong> Cuerpo adaptado a ambientes acuáticos</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>carnívoro piscívoro</strong>, especializado en la caza de peces, similar a otros espinosaurios.</p>

<h2>Comportamiento</h2>
<p>Probablemente llevaba un estilo de vida semiacuático, acechando en ríos y lagos para atrapar presas.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, se reproducía mediante <strong>huevos</strong>, aunque no se han encontrado nidos asociados a este género.</p>

<h2>Descubrimiento</h2>
<p>Ichthyovenator fue descrito en 2012 a partir de fósiles descubiertos en la Formación Grès supérieurs en Laos.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Es un miembro de la familia Spinosauridae, relacionado con Spinosaurus y Baryonyx, todos ellos con adaptaciones acuáticas.</p>

<h2>Importancia cultural</h2>
<p>Es uno de los pocos dinosaurios espinosaurios conocidos del sudeste asiático y se destaca por su vela doble única.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Su nombre hace referencia a su dieta piscívora.</li>
    <li>Es el primer espinosaurio descrito en el sudeste asiático.</li>
    <li>La vela en su espalda podría haber tenido fines de exhibición o regulación térmica.</li>
    <li>Comparte rasgos con Spinosaurus, pero su estructura vertebral es única.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
