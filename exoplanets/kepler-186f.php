<?php

$planet_details = [
    'name' => 'Kepler-186f',
    'distance' => '500 años luz',
    'radius' => '1.11 veces el de la Tierra',
    'mass' => '1.3 veces la masa de la Tierra',
    'temperature' => '23°C',
    'discovered' => '2014',
    'star' => 'Kepler-186',
    'constellation' => 'Cygnus',
    'description' => '
        Kepler-186f es un exoplaneta notable por ser el primero descubierto que tiene un tamaño similar al de la Tierra 
        y se encuentra en la zona habitable de su estrella. La zona habitable es la región donde las condiciones podrían 
        permitir la existencia de agua líquida, un ingrediente esencial para la vida tal como la conocemos. 
        Descubierto en 2014 por el telescopio espacial Kepler, Kepler-186f está a unos 500 años luz de distancia de la Tierra 
        y orbita la estrella enana roja Kepler-186. Este exoplaneta tiene un radio de aproximadamente 1.11 veces el de la Tierra 
        y se encuentra a una distancia de su estrella que podría permitir temperaturas adecuadas para la vida.
    ',
    'orbital_period' => '130 días',
    'discovery_method' => 'Tránsito',
    'status' => 'Confirmado',
    'detection_year' => '2014',
    'additional_info' => '
        - **Radio**: 1.11 veces el de la Tierra
        - **Masa**: 1.3 veces la masa de la Tierra
        - **Temperatura**: 23°C (aproximadamente)
        - **Distancia desde la Tierra**: 500 años luz
        - **Estrella anfitriona**: Kepler-186
        - **Constelación**: Cygnus
        - **Método de detección**: Tránsito (cuando el planeta pasa frente a su estrella)
        - **Año de descubrimiento**: 2014
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
        <h1>🌍 Descubre Kepler-186f</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/kepler-186f.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Kepler-186f se encuentra en la zona habitable de su estrella, lo que aumenta las posibilidades de que tenga agua líquida 
            en su superficie y, por lo tanto, la posibilidad de albergar vida. Aunque el planeta está a una distancia considerable 
            de la Tierra, su tamaño y ubicación lo convierten en uno de los exoplanetas más interesantes en la búsqueda de vida 
            fuera de nuestro sistema solar. Sin embargo, aún se desconocen muchos detalles sobre su atmósfera y la composición 
            exacta de su superficie, por lo que la investigación continúa.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
