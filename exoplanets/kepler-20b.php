<?php

$planet_details = [
    'name' => 'Kepler-20b',
    'distance' => '1,000 años luz',
    'radius' => '1.03 veces el de la Tierra',
    'mass' => '1.03 veces la masa de la Tierra',
    'temperature' => '1,500°C',
    'discovered' => '2011',
    'star' => 'Kepler-20',
    'constellation' => 'Lyra',
    'description' => '
        Kepler-20b es un exoplaneta rocoso ubicado a aproximadamente 1,000 años luz de la Tierra. 
        Este planeta tiene un radio de 1.03 veces el de la Tierra y una masa ligeramente mayor que la de nuestro planeta. 
        Kepler-20b es un planeta extremadamente caliente, con temperaturas de hasta 1,500°C debido a su cercanía a su estrella.
    ',
    'orbital_period' => '0.85 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2011',
    'additional_info' => '
        - **Radio**: 1.03 veces el de la Tierra
        - **Masa**: 1.03 veces la masa de la Tierra
        - **Temperatura**: 1,500°C
        - **Distancia desde la Tierra**: 1,000 años luz
        - **Estrella anfitriona**: Kepler-20
        - **Constelación**: Lyra
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
    <img src="../img/exoplanets/kepler-20b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Debido a su alta temperatura, Kepler-20b es un planeta inhóspito para la vida tal como la conocemos. 
            Sin embargo, el estudio de este tipo de planetas nos ayuda a comprender más sobre los exoplanetas rocosos y su interacción con sus estrellas.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
