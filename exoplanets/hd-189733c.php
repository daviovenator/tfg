<?php

$planet_details = [
    'name' => 'HD 189733c',
    'distance' => '63 años luz',
    'radius' => '1.13 veces el de Júpiter',
    'mass' => '1.15 veces la masa de Júpiter',
    'temperature' => '1,200°C',
    'discovered' => '2005',
    'star' => 'HD 189733',
    'constellation' => 'Vulpecula',
    'description' => '
        HD 189733c es un exoplaneta gigante gaseoso que orbita una estrella situada a unos 63 años luz de la Tierra. 
        Tiene un radio 1.13 veces mayor que el de Júpiter y una masa 1.15 veces mayor que la de Júpiter. 
        Su temperatura superficial es de aproximadamente 1,200°C, lo que lo convierte en un planeta inhóspito para la vida tal como la conocemos.
    ',
    'orbital_period' => '2.2 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2005',
    'additional_info' => '
        - **Radio**: 1.13 veces el de Júpiter
        - **Masa**: 1.15 veces la masa de Júpiter
        - **Temperatura**: 1,200°C
        - **Distancia desde la Tierra**: 63 años luz
        - **Estrella anfitriona**: HD 189733
        - **Constelación**: Vulpecula
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 2005
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
    <img src="../img/exoplanets/hd-189733c.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Debido a su alta temperatura y su proximidad a su estrella, HD 189733c es un planeta extremadamente inhóspito para la vida tal 
            como la conocemos. Sin embargo, su estudio sigue siendo valioso para entender las condiciones extremas de otros planetas.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
