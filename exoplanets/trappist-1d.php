<?php

$planet_details = [
    'name' => 'TRAPPIST-1d',
    'distance' => '40.2 años luz',
    'radius' => '1.07 veces el de la Tierra',
    'mass' => '1.2 veces la masa de la Tierra',
    'temperature' => 'aproximadamente 20°C',
    'discovered' => '2016',
    'star' => 'TRAPPIST-1',
    'constellation' => 'Acuario',
    'description' => '
        TRAPPIST-1d es uno de los siete exoplanetas descubiertos en 2017 que orbitan la estrella ultrafría TRAPPIST-1, 
        que se encuentra a solo 40 años luz de la Tierra. TRAPPIST-1d es un planeta de tamaño similar a la Tierra, 
        con un radio de aproximadamente 1.07 veces el de nuestro planeta, lo que lo convierte en una posible 
        "super-Tierra". Lo más intrigante de este exoplaneta es su ubicación en la zona habitable de su estrella, 
        lo que significa que podría tener agua líquida en su superficie, una característica crucial para la vida. 
        TRAPPIST-1d tiene una temperatura media de alrededor de 20°C, lo que también lo hace potencialmente habitable. 
        Sin embargo, al igual que con otros exoplanetas, aún hay muchas incógnitas sobre su atmósfera y las condiciones exactas.
    ',
    'orbital_period' => '4.05 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2016',
    'additional_info' => '
        - **Radio**: 1.07 veces el de la Tierra
        - **Masa**: 1.2 veces la masa de la Tierra
        - **Temperatura**: Aproximadamente 20°C
        - **Distancia desde la Tierra**: 40.2 años luz
        - **Estrella anfitriona**: TRAPPIST-1
        - **Constelación**: Acuario
        - **Método de detección**: Transito (cuando el planeta pasa frente a su estrella)
        - **Año de descubrimiento**: 2016
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
        <h1>🌍 Descubre TRAPPIST-1d</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/trappist-1d.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            TRAPPIST-1d se encuentra en la zona habitable de su estrella, lo que podría permitir que tenga agua líquida 
            en su superficie y, por lo tanto, la posibilidad de albergar vida. La estrella TRAPPIST-1 es mucho más fría 
            que el Sol, lo que hace que los planetas en su zona habitable estén a una distancia más corta, lo que 
            permite que las temperaturas sean más adecuadas para la vida tal como la conocemos. Sin embargo, como en 
            el caso de otros exoplanetas, aún se necesitan más observaciones para determinar si realmente tiene una atmósfera 
            adecuada y si puede albergar vida.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
