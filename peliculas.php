<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Deus Films</title>
  <link rel="stylesheet" href="css/pelis_style.css" />
  <style>
    .ascua {
      position: fixed;
      width: 4px;
      height: 4px;
      background: black;
      border-radius: 50%;
      opacity: 0.7;
      pointer-events: none;
      animation: volar 4s linear infinite;
      z-index: 9999;
    }

    @keyframes volar {
      from {
        transform: translate(0, 0);
        opacity: 1;
      }
      to {
        transform: translate(var(--dx), var(--dy));
        opacity: 0;
      }
    }
  </style>
</head>
<body>
  <header class="header">
    <div class="header-content">
      <h1 class="logo">🎬Deus Films😛</h1>
      <input
        type="text"
        id="search-input"
        placeholder="Buscar película..."
        oninput="buscarPeliculas()"
        aria-label="Buscar película"
      />
      <button class="salir-btn" onclick="salir()">Salir</button>
    </div>
  </header>

  <main>
    <section class="slider-section" id="slider-section">
      <h2 class="section-title">Películas de la semana</h2>
      <div class="slider" id="peliculas-semana"></div>
    </section>

    <section class="movies-section">
      <h2 class="section-title">Todas las películas</h2>
      <div class="movies-grid" id="all-movies">
        <!-- Aquí van las películas -->
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1QKqPAil-pu7NExli9BtCfgWZGvwTvs8C/view?usp=drivesdk" target="_blank" rel="noopener">
            <img src="img/Alien.jpg" alt="Alien" />
          </a>
          <h2>Alien: Romulus (2024)</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1aqpfl9hIJ8l6Jnro9MJXWdfCeoSpdZjp/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/coraline.jpg" alt="Coraline" />
          </a>
          <h2>Coraline y la puerta secreta (2009)</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/13wM-gigBe7sbaFlNX43VQSrhIVUf5oHb/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/Deadpool.webp" alt="Deadpool" />
          </a>
          <h2>Deadpool & Wolverine (2024)</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1oTs0ynXUZcsQvpW9YUb0-Cd7F0lUZJAm/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/Novocaine.jpg" alt="Novocaine" />
          </a>
          <h2>Novocaine sin dolor (2025)</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1n9evY2mFigyCwSi6BzTw3q9FlOC460fM/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/Lanoviacadaver.webp" alt="La Novia Cadáver" />
          </a>
          <h2>La Novia Cadáver</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1sllfy8QCXYMzUFCgHqKk5_qxET5C3z8K/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/isladinosaurios.jpg" alt="Isla de Dinosaurios" />
          </a>
          <h2>La Isla de los Dinosaurios (Español)</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1mjtnhPNl0HrC_ntFvwhMV64gyq7AXzfU/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/sonic3.jpg" alt="Sonic 3" />
          </a>
          <h2>Sonic 3: La película (2024)</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1eGlGvNDtJvexVxd-VLNeqwhoDW5eKIpY/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/terrifier3.jpeg" alt="Terrifier 3" />
          </a>
          <h2>Terrifier 3: Payaso Siniestro (2024)</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/13E3fnEZBC0ChEPKtdGGcTTWQ3Fpn9Zoo/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/venom.webp" alt="Venom" />
          </a>
          <h2>Venom: El último baile (2024)</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1Y85nv5rinpc_vazY_nJZrWADP7yIp9cF/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/Minecraft.jpg" alt="Minecraft" />
          </a>
          <h2>Minecraft</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1SWnI_meA75qAIGxaZ6VgGgXoMadkBPnF/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/Aladdin.jpg" alt="Aladdin" />
          </a>
          <h2>Aladdin</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1SjLVwCK7vK66Is0h7-alTuAWB1D3JeeH/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/Angrybirds.webp" alt="Angry Birds" />
          </a>
          <h2>Angry Birds</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1kFYkrgAU9wdVS2Mh4f5cBdGEoibozp-V/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/Bambi.jpg" alt="Bambi" />
          </a>
          <h2>Bambi</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/12Ju4rQOgXVLR4LIt5RyB4I15azlbP9X9/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/Barbie12princesas.jpg" alt="Barbie y las 12 Princesas" />
          </a>
          <h2>Barbie y las 12 Princesas</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1dT9-t9Mdxj5o-4ordSBgF7XX8wqdoI9t/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/Blancanieves.jpeg" alt="Blancanieves" />
          </a>
          <h2>Blancanieves</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/1aWBitkCtJCO78_I6zZPI2OKlsU_jgnvH/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/Cenicienta.jpg" alt="Cenicienta" />
          </a>
          <h2>Cenicienta</h2>
        </div>
        <div class="movie-card">
          <a href="https://drive.google.com/file/d/11OP5nhl7aoAOl1m7RSn3EijZU1kPWzmD/view?usp=sharing" target="_blank" rel="noopener">
            <img src="img/El_principito.jpg" alt="El Principito" />
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
        <img src="img/chihiro.jpg" alt="El Viaje de Chihiro">
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
      <h2>Valiente</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1tXdCzXubt1VtKjhZX0GcdhNKVjM12e7C/view?usp=sharing" target="_blank">
    <img src="img/Cruella.jpg" alt="Cruella">
  </a>
      <h2>Cruella</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1a17va8ZBbRgbH2tnjostzrcDPgCafXvd/view?usp=sharing" target="_blank">
    <img src="img/doraemon.jpg" alt="Doraemon">
  </a>
      <h2>Doraemon y la Revolución de los Robots</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1xP6aRd20FwBYY9MMFUqFxCqiSVKUD5Ze/view?usp=sharing" target="_blank">
    <img src="img/Dumbo.webp" alt="Dumbo">
  </a>
      <h2>Dumbo</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/189SXYLi9Vrw5uQ-QavNiM11UTay1b5Mq/view?usp=sharing" target="_blank">
    <img src="img/gato.jpg" alt="El gato con botas">
  </a>
      <h2>El gato con botas y el último deseo</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1pQ6y9sB9kma2j7WBt4OcnoJAzaOPga53/view?usp=sharing" target="_blank">
    <img src="img/encantada.webp" alt="Encantada">
  </a>
      <h2>Encantada</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1IuhsqdMTDoYWYD68dWS3cD5nkMyhLkhj/view?usp=sharing" target="_blank">
    <img src="img/enredados.jpg" alt="Enredados">
  </a>
      <h2>Enredados</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1ICMVl4-Cejyj46uqdmwZJXK_yTZhomrc/view?usp=sharing" target="_blank">
    <img src="img/frozen.webp" alt="Frozen">
  </a>
      <h2>Frozen</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1JfwYwPxk4HKYb-9n_M1Wl6cDxbw-x4YV/view?usp=sharing" target="_blank">
    <img src="img/monsterhouse.jpg" alt="Monster House">
  </a>
      <h2>Monster House</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1sB08xpCHX64fTW328b0-lkI2kFN3Dobv/view?usp=sharing" target="_blank">
    <img src="img/tarzan.webp" alt="Tarzán">
  </a>
      <h2>Tarzán</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/12H8W5XaQWTAd5N5ysypwGmEWwA0FmQel/view?usp=sharing" target="_blank">
    <img src="img/unmonstruovieneaverme.jpg" alt="Un monstruo viene a verme">
  </a>
      <h2>Un Monstruo Viene a Verme</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1pv9rgJJpBEfMHA7ySP4uZnprnQrTxkml/view?usp=sharing" target="_blank">
    <img src="img/princesayelsapo.jpeg" alt="La princesa y el sapo">
  </a>
      <h2>La Princesa y El Sapo</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/11U5JL30Yo59LWD_mtei93B6tDVsyZg5h/view?usp=sharing" target="_blank">
    <img src="img/lasirenita.avif" alt="La Sirenita">
  </a>
      <h2>La Sirenita</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1G4JMjOq6VFBi8_AAJ1yMEbkcBbSEDf4K/view?usp=sharing" target="_blank">
    <img src="img/losaristogatos.jpg" alt="Los Aristogatos">
  </a>
      <h2>Los Aristogatos</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1NZdlgxm7ChhUT1vtxtu2VveZXjua0t6t/view?usp=sharing" target="_blank">
    <img src="img/malefica.webp" alt="Maléfica">
  </a>
      <h2>Maléfica</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1CQYgPijtZ2_LFwiqbfaxBH3tFN3Si7l5/view?usp=sharing" target="_blank">
    <img src="img/losincreibles.webp" alt="Los Increíbles">
  </a>
      <h2>Los Increíbles</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1F-g_14-s4jzmxHrL53pYf85XQ1gIJDSj/view?usp=sharing" target="_blank">
    <img src="img/monstersuniversity.jpg" alt="Monsters University">
  </a>
      <h2>Monsters University</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1WNTRDTOrhOuYGCDtaQ8j5LFuEWeEDppF/view?usp=sharing" target="_blank">
    <img src="img/mulan.jpg" alt="Mulán">
  </a>
      <h2>Mulán</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1tRUQYXM0lkT0TPlIIBh-HPCQUl56f-Hl/view?usp=sharing" target="_blank">
    <img src="img/pocahontas.jpg" alt="Pocahontas">
  </a>
      <h2>Pocahontas</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1E03MpAsyQyCspJhKrnpWCSncAl5MUz0B/view?usp=sharing" target="_blank">
    <img src="img/ralpheldemoledor.jpg" alt="Ralph el demoledor">
  </a>
      <h2>Ralph El Demoledor</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1AOtD-3oZmJwtqzDTXfhcaWp7UpOLdqZV/view?usp=sharing" target="_blank">
    <img src="img/ratatouille.webp" alt="Ratatouille">
  </a>
      <h2>Ratatouille</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1OguAhmjNjp8WEZ4G0vRq8lWWkG_eARdw/view?usp=sharing" target="_blank">
    <img src="img/spirit.jpg" alt="Spirit">
  </a>
      <h2>Spirit</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1JdO6ApKhoW9vVC2tznRC9luX6CzLGe7Z/view?usp=sharing" target="_blank">
    <img src="img/toystory.jpg" alt="Toy Story">
  </a>
      <h2>Toy Story</h2>
