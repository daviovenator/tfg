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
    <title>Estrella Mimosa - La Brillante de la Cruz del Sur</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Mimosa: La Brillante de la Cruz del Sur</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Mimosa</h2>
        <p>
            Mimosa, también conocida como Beta Crucis, es una de las estrellas más brillantes de la constelación de la Cruz del Sur. Su nombre proviene de la palabra latina "mimosa", que significa "tímida" o "delicada", aunque su brillo en el cielo es anything but tímido. Es una supergigante azul que se encuentra a unos 350 años luz de distancia de la Tierra y es una de las estrellas más observadas del hemisferio sur.
        </p>
        <!-- Imagen de Mimosa añadida justo debajo de la descripción -->
        <img src="https://www.star-facts.com/wp-content/uploads/2019/10/Regulus-Alpha-Leonis.webp" alt="Estrella Mimosa" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Beta Crucis</li>
            <li><strong>Tipo espectral:</strong> B0.5 III (Supergigante Azul)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 350 años luz (107 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 1.25</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 16,000 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 25,000 K</li>
            <li><strong>Radio:</strong> 12 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Evolución de Mimosa</h2>
        <p>
            Mimosa se encuentra en una etapa avanzada de su evolución estelar. Como una supergigante azul, esta estrella ha agotado su hidrógeno en el núcleo y está quemando elementos más pesados. Eventualmente, esta estrella explotará como una supernova, dejando tras de sí una estrella de neutrones o un agujero negro. A pesar de estar en una etapa de vida relativamente corta, su luminosidad la convierte en una de las estrellas más observables y estudiadas del cielo.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Mimosa ha sido una estrella importante en las culturas del hemisferio sur. Forma parte de la constelación de la Cruz del Sur, un símbolo culturalmente significativo para los pueblos de esa región:
        </p>
        <ul>
            <li>
                <strong>Aborígenes Australianos:</strong> Para los aborígenes australianos, la Cruz del Sur, y por lo tanto Mimosa, tenía una importante conexión espiritual y cultural. Era vista como un punto de orientación en el cielo.
            </li>
            <li>
                <strong>Cultura Europea:</strong> Aunque Mimosa no era tan conocida en el hemisferio norte, los navegantes europeos utilizaron la Cruz del Sur para orientarse durante sus viajes en el océano.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Es una de las estrellas más brillantes en el hemisferio sur, fácilmente visible en lugares como Australia y Sudamérica.</li>
            <li>Mimosa es parte de la famosa "Cruz del Sur", que es una de las constelaciones más conocidas y utilizadas para la navegación en el hemisferio sur.</li>
            <li>A pesar de su enorme luminosidad, Mimosa es una estrella de vida relativamente corta debido a su masa y su velocidad de consumo de combustible estelar.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
