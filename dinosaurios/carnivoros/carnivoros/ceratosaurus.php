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
    <title>Ceratosaurus - Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="../../../css/dinosaur_style.css">
</head>
<body>

<a href="javascript:history.back()" class="volver-btn">← Volver</a>

<h1>Ceratosaurus</h1>

<a href="../../../img/ceratosaurus.jpg" target="_blank">
    <img src="../../../img/ceratosaurus.jpg" alt="Ceratosaurus" width="600" class="imagen-destacada">
</a>

<h2>¿Qué significa su nombre?</h2>
<p><strong>Ceratosaurus</strong> significa "lagarto con cuerno", en referencia al prominente cuerno en su hocico. El nombre proviene del griego "keras" (cuerno) y "sauros" (lagarto).</p>

<h2>Clasificación científica</h2>
<ul>
    <li><strong>Reino:</strong> Animalia</li>
    <li><strong>Filo:</strong> Chordata</li>
    <li><strong>Clase:</strong> Reptilia</li>
    <li><strong>Orden:</strong> Saurischia</li>
    <li><strong>Suborden:</strong> Theropoda</li>
    <li><strong>Familia:</strong> Ceratosauridae</li>
    <li><strong>Género:</strong> Ceratosaurus</li>
    <li><strong>Especie:</strong> C. nasicornis (especie tipo)</li>
</ul>

<h2>Periodo geológico</h2>
<p>Vivió durante el <strong>Jurásico Tardío</strong>, hace aproximadamente <strong>153 a 148 millones de años</strong>.</p>

<h2>Distribución geográfica</h2>
<p>Sus restos se han encontrado en:
<ul>
    <li>Estados Unidos (Utah, Colorado, Wyoming)</li>
    <li>Portugal</li>
</ul>
</p>

<h2>Características físicas</h2>
<ul>
    <li><strong>Longitud:</strong> Hasta 6-7 metros</li>
    <li><strong>Peso:</strong> Entre 1 y 2 toneladas</li>
    <li><strong>Distintivo:</strong> Cuerno nasal prominente y placas óseas a lo largo del cuerpo</li>
    <li><strong>Brazos:</strong> Relativamente cortos con dedos ganchudos</li>
</ul>

<h2>Alimentación</h2>
<p>Era un <strong>carnívoro</strong> que probablemente cazaba dinosaurios más pequeños, cocodrilos primitivos y posiblemente peces, gracias a su estructura esbelta y adaptada al movimiento ágil.</p>

<h2>Comportamiento</h2>
<p>Se cree que era un cazador solitario. Su cuerno pudo haber sido usado en exhibiciones visuales o combates entre machos.</p>

<h2>Reproducción</h2>
<p>Como todos los dinosaurios, se reproducía por <strong>huevos</strong>. Los detalles específicos sobre su reproducción son escasos debido a la falta de nidos fósiles asociados.</p>

<h2>Descubrimiento</h2>
<p>Fue descrito por el paleontólogo Othniel Charles Marsh en 1884 a partir de restos hallados en la Formación Morrison, EE.UU.</p>

<h2>Relación con otros dinosaurios</h2>
<p>Pertenece a la familia Ceratosauridae, un grupo primitivo de terópodos que coexistieron con dinosaurios más avanzados como Allosaurus.</p>

<h2>Importancia cultural</h2>
<p>Aunque menos famoso que el T. rex o Velociraptor, Ceratosaurus ha aparecido en películas, libros y videojuegos, destacándose por su aspecto distintivo.</p>

<h2>Curiosidades</h2>
<ul>
    <li>Su cola era muy larga y flexible, lo que le ayudaba a mantener el equilibrio.</li>
    <li>Los dientes eran afilados y curvados hacia atrás, ideales para desgarrar carne.</li>
    <li>Su cuerno no estaba relacionado con la defensa, sino posiblemente con el cortejo.</li>
    <li>Compartía hábitat con Allosaurus y Stegosaurus.</li>
</ul>

<footer>
    <p>Enciclopedia de Dinosaurios - © 2025</p>
</footer>

</body>
</html>
