<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Deus Films</title>
  <link rel="stylesheet" href="css/pelis_style.css" />
</head>
<body>
  <header class="top-bar">
    <button class="salir-btn" onclick="salir()">Salir</button>
    <h1>🎬Deus Films😛</h1>
    <input type="text" id="search-input" placeholder="Buscar película..." oninput="buscarPeliculas()" />
  </header>

  <main class="container">
    <!-- Películas -->
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
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1Y85nv5rinpc_vazY_nJZrWADP7yIp9cF/view?usp=sharing" target="_blank">
        <img src="img/Minecraft.jpg" alt="Minecraft">
      </a>
      <h2>Minecraft</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1SWnI_meA75qAIGxaZ6VgGgXoMadkBPnF/view?usp=sharing" target="_blank">
        <img src="img/Aladdin.jpg" alt="Aladdin">
      </a>
      <h2>Aladdin</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1SjLVwCK7vK66Is0h7-alTuAWB1D3JeeH/view?usp=sharing" target="_blank">
        <img src="img/Angrybirds.webp" alt="Angry Birds">
      </a>
      <h2>Angry Birds</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1kFYkrgAU9wdVS2Mh4f5cBdGEoibozp-V/view?usp=sharing" target="_blank">
        <img src="img/Bambi.jpg" alt="Bambi">
      </a>
      <h2>Bambi</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/12Ju4rQOgXVLR4LIt5RyB4I15azlbP9X9/view?usp=sharing" target="_blank">
        <img src="img/Barbie12princesas.jpg" alt="Barbie y las 12 Princesas">
      </a>
      <h2>Barbie y las 12 Princesas</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1dT9-t9Mdxj5o-4ordSBgF7XX8wqdoI9t/view?usp=sharing" target="_blank">
        <img src="img/Blancanieves.jpeg" alt="Blancanieves">
      </a>
      <h2>Blancanieves</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1aWBitkCtJCO78_I6zZPI2OKlsU_jgnvH/view?usp=sharing" target="_blank">
        <img src="img/Cenicienta.jpg" alt="Cenicienta">
      </a>
      <h2>Cenicienta</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/11OP5nhl7aoAOl1m7RSn3EijZU1kPWzmD/view?usp=sharing" target="_blank">
        <img src="img/El_principito.jpg" alt="El Principito">
      </a>
      <h2>El Principito</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1yuCNyy3qgECw7ZFz8Al_gzFIim4gKaLE/view?usp=sharing" target="_blank">
        <img src="img/reyleon.jpg" alt="El Rey León">
      </a>
      <h2>El Rey León</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1Z-tjtjfZhxPcJPkU3f9PQ37jW0pOTph0/view?usp=sharing" target="_blank">
        <img src="img/viajedechihiro.jpg" alt="El Viaje de Chihiro">
      </a>
      <h2>El Viaje de Chihiro</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/176wRxX3EJKJHyuEM4BKuyKo5xQlJVW-N/view?usp=sharing" target="_blank">
        <img src="img/bellaylabestia.jpg" alt="La Bella y la Bestia">
      </a>
      <h2>La Bella y la Bestia</h2>
    </div>
    <div class="movie-card">
      <a href="https://drive.google.com/file/d/1NfIYFzbrBcPh_SExXFATtw2IGPmCTcFf/view?usp=sharing" target="_blank">
        <img src="img/angrybirds2.jpg" alt="Angry Birds 2">
      </a>
      <h2>Angry Birds 2</h2>
    </div>
    <div class="movie-card">
  <a href="https://drive.google.com/file/d/1xba3t-mZyE8iaxJAstb-_H8TbR9rOosq/view?usp=sharing" target="_blank">
    <img src="img/valiente.webp" alt="Valiente">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1tXdCzXubt1VtKjhZX0GcdhNKVjM12e7C/view?usp=sharing" target="_blank">
    <img src="img/cruella.jpg" alt="Cruella">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1a17va8ZBbRgbH2tnjostzrcDPgCafXvd/view?usp=sharing" target="_blank">
    <img src="img/doraemon.jpg" alt="Doraemon">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1xP6aRd20FwBYY9MMFUqFxCqiSVKUD5Ze/view?usp=sharing" target="_blank">
    <img src="img/dumbo.jpg" alt="Dumbo">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/189SXYLi9Vrw5uQ-QavNiM11UTay1b5Mq/view?usp=sharing" target="_blank">
    <img src="img/gatoconbotas.jpg" alt="El gato con botas">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1pQ6y9sB9kma2j7WBt4OcnoJAzaOPga53/view?usp=sharing" target="_blank">
    <img src="img/encantada.webp" alt="Encantada">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1IuhsqdMTDoYWYD68dWS3cD5nkMyhLkhj/view?usp=sharing" target="_blank">
    <img src="img/enredados.jpg" alt="Enredados">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1ICMVl4-Cejyj46uqdmwZJXK_yTZhomrc/view?usp=sharing" target="_blank">
    <img src="img/frozen.webp" alt="Frozen">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1JfwYwPxk4HKYb-9n_M1Wl6cDxbw-x4YV/view?usp=sharing" target="_blank">
    <img src="img/monsterhouse.jpg" alt="Monster House">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1sB08xpCHX64fTW328b0-lkI2kFN3Dobv/view?usp=sharing" target="_blank">
    <img src="img/tarzan.webp" alt="Tarzán">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/12H8W5XaQWTAd5N5ysypwGmEWwA0FmQel/view?usp=sharing" target="_blank">
    <img src="img/unmonstruovieneaverme.jpg" alt="Un monstruo viene a verme">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1pv9rgJJpBEfMHA7ySP4uZnprnQrTxkml/view?usp=sharing" target="_blank">
    <img src="img/princesayelsapo.jpeg" alt="La princesa y el sapo">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/11U5JL30Yo59LWD_mtei93B6tDVsyZg5h/view?usp=sharing" target="_blank">
    <img src="img/lasirenita.avif" alt="La Sirenita">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1G4JMjOq6VFBi8_AAJ1yMEbkcBbSEDf4K/view?usp=sharing" target="_blank">
    <img src="img/losaristogatos.jpg" alt="Los Aristogatos">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1NZdlgxm7ChhUT1vtxtu2VveZXjua0t6t/view?usp=sharing" target="_blank">
    <img src="img/malefica.webp" alt="Maléfica">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1CQYgPijtZ2_LFwiqbfaxBH3tFN3Si7l5/view?usp=sharing" target="_blank">
    <img src="img/losincreibles.webp" alt="Los Increíbles">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1F-g_14-s4jzmxHrL53pYf85XQ1gIJDSj/view?usp=sharing" target="_blank">
    <img src="img/monstersuniversity.jpg" alt="Monsters University">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1WNTRDTOrhOuYGCDtaQ8j5LFuEWeEDppF/view?usp=sharing" target="_blank">
    <img src="img/mulan.jpg" alt="Mulán">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1tRUQYXM0lkT0TPlIIBh-HPCQUl56f-Hl/view?usp=sharing" target="_blank">
    <img src="img/pocahontas.jpg" alt="Pocahontas">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1E03MpAsyQyCspJhKrnpWCSncAl5MUz0B/view?usp=sharing" target="_blank">
    <img src="img/ralpheldemoledor.jpg" alt="Ralph el demoledor">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1AOtD-3oZmJwtqzDTXfhcaWp7UpOLdqZV/view?usp=sharing" target="_blank">
    <img src="img/ratatouille.webp" alt="Ratatouille">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1OguAhmjNjp8WEZ4G0vRq8lWWkG_eARdw/view?usp=sharing" target="_blank">
    <img src="img/spirit.jpg" alt="Spirit">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1JdO6ApKhoW9vVC2tznRC9luX6CzLGe7Z/view?usp=sharing" target="_blank">
    <img src="img/toystory.jpg" alt="Toy Story">
  </a>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1PMhoCndfl-nbhiA9rNpCa9brEJidU_qS/view?usp=sharing" target="_blank">
    <img src="img/up.jpg" alt="Up">
  </a>
</div>
  </main>

  <script>
    function salir() {
      if (document.referrer && document.referrer !== window.location.href) {
        history.back();
      } else {
        window.location.href = "index.php";
      }
    }

    function buscarPeliculas() {
      const input = document.getElementById("search-input").value.toLowerCase();
      const cards = document.querySelectorAll(".movie-card");

      cards.forEach(card => {
        const title = card.querySelector("h2").textContent.toLowerCase();
        card.style.display = title.includes(input) ? "block" : "none";
      });
    }
  </script>
</body>
</html>

