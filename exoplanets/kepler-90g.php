<?php

$planet_details = [
    'name' => 'Kepler-90g',
    'distance' => '2,545 años luz',
    'radius' => '1.2 veces el de la Tierra',
    'mass' => '1.5 veces la masa de la Tierra',
    'temperature' => '450°C',
    'discovered' => '2018',
    'star' => 'Kepler-90',
    'constellation' => 'Dragón',
    'description' => '
        Kepler-90g es un exoplaneta rocoso que forma parte del sistema estelar Kepler-90, ubicado a unos 2,545 años luz de la Tierra. 
        Es un planeta de tamaño similar a la Tierra, pero con una temperatura de alrededor de 450°C, lo que lo hace inhabitable.
    ',
    'orbital_period' => '79.7 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2018',
    'additional_info' => '
        - **Radio**: 1.2 veces el de la Tierra
        - **Masa**: 1.5 veces la masa de la Tierra
        - **Temperatura**: 450°C
        - **Distancia desde la Tierra**: 2,545 años luz
        - **Estrella anfitriona**: Kepler-90
        - **Constelación**: Dragón
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 2018
    ',
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $planet_details['name'] ?></title>
    <link rel="stylesheet" href="../css/exoplanets_style.css">
</head>
<body>
    <header>
        <h1>🌍 Descubre <?= $planet_details['name'] ?></h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/kepler-90g.jpeg" alt="Imagen de <?= $planet_details['name'] ?>">
</div>
<br>        
        <p><strong>Nombre:</strong> <?= $planet_details['name'] ?></p>
        <p><strong>Distancia desde la Tierra:</strong> <?= $planet_details['distance'] ?></p>
        <p><strong>Radio:</strong> <?= $planet_details['radius'] ?></p>
        <p><strong>Masa:</strong> <?= $planet_details['mass'] ?></p>
        <p><strong>Temperatura:</strong> <?= $planet_details['temperature'] ?></p>
        <p><strong>Estrella anfitriona:</strong> <?= $planet_details['star'] ?></p>
        <p><strong>Constelación:</strong> <?= $planet_details['constellation'] ?></p>
        
        <h3>Descripción del planeta</h3>
        <p><?= $planet_details['description'] ?></p>
        
        <h3>Datos adicionales</h3>
        <ul>
            <?php
                // Mostrar la lista de datos adicionales.
                $additional_info = explode("\n", $planet_details['additional_info']);
                foreach ($additional_info as $info) {
                    if (!empty($info)) {
                        echo "<li>$info</li>";
                    }
                }
            ?>
        </ul>

        <h3>Órbita y Composición</h3>
        <p><strong>Período orbital:</strong> <?= $planet_details['orbital_period'] ?></p>
        <p><strong>Método de descubrimiento:</strong> <?= $planet_details['discovery_method'] ?></p>
        <p><strong>Estado de confirmación:</strong> <?= $planet_details['status'] ?></p>
        <p><strong>Año de descubrimiento:</strong> <?= $planet_details['detection_year'] ?></p>

        <h3>Posibilidades de vida</h3>
        <p>
            Kepler-90g es un planeta con una temperatura demasiado alta para albergar vida tal como la conocemos. Su composición rocoso 
            sugiere que podría tener una atmósfera, pero sus condiciones actuales no permiten la vida.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
