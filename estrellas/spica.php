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
    <title>Estrella Spica - La Joya de Virgo</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Spica: La Joya Brillante de Virgo</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Spica</h2>
        <p>
            Spica es la estrella más brillante de la constelación de Virgo y una de las estrellas más luminosas del cielo nocturno. Con una magnitud aparente de 0.98, es fácilmente visible a simple vista. Spica es una estrella binaria, compuesta por dos estrellas masivas, una de ellas una gigante azul extremadamente caliente. Spica se encuentra a unos 260 años luz de la Tierra.
        </p>
        <!-- Imagen de Spica añadida justo debajo de la descripción -->
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJUOiUuQiZ1piC1ULgplfRfZ8ZDLsy-dWsUw&s" alt="Estrella Spica" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Alpha Virginis</li>
            <li><strong>Tipo espectral:</strong> B1 III (Gigante Azul)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 260 años luz (80 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 0.98</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 2,500 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 22,400 K</li>
            <li><strong>Radio:</strong> 7.5 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Naturaleza de Spica</h2>
        <p>
            Spica es una estrella binaria, lo que significa que está compuesta por dos estrellas que orbitan entre sí. La estrella primaria es una gigante azul caliente, mucho más grande y más masiva que el Sol. La segunda estrella, aunque también masiva, es de menor tamaño y masa en comparación con la primaria. Esta característica hace que Spica sea un sistema estelar fascinante de estudiar para los astrónomos.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Spica ha sido una estrella importante en diversas culturas a lo largo de la historia:
        </p>
        <ul>
            <li>
                <strong>Mitología Griega:</strong> En la mitología griega, Spica representa la espiga de trigo de la diosa Virgo, simbolizando la abundancia y la cosecha. Era una estrella central para los antiguos astrónomos griegos.
            </li>
            <li>
                <strong>Antiguo Egipto:</strong> Los egipcios también reconocieron a Spica como una estrella significativa, utilizándola para la planificación agrícola, ya que su salida y puesta era clave en la predicción de las estaciones.
            </li>
            <li>
                <strong>Arabia:</strong> El nombre "Spica" proviene del latín, pero en árabe la estrella era conocida como "Al-Shaʽbā", lo que hace referencia a su prominente posición en la constelación de Virgo.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Spica es una de las estrellas más calientes que se pueden observar a simple vista, con temperaturas que superan los 22,000 K.</li>
            <li>Es una estrella binaria, lo que significa que es el sistema estelar de dos estrellas que se encuentran en órbita mutua, un fenómeno relativamente raro.</li>
            <li>Su alto brillo la convierte en una de las estrellas más observadas y estudiadas por los astrónomos para entender las estrellas masivas y su evolución.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
