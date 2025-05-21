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
    <title>Triceratops - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Triceratops</h1>

<a href="../../../img/Triceratops.jpg" target="_blank">
    <img src="../../../img/Triceratops.jpg" alt="Triceratops" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Triceratops</strong> significa “cara con tres cuernos”, en referencia a los dos grandes cuernos sobre los ojos y uno más pequeño en el hocico.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Suborden:</strong> Marginocephalia</li>
    <li><strong>Familia:</strong> Ceratopsidae</li>
    <li><strong>Género:</strong> Triceratops</li>
    <li><strong>Especie:</strong> T. horridus (principal especie)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Tardío</strong>, hace aproximadamente <strong>68 a 66 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles se han hallado principalmente en:
<ul>
    <li>Montana</li>
    <li>Wyoming</li>
    <li>Dakota del Sur</li>
    <li>Colorado</li>
    <li>Alberta (Canadá)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 9 metros</li>
    <li><strong>Peso:</strong> Hasta 12 toneladas</li>
    <li><strong>Cabeza:</strong> Enorme, con una gola ósea que protegía el cuello</li>
    <li><strong>Cuernos:</strong> Dos sobre los ojos de hasta 1 metro, y uno más pequeño sobre la nariz</li>
    <li><strong>Dientes:</strong> Formaba baterías dentales para triturar vegetación</li>
    <li><strong>Cuadrúpedo:</strong> Caminaba sobre sus cuatro patas robustas</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong> que se alimentaba de palmas, helechos y plantas coníferas. Su pico en forma de loro le ayudaba a cortar vegetación dura.</p>

<h2>Comportamiento</h2>
<p>Se cree que vivía en manadas, lo que ofrecía protección frente a depredadores como el Tyrannosaurus rex. Podría haber usado sus cuernos en combate entre machos o para defenderse.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, el Triceratops se reproducía mediante <strong>huevos</strong>. Las crías nacían de huevos depositados en nidos construidos en tierra.</p>

<h2>Curiosidades</h2>
<ul>
    <li>La gola pudo haber sido utilizada para la exhibición, regulación térmica o defensa.</li>
    <li>Era uno de los últimos dinosaurios no avianos antes de la extinción masiva.</li>
    <li>Su cráneo era uno de los más grandes del reino animal terrestre, con más de 2 metros de largo.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
