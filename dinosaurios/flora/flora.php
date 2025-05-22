<?php
// Lista de plantas prehistóricas con sus imágenes locales
$extra_plants = [
    "Lycopodiophyta" => "../../img/Lycopodiophyta(Lycopodios).jpg",
    "Sigillaria" => "../../img/sigillaria.jpg",
    "Calamites" => "../../img/Calamites.jpg",
    "Lepidodendron" => "../../img/Lepidodendron.webp",
    "Psilophyton" => "../../img/Psilophyton.png",
    "Ferns" => "../../img/Ferns(helechos).jpg",
    "Tree ferns" => "../../img/Tree ferns(helechos arbóreos).jpg",
    "Equisetum" => "../../img/Equisetum.jpg",
    "Ginkgophyta" => "../../img/Ginkgophyta (Ginkgo).jpg",
    "Cycads" => "../../img/Cycads (Cícadas).jpg",
    "Conifers" => "../../img/Conifers (Coníferas).jpg",
    "Araucaria" => "../../img/Araucaria.jpg",
    "Sequoia" => "../../img/Sequoia.jpeg",
    "Taxodium" => "../../img/Taxodium.avif",
    "Pinus" => "../../img/Pinus.jpg",
    "Cordaiteae" => "../../img/Cordaiteae.jpg",
    "Pteridosperms" => "../../img/Pteridosperms.png",
    "Glossopteris" => "../../img/Glossopteris.webp",
    "Sphenophyllum" => "../../img/Sphenophyllum.jpeg",
    "Macrophyllum" => "../../img/Macrophyllum.webp",
    "Brachyphyllum" => "../../img/Brachyphyllum.webp",
    "Zamites" => "../../img/Zamites.webp",
    "Podozamites" => "../../img/Podozamites.jpeg",
    "Salvinia" => "../../img/Salvinia.jpg",
    "Nymphaea" => "../../img/Nymphaea.webp",
    "Chara" => "../../img/Chara.jpg",
    "Aldrovanda" => "../../img/Aldrovanda.jpg",
    "Lepidophloios" => "../../img/Lepidophloios.jpg",
    "Rhacophyton" => "../../img/Rhacophyton.jpeg",
    "Ulvophyceae" => "../../img/Ulvophyceae.jpg",
    "Ceratophyllum" => "../../img/Ceratophyllum.webp",
    "Bennettitales" => "../../img/Bennettitales.webp",
    "Angiosperms" => "../../img/Angiosperms.jpg",
    "Eugenia" => "../../img/Eugenia.webp",
    "Algae" => "../../img/Algae.jpg",
    "Cyperaceae" => "../../img/Cyperaceae.jpg"
];

// Generar el array de plantas
$plants = array_map(function ($name, $image) {
    return [
        'name' => $name,
        'image' => $image,
        'url' => strtolower(str_replace(' ', '-', $name)) . '.php'
    ];
}, array_keys($extra_plants), $extra_plants);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plantas Prehistóricas</title>
    <link rel="stylesheet" href="../../css/plantas_style.css">
</head>
<body>
    <header>
        <a href="../../dino.php">🔙 Volver</a>
    </header>

    <!-- Contenedor para el video -->
    <div id="video-container">
        <video autoplay loop muted playsinline width="100%" height="500" style="object-fit: cover;">
            <source src="../../img/plantas.mp4" type="video/mp4">
            Tu navegador no soporta el elemento de video.
        </video>
    </div>

    <section>
        <ul>
            <?php foreach ($plants as $plant): ?>
                <li>
                    <a href="plantas/<?= strtolower(urlencode($plant['name'])) ?>.php">
                        <strong><?= htmlspecialchars($plant['name']) ?></strong>
                        <img src="<?= htmlspecialchars($plant['image']) ?>" alt="<?= htmlspecialchars($plant['name']) ?>">
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <footer>
        <p>Enciclopedia de Plantas Prehistóricas - © 2025</p>
    </footer>
</body>
</html>

