<?php
// Lista de herbívoros prehistóricos con sus imágenes locales
$extra_herbivores = [
    "Arandaspis" => "../../img/arandaspis.jpeg",
    "Stegosaurus" => "../../img/Stegosaurus.jpg",
    "Triceratops" => "../../img/Triceratops.jpg",
    "Brachiosaurus" => "../../img/Brachiosaurus.jpg",
    "Apatosaurus" => "../../img/Apatosaurus.webp",
    "Ankylosaurus" => "../../img/Ankylosaurus.jpeg",
    "Iguanodon" => "../../img/Iguanodon.webp",
    "Parasaurolophus" => "../../img/Parasaurolophus.jpg",
    "Edmontosaurus" => "../../img/edmontosaurus.jpg",
    "Camptosaurus" => "../../img/Camptosaurus.webp",
    "Pachycephalosaurus" => "../../img/Pachycephalosaurus.webp",
    "Corythosaurus" => "../../img/Corythosaurus.webp",
    "Diplodocus" => "../../img/Diplodocus.jpg",
    "Sauropelta" => "../../img/Sauropelta.jpg",
    "Gallimimus" => "../../img/Gallimimus.jpg",
    "Euhelopus" => "../../img/euhelopus.jpg",
    "Mamenchisaurus" => "../../img/mamenchisaurus.jpg",
    "Giraffatitan" => "../../img/giraffatitan.jpg",
    "Hypsilophodon" => "../../img/Hypsilophodon.jpg",
    "Plateosaurus" => "../../img/Plateosaurus.webp",
    "Shunosaurus" => "../../img/Shunosaurus.jpg",
    "Leptoceratops" => "../../img/Leptoceratops.jpg",
    "Lambeosaurus" => "../../img/Lambeosaurus.jpg",
    "Eotrachodon" => "../../img/Eotrachodon.webp",
    "Hadrosaurus" => "../../img/Hadrosaurus.jpg",
    "Rhabdodon" => "../../img/Rhabdodon.jpg",
    "Nodosaurus" => "../../img/nodosaurus.jpg",
    "Microceratus" => "../../img/Microceratus.webp",
    "Shantungosaurus" => "../../img/Shantungosaurus.jpeg",
    "Camarasaurus" => "../../img/Camarasaurus.webp",
    "Choyrodon" => "../../img/Choyrodon.jpg",
    "Zalmoxes" => "../../img/Zalmoxes.png",
    "Hesperornis" => "../../img/hesperornis.jpg",
    "Titanosaurus" => "../../img/titanosaurus.jpg",
];

// Generar el array de herbívoros
$herbivores = array_map(function ($name, $image) {
    return [
        'name' => $name,
        'image' => $image,
        'url' => strtolower(str_replace(' ', '-', $name)) . '.php'
    ];
}, array_keys($extra_herbivores), $extra_herbivores);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herbívoros Prehistóricos</title>
    <link rel="stylesheet" href="../../css/herbivoros_style.css">
</head>
<body>
    <header>
        <a href="../../dino.php">🔙 Volver</a>
    </header>

    <!-- Contenedor para el video -->
    <div id="video-container">
        <video autoplay loop muted playsinline width="100%" height="500" style="object-fit: cover;">
            <source src="../../img/hervivoros.mp4" type="video/mp4">
            Tu navegador no soporta el elemento de video.
        </video>
    </div>

    <section>
        <ul>
            <?php foreach ($herbivores as $herbivore): ?>
                <li>
                    <a href="herbivoros/<?= strtolower(urlencode($herbivore['name'])) ?>.php">
                        <strong><?= htmlspecialchars($herbivore['name']) ?></strong>
                        <img src="<?= htmlspecialchars($herbivore['image']) ?>" alt="<?= htmlspecialchars($herbivore['name']) ?>">
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia de Dinosaurios - © 2025</p>
    </footer>
</body>
</html>
