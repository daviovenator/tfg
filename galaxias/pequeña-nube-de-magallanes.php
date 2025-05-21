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
    <title>Pequeña Nube de Magallanes</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>Pequeña Nube de Magallanes</h1>
        <p>Descubre todo sobre la Pequeña Nube de Magallanes, una galaxia satélite de la Vía Láctea.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>

    <section id="informacion">
        <h2>¿Qué es la Pequeña Nube de Magallanes?</h2>
        <p>La **Pequeña Nube de Magallanes (SMC, por sus siglas en inglés)** es una galaxia satélite irregular de la **Vía Láctea**, ubicada a unos 200,000 años luz de distancia. Junto con la **Gran Nube de Magallanes**, forma parte de un grupo de galaxias cercanas a nuestra propia galaxia. Aunque es más pequeña y menos luminosa que la Gran Nube de Magallanes, la Pequeña Nube de Magallanes es un objeto fascinante para los astrónomos, especialmente por sus características y su proximidad a la Vía Láctea.</p>
        <p>Al igual que su compañera, la Gran Nube de Magallanes, la Pequeña Nube de Magallanes es visible desde el hemisferio sur y se puede observar a simple vista como una nebulosa difusa en el cielo nocturno. También es un buen lugar para estudiar la formación estelar y la evolución de las galaxias irregulares.</p>
        <img src="../img/galaxias/Pequeña-nube-de-magallanes.jpg " alt="Imagen de la Pequeña Nube de Magallanes">
        <div class="highlight">
            <p>La Pequeña Nube de Magallanes es una galaxia irregular y satélite de la Vía Láctea, rica en regiones de formación estelar.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Composición de la Pequeña Nube de Magallanes</h3>
                <p>La Pequeña Nube de Magallanes es una galaxia irregular que contiene una gran cantidad de gas, polvo y estrellas, muchas de ellas jóvenes y en formación. Al igual que la Gran Nube de Magallanes, la Pequeña Nube es muy activa en términos de formación estelar, especialmente en una región conocida como **NGC 346**, que es uno de los cúmulos estelares más jóvenes y brillantes de la galaxia.</p>
                <p>Su composición está dominada por gas y polvo que alimentan la creación de nuevas estrellas. Estas regiones de formación estelar se encuentran principalmente en la periferia de la galaxia, lo que la hace muy interesante para el estudio de los procesos de formación estelar.</p>
            </div>

            <div class="column">
                <h3>Estructura de la Pequeña Nube de Magallanes</h3>
                <p>La Pequeña Nube de Magallanes tiene una estructura irregular y difusa, sin la forma definida de las galaxias espirales. Aunque carece de una forma simétrica, presenta una gran cantidad de regiones de gas y polvo que se agrupan en ciertas áreas. Se compone principalmente de un disco extendido de estrellas y gas, con algunas regiones densas y otras más dispersas.</p>
                <ul>
                    <li><strong>El Cúmulo Estelar NGC 346:</strong> Es uno de los cúmulos más jóvenes y brillantes de la galaxia, compuesto por estrellas muy masivas en formación.</li>
                    <li><strong>Regiones de Formación Estelar:</strong> La Pequeña Nube de Magallanes tiene numerosas regiones de gas donde nacen nuevas estrellas. Estas áreas son de gran interés para los astrónomos debido a la alta tasa de formación estelar que experimentan.</li>
                    <li><strong>Interacciones con la Vía Láctea:</strong> Al igual que la Gran Nube de Magallanes, la Pequeña Nube de Magallanes está en órbita alrededor de la Vía Láctea. Estas interacciones gravitacionales entre las dos galaxias pueden influir en su evolución a lo largo del tiempo.</li>
                </ul>
            </div>
        </div>

        <h2>Historia de la Pequeña Nube de Magallanes</h2>
        <p>La Pequeña Nube de Magallanes ha sido conocida desde hace siglos, pero fue en el siglo XIX cuando se empezó a estudiar más a fondo debido a su proximidad a la Tierra. A lo largo del tiempo, los astrónomos han logrado obtener una gran cantidad de datos sobre su composición, estructura y su papel dentro del Grupo Local de galaxias.</p>
        <p>El estudio de la Pequeña Nube de Magallanes ha sido fundamental para entender cómo las galaxias satélite interactúan con su galaxia madre, como la Vía Láctea, y cómo se forman las estrellas en las galaxias irregulares.</p>

        <div class="highlight">
            <p>La Pequeña Nube de Magallanes es una galaxia irregular cercana, rica en estrellas jóvenes y en formación, lo que la convierte en un objetivo ideal para los estudios de astronomía.</p>
        </div>

        <h2>Datos Curiosos de la Pequeña Nube de Magallanes</h2>
        <p>Algunos datos interesantes sobre la Pequeña Nube de Magallanes incluyen:</p>
        <ul>
            <li>La Pequeña Nube de Magallanes tiene un diámetro de aproximadamente 7,000 años luz, lo que la convierte en una galaxia más pequeña que la Gran Nube de Magallanes.</li>
            <li>Es hogar de una gran cantidad de cúmulos estelares jóvenes, lo que la convierte en una galaxia activa en términos de formación estelar.</li>
            <li>Está a unos 200,000 años luz de la Tierra, y es una de las galaxias más cercanas a la Vía Láctea, lo que facilita su estudio.</li>
            <li>La Pequeña Nube de Magallanes es una de las galaxias más cercanas que no forma parte del grupo principal de la Vía Láctea.</li>
        </ul>

        <h2>El Futuro de la Pequeña Nube de Magallanes</h2>
        <p>Al igual que la Gran Nube de Magallanes, la Pequeña Nube de Magallanes está en una órbita alrededor de la Vía Láctea y se espera que eventualmente se fusione con nuestra galaxia, aunque esto ocurrirá dentro de miles de millones de años. Este proceso podría resultar en una alteración significativa de la estructura de ambas galaxias, pero debido a la gran distancia entre las estrellas, es probable que no haya colisiones directas entre ellas.</p>
        <p>En términos de estudios científicos, la Pequeña Nube de Magallanes seguirá siendo un importante objeto de investigación para comprender cómo las galaxias más pequeñas y satélites evolucionan y cómo se forman las estrellas en condiciones menos concentradas que en las galaxias espirales.</p>

        <div class="highlight">
            <p>La Pequeña Nube de Magallanes es una galaxia fascinante, rica en formación estelar y llena de misterios por descubrir.</p>
        </div>

    </section>

    <footer>
        <p>&copy; 2025 Pequeña Nube de Magallanes. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
