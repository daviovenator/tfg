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
    <title>Estrella Mirfak - La Estrella Principal de Perseo</title>
    <link rel="stylesheet" href="../css/estrellasinfo_style.css">
</head>
<body>
    <header>
        <h1>Mirfak: La Estrella Principal de Perseo</h1>
        <a href="../estrellas.php">🔙 Volver</a>
    </header>

    <section>
        <h2>Información General de Mirfak</h2>
        <p>
            Mirfak, también conocida como Alpha Persei, es la estrella más brillante de la constelación de Perseo. Su nombre proviene del árabe <strong>"Al-Mirfaq"</strong>, que significa "el codo" o "el codo del brazo". Mirfak es una gigante amarilla ubicada a unos 590 años luz de la Tierra, y su brillo la convierte en una de las estrellas más destacadas del cielo en su constelación. Se encuentra en una etapa avanzada de su evolución estelar.
        </p>
        <!-- Imagen de Mirfak añadida justo debajo de la descripción -->
        <img src="https://www.star-facts.com/wp-content/uploads/2020/12/Kochab.webp" alt="Estrella Mirfak" style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); margin-top: 20px;">
    </section>

    <section>
        <h2>Características Astronómicas</h2>
        <ul>
            <li><strong>Nombre científico:</strong> Alpha Persei</li>
            <li><strong>Tipo espectral:</strong> F5 Ib (Gigante Amarilla)</li>
            <li><strong>Distancia desde la Tierra:</strong> Aproximadamente 590 años luz (180 pársecs)</li>
            <li><strong>Magnitud aparente:</strong> 1.79</li>
            <li><strong>Luminosidad:</strong> Aproximadamente 700 veces la del Sol</li>
            <li><strong>Temperatura superficial:</strong> 6,200 K</li>
            <li><strong>Radio:</strong> 14 veces el del Sol</li>
        </ul>
    </section>

    <section>
        <h2>La Evolución de Mirfak</h2>
        <p>
            Mirfak es una estrella masiva que se encuentra en una etapa avanzada de su vida. Aunque todavía está en la fase de gigante amarilla, eventualmente agotará su suministro de hidrógeno en el núcleo, lo que provocará que su tamaño se expanda aún más. Al igual que otras estrellas de este tipo, es probable que en el futuro termine como una enana blanca tras pasar por una fase de supernova. Este proceso no ocurrirá por miles de millones de años, pero es fascinante para los astrónomos observar su evolución.
        </p>
    </section>

    <section>
        <h2>Historia y Cultura</h2>
        <p>
            A lo largo de la historia, Mirfak ha sido importante para varias culturas, especialmente en la astronomía árabe:
        </p>
        <ul>
            <li>
                <strong>Mitología Griega:</strong> Aunque no hay una conexión directa con un mito griego específico, Mirfak es parte de la constelación de Perseo, el héroe mitológico que luchó contra Medusa y rescató a Andrómeda.
            </li>
            <li>
                <strong>Tradición Árabe:</strong> En la tradición árabe, el nombre de la estrella, "Al-Mirfaq", se refiere al "codo", haciendo referencia a la parte del brazo de Perseo en su representación en el cielo.
            </li>
        </ul>
    </section>

    <section>
        <h2>Curiosidades Fascinantes</h2>
        <ul>
            <li>Mirfak es la estrella más brillante de la constelación de Perseo, aunque su brillo puede ser opacado por otras estrellas cercanas cuando se observan desde la Tierra.</li>
            <li>Es una estrella relativamente cercana a la Tierra, lo que la convierte en un objeto interesante para los estudios de estrellas masivas y su evolución.</li>
            <li>El sistema estelar al que pertenece Mirfak está compuesto por múltiples estrellas, algunas de las cuales son visibles a simple vista.</li>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
