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
    <title>NGC 4650A - La Galaxia de la Rueda de Carro</title>
    <link rel="stylesheet" href="../css/galaxiasinfo_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <h1>NGC 4650A - La Galaxia de la Rueda de Carro</h1>
        <p>Descubre todo sobre NGC 4650A, también conocida como la Galaxia de la Rueda de Carro, una galaxia peculiar que presenta una estructura única en forma de rueda.</p>
        <a href="../galaxias.php" class="boton-volver">Volver</a>
    </header>

    <section id="informacion">
        <h2>¿Qué es la Galaxia de la Rueda de Carro?</h2>
        <p>NGC 4650A, conocida como la **Galaxia de la Rueda de Carro**, es una galaxia espiral que se encuentra aproximadamente a unos 140 millones de años luz de distancia, en la constelación de Centaurus. Su nombre proviene de su característica forma de rueda de carro, que es el resultado de una colisión galáctica que le dio su forma peculiar.</p>
        <p>La estructura de la galaxia es una de las más singulares conocidas, con un núcleo brillante rodeado por un anillo externo que recuerda a una rueda de carro. Esta forma es el resultado de una interacción dinámica compleja, probablemente una colisión con una galaxia más pequeña.</p>
        <img src="../img/galaxias/Rueda de Carro.jpeg" alt="Imagen de la Galaxia de la Rueda de Carro (NGC 4650A)">
        <div class="highlight">
            <p>La Galaxia de la Rueda de Carro es famosa por su estructura en anillo, que se formó como consecuencia de una colisión galáctica.</p>
        </div>

        <div class="columns">
            <div class="column">
                <h3>Composición de NGC 4650A</h3>
                <p>La galaxia de la Rueda de Carro tiene una estructura de anillo que la hace destacar entre las galaxias espirales. El núcleo central de la galaxia está rodeado por un anillo exterior que contiene una gran cantidad de estrellas jóvenes, gas y polvo. Este anillo es el resultado de una interacción gravitacional que ocurrió cuando una galaxia más pequeña pasó a través de la galaxia más grande.</p>
                <p>En el interior de la galaxia se observa una gran cantidad de estrellas viejas y una región de formación estelar activa en su anillo externo. La colisión galáctica no solo produjo esta forma de rueda, sino que también estimuló la formación de nuevas estrellas en el anillo exterior.</p>
            </div>

            <div class="column">
                <h3>Estructura de NGC 4650A</h3>
                <p>La estructura de NGC 4650A es muy diferente a la de otras galaxias espirales, debido a la presencia del anillo en forma de rueda. Se puede describir de la siguiente manera:</p>
                <ul>
                    <li><strong>El Núcleo:</strong> En el centro de NGC 4650A se encuentra un núcleo brillante, que contiene una gran cantidad de estrellas viejas y un pequeño agujero negro central. A diferencia de las galaxias espirales típicas, el núcleo no está rodeado por un disco claro, sino que está incrustado dentro de un anillo.</li>
                    <li><strong>El Anillo Externo:</strong> El rasgo más distintivo de la galaxia es el anillo exterior, que es una estructura de estrellas jóvenes, gas y polvo. Este anillo es el resultado de la interacción galáctica que distorsionó la galaxia, creando una forma de rueda.</li>
                    <li><strong>Los Brazos de Anillo:</strong> El anillo que rodea el núcleo tiene una gran cantidad de formación estelar, lo que le da un aspecto de brazo espiral distorsionado. Los brazos del anillo están llenos de estrellas brillantes que emergen de las nubes de gas y polvo que han sido comprimidas durante la colisión.</li>
                </ul>
            </div>
        </div>

        <h2>Historia de NGC 4650A</h2>
        <p>NGC 4650A fue descubierta por el astrónomo John Herschel en 1834, pero fue su peculiar forma de rueda lo que atrajo la atención de los astrónomos modernos. La galaxia de la Rueda de Carro es un excelente ejemplo de cómo las interacciones galácticas pueden modificar radicalmente la forma y la estructura de una galaxia.</p>
        <p>Se cree que la forma de rueda de la galaxia es el resultado de una colisión con una galaxia más pequeña, que causó una onda de choque que recorrió la galaxia, creando el anillo de formación estelar visible hoy. Esta colisión galáctica le dio a NGC 4650A una de las formas más inusuales y estudiadas en la astronomía moderna.</p>

        <div class="highlight">
            <p>La estructura de anillo de NGC 4650A sigue siendo un tema de estudio en astronomía, ya que proporciona información sobre los efectos de las colisiones galácticas en las galaxias.</p>
        </div>

        <h2>Datos Curiosos de NGC 4650A</h2>
        <p>Algunos datos interesantes sobre la Galaxia de la Rueda de Carro:</p>
        <ul>
            <li>El anillo externo de NGC 4650A es una región de intensa formación estelar, lo que significa que el gas y el polvo en el anillo están creando nuevas estrellas a un ritmo relativamente alto.</li>
            <li>La galaxia tiene una apariencia muy similar a la Galaxia del Sombrero (M104), pero con una estructura de anillo mucho más pronunciada.</li>
            <li>Se estima que la colisión galáctica que produjo la forma de rueda ocurrió hace aproximadamente 1 a 2 mil millones de años.</li>
            <li>El anillo de la galaxia tiene un diámetro de aproximadamente 40,000 años luz, mientras que la galaxia completa tiene un diámetro de unos 100,000 años luz.</li>
        </ul>

        <h2>El Futuro de NGC 4650A</h2>
        <p>El futuro de NGC 4650A está íntimamente relacionado con la continua evolución de su anillo exterior y la dinámica interna de la galaxia. En el futuro, la galaxia podría continuar formando nuevas estrellas en su anillo mientras sigue alejándose de la galaxia que causó su colisión original.</p>
        <p>Aunque se espera que el anillo continúe evolucionando, es posible que la forma de rueda se altere con el tiempo debido a futuras interacciones galácticas. La galaxia sigue siendo un objeto clave para estudiar cómo las colisiones galácticas afectan a la estructura y evolución de las galaxias a lo largo del tiempo.</p>

        <div class="highlight">
            <p>NGC 4650A es un ejemplo impresionante de cómo las interacciones entre galaxias pueden dar lugar a formas y estructuras sorprendentes en el universo.</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 NGC 4650A. Todos los derechos reservados. <br>
        Fuente de información: NASA, ESA, y otros estudios astronómicos.</p>
    </footer>
</body>
</html>
