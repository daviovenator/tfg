<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enciclopedia de Dinosaurios</title>
    <link rel="stylesheet" href="css/dino_style.css">
</head>
<body>

    <header>
        <h1>Enciclopedia de Dinosaurios</h1>
        <p>Explora el mundo prehistórico como nunca antes</p>
    </header>

    <nav>
        <ul>
            <li><a href="dinosaurios/carnivoros/carnivoros.php">Carnívoros</a></li>
            <li><a href="dinosaurios/hervivoros/hervivoros.php">Hervívoros</a></li>
            <li><a href="dinosaurios/flora/flora.php">Flora</a></li>
            <li><a href="wiki_espace.php">Wikispace</a></li>
            <li><a href="index.php">Salir</a></li>
        </ul>
    </nav>

    <div class="mensaje-interes">
        <h2>Bienvenido a nuestra pequeña enciclopedia jurásica</h2>
    </div>

    <!-- Carrusel de Imágenes -->
    <div class="slider-container">
        <div class="slider">
            <img src="img/dino1.avif" alt="Dinosaurio 1">
            <img src="img/dino2.avif" alt="Dinosaurio 2">
            <img src="img/dino3.webp" alt="Dinosaurio 3">
            <img src="img/dino4.jpg" alt="Dinosaurio 4">
            <img src="img/dino5.jpg" alt="Dinosaurio 5">
            <img src="img/dino7.jpeg" alt="Dinosaurio 7">
        </div>

        <!-- Contenedor de ascuas -->
        <div id="ascuas-container"></div>

        <!-- Botones para navegar entre las imágenes -->
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
    </div>

<script>
    // JavaScript para el control del slider
    let currentIndex = 0;
    const slides = document.querySelectorAll(".slider img");
    const totalSlides = slides.length;
    const prevButton = document.querySelector(".prev");
    const nextButton = document.querySelector(".next");

    function showSlide(index) {
        if (index >= totalSlides) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = totalSlides - 1;
        } else {
            currentIndex = index;
        }
        const offset = -currentIndex * 100;
        document.querySelector(".slider").style.transform = `translateX(${offset}%)`;
    }

    prevButton.addEventListener("click", () => {
        showSlide(currentIndex - 1);
    });

    nextButton.addEventListener("click", () => {
        showSlide(currentIndex + 1);
    });

    setInterval(() => {
        showSlide(currentIndex + 1);
    }, 7000);

    showSlide(currentIndex);

    // Sistema de Ascuas actualizado
    const ascuaContainer = document.getElementById('ascuas-container');

    function crearAscua() {
        const ascua = document.createElement('div');
        ascua.classList.add('ascua');

        // Posición aleatoria inicial
        ascua.style.left = Math.random() * 100 + '%';
        ascua.style.top = Math.random() * 90 + '%';

        // Tamaño y opacidad aleatoria
        const size = Math.random() * 10 + 5;
        ascua.style.width = size + 'px';
        ascua.style.height = size + 'px';
        ascua.style.opacity = Math.random() * 0.5 + 0.5;

        // Movimiento aleatorio
        const moveX = (Math.random() - 0.5) * 100; // entre -50px y 50px
        const moveY = - (Math.random() * 100 + 50); // siempre hacia arriba

        ascua.style.setProperty('--move-x', `${moveX}px`);
        ascua.style.setProperty('--move-y', `${moveY}px`);

        ascuaContainer.appendChild(ascua);

        // Eliminar ascua después de animación
        setTimeout(() => {
            ascua.remove();
        }, 3000);
    }

    // Crear una ascua cada 1 segundo
    setInterval(crearAscua, 300);
</script>

</body>
</html>
