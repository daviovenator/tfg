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
    'name' => 'Trappist-1b',
    'distance' => '39.5 años luz',
    'radius' => '1.09 veces el de la Tierra',
    'mass' => '1.2 veces la masa de la Tierra',
    'temperature' => '250°C',
    'discovered' => '2017',
    'star' => 'Trappist-1',
    'constellation' => 'Acuario',
    'description' => '
        Trappist-1b es el planeta más cercano a su estrella en el sistema Trappist-1. 
        Tiene un radio de 1.09 veces el de la Tierra y una masa de 1.2 veces la masa terrestre. 
        La temperatura de la superficie de Trappist-1b es extremadamente alta, alcanzando alrededor de 250°C, 
        lo que sugiere que no es un lugar adecuado para la vida tal como la conocemos. 
        Este planeta es interesante porque forma parte de un sistema con otros planetas en la zona habitable.
    ',
    'orbital_period' => '1.5 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2017',
    'additional_info' => '
        - **Radio**: 1.09 veces el de la Tierra
        - **Masa**: 1.2 veces la masa de la Tierra
        - **Temperatura**: 250°C (aproximadamente)
        - **Distancia desde la Tierra**: 39.5 años luz
        - **Estrella anfitriona**: Trappist-1
        - **Constelación**: Acuario
        - **Método de detección**: Transito
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
        <h1>🌍 Descubre Trappist-1b</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/trappist-1b.png" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Trappist-1b se encuentra demasiado cerca de su estrella, lo que genera temperaturas extremadamente altas 
            que hacen improbable la presencia de vida. Sin embargo, sigue siendo un planeta de interés para la astronomía.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
