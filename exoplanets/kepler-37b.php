<?php

$planet_details = [
    'name' => 'Kepler-37b',
    'distance' => '210 años luz',
    'radius' => '0.3 veces el de la Tierra',
    'mass' => '0.4 veces la masa de la Tierra',
    'temperature' => '1,200°C',
    'discovered' => '2013',
    'star' => 'Kepler-37',
    'constellation' => 'Lyra',
    'description' => '
        Kepler-37b es un exoplaneta rocoso, el más pequeño encontrado por el telescopio Kepler hasta su descubrimiento. 
        Se encuentra a unos 210 años luz de la Tierra, tiene un radio 0.3 veces el de la Tierra y una masa 0.4 veces menor. 
        Su temperatura alcanza los 1,200°C debido a su proximidad a su estrella anfitriona, lo que lo hace inhabitable.
    ',
    'orbital_period' => '13.3 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2013',
    'additional_info' => '
        - **Radio**: 0.3 veces el de la Tierra
        - **Masa**: 0.4 veces la masa de la Tierra
        - **Temperatura**: 1,200°C
        - **Distancia desde la Tierra**: 210 años luz
        - **Estrella anfitriona**: Kepler-37
        - **Constelación**: Lyra
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 2013
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
    <img src="../img/exoplanets/kepler-37b.jpeg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Kepler-37b tiene una temperatura extremadamente alta que lo hace inhabitable. 
            Sin embargo, su descubrimiento fue crucial para entender la existencia de planetas más pequeños en zonas más cercanas a sus estrellas.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
