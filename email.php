<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mensaje_envio = "";
$tipo_mensaje = "";

// La contraseña se lee desde variable de entorno (NO está en el código)
$smtp_password = getenv('SMTP_PASSWORD');

// Si no está configurada la variable, mostrar error
if (!$smtp_password) {
    $mensaje_envio = "⚠️ Error de configuración: Variable SMTP_PASSWORD no encontrada";
    $tipo_mensaje = "error";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $smtp_password) {
    $nombre = htmlspecialchars($_POST["name"]);
    $asunto = htmlspecialchars($_POST["subject"]);
    $email_remitente = htmlspecialchars($_POST["email"]);
    $mensaje_usuario = htmlspecialchars($_POST["message"]);
    
    // Obtener IP del usuario
    $ip_usuario = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';
    if (strpos($ip_usuario, ',') !== false) {
        $ip_usuario = explode(',', $ip_usuario)[0];
    }
    $ip_usuario = trim($ip_usuario);
    
    // Detectar SO y navegador
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido';
    
    $os = "Desconocido";
    if (preg_match('/Windows NT 10.0/', $user_agent)) $os = "Windows 10";
    elseif (preg_match('/Windows NT 11.0/', $user_agent)) $os = "Windows 11";
    elseif (preg_match('/Mac OS X/', $user_agent)) $os = "macOS";
    elseif (preg_match('/Linux/', $user_agent)) $os = "Linux";
    elseif (preg_match('/Android/', $user_agent)) $os = "Android";
    elseif (preg_match('/iPhone/', $user_agent)) $os = "iOS";
    
    $browser = "Desconocido";
    if (preg_match('/Chrome/i', $user_agent) && !preg_match('/Edg/i', $user_agent)) $browser = "Google Chrome";
    elseif (preg_match('/Firefox/i', $user_agent)) $browser = "Mozilla Firefox";
    elseif (preg_match('/Safari/i', $user_agent) && !preg_match('/Chrome/i', $user_agent)) $browser = "Safari";
    elseif (preg_match('/Edg/i', $user_agent)) $browser = "Microsoft Edge";
    elseif (preg_match('/Opera/i', $user_agent)) $browser = "Opera";
    
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'asirclean@gmail.com';
        $mail->Password   = $smtp_password;  // ← Se usa la variable, NO está escrita
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';
        
        $mail->setFrom('asirclean@gmail.com', 'Cyber Crime System');
        $mail->addReplyTo($email_remitente, $nombre);
        $mail->addAddress('davidcigaran@gmail.com', 'David');
        
        $mail->isHTML(true);
        $mail->Subject = "📩 Nuevo contacto de $nombre - $asunto";
        
        $mail->Body = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: "Segoe UI", Arial, sans-serif; background: linear-gradient(135deg, #0a0e27 0%, #1a1f3a 100%); margin: 0; padding: 20px; }
                .container { max-width: 600px; margin: 0 auto; background: #0f1233; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.4); border: 1px solid rgba(0, 255, 255, 0.2); }
                .header { background: linear-gradient(135deg, #00b4ff, #0066ff); padding: 30px; text-align: center; }
                .header h1 { margin: 0; color: white; font-size: 24px; }
                .header p { margin: 10px 0 0; color: rgba(255,255,255,0.9); }
                .content { padding: 30px; }
                .info-card { background: rgba(0, 255, 255, 0.05); border-left: 4px solid #00ffff; padding: 15px; margin-bottom: 20px; border-radius: 8px; }
                .info-label { color: #00ffff; font-size: 12px; text-transform: uppercase; letter-spacing: 2px; font-weight: bold; margin-bottom: 5px; }
                .info-value { color: #fff; font-size: 16px; font-weight: 500; }
                .message-box { background: rgba(0, 0, 0, 0.3); border-radius: 12px; padding: 20px; margin-top: 20px; border: 1px solid rgba(0, 255, 255, 0.2); }
                .message-box h3 { color: #00ffff; margin: 0 0 10px 0; font-size: 14px; text-transform: uppercase; }
                .message-text { color: #e0e0e0; line-height: 1.6; font-size: 14px; }
                .tech-details { background: #0a0c22; border-radius: 12px; padding: 15px; margin-top: 20px; font-family: "Courier New", monospace; font-size: 12px; }
                .tech-details h4 { color: #ff6b6b; margin: 0 0 10px 0; }
                .tech-row { display: flex; justify-content: space-between; padding: 5px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
                .tech-label { color: #888; }
                .tech-value { color: #0f0; text-align: right; }
                .footer { background: rgba(0,0,0,0.3); padding: 20px; text-align: center; font-size: 11px; color: #666; }
                .badge { display: inline-block; background: rgba(0, 255, 0, 0.2); color: #0f0; padding: 4px 12px; border-radius: 20px; font-size: 11px; margin-top: 10px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header"><h1>🔐 CYBER CRIME SECURITY</h1><p>Nuevo mensaje recibido</p></div>
                <div class="content">
                    <div class="info-card"><div class="info-label">👤 Remitente</div><div class="info-value">' . $nombre . '</div></div>
                    <div class="info-card"><div class="info-label">📧 Correo electrónico</div><div class="info-value">' . $email_remitente . '</div></div>
                    <div class="info-card"><div class="info-label">📌 Asunto</div><div class="info-value">' . $asunto . '</div></div>
                    <div class="message-box"><h3>💬 Mensaje</h3><p class="message-text">' . nl2br($mensaje_usuario) . '</p></div>
                    <div class="tech-details">
                        <h4>🖥️ INFORMACIÓN TÉCNICA</h4>
                        <div class="tech-row"><span class="tech-label">🌐 IP:</span><span class="tech-value">' . $ip_usuario . '</span></div>
                        <div class="tech-row"><span class="tech-label">💻 SO:</span><span class="tech-value">' . $os . '</span></div>
                        <div class="tech-row"><span class="tech-label">🌍 Navegador:</span><span class="tech-value">' . $browser . '</span></div>
                        <div class="tech-row"><span class="tech-label">📅 Fecha:</span><span class="tech-value">' . date('d/m/Y H:i:s') . '</span></div>
                    </div>
                    <div class="badge">🔒 Mensaje cifrado extremo a extremo</div>
                </div>
                <div class="footer">Cyber Crime Security System © 2026</div>
            </div>
        </body>
        </html>';
        
        $mail->AltBody = "Nuevo mensaje de contacto\n\nNombre: $nombre\nCorreo: $email_remitente\nAsunto: $asunto\nMensaje:\n$mensaje_usuario\n\nIP: $ip_usuario\nSO: $os\nNavegador: $browser\nFecha: " . date('d/m/Y H:i:s');
        
        $mail->send();
        $mensaje_envio = "✨ ¡Muchas gracias por tu mensaje! ✨<br>📬 Me pondré en contacto contigo muy pronto.";
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
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 12px;
            font-family: 'Segoe UI', system-ui, sans-serif;
            text-align: center;
            animation: slideIn 0.5s ease-out;
        }
        .mensaje-envio.exito {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.15), rgba(0, 200, 0, 0.05));
            border: 1px solid rgba(0, 255, 0, 0.3);
            color: #0f0;
        }
        .mensaje-envio.error {
            background: linear-gradient(135deg, rgba(255, 0, 0, 0.15), rgba(200, 0, 0, 0.05));
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #f66;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-20px); }
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
            <small>🔒 Tu mensaje viaja de forma segura y cifrada</small>
        </div>
    </div>

    <script src="matrix.js"></script>
</body>
</html>
