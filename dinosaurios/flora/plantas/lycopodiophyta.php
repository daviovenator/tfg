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
    <title>Lycopodiophyta - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Lycopodiophyta</h1>

<a href="../../../img/Lycopodiophyta(Lycopodios).jpg" target="_blank">
    <img src="../../../img/Lycopodiophyta(Lycopodios).jpg" alt="Lycopodiophyta" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Lycopodiophyta</strong> es un filo de plantas vasculares que incluye musgos y helechos primitivos. Su nombre proviene del griego "lykos" (lobo) y "podion" (pie), lo que hace referencia a la forma de sus esporas, que se asemejan a huellas de lobo.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>Filo:</strong> Lycopodiophyta</li>
    <li><strong>Clase:</strong> Lycopodiopsida</li>
    <li><strong>Orden:</strong> Lycopodiales</li>
    <li><strong>Familia:</strong> Lycopodiaceae</li>
    <li><strong>Género:</strong> Lycopodium</li>
    <li><strong>Especie:</strong> Lycopodium clavatum</li>
</ul>

<h2>Periodo geológico</h2>
<p>Las plantas de Lycopodiophyta tienen un registro fósil que se remonta al <strong>Devónico</strong>, hace más de <strong>400 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Se encuentran principalmente en regiones templadas y tropicales, creciendo en bosques húmedos y suelos ricos en materia orgánica.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Altura:</strong> Generalmente de 30 cm a 1 metro, aunque algunas especies pueden alcanzar hasta 2 metros.</li>
    <li><strong>Hojas:</strong> Son pequeñas, escamosas y organizadas en espirales.</li>
    <li><strong>Raíz:</strong> Su sistema radicular es bastante primitivo, sin raíces verdaderas, pero con estructuras similares a las raíces.</li>
    <li><strong>Reproducción:</strong> A través de esporas, producidas en conos o esporangios.</li>
</ul>

<h2>Alimentación</h2>
<p>Las Lycopodiophyta son <strong>plantas autotróficas</strong>, lo que significa que producen su propio alimento a través de la fotosíntesis, utilizando la luz solar, el dióxido de carbono y el agua.</p>

<h2>Comportamiento</h2>
<p>Estas plantas no tienen un "comportamiento" como los animales, pero pueden ajustarse a su entorno cambiando su tasa de crecimiento según las condiciones ambientales.</p>

<h2>Reproducción</h2>
<p>Se reproducen mediante esporas, que se liberan cuando el esporangio madura. Estas esporas pueden germinar y crecer en nuevas plantas bajo condiciones adecuadas.</p>

<h2>Descubrimiento</h2>
<p>Las Lycopodiophyta fueron conocidas desde la antigüedad, pero fue durante el siglo XVIII cuando los botánicos comenzaron a clasificarlas como un grupo distinto de plantas vasculares.</p>

<h2>Relación con otras plantas</h2>
<p>Las Lycopodiophyta están relacionadas con los helechos y las plantas con semilla, pero se distinguen por su falta de semillas y por tener esporas en lugar de flores.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Algunas especies de Lycopodiophyta, como <em>Lycopodium clavatum</em>, fueron utilizadas históricamente en medicina tradicional y como material inflamable en la industria de pirotecnia.</li>
    <li>Las esporas de Lycopodium pueden ser altamente inflamables, lo que las hacía útiles para efectos especiales en películas antiguas.</li>
    <li>Estas plantas tienen una longeva historia evolutiva, representando uno de los grupos más antiguos de plantas vasculares existentes hoy.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
