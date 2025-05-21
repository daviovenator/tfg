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
    <title>Estrella Proxima Centauri - La Estrella Más Cercana</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Proxima Centauri: La Estrella Más Cercana al Sistema Solar</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Proxima Centauri</h2>
        <p>
            Proxima Centauri es la estrella más cercana al Sistema Solar, situada a tan solo 4.24 años luz de distancia. Es una enana roja de baja luminosidad, lo que hace que no sea visible a simple vista. Aunque es muy cercana, su débil brillo la hace difícil de observar desde la Tierra. Proxima Centauri forma parte del sistema estelar Alfa Centauri, que también incluye a Alfa Centauri A y Alfa Centauri B. Su proximidad y características la convierten en un objeto de gran interés para los astrónomos.
        </p>
        <!-- Imagen de Proxima Centauri añadida justo debajo de la descripción -->
        <img src="https://e00-elmundo.uecdn.es/assets/multimedia/imagenes/2021/05/06/16202957287046.jpg" alt="Estrella Proxima Centauri" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>
    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Proxima Centauri (Alpha Centauri C)</li>
            <li><strong>Tipo espectral:</strong> M5.5Ve (Enana Roja)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 4.24 años luz (1.30 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 11.05 (no visible a simple vista)</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 0.0017 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 3,050 K</li>
            <li><strong>Radio:</strong> 0.14 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Posibilidad de Vida en Proxima Centauri b</h2>
        <p>
            Proxima Centauri es conocida por albergar un exoplaneta, Proxima Centauri b, que se encuentra en la zona habitable de la estrella. Este planeta tiene condiciones que podrían permitir la existencia de agua líquida, un factor crucial para la vida tal como la conocemos. A pesar de su cercanía, la existencia de vida en Proxima Centauri b sigue siendo incierta, y los astrónomos continúan investigando las condiciones del planeta.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Proxima Centauri ha sido objeto de interés en la astronomía moderna debido a su proximidad al Sistema Solar. Aunque no tiene la misma fama que otras estrellas brillantes, su proximidad hace que sea un objetivo principal para futuros proyectos de exploración espacial:
        </p>
        <ul>
            <li>
                <strong>Observaciones modernas:</strong> A lo largo de los años, Proxima Centauri ha sido objeto de numerosos estudios, especialmente con la intención de descubrir más sobre sus planetas y características.
            </li>
            <li>
                <strong>Exploración futura:</strong> Dado su cercanía, Proxima Centauri ha sido considerada como un objetivo potencial para misiones espaciales en el futuro.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Proxima Centauri es la estrella más cercana a la Tierra, pero es tan débil que no puede ser vista a simple vista.</li>
            <li>El exoplaneta Proxima Centauri b es uno de los más estudiados debido a su ubicación en la zona habitable de la estrella.</li>
            <li>Proxima Centauri es una de las muchas enanas rojas que existen en nuestra galaxia, pero su cercanía la hace especialmente interesante para los astrónomos.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
