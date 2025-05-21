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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estrella Formalhaut - La Estrella Solitaria de Piscis Austrinus</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Formalhaut: La Estrella Solitaria de Piscis Austrinus</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Formalhaut</h2>
        <p>
            Formalhaut es una de las estrellas más brillantes en el cielo nocturno y se encuentra en la constelación de Piscis Austrinus. Su nombre proviene del árabe <strong>"Fomalhaut"</strong>, que significa "el que está en la boca del pez", haciendo referencia a su posición en la constelación. Formalhaut es una estrella joven y activa, y ha capturado el interés de los astrónomos por su posible sistema planetario. 
        </p>
        <!-- Imagen de Formalhaut añadida justo debajo de la descripción -->
        <img src="https://cdn.britannica.com/37/159937-050-4A567E18/Fomalhaut-emission-dust-belt-Herschel-European-Space.jpg" alt="Estrella Formalhaut" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Alpha Piscis Austrini</li>
            <li><strong>Tipo espectral:</strong> A3 V (Subgigante Blanco-azul)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 25 años luz (7.7 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 1.16</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 16 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 7,500 K</li>
            <li><strong>Radio:</strong> 1.8 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>El Sistema Planetario de Formalhaut</h2>
        <p>
            Formalhaut es conocida no solo por su brillo, sino también por su sistema planetario. En 2008, el telescopio espacial Hubble capturó una imagen de un exoplaneta que orbita alrededor de Formalhaut. Este planeta, llamado Formalhaut b, es uno de los exoplanetas más fascinantes, ya que se encuentra en una órbita relativamente amplia alrededor de su estrella, lo que lo hace fácil de observar. Este descubrimiento ha sido importante para estudiar los sistemas planetarios y cómo se forman los planetas en otras estrellas.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Formalhaut ha sido una estrella de importancia tanto para astrónomos como para diversas culturas:
        </p>
        <ul>
            <li>
                <strong>Antigua Grecia:</strong> En la mitología griega, Formalhaut se asocia con el pez que lleva el agua, en referencia a la constelación de Piscis Austrinus.
            </li>
            <li>
                <strong>Arabia:</strong> Su nombre árabe, "Fomalhaut", hace referencia a su posición en la "boca del pez", una forma en que los astrónomos árabes representaban la constelación de Piscis Austrinus.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Formalhaut es una de las estrellas más brillantes del hemisferio sur, visible sin telescopio en muchas partes del mundo.</li>
            <li>El exoplaneta Formalhaut b, descubierto en 2008, fue uno de los primeros planetas en ser capturados en una imagen directa.</li>
            <li>Formalhaut es una estrella relativamente joven y activa, y se espera que evolucione hacia una gigante en los próximos miles de millones de años.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
