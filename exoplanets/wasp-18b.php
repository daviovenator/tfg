<?php

$planet_details = [
    'name' => 'WASP-18b',
    'distance' => '325 años luz',
    'radius' => '1.2 veces el de Júpiter',
    'mass' => '10 veces la masa de Júpiter',
    'temperature' => '2,500°C',
    'discovered' => '2009',
    'star' => 'WASP-18',
    'constellation' => 'Cetus',
    'description' => '
        WASP-18b es un exoplaneta gigante gaseoso extremadamente caliente que orbita su estrella a solo 0.02 AU de distancia. 
        Este planeta tiene un radio 1.2 veces mayor al de Júpiter y una masa 10 veces mayor. 
        Con temperaturas que alcanzan los 2,500°C, WASP-18b es uno de los planetas más calientes conocidos.
    ',
    'orbital_period' => '0.94 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2009',
    'additional_info' => '
        - **Radio**: 1.2 veces el de Júpiter
        - **Masa**: 10 veces la masa de Júpiter
        - **Temperatura**: 2,500°C
        - **Distancia desde la Tierra**: 325 años luz
        - **Estrella anfitriona**: WASP-18
        - **Constelación**: Cetus
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
    <img src="../img/exoplanets/wasp-18b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Con temperaturas extremas de hasta 2,500°C, WASP-18b es un planeta inhabitado para la vida tal como la conocemos. 
            Su proximidad a su estrella y su enorme masa lo hacen un lugar muy hostil.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
