<?php

$planet_details = [
    'name' => 'Trappist-1c',
    'distance' => '39.5 años luz',
    'radius' => '1.06 veces el de la Tierra',
    'mass' => '1.7 veces la masa de la Tierra',
    'temperature' => '130°C',
    'discovered' => '2017',
    'star' => 'Trappist-1',
    'constellation' => 'Acuario',
    'description' => '
        Trappist-1c es otro planeta del sistema Trappist-1 que se encuentra en la zona habitable de su estrella. 
        Tiene un radio de 1.06 veces el de la Tierra y una masa de 1.7 veces la masa de la Tierra. 
        La temperatura en su superficie es más moderada en comparación con Trappist-1b, pero aún podría ser demasiado 
        cálida para la vida. La ubicación de este planeta en la zona habitable es uno de los aspectos más interesantes 
        para los astrónomos.
    ',
    'orbital_period' => '2.4 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2017',
    'additional_info' => '
        - **Radio**: 1.06 veces el de la Tierra
        - **Masa**: 1.7 veces la masa de la Tierra
        - **Temperatura**: 130°C (aproximadamente)
        - **Distancia desde la Tierra**: 39.5 años luz
        - **Estrella anfitriona**: Trappist-1
        - **Constelación**: Acuario
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 2017
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
        <h1>🌍 Descubre Trappist-1c</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/trappist-1c.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Aunque Trappist-1c se encuentra en la zona habitable, su temperatura sigue siendo demasiado alta, 
            lo que puede hacer improbable que sea habitable. Aun así, su estudio proporciona valiosa información sobre 
            las condiciones que podrían ser adecuadas para la vida.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
