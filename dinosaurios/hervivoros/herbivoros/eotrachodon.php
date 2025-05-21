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
    <title>Eotrachodon - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Eotrachodon</h1>

<a href="../../../img/Eotrachodon.webp" target="_blank">
    <img src="../../../img/Eotrachodon.webp" alt="Eotrachodon" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Eotrachodon</strong> proviene del griego "eos" (amanecer) y "trachodon" (dientes rugosos), lo que significa "dientes rugosos del amanecer", refiriéndose a sus características dentales y su posición temprana en la evolución de los hadrosaurios.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Suborden:</strong> Cerapoda</li>
    <li><strong>Familia:</strong> Hadrosauridae</li>
    <li><strong>Género:</strong> Eotrachodon</li>
    <li><strong>Especie:</strong> E. orientalis</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Inferior</strong>, hace aproximadamente <strong>80 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se ha encontrado en lo que hoy es América del Norte, específicamente en el estado de Georgia, Estados Unidos.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 7 metros</li>
    <li><strong>Peso:</strong> Alrededor de 1.5 toneladas</li>
    <li><strong>Postura:</strong> Cuadrúpeda, pero probablemente también podía caminar en dos patas ocasionalmente.</li>
    <li><strong>Características distintivas:</strong> Como otros hadrosaurios, tenía una dentadura especializada en triturar vegetación y una postura adaptada para el consumo de plantas de bajo crecimiento.</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong>, y se alimentaba de una gran variedad de plantas, incluyendo helechos y coníferas que dominaban el paisaje del Cretácico Inferior.</p>

<h2>Comportamiento</h2>
<p>Vivía en grandes manadas, lo que le permitía protegerse de depredadores. Su tamaño y los rasgos típicos de los hadrosaurios sugieren que también podía correr a buena velocidad cuando se sentía amenazado.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios herbívoros de su época, el Eotrachodon probablemente se reproducía por <strong>huevos</strong> en nidos construidos por las hembras.</p>

<h2>Descubrimiento</h2>
<p>Fue descubierto en 2009 en Georgia, Estados Unidos, y fue descrito en 2011. Este dinosaurio es uno de los primeros hadrosaurios conocidos en Norteamérica, y su descubrimiento proporcionó información clave sobre la evolución temprana de los hadrosaurios.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Eotrachodon pertenece a la familia Hadrosauridae, y está relacionado con otros dinosaurios de esta familia, como el <em>Parasaurolophus</em> y el <em>Lambeosaurus</em>. Los hadrosaurios son conocidos por sus dentaduras especializadas para triturar plantas y su postura bípeda o cuadrúpeda.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Eotrachodon es uno de los primeros ejemplos de hadrosaurios encontrados en América del Norte, lo que ofrece una visión más clara de la evolución temprana de esta familia.</li>
    <li>La dentadura del Eotrachodon era muy especializada para una dieta herbívora, lo que le permitía alimentarse de una variedad de plantas disponibles en su ecosistema.</li>
    <li>Este dinosaurio es una pieza clave para entender el desarrollo de los hadrosaurios antes de la aparición de especies más conocidas como el <em>Edmontosaurus</em>.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
