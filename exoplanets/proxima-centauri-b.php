<?php
$planet_details = [
    'name' => 'Proxima Centauri b',
    'distance' => '4.24 años luz',
    'radius' => '1.17 veces el de la Tierra',
    'mass' => '1.3 veces la masa de la Tierra',
    'temperature' => 'Temperatura media: -39°C (aproximadamente)',
    'discovered' => '2016',
    'star' => 'Proxima Centauri',
    'constellation' => 'Centaurus',
    'description' => '
        Proxima Centauri b es un exoplaneta que orbita en la zona habitable de la estrella más cercana a nuestro sistema 
        solar, Proxima Centauri, ubicada a unos 4.24 años luz de distancia. Este planeta se encuentra en una región donde 
        las condiciones podrían permitir la presencia de agua líquida, lo que lo convierte en un candidato ideal para la 
        búsqueda de vida extraterrestre. Fue descubierto en 2016 y es uno de los exoplanetas más estudiados debido a su 
        proximidad a la Tierra.
        
        Con un radio aproximadamente 1.17 veces el de la Tierra, Proxima Centauri b es un planeta rocoso que tiene el 
        tamaño adecuado para mantener una atmósfera y agua líquida en su superficie. A pesar de su proximidad, la estrella 
        Proxima Centauri es una enana roja, lo que significa que la radiación que recibe el planeta es mucho mayor que la 
        de la Tierra. Esto podría hacer que las condiciones en su superficie sean hostiles para la vida tal como la conocemos, 
        pero la investigación continúa para determinar la verdadera naturaleza de este planeta.
    ',
    'orbital_period' => '11.2 días',
    'discovery_method' => 'Movimiento radial',
    'status' => 'Confirmado',
    'detection_year' => '2016',
    'additional_info' => '
        - **Radio**: 1.17 veces el de la Tierra
        - **Masa**: 1.3 veces la masa de la Tierra
        - **Temperatura**: -39°C (aproximadamente)
        - **Distancia desde la Tierra**: 4.24 años luz
        - **Estrella anfitriona**: Proxima Centauri
        - **Constelación**: Centaurus
        - **Método de detección**: Movimiento radial
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
        <h1>🌍 Descubre Proxima Centauri b</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/proxima-centauri-b.webp" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Proxima Centauri b es uno de los planetas más fascinantes en términos de habitabilidad debido a su proximidad 
            a la Tierra y su ubicación en la zona habitable de su estrella anfitriona, Proxima Centauri. Aunque la estrella 
            es una enana roja, que emite radiación más intensa que el Sol, la proximidad del planeta a la estrella podría 
            permitir la presencia de agua líquida. Sin embargo, la intensa radiación podría representar un desafío para la vida 
            tal como la conocemos. Los científicos están investigando activamente si Proxima Centauri b tiene una atmósfera 
            protectora que podría ofrecer una oportunidad para la vida.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
