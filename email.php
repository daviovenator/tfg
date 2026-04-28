<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mensaje_envio = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["name"]);
    $asunto = htmlspecialchars($_POST["subject"]);
    $email_remitente = htmlspecialchars($_POST["email"]);
    $mensaje_usuario = htmlspecialchars($_POST["message"]);
    
    $mail = new PHPMailer(true);
    
    try {
        // Configuración SMTP de Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'asirclean@gmail.com';
        $mail->Password   = 'jagx whvr ektj iffb';  // Tu contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        // Remitente y destinatario
        $mail->setFrom('asirclean@gmail.com', 'AsirClean System');
        $mail->addReplyTo($email_remitente, $nombre);
        $mail->addAddress('davidcigaran@gmail.com', 'David');
        
        // Contenido del correo
        $mail->isHTML(false);
        $mail->Subject = "📧 Nuevo mensaje de $nombre: $asunto";
        $mail->Body    = "========================================\n";
        $mail->Body   .= "📨 NUEVO MENSAJE DESDE CYBER CRIME\n";
        $mail->Body   .= "========================================\n\n";
        $mail->Body   .= "👤 Nombre: $nombre\n";
        $mail->Body   .= "📧 Correo: $email_remitente\n";
        $mail->Body   .= "📝 Asunto: $asunto\n";
        $mail->Body   .= "────────────────────────────────────────\n";
        $mail->Body   .= "💬 Mensaje:\n$mensaje_usuario\n";
        $mail->Body   .= "────────────────────────────────────────\n";
        $mail->Body   .= "🌐 Enviado desde: " . ($_SERVER['HTTP_REFERER'] ?? 'Web directa') . "\n";
        $mail->Body   .= "🕒 Fecha: " . date('d/m/Y H:i:s') . "\n";
        $mail->Body   .= "🖥️ IP: " . ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Desconocida') . "\n";
        
        $mail->send();
        $mensaje_envio = "✅ ¡Correo enviado con éxito a davidcigaran@gmail.com!";
        $tipo_mensaje = "exito";
    } catch (Exception $e) {
        $mensaje_envio = "❌ Error al enviar: " . $mail->ErrorInfo;
        $tipo_mensaje = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Crime - Contacto Seguro</title>
    <link rel="stylesheet" href="css/email_style.css">
    <style>
        .mensaje-envio {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            text-align: center;
            animation: fadeIn 0.5s ease-in;
        }
        .mensaje-envio.exito {
            background-color: rgba(0, 255, 0, 0.15);
            border-left: 4px solid #0f0;
            color: #0f0;
            text-shadow: 0 0 5px rgba(0,255,0,0.5);
        }
        .mensaje-envio.error {
            background-color: rgba(255, 0, 0, 0.15);
            border-left: 4px solid #f00;
            color: #f66;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .info-seguridad {
            margin-top: 15px;
            text-align: center;
            font-size: 12px;
            color: #0a0;
            font-family: monospace;
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
        <h2>📧 Envía un Correo Seguro</h2>
        
        <?php if ($mensaje_envio): ?>
            <div class="mensaje-envio <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje_envio; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <label for="name">🕵️ Tu Nombre o Alias:</label>
            <input type="text" name="name" id="name" placeholder="Ej: Neo / Trinity / ZeroCool" required>

            <label for="subject">📌 Asunto:</label>
            <input type="text" name="subject" id="subject" placeholder="Motivo de tu mensaje" required>

            <label for="email">✉️ Tu Correo Electrónico:</label>
            <input type="email" name="email" id="email" placeholder="usuario@ejemplo.com" required>

            <label for="message">💬 Mensaje:</label>
            <textarea name="message" id="message" placeholder="Escribe tu mensaje aquí..." rows="6" required></textarea>

            <button type="submit">🚀 Enviar Mensaje</button>
        </form>
        
        <div class="info-seguridad">
            <small>🔒 Tu mensaje se enviará de forma segura a nuestro equipo.</small>
        </div>
    </div>

    <script src="matrix.js"></script>
</body>
</html>
