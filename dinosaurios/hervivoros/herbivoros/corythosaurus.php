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
    <title>Corythosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Corythosaurus</h1>

<a href="../../../img/Corythosaurus.webp" target="_blank">
    <img src="../../../img/Corythosaurus.webp" alt="Corythosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Corythosaurus</strong> significa "lagarto con casco", debido a su característico casco óseo en la cabeza, que se asemeja al de un casco griego antiguo.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ornithischia</li>
    <li><strong>Familia:</strong> Hadrosauridae</li>
    <li><strong>Género:</strong> Corythosaurus</li>
    <li><strong>Especie:</strong> C. casuarius (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Temprano</strong>, hace aproximadamente <strong>75 a 72 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles de Corythosaurus en:
<ul>
    <li>Canadá (Alberta)</li>
    <li>Estados Unidos (Montana)</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 9 metros</li>
    <li><strong>Peso:</strong> Alrededor de 2.5 toneladas</li>
    <li><strong>Cabeza:</strong> Con un casco óseo en forma de cresta que podría haber tenido una función en la comunicación y/o selección sexual</li>
    <li><strong>Cuerpo:</strong> Grande, con un cuerpo robusto y patas traseras fuertes para caminar a bipedalismo</li>
    <li><strong>Cola:</strong> Larga y rígida, utilizada para equilibrio</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong>, que se alimentaba principalmente de plantas de baja altura como helechos, cícadas y coníferas. Su pico especializado le permitía cortar y masticar vegetación.</p>

<h2>Comportamiento</h2>
<p>Probablemente vivió en manadas y se desplazaba en grupos para protegerse de los depredadores. Su cresta podría haber sido utilizada para emitir sonidos, lo que sugiere que tenía un comportamiento social complejo.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, el Corythosaurus se reproducía por <strong>huevos</strong>, que eran depositados en nidos construidos en el suelo.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El casco óseo de su cabeza probablemente era utilizado para producir sonidos que podían ser escuchados a larga distancia.</li>
    <li>Su cresta era una de las más elaboradas entre los dinosaurios hadrosauridos.</li>
    <li>Se cree que el Corythosaurus formaba grandes manadas para protegerse de los depredadores como el Tyrannosaurus rex.</li>
    <li>Es uno de los hadrosaurios más reconocidos por su impresionante cresta.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
