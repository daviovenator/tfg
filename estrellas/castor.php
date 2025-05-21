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
    <title>Estrella Castor - La Estrella Gemela de Géminis</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Castor: La Estrella Gemela de Géminis</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Castor</h2>
        <p>
            Castor es una de las estrellas más brillantes de la constelación de Géminis, y, junto con Pollux, forma uno de los pares de estrellas más conocidos en el cielo. Aunque a simple vista ambas parecen estar muy cerca, en realidad Castor es un sistema estelar múltiple compuesto por al menos seis estrellas en tres sistemas binarios. Su nombre proviene de la mitología griega, donde Castor era uno de los gemelos, hijo de Zeus, y hermano de Pollux.
        </p>
        <!-- Imagen de Castor añadida justo debajo de la descripción -->
        <img src="https://storage.googleapis.com/theskylive-static/website/sky/stars/star-images/28/2891_800.jpg" alt="Estrella Castor" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Alpha Geminorum</li>
            <li><strong>Tipo espectral:</strong> A1 V (Subgigante Azul-Blanco)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 52 años luz (16 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 1.58</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 50 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 9,200 K</li>
            <li><strong>Radio:</strong> 2.5 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Naturaleza de Castor</h2>
        <p>
            Castor es un sistema estelar múltiple que consta de al menos seis estrellas, agrupadas en tres sistemas binarios. La estrella más brillante de este sistema es una subgigante de tipo espectral A1, lo que significa que es una estrella relativamente joven en comparación con nuestro Sol. A diferencia de Pollux, Castor no está en la fase de gigante roja, sino que es una estrella aún activa en la secuencia principal. Su luminosidad y temperatura la hacen una estrella mucho más caliente y más azul que su compañero Pollux.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Al igual que Pollux, Castor tiene un gran significado en la mitología griega:
        </p>
        <ul>
            <li>
                <strong>Mitología Griega:</strong> Castor era el hermano gemelo de Pollux. Juntos formaban el par de gemelos conocidos como "Los Gemelos de Géminis". Según la mitología, cuando Castor murió, Pollux pidió a Zeus compartir su inmortalidad, lo que llevó a ambos gemelos a ser transformados en las dos estrellas brillantes de la constelación de Géminis.
            </li>
            <li>
                <strong>Roma:</strong> En la cultura romana, Castor y Pollux eran venerados como protectores de los marineros y de las batallas, conocidos como los "Dioses Gemelos". Esta idea también se reflejó en la astrología, donde Géminis era asociado con la dualidad y los gemelos.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Castor es un sistema estelar compuesto por seis estrellas, lo que lo convierte en un sistema mucho más complejo de lo que parece a simple vista.</li>
            <li>Aunque Castor y Pollux parecen estar muy cerca en el cielo, Castor está mucho más lejos de la Tierra que Pollux.</li>
            <li>La estrella más brillante del sistema Castor es una subgigante que es mucho más caliente que el Sol, con una temperatura superficial de aproximadamente 9,200 K.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
