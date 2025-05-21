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
    <title>Nodosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Nodosaurus</h1>

<a href="../../../img/nodosaurus.jpg" target="_blank">
    <img src="../../../img/nodosaurus.jpg" alt="Nodosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Nodosaurus</strong> proviene del griego "nodus" (nudo) y "sauros" (lagarto), lo que significa "lagarto nodoso", debido a las protuberancias óseas que cubren su cuerpo.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Ankylosauria</li>
    <li><strong>Familia:</strong> Nodosauridae</li>
    <li><strong>Género:</strong> Nodosaurus</li>
    <li><strong>Especie:</strong> N. textilis</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Inferior</strong>, hace aproximadamente <strong>100 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se ha encontrado en lo que hoy es América del Norte, específicamente en lo que actualmente es Canadá y los Estados Unidos.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 6 metros</li>
    <li><strong>Peso:</strong> Aproximadamente 2-3 toneladas</li>
    <li><strong>Postura:</strong> Cuadrúpeda, adaptado para desplazarse a baja velocidad.</li>
    <li><strong>Características distintivas:</strong> Su cuerpo estaba cubierto de placas óseas y espinas, con una cola masiva con una maza ósea al final, lo que lo hacía un excelente defensor contra los depredadores.</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>herbívoro</strong>, y se alimentaba de vegetación baja, como helechos y coníferas, usando sus dientes y mandíbulas adaptadas para cortar y triturar plantas.</p>

<h2>Comportamiento</h2>
<p>El Nodosaurus era probablemente un animal solitario o que vivía en pequeños grupos, desplazándose lentamente por su entorno y utilizando sus placas óseas y su cola con maza para defenderse de los depredadores.</p>

<h2>Reproducción</h2>
<p>Al igual que otros dinosaurios herbívoros, el Nodosaurus se reproducía por <strong>huevos</strong>, que las hembras depositaban en nidos construidos en el suelo.</p>

<h2>Descubrimiento</h2>
<p>El primer fósil de Nodosaurus fue descubierto en 1851 por el paleontólogo Othniel Charles Marsh, quien fue uno de los principales responsables de la era de descubrimientos de dinosaurios en América del Norte.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Nodosaurus pertenece a la familia Nodosauridae, una familia de dinosaurios blindados relacionados con el <em>Euoplocephalus</em> y el <em>Polacanthus</em>, conocidos por sus placas óseas y espinas.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Nodosaurus es uno de los primeros dinosaurios armados descubiertos y es clave para entender la evolución de los dinosaurios blindados.</li>
    <li>Su cola con maza ósea era un arma poderosa que utilizaba para defenderse de los depredadores.</li>
    <li>El Nodosaurus vivía en ambientes boscosos y pantanosos, lo que le proporcionaba la vegetación necesaria para su alimentación.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
