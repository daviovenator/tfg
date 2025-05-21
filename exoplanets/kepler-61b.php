<?php

$planet_details = [
    'name' => 'Kepler-61b',
    'distance' => '2,700 años luz',
    'radius' => '1.5 veces el de la Tierra',
    'mass' => '2.5 veces la masa de la Tierra',
    'temperature' => '800°C',
    'discovered' => '2012',
    'star' => 'Kepler-61',
    'constellation' => 'Cygnus',
    'description' => '
        Kepler-61b es un exoplaneta que se encuentra a unos 2,700 años luz de la Tierra. 
        Tiene un radio 1.5 veces mayor que el de la Tierra y una masa 2.5 veces más grande. 
        Su temperatura superficial es de aproximadamente 800°C, lo que lo hace inhabitable para la vida tal como la conocemos.
    ',
    'orbital_period' => '13.4 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2012',
    'additional_info' => '
        - **Radio**: 1.5 veces el de la Tierra
        - **Masa**: 2.5 veces la masa de la Tierra
        - **Temperatura**: 800°C
        - **Distancia desde la Tierra**: 2,700 años luz
        - **Estrella anfitriona**: Kepler-61
        - **Constelación**: Cygnus
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 2012
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
    <img src="../img/exoplanets/kepler-61b.webp" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Debido a la alta temperatura de Kepler-61b, este planeta es inhabitable para la vida tal como la conocemos. Sin embargo, su estudio 
            es crucial para entender los planetas en sistemas estelares lejanos y las condiciones extremas en las que pueden existir.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
