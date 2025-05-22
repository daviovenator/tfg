<?php

// Lista de carnívoros prehistóricos con sus imágenes locales
$extra_carnivores = [
    "Tyrannosaurus Rex" => "../../img/trex.webp",
    "Allosaurus" => "../../img/allosaurus.webp",
    "Spinosaurus" => "../../img/spinosaurus.webp",
    "Velociraptor" => "../../img/Velociraptor.webp",
    "Carnotaurus" => "../../img/carnotaurus.jpg",
    "Carcharodontosaurus" => "../../img/carcharodontosaurus.jpg",
    "Giganotosaurus" => "../../img/giganotosaurus.jpg",
    "Baryonyx" => "../../img/baryonix.webp",
    "Majungasaurus" => "../../img/Majungasaurus.jpg",
    "Troodon" => "../../img/troodon.jpeg",
    "Deinonychus" => "../../img/Deinonychus.jpg",
    "Mapusaurus" => "../../img/mapusaurus.jpg",
    "Ceratosaurus" => "../../img/ceratosaurus.jpg",
    "Dilophosaurus" => "../../img/dilophosaurus.webp",
    "Herrerasaurus" => "../../img/herrerasaurus.jpg",
    "Dunkleosteus" => "../../img/Dunkleosteus.jpg",
    "Liopleurodon" => "../../img/Liopleurodon.webp",
    "Mosasaurus" => "../../img/mosasaurus.jpg",
    "Pliosaurus" => "../../img/Pliosaurus.jpg",
    "Tylosaurus" => "../../img/tylosaurus.webp",
    "Helicoprion" => "../../img/Helicoprion.webp",
    "Jaekelopterus" => "../../img/Jaekelopterus.webp",
    "Anomalocaris" => "../../img/Anomalocaris.avif",
    "Eurypterus" => "../../img/Eurypterus.jpg",
    "Pterygotus" => "../../img/Pterygotus.jpg",
    "Quetzalcoatlus" => "../../img/quetzalcoatlus.jpg",
    "Dimorphodon" => "../../img/Dimorphodon.webp",
    "Pterodaustro" => "../../img/Pterodaustro.jpg",
    "Postosuchus" => "../../img/postosuchus.jpg",
    "Prestosuchus" => "../../img/Prestosuchus.jpg",
    "Phytosaurios" => "../../img/Phytosaurios.jpg",
    "Therizinosaurus" => "../../img/Therizinosaurus.jpeg",
    "Sinornithosaurus" => "../../img/Sinornithosaurus.webp",
    "Utahraptor" => "../../img/Utahraptor.jpg",
    "Sarchosuchus" => "../../img/Sarcosuchus.webp",
    "Coelophysis" => "../../img/coelophysis.jpg",
    "Oviraptor" => "../../img/Oviraptor.jpeg",
    "Ichthyovenator" => "../../img/Ichthyovenator.webp"
];

// Generar el array de carnívoros
$carnivores = array_map(function ($name, $image) {
    return [
        'name' => $name,
        'image' => $image,
        'url' => strtolower(str_replace(' ', '-', $name)) . '.php'
    ];
}, array_keys($extra_carnivores), $extra_carnivores);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnívoros Prehistóricos</title>
    <link rel="stylesheet" href="../../css/carnivoros_style.css">
</head>
<body>
    <header>
        <a href="../../dino.php">🔙 Volver</a>
    </header>

<!-- Contenedor para el video -->
<div id="video-container">
    <video autoplay loop muted playsinline width="100%" height="500" style="object-fit: cover;">
        <source src="../../img/videoplayback.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>
</div>

    <section>
        <ul>
            <?php foreach ($carnivores as $carnivore): ?>
                <li>
                    <a href="carnivoros/<?= strtolower(urlencode($carnivore['name'])) ?>.php">
                        <strong><?= htmlspecialchars($carnivore['name']) ?></strong>
                        <img src="<?= htmlspecialchars($carnivore['image']) ?>" alt="<?= htmlspecialchars($carnivore['name']) ?>">
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
