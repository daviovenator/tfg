<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Snake</title>
    <style>
        /* Estilo general */
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Evitar el desplazamiento de la página */
        }

        /* Pantalla de bienvenida */
        .welcome-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('https://img1.picmix.com/output/pic/normal/2/7/6/5/2795672_b7864.gif');
            background-size: cover;
            background-position: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-size: 50px;
            margin-bottom: 30px;
        }

        .btn {
            padding: 20px 40px;
            font-size: 30px;
            color: white;
            background-color: gold;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .btn:hover {
            background-color: #ffcc00;
        }

        /* Juego de la serpiente */
        #game-screen {
            display: none;
            background-image: url('https://i.gifer.com/26pr.gif');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        canvas {
            background-color: rgba(0, 0, 0, 0.8);
            display: block;
            margin: auto;
        }

        /* Pantalla de fin de juego */
        .game-over {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #FFF0F8FF;
            padding: 30px;
            border-radius: 15px;
            color: black;
            text-align: center;
            font-size: 24px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .game-over .btn {
            background-color: goldenrod;
            margin-top: 20px;
        }

    </style>
</head>
<body>

    <!-- Pantalla de bienvenida -->
    <div class="welcome-container" id="welcome-screen">
        <h1>Juego del Dragón</h1>
        <button class="btn" onclick="startGame()">Comenzar</button>
    </div>

    <!-- Juego de la serpiente -->
    <div id="game-screen">
        <h1>Juego de Snake</h1>
        <canvas id="gameCanvas" width="800" height="800"></canvas>
    </div>

    <div id="gameOverScreen" class="game-over" style="display:none;">
        <h2>¡Ups, has perdido!</h2>
        <p>Puntuación: <span id="finalScore"></span></p>
        <button class="btn" onclick="startGame()">Reintentar</button>
    </div>

    <script>
        let gameInterval;
        let snake;
        let direction;
        let food;
        let score;

        // Función para ocultar la pantalla de bienvenida y mostrar el juego
        function startGame() {
            // Ocultar la pantalla de bienvenida
            document.getElementById("welcome-screen").style.display = "none";
            // Mostrar el área de juego
            document.getElementById("game-screen").style.display = "block";
            // Ocultar la pantalla de fin de juego
            document.getElementById("gameOverScreen").style.display = "none";

            // Inicializar los parámetros del juego
            snake = [{ x: 10 * 20, y: 10 * 20 }];
            direction = "RIGHT";
            food = {
                x: Math.floor(Math.random() * 20) * 20,
                y: Math.floor(Math.random() * 20) * 20,
            };
            score = 0;

            // Iniciar el juego
            gameInterval = setInterval(draw, 100);
        }

        // Prevenir el desplazamiento de la página al usar las teclas de flecha
        document.addEventListener("keydown", function(event) {
            event.preventDefault();
            changeDirection(event);
        });

        function changeDirection(event) {
            if (event.keyCode === 37 && direction !== "RIGHT") direction = "LEFT";
            else if (event.keyCode === 38 && direction !== "DOWN") direction = "UP";
            else if (event.keyCode === 39 && direction !== "LEFT") direction = "RIGHT";
            else if (event.keyCode === 40 && direction !== "UP") direction = "DOWN";
            else if (event.keyCode === 13) startGame(); // Enter para reiniciar el juego
        }

        function draw() {
            const canvas = document.getElementById("gameCanvas");
            const ctx = canvas.getContext("2d");
            const box = 20;

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Dibuja la comida
            ctx.fillStyle = "red";
            ctx.fillRect(food.x, food.y, box, box);

            // Dibuja la serpiente
            ctx.fillStyle = "lime";
            snake.forEach((segment) => {
                ctx.fillRect(segment.x, segment.y, box, box);
            });

            let head = { x: snake[0].x, y: snake[0].y };

            if (direction === "LEFT") head.x -= box;
            if (direction === "UP") head.y -= box;
            if (direction === "RIGHT") head.x += box;
            if (direction === "DOWN") head.y += box;

            if (head.x === food.x && head.y === food.y) {
                food = {
                    x: Math.floor(Math.random() * 20) * box,
                    y: Math.floor(Math.random() * 20) * box,
                };
                score += 10;
            } else {
                snake.pop();
            }

            if (
                head.x < 0 || head.x >= canvas.width || head.y < 0 || head.y >= canvas.height ||
                snake.some(segment => segment.x === head.x && segment.y === head.y)
            ) {
                clearInterval(gameInterval);
                showGameOverScreen();
                return;
            }

            snake.unshift(head);
        }

        function showGameOverScreen() {
            // Mostrar pantalla de fin de juego
            document.getElementById("gameOverScreen").style.display = "block";
            document.getElementById("finalScore").textContent = score;
        }
    </script>

</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Snake</title>
    <style>
        /* Estilo general */
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Evitar el desplazamiento de la página */
        }

        /* Pantalla de bienvenida */
        .welcome-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('https://img1.picmix.com/output/pic/normal/2/7/6/5/2795672_b7864.gif');
            background-size: cover;
            background-position: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-size: 50px;
            margin-bottom: 30px;
        }

        .btn {
            padding: 20px 40px;
            font-size: 30px;
            color: white;
            background-color: gold;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .btn:hover {
            background-color: #ffcc00;
        }

        /* Juego de la serpiente */
        #game-screen {
            display: none;
            background-image: url('https://lh3.googleusercontent.com/proxy/SXtMQMJLuUQL7g4C6fzxXAvkXFRvQDVSS9rlR5sTczd75s_Ct6LiAERHwYUIQ9FSLx7N17xtB-HrfxO_DhQOnOujV6AaTMM7V8JP7fweHQ');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        canvas {
            background-color: rgba(0, 0, 0, 0.8);
            display: block;
            margin: auto;
        }

        /* Pantalla de fin de juego */
        .game-over {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #FFF0F8FF;
            padding: 30px;
            border-radius: 15px;
            color: black;
            text-align: center;
            font-size: 24px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .game-over .btn {
            background-color: goldenrod;
            margin-top: 20px;
        }

    </style>
</head>
<body>

    <!-- Pantalla de bienvenida -->
    <div class="welcome-container" id="welcome-screen">
        <h1>Juego del Dragón</h1>
        <button class="btn" onclick="startGame()">Comenzar</button>
    </div>

    <!-- Juego de la serpiente -->
    <div id="game-screen">
        <h1>Juego de Snake</h1>
        <canvas id="gameCanvas" width="800" height="800"></canvas>
    </div>

    <div id="gameOverScreen" class="game-over" style="display:none;">
        <h2>¡Ups, has perdido!</h2>
        <p>Puntuación: <span id="finalScore"></span></p>
        <button class="btn" onclick="startGame()">Reintentar</button>
    </div>

    <script>
        let gameInterval;
        let snake;
        let direction;
        let food;
        let score;

        // Función para ocultar la pantalla de bienvenida y mostrar el juego
        function startGame() {
            // Ocultar la pantalla de bienvenida
            document.getElementById("welcome-screen").style.display = "none";
            // Mostrar el área de juego
            document.getElementById("game-screen").style.display = "block";
            // Ocultar la pantalla de fin de juego
            document.getElementById("gameOverScreen").style.display = "none";

            // Inicializar los parámetros del juego
            snake = [{ x: 10 * 20, y: 10 * 20 }];
            direction = "RIGHT";
            food = {
                x: Math.floor(Math.random() * 20) * 20,
                y: Math.floor(Math.random() * 20) * 20,
            };
            score = 0;

            // Iniciar el juego
            gameInterval = setInterval(draw, 100);
        }

        // Prevenir el desplazamiento de la página al usar las teclas de flecha
        document.addEventListener("keydown", function(event) {
            event.preventDefault();
            changeDirection(event);
        });

        function changeDirection(event) {
            if (event.keyCode === 37 && direction !== "RIGHT") direction = "LEFT";
            else if (event.keyCode === 38 && direction !== "DOWN") direction = "UP";
            else if (event.keyCode === 39 && direction !== "LEFT") direction = "RIGHT";
            else if (event.keyCode === 40 && direction !== "UP") direction = "DOWN";
            else if (event.keyCode === 13) startGame(); // Enter para reiniciar el juego
        }

        function draw() {
            const canvas = document.getElementById("gameCanvas");
            const ctx = canvas.getContext("2d");
            const box = 20;

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Dibuja la comida
            ctx.fillStyle = "red";
            ctx.fillRect(food.x, food.y, box, box);

            // Dibuja la serpiente
            ctx.fillStyle = "lime";
            snake.forEach((segment) => {
                ctx.fillRect(segment.x, segment.y, box, box);
            });

            let head = { x: snake[0].x, y: snake[0].y };

            if (direction === "LEFT") head.x -= box;
            if (direction === "UP") head.y -= box;
            if (direction === "RIGHT") head.x += box;
            if (direction === "DOWN") head.y += box;

            if (head.x === food.x && head.y === food.y) {
                food = {
                    x: Math.floor(Math.random() * 20) * box,
                    y: Math.floor(Math.random() * 20) * box,
                };
                score += 10;
            } else {
                snake.pop();
            }

            if (
                head.x < 0 || head.x >= canvas.width || head.y < 0 || head.y >= canvas.height ||
                snake.some(segment => segment.x === head.x && segment.y === head.y)
            ) {
                clearInterval(gameInterval);
                showGameOverScreen();
                return;
            }

            snake.unshift(head);
        }

        function showGameOverScreen() {
            // Mostrar pantalla de fin de juego
            document.getElementById("gameOverScreen").style.display = "block";
            document.getElementById("finalScore").textContent = score;
        }
    </script>

</body>
</html>
