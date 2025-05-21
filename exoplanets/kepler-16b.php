<?php

$planet_details = [
    'name' => 'Kepler-16b',
    'distance' => '200 años luz',
    'radius' => '0.7 veces el de Júpiter',
    'mass' => '0.33 veces la masa de Júpiter',
    'temperature' => '−73°C',
    'discovered' => '2011',
    'star' => 'Kepler-16',
    'constellation' => 'Lira',
    'description' => '
        Kepler-16b es un exoplaneta que orbita un sistema estelar binario, es decir, dos estrellas, a unos 200 años luz de la Tierra. 
        Este planeta es relativamente pequeño en comparación con Júpiter, con un radio de 0.7 veces el de Júpiter. 
        Su temperatura extremadamente fría de alrededor de −73°C lo hace un lugar inhóspito para la vida.
    ',
    'orbital_period' => '229.9 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2011',
    'additional_info' => '
        - **Radio**: 0.7 veces el de Júpiter
        - **Masa**: 0.33 veces la masa de Júpiter
        - **Temperatura**: −73°C
        - **Distancia desde la Tierra**: 200 años luz
        - **Estrella anfitriona**: Kepler-16
        - **Constelación**: Lira
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
    <img src="../img/exoplanets/kepler-16b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Kepler-16b es un planeta muy frío debido a su distancia y características, lo que lo hace inhabitado para la vida tal 
            como la conocemos. A pesar de esto, es fascinante estudiar planetas que orbitan sistemas estelares binarios.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
