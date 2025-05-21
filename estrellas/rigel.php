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
    <title>Estrella Rigel - La Supergigante Azul</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Rigel: La Supergigante Azul del Cielo</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Rigel</h2>
        <p>
            Rigel es una de las estrellas más brillantes del cielo nocturno y la más luminosa de la constelación de Orión. Se trata de una supergigante azul situada a aproximadamente 860 años luz de distancia de la Tierra. Su nombre proviene del árabe <strong>"Rijl Jauzah al Yusr"</strong>, que significa "pie de Orión". Rigel es una estrella masiva que se encuentra en una fase avanzada de su vida, y aunque es brillante, su vida será relativamente corta en comparación con las estrellas más pequeñas.
        </p>
        <!-- Imagen de Rigel añadida justo debajo de la descripción -->
        <img src="data:image/jpeg;base64,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" alt="Estrella Rigel" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Beta Orionis</li>
            <li><strong>Tipo espectral:</strong> B8 Ia (Supergigante Azul)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 860 años luz (264 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 0.12</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 120,000 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 11,000 K</li>
            <li><strong>Radio:</strong> 78 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Muerte de Rigel</h2>
        <p>
            Rigel es una estrella masiva que, al igual que otras supergigantes, se encuentra en las últimas etapas de su vida. Cuando agote su combustible nuclear, se convertirá en una supernova, una explosión estelar que será tan brillante que podría eclipsar temporalmente a toda su galaxia. Este evento marcará el final de su ciclo vital y la creación de elementos más pesados en el espacio.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Rigel ha sido observada y mencionada en diversas culturas a lo largo de la historia, especialmente en la cultura árabe, donde su nombre se refiere al pie de Orión, un cazador mitológico:
        </p>
        <ul>
            <li>
                <strong>Arabia:</strong> Los astrónomos árabes la conocían como "Rijl al Jauzah al Yusr", lo que significa "el pie derecho de Orión".
            </li>
            <li>
                <strong>Grecia:</strong> En la mitología griega, Orión era un cazador gigante, y Rigel representaba su pie izquierdo.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Rigel es una de las estrellas más brillantes del cielo y es más de 60,000 veces más luminosa que el Sol.</li>
            <li>Si Rigel estuviera en el lugar del Sol, su radio se extendería más allá de la órbita de Júpiter.</li>
            <li>Rigel se encuentra en una fase avanzada de su vida, lo que significa que su vida útil es mucho más corta que la de otras estrellas más pequeñas.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
