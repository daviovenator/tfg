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
    <title>Estrella Saiph - La Estrella del Pie de Orión</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Saiph: La Estrella del Pie de Orión</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Saiph</h2>
        <p>
            Saiph es una estrella ubicada en la constelación de Orión, situada en el pie derecho del cazador mitológico. Su nombre proviene del árabe <strong>"Sa'if"</strong>, que significa "la espada", aunque también puede interpretarse como "el pie". Saiph es una supergigante azul que forma parte de las estrellas más brillantes de Orión, aunque su brillo es ligeramente más débil que el de las otras estrellas principales como Betelgeuse y Rigel. Junto con otras estrellas de la constelación, Saiph ha sido importante tanto para los astrónomos como para las culturas que han observado el cielo nocturno.
        </p>
        <!-- Imagen de Saiph añadida justo debajo de la descripción -->
        <img src="data:image/jpeg;base64,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" alt="Estrella Saiph" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Kappa Orionis</li>
            <li><strong>Tipo espectral:</strong> B0.5 Iab (Supergigante Azul)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 720 años luz (220 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 2.07</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 18,000 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 22,000 K</li>
            <li><strong>Radio:</strong> 30 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Evolución de Saiph</h2>
        <p>
            Saiph es una estrella masiva en las etapas finales de su vida. Como una supergigante azul, está en la fase en la que su núcleo ha agotado el hidrógeno y está fusionando helio. En un futuro relativamente cercano, se espera que Saiph se convierta en una supernova, una explosión estelar tan brillante que podría rivalizar con la luminosidad de toda una galaxia. Este evento marcaría el final de la vida de Saiph, dejando detrás un remanente como una estrella de neutrones o incluso un agujero negro.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Al igual que otras estrellas prominentes de la constelación de Orión, Saiph ha tenido un lugar importante en diversas culturas:
        </p>
        <ul>
            <li>
                <strong>Mitología Griega:</strong> En la mitología, Orión era un cazador gigante, y Saiph, ubicada en su pie, formaba parte de la representación de su figura. La constelación de Orión ha sido observada desde la antigüedad como un símbolo de fuerza y valentía.
            </li>
            <li>
                <strong>Tradiciones Árabes:</strong> En la astronomía árabe, las estrellas de Orión, incluida Saiph, fueron muy significativas, siendo usadas para la navegación y la observación astronómica.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Saiph, a pesar de ser una estrella masiva, no es tan conocida como otras estrellas de Orión como Betelgeuse o Rigel, aunque sigue siendo una de las estrellas más brillantes del cielo.</li>
            <li>Es una de las supergigantes azules más cercanas a la Tierra, lo que la convierte en un importante objeto de estudio en la astronomía.</li>
            <li>El hecho de que Saiph forme parte de la figura mitológica de Orión la hace aún más fascinante dentro de las tradiciones de muchas culturas que han observado la constelación.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
