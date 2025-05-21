<?php

$planet_details = [
    'name' => 'Kepler-26b',
    'distance' => '1,200 años luz',
    'radius' => '1.5 veces el de la Tierra',
    'mass' => '2.2 veces la masa de la Tierra',
    'temperature' => '950°C',
    'discovered' => '2013',
    'star' => 'Kepler-26',
    'constellation' => 'Cygnus',
    'description' => '
        Kepler-26b es un exoplaneta rocoso que orbita la estrella Kepler-26, situada a unos 1,200 años luz de la Tierra. 
        Tiene un radio 1.5 veces mayor que el de la Tierra y una masa 2.2 veces mayor. 
        Su alta temperatura, de aproximadamente 950°C, hace que las condiciones en su superficie sean extremadamente inhóspitas para la vida.
    ',
    'orbital_period' => '2.3 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2013',
    'additional_info' => '
        - **Radio**: 1.5 veces el de la Tierra
        - **Masa**: 2.2 veces la masa de la Tierra
        - **Temperatura**: 950°C
        - **Distancia desde la Tierra**: 1,200 años luz
        - **Estrella anfitriona**: Kepler-26
        - **Constelación**: Cygnus
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
    <img src="../img/exoplanets/kepler-26b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Debido a las altas temperaturas de Kepler-26b, este planeta no sería adecuado para la vida tal como la conocemos. 
            Aun así, su estudio ofrece valiosos conocimientos sobre la formación de planetas rocosos y su comportamiento cercano a sus estrellas.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
