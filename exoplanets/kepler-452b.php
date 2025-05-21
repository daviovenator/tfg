<?php

$planet_details = [
    'name' => 'Kepler-452b',
    'distance' => '1,400 años luz',
    'radius' => '1.6 veces el de la Tierra',
    'mass' => '5 veces la masa de la Tierra',
    'temperature' => '22°C (aproximadamente)',
    'discovered' => '2015',
    'star' => 'Kepler-452',
    'constellation' => 'Cygnus',
    'description' => '
        Kepler-452b es un exoplaneta que ha captado la atención de los científicos debido a su similitud con la Tierra. 
        Situado a aproximadamente 1,400 años luz de distancia, Kepler-452b es el primer planeta encontrado en la zona habitable 
        de una estrella similar al Sol. Con un radio de 1.6 veces el de la Tierra, Kepler-452b es un "super-Tierra" que orbita 
        su estrella en un período de aproximadamente 385 días. Su temperatura estimada es similar a la de la Tierra, lo que 
        ha generado especulaciones sobre su potencial para albergar vida.
    ',
    'orbital_period' => '385 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2015',
    'additional_info' => '
        - **Radio**: 1.6 veces el de la Tierra
        - **Masa**: 5 veces la masa de la Tierra
        - **Temperatura**: 22°C (aproximadamente)
        - **Distancia desde la Tierra**: 1,400 años luz
        - **Estrella anfitriona**: Kepler-452
        - **Constelación**: Cygnus
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 2015
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
        <h1>🌍 Descubre Kepler-452b</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/kepler-452b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Kepler-452b es uno de los planetas más emocionantes para los astrónomos debido a su similitud con la Tierra. 
            Se encuentra en la zona habitable de su estrella, lo que significa que podría tener agua líquida en su superficie. 
            Si bien no se sabe si tiene una atmósfera adecuada para albergar vida, su ubicación lo convierte en un candidato 
            ideal para futuras investigaciones.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
