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
    <title>Gallimimus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/hervivor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Gallimimus</h1>

<a href="../../../img/Gallimimus.jpg" target="_blank">
    <img src="../../../img/Gallimimus.jpg" alt="Gallimimus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Gallimimus</strong> proviene del latín "gallus" (gallo) y "mimus" (imitador), lo que se traduce como "imitador de gallo", debido a su aspecto y su comportamiento que recuerda al de las aves modernas, especialmente a los gallos.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Ornithomimidae</li>
    <li><strong>Género:</strong> Gallimimus</li>
    <li><strong>Especie:</strong> G. bullatus (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>El Gallimimus vivió durante el <strong>Cretácico Tardío</strong>, hace aproximadamente <strong>70 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles de Gallimimus en:
<ul>
    <li>Mongolia, en lo que hoy es el desierto de Gobi</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 6 metros</li>
    <li><strong>Peso:</strong> Alrededor de 440 kilogramos</li>
    <li><strong>Forma del cuerpo:</strong> Ligero y ágil, con largas patas traseras adaptadas para la carrera</li>
    <li><strong>Cabeza:</strong> Pequeña y ligera, con ojos grandes</li>
    <li><strong>Brazos:</strong> Relativamente cortos, con tres dedos en cada mano</li>
    <li><strong>Cola:</strong> Larga y flexible</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>omnivoro</strong>, y probablemente se alimentaba de una variedad de alimentos, incluyendo plantas, insectos y pequeños vertebrados. Su dieta era muy diversa debido a su agilidad para correr y encontrar diferentes tipos de comida.</p>

<h2>Comportamiento</h2>
<p>Se cree que el Gallimimus era un animal muy ágil y rápido, capaz de correr a grandes velocidades, similar a las aves modernas. Probablemente se desplazaba en grupos, y podría haber sido una presa fácil para depredadores grandes, pero su velocidad le proporcionaba una excelente defensa.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios, el Gallimimus se reproducía por <strong>huevos</strong>, que probablemente eran depositados en nidos en el suelo.</p>

<h2>Curiosidades</h2>
<ul>
    <li>A pesar de su apariencia de "gallina gigante", el Gallimimus era un dinosaurio carnívoro y omnivoro, que se desplazaba principalmente por correr.</li>
    <li>Su esqueleto liviano y su musculatura en las patas traseras le permitían alcanzar altas velocidades.</li>
    <li>El Gallimimus es uno de los dinosaurios más conocidos por su representación en la película *Jurassic Park*.</li>
    <li>Su comportamiento y forma de vida lo colocan dentro de los "dinosaurios de caza", aunque también puede haber practicado el forrajeo para alimentarse de plantas y pequeños animales.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
