<?php

$planet_details = [
    'name' => 'WASP-43b',
    'distance' => '260 años luz',
    'radius' => '1.6 veces el de Júpiter',
    'mass' => '2.03 veces la masa de Júpiter',
    'temperature' => '2,500°C',
    'discovered' => '2011',
    'star' => 'WASP-43',
    'constellation' => 'Lira',
    'description' => '
        WASP-43b es un exoplaneta gigante gaseoso que orbita una estrella enana roja ubicada a unos 260 años luz de la Tierra. 
        Fue descubierto en 2011 y pertenece a un tipo de exoplanetas conocidos como "Júpiter calientes". Estos planetas son 
        similares a Júpiter, pero se encuentran muy cerca de sus estrellas, lo que les da temperaturas extremadamente altas. 
        Con un radio de 1.6 veces el de Júpiter y una masa de 2.03 veces la de Júpiter, WASP-43b tiene condiciones muy extremas, 
        con temperaturas en su atmósfera que alcanzan los 2,500°C.
    ',
    'orbital_period' => '0.81 días',
    'discovery_method' => 'Transito',
    'status' => 'Confirmado',
    'detection_year' => '2011',
    'additional_info' => '
        - **Radio**: 1.6 veces el de Júpiter
        - **Masa**: 2.03 veces la masa de Júpiter
        - **Temperatura**: 2,500°C (aproximadamente)
        - **Distancia desde la Tierra**: 260 años luz
        - **Estrella anfitriona**: WASP-43
        - **Constelación**: Lira
        - **Método de detección**: Transito (cuando el planeta pasa frente a su estrella)
        - **Año de descubrimiento**: 2011
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
        <h1>🌍 Descubre WASP-43b</h1>
        <a href="../planetas.php">🔙 Volver a la lista de planetas</a>
    </header>

    <section>
        <h2>Información detallada sobre <?= $planet_details['name'] ?></h2>
<div class="planet-image">
    <img src="../img/exoplanets/wasp-43b.jpeg" alt="Imagen de <?= $planet_details['name'] ?>">
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
            Debido a su proximidad extrema a su estrella, WASP-43b tiene temperaturas increíblemente altas en su atmósfera, lo que 
            lo hace inhabitable para la vida tal como la conocemos. Sin embargo, el estudio de este tipo de exoplanetas es clave para 
            entender cómo los planetas gaseosos interactúan con sus estrellas y para descubrir más sobre las condiciones extremas en 
            otros planetas.
        </p>
    </section>

    <footer>
        <p>Enciclopedia del Espacio - © 2025</p>
    </footer>
</body>
</html>
