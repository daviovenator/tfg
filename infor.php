<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIR - Aprendizaje en Ciberseguridad</title>
    <link rel="stylesheet" href="css/infor_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="matrix"></div> <!-- Fondo animado -->

    <!-- Botón Inicio -->
    <button class="inicio-btn"><a href="hackeo.php">Volver</a></button>

    <h1>Aprende ASIR</h1>

    <div class="section-container">
        <div class="section-box" onclick="location.href='sistemas_operativos.php'" style="cursor: pointer;">
            <h2>Sistemas Operativos</h2>
            <p>Domina Ubuntu y Windows aprendiendo a gestionar usuarios, permisos y redes. Explora Windows Server y DNS.</p>
        </div>
        <div class="section-box" onclick="location.href='desarrollo_web.php'" style="cursor: pointer;">
            <h2>Desarrollo Web</h2>
            <p>Construye páginas con PHP, CSS y JavaScript. Aprende a usar WordPress para crear sitios profesionales.</p>
        </div>
        <div class="section-box" onclick="location.href='base_datos.php'" style="cursor: pointer;">
            <h2>Bases de Datos</h2>
            <p>Administra datos con MySQL y MongoDB. Aprende sobre consultas, modelado y optimización de bases de datos.</p>
        </div>
    </div>

    <footer>
        <p> 2025 ASIR Academy - Ciberseguridad y Desarrollo</p>
    </footer>

    <script src="matrix.js"></script> <!-- Animación Matrix -->
</body>
</html>
