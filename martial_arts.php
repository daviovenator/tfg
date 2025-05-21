<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modelo 3D con Animaciones</title>
  <style>
    body { margin: 0; }
    canvas { display: block; }
    .controls {
      position: fixed;
      top: 10px;
      left: 10px;
      z-index: 10;
      background: rgba(0, 0, 0, 0.5);
      padding: 10px;
      border-radius: 5px;
      color: white;
    }
    select, button {
      padding: 10px;
      font-size: 16px;
      border: none;
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
      width: 200px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="controls">
    <label for="model-selector">Selecciona un modelo:</label>
    <select id="model-selector" onchange="changeModel(this.value)">
      <option value="Erika_Archer.fbx">Erika Archer</option>
      <option value="Ch02_nonPBR.fbx">Modelo 2 - Chica</option>
      <option value="The_Boss.fbx">Modelo 3 - Boss</option>
      <option value="Ganfaul_M_Aure.fbx">Modelo 4 - Ganafaul</option>
    </select>

    <label for="dance-animation">Selecciona un baile:</label>
    <select id="dance-animation" onchange="changeAnimation('dance', this.value)">
      <option value="">Elige una animación</option>
      <option value="samba">Samba Dance</option>
      <option value="jazz">Jazz Dance</option>
      <option value="swing">Swing Dance</option>
      <option value="macarena">Macarena</option>
    </select>

    <label for="boxing-animation">Selecciona una animación de boxeo:</label>
    <select id="boxing-animation" onchange="changeAnimation('boxing', this.value)">
      <option value="">Elige una animación</option>
      <option value="boxing">Boxing</option>
    </select>
  </div>

  <div id="3d-container"></div>

  <script src="https://cdn.jsdelivr.net/npm/fflate@0.6.9/umd/index.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/FBXLoader.js"></script>

  <script>
    let scene, camera, renderer, model, mixer;
    let animations = {};

    function init() {
      scene = new THREE.Scene();
      camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
      renderer = new THREE.WebGLRenderer();
      renderer.setSize(window.innerWidth, window.innerHeight);
      renderer.setClearColor(0xffffff, 1); // Fondo blanco
      document.getElementById('3d-container').appendChild(renderer.domElement);

      const light = new THREE.AmbientLight(0x404040, 5);
      scene.add(light);
      const directionalLight = new THREE.DirectionalLight(0xffffff, 1.5);
      directionalLight.position.set(10, 10, 10);
      scene.add(directionalLight);

      loadModel("Erika_Archer.fbx");
      window.addEventListener('resize', onWindowResize, false);
    }

    function loadModel(modelPath) {
      if (model) scene.remove(model);
      const loader = new THREE.FBXLoader();
      loader.load(modelPath, (fbx) => {
        model = fbx;
        scene.add(model);
        mixer = new THREE.AnimationMixer(model);
        loadAnimations();
        camera.position.set(0, 100, 200);
      });
    }

    function loadAnimations() {
      const animationFiles = {
        'boxing': 'Boxing.fbx',
        'samba': 'Samba_Dancing.fbx',
        'jazz': 'Jazz_Dancing.fbx',
        'swing': 'Swing_Dancing.fbx',
        'macarena': 'Macarena.fbx'
      };
      for (let key in animationFiles) {
        const loader = new THREE.FBXLoader();
        loader.load(animationFiles[key], (fbx) => {
          animations[key] = fbx.animations[0];
        });
      }
    }

    function changeModel(modelPath) {
      loadModel(modelPath);
    }

    function changeAnimation(type, value) {
      if (mixer && model) {
        mixer.stopAllAction();
        if (animations[value]) {
          const action = mixer.clipAction(animations[value]);
          action.play();
        }
      }
    }

    function onWindowResize() {
      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
    }

    function animate() {
      requestAnimationFrame(animate);
      if (mixer) {
        mixer.timeScale = 1.5;
        mixer.update(0.01);
      }

      renderer.render(scene, camera);
    }

    init();
    animate();
  </script>
</body>
</html>
