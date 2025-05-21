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
    <title>Araucaria - Enciclopedia de Plantas</title>
    <link rel="stylesheet" href="../../../css/flor_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Araucaria</h1>

<a href="../../../img/Araucaria.jpg" target="_blank">
    <img src="../../../img/Araucaria.jpg" alt="Araucaria" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p>El nombre <strong>Araucaria</strong> proviene del "Araucano", una etnia nativa de Chile, donde esta planta es común. La palabra se utiliza para referirse tanto al género como a la familia de árboles que incluye especies como la Araucaria araucana.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Plantae</li>
    <li><strong>División:</strong> Coniferophyta</li>
    <li><strong>Clase:</strong> Pinopsida</li>
    <li><strong>Orden:</strong> Pinales</li>
    <li><strong>Familia:</strong> Araucariaceae</li>
    <li><strong>Género:</strong> Araucaria</li>
    <li><strong>Especies:</strong> Varias, incluyendo Araucaria araucana, Araucaria angustifolia, entre otras.</li>
</ul>

<h2>Periodo geológico</h2>
<p>Las especies de Araucaria existen desde hace más de <strong>200 millones de años</strong>, durante el <strong>Triásico</strong>, y son algunas de las coníferas más antiguas que aún existen.</p>

<h2>Distribución geográfica</h2>
<p>La Araucaria araucana, conocida comúnmente como el <strong>Pehuén</strong>, es originaria de Chile y Argentina. Otras especies de Araucaria se encuentran en Australia, Nueva Guinea y en diversas islas del Pacífico.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Altura:</strong> Pueden alcanzar hasta 60 metros de altura.</li>
    <li><strong>Hojas:</strong> Puntiagudas, rígidas y dispuestas en espiral, lo que les da una apariencia bastante distintiva.</li>
    <li><strong>Conos:</strong> Los conos de las Araucarias son grandes y leñosos, contienen las semillas comestibles que han sido aprovechadas por varias culturas indígenas.</li>
    <li><strong>Tronco:</strong> Recto y grueso, con una corteza gruesa y rugosa.</li>
</ul>

<h2>Alimentación</h2>
<p>Como todas las plantas, las araucarias realizan <strong>fotosíntesis</strong> para producir su propio alimento, aprovechando la luz solar, el dióxido de carbono y el agua.</p>

<h2>Comportamiento</h2>
<p>Las araucarias son plantas perennes, que crecen lentamente, pero pueden llegar a ser muy longevas, viviendo hasta más de 1,000 años. Son resistentes a climas fríos y de montaña.</p>

<h2>Reproducción</h2>
<p>Son <strong>plantas dioicas</strong>, lo que significa que existen árboles masculinos y femeninos. Los conos masculinos liberan polen que es transportado por el viento para fertilizar los conos femeninos, donde se desarrollan las semillas.</p>

<h2>Descubrimiento</h2>
<p>La Araucaria fue descrita científicamente en el siglo XVIII, aunque ya era conocida y aprovechada por las culturas indígenas de América del Sur, que usaban sus semillas comestibles como fuente de alimento.</p>

<h2>Relación con otras plantas</h2>
<p>Las Araucarias pertenecen al grupo de las <strong>coníferas</strong> y están estrechamente relacionadas con otras plantas de la familia Araucariaceae. Son parte del mismo linaje antiguo que las secuoyas y los pinos.</p>

<h2>Curiosidades</h2>
<ul>
    <li>La semilla de la Araucaria araucana es comestible y muy nutritiva, y se ha utilizado en la dieta de los pueblos originarios del sur de Chile y Argentina.</li>
    <li>La Araucaria araucana está considerada un árbol nacional de Chile, y su imagen se encuentra en el escudo de la región de La Araucanía.</li>
    <li>El tronco de la Araucaria tiene una corteza gruesa que la hace resistente al fuego.</li>
    <li>La madera de la Araucaria es valorada por su durabilidad y resistencia, y se usa en la construcción.</li>
</ul>

<footer>
    <p>Enciclopedia de Plantas - © 2025</p>
</footer>

</body>
</html>
