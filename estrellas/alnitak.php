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
    <title>Estrella Alnitak - La Estrella de la Cintura de Orión</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Alnitak: La Estrella de la Cintura de Orión</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Alnitak</h2>
        <p>
            Alnitak es una estrella brillante situada en la constelación de Orión, específicamente en la Cintura de Orión, que es uno de los objetos más reconocidos en el cielo nocturno. Su nombre proviene del árabe <strong>"an-niṭāq"</strong>, que significa "el cinturón". Alnitak es una estrella gigante azul y es la estrella más brillante de la Cintura de Orión, junto con Alnilam y Mintaka, que forman el famoso "cinturón" de esta constelación.
        </p>
        <!-- Imagen de Alnitak añadida justo debajo de la descripción -->
        <img src="https://www.orionsarm.com/im_store/alnitak.jpg" alt="Estrella Alnitak" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Zeta Orionis</li>
            <li><strong>Tipo espectral:</strong> O9.5 Iab (Gigante Azul)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 800 años luz (250 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 1.74</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 100,000 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 29,000 K</li>
            <li><strong>Radio:</strong> 20 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Evolución de Alnitak</h2>
        <p>
            Alnitak es una estrella masiva que se encuentra en las últimas etapas de su vida como una supergigante azul. Está agotando su hidrógeno en el núcleo y, eventualmente, se convertirá en una supernova, un fenómeno explosivo que liberará enormes cantidades de energía. Después de esta explosión, se espera que la estrella termine su vida como una estrella de neutrones o incluso como un agujero negro. Este proceso es un ejemplo de cómo las estrellas masivas pueden transformar la materia y la energía en eventos espectaculares.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Alnitak ha sido una estrella notablemente importante tanto para los astrónomos como para las culturas a lo largo de la historia:
        </p>
        <ul>
            <li>
                <strong>Mitología Griega:</strong> Alnitak, al igual que las otras estrellas del cinturón de Orión, ha sido asociada con el mítico cazador Orión. La constelación de Orión ha tenido una gran importancia en muchas culturas, representando tanto la figura de un cazador como un símbolo de fuerza y valentía.
            </li>
            <li>
                <strong>Cultura Islámica:</strong> En la astronomía islámica, Orión y sus estrellas, como Alnitak, eran muy importantes para la navegación y el estudio del cielo.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Alnitak es parte del sistema estelar triple, donde la estrella principal es una gigante azul y tiene dos compañeras más pequeñas.</li>
            <li>Junto con Alnilam y Mintaka, Alnitak forma el "cinturón" de Orión, una de las formaciones más fácilmente reconocibles en el cielo.</li>
            <li>Alnitak es tan brillante que su luz puede verse a simple vista incluso desde áreas con contaminación lumínica moderada.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
