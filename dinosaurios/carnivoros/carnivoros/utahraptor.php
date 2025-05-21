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
    <title>Utahraptor - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Utahraptor</h1>

<a href="../../../img/Utahraptor.jpg" target="_blank">
    <img src="../../../img/Utahraptor.jpg" alt="Utahraptor" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Utahraptor</strong> significa "ladrón de Utah", en referencia al estado estadounidense donde fue descubierto.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Dromaeosauridae</li>
    <li><strong>Género:</strong> Utahraptor</li>
    <li><strong>Especie:</strong> U. ostrommaysorum</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Cretácico Inferior</strong>, hace aproximadamente <strong>135 a 130 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus fósiles fueron encontrados en <strong>Utah, Estados Unidos</strong>, principalmente en la Formación Cedar Mountain.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 7 metros</li>
    <li><strong>Peso:</strong> Entre 500 y 1000 kg</li>
    <li><strong>Garras:</strong> Garras curvas y afiladas de hasta 25 cm en los pies</li>
    <li><strong>Cuerpo:</strong> Ágil y musculoso, adaptado para la caza activa</li>
    <li><strong>Plumas:</strong> Probablemente tenía plumas, al igual que otros dromeosáuridos</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>carnívoro</strong>, cazador activo de presas grandes. Posiblemente cazaba en grupos para derribar animales más grandes que él.</p>

<h2>Comportamiento</h2>
<p>Se cree que tenía un comportamiento social avanzado, con capacidades de caza en manada y comunicación efectiva.</p>

<h2>Reproducción</h2>
<p>Se reproducía mediante <strong>huevos</strong>. Es probable que construyera nidos y que algunas especies cercanas mostraran cierto cuidado parental.</p>

<h2>Descubrimiento</h2>
<p>Fue descubierto en 1991 en Utah y descrito oficialmente en 1993. Su hallazgo cambió las ideas sobre los dromeosáuridos al mostrar que podían ser grandes y robustos.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Utahraptor está emparentado con otros "raptores" como Velociraptor y Deinonychus, pero es considerablemente más grande.</p>

<h2>Importancia cultural</h2>
<p>A pesar de no ser tan famoso como el Velociraptor, ha ganado popularidad por su gran tamaño y aspecto intimidante. Ha aparecido en documentales y videojuegos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Es el dromeosáurido más grande conocido hasta ahora.</li>
    <li>Sus garras en forma de hoz eran mortales para sus presas.</li>
    <li>El descubrimiento coincidió con el rodaje de "Jurassic Park", que popularizó a los raptores.</li>
    <li>Su anatomía demuestra la transición entre dinosaurios y aves.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>

