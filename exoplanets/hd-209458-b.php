<?php

$planet_details = [
    'name' => 'HD 209458 b',
    'distance' => '150 años luz',
    'radius' => '1.4 veces el de la Tierra',
    'mass' => '0.69 veces la masa de Júpiter',
    'temperature' => '1,200°C',
    'discovered' => '1999',
    'star' => 'HD 209458',
    'constellation' => 'Pegasus',
    'description' => '
        HD 209458 b es un exoplaneta conocido por ser uno de los primeros exoplanetas en mostrar evidencia de atmósfera. 
        Es un planeta de tipo "Júpiter caliente", un tipo de gigante gaseoso que orbita muy cerca de su estrella anfitriona. 
        Fue descubierto en 1999 y se encuentra a una distancia de aproximadamente 150 años luz de la Tierra en la constelación de Pegasus. 
        Este planeta es famoso por tener una atmósfera que ha sido estudiada en detalle debido a la presencia de vapor de agua y otros elementos. 
        Su temperatura extremadamente alta (alrededor de 1,200°C) se debe a su proximidad a su estrella, que lo coloca a una distancia de solo 
        0.047 UA (unidades astronómicas), lo que lo hace un candidato ideal para estudiar las condiciones de los planetas en zonas muy calurosas.
    ',
    'orbital_period' => '3.5 días',
    'discovery_method' => 'Tránsito',
    'status' => 'Confirmado',
    'detection_year' => '1999',
    'additional_info' => '
        - **Radio**: 1.4 veces el de la Tierra
        - **Masa**: 0.69 veces la masa de Júpiter
        - **Temperatura**: 1,200°C (aproximadamente)
        - **Distancia desde la Tierra**: 150 años luz
        - **Estrella anfitriona**: HD 209458
        - **Constelación**: Pegasus
        - **Método de detección**: Tránsito (cuando el planeta pasa frente a su estrella)
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
        <h1>🌍 Descubre HD 209458 b</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/hd-209458-b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Debido a la proximidad de HD 209458 b a su estrella, sus temperaturas extremadamente altas hacen que las condiciones para 
            la vida tal como la conocemos sean imposibles. Sin embargo, el estudio de este planeta ha sido crucial para comprender las 
            atmósferas de los exoplanetas calientes y los posibles procesos atmosféricos en planetas de tipo "Júpiter caliente".
            Los científicos siguen estudiando su atmósfera para obtener más información sobre los exoplanetas de este tipo.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
