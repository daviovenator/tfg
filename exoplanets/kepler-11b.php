<?php

$planet_details = [
    'name' => 'Kepler-11b',
    'distance' => '2,000 años luz',
    'radius' => '1.1 veces el de la Tierra',
    'mass' => '1.5 veces la masa de la Tierra',
    'temperature' => '25°C',
    'discovered' => '2010',
    'star' => 'Kepler-11',
    'constellation' => 'Cygnus',
    'description' => '
        Kepler-11b es un exoplaneta que orbita una estrella enana amarilla llamada Kepler-11, situada a unos 2,000 años luz de la Tierra. 
        Este planeta tiene un tamaño ligeramente mayor al de la Tierra, con un radio de 1.1 veces el de nuestro planeta. 
        Kepler-11b tiene temperaturas bastante suaves, alrededor de los 25°C, y es uno de los planetas más cercanos a la estrella en su sistema.
    ',
    'orbital_period' => '10.3 días',
    'discovery_method' => 'Tránsito',
    'status' => 'Confirmado',
    'detection_year' => '2010',
    'additional_info' => '
        - Radio: 1.1 veces el de la Tierra
        - Masa: 1.5 veces la masa de la Tierra
        - Temperatura: 25°C
        - Distancia desde la Tierra: 2,000 años luz
        - Estrella anfitriona: Kepler-11
        - Constelación: Cygnus
        - Método de detección: Tránsito
        - Año de descubrimiento: 2010
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
    <style>
        /* Estilo adicional para asegurar que solo el texto después de los dos puntos sea normal */
        .additional-info li {
            font-weight: normal; /* Texto por defecto */
        }
        .additional-info li strong {
            font-weight: bold; /* Solo los títulos en negrita */
        }
    </style>
</head>
<body>
    <header>
        <h1>🌍 Descubre <?= $planet_details['name'] ?></h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section class="details-container">
        <!-- Información del planeta -->
        <div class="planet-info">
<h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/Kepler11b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            <ul class="additional-info">
                <?php
                    // Procesar la lista de datos adicionales para aplicar negrita antes de los dos puntos
                    $additional_info = explode("\n", $planet_details['additional_info']);
                    foreach ($additional_info as $info) {
                        if (!empty($info)) {
                            // Dividir en dos partes: antes y después de los dos puntos
                            $parts = explode(':', $info, 2);
                            if (count($parts) === 2) {
                                echo "<li><strong>" . trim($parts[0]) . ":</strong>" . trim($parts[1]) . "</li>";
                            }
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
                Este planeta tiene una temperatura moderada, pero se encuentra fuera de la zona habitable de su estrella, lo que hace que sea 
                un planeta más difícil para la vida tal como la conocemos. No obstante, su estudio ayuda a aprender más sobre los planetas 
                en sistemas estelares distantes.
            </p>
        </div>

        <!-- Imagen del planeta -->

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
