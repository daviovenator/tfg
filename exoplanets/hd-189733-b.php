<?php

$planet_details = [
    'name' => 'HD 189733 b',
    'distance' => '63 años luz',
    'radius' => '1.14 veces el de Júpiter',
    'mass' => '1.15 veces la masa de Júpiter',
    'temperature' => '1,000°C',
    'discovered' => '2005',
    'star' => 'HD 189733',
    'constellation' => 'Virgo',
    'description' => '
        HD 189733 b es un exoplaneta que orbita una estrella enana naranja ubicada a unos 63 años luz de la Tierra, en la constelación 
        de Virgo. Descubierto en 2005, este planeta ha sido objeto de mucha atención debido a su ambiente extremo y sus altas temperaturas. 
        Con un radio de aproximadamente 1.14 veces el de Júpiter y una masa de 1.15 veces la de Júpiter, se trata de un gigante gaseoso. 
        La temperatura en su atmósfera alcanza unos 1,000°C, lo que lo convierte en un lugar inhóspito para la vida tal como la conocemos.
    ',
    'orbital_period' => '2.2 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2005',
    'additional_info' => '
        - **Radio**: 1.14 veces el de Júpiter
        - **Masa**: 1.15 veces la masa de Júpiter
        - **Temperatura**: 1,000°C (aproximadamente)
        - **Distancia desde la Tierra**: 63 años luz
        - **Estrella anfitriona**: HD 189733
        - **Constelación**: Virgo
        - **Método de detección**: Transito (cuando el planeta pasa frente a su estrella)
        - **Año de descubrimiento**: 2005
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
        <h1>🌍 Descubre HD 189733 b</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/hd-189733-b.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Aunque HD 189733 b está extremadamente caliente debido a su proximidad a su estrella, y su atmósfera tiene condiciones muy 
            hostiles para la vida tal como la conocemos, el estudio de este exoplaneta ha proporcionado una gran cantidad de información 
            sobre los exoplanetas de tipo Júpiter caliente. La investigación sobre su atmósfera y condiciones extremas sigue siendo 
            relevante para comprender mejor los planetas gaseosos en el universo.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
