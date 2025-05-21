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
    <title>Helicoprion - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Helicoprion</h1>

<a href="../../../img/Helicoprion.webp" target="_blank">
    <img src="../../../img/Helicoprion.webp" alt="Helicoprion" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Helicoprion</strong> significa "diente en espiral", en referencia a los distintivos dientes en espiral que caracterizan a este animal. El nombre proviene del griego "helix" (espiral) y "prion" (sierra).</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Chondrichthyes (peces cartilaginosos)</li>
    <li><strong>Orden:</strong> Helicoprionidae</li>
    <li><strong>Género:</strong> Helicoprion</li>
    <li><strong>Especie:</strong> H. bessonovi (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Permiano</strong>, hace aproximadamente <strong>290 a 250 millones de años</strong>, un periodo que precedió la extinción masiva del final del Permiano.</p>

<h2>Distribución geográfica</h2>
<p>Se han encontrado fósiles de Helicoprion en diversas regiones del mundo, tales como:
<ul>
    <li>Estados Unidos (principalmente en Idaho)</li>
    <li>Rusia</li>
    <li>Francia</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 4 a 5 metros</li>
    <li><strong>Forma del cuerpo:</strong> Cuerpo alargado, adaptado a la vida acuática</li>
    <li><strong>Dientes:</strong> Dientes en espiral característicos, ubicados en la parte inferior de la mandíbula, lo que le daba una apariencia única</li>
</ul>

<h2>Alimentación</h2>
<p>El Helicoprion era un <strong>carnívoro</strong>, y se cree que su alimentación consistía principalmente en peces pequeños y otros organismos marinos, aunque el uso de sus dientes en espiral para cazar es aún un tema de debate.</p>

<h2>Comportamiento</h2>
<p>Este animal marino es conocido por su extraña anatomía y el patrón único de sus dientes, lo que ha llevado a especulaciones sobre cómo utilizaba estos dientes. Algunos estudios sugieren que podría haberlos usado para cortar a sus presas en pedazos antes de tragarlas.</p>

<h2>Reproducción</h2>
<p>La información sobre su reproducción es limitada debido a la escasez de fósiles completos. Sin embargo, como la mayoría de los tiburones y peces cartilaginosos, es probable que el Helicoprion se haya reproducido por medio de <strong>parto vivo</strong>.</p>

<h2>Descubrimiento</h2>
<p>El Helicoprion fue descrito por primera vez en 1899, basándose en fragmentos de dientes encontrados en la región de Idaho, EE.UU. Su característico patrón dental lo hizo único en la paleontología, y desde entonces ha sido objeto de numerosos estudios.</p>

<h2>Relación con otros animales</h2>
<p>El Helicoprion pertenece a la clase de los peces cartilaginosos, relacionada con los tiburones modernos. Aunque no es un tiburón propiamente dicho, comparte varios rasgos con este grupo de animales.</p>

<h2>Importancia cultural</h2>
<p>Aunque el Helicoprion no es tan conocido como los grandes tiburones actuales, su peculiar morfología y los fósiles de sus dientes en espiral lo han convertido en un tema fascinante de estudio paleontológico y en un animal popular en documentales y libros sobre la prehistoria.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Los dientes en espiral de Helicoprion fueron su rasgo más distintivo, lo que lo convierte en uno de los animales más extraños de su época.</li>
    <li>El Helicoprion no es un tiburón verdadero, sino un pariente antiguo de este grupo.</li>
    <li>Los fósiles de Helicoprion han sido encontrados en varias partes del mundo, lo que indica que este animal tenía una distribución bastante amplia en los océanos prehistóricos.</li>
    <li>Los dientes de Helicoprion probablemente se renovaban periódicamente, como sucede en los tiburones modernos.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
