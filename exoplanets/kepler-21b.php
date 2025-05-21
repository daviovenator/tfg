<?php

$planet_details = [
    'name' => 'Kepler-21b',
    'distance' => '400 años luz',
    'radius' => '1.6 veces el de la Tierra',
    'mass' => '2.6 veces la masa de la Tierra',
    'temperature' => '1,000°C',
    'discovered' => '2012',
    'star' => 'Kepler-21',
    'constellation' => 'Cygnus',
    'description' => '
        Kepler-21b es un exoplaneta rocoso ubicado a unos 400 años luz de la Tierra. 
        Este planeta es más grande que la Tierra, con un radio 1.6 veces mayor y una masa 2.6 veces mayor que la de la Tierra. 
        A pesar de su tamaño, Kepler-21b tiene temperaturas extremadamente altas debido a su proximidad a su estrella.
    ',
    'orbital_period' => '1.5 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2012',
    'additional_info' => '
        - **Radio**: 1.6 veces el de la Tierra
        - **Masa**: 2.6 veces la masa de la Tierra
        - **Temperatura**: 1,000°C
        - **Distancia desde la Tierra**: 400 años luz
        - **Estrella anfitriona**: Kepler-21
        - **Constelación**: Cygnus
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 2012
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
    <img src="../img/exoplanets/kepler-21b.webp" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Las altas temperaturas de Kepler-21b lo hacen inhabitado para la vida tal como la conocemos, 
            pero su estudio es valioso para comprender cómo los planetas rocosos se comportan cerca de sus estrellas.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
