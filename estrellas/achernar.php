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
    <title>Estrella Achernar - La Estrella Brillante de Erídano</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Achernar: La Estrella Brillante de Erídano</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Achernar</h2>
        <p>
            Achernar es la estrella más brillante de la constelación de Erídano, y una de las estrellas más brillantes del cielo nocturno. Su nombre proviene del árabe <strong>"Aš-Šarnār"</strong>, que significa "el final del río". Achernar es una estrella muy caliente y masiva, que se encuentra a aproximadamente 139 años luz de la Tierra. A pesar de su brillo, su forma es bastante peculiar: Achernar es una estrella oblonga debido a su rápida rotación.
        </p>
        <!-- Imagen de Achernar añadida justo debajo de la descripción -->
        <img src="https://osr.org/wp-content/uploads/2016/03/achernar-star.jpg" alt="Estrella Canopus" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Alpha Eridani</li>
            <li><strong>Tipo espectral:</strong> B6 V (Enana Azul-Blanca)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 139 años luz (42.5 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 0.45</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 3,000 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 19,000 K</li>
            <li><strong>Radio:</strong> 7.5 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Forma y Rotación de Achernar</h2>
        <p>
            Achernar es una estrella rápida en rotación. Su periodo de rotación es tan corto que su forma es distorsionada: en lugar de ser esférica, es una esfera oblata. Esto significa que su diámetro ecuatorial es mucho mayor que el diámetro polar. Esta peculiaridad es común en las estrellas muy calientes y masivas, que experimentan grandes fuerzas centrífugas debido a su rotación.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Achernar ha tenido un lugar importante en las culturas antiguas, especialmente en la astronomía árabe:
        </p>
        <ul>
            <li>
                <strong>Mitología Griega:</strong> Achernar forma parte de la constelación de Erídano, que representa el río que fluye hacia el océano. En la mitología, Erídano estaba asociado con el mito de Phaethon y su caída al río después de perder el control del carro solar.
            </li>
            <li>
                <strong>Tradición Árabe:</strong> El nombre de Achernar proviene de la tradición árabe, en la que "Aš-Šarnār" hace referencia al "final del río", representando el extremo de la constelación de Erídano.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Achernar es una de las estrellas más calientes conocidas, con una temperatura superficial que supera los 19,000 K.</li>
            <li>A pesar de ser una estrella muy brillante, su forma alargada debido a su rotación rápida es algo único y no tan común en otras estrellas similares.</li>
            <li>Achernar es difícil de observar desde el hemisferio norte debido a su posición en el cielo, pero es una de las más prominentes en el hemisferio sur.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
