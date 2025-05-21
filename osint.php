<?php
function obtenerDireccionAleatoriaEspana() {
    $direcciones = [
        // Madrid
        ['calle' => 'Gran Vía', 'ciudad' => 'Madrid', 'cp' => '28013'],
        ['calle' => 'Calle de Alcalá', 'ciudad' => 'Madrid', 'cp' => '28014'],
        ['calle' => 'Paseo del Prado', 'ciudad' => 'Madrid', 'cp' => '28014'],
        ['calle' => 'Calle de Atocha', 'ciudad' => 'Madrid', 'cp' => '28012'],
        ['calle' => 'Calle de Velázquez', 'ciudad' => 'Madrid', 'cp' => '28001'],
        ['calle' => 'Calle de Serrano', 'ciudad' => 'Madrid', 'cp' => '28006'],
        ['calle' => 'Calle de Fuencarral', 'ciudad' => 'Madrid', 'cp' => '28004'],
        ['calle' => 'Paseo de la Castellana', 'ciudad' => 'Madrid', 'cp' => '28046'],

        // Barcelona
        ['calle' => 'Avenida Diagonal', 'ciudad' => 'Barcelona', 'cp' => '08028'],
        ['calle' => 'Calle de Aragón', 'ciudad' => 'Barcelona', 'cp' => '08009'],
        ['calle' => 'La Rambla', 'ciudad' => 'Barcelona', 'cp' => '08002'],
        ['calle' => 'Calle de Balmes', 'ciudad' => 'Barcelona', 'cp' => '08006'],
        ['calle' => 'Calle del Consell de Cent', 'ciudad' => 'Barcelona', 'cp' => '08007'],
        ['calle' => 'Gran Via de les Corts Catalanes', 'ciudad' => 'Barcelona', 'cp' => '08015'],

        // Valencia
        ['calle' => 'Calle de Colón', 'ciudad' => 'Valencia', 'cp' => '46004'],
        ['calle' => 'Gran Vía Marqués del Turia', 'ciudad' => 'Valencia', 'cp' => '46005'],
        ['calle' => 'Avenida del Puerto', 'ciudad' => 'Valencia', 'cp' => '46023'],
        ['calle' => 'Calle de la Paz', 'ciudad' => 'Valencia', 'cp' => '46003'],

        // Sevilla
        ['calle' => 'Calle Sierpes', 'ciudad' => 'Sevilla', 'cp' => '41001'],
        ['calle' => 'Avenida de la Constitución', 'ciudad' => 'Sevilla', 'cp' => '41004'],
        ['calle' => 'Calle San Fernando', 'ciudad' => 'Sevilla', 'cp' => '41004'],
        ['calle' => 'Calle Asunción', 'ciudad' => 'Sevilla', 'cp' => '41011'],

        // Zaragoza
        ['calle' => 'Paseo Independencia', 'ciudad' => 'Zaragoza', 'cp' => '50001'],
        ['calle' => 'Calle del Coso', 'ciudad' => 'Zaragoza', 'cp' => '50003'],
        ['calle' => 'Avenida César Augusto', 'ciudad' => 'Zaragoza', 'cp' => '50004'],

        // Málaga
        ['calle' => 'Calle Marqués de Larios', 'ciudad' => 'Málaga', 'cp' => '29005'],
        ['calle' => 'Alameda Principal', 'ciudad' => 'Málaga', 'cp' => '29001'],
        ['calle' => 'Calle Nueva', 'ciudad' => 'Málaga', 'cp' => '29005'],
        ['calle' => 'Paseo del Parque', 'ciudad' => 'Málaga', 'cp' => '29015'],

        // Murcia
        ['calle' => 'Gran Vía Alfonso X el Sabio', 'ciudad' => 'Murcia', 'cp' => '30008'],
        ['calle' => 'Avenida de la Libertad', 'ciudad' => 'Murcia', 'cp' => '30009'],
        ['calle' => 'Calle Trapería', 'ciudad' => 'Murcia', 'cp' => '30001'],

        // Palma
        ['calle' => 'Calle de Jaime III', 'ciudad' => 'Palma', 'cp' => '07012'],
        ['calle' => 'Avenida Alexandre Rosselló', 'ciudad' => 'Palma', 'cp' => '07002'],
        ['calle' => 'Paseo del Borne', 'ciudad' => 'Palma', 'cp' => '07012'],

        // Las Palmas
        ['calle' => 'Calle Mayor de Triana', 'ciudad' => 'Las Palmas', 'cp' => '35002'],
        ['calle' => 'Avenida Mesa y López', 'ciudad' => 'Las Palmas', 'cp' => '35010'],
        ['calle' => 'Calle León y Castillo', 'ciudad' => 'Las Palmas', 'cp' => '35003'],

        // Bilbao
        ['calle' => 'Gran Vía de Don Diego López de Haro', 'ciudad' => 'Bilbao', 'cp' => '48009'],
        ['calle' => 'Calle Licenciado Poza', 'ciudad' => 'Bilbao', 'cp' => '48011'],
        ['calle' => 'Avenida Sabino Arana', 'ciudad' => 'Bilbao', 'cp' => '48013']
    ];

    $direccionElegida = $direcciones[array_rand($direcciones)];
    $portal = rand(1, 200);
    $piso = rand(1, 10) . "º";

    $latitud = rand(35, 43) + (rand(0, 9999) / 10000);
    $longitud = rand(-9, 3) + (rand(0, 9999) / 10000);

    return [
        'direccion' => "{$direccionElegida['calle']}, $portal, $piso, {$direccionElegida['cp']}, {$direccionElegida['ciudad']}",
        'coordenadas' => "Latitud: " . round($latitud, 6) . ", Longitud: " . round($longitud, 6)
    ];
}

