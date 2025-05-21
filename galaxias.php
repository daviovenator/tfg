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

$galaxies = [
    ["name" => "Andrómeda", "image" => "img/galaxias/andromeda.jpg"],
    ["name" => "Messier 87", "image" => "img/galaxias/messier-87.jpg"],
    ["name" => "NGC 1300", "image" => "img/galaxias/ngc-1300.avif"],
    ["name" => "Sombrero", "image" => "img/galaxias/sombrero.jpg"],
    ["name" => "Ojo Negro", "image" => "img/galaxias/ojo-negro.jpg"],
    ["name" => "Galaxia del Triángulo, M33", "image" => "img/galaxias/M33.jpg"],
    ["name" => "Galaxia del Remolino, M51", "image" => "img/galaxias/M51.jpg"],
    ["name" => "Galaxia de Bode, M81", "image" => "img/galaxias/M81.jpg"],
    ["name" => "Galaxia del Cigarro, M82", "image" => "img/galaxias/M82.jpg"],
    ["name" => "Galaxia de la Escultora, NGC 253", "image" => "img/galaxias/NGC-253.jpg"],
    ["name" => "Galaxia de Centauro A, NGC 5128", "image" => "img/galaxias/NGC-5128.jpg"],
    ["name" => "Galaxia de la Rueda de Carro", "image" => "img/galaxias/Rueda de Carro.jpeg"],
    ["name" => "Galaxia de Barnard, NGC 6822", "image" => "img/galaxias/NGC-6822.jpg"],
    ["name" => "Gran Nube de Magallanes", "image" => "img/galaxias/Gran-nube-de-magallanes.jpg"],
    ["name" => "Pequeña Nube de Magallanes", "image" => "img/galaxias/Pequeña-nube-de-magallanes.jpg"],
    ["name" => "Galaxia del Molinillo Austral, NGC 2997", "image" => "img/galaxias/NGC-2997.jpg"],
    ["name" => "Galaxia de la Tortuga, NGC 3314", "image" => "img/galaxias/NGC-3314.jpg"],
    ["name" => "Galaxia de Hoag", "image" => "img/galaxias/Hoag.jpg"]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galaxias Fascinantes</title>
    <link rel="stylesheet" href="css/galaxias_style.css">
</head>
<body>
    <header id="header">
        <h1>🌌 Galaxias Asombrosas</h1>
        <a class="back-button" href="wiki_espace.php">🔙 Volver a la Enciclopedia</a>
    </header>

    <div id="milky-way">
        <a href="galaxias/via_lactea.php">
            <img src="https://external-preview.redd.it/oluRUXCVMJCCK2Qyg_atG7_MoK5OZF6cKNS6huFsvDQ.jpg?auto=webp&s=9db7738a09770b313c3982a6c6652055f58cd81e" alt="Imagen de la Vía Láctea">
        </a>
    </div>

    <section>
        <h2>Maravillas del Universo</h2>
        <div class="galaxy-cards">
            <?php foreach ($galaxies as $galaxy): ?>
                <div class="card">
                    <a href="galaxias/<?= strtolower(str_replace(' ', '-', $galaxy['name'])) ?>.php">
                        <h3><?= $galaxy['name'] ?></h3>
                        <img src="<?= $galaxy['image'] ?>" alt="<?= $galaxy['name'] ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>

    <script>
        function createAstro(type) {
            const astro = document.createElement("div");
            astro.classList.add("astro");

            if (type === "comet") {
                astro.style.width = "8px";
                astro.style.height = "8px";
                astro.style.background = "linear-gradient(to right, white, transparent)";
                astro.style.boxShadow = "0 0 20px white";
            } else if (type === "star") {
                astro.style.width = "6px";
                astro.style.height = "6px";
                astro.style.background = "yellow";
                astro.style.boxShadow = "0 0 15px yellow";
            }

            const startX = Math.random() * window.innerWidth;
            const startY = Math.random() * window.innerHeight / 2;

            astro.style.left = `${startX}px`;
            astro.style.top = `${startY}px`;

            document.body.appendChild(astro);

            const endX = Math.random() * window.innerWidth;
            const endY = Math.random() * window.innerHeight;

            astro.animate([
                { transform: `translate(0, 0)` },
                { transform: `translate(${endX - startX}px, ${endY - startY}px)` }
            ], {
                duration: Math.random() * 3000 + 2000,
                easing: "ease-in-out",
                iterations: 1
            }).onfinish = () => astro.remove();
        }

        function spawnAstros() {
            const types = ["comet"];
            const randomType = types[Math.floor(Math.random() * types.length)];
            createAstro(randomType);
        }

        setInterval(spawnAstros, 3000);

        let prevScrollpos = window.pageYOffset;
        window.onscroll = function() {
            let currentScrollPos = window.pageYOffset;
            const header = document.getElementById("header");
            const backButton = document.querySelector(".back-button");
            
            if (prevScrollpos > currentScrollPos) {
                header.style.top = "0";
                backButton.style.top = "0";
            } else {
                header.style.top = "-100px";
                backButton.style.top = "-100px";
            }
            prevScrollpos = currentScrollPos;
        }
    </script>
</body>
</html>
