<?php

$planet_details = [
    'name' => 'Kepler-62f',
    'distance' => '1,200 años luz',
    'radius' => '1.4 veces el de la Tierra',
    'mass' => 'No determinada con exactitud',
    'temperature' => '15°C (aproximadamente)',
    'discovered' => '2013',
    'star' => 'Kepler-62',
    'constellation' => 'Lyra',
    'description' => '
        Kepler-62f es un exoplaneta ubicado en la zona habitable de su estrella, Kepler-62, una enana naranja ubicada 
        a unos 1,200 años luz de la Tierra, en la constelación de Lyra. Este planeta se encuentra en una región donde 
        podría haber agua líquida, lo que lo convierte en un candidato ideal para la búsqueda de vida extraterrestre. 
        Fue descubierto por el telescopio espacial Kepler en 2013 y es uno de los exoplanetas más prometedores en términos 
        de habitabilidad.
        
        Con un radio aproximadamente 1.4 veces mayor que el de la Tierra, Kepler-62f es un "super-Tierra". Aunque no se 
        sabe mucho sobre su composición, se cree que podría tener una atmósfera densa y una superficie rocosa. Las condiciones 
        en este planeta podrían ser adecuadas para albergar vida, aunque aún se desconoce si realmente existen tales condiciones.
        
        Kepler-62f orbita su estrella en 267 días, lo que lo coloca en una órbita estable que podría permitir la presencia 
        de agua en estado líquido. Sin embargo, la falta de información precisa sobre su atmósfera y otras características 
        hace que aún sea un misterio.
    ',
    'orbital_period' => '267 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2013',
    'additional_info' => '
        - **Radio**: 1.4 veces el de la Tierra
        - **Temperatura**: 15°C (aproximadamente)
        - **Distancia desde la Tierra**: 1,200 años luz
        - **Estrella anfitriona**: Kepler-62
        - **Constelación**: Lyra
        - **Método de detección**: Transito
        - **Año de descubrimiento**: 2013
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
        <h1>🌍 Descubre Kepler-62f</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/kepler-62f.jpg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Kepler-62f es un exoplaneta en la zona habitable de su estrella, lo que significa que podría tener agua líquida 
            en su superficie. La posibilidad de que este planeta albergue vida es uno de los temas más intrigantes de la 
            investigación sobre exoplanetas. Sin embargo, aún no se sabe si su atmósfera y condiciones son adecuadas para 
            albergar vida tal como la conocemos. Los astrónomos continúan estudiando este planeta para obtener más información 
            sobre su composición y sus posibilidades para soportar vida.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
