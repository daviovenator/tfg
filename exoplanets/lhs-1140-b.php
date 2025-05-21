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
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; object-src 'none'; frame-ancestors 'none'; base-uri 'self';");
header("Referrer-Policy: no-referrer");
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Solo si usas HTTPS


$planet_details = [
    'name' => 'LHS 1140 b',
    'distance' => '40.6 años luz',
    'radius' => '1.4 veces el de la Tierra',
    'mass' => '6.6 veces la masa de la Tierra',
    'temperature' => '-20°C',
    'discovered' => '2017',
    'star' => 'LHS 1140',
    'constellation' => 'Cetus',
    'description' => '
        LHS 1140 b es un exoplaneta rocoso ubicado en la zona habitable de su estrella, LHS 1140, que se encuentra 
        a unos 40.6 años luz de la Tierra en la constelación de Cetus. Fue descubierto en 2017 y es uno de los exoplanetas 
        más prometedores para estudiar las atmósferas de planetas en la zona habitable, debido a su tamaño y proximidad 
        a su estrella. LHS 1140 b tiene un radio de aproximadamente 1.4 veces el de la Tierra, y una masa de 6.6 veces 
        la masa de la Tierra, lo que lo clasifica como un "super-Tierra". 
        Con temperaturas que rondan los -20°C, es un planeta frío, pero su ubicación en la zona habitable sugiere que 
        podría tener condiciones adecuadas para la presencia de agua líquida en su superficie.
    ',
    'orbital_period' => '25.4 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2017',
    'additional_info' => '
        - **Radio**: 1.4 veces el de la Tierra
        - **Masa**: 6.6 veces la masa de la Tierra
        - **Temperatura**: -20°C (aproximadamente)
        - **Distancia desde la Tierra**: 40.6 años luz
        - **Estrella anfitriona**: LHS 1140
        - **Constelación**: Cetus
        - **Método de detección**: Transito (cuando el planeta pasa frente a su estrella)
        - **Año de descubrimiento**: 2017
    ',
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $planet_details['name'] ?></title>
    <link rel="stylesheet" href="../css/exoplanets_style.css">
</head>
<body>
    <header>
        <h1>🌍 Descubre LHS 1140 b</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/lhs-1140-b.webp" alt="Imagen de <?= $planet_details['name'] ?>">
</div>
<br>        
        <p><strong>Nombre:</strong> <?= $planet_details['name'] ?></p>
        <p><strong>Distancia desde la Tierra:</strong> <?= $planet_details['distance'] ?></p>
        <p><strong>Radio:</strong> <?= $planet_details['radius'] ?></p>
        <p><strong>Masa:</strong> <?= $planet_details['mass'] ?></p>
        <p><strong>Temperatura:</strong> <?= $planet_details['temperature'] ?></p>
        <p><strong>Estrella anfitriona:</strong> <?= $planet_details['star'] ?></p>
        <p><strong>Constelación:</strong> <?= $planet_details['constellation'] ?></p>
        
        <h3>Descripción del planeta</h3>
        <p><?= $planet_details['description'] ?></p>
        
        <h3>Datos adicionales</h3>
        <ul>
            <?php
                // Mostrar la lista de datos adicionales.
                $additional_info = explode("\n", $planet_details['additional_info']);
                foreach ($additional_info as $info) {
                    if (!empty($info)) {
                        echo "<li>$info</li>";
                    }
                }
            ?>
        </ul>

        <h3>Órbita y Composición</h3>
        <p><strong>Período orbital:</strong> <?= $planet_details['orbital_period'] ?></p>
        <p><strong>Método de descubrimiento:</strong> <?= $planet_details['discovery_method'] ?></p>
        <p><strong>Estado de confirmación:</strong> <?= $planet_details['status'] ?></p>
        <p><strong>Año de descubrimiento:</strong> <?= $planet_details['detection_year'] ?></p>

        <h3>Posibilidades de vida</h3>
        <p>
            Aunque LHS 1140 b es un planeta frío con temperaturas promedio de -20°C, su ubicación en la zona habitable 
            de su estrella sugiere que podría tener agua líquida en su superficie. El hecho de que esté tan cerca de 
            la zona habitable lo convierte en un candidato ideal para futuras misiones de investigación. 
            Si se confirmara la presencia de agua líquida, LHS 1140 b sería un planeta de gran interés en la búsqueda 
            de vida extraterrestre.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
