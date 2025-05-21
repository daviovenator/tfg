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
    <title>Spinosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Spinosaurus</h1>

<a href="../../../img/spinosaurus.webp" target="_blank">
    <img src="../../../img/spinosaurus.webp" alt="Spinosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Spinosaurus</strong> proviene del latín "spina" (espina) y "sauros" (lagarto), lo que se traduce como "Lagarto Espinoso". Fue nombrado por el paleontólogo Ernst Stromer en 1915.</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Spinosauridae</li>
    <li><strong>Género:</strong> Spinosaurus</li>
    <li><strong>Especie:</strong> S. aegypticus</li>
</ul>

<h2>Periodo geológico</h2>
<p>El Spinosaurus vivió durante el <strong>Cretácico Medio</strong>, específicamente entre hace <strong>112 y 93 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Habitó lo que hoy es África del Norte. Sus fósiles han sido encontrados en:
<ul>
    <li>Egipto</li>
    <li>Morocco</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 18 metros</li>
    <li><strong>Altura:</strong> Hasta 5.5 metros a la cadera</li>
    <li><strong>Peso:</strong> Aproximadamente 7-10 toneladas</li>
    <li><strong>Cráneo:</strong> Alargado, con una mandíbula llena de dientes cónicos, ideal para atrapar peces</li>
    <li><strong>Columna vertebral:</strong> Unas espinas largas y prominentes en su espalda que forman una vela o cresta</li>
    <li><strong>Extremidades:</strong> Relativamente cortas, con garras en las manos</li>
</ul>

<h2>Alimentación</h2>
<p>El Spinosaurus era un <strong>carnívoro piscívoro</strong>, es decir, se alimentaba principalmente de peces. Sus dientes y mandíbula alargada estaban adaptados para pescar, aunque también se cree que podía cazar presas terrestres más pequeñas.</p>

<h2>Comportamiento</h2>
<p>El Spinosaurus era un depredador semiacuático que probablemente pasaba mucho tiempo en el agua. Sus extremidades traseras eran fuertes, y sus brazos, aunque cortos, eran adecuados para capturar presas acuáticas. Se piensa que era un cazador muy ágil tanto en tierra como en el agua.</p>

<h2>Reproducción</h2>
<p>Como otros dinosaurios, el Spinosaurus se reproducía por medio de <strong>huevos</strong>. Aunque no se han encontrado nidos específicos de Spinosaurus, se cree que, al igual que otros dinosaurios terópodos, construía nidos en el suelo para incubar sus huevos.</p>

<h2>Crecimiento y desarrollo</h2>
<p>El Spinosaurus, al igual que otros grandes dinosaurios, crecía rápidamente durante su juventud. Sin embargo, su tamaño y fuerza lo hacían un depredador dominante solo cuando alcanzaba su tamaño adulto.</p>

<h2>Esperanza de vida</h2>
<p>Se estima que el Spinosaurus vivía entre <strong>20 y 30 años</strong>, aunque la falta de evidencia directa sobre la longevidad exacta hace que esta cifra sea solo una estimación.</p>

<h2>Descubrimiento</h2>
<p>El Spinosaurus fue descubierto por Ernst Stromer en 1912 en Egipto. Sin embargo, los fósiles originales fueron destruidos durante la Segunda Guerra Mundial, lo que retrasó la investigación sobre este dinosaurio hasta la década de 1990, cuando se encontraron nuevos restos.</p>

<h2>Relación con otros dinosaurios</h2>
<p>El Spinosaurus pertenece a la familia Spinosauridae, y sus parientes cercanos incluyen a:
<ul>
    <li>Baryonyx</li>
    <li>Suchomimus</li>
</ul>
Estos dinosaurios comparten características similares, como una alimentación piscívora y una morfología adaptada para la vida acuática.</p>

<h2>Extinción</h2>
<p>El Spinosaurus desapareció hace aproximadamente <strong>93 millones de años</strong>, probablemente debido a cambios en el clima, la disminución de fuentes de alimento, o la competencia con otros depredadores.</p>

<h2>Importancia cultural</h2>
<p>El Spinosaurus es uno de los dinosaurios más conocidos, especialmente por su aparición en la película <em>Jurassic Park III</em>. Su aspecto único, con la vela en su espalda, lo ha convertido en uno de los dinosaurios más fascinantes para el público.</p>

<h2>Curiosidades</h2>
<ul>
    <li>El Spinosaurus fue uno de los dinosaurios más grandes que jamás haya existido, incluso más grande que el Tyrannosaurus rex.</li>
    <li>Su cresta en la espalda probablemente tenía un propósito para la comunicación visual o para regular la temperatura corporal.</li>
    <li>Se cree que el Spinosaurus podría haber nadado, gracias a su morfología adaptada para el agua.</li>
    <li>Algunos estudios sugieren que el Spinosaurus podía caminar tanto sobre sus dos patas traseras como en cuatro patas, lo que lo convierte en uno de los dinosaurios más versátiles en cuanto a locomoción.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
