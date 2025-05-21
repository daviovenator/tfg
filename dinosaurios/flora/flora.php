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

// Lista de plantas prehistóricas con sus imágenes locales
$extra_plants = [
    "Lycopodiophyta" => "../../img/Lycopodiophyta(Lycopodios).jpg",
    "Sigillaria" => "../../img/sigillaria.jpg",
    "Calamites" => "../../img/Calamites.jpg",
    "Lepidodendron" => "../../img/Lepidodendron.webp",
    "Psilophyton" => "../../img/Psilophyton.png",
    "Ferns" => "../../img/Ferns(helechos).jpg",
    "Tree ferns" => "../../img/Tree ferns(helechos arbóreos).jpg",
    "Equisetum" => "../../img/Equisetum.jpg",
    "Ginkgophyta" => "../../img/Ginkgophyta (Ginkgo).jpg",
    "Cycads" => "../../img/Cycads (Cícadas).jpg",
    "Conifers" => "../../img/Conifers (Coníferas).jpg",
    "Araucaria" => "../../img/Araucaria.jpg",
    "Sequoia" => "../../img/Sequoia.jpeg",
    "Taxodium" => "../../img/Taxodium.avif",
    "Pinus" => "../../img/Pinus.jpg",
    "Cordaiteae" => "../../img/Cordaiteae.jpg",
    "Pteridosperms" => "../../img/Pteridosperms.png",
    "Glossopteris" => "../../img/Glossopteris.webp",
    "Sphenophyllum" => "../../img/Sphenophyllum.jpeg",
    "Macrophyllum" => "../../img/Macrophyllum.webp",
    "Brachyphyllum" => "../../img/Brachyphyllum.webp",
    "Zamites" => "../../img/Zamites.webp",
    "Podozamites" => "../../img/Podozamites.jpeg",
    "Salvinia" => "../../img/Salvinia.jpg",
    "Nymphaea" => "../../img/Nymphaea.webp",
    "Chara" => "../../img/Chara.jpg",
    "Aldrovanda" => "../../img/Aldrovanda.jpg",
    "Lepidophloios" => "../../img/Lepidophloios.jpg",
    "Rhacophyton" => "../../img/Rhacophyton.jpeg",
    "Ulvophyceae" => "../../img/Ulvophyceae.jpg",
    "Ceratophyllum" => "../../img/Ceratophyllum.webp",
    "Bennettitales" => "../../img/Bennettitales.webp",
    "Angiosperms" => "../../img/Angiosperms.jpg",
    "Eugenia" => "../../img/Eugenia.webp",
    "Algae" => "../../img/Algae.jpg",
    "Cyperaceae" => "../../img/Cyperaceae.jpg"
];

// Generar el array de plantas
$plants = array_map(function ($name, $image) {
    return [
        'name' => $name,
        'image' => $image,
        'url' => strtolower(str_replace(' ', '-', $name)) . '.php'
    ];
}, array_keys($extra_plants), $extra_plants);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plantas Prehistóricas</title>
    <link rel="stylesheet" href="../../css/plantas_style.css">
</head>
<body>
    <header>
        <a href="../../dino.php">🔙 Volver</a>
    </header>

    <!-- Contenedor para el video -->
    <div id="video-container">
        <video autoplay loop muted playsinline width="100%" height="500" style="object-fit: cover;">
            <source src="../../img/plantas.mp4" type="video/mp4">
            Tu navegador no soporta el elemento de video.
        </video>
    </div>

    <section>
        <ul>
            <?php foreach ($plants as $plant): ?>
                <li>
                    <a href="plantas/<?= strtolower(urlencode($plant['name'])) ?>.php">
                        <strong><?= htmlspecialchars($plant['name']) ?></strong>
                        <img src="<?= htmlspecialchars($plant['image']) ?>" alt="<?= htmlspecialchars($plant['name']) ?>">
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia de Plantas Prehistóricas - © 2025</p>
    </footer>
</body>
</html>

