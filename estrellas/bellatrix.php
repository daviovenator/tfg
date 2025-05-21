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
    <title>Estrella Bellatrix - La Estrella Guerrera de Orión</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Bellatrix: La Estrella Guerrera de Orión</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Bellatrix</h2>
        <p>
            Bellatrix es la tercera estrella más brillante de la constelación de Orión y una de las estrellas más brillantes del cielo nocturno. Su nombre proviene del latín <strong>"bellatrix"</strong>, que significa "guerrera". Esta estrella es una supergigante azul, lo que la hace mucho más masiva y caliente que el Sol. Se encuentra a aproximadamente 240 años luz de la Tierra y es una de las estrellas más masivas conocidas en la región de Orión.
        </p>
        <!-- Imagen de Bellatrix añadida justo debajo de la descripción -->
        <img src="data:image/jpeg;base64,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" alt="Estrella Canopus" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Gamma Orionis</li>
            <li><strong>Tipo espectral:</strong> B2 III (Supergigante Azul)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 240 años luz (73.5 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 1.64</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 10,000 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 22,000 K</li>
            <li><strong>Radio:</strong> 5 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Naturaleza de Bellatrix</h2>
        <p>
            Bellatrix es una supergigante azul, lo que significa que tiene una temperatura extremadamente alta y un brillo mucho mayor que el de estrellas como el Sol. Estas estrellas tienen una vida relativamente corta, quemando su combustible rápidamente, lo que eventualmente las lleva a explotar como supernovas. La enorme masa de Bellatrix también hace que esté en una fase avanzada de su vida, lo que la hace muy interesante para los astrónomos.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            A lo largo de la historia, Bellatrix ha tenido un lugar destacado en la astronomía y la mitología:
        </p>
        <ul>
            <li>
                <strong>Mitología Griega:</strong> En la mitología, Orión era un cazador gigante, y Bellatrix representaba una de las estrellas que se encontraban en su cinturón.
            </li>
            <li>
                <strong>Modernidad:</strong> El nombre "Bellatrix" también ha sido popularizado en la cultura moderna, especialmente en la literatura y en el cine, como un símbolo de poder y valentía.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Bellatrix es una de las estrellas más calientes que podemos observar a simple vista, con una temperatura superficial de alrededor de 22,000 K.</li>
            <li>Su brillo ha sido un fenómeno interesante para los astrónomos, ya que las supergigantes azules son propensas a cambios en su luminosidad.</li>
            <li>A pesar de ser una estrella muy brillante, Bellatrix no es tan conocida como otras estrellas de Orión, como Betelgeuse, aunque ocupa un lugar importante en la constelación.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
