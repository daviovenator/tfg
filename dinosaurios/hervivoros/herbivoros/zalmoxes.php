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
    <title>Zalmoxes - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Zalmoxes</h1>

<a href="../../../img/Zalmoxes.png" target="_blank">
    <img src="../../../img/Zalmoxes.png" alt="Zalmoxes" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Zalmoxes</strong> recibe su nombre del dios de la inmortalidad en la mitología tracia, Zalmoxis, aludiendo a su origen geográfico en lo que hoy es Rumanía.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Suborden:</strong> Cerapoda</li>
    <li><strong>Familia:</strong> Rhabdodontidae</li>
    <li><strong>Género:</strong> Zalmoxes</li>
    <li><strong>Especie:</strong> Z. robustus</li>
</ul>

<h2>Periodo geológico</h2>
<p>El Zalmoxes vivió durante el <strong>Cretácico Temprano</strong>, aproximadamente hace <strong>70 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Este dinosaurio ha sido encontrado en lo que hoy es Rumanía, específicamente en la formación geológica de Hațeg, que pertenecía a un ecosistema insular en el Cretácico.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 3 metros</li>
    <li><strong>Peso:</strong> Se estima que pesaba entre 50 y 100 kilogramos</li>
    <li><strong>Cuerpo:</strong> Ligero y ágil, con un cuerpo adaptado para la vida en un ecosistema insular</li>
    <li><strong>Cola:</strong> Larga y utilizada para equilibrio y defensa</li>
    <li><strong>Cabeza:</strong> Relativamente pequeña, con una mandíbula fuerte adaptada para comer vegetación baja</li>
</ul>

<h2>Alimentación</h2>
<p>El Zalmoxes era un <strong>herbívoro</strong>, alimentándose de vegetación baja, arbustos y helechos. Vivió en un ecosistema insular con pocos depredadores, lo que le permitió desarrollar una dieta basada en plantas disponibles en su entorno.</p>

<h2>Comportamiento</h2>
<p>Se cree que el Zalmoxes era un dinosaurio bastante ágil, debido a su cuerpo ligero. Probablemente vivía en grupos pequeños, ya que la vida en una isla pequeña ofrecía pocos recursos y muchos desafíos para la supervivencia.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios, el Zalmoxes se reproducía por medio de <strong>huevos</strong>, aunque no se tiene mucha información sobre cómo construía sus nidos o el cuidado que proporcionaba a sus crías.</p>

<h2>Descubrimiento</h2>
<p>El Zalmoxes fue descubierto a partir de restos fósiles hallados en Rumanía en la década de 1990. Su descubrimiento fue importante porque demostró que algunos dinosaurios herbívoros insulares desarrollaron características únicas debido a las limitaciones de su entorno.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Zalmoxes pertenece a la familia Rhabdodontidae, una familia de dinosaurios herbívoros que incluye a otros dinosaurios pequeños y ágiles como el <em>Rhabdodon</em>. A pesar de ser pequeño, su parentesco con otros dinosaurios herbívoros sugiere que vivió en un ambiente en el que competía con otras especies por recursos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Zalmoxes vivió en una isla, lo que influyó en su tamaño y en la forma en que evolucionó con respecto a otros dinosaurios del continente.</li>
    <li>Es uno de los pocos dinosaurios conocidos de la región de Hațeg, que era un ecosistema insular durante el Cretácico.</li>
    <li>Su tamaño pequeño y su agilidad le permitieron adaptarse a un entorno con recursos limitados y pocos depredadores.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
