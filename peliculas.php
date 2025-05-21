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
