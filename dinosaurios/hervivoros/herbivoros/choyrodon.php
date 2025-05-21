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
    <title>Choyrodon - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Choyrodon</h1>

<a href="../../../img/Choyrodon.jpg" target="_blank">
    <img src="../../../img/Choyrodon.jpg" alt="Choyrodon" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Choyrodon</strong> proviene del griego "Choyro", que hace referencia a un lugar de la región de Mongolia, y "odon", que significa "diente". Así que su nombre hace referencia a los dientes que se encuentran en los fósiles de este dinosaurio.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Suborden:</strong> Cerapoda</li>
    <li><strong>Familia:</strong> Hypsilophodontidae</li>
    <li><strong>Género:</strong> Choyrodon</li>
    <li><strong>Especie:</strong> C. densum</li>
</ul>

<h2>Periodo geológico</h2>
<p>El Choyrodon vivió durante el <strong>Cretácico Temprano</strong>, aproximadamente hace <strong>120 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Este dinosaurio ha sido encontrado principalmente en Mongolia, donde sus fósiles fueron descubiertos por paleontólogos rusos en el siglo XX.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 3 metros</li>
    <li><strong>Peso:</strong> Se estima que pesaba entre 100 y 200 kilogramos</li>
    <li><strong>Cuerpo:</strong> De tamaño medio, con un cuerpo ligero y adaptado para la velocidad</li>
    <li><strong>Cola:</strong> Larga, lo que ayudaba a mantener el equilibrio al correr</li>
    <li><strong>Cabeza:</strong> Relativamente pequeña, con dientes adaptados para una dieta herbívora</li>
</ul>

<h2>Alimentación</h2>
<p>El Choyrodon era un <strong>herbívoro</strong> que se alimentaba principalmente de plantas bajas y arbustos, lo que indicaría que vivió en bosques o áreas con vegetación densa.</p>

<h2>Comportamiento</h2>
<p>Se cree que el Choyrodon era un dinosaurio ágil y veloz, lo que le permitía escapar de depredadores más grandes. Probablemente vivía en grupos pequeños para aumentar sus probabilidades de defensa.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios de su tipo, el Choyrodon se reproducía por medio de <strong>huevos</strong>, aunque no se tiene mucha información sobre su comportamiento reproductivo específico.</p>

<h2>Descubrimiento</h2>
<p>El Choyrodon fue descrito en 1979 a partir de restos fósiles encontrados en Mongolia. A pesar de ser un dinosaurio poco conocido, su descubrimiento fue importante para entender la fauna del Cretácico Temprano.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Choyrodon pertenece a la familia Hypsilophodontidae, que incluye dinosaurios pequeños y veloces como el <em>Hypsilophodon</em>. Estos dinosaurios compartían características como el cuerpo ligero y los dientes adaptados para la alimentación herbívora.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Choyrodon es un dinosaurio poco conocido debido a la escasez de fósiles completos.</li>
    <li>Se ha sugerido que su agilidad y velocidad eran sus principales defensas contra los depredadores de la época.</li>
    <li>El Choyrodon vivió junto a otros dinosaurios herbívoros como el <em>Archaeoceratops</em> y el <em>Hypsilophodon</em>.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
