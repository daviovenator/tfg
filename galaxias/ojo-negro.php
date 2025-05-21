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
    <title>La Galaxia Ojo Negro - Todo sobre esta fascinante galaxia</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>La Galaxia Ojo Negro (NGC 4321)</h1>
        <p>Descubre todo sobre una de las galaxias más intrigantes del universo: La Galaxia Ojo Negro.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>

    <section id="informacion">
        <h2>¿Qué es la Galaxia Ojo Negro?</h2>
        <p>La Galaxia Ojo Negro, conocida como NGC 4321, es una galaxia espiral ubicada en el cúmulo de galaxias de Virgo. Se encuentra a unos 55 millones de años luz de la Tierra y se ha ganado el nombre de "Ojo Negro" debido a su característica forma, que recuerda a un ojo con su núcleo brillante y el disco oscuro que lo rodea.</p>
        <p>NGC 4321 es una galaxia espiral bastante prominente en el cielo nocturno y ha sido objeto de múltiples estudios astronómicos debido a su estructura bien definida y su relativamente cercana distancia a la Tierra.</p>

        <img src="../img/galaxias/ojo-negro.jpg " alt="Imagen de la Galaxia Ojo Negro">

        <div class="highlight">
            <p>El centro de la Galaxia Ojo Negro es particularmente brillante, rodeado por un disco de gas y polvo que contribuye a su forma distintiva.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Características de la Galaxia Ojo Negro</h3>
                <p>NGC 4321 es una galaxia espiral de gran tamaño, con un núcleo brillante y una estructura de brazos espirales bien definidos. Su apariencia es similar a la de otras galaxias espirales, pero lo que la hace especial es la claridad con la que se observa su centro oscuro y el contraste con su brillante núcleo.</p>
                <p>Esta galaxia alberga una variedad de estrellas, algunas de las cuales son jóvenes y otras viejas, lo que contribuye a la diversidad de su estructura. Además, se cree que su núcleo contiene un agujero negro supermasivo, como ocurre en muchas galaxias de este tipo.</p>
            </div>

            <div class="column">
                <h3>Historia del Descubrimiento</h3>
                <p>La Galaxia Ojo Negro fue descubierta por el astrónomo William Herschel en 1784. Desde su descubrimiento, se ha convertido en un objetivo popular para los astrónomos, debido a su ubicación cercana y su impresionante estructura que permite realizar observaciones detalladas.</p>
                <p>En las últimas décadas, NGC 4321 ha sido ampliamente estudiada debido a su cercanía y su rol en la comprensión de las galaxias espirales y sus características. Ha sido objeto de observación tanto con telescopios ópticos como de rayos X y de infrarrojos.</p>
            </div>
        </div>

        <h2>Datos Curiosos sobre la Galaxia Ojo Negro</h2>
        <p>La Galaxia Ojo Negro tiene varias características notables que la hacen un objeto de estudio interesante:</p>
        <ul>
            <li>Se estima que NGC 4321 tiene un diámetro de unos 90,000 años luz.</li>
            <li>El núcleo de la galaxia contiene un agujero negro supermasivo con una masa estimada de alrededor de 300 millones de veces la masa del Sol.</li>
            <li>NGC 4321 es una de las galaxias espirales más cercanas a la Tierra, lo que permite realizar estudios detallados de su estructura interna.</li>
            <li>La galaxia está rodeada por un halo de estrellas y cúmulos globulares, y se encuentra en el borde del cúmulo de galaxias de Virgo.</li>
        </ul>

        <div class="highlight">
            <p>La Galaxia Ojo Negro tiene un centro brillante y rodeado de polvo, lo que le otorga una apariencia única y llamativa en el espacio profundo.</p>
        </div>

        <h2>El Futuro de la Galaxia Ojo Negro</h2>
        <p>Se cree que la Galaxia Ojo Negro, al igual que muchas otras galaxias en el cúmulo de Virgo, eventualmente se fusionará con otras galaxias cercanas a medida que el universo evoluciona. Sin embargo, debido a la distancia entre las estrellas dentro de estas galaxias, no se espera que ocurran colisiones significativas entre estrellas en el corto plazo.</p>

        <p>Se estima que NGC 4321 seguirá siendo un objeto de estudio importante para comprender las características de las galaxias espirales y los agujeros negros supermasivos en el centro de estas galaxias.</p>

    </section>

    <footer>
        <p>&copy; 2025 Galaxia Ojo Negro. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
