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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Taquilla de Cine</title>
  <link rel="stylesheet" href="css/pelis_style.css" />
</head>
<body>
  <button class="salir-btn" onclick="salir()">Salir</button>

  <script>
    function salir() {
      if (document.referrer && document.referrer !== window.location.href) {
        history.back();
      } else {
        window.location.href = "hackeo.php";
      }
    }
  </script>

  <header>
    <h1>🎬 Taquilla de Cine</h1>
  </header>

  <main class="container">
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1QKqPAil-pu7NExli9BtCfgWZGvwTvs8C/view?usp=drivesdk" target="_blank">
        <img src="img/Alien.jpg" alt="Alien">
      </a>
      <h2>Alien: Romulus (2024)</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1aqpfl9hIJ8l6Jnro9MJXWdfCeoSpdZjp/view?usp=sharing" target="_blank">
        <img src="img/coraline.jpg" alt="Coraline">
      </a>
      <h2>Coraline y la puerta secreta (2009)</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/13wM-gigBe7sbaFlNX43VQSrhIVUf5oHb/view?usp=sharing" target="_blank">
        <img src="img/Deadpool.webp" alt="Deadpool">
      </a>
      <h2>Deadpool & Wolverine (2024)</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1oTs0ynXUZcsQvpW9YUb0-Cd7F0lUZJAm/view?usp=sharing" target="_blank">
        <img src="img/Novocaine.jpg" alt="Novocaine">
      </a>
      <h2>Novocaine sin dolor (2025)</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1n9evY2mFigyCwSi6BzTw3q9FlOC460fM/view?usp=sharing" target="_blank">
        <img src="img/Lanoviacadaver.webp" alt="La Novia Cadáver">
      </a>
      <h2>La Novia Cadáver</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1sllfy8QCXYMzUFCgHqKk5_qxET5C3z8K/view?usp=sharing" target="_blank">
        <img src="img/isladinosaurios.jpg" alt="Isla de Dinosaurios">
      </a>
      <h2>La Isla de los Dinosaurios (Español)</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1mjtnhPNl0HrC_ntFvwhMV64gyq7AXzfU/view?usp=sharing" target="_blank">
        <img src="img/sonic3.jpg" alt="Sonic 3">
      </a>
      <h2>Sonic 3: La película (2024)</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1eGlGvNDtJvexVxd-VLNeqwhoDW5eKIpY/view?usp=sharing" target="_blank">
        <img src="img/terrifier3.jpeg" alt="Terrifier 3">
      </a>
      <h2>Terrifier 3: Payaso Siniestro (2024)</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/13E3fnEZBC0ChEPKtdGGcTTWQ3Fpn9Zoo/view?usp=sharing" target="_blank">
        <img src="img/venom.webp" alt="Venom">
      </a>
      <h2>Venom: El último baile (2024)</h2>
    </div>
  </main>
</body>
</html>
