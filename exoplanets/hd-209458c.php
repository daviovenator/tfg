<?php

$planet_details = [
    'name' => 'HD 209458c',
    'distance' => '150 años luz',
    'radius' => '1.38 veces el de Júpiter',
    'mass' => '1.38 veces la masa de Júpiter',
    'temperature' => '1,000°C',
    'discovered' => '1999',
    'star' => 'HD 209458',
    'constellation' => 'Pegasus',
    'description' => '
        HD 209458c es un exoplaneta gigante gaseoso que orbita una estrella a aproximadamente 150 años luz de la Tierra. 
        Tiene un radio 1.38 veces mayor que el de Júpiter y una masa 1.38 veces mayor que la de Júpiter. 
        Su temperatura superficial es de alrededor de 1,000°C, lo que lo convierte en un planeta inhóspito para la vida.
    ',
    'orbital_period' => '3.5 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '1999',
    'additional_info' => '
        - **Radio**: 1.38 veces el de Júpiter
        - **Masa**: 1.38 veces la masa de Júpiter
        - **Temperatura**: 1,000°C
        - **Distancia desde la Tierra**: 150 años luz
        - **Estrella anfitriona**: HD 209458
        - **Constelación**: Pegasus
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 1999
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
    <img src="../img/exoplanets/hd-209458c.webp" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Al igual que otros exoplanetas cercanos a sus estrellas, HD 209458c tiene condiciones extremadamente inhóspitas para la vida tal como la conocemos, 
            pero su estudio sigue siendo esencial para comprender mejor las condiciones de los planetas en sistemas lejanos.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
