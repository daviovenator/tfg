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
    <title>La Galaxia M33 - Todo sobre esta fascinante galaxia</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>La Galaxia M33 (NGC 598)</h1>
        <p>Descubre todo sobre la fascinante galaxia M33, también conocida como la Galaxia del Triángulo.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>

    <section id="informacion">
        <h2>¿Qué es la Galaxia M33?</h2>
        <p>La Galaxia M33, también conocida como NGC 598 o la Galaxia del Triángulo, es una galaxia espiral que se encuentra a unos 3 millones de años luz de la Tierra, en la constelación del Triángulo. Es una de las galaxias más cercanas a la Vía Láctea, y tiene un tamaño de aproximadamente 50,000 años luz, lo que la hace más pequeña en comparación con nuestra propia galaxia.</p>
        <p>M33 es miembro del Grupo Local de galaxias, que incluye a la Vía Láctea, la Galaxia de Andrómeda y otras muchas más pequeñas. Aunque es bastante conocida, es más débil y difícil de observar en comparación con otras galaxias más brillantes del Grupo Local.</p>

        <img src="../img/galaxias/M33.jpg" alt="Imagen de la Galaxia M33">

        <div class="highlight">
            <p>La Galaxia M33 es una galaxia espiral que forma parte del Grupo Local, y es conocida por su estructura bien definida y su gran número de estrellas jóvenes.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Características de la Galaxia M33</h3>
                <p>M33 es una galaxia espiral con un núcleo poco brillante y unos brazos espirales claramente definidos que albergan una gran cantidad de estrellas jóvenes. Su estructura es relativamente similar a la de la Vía Láctea y la Galaxia de Andrómeda, pero su tamaño es considerablemente más pequeño.</p>
                <p>Uno de los aspectos más fascinantes de M33 es la gran cantidad de estrellas azules y jóvenes que se encuentran en sus brazos espirales. Estas estrellas se están formando activamente, lo que hace que las regiones de formación estelar de la galaxia sean muy brillantes, especialmente en longitudes de onda de ultravioleta.</p>
            </div>

            <div class="column">
                <h3>Historia del Descubrimiento</h3>
                <p>La Galaxia M33 fue descubierta por el astrónomo William Herschel en 1784. Durante muchos años, fue considerada una de las galaxias más brillantes del Grupo Local, y se pensaba que era una parte del halo de la Galaxia de Andrómeda. Sin embargo, estudios posteriores confirmaron que M33 es una galaxia independiente.</p>
                <p>En las últimas décadas, M33 ha sido objeto de muchas observaciones, especialmente en el campo de la formación estelar, ya que sus brazos espirales activos son ideales para estudiar cómo se forman las estrellas en una galaxia espiral.</p>
            </div>
        </div>

        <h2>Datos Curiosos sobre la Galaxia M33</h2>
        <p>La Galaxia M33 es un objeto fascinante debido a sus características únicas:</p>
        <ul>
            <li>M33 tiene un diámetro de unos 50,000 años luz, aproximadamente un 40% del tamaño de la Vía Láctea.</li>
            <li>Es una de las galaxias más cercanas a la Vía Láctea, ubicada a unos 3 millones de años luz de distancia.</li>
            <li>El centro de la galaxia contiene un pequeño núcleo, y sus brazos espirales están llenos de regiones activas de formación estelar.</li>
            <li>En M33 se han encontrado numerosas regiones HII, que son zonas donde las estrellas jóvenes emiten gran cantidad de radiación ultravioleta, lo que ioniza el gas circundante.</li>
        </ul>

        <div class="highlight">
            <p>Una de las características más sorprendentes de M33 es la gran cantidad de estrellas jóvenes en formación, lo que le da un brillo espectacular en longitudes de onda ultravioletas.</p>
        </div>

        <h2>El Futuro de la Galaxia M33</h2>
        <p>Aunque M33 es una galaxia relativamente pequeña en comparación con la Vía Láctea, es probable que en el futuro interactúe con otras galaxias cercanas. La galaxia de Andrómeda y la Vía Láctea están en proceso de acercarse y, eventualmente, se fusionarán dentro de unos 4.5 mil millones de años. Durante este proceso, M33 también podría verse afectada por la gravedad de las galaxias más grandes, aunque no se espera que ocurra una fusión directa entre M33 y las otras galaxias del Grupo Local.</p>

        <p>A lo largo de los próximos miles de millones de años, es probable que M33 siga siendo un laboratorio natural para estudiar la formación estelar y los procesos dinámicos de las galaxias espirales.</p>

    </section>

    <footer>
        <p>&copy; 2025 Galaxia M33. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
