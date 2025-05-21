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
    <title>Allosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Allosaurus</h1>

<a href="../../../img/allosaurus.webp" target="_blank">
    <img src="../../../img/allosaurus.webp" alt="Allosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Allosaurus</strong> proviene del griego "allos" (otro) y "sauros" (lagarto), lo que se traduce como "Otro lagarto". Fue nombrado por el paleontólogo Othniel Charles Marsh en 1877.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Allosauridae</li>
    <li><strong>Género:</strong> Allosaurus</li>
    <li><strong>Especie:</strong> A. fragilis</li>
</ul>

<h2>Periodo geológico</h2>
<p>El Allosaurus vivió durante el <strong>Jurásico Tardío</strong>, específicamente entre hace <strong>155 y 150 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Habitó lo que hoy es América del Norte y Europa. Sus fósiles han sido encontrados en:
<ul>
    <li>Utah (Estados Unidos)</li>
    <li>Colorado</li>
    <li>Montana</li>
    <li>Portugal</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 12 metros</li>
    <li><strong>Altura:</strong> 4 metros a la cadera</li>
    <li><strong>Peso:</strong> Aproximadamente 2-3 toneladas</li>
    <li><strong>Cráneo:</strong> Grande, con dientes afilados y curvados adaptados para cortar carne</li>
    <li><strong>Cola:</strong> Larga y flexible, utilizada para equilibrio</li>
    <li><strong>Brazos:</strong> Relativamente cortos pero fuertes, con tres dedos en cada mano</li>
</ul>

<h2>Alimentación</h2>
<p>El Allosaurus era un <strong>carnívoro</strong> que cazaba grandes dinosaurios herbívoros como el Stegosaurus y el Camptosaurus. Sus dientes y garras eran ideales para desgarrar carne.</p>

<h2>Comportamiento</h2>
<p>Se cree que el Allosaurus cazaba en grupos pequeños, aunque algunos estudios sugieren que también podría haber sido solitario. Tenía una gran agilidad y probablemente acechaba a sus presas antes de atacarlas.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios, el Allosaurus se reproducía por medio de <strong>huevos</strong>. Los nidos de Allosaurus no han sido encontrados, pero se cree que las hembras ponían sus huevos en áreas abiertas.</p>

<h2>Crecimiento y desarrollo</h2>
<p>El Allosaurus creció rápidamente, alcanzando su tamaño adulto en pocos años. Los jóvenes eran más ágiles y probablemente cazaban presas más pequeñas hasta llegar a su tamaño completo.</p>

<h2>Esperanza de vida</h2>
<p>Se estima que el Allosaurus vivía entre <strong>20 y 30 años</strong>.</p>

<h2>Descubrimiento</h2>
<p>El primer fósil de Allosaurus fue encontrado en 1877 por Othniel Charles Marsh en Wyoming, Estados Unidos. Desde entonces, se han encontrado numerosos fósiles, lo que ha permitido reconstruir muchas características de su biología.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Allosaurus pertenecía a la familia Allosauridae, y sus parientes cercanos incluyen a:
<ul>
    <li>Acrocanthosaurus</li>
    <li>Carcharodontosaurus</li>
    <li>Giganotosaurus</li>
</ul>
</p>

<h2>Extinción</h2>
<p>El Allosaurus desapareció hace unos 145 millones de años, probablemente debido a cambios ambientales y la competencia con otros dinosaurios más grandes, como el Brachiosaurus y el Saurophaganax.</p>

<h2>Importancia cultural</h2>
<p>El Allosaurus es uno de los dinosaurios más conocidos y ha aparecido en varios medios populares, incluidos libros, películas y documentales sobre dinosaurios.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Allosaurus fue uno de los primeros dinosaurios en ser descubierto y clasificado científicamente.</li>
    <li>Se cree que los Allosaurus podrían haber cazado en manadas, aunque esto sigue siendo un tema de debate.</li>
    <li>Su cráneo era tan grande que podía albergar un cerebro del tamaño de una naranja.</li>
    <li>Los restos de Allosaurus han sido encontrados junto a los restos de otras especies de dinosaurios, lo que sugiere que pudo haber sido un depredador dominante en su ecosistema.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
