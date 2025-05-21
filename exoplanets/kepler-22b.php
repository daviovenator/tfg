<?php

$planet_details = [
    'name' => 'Kepler-22b',
    'distance' => '620 años luz',
    'radius' => '2.4 veces el de la Tierra',
    'mass' => '13.8 veces la masa de la Tierra',
    'temperature' => '22°C',
    'discovered' => '2011',
    'star' => 'Kepler-22',
    'constellation' => 'Cygnus',
    'description' => '
        Kepler-22b es un exoplaneta fascinante que se encuentra en la "zona habitable" de su estrella, 
        lo que significa que podría tener agua líquida en su superficie, una condición esencial para la vida tal 
        como la conocemos. Este planeta fue descubierto por el telescopio espacial Kepler, que ha sido clave en la 
        identificación de miles de exoplanetas en las últimas décadas. 
        Con un radio aproximadamente 2.4 veces mayor que el de la Tierra, Kepler-22b es considerado un "super-Tierra", 
        un tipo de exoplaneta más grande que la Tierra, pero que podría compartir algunas de sus características. 
        La estrella Kepler-22, alrededor de la cual orbita el planeta, es una estrella similar al Sol, lo que aumenta 
        las posibilidades de que el planeta tenga condiciones adecuadas para la vida.
        
        Aunque Kepler-22b está demasiado lejos para ser explorado por sondas espaciales, su posición en la zona habitable 
        lo convierte en uno de los objetivos más interesantes en la búsqueda de vida extraterrestre. 
        Los científicos están particularmente interesados en este planeta porque podría ofrecer pistas sobre si existen 
        otros mundos en nuestra galaxia capaces de albergar vida.
    ',
    'orbital_period' => '290 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2011',
    'additional_info' => '
        - **Radio**: 2.4 veces el de la Tierra
        - **Masa**: 13.8 veces la masa de la Tierra
        - **Temperatura**: 22°C (aproximadamente)
        - **Distancia desde la Tierra**: 620 años luz
        - **Estrella anfitriona**: Kepler-22
        - **Constelación**: Cygnus
        - **Método de detección**: Transito (cuando el planeta pasa frente a su estrella)
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
        <h1>🌍 Descubre Kepler-22b</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/kepler-22b.jpeg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Kepler-22b es un exoplaneta que ha generado gran interés debido a su ubicación en la zona habitable de su estrella, 
            una región donde las condiciones podrían permitir la presencia de agua líquida en su superficie. 
            Esto aumenta las expectativas sobre la posibilidad de que el planeta sea capaz de albergar formas de vida. 
            Sin embargo, aún es incierto si el planeta tiene una atmósfera adecuada o si tiene agua en su superficie. 
            La investigación continúa y los astrónomos están realizando simulaciones para comprender mejor las 
            condiciones de este planeta.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
