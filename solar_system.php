<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Solar 3D Mejorado</title>
    <style>
        body { margin: 0; overflow: hidden; background: black; display: flex; justify-content: space-between; }
        canvas { display: block; }
        
        .controls-left {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
        }

        .controls-right {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .controls-right-separate {
            margin-top: 80px;
        }

        .controls-bottom-right {
            position: absolute;
            bottom: 10px;
            right: 10px;
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        button, select {
            padding: 10px;
            font-size: 18px;
            margin: 5px 0;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
            width: 150px;
        }
        
        button:hover, select:hover {
            background-color: #E6E6FA;
            transform: translateY(-2px);
        }
        
        button:active, select:active {
            background-color: #D8BFD8;
            transform: translateY(2px);
        }
        
        .label {
            position: absolute;
            color: white;
            font-size: 18px;
            text-align: center;
            pointer-events: none;
            user-select: none;
        }

        #planetSelectionMenu {
            display: none;
            background-color: #333;
            padding: 10px;
            border-radius: 8px;
            position: absolute;
            top: 50px;
            left: 0;
            z-index: 20;
            min-width: 180px;
        }

        #planetSelectionMenu button {
            display: block;
            margin: 5px 0;
            width: 150px;
        }

    </style>
</head>
<body>

<div class="controls-left">
    <button id="planetSelectionButton">Planetas</button>
    <div id="planetSelectionMenu">
        <button onclick="moveToPlanet('Mercurio')">Mercurio</button>
        <button onclick="moveToPlanet('Venus')">Venus</button>
        <button onclick="moveToPlanet('Tierra')">Tierra</button>
        <button onclick="moveToPlanet('Marte')">Marte</button>
        <button onclick="moveToPlanet('Jupiter')">Jupiter</button>
        <button onclick="moveToPlanet('Saturno')">Saturno</button>
        <button onclick="moveToPlanet('Urano')">Urano</button>
        <button onclick="moveToPlanet('Neptuno')">Neptuno</button>
        <button onclick="moveToPlanet('Plutón')">Plutón</button>
    </div>
</div>

<div class="controls-right">
    <button onclick="changeSpeed('increase')">+</button>
    <button onclick="changeSpeed('decrease')">-</button>
    <button onclick="resetCamera()">Restablecer</button>

    <div class="controls-right-separate">
        <button onclick="togglePlanetMovement()">Start/Stop</button>
    </div>
</div>

<div class="controls-bottom-right">
    <button id="corregirButton" onclick="resetCameraOrientation()">Corregir Inclinación</button>
</div>

