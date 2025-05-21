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
    <title>Velociraptor - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Velociraptor</h1>

<a href="../../../img/Velociraptor.webp" target="_blank">
    <img src="../../../img/Velociraptor.webp" alt="Velociraptor" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Velociraptor</strong> proviene del latín "velocis" (rápido) y "raptor" (ladrón o saqueador), lo que se traduce como "Ladrón Rápido". Fue nombrado por el paleontólogo Henry Fairfield Osborn en 1924.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Dromaeosauridae</li>
    <li><strong>Género:</strong> Velociraptor</li>
    <li><strong>Especie:</strong> V. mongoliensis</li>
</ul>

<h2>Periodo geológico</h2>
<p>El Velociraptor vivió durante el <strong>Cretácico Superior</strong>, específicamente entre hace <strong>75 y 71 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>El Velociraptor habitó lo que hoy es Asia. Sus fósiles han sido encontrados principalmente en:
<ul>
    <li>Mongolia</li>
    <li>China</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Aproximadamente 2 metros</li>
    <li><strong>Altura:</strong> 0.5 metros a la cadera</li>
    <li><strong>Peso:</strong> Aproximadamente 15 kilogramos</li>
    <li><strong>Cráneo:</strong> Relativamente pequeño, con una mandíbula llena de dientes afilados y curvados</li>
    <li><strong>Garras:</strong> Tenía una garra retráctil en cada pie que usaba para atrapar y desmembrar presas</li>
    <li><strong>Cuerpo:</strong> Ágil y ligero, lo que le permitía moverse rápidamente</li>
</ul>

<h2>Alimentación</h2>
<p>El Velociraptor era un <strong>carnívoro</strong> que probablemente cazaba en manadas. Se cree que se alimentaba de dinosaurios más pequeños, como Protoceratops, o de animales que caían en sus trampas. Su agilidad y rapidez lo hacían un cazador eficiente.</p>

<h2>Comportamiento</h2>
<p>Se considera que el Velociraptor cazaba en grupo, utilizando tácticas de caza coordinadas para capturar presas mucho más grandes que ellos. Su alta inteligencia y agilidad lo convertían en un depredador muy peligroso, especialmente en manada.</p>

<h2>Reproducción</h2>
<p>El Velociraptor se reproducía por medio de <strong>huevos</strong>. Aunque no se han encontrado nidos específicamente de Velociraptor, los hallazgos de nidos de otros dinosaurios dromaeosáuridos sugieren que los Velociraptor también construían nidos en el suelo.</p>

<h2>Crecimiento y desarrollo</h2>
<p>El Velociraptor crecía rápidamente durante su juventud, alcanzando su tamaño adulto en unos pocos años. Su cuerpo ágil y musculoso le permitía moverse rápidamente y cazar eficazmente.</p>

<h2>Esperanza de vida</h2>
<p>Se estima que el Velociraptor vivía entre <strong>10 y 15 años</strong>, aunque la falta de evidencia directa sobre la longevidad exacta de estos dinosaurios hace que esta cifra sea solo una estimación.</p>

<h2>Descubrimiento</h2>
<p>El primer fósil de Velociraptor fue descubierto en 1923 en el desierto de Gobi, Mongolia, por una expedición del Museo Americano de Historia Natural. Desde entonces, se han encontrado más fósiles de este dinosaurio, lo que ha ayudado a reconstruir su imagen.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Velociraptor pertenece a la familia Dromaeosauridae, y sus parientes cercanos incluyen a:
<ul>
    <li>Dromaeosaurus</li>
    <li>Utahraptor</li>
</ul>
Estos dinosaurios comparten características como las garras retráctiles en sus pies y su agilidad en la caza.</p>

<h2>Extinción</h2>
<p>El Velociraptor se extinguió hace unos <strong>71 millones de años</strong> al final del Cretácico Superior, probablemente debido a cambios ambientales o a la competencia con otros depredadores más grandes.</p>

<h2>Importancia cultural</h2>
<p>El Velociraptor se hizo extremadamente popular gracias a su aparición en la película <em>Jurassic Park</em>, donde es retratado como uno de los dinosaurios más inteligentes y aterradores. Su imagen ha quedado grabada en la cultura popular como el símbolo de la rapidez y la astucia.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Velociraptor es conocido por su garras retráctiles, que usaba para cazar y capturar a sus presas.</li>
    <li>El tamaño real del Velociraptor era mucho menor que el mostrado en las películas, donde se le presenta mucho más grande y más intimidante.</li>
    <li>Se cree que el Velociraptor tenía plumas, lo que lo hace uno de los dinosaurios terópodos más cercanos a las aves modernas.</li>
    <li>Los estudios han demostrado que el Velociraptor tenía un cerebro relativamente grande en comparación con su tamaño corporal, lo que sugiere una alta inteligencia.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
