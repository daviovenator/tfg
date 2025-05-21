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
    <title>Gran Nube de Magallanes</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>Gran Nube de Magallanes</h1>
        <p>Descubre todo sobre la Gran Nube de Magallanes, una galaxia satélite de la Vía Láctea.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>

    <section id="informacion">
        <h2>¿Qué es la Gran Nube de Magallanes?</h2>
        <p>La **Gran Nube de Magallanes (LMC, por sus siglas en inglés)** es una galaxia satélite de la **Vía Láctea**, ubicada a unos 163,000 años luz de distancia. Es una galaxia irregular y una de las galaxias más cercanas a nuestra propia galaxia. La Gran Nube de Magallanes es visible a simple vista desde el hemisferio sur y se puede observar como una nebulosa difusa en el cielo nocturno.</p>
        <p>El nombre "Nube de Magallanes" proviene de los exploradores portugueses, quienes la observaron durante sus expediciones en el siglo XVI. Fue nombrada en honor al navegante Fernando de Magallanes, quien fue el primero en registrar su observación durante su expedición alrededor del mundo.</p>
        <img src="../img/galaxias/Gran-nube-de-magallanes.jpg" alt="Imagen de la Gran Nube de Magallanes">
        <div class="highlight">
            <p>La Gran Nube de Magallanes es una galaxia irregular que se encuentra relativamente cerca de nuestra Vía Láctea y es una de las galaxias más grandes del Grupo Local.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Composición de la Gran Nube de Magallanes</h3>
                <p>La Gran Nube de Magallanes es una galaxia irregular que contiene una gran cantidad de gas y polvo, lo que favorece la formación de nuevas estrellas. Es rica en regiones de formación estelar, en particular en el área conocida como **30 Doradus**, una de las regiones de formación estelar más activas que se conocen, donde se encuentran estrellas masivas y jóvenes.</p>
                <p>Además de las estrellas, la galaxia contiene cúmulos estelares y una gran cantidad de gas en forma de hidrógeno. El gas en la Gran Nube de Magallanes también está involucrado en la formación de nuevas estrellas a medida que colapsa bajo su propia gravedad.</p>
            </div>

            <div class="column">
                <h3>Estructura de la Gran Nube de Magallanes</h3>
                <p>La Gran Nube de Magallanes tiene una estructura irregular, sin una forma definida como las galaxias espirales. Su forma es más difusa y asimétrica, con varios brazos y nubes de gas que se extienden hacia el espacio. A pesar de ser irregular, esta galaxia ha sido una de las principales fuentes de información para los astrónomos sobre la formación y evolución de las galaxias irregulares.</p>
                <ul>
                    <li><strong>El Núcleo:</strong> El núcleo de la Gran Nube de Magallanes está lleno de estrellas viejas y algunas estrellas jóvenes. Es una región densa, pero no es tan concentrado como en las galaxias espirales.</li>
                    <li><strong>Regiones de Formación Estelar:</strong> 30 Doradus, también conocida como la Nebulosa de la Tarántula, es una de las regiones más activas de la galaxia, donde nacen nuevas estrellas debido a la gran cantidad de gas y polvo presente.</li>
                    <li><strong>Interacciones con la Vía Láctea:</strong> La Gran Nube de Magallanes está en una órbita alrededor de la Vía Láctea y se cree que está siendo afectada gravitacionalmente por nuestra galaxia, lo que podría influir en su evolución a largo plazo.</li>
                </ul>
            </div>
        </div>

        <h2>Historia de la Gran Nube de Magallanes</h2>
        <p>La Gran Nube de Magallanes ha sido observada desde tiempos antiguos, pero fue en el siglo XVI, durante los viajes de exploración de Fernando de Magallanes, cuando se documentó por primera vez. Desde entonces, ha sido un objeto de estudio clave para entender la naturaleza de las galaxias irregulares y su relación con la Vía Láctea.</p>
        <p>El estudio de la Gran Nube de Magallanes ha sido vital para los astrónomos que buscan comprender los procesos de formación estelar, ya que es una de las galaxias más cercanas en la que se observan grandes nubes de gas y polvo que son indicativos de la actividad de formación estelar.</p>

        <div class="highlight">
            <p>La Gran Nube de Magallanes es una de las galaxias más cercanas y mejor estudiadas en nuestro vecindario cósmico.</p>
        </div>

        <h2>Datos Curiosos de la Gran Nube de Magallanes</h2>
        <p>Algunos datos interesantes sobre la Gran Nube de Magallanes incluyen:</p>
        <ul>
            <li>La Gran Nube de Magallanes tiene aproximadamente 14,000 años luz de diámetro, lo que la hace una de las galaxias más grandes del Grupo Local.</li>
            <li>La galaxia es una de las principales fuentes de formación estelar en el universo cercano, especialmente en la región de 30 Doradus.</li>
            <li>Es una de las pocas galaxias irregulares cercanas que se puede estudiar con detalle para entender su estructura y evolución.</li>
            <li>La Gran Nube de Magallanes está en una órbita de acoplamiento alrededor de la Vía Láctea, lo que significa que interactúa gravitacionalmente con nuestra galaxia.</li>
        </ul>

        <h2>El Futuro de la Gran Nube de Magallanes</h2>
        <p>En el futuro, la Gran Nube de Magallanes continuará su interacción con la Vía Láctea, y se espera que eventualmente se fusione con nuestra galaxia. Este proceso tomará miles de millones de años, pero podría dar lugar a la formación de nuevas estructuras en el universo.</p>
        <p>Además, se espera que la galaxia siga siendo una fuente clave de estudio para los astrónomos que investigan la formación estelar y la evolución de las galaxias irregulares. La actividad de formación estelar en la Gran Nube de Magallanes ofrecerá nuevas oportunidades para entender cómo se forman las estrellas y los cúmulos estelares en otros rincones del universo.</p>

        <div class="highlight">
            <p>La Gran Nube de Magallanes sigue siendo un objeto fascinante de estudio, con un futuro lleno de descubrimientos y sorpresas.</p>
        </div>

    </section>

    <footer>
        <p>&copy; 2025 Gran Nube de Magallanes. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
