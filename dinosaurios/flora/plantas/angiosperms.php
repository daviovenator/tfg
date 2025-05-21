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
    <title>Angiosperms - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Angiosperms</h1>

<a href="../../../img/Angiosperms.jpg" target="_blank">
    <img src="../../../img/Angiosperms.jpg" alt="Angiosperms" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Angiosperms</strong> proviene del griego "angeion" (caja) y "sperma" (semilla), haciendo referencia a las plantas que tienen semillas encerradas en un ovario, lo que las distingue de las gimnospermas.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Angiospermae</li>
    <li><strong>Clase:</strong> Magnoliopsida (dicotiledóneas) o Liliopsida (monocotiledóneas)</li>
    <li><strong>Orden:</strong> Varía dependiendo de la especie</li>
    <li><strong>Familia:</strong> Varía dependiendo de la especie</li>
</ul>

<h2>Periodo geológico</h2>
<p>Las Angiospermas aparecieron en el Cretácico, hace aproximadamente 140 millones de años. Desde entonces, se han diversificado enormemente y son la clase de plantas más dominante en la actualidad.</p>

<h2>Distribución geográfica</h2>
<p>Las Angiospermas están distribuidas por todo el planeta, desde zonas tropicales hasta regiones templadas, y son fundamentales para la vida de muchos ecosistemas, especialmente en bosques, praderas y áreas de cultivos.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Flores:</strong> Son las únicas plantas que tienen flores, estructuras reproductivas complejas que facilitan la polinización por insectos, aves o el viento.</li>
    <li><strong>Semillas:</strong> Sus semillas están protegidas dentro de una estructura denominada fruto, que se desarrolla a partir del ovario de la flor.</li>
    <li><strong>Variedad de formas:</strong> Las Angiospermas presentan una enorme diversidad de tamaños, desde diminutas hierbas hasta grandes árboles.</li>
</ul>

<h2>Alimentación</h2>
<p>Las Angiospermas, al igual que todas las plantas, son autótrofas, lo que significa que realizan fotosíntesis para producir su propio alimento utilizando luz solar, dióxido de carbono y agua.</p>

<h2>Comportamiento</h2>
<p>Estas plantas son fundamentales para los ecosistemas, ya que proporcionan alimento y oxígeno a otros organismos, además de ser la base de muchas cadenas alimenticias. También son importantes para la estabilización del suelo y el ciclo del agua.</p>

<h2>Reproducción</h2>
<p>Las Angiospermas se reproducen a través de flores, que contienen estructuras reproductivas tanto masculinas como femeninas. La polinización puede ser llevada a cabo por insectos, el viento o incluso aves. Tras la polinización, las flores se desarrollan en frutos que contienen las semillas.</p>

<h2>Descubrimiento</h2>
<p>El concepto de Angiosperma fue establecido en el siglo XIX por botánicos como Johann Friedrich Blumenbach. Desde entonces, las investigaciones sobre estas plantas han sido fundamentales para la comprensión de la biodiversidad vegetal.</p>

<h2>Relación con otras plantas</h2>
<p>Las Angiospermas están emparentadas con las gimnospermas, pero se distinguen por su sistema de reproducción floral y su capacidad para producir frutos. Son el grupo de plantas más diverso y evolucionado en la actualidad.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Las Angiospermas representan más del 80% de todas las plantas conocidas, lo que incluye árboles, arbustos, hierbas y flores.</li>
    <li>Se cree que la aparición de las Angiospermas fue clave en la diversificación de muchos grupos de animales, incluidos insectos, aves y mamíferos.</li>
    <li>Los frutos de las Angiospermas no solo sirven para proteger las semillas, sino que también ayudan a dispersarlas de manera eficiente, lo que contribuye a la propagación de la planta.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
