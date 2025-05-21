<?php

$planet_details = [
    'name' => 'WASP-12b',
    'distance' => '1,400 años luz',
    'radius' => '1.79 veces el de Júpiter',
    'mass' => '1.4 veces la masa de Júpiter',
    'temperature' => '2,500°C',
    'discovered' => '2008',
    'star' => 'WASP-12',
    'constellation' => 'Auriga',
    'description' => '
        WASP-12b es un exoplaneta extremadamente caliente, que se encuentra a aproximadamente 1,400 años luz de la Tierra, 
        en la constelación de Auriga. Este planeta ha captado la atención de los astrónomos debido a su enorme temperatura 
        y su proximidad a su estrella anfitriona. WASP-12b es un "Júpiter caliente", un gigante gaseoso que orbita muy cerca 
        de su estrella, completando un ciclo orbital en solo 1.1 días. 
        La temperatura en la superficie de WASP-12b alcanza los 2,500°C, lo que lo convierte en uno de los exoplanetas más 
        calientes conocidos hasta la fecha. Debido a su cercanía a su estrella, se cree que WASP-12b tiene una atmósfera 
        distorsionada por la intensa radiación estelar.
    ',
    'orbital_period' => '1.1 días',
    'discovery_method' => 'Tránsito',
    'status' => 'Confirmado',
    'detection_year' => '2008',
    'additional_info' => '
        - **Radio**: 1.79 veces el de Júpiter
        - **Masa**: 1.4 veces la masa de Júpiter
        - **Temperatura**: 2,500°C (aproximadamente)
        - **Distancia desde la Tierra**: 1,400 años luz
        - **Estrella anfitriona**: WASP-12
        - **Constelación**: Auriga
        - **Método de detección**: Tránsito (cuando el planeta pasa frente a su estrella)
        - **Año de descubrimiento**: 2008
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
        <h1>🌍 Descubre WASP-12b</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/wasp-12b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Debido a las extremas condiciones de temperatura y la cercanía de WASP-12b a su estrella, es muy improbable que 
            este planeta tenga condiciones adecuadas para la vida tal como la conocemos. Las temperaturas son tan altas que cualquier 
            forma de vida que se asemeje a la vida en la Tierra no podría sobrevivir en su atmósfera. Sin embargo, el estudio de este 
            planeta ayuda a los científicos a comprender cómo se desarrollan y evolucionan los planetas de tipo "Júpiter caliente".
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
