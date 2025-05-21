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
    <title>La Galaxia M82 - La Galaxia Cigarro</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>La Galaxia M82 (La Galaxia Cigarro)</h1>
        <p>Descubre todo sobre la Galaxia M82, una galaxia peculiar en forma de cigarro situada cerca de M81.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>

    <section id="informacion">
        <h2>¿Qué es la Galaxia M82?</h2>
        <p>La Galaxia M82, también conocida como NGC 3034 o la Galaxia Cigarro, es una galaxia irregular ubicada a unos 12 millones de años luz de la Tierra, en la constelación de la Osa Mayor. Es famosa por su forma alargada y su actividad de formación estelar extremadamente alta, que le da un aspecto similar a un cigarro, de ahí su nombre.</p>
        <p>M82 es una galaxia peculiar que ha sido estudiada a fondo debido a su intensa actividad en el centro, donde una gran cantidad de gas y polvo están involucrados en procesos de formación estelar. Además, M82 es conocida por ser una galaxia starburst, lo que significa que está experimentando una tasa de formación estelar mucho más alta de lo normal.</p>

        <img src="../img/galaxias/M82.jpg" alt="Imagen de la Galaxia M82">

        <div class="highlight">
            <p>La Galaxia M82 es famosa por su forma alargada y su gran actividad de formación estelar, la cual es producto de la interacción con su vecina, la galaxia M81.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Características de la Galaxia M82</h3>
                <p>La Galaxia M82 es una galaxia de tipo irregular, que presenta una estructura alargada y delgada, parecida a un cigarro. Esta forma se ha originado a partir de una interacción gravitacional con la cercana galaxia M81, lo que ha alterado su estructura. En el centro de M82, hay una región muy activa donde se producen grandes cantidades de nuevas estrellas, lo que la convierte en una galaxia tipo starburst.</p>
                <p>El núcleo de M82 alberga un agujero negro supermasivo y, aunque la galaxia misma no es tan brillante como otras espirales, su actividad en el centro la hace un objeto fascinante para los astrónomos. Además, la galaxia está envuelta en un campo de gas caliente que está siendo expulsado por la intensa actividad en el núcleo, dando lugar a una gran cantidad de material eyectado hacia el espacio exterior.</p>
            </div>

            <div class="column">
                <h3>Interacción con la Galaxia M81</h3>
                <p>La Galaxia M82 se encuentra en una interacción gravitacional con la Galaxia M81, su vecina cercana. Esta interacción ha causado que M82 se distorsione, dándole su forma alargada. La gravedad de M81 ha alterado el gas y el polvo en M82, desencadenando una intensa formación de nuevas estrellas en su núcleo. Este proceso ha convertido a M82 en una de las galaxias más activas en términos de formación estelar.</p>
                <p>Los astrónomos creen que la interacción entre M81 y M82 podría haber disparado la eyección de material desde el centro de M82, lo que resulta en una gran cantidad de gas y polvo expulsado, conocido como "viento galáctico". Este fenómeno es típico en galaxias starburst y proporciona un ambiente muy dinámico y fascinante para el estudio de las galaxias.</p>
            </div>
        </div>

        <h2>Historia del Descubrimiento</h2>
        <p>La Galaxia M82 fue descubierta por el astrónomo William Herschel en 1774. Durante muchos años, se la consideró una galaxia elíptica debido a su forma, pero estudios más detallados revelaron que, a pesar de su aspecto, es una galaxia irregular con una alta tasa de formación estelar. El estudio de M82 se intensificó en el siglo XX cuando los astrónomos comenzaron a estudiar las galaxias de tipo starburst y los procesos involucrados en la formación estelar extrema.</p>
        <p>Además, el telescopio espacial Hubble ha proporcionado imágenes detalladas del centro de M82, mostrando la intensa actividad estelar y la eyección de material desde su núcleo.</p>

        <h2>Datos Curiosos sobre la Galaxia M82</h2>
        <ul>
            <li>La Galaxia M82 está a aproximadamente 12 millones de años luz de la Tierra, lo que la convierte en una de las galaxias más cercanas en el Grupo de Galaxias de la Osa Mayor.</li>
            <li>M82 es una galaxia starburst, lo que significa que está experimentando una tasa de formación estelar mucho mayor que la Vía Láctea.</li>
            <li>El agujero negro supermasivo en el centro de M82 es uno de los más activos, con una alta tasa de material siendo expulsado hacia el espacio.</li>
            <li>La interacción gravitacional con la galaxia M81 ha alterado la estructura de M82, provocando su forma alargada y su actividad estelar extrema.</li>
            <li>M82 es visible con telescopios pequeños y medianos, y es una de las galaxias más estudiadas debido a su singular comportamiento.</li>
        </ul>

        <div class="highlight">
            <p>La Galaxia M82 es un excelente ejemplo de cómo las interacciones galácticas pueden influir en la estructura y la actividad de una galaxia, creando fenómenos estelares fascinantes.</p>
        </div>

        <h2>El Futuro de la Galaxia M82</h2>
        <p>En el futuro, M82 continuará interactuando con M81, lo que podría seguir impulsando la formación de estrellas y la expulsión de material. Sin embargo, debido a que las galaxias están separadas por una gran distancia en términos astronómicos, las interacciones directas entre ellas ocurrirán a una escala muy lenta, probablemente durante miles de millones de años.</p>
        <p>Además, el agujero negro supermasivo en el centro de M82 podría seguir jugando un papel crucial en la dinámica de la galaxia, y su estudio podría proporcionar valiosa información sobre cómo se forman y evolucionan las galaxias activas y las estructuras relacionadas con los agujeros negros.</p>

    </section>

    <footer>
        <p>&copy; 2025 Galaxia M82. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
