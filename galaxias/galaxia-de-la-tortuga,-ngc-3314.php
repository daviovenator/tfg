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
    <title>NGC 3314 - Una interacción galáctica fascinante</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>NGC 3314</h1>
        <p>Descubre todo sobre NGC 3314, un sistema interactivo de dos galaxias fascinantes.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>

    <section id="informacion">
        <h2>¿Qué es NGC 3314?</h2>
        <p>NGC 3314 es una galaxia que se encuentra a unos 130 millones de años luz de distancia en la constelación de Cáncer. Es famosa por ser una galaxia que está interactuando visualmente con una galaxia de fondo, creando una fascinante ilusión óptica. El fenómeno que se observa, donde parece que ambas galaxias están entrelazadas, se debe a la alineación perfecta entre la galaxia espiral NGC 3314 y una galaxia más distante, lo que provoca que sus discos se vean superpuestos desde nuestra perspectiva.</p>
        <p>Este tipo de interacciones visuales entre galaxias son de gran interés para los astrónomos, ya que permiten estudiar cómo las galaxias interactúan entre sí y cómo la luz de una galaxia más cercana puede influir en la forma en que vemos las galaxias de fondo.</p>
        <img src="../img/galaxias/NGC-3314.jpg" alt="Imagen de la galaxia NGC 3314">
        <div class="highlight">
            <p>NGC 3314 muestra una impresionante interacción visual entre dos galaxias, una de fondo y otra en primer plano.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Composición de NGC 3314</h3>
                <p>NGC 3314 está compuesta principalmente por gas, polvo, y una gran cantidad de estrellas en su disco espiral. La galaxia tiene una estructura espiral clásica, con brazos espirales que albergan regiones de formación estelar. Sin embargo, lo más interesante de NGC 3314 no es su composición, sino la interacción visual que crea cuando se alinea con una galaxia más distante.</p>
                <p>La galaxia de fondo, que forma parte de NGC 3314, parece estar ubicada mucho más lejos de la Tierra y no está involucrada en la misma interacción galáctica, pero su alineación con la galaxia más cercana crea una ilusión de fusión de discos.</p>
            </div>

            <div class="column">
                <h3>Estructura de NGC 3314</h3>
                <p>La galaxia NGC 3314 tiene una típica estructura de galaxia espiral, con un disco central denso y un halo de estrellas más viejas en sus alrededores. Su núcleo es relativamente brillante, y sus brazos espirales están llenos de gas y polvo, donde se están formando nuevas estrellas.</p>
                <ul>
                    <li><strong>El Núcleo:</strong> En el centro de NGC 3314 se encuentra una concentración de estrellas, principalmente viejas. No se ha detectado actividad intensa de formación estelar en esta región.</li>
                    <li><strong>Los Brazos Espirales:</strong> Los brazos espirales están llenos de gas y polvo, siendo las regiones donde se encuentran la mayoría de las estrellas jóvenes y las áreas de formación estelar.</li>
                    <li><strong>El Halo:</strong> Como en la mayoría de las galaxias, NGC 3314 tiene un halo de estrellas viejas y cúmulos globulares que rodean su disco espiral.</li>
                </ul>
            </div>
        </div>

        <h2>Historia de NGC 3314</h2>
        <p>NGC 3314 fue descubierta por el astrónomo William Herschel el 5 de marzo de 1784. Desde su descubrimiento, la galaxia ha sido estudiada por los astrónomos debido a la interesante interacción visual que crea cuando se alinea con la galaxia más distante. A lo largo de los años, NGC 3314 ha sido un objeto fascinante para estudiar cómo las galaxias pueden parecer interactuar entre sí, aunque en realidad no haya interacción física directa entre ellas.</p>
        <p>Esta galaxia ha sido observada en diversas longitudes de onda, como el visible, infrarrojo y radio, para analizar su estructura y los procesos estelares que ocurren en su interior.</p>

        <div class="highlight">
            <p>NGC 3314 ha cautivado a los astrónomos debido a la ilusión óptica de interacción galáctica que crea con una galaxia de fondo.</p>
        </div>

        <h2>Datos Curiosos de NGC 3314</h2>
        <p>Algunos aspectos interesantes sobre NGC 3314 incluyen:</p>
        <ul>
            <li>La interacción visual entre las dos galaxias es solo una ilusión óptica. La galaxia de fondo está a una distancia mucho mayor que NGC 3314.</li>
            <li>NGC 3314 se encuentra a aproximadamente 130 millones de años luz de distancia de la Tierra, lo que la coloca en una región del espacio interesante para el estudio de galaxias espirales.</li>
            <li>El fenómeno de superposición de galaxias en NGC 3314 es un ejemplo perfecto de cómo las galaxias pueden parecer estar interactuando, pero en realidad no lo están, lo que lo convierte en un objeto único para los estudios de interacciones galácticas.</li>
        </ul>

        <h2>El Futuro de NGC 3314</h2>
        <p>En el futuro, NGC 3314 seguirá siendo un objeto de estudio importante para los astrónomos que investigan las interacciones galácticas. Aunque las dos galaxias no están físicamente interactuando entre sí, la alineación perfecta que crean desde nuestra perspectiva ofrece una oportunidad única para estudiar cómo las galaxias pueden parecer fusionarse sin estar realmente en contacto.</p>
        <p>Además, la observación de NGC 3314 en diferentes longitudes de onda puede proporcionar más información sobre los procesos dinámicos en las galaxias espirales y sobre cómo se forman y evolucionan las estructuras galácticas a lo largo del tiempo.</p>

        <div class="highlight">
            <p>NGC 3314 es un fascinante ejemplo de cómo las ilusiones ópticas en astronomía pueden enseñar mucho sobre la dinámica y evolución de las galaxias.</p>
        </div>

    </section>

    <footer>
        <p>&copy; 2025 NGC 3314. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
