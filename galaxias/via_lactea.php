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
    <title>La Vía Láctea - Todo sobre nuestra galaxia</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>La Vía Láctea</h1>
        <p>Descubre todo sobre nuestra galaxia, la casa del Sistema Solar.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </section>
    <section id="informacion">
        <h2>¿Qué es la Vía Láctea?</h2>
        <p>La Vía Láctea es nuestra galaxia, un vasto sistema estelar en forma de espiral que contiene nuestro Sistema Solar y millones de estrellas. Esta galaxia, que se extiende a lo largo de unos 100,000 años luz, es solo una de las miles de millones de galaxias en el universo conocido.</p>
        <p>El nombre "Vía Láctea" proviene de la antigua mitología griega, donde se referían a ella como el "camino de leche", haciendo alusión a la franja brillante y lechosa que aparece en el cielo nocturno. Este fenómeno es el resultado de la luz de las estrellas que forman la galaxia, vista desde nuestro punto de observación.</p>

<img src="https://media.es.wired.com/photos/6654c716157239e3d1f2aef1/16:9/w_2992,h_1683,c_limit/via%20lactea%20en%20bosque.jpg">        <div class="highlight">
            <p>La Vía Láctea es una galaxia espiral barrada con un gran halo de estrellas en su centro, rodeado por grandes nubes de gas y polvo interestelar.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Composición de la Vía Láctea</h3>
                <p>La Vía Láctea está compuesta principalmente por estrellas, gas y polvo. La mayor parte de las estrellas se encuentran en el disco espiral de la galaxia, mientras que el núcleo alberga una densa concentración de estrellas viejas y un agujero negro supermasivo. Los brazos espirales son regiones activas donde se forman nuevas estrellas, alimentadas por grandes nubes de gas y polvo.</p>
                <p>Además de las estrellas, la galaxia contiene una gran cantidad de materia oscura, un tipo de materia invisible que no emite luz ni energía detectable, pero cuya presencia se infiere por sus efectos gravitacionales en la materia visible.</p>
            </div>

            <div class="column">
                <h3>Estructura de la Vía Láctea</h3>
                <p>La estructura de la Vía Láctea se puede describir en varias partes clave:</p>
                <ul>
                    <li><strong>El Bulbo Central:</strong> Es una esfera de estrellas densamente agrupadas en el centro de la galaxia. Este bulbo alberga algunas de las estrellas más antiguas y cerca de él se encuentra el agujero negro supermasivo, conocido como Sagitario A*.</li>
                    <li><strong>El Disco:</strong> Es el componente principal de la galaxia y contiene los brazos espirales, regiones ricas en gas y polvo, y muchas estrellas jóvenes. El disco tiene una forma plana y se extiende a lo largo de unos 100,000 años luz.</li>
                    <li><strong>El Halo:</strong> Una extensa región esférica que rodea el disco, llena de estrellas viejas y cúmulos globulares. El halo también alberga la mayor parte de la materia oscura de la galaxia.</li>
                </ul>
            </div>
        </div>

        <h2>Historia de la Vía Láctea</h2>
        <p>La historia de nuestra comprensión de la Vía Láctea ha evolucionado considerablemente desde la antigüedad. En la antigua Grecia, filósofos como Aristóteles pensaban que la Vía Láctea era un fenómeno asociado con los dioses, mientras que otros, como los astrónomos medievales, creían que era una región del espacio vacío llena de luz.</p>
        <p>El descubrimiento de que la Vía Láctea estaba compuesta por estrellas individuales se le atribuye a Galileo Galilei en el siglo XVII. Utilizando su telescopio, Galileo observó que la franja luminosa que veíamos en el cielo nocturno estaba compuesta por miles de pequeñas estrellas. Sin embargo, fue a principios del siglo XX cuando los astrónomos comenzaron a comprender la verdadera naturaleza de nuestra galaxia, especialmente gracias a las observaciones de Edwin Hubble, quien demostró que la Vía Láctea era solo una de muchas galaxias en el universo.</p>


        <div class="highlight">
            <p>Se estima que la Vía Láctea contiene entre 100 y 400 mil millones de estrellas.</p>
        </div>

        <h2>Datos Curiosos de la Vía Láctea</h2>
        <p>Existen muchos aspectos interesantes sobre la Vía Láctea que a menudo sorprenden a los científicos y aficionados a la astronomía:</p>
        <ul>
            <li>En el centro de la Vía Láctea reside un agujero negro supermasivo, conocido como Sagitario A*, que tiene una masa equivalente a 4 millones de veces la del Sol.</li>
            <li>La Vía Láctea es solo una de las miles de millones de galaxias que existen en el universo observable.</li>
            <li>En unos 4.5 mil millones de años, la Vía Láctea y la galaxia de Andrómeda se fusionarán, dando lugar a una nueva galaxia elíptica gigante.</li>
            <li>Se estima que la Vía Láctea contiene más de 100,000 millones de planetas, algunos de los cuales podrían tener las condiciones necesarias para albergar vida.</li>
        </ul>

        <h2>El Futuro de la Vía Láctea</h2>
        <p>En el futuro, la Vía Láctea experimentará grandes cambios. Como se mencionó, dentro de unos 4.5 mil millones de años, nuestra galaxia se fusionará con la galaxia de Andrómeda. Este evento cambiará completamente la forma de ambas galaxias, pero no afectará directamente a las estrellas individuales, que están muy separadas unas de otras. A lo largo de este proceso, las estrellas de ambas galaxias probablemente seguirán sus trayectorias sin chocar entre sí, aunque el gas y el polvo en el centro de ambas galaxias se combinarán, formando nuevas estrellas.</p>
        <p>Además, se espera que en el futuro, la Vía Láctea se convierta en una galaxia elíptica después de la fusión. Sin embargo, como este proceso está a miles de millones de años de ocurrir, no afectará a la vida en la Tierra en un futuro cercano.</p>

        <div class="highlight">
            <p>La Vía Láctea es nuestra casa cósmica, pero también es solo una pequeña parte del vasto universo que aún estamos tratando de explorar.</p>
        </div>

    </section>

    <footer>
        <p>&copy; 2025 La Vía Láctea. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
