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
    <title>Estrella Capella - La Doble Estrella de la Constelación de Aries</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Capella: La Doble Estrella de la Constelación de Aries</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Capella</h2>
        <p>
            Capella es una de las estrellas más brillantes en el cielo nocturno, ubicada en la constelación de Aries. Es un sistema estelar binario compuesto por dos estrellas gigantes, una de tipo G y otra de tipo K. Capella es conocida por ser una de las estrellas más cercanas a la Tierra, y su nombre proviene del latín <strong>"Capella"</strong>, que significa "la pequeña cabra", haciendo referencia a su asociación con la mitología de la cabra Amalthaea, que alimentó al dios griego Zeus.
        </p>
        <!-- Imagen de Capella añadida justo debajo de la descripción -->
        <img src="https://theplanets.org/123/2022/03/The-Capella-Star.jpg" alt="Estrella Capella" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Alpha Aurigae</li>
            <li><strong>Tipo espectral:</strong> G1 III y G8 III (Gigantes Amarillas)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 42.2 años luz (12.9 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 0.08</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 78 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 5,700 K (para la estrella principal)</li>
            <li><strong>Radio:</strong> 9.8 veces el del Sol (para la estrella principal)</li>
        </ul>
    </section>

    <section>
        <h2>La Naturaleza de Capella</h2>
        <p>
            Capella es un sistema estelar binario compuesto por dos estrellas gigantes, conocidas como Capella A y Capella B. Ambas son similares en tamaño y luminosidad, aunque Capella A es ligeramente más caliente y masiva que Capella B. Este sistema es uno de los más cercanos a la Tierra entre las estrellas más brillantes, lo que lo hace fácilmente visible a simple vista. Se cree que las dos estrellas de Capella están en una fase avanzada de su vida y eventualmente se convertirán en enanas blancas.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            Capella ha tenido un gran significado en varias culturas a lo largo de la historia:
        </p>
        <ul>
            <li>
                <strong>Grecia:</strong> En la mitología griega, Capella está asociada con la cabra Amalthaea, que amamantó al joven Zeus. La estrella representaba la cabra y se consideraba un símbolo de fertilidad y generosidad.
            </li>
            <li>
                <strong>Roma:</strong> En la antigua Roma, Capella se consideraba una de las estrellas más importantes, utilizada por los navegantes para orientarse en el mar Mediterráneo.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Capella es uno de los sistemas estelares binarios más cercanos a la Tierra, lo que la convierte en una de las estrellas más brillantes y fácilmente visibles.</li>
            <li>Su nombre "Capella" significa "la pequeña cabra" y se refiere a la cabra mítica que amamantó al dios Zeus en la mitología griega.</li>
            <li>La estrella principal de Capella (A) es una gigante amarilla, mientras que la compañera (B) es de tipo espectral G8 III.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
