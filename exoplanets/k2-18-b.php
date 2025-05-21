<?php

$planet_details = [
    'name' => 'K2-18 b',
    'distance' => '124 años luz',
    'radius' => '2.6 veces el de la Tierra',
    'mass' => '8.6 veces la masa de la Tierra',
    'temperature' => 'Típica de la zona habitable',
    'discovered' => '2015',
    'star' => 'K2-18',
    'constellation' => 'León',
    'description' => '
        K2-18 b es un exoplaneta ubicado a aproximadamente 124 años luz de la Tierra en la constelación de León. Fue descubierto en 2015 y 
        ha sido uno de los exoplanetas más emocionantes debido a que se encuentra en la zona habitable de su estrella, lo que sugiere que podría 
        tener agua líquida en su superficie, una condición esencial para la vida.
        
        Con un radio de aproximadamente 2.6 veces el de la Tierra, K2-18 b es considerado un "super-Tierra" y tiene una masa de 8.6 veces la 
        masa de la Tierra. Aunque su temperatura no se ha confirmado con precisión, su ubicación en la zona habitable sugiere que podría tener 
        condiciones adecuadas para albergar agua líquida en su superficie. K2-18 b es uno de los objetivos principales para futuras misiones 
        espaciales que busquen signos de vida extraterrestre.
    ',
    'orbital_period' => '33.1 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2015',
    'additional_info' => '
        - **Radio**: 2.6 veces el de la Tierra
        - **Masa**: 8.6 veces la masa de la Tierra
        - **Temperatura**: Típica de la zona habitable
        - **Distancia desde la Tierra**: 124 años luz
        - **Estrella anfitriona**: K2-18
        - **Constelación**: León
        - **Método de detección**: Transito (cuando el planeta pasa frente a su estrella)
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
        <h1>🌍 Descubre K2-18 b</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/k2-18-b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Debido a que K2-18 b se encuentra en la zona habitable de su estrella, se considera uno de los exoplanetas más prometedores en 
            términos de la posibilidad de que tenga agua líquida en su superficie. La investigación sobre la atmósfera de este planeta está 
            en curso, y los científicos están particularmente interesados en buscar signos de vida en este mundo distante.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
