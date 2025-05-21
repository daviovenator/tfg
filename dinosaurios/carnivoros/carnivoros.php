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

// Lista de carnívoros prehistóricos con sus imágenes locales
$extra_carnivores = [
    "Tyrannosaurus Rex" => "../../img/trex.webp",
    "Allosaurus" => "../../img/allosaurus.webp",
    "Spinosaurus" => "../../img/spinosaurus.webp",
    "Velociraptor" => "../../img/Velociraptor.webp",
    "Carnotaurus" => "../../img/carnotaurus.jpg",
    "Carcharodontosaurus" => "../../img/carcharodontosaurus.jpg",
    "Giganotosaurus" => "../../img/giganotosaurus.jpg",
    "Baryonyx" => "../../img/baryonix.webp",
    "Majungasaurus" => "../../img/Majungasaurus.jpg",
    "Troodon" => "../../img/troodon.jpeg",
    "Deinonychus" => "../../img/Deinonychus.jpg",
    "Mapusaurus" => "../../img/mapusaurus.jpg",
    "Ceratosaurus" => "../../img/ceratosaurus.jpg",
    "Dilophosaurus" => "../../img/dilophosaurus.webp",
    "Herrerasaurus" => "../../img/herrerasaurus.jpg",
    "Dunkleosteus" => "../../img/Dunkleosteus.jpg",
    "Liopleurodon" => "../../img/Liopleurodon.webp",
    "Mosasaurus" => "../../img/mosasaurus.jpg",
    "Pliosaurus" => "../../img/Pliosaurus.jpg",
    "Tylosaurus" => "../../img/tylosaurus.webp",
    "Helicoprion" => "../../img/Helicoprion.webp",
    "Jaekelopterus" => "../../img/Jaekelopterus.webp",
    "Anomalocaris" => "../../img/Anomalocaris.avif",
    "Eurypterus" => "../../img/Eurypterus.jpg",
    "Pterygotus" => "../../img/Pterygotus.jpg",
    "Quetzalcoatlus" => "../../img/quetzalcoatlus.jpg",
    "Dimorphodon" => "../../img/Dimorphodon.webp",
    "Pterodaustro" => "../../img/Pterodaustro.jpg",
    "Postosuchus" => "../../img/postosuchus.jpg",
    "Prestosuchus" => "../../img/Prestosuchus.jpg",
    "Phytosaurios" => "../../img/Phytosaurios.jpg",
    "Therizinosaurus" => "../../img/Therizinosaurus.jpeg",
    "Sinornithosaurus" => "../../img/Sinornithosaurus.webp",
    "Utahraptor" => "../../img/Utahraptor.jpg",
    "Sarchosuchus" => "../../img/Sarcosuchus.webp",
    "Coelophysis" => "../../img/coelophysis.jpg",
    "Oviraptor" => "../../img/Oviraptor.jpeg",
    "Ichthyovenator" => "../../img/Ichthyovenator.webp"
];

// Generar el array de carnívoros
$carnivores = array_map(function ($name, $image) {
    return [
        'name' => $name,
        'image' => $image,
        'url' => strtolower(str_replace(' ', '-', $name)) . '.php'
    ];
}, array_keys($extra_carnivores), $extra_carnivores);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnívoros Prehistóricos</title>
    <link rel="stylesheet" href="../../css/carnivoros_style.css">
</head>
<body>
    <header>
        <a href="../../dino.php">🔙 Volver</a>
    </header>

<!-- Contenedor para el video -->
<div id="video-container">
    <video autoplay loop muted playsinline width="100%" height="500" style="object-fit: cover;">
        <source src="../../img/videoplayback.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>
</div>

    <section>
        <ul>
            <?php foreach ($carnivores as $carnivore): ?>
                <li>
                    <a href="carnivoros/<?= strtolower(urlencode($carnivore['name'])) ?>.php">
                        <strong><?= htmlspecialchars($carnivore['name']) ?></strong>
                        <img src="<?= htmlspecialchars($carnivore['image']) ?>" alt="<?= htmlspecialchars($carnivore['name']) ?>">
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia de Dinosaurios - © 2025</p>
    </footer>
</body>
</html>
