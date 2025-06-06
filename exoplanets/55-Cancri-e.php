<?php
$planet_details = [
    'name' => '55 Cancri e',
    'distance' => '41 años luz',
    'radius' => '1.6 veces el de la Tierra',
    'mass' => '8.0 veces la masa de la Tierra',
    'temperature' => '2,000°C',
    'discovered' => '2004',
    'star' => '55 Cancri',
    'constellation' => 'Cáncer',
    'description' => '
        55 Cancri e es un exoplaneta rocoso que orbita una estrella a unos 41 años luz de la Tierra. 
        Este planeta es conocido por tener una temperatura extremadamente alta de 2,000°C debido a su cercanía con su estrella. 
        Su radio es 1.6 veces el de la Tierra, y su masa es 8.0 veces la masa de la Tierra.
    ',
    'orbital_period' => '0.74 días',
    'discovery_method' => 'Velocidades radiales',
    'status' => 'Confirmado',
    'detection_year' => '2004',
    'additional_info' => '
        - **Radio**: 1.6 veces el de la Tierra
        - **Masa**: 8.0 veces la masa de la Tierra
        - **Temperatura**: 2,000°C
        - **Distancia desde la Tierra**: 41 años luz
        - **Estrella anfitriona**: 55 Cancri
        - **Constelación**: Cáncer
        - **Método de detección**: Velocidades radiales
        - **Año de descubrimiento**: 2004
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
    <img src="../img/exoplanets/55-cancri-e.avif" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Debido a las altas temperaturas que experimenta 55 Cancri e, este planeta es completamente inhóspito para la vida tal como la conocemos. 
            Su estudio es importante para aprender más sobre los planetas rocosos cercanos a sus estrellas.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
