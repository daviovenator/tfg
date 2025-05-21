<?php
$planet_details = [
    'name' => 'Gliese 581g',
    'distance' => '20.3 años luz',
    'radius' => '1.5 veces el de la Tierra',
    'mass' => '3.1 veces la masa de la Tierra',
    'temperature' => 'Temperatura media: 0°C (aproximadamente)',
    'discovered' => '2010',
    'star' => 'Gliese 581',
    'constellation' => 'Libra',
    'description' => '
        Gliese 581g es un exoplaneta ubicado en la zona habitable de la enana roja Gliese 581, a aproximadamente 20.3 años 
        luz de la Tierra. Este planeta se encuentra en una región donde las condiciones podrían ser adecuadas para la existencia 
        de agua líquida, lo que lo convierte en un candidato destacado en la búsqueda de vida extraterrestre. Fue descubierto en 2010 
        y, debido a su proximidad a su estrella, se ha generado gran interés sobre sus características y posibilidades de habitabilidad.
        
        Gliese 581g tiene un radio aproximadamente 1.5 veces el de la Tierra y se estima que su masa es aproximadamente 3.1 veces mayor. 
        Los científicos han especulado que, dado su tamaño y ubicación, este planeta podría ser un "super-Tierra" rocoso con un clima 
        templado, lo que aumentaría las posibilidades de que tenga una atmósfera similar a la de la Tierra.
    ',
    'orbital_period' => '37.6 días',
    'discovery_method' => 'Movimiento radial',
    'status' => 'Confirmado',
    'detection_year' => '2010',
    'additional_info' => '
        - **Radio**: 1.5 veces el de la Tierra
        - **Masa**: 3.1 veces la masa de la Tierra
        - **Temperatura**: 0°C (aproximadamente)
        - **Distancia desde la Tierra**: 20.3 años luz
        - **Estrella anfitriona**: Gliese 581
        - **Constelación**: Libra
        - **Método de detección**: Movimiento radial
        - **Año de descubrimiento**: 2010
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
        <h1>🌍 Descubre Gliese 581g</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/gliese-581g.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Gliese 581g ha sido considerado uno de los mejores candidatos para albergar vida debido a su ubicación en la zona 
            habitable de su estrella anfitriona. Aunque la temperatura media de su superficie podría ser fría, hay especulaciones 
            sobre la existencia de agua líquida, lo que abriría la posibilidad de vida. Sin embargo, la falta de una observación 
            directa sobre la atmósfera del planeta hace que la investigación sobre su habitabilidad continúe siendo un área activa 
            de estudio.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
