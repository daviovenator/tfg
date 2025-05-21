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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>La Galaxia del Sombrero - Todo sobre esta fascinante galaxia</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>La Galaxia del Sombrero (M104)</h1>
        <p>Explora una de las galaxias más fascinantes del universo: La Galaxia del Sombrero.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>

    <section id="informacion">
        <h2>¿Qué es la Galaxia del Sombrero?</h2>
        <p>La Galaxia del Sombrero, también conocida como Messier 104 (M104), es una galaxia espiral ubicada en la constelación de Virgo. Es famosa por su forma distintiva, que se asemeja a un sombrero de copa debido a su brillante núcleo y el disco de polvo que lo rodea.</p>
        <p>Está situada a unos 28 millones de años luz de la Tierra y tiene un diámetro de aproximadamente 50,000 años luz. La galaxia del Sombrero se encuentra entre las más brillantes del cúmulo de galaxias de Virgo y es una de las galaxias más estudiadas debido a su estructura única.</p>

        <img src="../img/galaxias/sombrero.jpg" alt="Imagen de la Galaxia del Sombrero">

        <div class="highlight">
            <p>La Galaxia del Sombrero tiene un núcleo brillante rodeado por un disco de polvo oscuro que forma su característico aspecto de sombrero.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Características de la Galaxia del Sombrero</h3>
                <p>La Galaxia del Sombrero es una galaxia espiral con un núcleo central extremadamente brillante. El disco de gas y polvo que rodea el núcleo es lo que le da su apariencia de sombrero. Esta galaxia alberga un agujero negro supermasivo en su centro, lo que es común en muchas galaxias grandes.</p>
                <p>Además, la Galaxia del Sombrero es una de las galaxias más brillantes del cúmulo de Virgo, siendo un objeto muy popular para los astrónomos aficionados y profesionales.</p>
            </div>

            <div class="column">
                <h3>Descubrimiento e Historia</h3>
                <p>La Galaxia del Sombrero fue descubierta por el astrónomo francés Pierre Méchain en 1781. Su apariencia única hizo que fuera rápidamente catalogada como uno de los objetos más interesantes en el cielo de la constelación de Virgo.</p>
                <p>A pesar de su cercanía a la Tierra en términos astronómicos, la Galaxia del Sombrero sigue siendo un misterio en muchos aspectos. Los astrónomos continúan estudiando su estructura, la actividad de su agujero negro central y cómo se formó su disco de polvo.</p>
            </div>
        </div>

        <h2>Datos Curiosos sobre la Galaxia del Sombrero</h2>
        <p>La Galaxia del Sombrero tiene muchas peculiaridades que la hacen única y fascinante:</p>
        <ul>
            <li>El agujero negro supermasivo en su núcleo tiene una masa equivalente a mil millones de veces la del Sol.</li>
            <li>Es una de las galaxias más brillantes de la constelación de Virgo, siendo visible a través de pequeños telescopios.</li>
            <li>La estructura de la galaxia se compone de un disco delgado y un bulbo central brillante rodeado de un halo de estrellas viejas.</li>
            <li>La galaxia está rodeada por un extenso halo de estrellas y cúmulos globulares que se extienden a varios cientos de miles de años luz de distancia.</li>
        </ul>

        <div class="highlight">
            <p>Con una forma tan característica, la Galaxia del Sombrero se destaca entre otras galaxias espirales por su aspecto único y su brillo inconfundible.</p>
        </div>

        <h2>El Futuro de la Galaxia del Sombrero</h2>
        <p>A pesar de su impresionante aspecto, la Galaxia del Sombrero está en una fase tranquila en términos de actividad estelar. No se espera que su estructura cambie radicalmente en el futuro cercano. Sin embargo, como muchas galaxias cercanas, se cree que experimentará interacciones con otras galaxias en el futuro, lo que podría alterar su forma a lo largo de millones de años.</p>

        <p>Es interesante notar que, aunque no está en riesgo de colisión inmediata, el futuro de la Galaxia del Sombrero podría estar influenciado por el movimiento de otras galaxias en el cúmulo de Virgo.</p>

    </section>

    <footer>
        <p>&copy; 2025 Galaxia del Sombrero. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
