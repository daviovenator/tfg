<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enciclopedia del Espacio</title>
    <link rel="stylesheet" href="css/wikiespace_style.css">
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #00264d;
            text-align: center;
            padding: 50px;
        }

        header h1 {
            font-size: 4rem;
            color: #fff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        header p {
            font-size: 1.5rem;
            color: #fff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        /* Estilos del carrusel de imágenes (Slider) */
        .slider-container {
            position: relative;
            width: 100%;
            height: 300px;  /* Reducir la altura del slider */
            margin: 30px auto;
            overflow: hidden;
        }

        .slider {
            display: flex;
            transition: transform 1s ease;
        }

        .slider img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            flex-shrink: 0; /* Esto asegura que las imágenes no se encojan */
        }

        /* Botones de navegación */
        .prev, .next {
            position: absolute;
            top: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 15px;
            font-size: 18px;
            cursor: pointer;
            border: none;
            transform: translateY(-50%);
            z-index: 1000;
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }

        /* Estilos para el texto atractivo */
        .mensaje-interes h2 {
            text-align: center;
            font-size: 2.5rem;
            color: #FFD700; /* Un color dorado para resaltar */
            font-weight: bold;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
            margin-top: 20px;
        }

        section {
            background: #1a1a1a;
            margin: 20px auto;
            padding: 30px;
            max-width: 900px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 1.1rem;
        }

        section h2 {
            color: #FFD700; /* Color dorado para los títulos */
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-align: center;
        }

        section p {
            color: #fff;
            line-height: 1.8;
            font-size: 1.1rem;
            text-align: justify;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        footer {
            text-align: center;
            background: #00264d;
            color: white;
            padding: 10px;
            margin-top: 20px;
        }

        /* Estilos del menú */
        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            background-color: #333;
            margin: 0;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            padding: 15px;
            display: block;
        }

        nav ul li a:hover {
            background-color: #555;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Enciclopedia del Espacio</h1>
        <p>Explora los misterios del universo como nunca antes</p>
    </header>

    <nav>
        <ul>
            <li><a href="planetas.php">Planetas</a></li>
            <li><a href="estrellas.php">Estrellas</a></li>
            <li><a href="galaxias.php">Galaxias</a></li>
            <li><a href="dino.php">Wikisaurio</a></li>
            <li><a href="hackeo.php">Salir</a></li>
        </ul>
    </nav>
<div class="mensaje-interes">
        <h2>Bienvenido a nuestra pequeña enciclopedia</h2>
    </div>
    <!-- Carrusel de Imágenes -->
    <div class="slider-container">
        <div class="slider">
            <img src="img/img1.jpg" alt="Imagen 1">
            <img src="img/img2.jpg" alt="Imagen 2">
            <img src="img/img7.avif" alt="Imagen 3">
            <img src="img/img4.jpg" alt="Imagen 4">
            <img src="img/img8.avif" alt="Imagen 5">
            <img src="img/img9.avif" alt="Imagen 6">
            <img src="img/img11.avif" alt="Imagen 8">
</div>

        <!-- Botones para navegar entre las imágenes -->
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
    </div>

    <!-- Resto del contenido -->
    <section>
        <h2>Descubre más sobre el cosmos</h2>
        <p>El universo está lleno de maravillas y misterios por descubrir. Desde las galaxias más lejanas hasta los planetas cercanos a nuestro sistema solar, cada rincón del cosmos tiene algo asombroso que ofrecernos. Aquí aprenderás sobre los últimos descubrimientos científicos, los exoplanetas más extraños y algunos datos y curiosidades que probablemente no conocías.</p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>

    <script>
        // JavaScript para el control del slider
        let currentIndex = 0;
        const slides = document.querySelectorAll(".slider img");
        const totalSlides = slides.length;
        const prevButton = document.querySelector(".prev");
        const nextButton = document.querySelector(".next");

        // Función para mostrar la imagen correspondiente al índice
        function showSlide(index) {
            if (index >= totalSlides) {
                currentIndex = 0;
            } else if (index < 0) {
                currentIndex = totalSlides - 1;
            } else {
                currentIndex = index;
            }
            const offset = -currentIndex * 100; // Mueve el carrusel
            document.querySelector(".slider").style.transform = `translateX(${offset}%)`;
        }

        // Acción de los botones de navegación
        prevButton.addEventListener("click", () => {
            showSlide(currentIndex - 1);
        });

        nextButton.addEventListener("click", () => {
            showSlide(currentIndex + 1);
        });

        // Función para deslizar automáticamente cada 7 segundos
        setInterval(() => {
            showSlide(currentIndex + 1);
        }, 7000); // 7 segundos

        // Mostrar la primera imagen
        showSlide(currentIndex);
    </script>

</body>
</html>