$direccion = '';
$coordenadas = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['generate'])) {
        $direccionData = obtenerDireccionAleatoriaEspana();
        $direccion = $direccionData['direccion'];
        $coordenadas = $direccionData['coordenadas'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Crime - Hacking the Pentagon</title>
    <link rel="stylesheet" href="css/osint_style.css">
    <style>
        .search-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            padding: 10px;
        }

        .search-container input, .search-container button {
            margin: 5px 0;
            padding: 10px;
            width: 300px;
            font-size: 16px;
        }

        .search-container button[type="submit"] {
            background-color: #0066cc;
            width: 100px;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        #map.fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
        }

        .map-container {
            margin-top: 20px;
        }

        .spoofwave-button {
            background-color: #00b894;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
        }

        .spoofwave-button:hover {
            background-color: #019874;
        }

        .ia-box {
            margin: 40px auto;
            padding: 20px;
            background-color: #111;
            border: 1px solid #444;
            border-radius: 10px;
            color: #fff;
            width: 60%; /* <-- ancho aumentado */
            max-width: 1000px; /* <-- máximo opcional */
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>
<body>
    <div id="matrix"></div>

    <!-- Contenedor de botones arriba a la izquierda -->
    <div class="botones-superiores">
        <a href="hackeo.php" class="inicio-btn">Inicio</a>
        <a href="index.php" class="salir-btn">Salir</a>
    </div>

    <div class="dropdown">
        <button class="dropbtn">Expándeme</button>
        <div class="dropdown-content">
            <a href="infor.php">Asir</a>
            <a href="virus_list.php">Listado virus</a>
            <a href="email.php">Email</a>
            <a href="osint.php">OSINT</a>
            <a href="links.php">Links</a>
            <a href="3D.php">3D</a>
            <a href="wiki_espace.php">Wiki Space</a>
            <a href="juegos.php">Juegos</a>
            <a href="peliculas.php">Películas</a>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="search-container">
            <h1>Generador de Direcciones Aleatorias Españolas</h1>
            <input type="text" id="address" value="<?php echo htmlspecialchars($direccion); ?>" readonly>
            <form method="POST" action="">
                <button type="submit" name="generate">Generar</button>
            </form>
        </div>

        <div class="ia-box">
            <h1>SpoofWave</h1>
            <p>SpoofWave es una plataforma líder que ofrece herramientas avanzadas para la suplantación de identidad en correos electrónicos, SMS y llamadas.Está diseñado para proporcionar acceso seguro y eficiente a técnicas de recopilación de inteligencia y pruebas de penetración. Además, SpoofWave ofrece un paquete de API con acceso de por vida y sin límites de uso, incluyendo módulos como SEON, Crypto Lookup y Email Spoof Checker. ​spoofwave.com+4</p>

            <a href="https://spoofwave.com/" target="_blank" class="spoofwave-button">SpoofWave</a>
        </div>

        <div class="map-container">
            <button onclick="changeMap('standard')">Mapa Estándar</button>
            <button onclick="changeMap('satellite')">Mapa Satelital</button>

            <div id="map" style="height: 400px;"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        var map = L.map('map').setView([40.4168, -3.7038], 13);
        var currentLayer;

        function changeMap(type) {
            if (currentLayer) {
                map.removeLayer(currentLayer);
            }

            if (type === 'standard') {
                currentLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
            } else if (type === 'satellite') {
                currentLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.opentopomap.org/">OpenTopoMap</a>'
                }).addTo(map);
            } else if (type === 'espacial') {
                currentLayer = L.tileLayer('https://{s}.s3.amazonaws.com/worldview/{z}/{x}/{y}.jpg', {
                    attribution: '&copy; <a href="https://worldview.earthdata.nasa.gov/">NASA Worldview</a>'
                }).addTo(map);
            }
        }

        changeMap('standard');

        var geocoder = L.Control.Geocoder.nominatim({
            geocodingQueryParams: { countrycodes: 'ES' }
        }).addTo(map);

        var marker = L.marker([40.4168, -3.7038]).addTo(map);
        marker.bindPopup("<b>Madrid</b>").openPopup();
    </script>
</body>
</html> 
