<?php

$planet_details = [
    'name' => 'Kepler-18b',
    'distance' => '300 años luz',
    'radius' => '2.0 veces el de la Tierra',
    'mass' => '2.7 veces la masa de la Tierra',
    'temperature' => '−70°C',
    'discovered' => '2012',
    'star' => 'Kepler-18',
    'constellation' => 'Lyra',
    'description' => '
        Kepler-18b es un exoplaneta rocoso que orbita la estrella Kepler-18, ubicada a unos 300 años luz de la Tierra. 
        Este planeta tiene un tamaño de 2.0 veces el de la Tierra y una masa de 2.7 veces la de la Tierra. 
        Su temperatura es extremadamente fría, con valores cercanos a −70°C.
    ',
    'orbital_period' => '3.5 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2012',
    'additional_info' => '
        - **Radio**: 2.0 veces el de la Tierra
        - **Masa**: 2.7 veces la masa de la Tierra
        - **Temperatura**: −70°C
        - **Distancia desde la Tierra**: 300 años luz
        - **Estrella anfitriona**: Kepler-18
        - **Constelación**: Lyra
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
    <img src="../img/exoplanets/kepler-18b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Con su baja temperatura y características, Kepler-18b no parece tener condiciones aptas para la vida tal como la conocemos. 
            Sin embargo, sigue siendo una importante referencia para entender planetas rocosos en zonas frías.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
