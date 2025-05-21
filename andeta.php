<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Dónde está la bola?</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://pa1.aminoapps.com/7703/17f3fef60cae6fa7904b382886d231c7f76d99dbr1-500-834_hq.gif') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            flex-direction: column;
        }

        .game-container {
            position: relative;
            text-align: center;
        }

.message {
    font-size: 24px;
    font-weight: bold;
    color: black;
    background-color: white;
    padding: 10px 20px;
    border-radius: 10px;
    position: absolute;
    top: -250px;
    width: auto; /* Esto asegura que el fondo blanco se ajuste al tamaño del texto */
    text-align: center;
    z-index: 3;
    display: none;
    margin-left: 110px; /* Ajusta este valor para mover el mensaje más a la derecha */
}

.restart-button {
    background-color: gold;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: -170px;
    display: none;
    margin-left: 120px; /* Esto moverá el botón a la derecha */
}

.restart-button:hover {
    background-color: darkgoldenrod;
}

        .vasos-container {
            display: flex;
            justify-content: center;
            width: 360px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .vaso {
            width: 80px;
            height: 120px;
            background-color: white;
            border-radius: 10px;
            border: 3px solid #333;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            cursor: pointer;
            position: relative;
            z-index: 1;
        }

        .ball {
            width: 30px;
            height: 30px;
            background-color: red;
            border-radius: 50%;
            position: absolute;
            top: -40px;
            z-index: 2;
            display: none;
        }
    </style>
</head>
<body>
    <div class="game-container">
        <div class="message" id="message"></div>
        <button id="restartButton" class="restart-button" onclick="restartGame()">Reintentar</button>
        <div class="vasos-container">
            <div class="vaso" id="vaso1" onclick="checkVaso(1)"></div>
            <div class="vaso" id="vaso2" onclick="checkVaso(2)"></div>
            <div class="vaso" id="vaso3" onclick="checkVaso(3)"></div>
        </div>
    </div>

    <script>
        let ballPosition = 0;
        let gameStarted = false;
        let gameOver = false;
        let ballElement = null;

        function hideBall() {
            if (ballElement) ballElement.style.display = "none";
        }

        function showBall(position) {
            ballElement = document.createElement("div");
            ballElement.classList.add("ball");
            document.getElementById("vaso" + position).appendChild(ballElement);
            ballElement.style.display = "block";
        }

        function startGame() {
            gameOver = false;
            gameStarted = true;

            // Ocultar mensaje y botón antes de reiniciar el juego
            document.getElementById("message").style.display = "none";
            document.getElementById("restartButton").style.display = "none";

            hideBall();
            ballPosition = Math.floor(Math.random() * 3) + 1;

            showBall(ballPosition);

            ballElement.style.top = "-40px";
            let ballFallInterval = setInterval(() => {
                let ballTop = parseInt(ballElement.style.top.replace("px", ""));
                if (ballTop < 60) {
                    ballElement.style.top = ballTop + 5 + "px";
                } else {
                    clearInterval(ballFallInterval);
                    setTimeout(startSwapping, 1000);
                }
            }, 50);
        }

        function startSwapping() {
            let swapCount = 0;
            const vasos = ["vaso1", "vaso2", "vaso3"];
            let vasosElements = vasos.map(id => document.getElementById(id));

            const swapInterval = setInterval(() => {
                vasosElements = shuffleArray(vasosElements);

                vasosElements.forEach((vaso, index) => {
                    vaso.style.transform = `translateX(${index * 90}px)`;
                });

                ballElement.style.backgroundColor = "white";

                swapCount++;

                if (swapCount === 20) {
                    clearInterval(swapInterval);
                    resetVasosPosition();
                }
            }, 100);
        }

        function shuffleArray(array) {
            return array.sort(() => Math.random() - 0.5);
        }

        function resetVasosPosition() {
            const vasos = ["vaso1", "vaso2", "vaso3"];
            vasos.forEach((vaso, index) => {
                const vasoElement = document.getElementById(vaso);
                vasoElement.style.transform = `translateX(${index * 90}px)`;
            });

            ballElement.style.backgroundColor = "white";
            document.querySelectorAll('.vaso').forEach(vaso => vaso.style.cursor = 'pointer');
        }

        function checkVaso(selectedVaso) {
            if (gameOver) return;

            ballElement.style.backgroundColor = "red";
            const vaso = document.getElementById("vaso" + selectedVaso);
            ballElement.style.top = "-40px";
            ballElement.style.left = "50%";
            ballElement.style.transform = "translateX(-50%)";

            ballElement.style.display = "block";

            // Mostrar el mensaje con fondo blanco y texto negro
            const messageElement = document.getElementById("message");
            messageElement.innerText = selectedVaso === ballPosition ? "¡Has ganado!" : "¡Has perdido!";
            messageElement.style.backgroundColor = "white";
            messageElement.style.color = "black";
            messageElement.style.padding = "10px 20px";
            messageElement.style.borderRadius = "10px";
            messageElement.style.display = "block"; // Hacer visible el mensaje

            // Mostrar el botón de reinicio
            document.getElementById("restartButton").style.display = "block";

            gameOver = true;
        }

        function restartGame() {
            document.getElementById("message").style.display = "none"; // Ocultar mensaje
            document.getElementById("restartButton").style.display = "none"; // Ocultar botón
            startGame(); // Iniciar el juego de nuevo
        }

        window.onload = startGame;
    </script>
</body>
</html>
