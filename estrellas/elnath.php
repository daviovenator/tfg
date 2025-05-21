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
    <title>Estrella Elnath - El Cuerno de Tauro</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Elnath: El Cuerno de Tauro</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Elnath</h2>
        <p>
            Elnath es una estrella brillante ubicada en la constelación de Tauro, conocida por ser una de las estrellas más luminosas de dicha constelación. Esta estrella se encuentra en la fase de gigante azul, lo que significa que es mucho más caliente y más luminosa que nuestro Sol. Elnath es una estrella importante para los astrónomos debido a su posición en el cielo y su relativa proximidad a la Tierra.
        </p>
        <!-- Imagen de Elnath añadida justo debajo de la descripción -->
        <img src="https://upload.wikimedia.org/wikipedia/it/f/fd/Elnath.jpg" alt="Estrella Elnath" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Beta Tauri</li>
            <li><strong>Tipo espectral:</strong> B7 III (Gigante Azul)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 134 años luz (41.1 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 1.65</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 260 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 13,000 K</li>
            <li><strong>Radio:</strong> 5.6 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Naturaleza de Elnath</h2>
        <p>
            Elnath es una gigante azul que se encuentra en una fase posterior de su evolución estelar. Es más masiva y caliente que el Sol, lo que le da un color azulado intenso. A pesar de ser una estrella luminosa, Elnath está en una fase transitoria, ya que se espera que en el futuro se convierta en una supergigante roja antes de terminar su vida como una estrella de tipo blanco. Su intensa luminosidad la convierte en una de las estrellas más brillantes de su constelación.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Elnath ha tenido un papel importante en varias culturas a lo largo de la historia:
        </p>
        <ul>
            <li>
                <strong>Mitología griega:</strong> En la mitología griega, Elnath formaba parte del cuerno del toro, que es representado en la constelación de Tauro. Esta constelación estaba asociada con el mito de Zeus y Europa.
            </li>
            <li>
                <strong>Cultura árabe:</strong> Los árabes se referían a Elnath como "Al Nath", que significa "el cuerno", debido a su ubicación en el toro de la constelación.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Elnath es una de las pocas estrellas que está cerca del límite entre las constelaciones de Tauro y Aries, lo que la hace una estrella de transición entre estas dos constelaciones.</li>
            <li>La estrella Elnath es utilizada como una de las guías para localizar otras estrellas y constelaciones en el cielo, especialmente durante las observaciones astronómicas.</li>
            <li>A pesar de ser una de las estrellas más brillantes en el cielo nocturno, Elnath no es tan conocida como otras estrellas debido a su ubicación más hacia el norte de la eclíptica.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
