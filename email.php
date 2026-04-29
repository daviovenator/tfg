<?php
// 🚨 Requiere PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de que PHPMailer está instalado con Composer

$mensaje_envio = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = htmlspecialchars($_POST["name"]);
    $destinatario = htmlspecialchars($_POST["to_email"]);
    $mensaje = htmlspecialchars($_POST["message"]);

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'asirclean@gmail.com';
        $mail->Password = 'jagx whvr ektj iffb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Configurar el remitente y destinatario
        $mail->setFrom('asirclean@gmail.com', $nombre);
        $mail->addAddress($destinatario);
        $mail->addReplyTo('asirclean@gmail.com', $nombre);

        // Contenido del correo
        $mail->isHTML(false);
        $mail->Subject = 'Mensaje Anónimo de ' . $nombre;
        $mail->Body = $mensaje;

        $mail->send();
        $mensaje_envio = "✅ ¡Correo enviado con éxito a $destinatario!";
        $tipo_mensaje = "exito";
    } catch (Exception $e) {
        $mensaje_envio = "❌ Error al enviar el correo: " . $mail->ErrorInfo;
        $tipo_mensaje = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Crime - Envío de Correos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: #000;
            color: #0f0;
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Fondo Matrix */
        #matrix {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: #000;
        }

        .botones-superiores {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }

        .inicio-btn {
            background: rgba(0, 255, 0, 0.2);
            backdrop-filter: blur(5px);
            padding: 10px 20px;
            border-radius: 5px;
            color: #0f0;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #0f0;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .inicio-btn:hover {
            background: rgba(0, 255, 0, 0.4);
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }

        .dropdown {
            position: fixed;
            top: 20px;
            right: 20px;
            display: inline-block;
            z-index: 1000;
        }

        .dropbtn {
            background: rgba(0, 255, 0, 0.2);
            backdrop-filter: blur(5px);
            color: #0f0;
            padding: 10px 20px;
            font-size: 16px;
            border: 1px solid #0f0;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .dropbtn:hover {
            background: rgba(0, 255, 0, 0.4);
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: rgba(0, 0, 0, 0.95);
            min-width: 180px;
            border-radius: 5px;
            border: 1px solid #0f0;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: #0f0;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
        }

        .dropdown-content a:hover {
            background: rgba(0, 255, 0, 0.2);
            padding-left: 25px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .email-form-container {
            position: relative;
            z-index: 1;
            max-width: 500px;
            margin: 80px auto;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
            border: 2px solid #0f0;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 30px rgba(0, 255, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #0f0;
            margin-bottom: 25px;
            font-size: 24px;
            text-shadow: 0 0 5px #0f0;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #0f0;
            font-weight: bold;
            margin-top: 15px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid #0f0;
            border-radius: 5px;
            color: #0f0;
            font-size: 14px;
            font-family: 'Courier New', monospace;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #0f0;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: transparent;
            border: 2px solid #0f0;
            border-radius: 5px;
            color: #0f0;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 25px;
            font-family: 'Courier New', monospace;
        }

        button:hover {
            background: rgba(0, 255, 0, 0.2);
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
            transform: translateY(-2px);
        }

        .mensaje-envio {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
            border: 1px solid;
        }

        .mensaje-envio.exito {
            background: rgba(0, 255, 0, 0.1);
            border-color: #0f0;
            color: #0f0;
        }

        .mensaje-envio.error {
            background: rgba(255, 0, 0, 0.1);
            border-color: #f00;
            color: #f66;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        ::placeholder {
            color: rgba(0, 255, 0, 0.5);
        }
    </style>
</head>
<body>
    <div id="matrix"></div>

    <div class="botones-superiores">
        <a href="index.php" class="inicio-btn">🏠 Inicio</a>
    </div>

    <div class="dropdown">
        <button class="dropbtn">🔓 Expándeme</button>
        <div class="dropdown-content">
            <a href="infor.php">💻 Asir</a>
            <a href="virus_list.php">🦠 Listado virus</a>
            <a href="email.php">📧 Email</a>
            <a href="osint.php">🔍 OSINT</a>
            <a href="links.php">🔗 Links</a>
            <a href="3D.php">🎮 3D</a>
            <a href="wiki_espace.php">📚 Wiki Space</a>
            <a href="juegos.php">🎯 Juegos</a>
            <a href="peliculas.php">🎬 Películas</a>
        </div>
    </div>

    <div class="email-form-container">
        <h2>📧 Envío de Correo Electrónico</h2>
        
        <?php if ($mensaje_envio): ?>
            <div class="mensaje-envio <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje_envio; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <label for="name">👤 Tu Nombre (o pseudónimo):</label>
            <input type="text" name="name" id="name" placeholder="Ej: Neo, Trinity, ZeroCool" required>

            <label for="to_email">📧 Correo del Destinatario:</label>
            <input type="email" name="to_email" id="to_email" placeholder="destinatario@example.com" required>

            <label for="message">💬 Mensaje:</label>
            <textarea name="message" id="message" placeholder="Escribe tu mensaje aquí..." required></textarea>

            <button type="submit">🚀 Enviar Correo</button>
        </form>
    </div>

    <script>
        // Efecto Matrix simplificado
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        document.getElementById('matrix').appendChild(canvas);
        
        canvas.style.position = 'fixed';
        canvas.style.top = '0';
        canvas.style.left = '0';
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        canvas.style.zIndex = '-1';
        
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();
        
        const chars = '01アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン';
        const charArray = chars.split('');
        const fontSize = 16;
        const columns = canvas.width / fontSize;
        const drops = [];
        
        for (let i = 0; i < columns; i++) {
            drops[i] = Math.random() * -100;
        }
        
        function draw() {
            ctx.fillStyle = 'rgba(0, 0, 0, 0.04)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            ctx.fillStyle = '#0f0';
            ctx.font = fontSize + 'px monospace';
            
            for (let i = 0; i < drops.length; i++) {
                const char = charArray[Math.floor(Math.random() * charArray.length)];
                ctx.fillText(char, i * fontSize, drops[i] * fontSize);
                
                if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                    drops[i] = 0;
                }
                drops[i]++;
            }
        }
        
        setInterval(draw, 50);
    </script>
</body>
</html>
