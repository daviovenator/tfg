<?php

$planet_details = [
    'name' => 'Kepler-15b',
    'distance' => '1,400 años luz',
    'radius' => '1.4 veces el de Júpiter',
    'mass' => '1.6 veces la masa de Júpiter',
    'temperature' => '1,300°C',
    'discovered' => '2011',
    'star' => 'Kepler-15',
    'constellation' => 'Cygnus',
    'description' => '
        Kepler-15b es un exoplaneta gigante gaseoso que orbita la estrella Kepler-15, ubicada a unos 1,400 años luz de la Tierra. 
        Tiene un tamaño de 1.4 veces el de Júpiter y una masa 1.6 veces mayor que la de Júpiter. 
        Su atmósfera extremadamente caliente alcanza los 1,300°C, lo que lo hace inhabitable.
    ',
    'orbital_period' => '3.2 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2011',
    'additional_info' => '
        - **Radio**: 1.4 veces el de Júpiter
        - **Masa**: 1.6 veces la masa de Júpiter
        - **Temperatura**: 1,300°C
        - **Distancia desde la Tierra**: 1,400 años luz
        - **Estrella anfitriona**: Kepler-15
        - **Constelación**: Cygnus
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 2011
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
    <img src="../img/exoplanets/kepler-15b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            La temperatura extremadamente alta de Kepler-15b lo hace inhabitado para cualquier tipo de vida tal como la conocemos, 
            pero su estudio sigue siendo importante para entender los planetas gaseosos cercanos a sus estrellas.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
