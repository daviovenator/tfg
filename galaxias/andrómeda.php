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
    <title>Galaxia de Andrómeda - Todo sobre la galaxia más cercana</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>Galaxia de Andrómeda</h1>
        <p>Descubre todo sobre la galaxia más cercana a la Vía Láctea.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>
    <section id="informacion">
        <h2>¿Qué es la Galaxia de Andrómeda?</h2>
        <p>La galaxia de Andrómeda, también conocida como M31, es una galaxia espiral gigante ubicada a aproximadamente 2.537 millones de años luz de la Tierra. Es la galaxia más cercana en tamaño y estructura a la Vía Láctea, y ambas forman parte del Grupo Local, una colección de más de 50 galaxias.</p>
        <p>Andrómeda tiene un diámetro de alrededor de 220,000 años luz, lo que la hace más grande que la Vía Láctea, que tiene aproximadamente 100,000 años luz de ancho. Se estima que contiene más de 1 billón de estrellas, lo que la convierte en una de las galaxias más masivas de nuestra vecindad cósmica.</p>

        <img src="../img/galaxias/andromeda.jpg" alt="Imagen de la Galaxia de Andrómeda">

        <div class="highlight">
            <p>La galaxia de Andrómeda es una de las pocas galaxias visibles a simple vista desde la Tierra, especialmente en cielos oscuros.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Composición de la Galaxia de Andrómeda</h3>
                <p>La galaxia de Andrómeda, al igual que la Vía Láctea, está compuesta por estrellas, gas, polvo y materia oscura. Andrómeda tiene una estructura en espiral con brazos llenos de estrellas jóvenes y una región central densa con estrellas viejas. En su núcleo se encuentra un agujero negro supermasivo, similar al de la Vía Láctea, que se cree que juega un papel crucial en la dinámica de la galaxia.</p>
                <p>Además de las estrellas visibles, Andrómeda contiene una gran cantidad de gas interestelar, que es esencial para la formación de nuevas estrellas. La galaxia también está rodeada por un halo de materia oscura, cuya presencia se deduce por los efectos gravitacionales en las estrellas visibles.</p>
            </div>

            <div class="column">
                <h3>Estructura de la Galaxia de Andrómeda</h3>
                <p>La estructura de la galaxia de Andrómeda puede describirse en varias partes clave:</p>
                <ul>
                    <li><strong>El Núcleo:</strong> En el centro de Andrómeda se encuentra un agujero negro supermasivo, similar al de la Vía Láctea. Este agujero negro es el motor gravitacional que influye en el movimiento de las estrellas y el gas en la galaxia.</li>
                    <li><strong>El Disco Espiral:</strong> La mayor parte de las estrellas de Andrómeda están distribuidas en su disco espiral, que tiene una forma plana y está dividido en brazos espirales. Estos brazos son regiones ricas en gas y polvo donde nacen nuevas estrellas.</li>
                    <li><strong>El Halo:</strong> El halo de Andrómeda está compuesto por estrellas más viejas, cúmulos globulares y una gran cantidad de materia oscura. Este halo es más grande que el disco y contiene una gran cantidad de la masa invisible de la galaxia.</li>
                </ul>
            </div>
        </div>

        <h2>Historia de la Galaxia de Andrómeda</h2>
        <p>La historia de la comprensión de la galaxia de Andrómeda ha sido fundamental en la astronomía moderna. Durante siglos, los astrónomos pensaron que Andrómeda era una nebulosa, es decir, una nube de gas distante, y no una galaxia en sí misma. Fue en 1924 cuando el astrónomo Edwin Hubble, utilizando el telescopio de Monte Wilson, demostró que Andrómeda era una galaxia separada de la Vía Láctea, lo que cambió completamente nuestra comprensión del universo.</p>
        <p>El descubrimiento de que Andrómeda estaba tan lejos de la Vía Láctea y contenía su propio sistema estelar abrió la puerta a la idea de que el universo estaba lleno de galaxias. Esto también llevó al desarrollo de la teoría de la expansión del universo, que ha sido fundamental para nuestra comprensión de la cosmología moderna.</p>

        <div class="highlight">
            <p>Se estima que Andrómeda contiene más de un billón de estrellas, mientras que la Vía Láctea tiene "solo" entre 100 y 400 mil millones de estrellas.</p>
        </div>

        <h2>Datos Curiosos de la Galaxia de Andrómeda</h2>
        <p>La galaxia de Andrómeda está llena de curiosidades fascinantes:</p>
        <ul>
            <li>Andrómeda es la galaxia más cercana a la Vía Láctea y se dirige hacia nuestra galaxia a unos 110 km/s. En unos 4.5 mil millones de años, se espera que ambas galaxias se fusionen.</li>
            <li>La galaxia de Andrómeda tiene varias galaxias satélites que la acompañan, incluyendo las galaxias del Triángulo (M33) y M32.</li>
            <li>Andrómeda tiene una gran cantidad de cúmulos globulares, que son conglomerados densos de estrellas viejas que giran alrededor de la galaxia.</li>
            <li>La galaxia de Andrómeda tiene una forma elíptica, lo que la distingue de la Vía Láctea, que tiene una forma espiral barrada.</li>
        </ul>

        <h2>El Futuro de la Galaxia de Andrómeda</h2>
        <p>En el futuro, Andrómeda y la Vía Láctea se fusionarán en un proceso que cambiará drásticamente la forma de ambas galaxias. Esta colisión, que ocurrirá en aproximadamente 4.5 mil millones de años, resultará en la creación de una nueva galaxia elíptica gigante, posiblemente llamada "Milkomeda". Durante esta fusión, las estrellas de ambas galaxias seguirán sus trayectorias sin chocar entre sí debido a la gran distancia que las separa, pero el gas y el polvo se fusionarán para formar nuevas estrellas.</p>
        <p>El encuentro entre estas dos grandes galaxias tendrá un impacto profundo en el futuro del Grupo Local y será uno de los eventos más importantes en la historia cósmica de la Vía Láctea y Andrómeda.</p>

        <div class="highlight">
            <p>La galaxia de Andrómeda es nuestra vecina cósmica, y su colisión con la Vía Láctea nos permitirá entender mejor cómo las galaxias se fusionan y evolucionan a lo largo del tiempo.</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Galaxia de Andrómeda. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
