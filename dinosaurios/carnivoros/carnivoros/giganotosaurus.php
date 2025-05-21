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
    <title>Giganotosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Giganotosaurus</h1>

<a href="../../../img/giganotosaurus.jpg" target="_blank">
    <img src="../../../img/giganotosaurus.jpg" alt="Giganotosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Giganotosaurus</strong> proviene del griego "gigantes" (gigante) y "nosos" (lagarto), lo que se traduce como "lagarto gigante". Este nombre hace referencia a su gran tamaño, siendo uno de los dinosaurios carnívoros más grandes conocidos.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Carcharodontosauridae</li>
    <li><strong>Género:</strong> Giganotosaurus</li>
    <li><strong>Especie:</strong> G. carolinii</li>
</ul>

<h2>Periodo geológico</h2>
<p>El Giganotosaurus vivió durante el <strong>Cretácico Temprano</strong>, específicamente hace unos <strong>112 a 93 millones de años</strong>, en lo que hoy es Sudamérica, particularmente en lo que es actualmente Argentina.</p>

<h2>Distribución geográfica</h2>
<p>Este dinosaurio habitó lo que hoy es el sur de América del Sur, en las actuales regiones de Argentina, donde se han encontrado varios restos fósiles que permiten estudiar su biología y comportamiento.</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 12 a 13 metros</li>
    <li><strong>Altura:</strong> 4 metros a la cadera</li>
    <li><strong>Peso:</strong> Aproximadamente 8 toneladas</li>
    <li><strong>Cráneo:</strong> Grande, con dientes afilados y de gran tamaño adaptados para cortar carne</li>
    <li><strong>Brazos:</strong> Cortos, pero poderosos, con tres dedos, ideales para sujetar a sus presas</li>
    <li><strong>Cuerpo:</strong> Esbelto, adaptado para la caza rápida y ágil de grandes presas</li>
</ul>

<h2>Alimentación</h2>
<p>El Giganotosaurus era un <strong>carnívoro</strong> que cazaba grandes dinosaurios herbívoros, como los sauropodos. Su tamaño y fuerza le permitían capturar presas muy grandes, y su poderosa mandíbula estaba diseñada para desgarrar carne.</p>

<h2>Comportamiento</h2>
<p>Este dinosaurio era probablemente un cazador activo que podía haber cazado en grupos, como se sugiere en algunos estudios. Sin embargo, también se ha planteado la posibilidad de que pudiera ser un carroñero cuando las circunstancias lo permitían. Gracias a su tamaño y velocidad, era uno de los principales depredadores de su época.</p>

<h2>Reproducción</h2>
<p>El Giganotosaurus se reproducía mediante <strong>huevos</strong>, como todos los dinosaurios terópodos. Aunque no se han encontrado nidos de Giganotosaurus, se piensa que los jóvenes nacían en una etapa avanzada y probablemente dependían de sus padres durante los primeros años de vida.</p>

<h2>Crecimiento y desarrollo</h2>
<p>El Giganotosaurus crecía rápidamente en su juventud, alcanzando una gran masa corporal durante los primeros años de vida. Se estima que alcanzaba la madurez sexual en torno a los 10 a 15 años de edad, lo que era relativamente temprano para un dinosaurio de su tamaño.</p>

<h2>Esperanza de vida</h2>
<p>Se calcula que el Giganotosaurus vivía alrededor de <strong>20 a 30 años</strong>, aunque la evidencia directa sobre su longevidad es limitada. Como otros grandes depredadores, probablemente vivió una vida activa y llena de desafíos.</p>

<h2>Descubrimiento</h2>
<p>El Giganotosaurus fue descubierto en 1993 por el paleontólogo Rubén Carolini en la región de Patagonia, Argentina. El primer esqueleto encontrado permitió identificarlo como uno de los depredadores más grandes de la era Mesozoica.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Giganotosaurus pertenecía a la familia Carcharodontosauridae, y sus parientes cercanos incluyen a:
<ul>
    <li>Carcharodontosaurus</li>
    <li>Mapusaurus</li>
    <li>Allosaurus</li>
</ul>
Todos estos dinosaurios comparten características como dientes afilados y un cuerpo esbelto adaptado para cazar grandes presas.</p>

<h2>Extinción</h2>
<p>El Giganotosaurus desapareció hace aproximadamente <strong>93 millones de años</strong>, a medida que el clima y los ecosistemas cambiaron, lo que provocó la desaparición de muchos grandes depredadores como él.</p>

<h2>Importancia cultural</h2>
<p>El Giganotosaurus ha aparecido en varios documentales y libros sobre dinosaurios, y es considerado uno de los depredadores más impresionantes de la era Mesozoica. Su gran tamaño y su poder lo convierten en un símbolo de la caza y la depredación durante el Cretácico.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Giganotosaurus es uno de los dinosaurios más grandes de Sudamérica, superado solo por el Spinosaurus y el Carcharodontosaurus.</li>
    <li>Se estima que el Giganotosaurus podía correr a una velocidad de hasta 50 km/h, lo que le permitía perseguir a presas rápidas.</li>
    <li>Sus dientes eran largos, afilados y diseñados para desgarrar carne, similar a los de un tiburón.</li>
    <li>El descubrimiento de varios fósiles ha ayudado a reconstruir el aspecto de este dinosaurio, permitiendo que los paleontólogos estudien sus comportamientos y características.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
