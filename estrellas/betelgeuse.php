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
    <title>Estrella Betelgeuse - La Gigante Roja</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1> Betelgeuse: La Gigante Roja del Cielo</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Betelgeuse</h2>
        <p>
            Betelgeuse es una de las estrellas más conocidas y observadas del cielo, famosa por ser una gigante roja situada en la constelación de Orión. 
            Su nombre proviene del árabe <strong>"Ibt al-Jauzah"</strong>, que significa "el hombro de la gigante". Betelgeuse es una estrella en su fase final de vida,
            lo que la convierte en un objeto de gran interés para los astrónomos. Es una de las estrellas más brillantes del cielo, pero su brillo varía debido a su inestabilidad.
        </p>
        <!-- Imagen de Betelgeuse añadida justo debajo de la descripción -->
        <img src="https://hips.hearstapps.com/hmg-prod/images/betelgeuse-star-against-starry-sky-artistic-vision-royalty-free-image-1709935858.jpg" alt="Estrella Betelgeuse" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Alpha Orionis</li>
            <li><strong>Tipo espectral:</strong> M1-M2 (Gigante Roja)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 642.5 años luz (197 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 0.42</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 100,000 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 3,500 K</li>
            <li><strong>Radio:</strong> 887 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Muerte de Betelgeuse</h2>
        <p>
            Betelgeuse se encuentra en las últimas etapas de su vida. Como una gigante roja, su núcleo está agotando el hidrógeno, lo que provoca que su tamaño se expanda.
            Eventualmente, se convertirá en una supernova, una explosión estelar tan poderosa que podría ser visible desde la Tierra incluso de día. Este evento no ocurrirá
            inmediatamente, pero es un fenómeno fascinante para los astrónomos.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Betelgeuse ha sido una estrella importante para varias culturas a lo largo de la historia:
        </p>
        <ul>
            <li>
                <strong>Egipto:</strong> Los egipcios observaron a Betelgeuse como parte de la constelación de Orión, asociada con el dios Osiris y la muerte.
            </li>
            <li>
                <strong>Grecia:</strong> En la mitología griega, Orión era un cazador gigante, y Betelgeuse representaba su hombro.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Betelgeuse es una de las estrellas más grandes conocidas, con un tamaño que podría engullir a todo el sistema solar.</li>
            <li>Su brillo ha variado drásticamente en los últimos años, lo que ha llevado a especulaciones sobre una posible explosión de supernova.</li>
            <li>El nombre "Betelgeuse" es difícil de pronunciar, pero es uno de los nombres más conocidos de las estrellas en la astronomía popular.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
