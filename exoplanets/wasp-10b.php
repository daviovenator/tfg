<?php

$planet_details = [
    'name' => 'WASP-10b',
    'distance' => '330 años luz',
    'radius' => '1.2 veces el de Júpiter',
    'mass' => '1.5 veces la masa de Júpiter',
    'temperature' => '1,500°C',
    'discovered' => '2009',
    'star' => 'WASP-10',
    'constellation' => 'Pavo',
    'description' => '
        WASP-10b es un exoplaneta gigante gaseoso que orbita su estrella a una distancia de 330 años luz de la Tierra. 
        Este planeta tiene un radio de 1.2 veces el de Júpiter y una masa de 1.5 veces la de Júpiter. 
        Su temperatura extremadamente alta de 1,500°C lo hace inhabitable para la vida tal como la conocemos, pero su estudio 
        ofrece información valiosa sobre los planetas calientes y sus atmósferas.
    ',
    'orbital_period' => '0.94 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2009',
    'additional_info' => '
        - **Radio**: 1.2 veces el de Júpiter
        - **Masa**: 1.5 veces la masa de Júpiter
        - **Temperatura**: 1,500°C
        - **Distancia desde la Tierra**: 330 años luz
        - **Estrella anfitriona**: WASP-10
        - **Constelación**: Pavo
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 2009
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
    <img src="../img/exoplanets/wasp-10b.webp" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Debido a su cercanía a la estrella, WASP-10b tiene temperaturas extremadamente altas, lo que hace que sea un planeta inhóspito para la vida tal como la conocemos.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
