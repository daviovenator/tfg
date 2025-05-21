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
    <title>NGC 2997 - Una galaxia espiral</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>NGC 2997</h1>
        <p>Descubre todo sobre NGC 2997, una impresionante galaxia espiral ubicada en la constelación de Hidra.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>

    <section id="informacion">
        <h2>¿Qué es NGC 2997?</h2>
        <p>NGC 2997 es una galaxia espiral ubicada aproximadamente a 30 millones de años luz de la Tierra, en la constelación de Hidra. Esta galaxia es conocida por su impresionante estructura espiral bien definida, su núcleo brillante y su relativamente baja tasa de formación estelar comparada con otras galaxias similares. NGC 2997 fue descubierta por el astrónomo William Herschel el 5 de febrero de 1793.</p>
        <p>Es un excelente objeto de estudio para los astrónomos que investigan la estructura y la dinámica de las galaxias espirales, en particular en lo que se refiere a los procesos de formación de estrellas y la evolución de sus brazos espirales.</p>
        <img src="../img/galaxias/NGC-2997.jpg" alt="Imagen de la galaxia NGC 2997">
        <div class="highlight">
            <p>NGC 2997 es una galaxia espiral bien definida, conocida por su núcleo brillante y sus distintivos brazos espirales.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Composición de NGC 2997</h3>
                <p>NGC 2997 es una galaxia espiral tipo Sc (de acuerdo con la clasificación de Hubble), lo que significa que tiene una estructura espiral bien definida con un núcleo brillante. La galaxia contiene un gran número de estrellas viejas y jóvenes, así como una buena cantidad de gas y polvo interestelar que alimentan la formación estelar.</p>
                <p>A pesar de su apariencia activa y estructurada, NGC 2997 no es una galaxia particularmente activa en términos de formación de nuevas estrellas. Sin embargo, tiene varias regiones de formación estelar, en particular en los brazos espirales donde el gas y el polvo son más densos.</p>
            </div>

            <div class="column">
                <h3>Estructura de NGC 2997</h3>
                <p>NGC 2997 tiene una estructura espiral clásica con un gran bulbo central y brazos espirales bien formados. Esta galaxia tiene un núcleo brillante, rodeado por un disco de estrellas y gas. Los brazos espirales son visibles en las observaciones y están llenos de cúmulos estelares y regiones de formación estelar.</p>
                <ul>
                    <li><strong>El Núcleo:</strong> El núcleo de NGC 2997 es relativamente brillante y está compuesto principalmente por estrellas viejas, con una pequeña cantidad de gas y polvo.</li>
                    <li><strong>Los Brazos Espirales:</strong> Los brazos espirales se extienden desde el centro de la galaxia y están llenos de gas y polvo. Son las regiones más activas en cuanto a formación estelar.</li>
                    <li><strong>El Halo:</strong> Al igual que otras galaxias, NGC 2997 está rodeada por un halo de estrellas viejas y cúmulos globulares que se extienden más allá del disco visible.</li>
                </ul>
            </div>
        </div>

        <h2>Historia de NGC 2997</h2>
        <p>NGC 2997 fue descubierta por William Herschel en 1793. Desde su descubrimiento, ha sido objeto de estudio en varias investigaciones astronómicas debido a su estructura espiral bien definida y su posición relativamente cercana a la Tierra. A lo largo de los años, los astrónomos han utilizado esta galaxia como un modelo para estudiar la formación y evolución de las galaxias espirales.</p>
        <p>El estudio de NGC 2997 también ha proporcionado información sobre los agujeros negros supermasivos en los núcleos galácticos, ya que se cree que muchas galaxias espirales como esta contienen uno en su centro, aunque NGC 2997 no parece tener uno activo en su núcleo.</p>

        <div class="highlight">
            <p>NGC 2997 ha sido un objetivo popular para los astrónomos debido a su estructura clara y sus características interesantes como galaxia espiral.</p>
        </div>

        <h2>Datos Curiosos de NGC 2997</h2>
        <p>Algunos aspectos interesantes sobre NGC 2997 incluyen:</p>
        <ul>
            <li>NGC 2997 tiene un diámetro de aproximadamente 100,000 años luz, lo que la hace comparable en tamaño con la Vía Láctea.</li>
            <li>La galaxia tiene una tasa relativamente baja de formación estelar en comparación con otras galaxias espirales, lo que la convierte en un ejemplo interesante para estudiar cómo las galaxias evolucionan a lo largo del tiempo.</li>
            <li>NGC 2997 ha sido observada en diversas longitudes de onda, incluyendo rayos X y radio, lo que ha proporcionado información adicional sobre los procesos dinámicos en su interior.</li>
        </ul>

        <h2>El Futuro de NGC 2997</h2>
        <p>Como otras galaxias espirales, NGC 2997 está en constante evolución. A medida que pasa el tiempo, es probable que su tasa de formación estelar continúe disminuyendo, lo que la llevará a convertirse en una galaxia más pasiva y menos activa. Eventualmente, se espera que NGC 2997 interactúe gravitacionalmente con otras galaxias cercanas, lo que podría modificar su estructura y dinámica.</p>
        <p>NGC 2997 será un objeto importante para los astrónomos que estudian la evolución de las galaxias espirales y los efectos de las interacciones galácticas en las características estructurales y dinámicas de estas galaxias.</p>

        <div class="highlight">
            <p>NGC 2997 es una galaxia espiral brillante, activa en su formación estelar, y seguirá siendo un importante objeto de estudio en el futuro para los astrónomos.</p>
        </div>

    </section>

    <footer>
        <p>&copy; 2025 NGC 2997. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
