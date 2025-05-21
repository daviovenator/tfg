<?php

$planet_details = [
    'name' => 'GJ 1214b',
    'distance' => '40 años luz',
    'radius' => '2.7 veces el de la Tierra',
    'mass' => '6.5 veces la masa de la Tierra',
    'temperature' => '180°C',
    'discovered' => '2009',
    'star' => 'GJ 1214',
    'constellation' => 'Osa Menor',
    'description' => '
        GJ 1214b es un exoplaneta de tipo supertierra que se encuentra a unos 40 años luz de la Tierra. 
        Su radio es 2.7 veces mayor que el de la Tierra, y su masa es 6.5 veces la masa terrestre. 
        Con una temperatura superficial de 180°C, este planeta podría tener condiciones adecuadas para el agua líquida, 
        lo que lo convierte en un objetivo de gran interés para la búsqueda de vida.
    ',
    'orbital_period' => '1.6 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2009',
    'additional_info' => '
        - **Radio**: 2.7 veces el de la Tierra
        - **Masa**: 6.5 veces la masa de la Tierra
        - **Temperatura**: 180°C
        - **Distancia desde la Tierra**: 40 años luz
        - **Estrella anfitriona**: GJ 1214
        - **Constelación**: Osa Menor
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 2009
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
    <img src="../img/exoplanets/GJ-1214b.png" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Debido a su temperatura superficial de 180°C, GJ 1214b podría ser un lugar interesante para la búsqueda de vida, ya que 
            la presencia de agua líquida es posible. Su estudio sigue siendo un tema activo de investigación.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