<div class="info">
    <h2>Sistema Solar 3D</h2>
    <p>Usa el mouse y las teclas de flecha para moverte. Rueda del mouse para hacer zoom.</p>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
    var scene, camera, renderer, sun, planets = [], labels = [], rings = [];
    var speedFactor = 1; // Velocidad de los planetas
    var planetData = [
        { name: 'Mercurio', size: 10, distance: 9000, color: 0xB0B0B0 },
        { name: 'Venus', size: 19, distance: 12500, color: 0xFF7F00 },
        { name: 'Tierra', size: 21, distance: 15000, color: 0x3399FF },
        { name: 'Marte', size: 18, distance: 18000, color: 0xFF0000 },
        { name: 'Jupiter', size: 52, distance: 21000, color: 0x4B3621 },
        { name: 'Saturno', size: 38, distance: 24000, color: 0xD2B48C },
        { name: 'Urano', size: 19, distance: 22000, color: 0x00CED1 }, // Urano acercado
        { name: 'Neptuno', size: 18, distance: 25000, color: 0x003366 }, // Neptuno acercado
        { name: 'Plutón', size: 8, distance: 28000, color: 0x3B3B3B } // Plutón acercado
    ];

    var isPlanetMovementPaused = false;
    var speedTimeout;

    scene = new THREE.Scene();

    camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 50000);
    
    // Guardamos la posición inicial de la cámara
    var initialCameraPosition = new THREE.Vector3(0, 3000, 22000);
    camera.position.copy(initialCameraPosition);
    camera.lookAt(new THREE.Vector3(0, 0, 0));

    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    var starCount = 10000;
    var starsGeometry = new THREE.BufferGeometry();
    var starsMaterial = new THREE.PointsMaterial({ color: 0xFFFFFF, size: 0.2 });
    var positions = [];
    for (var i = 0; i < starCount; i++) {
        positions.push(
            Math.random() * 100000 - 50000,  // Ampliamos el rango de -50000 a 50000
            Math.random() * 100000 - 50000,  // Ampliamos el rango de -50000 a 50000
            Math.random() * 100000 - 50000   // Ampliamos el rango de -50000 a 50000
        );
    }
    starsGeometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
    var stars = new THREE.Points(starsGeometry, starsMaterial);
    scene.add(stars);

    // Crear el Sol más grande
    var sunGeometry = new THREE.SphereGeometry(6000, 64, 64); // Aumentamos el tamaño del Sol
    var sunMaterial = new THREE.MeshBasicMaterial({
        color: 0xFF7F00,
        emissive: 0xFF7F00,
        emissiveIntensity: 1.5
    });
    sun = new THREE.Mesh(sunGeometry, sunMaterial);

    var sunLight = new THREE.PointLight(0xFF7F00, 10, 24000); // Ajusta la intensidad y distancia de la luz
    sunLight.position.set(0, 0, 0);
    scene.add(sunLight);

    scene.add(sun);

    function createPlanet(data) {
        var planetGeometry = new THREE.SphereGeometry(data.size, 64, 64);
        var planetMaterial = new THREE.MeshStandardMaterial({
            color: data.color,
            roughness: 0.3,
            metalness: 0.2,
            emissive: 0x444444,
            emissiveIntensity: 0.2
        });
        var planet = new THREE.Mesh(planetGeometry, planetMaterial);

        planet.position.x = data.distance;
        planet.name = data.name;
        planet.userData = { moving: true };

        scene.add(planet);
        planets.push(planet);

        var label = document.createElement('div');
        label.className = 'label';
        label.textContent = data.name;
        document.body.appendChild(label);
        labels.push({ planet: planet, label: label });
    }

    function createRing(planet, radius, color, scale) {
        var ringGeometry = new THREE.TorusGeometry(radius, 2, 16, 100);
        var ringMaterial = new THREE.MeshBasicMaterial({
            color: color,
            side: THREE.DoubleSide,
            opacity: 0.6,
            transparent: true
        });
        var ring = new THREE.Mesh(ringGeometry, ringMaterial);
        ring.rotation.x = Math.PI / 2;
        planet.add(ring);
        ring.scale.set(scale, scale, scale);
    }

    planetData.forEach(createPlanet);

    var saturn = planets.find(p => p.name === "Saturno");
    if (saturn) {
        createRing(saturn, 45, 0xC0C0C0, 1.2);
        createRing(saturn, 55, 0xA9A9A9, 1.5);
    }

    function moveToPlanet(planetName) {
        var planet = planets.find(function(p) { return p.name === planetName; });
        if (planet) {
            var targetPosition = planet.position.clone().add(new THREE.Vector3(0, 100, 0)); 
            camera.position.lerp(targetPosition, 0.1); 
            camera.lookAt(planet.position);
        }
    }

    function resetCamera() {
        // Restablecemos la posición y orientación de la cámara a su estado inicial
        camera.position.copy(initialCameraPosition);
        camera.lookAt(new THREE.Vector3(0, 0, 0));
    }

    function togglePlanetMovement() {
        isPlanetMovementPaused = !isPlanetMovementPaused;
        planets.forEach(function(planet) {
            planet.userData.moving = !isPlanetMovementPaused;
        });
    }

    function resetCameraOrientation() {
        camera.rotation.set(0, 0, 0);  
    }

    document.getElementById('planetSelectionButton').addEventListener('click', function() {
        var menu = document.getElementById('planetSelectionMenu');
        if (menu.style.display === 'none' || menu.style.display === '') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    });

    window.addEventListener('wheel', function(event) {
        var zoomFactor = 100;
        if (event.deltaY > 0) {
            camera.position.z += zoomFactor;
        } else {
            camera.position.z -= zoomFactor;
        }
    });

    let isMouseDown = false;
    let previousX = 0, previousY = 0;

    renderer.domElement.addEventListener('mousedown', function(event) {
        isMouseDown = true;
        previousX = event.clientX;
        previousY = event.clientY;
    });

    renderer.domElement.addEventListener('mousemove', function(event) {
        if (!isMouseDown) return;

        let deltaX = event.clientX - previousX;
        let deltaY = event.clientY - previousY;

        if (deltaX !== 0) {
            camera.rotation.y += deltaX * 0.002;
        }

        if (deltaY !== 0) {
            camera.rotation.x -= deltaY * 0.002;
            camera.rotation.x = Math.max(-Math.PI / 2, Math.min(Math.PI / 2, camera.rotation.x));
        }

        previousX = event.clientX;
        previousY = event.clientY;
    });

    window.addEventListener('mouseup', function() {
        isMouseDown = false;
    });

    function animate() {
        requestAnimationFrame(animate);

        sun.rotation.y += 0.0005;

        planets.forEach((planet, index) => {
            var time = Date.now() * 0.0001 * speedFactor * (planetData.length - index);

            if (planet.userData.moving) {
                planet.position.x = planetData[index].distance * Math.cos(time);
                planet.position.z = planetData[index].distance * Math.sin(time);
            }

            planet.rotation.y += 0.002;
        });

        updateLabels();
        renderer.render(scene, camera);
    }

    function updateLabels() {
        labels.forEach(function(entry) {
            var screenPosition = entry.planet.position.clone();
            screenPosition.project(camera);
            
            var x = (screenPosition.x * 0.5 + 0.5) * window.innerWidth;
            var y = (screenPosition.y * -0.5 + 0.5) * window.innerHeight;

            entry.label.style.left = x + 'px';
            entry.label.style.top = y + 'px';
        });
    }

    window.addEventListener('resize', function() {
        renderer.setSize(window.innerWidth, window.innerHeight);
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
    });

    // Aceleración con el botón
    function changeSpeed(direction) {
        if (direction === 'increase') {
            speedFactor *= 1.2; // Incrementa más la velocidad
        } else if (direction === 'decrease') {
            speedFactor /= 1.2; // Disminuye la velocidad
        }
    }

    animate();
</script>

</body>
</html>
