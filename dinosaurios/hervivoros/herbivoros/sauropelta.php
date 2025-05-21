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
    <title>Sauropelta - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Sauropelta</h1>

<a href="../../../img/Sauropelta.jpg" target="_blank">
    <img src="../../../img/Sauropelta.jpg" alt="Sauropelta" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Sauropelta</strong> proviene del griego "sauros" (lagarto) y "pelta" (escudo), lo que se traduce como "lagarto con escudo", debido a su cuerpo protegido por placas óseas y espinas.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ankylosauria</li>
    <li><strong>Familia:</strong> Nodosauridae</li>
    <li><strong>Género:</strong> Sauropelta</li>
    <li><strong>Especie:</strong> S. edwardsi (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Temprano</strong>, hace aproximadamente <strong>112 a 110 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles de Sauropelta en:
<ul>
    <li>América del Norte, principalmente en lo que hoy es Wyoming, Estados Unidos</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 4 a 5 metros</li>
    <li><strong>Peso:</strong> Alrededor de 1.5 toneladas</li>
    <li><strong>Forma del cuerpo:</strong> Bajo y robusto, con una gran cantidad de placas óseas en su espalda</li>
    <li><strong>Cola:</strong> Cortita y con un garfio óseo en la punta, usado probablemente como defensa</li>
    <li><strong>Defensas:</strong> Placas óseas y espinas en el cuerpo, utilizadas para protegerse de depredadores</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong>, alimentándose principalmente de plantas bajas como helechos y cícadas. Sus dientes eran adecuados para raspar plantas duras.</p>

<h2>Comportamiento</h2>
<p>Probablemente vivió en pequeños grupos o solitario. Su armadura de placas óseas era una defensa importante contra los depredadores de su tiempo, como los grandes carnívoros.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, el Sauropelta se reproducía por <strong>huevos</strong>, que probablemente eran depositados en nidos en el suelo.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Sauropelta es conocido por su armadura excepcional, que incluye placas óseas a lo largo de su espalda.</li>
    <li>Su garfio óseo en la cola probablemente le servía para defenderse de depredadores.</li>
    <li>Aunque no era tan grande como otros dinosaurios blindados, su armadura lo hacía un oponente formidable para los carnívoros.</li>
    <li>Este dinosaurio es un excelente ejemplo de cómo los herbívoros desarrollaron defensas naturales contra los depredadores.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
