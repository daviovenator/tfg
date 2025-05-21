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
    <title>NGC 1300 - Una galaxia espiral barrada</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>NGC 1300</h1>
        <p>Descubre la galaxia espiral barrada NGC 1300, una de las más conocidas del cielo.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>
    <section id="informacion">
        <h2>¿Qué es la NGC 1300?</h2>
        <p>NGC 1300 es una galaxia espiral barrada ubicada a unos 61 millones de años luz de la Tierra, en la constelación de Eridanus. Esta galaxia es famosa por su forma espiral bien definida y su barra central, un rasgo característico que muchas galaxias espirales poseen.</p>
        <p>La NGC 1300 es una de las galaxias más estudiadas debido a su estructura impresionante y su relativa cercanía. Tiene un diámetro de aproximadamente 100,000 años luz, lo que la convierte en una galaxia de tamaño similar a la Vía Láctea.</p>

        <img src="../img/galaxias/ngc-1300.avif" alt="Imagen de NGC 1300">

        <div class="highlight">
            <p>La galaxia NGC 1300 es una galaxia espiral barrada, lo que significa que tiene una barra de estrellas en su centro y brazos espirales que se extienden desde esa barra.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Composición de la NGC 1300</h3>
                <p>La NGC 1300 es una galaxia espiral barrada, lo que significa que tiene una estructura distintiva que se caracteriza por una barra de estrellas que atraviesa su núcleo central, alrededor de la cual se agrupan los brazos espirales. Este tipo de galaxia es relativamente común en el universo, pero NGC 1300 es una de las más grandes y brillantes en la que se puede observar claramente esta estructura.</p>
                <p>La galaxia contiene un gran número de estrellas, gas y polvo, que forman los brazos espirales. En su núcleo, se encuentra una gran concentración de estrellas viejas, mientras que en los brazos espirales se forman estrellas jóvenes. El gas y el polvo en los brazos espirales alimentan la formación de nuevas estrellas.</p>
            </div>

            <div class="column">
                <h3>Estructura de la NGC 1300</h3>
                <p>La estructura de la NGC 1300 es la típica de una galaxia espiral barrada, con tres componentes principales:</p>
                <ul>
                    <li><strong>La Barra Central:</strong> Una región densa de estrellas que atraviesa el núcleo de la galaxia. La barra es un componente distintivo de las galaxias espirales barradas y se cree que juega un papel importante en la dinámica de la galaxia.</li>
                    <li><strong>El Disco:</strong> El disco de la NGC 1300 es la región donde se encuentran los brazos espirales y la mayoría de las estrellas. El disco tiene una forma plana y se extiende a través de la galaxia.</li>
                    <li><strong>El Halo:</strong> Rodeando el disco, el halo contiene estrellas viejas, cúmulos globulares y materia oscura. Es una región esférica que se extiende mucho más allá del disco visible de la galaxia.</li>
                </ul>
            </div>
        </div>

        <h2>Historia de la NGC 1300</h2>
        <p>La NGC 1300 fue descubierta en 1835 por el astrónomo John Herschel. Desde su descubrimiento, ha sido un objetivo importante para los astrónomos que estudian la estructura de las galaxias espirales barradas. A lo largo de los años, se han realizado numerosos estudios de su formación estelar, su estructura y su dinámica interna.</p>
        <p>En particular, los astrónomos han estudiado la barra central de NGC 1300 para comprender mejor cómo se forman las barras en las galaxias. Este fenómeno sigue siendo un área activa de investigación, ya que no se comprende completamente por qué algunas galaxias desarrollan barras mientras que otras no.</p>

        <div class="highlight">
            <p>Se estima que la NGC 1300 tiene entre 40 y 50 mil millones de estrellas.</p>
        </div>

        <h2>Datos Curiosos de la NGC 1300</h2>
        <p>Algunos aspectos interesantes sobre la galaxia NGC 1300 incluyen:</p>
        <ul>
            <li>La NGC 1300 es un ejemplo clásico de una galaxia espiral barrada.</li>
            <li>La barra central de la NGC 1300 está compuesta por estrellas viejas y es una de las más prominentes observadas en las galaxias espirales barradas.</li>
            <li>Se cree que las barras en las galaxias como NGC 1300 juegan un papel crucial en la transferencia de gas hacia el núcleo de la galaxia, lo que podría alimentar la formación de nuevas estrellas.</li>
            <li>El estudio de la NGC 1300 ha proporcionado valiosa información sobre cómo se desarrollan las galaxias espirales barradas y su evolución a lo largo del tiempo.</li>
        </ul>

        <h2>El Futuro de la NGC 1300</h2>
        <p>Como muchas otras galaxias espirales, la NGC 1300 experimentará cambios a lo largo de millones de años. Se espera que, al igual que otras galaxias, NGC 1300 continúe formando nuevas estrellas en sus brazos espirales mientras que su barra central se mantenga relativamente estable. Las interacciones gravitacionales con otras galaxias en el futuro podrían cambiar la estructura de la NGC 1300, aunque este proceso ocurrirá a una escala temporal de miles de millones de años.</p>
        <p>Los astrónomos seguirán observando la NGC 1300 para aprender más sobre las galaxias espirales barradas y cómo evolucionan con el tiempo.</p>

        <div class="highlight">
            <p>La galaxia NGC 1300 es un objeto fascinante para los astrónomos, que siguen investigando su estructura y evolución en el vasto universo.</p>
        </div>

    </section>

    <footer>
        <p>&copy; 2025 NGC 1300. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
