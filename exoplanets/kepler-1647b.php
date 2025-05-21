<?php

$planet_details = [
    'name' => 'Kepler-1647b',
    'distance' => '3,700 años luz',
    'radius' => '1.4 veces el de la Tierra',
    'mass' => '1.3 veces la masa de Júpiter',
    'temperature' => '32°C (aproximadamente)',
    'discovered' => '2016',
    'star' => 'Estrella binaria (Kepler-1647)',
    'constellation' => 'Lira',
    'description' => '
        Kepler-1647b es un exoplaneta gigante en la zona habitable de una estrella binaria. 
        Con un tamaño 1.4 veces mayor que la Tierra, y una masa equivalente a 1.3 veces la masa de Júpiter, 
        este planeta orbita alrededor de dos estrellas (un sistema binario) y tiene un período orbital de aproximadamente 1,107 días. 
        La característica más interesante de Kepler-1647b es que su órbita es estable durante milenios, algo inusual para los exoplanetas en sistemas binarios.
    ',
    'orbital_period' => '1,107 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2016',
    'additional_info' => '
        - **Radio**: 1.4 veces el de la Tierra
        - **Masa**: 1.3 veces la masa de Júpiter
        - **Temperatura**: 32°C (aproximadamente)
        - **Distancia desde la Tierra**: 3,700 años luz
        - **Estrella anfitriona**: Sistema binario Kepler-1647
        - **Constelación**: Lira
        - **Método de detección**: Transito
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
        <h1>🌍 Descubre Kepler-1647b</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/kepler-1647b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Aunque Kepler-1647b es un planeta gigante y muy diferente de la Tierra, su ubicación en la zona habitable de una estrella binaria 
            podría permitir condiciones favorables para la vida. A pesar de que las posibilidades de vida tal como la conocemos podrían ser bajas 
            debido a su tamaño y composición, la estabilidad de su órbita durante milenios hace de Kepler-1647b un objeto fascinante para futuras investigaciones.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
