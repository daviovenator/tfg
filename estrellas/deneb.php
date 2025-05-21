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
    <title>Estrella Deneb - La Estrella Alfa de la Constelación de Cygnus</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Deneb: La Estrella Alfa de la Constelación de Cygnus</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Deneb</h2>
        <p>
            Deneb es la estrella más brillante de la constelación de Cygnus, también conocida como el Cisne. Se encuentra a unos 1,425 años luz de la Tierra y es una supergigante blanca. Junto con Altair y Vega, forma el famoso Triángulo del Verano. Deneb es una de las estrellas más luminosas del cielo nocturno y marca la cola del Cisne en la constelación. Es una estrella masiva que ha agotado su suministro de hidrógeno y está en las últimas fases de su vida.
        </p>
        <!-- Imagen de Deneb añadida justo debajo de la descripción -->
        <img src="https://www.star-facts.com/wp-content/uploads/2019/09/Deneb-Alpha-Cygni.webp" alt="Estrella Deneb" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Alpha Cygni</li>
            <li><strong>Tipo espectral:</strong> A2Ia (Supergigante Blanca)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 1,425 años luz (437 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 1.25</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 196,000 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 8,500 K</li>
            <li><strong>Radio:</strong> 203 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Naturaleza de Deneb</h2>
        <p>
            Deneb es una supergigante blanca que está en las últimas fases de su vida. Debido a su gran tamaño y alta luminosidad, esta estrella es mucho más masiva que nuestro Sol. En su núcleo, Deneb está agotando su suministro de hidrógeno y se encuentra en un proceso de expansión y enfriamiento, lo que la convierte en una estrella en una fase avanzada de su evolución. Eventualmente, se convertirá en una supernova y dejará una remanente estelar, como una estrella de neutrones o un agujero negro.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Deneb ha sido una estrella significativa en muchas culturas a lo largo de la historia:
        </p>
        <ul>
            <li>
                <strong>China:</strong> En la mitología china, Deneb es conocida como la "Tejedora", una figura importante en la leyenda del "Tejedor y el Pastor", que simboliza el amor y la separación.</li>
            <li>
                <strong>Occidente:</strong> En la tradición occidental, Deneb ha sido parte del Triángulo del Verano junto con Vega y Altair. Esta formación triangular ha sido una guía celestial para los navegantes y observadores del cielo.</li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Deneb es una de las estrellas más luminosas conocidas, con una luminosidad 196,000 veces mayor que la del Sol.</li>
            <li>La estrella forma parte del Triángulo del Verano, un asterismo visible durante los meses de verano en el hemisferio norte.</li>
            <li>Se cree que Deneb está perdiendo masa rápidamente debido a vientos estelares muy fuertes, lo que la lleva a su fase de supergigante.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