</div>
<div class="movie-card">
  <a href="https://drive.google.com/file/d/1PMhoCndfl-nbhiA9rNpCa9brEJidU_qS/view?usp=sharing" target="_blank">
    <img src="img/up.jpg" alt="Up">
  </a>
      <h2>Up</h2>
</div>

        <!-- ... más películas ... -->
      </div>
      <div class="pagination">
        <button id="prevBtn" onclick="cambiarPagina(-1)">Anterior</button>
        <span id="pageIndicator"></span>
        <button id="nextBtn" onclick="cambiarPagina(1)">Siguiente</button>
      </div>
    </section>
  </main>

  <script>
    const peliculas = Array.from(document.querySelectorAll('#all-movies .movie-card'));
    const sliderSection = document.getElementById('slider-section');
    const sliderContainer = document.getElementById('peliculas-semana');
    const pageIndicator = document.getElementById('pageIndicator');
    const paginationControls = document.querySelector('.pagination');

    let paginaActual = 1;
    const peliculasPorPagina = 30;

    function mostrarPeliculasSemana() {
      sliderContainer.innerHTML = '';
      let copiasPeliculas = peliculas.slice();
      for (let i = 0; i < 7 && copiasPeliculas.length > 0; i++) {
        const idx = Math.floor(Math.random() * copiasPeliculas.length);
        const pelicula = copiasPeliculas.splice(idx, 1)[0];
        const clon = pelicula.cloneNode(true);
        sliderContainer.appendChild(clon);
      }
    }

    function buscarPeliculas() {
      const texto = document.getElementById('search-input').value.toLowerCase();
      let hayResultados = false;

      peliculas.forEach(pelicula => {
        const titulo = pelicula.querySelector('h2').textContent.toLowerCase();
        if (titulo.includes(texto)) {
          pelicula.style.display = 'block';
          hayResultados = true;
        } else {
          pelicula.style.display = 'none';
        }
      });

      if (texto.length > 0) {
        sliderSection.style.display = 'none';
        paginationControls.style.display = 'none';
      } else {
        sliderSection.style.display = 'block';
        paginationControls.style.display = 'flex';
        mostrarPeliculasSemana();
        const paginaGuardada = parseInt(localStorage.getItem('paginaActual')) || 1;
        mostrarPagina(paginaGuardada);
      }
    }

    function mostrarPagina(pagina) {
      const totalPaginas = Math.ceil(peliculas.length / peliculasPorPagina);
      paginaActual = Math.max(1, Math.min(pagina, totalPaginas));
      localStorage.setItem('paginaActual', paginaActual);

      const inicio = (paginaActual - 1) * peliculasPorPagina;
      const fin = inicio + peliculasPorPagina;

      peliculas.forEach((pelicula, index) => {
        pelicula.style.display = (index >= inicio && index < fin) ? 'block' : 'none';
      });

      pageIndicator.textContent = `Página ${paginaActual} de ${totalPaginas}`;
      document.getElementById('prevBtn').style.display = (paginaActual > 1) ? 'inline-block' : 'none';
      document.getElementById('nextBtn').style.display = (paginaActual < totalPaginas) ? 'inline-block' : 'none';
    }

    function cambiarPagina(direccion) {
      mostrarPagina(paginaActual + direccion);
    }

  function salir() {
    window.location.href = 'index.php';
  }
    // Ascuas aleatorias
    function crearAscua() {
      const ascua = document.createElement('div');
      ascua.classList.add('ascua');

      const startX = Math.random() * window.innerWidth;
      const startY = Math.random() * window.innerHeight;
      const dx = (Math.random() - 0.5) * 400 + 'px';
      const dy = (Math.random() - 0.5) * 400 + 'px';

      ascua.style.left = startX + 'px';
      ascua.style.top = startY + 'px';
      ascua.style.setProperty('--dx', dx);
      ascua.style.setProperty('--dy', dy);

      document.body.appendChild(ascua);

      setTimeout(() => ascua.remove(), 4000);
    }

    setInterval(() => {
      for (let i = 0; i < 5; i++) crearAscua();
    }, 300);

    // Inicializar
    window.addEventListener('DOMContentLoaded', () => {
      mostrarPeliculasSemana();
      const paginaGuardada = parseInt(localStorage.getItem('paginaActual')) || 1;
      mostrarPagina(paginaGuardada);
    });
  </script>
</body>
</html>

