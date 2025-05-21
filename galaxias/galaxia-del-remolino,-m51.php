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
    <title>La Galaxia M51 - Todo sobre la Galaxia del Remolino</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>La Galaxia M51 (Galaxia del Remolino)</h1>
        <p>Descubre todo sobre la Galaxia M51, también conocida como la Galaxia del Remolino, una de las galaxias espirales más famosas.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>

    <section id="informacion">
        <h2>¿Qué es la Galaxia M51?</h2>
        <p>La Galaxia M51, también conocida como la Galaxia del Remolino, es una galaxia espiral ubicada a unos 31 millones de años luz de la Tierra, en la constelación de Canes Venatici. Es famosa por su estructura espiral bien definida y su interacción con la galaxia compañera NGC 5195. Esta interacción le da a M51 su aspecto de "remolino", con los brazos espirales claramente definidos y un centro brillante.</p>
        <p>La Galaxia M51 es una de las galaxias espirales más observadas por los astrónomos debido a su forma llamativa y su proximidad relativa. A menudo se utiliza como un ejemplo clásico de una galaxia espiral en interacción con otra galaxia.</p>

        <img src="../img/galaxias/M51.jpg" alt="Imagen de la Galaxia M51">

        <div class="highlight">
            <p>La Galaxia M51 es famosa por su interacción con la galaxia NGC 5195, lo que ha creado sus brazos espirales perfectamente definidos y su estructura espectacular.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Características de la Galaxia M51</h3>
                <p>La Galaxia M51 es una galaxia espiral clásica, con brazos espirales luminosos que se extienden desde su núcleo central. Lo más interesante de esta galaxia es su interacción con la galaxia compañera NGC 5195, que está más cerca de su núcleo y distorsiona la forma de M51.</p>
                <p>Los brazos espirales de M51 están llenos de regiones de formación estelar activa, lo que contribuye a su brillantez en las longitudes de onda de la luz visible. Además, la galaxia M51 tiene una gran cantidad de estrellas jóvenes y una población activa de estrellas azules.</p>
            </div>

            <div class="column">
                <h3>Interacción con NGC 5195</h3>
                <p>La galaxia NGC 5195 es una galaxia compañera de M51, y su interacción gravitacional ha afectado notablemente la estructura de M51. Esta interacción ha provocado que M51 tenga una forma de remolino, con sus brazos espirales retorciéndose alrededor del centro de la galaxia debido a la gravedad de NGC 5195.</p>
                <p>Esta interacción también ha desencadenado una intensa formación de estrellas en M51, especialmente en las regiones cercanas al punto de contacto entre ambas galaxias, lo que crea una región brillante de gas ionizado que se puede observar en varias longitudes de onda.</p>
            </div>
        </div>

        <h2>Historia del Descubrimiento</h2>
        <p>La Galaxia M51 fue descubierta por el astrónomo Charles Messier en 1773, quien la incluyó en su famoso catálogo de objetos difusos como el objeto Messier 51 (M51). Desde su descubrimiento, ha sido uno de los objetos más estudiados en el cielo debido a su impresionante forma espiral y la fascinante interacción con NGC 5195.</p>
        <p>A lo largo de los años, los astrónomos han utilizado M51 para estudiar las interacciones gravitacionales entre galaxias y el efecto que estas tienen sobre la formación estelar. Gracias a la tecnología moderna, como los telescopios espaciales Hubble y Spitzer, los científicos han podido observar M51 en gran detalle, lo que ha ayudado a comprender mejor los procesos que ocurren en las galaxias espirales.</p>

        <h2>Datos Curiosos sobre la Galaxia M51</h2>
        <ul>
            <li>La Galaxia M51 está a aproximadamente 31 millones de años luz de la Tierra, lo que la convierte en una de las galaxias más cercanas del tipo espiral en el cielo.</li>
            <li>La interacción con NGC 5195 ha provocado que M51 tenga una de las estructuras más definidas de brazos espirales en cualquier galaxia observada.</li>
            <li>Los brazos espirales de M51 están llenos de regiones de formación estelar, lo que la convierte en un lugar activo para el estudio de cómo nacen las estrellas en una galaxia espiral.</li>
            <li>El núcleo de M51 alberga un agujero negro supermasivo, como es típico en las galaxias espirales grandes.</li>
        </ul>

        <div class="highlight">
            <p>Gracias a su interacción con NGC 5195, M51 es uno de los mejores ejemplos de una galaxia espiral activa y de cómo las galaxias pueden influenciarse mutuamente.</p>
        </div>

        <h2>El Futuro de la Galaxia M51</h2>
        <p>En el futuro, M51 probablemente continuará interactuando con NGC 5195, lo que afectará aún más su estructura. Aunque se estima que la galaxia compañera se alejará eventualmente de M51, el intercambio de materia y energía entre ellas ha tenido un impacto significativo en la evolución de ambas galaxias.</p>
        <p>Los astrónomos continúan estudiando M51 para entender mejor cómo las galaxias espirales evolucionan y cómo las interacciones entre galaxias pueden desencadenar la formación de nuevas estrellas y modificar la estructura galáctica a lo largo del tiempo.</p>

    </section>

    <footer>
        <p>&copy; 2025 Galaxia M51. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
