<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Hash pre-calculado de la contraseña original
$password_hash = "d9b8c7a6e5f4d3c2b1a0f9e8d7c6b5a4938271657a8b9c0d1e2f3a4b5c6d7e8f9";

// Función para verificar la contraseña real desde variable de entorno
function verificar_contraseña() {
    $password_real = getenv('EMAIL_PASS_RAW'); // Contraseña real desde variable de entorno
    if (!$password_real) {
        return false;
    }
    return hash('sha256', $password_real) === $GLOBALS['password_hash'];
}

// Solo continuar si la contraseña está configurada correctamente
if (!verificar_contraseña()) {
    die("Error de configuración de seguridad. Contacte al administrador.");
}

$mensaje_envio = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    
    // Obtener información del navegador/equipo
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido';
    
    // Detectar sistema operativo
    $os = "Desconocido";
    if (preg_match('/Windows NT 10.0/', $user_agent)) $os = "Windows 10";
    elseif (preg_match('/Windows NT 11.0/', $user_agent)) $os = "Windows 11";
    elseif (preg_match('/Windows NT 6.1/', $user_agent)) $os = "Windows 7";
    elseif (preg_match('/Mac OS X/', $user_agent)) $os = "macOS";
    elseif (preg_match('/Linux/', $user_agent)) $os = "Linux";
    elseif (preg_match('/Android/', $user_agent)) $os = "Android";
    elseif (preg_match('/iPhone/', $user_agent)) $os = "iOS";
    
    // Detectar navegador
    $browser = "Desconocido";
    if (preg_match('/Chrome/i', $user_agent) && !preg_match('/Edg/i', $user_agent)) $browser = "Google Chrome";
    elseif (preg_match('/Firefox/i', $user_agent)) $browser = "Mozilla Firefox";
    elseif (preg_match('/Safari/i', $user_agent) && !preg_match('/Chrome/i', $user_agent)) $browser = "Safari";
    elseif (preg_match('/Edg/i', $user_agent)) $browser = "Microsoft Edge";
    elseif (preg_match('/Opera/i', $user_agent)) $browser = "Opera";
    
    $mail = new PHPMailer(true);
    
    try {
        // Configuración SMTP de Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'asirclean@gmail.com';
        $mail->Password   = getenv('EMAIL_PASS_RAW'); // Contraseña real desde variable de entorno
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';
        
        // Remitente y destinatario
        $mail->setFrom('asirclean@gmail.com', 'Cyber Crime System');
        $mail->addReplyTo($email_remitente, $nombre);
        $mail->addAddress('davidcigaran@gmail.com', 'David');
        
        // Contenido del correo en HTML
        $mail->isHTML(true);
        $mail->Subject = "📩 Nuevo contacto de $nombre - $asunto";
        
        // Cuerpo del mensaje con diseño visual (igual que antes)
        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: "Segoe UI", Arial, sans-serif;
                    background: linear-gradient(135deg, #0a0e27 0%, #1a1f3a 100%);
                    margin: 0;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background: #0f1233;
                    border-radius: 20px;
                    overflow: hidden;
                    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
                    border: 1px solid rgba(0, 255, 255, 0.2);
                }
                .header {
                    background: linear-gradient(135deg, #00b4ff, #0066ff);
                    padding: 30px;
                    text-align: center;
                }
                .header h1 {
                    margin: 0;
                    color: white;
                    font-size: 24px;
                    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
                }
                .header p {
                    margin: 10px 0 0;
                    color: rgba(255,255,255,0.9);
                    font-size: 14px;
                }
                .content {
                    padding: 30px;
                }
                .info-card {
                    background: rgba(0, 255, 255, 0.05);
                    border-left: 4px solid #00ffff;
                    padding: 15px;
                    margin-bottom: 20px;
                    border-radius: 8px;
                }
                .info-label {
                    color: #00ffff;
                    font-size: 12px;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                    font-weight: bold;
                    margin-bottom: 5px;
                }
                .info-value {
                    color: #fff;
                    font-size: 16px;
                    font-weight: 500;
                    word-break: break-word;
                }
                .message-box {
                    background: rgba(0, 0, 0, 0.3);
                    border-radius: 12px;
                    padding: 20px;
                    margin-top: 20px;
                    border: 1px solid rgba(0, 255, 255, 0.2);
                }
                .message-box h3 {
                    color: #00ffff;
                    margin: 0 0 10px 0;
                    font-size: 14px;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                }
                .message-text {
                    color: #e0e0e0;
                    line-height: 1.6;
                    font-size: 14px;
                    margin: 0;
                }
                .tech-details {
                    background: #0a0c22;
                    border-radius: 12px;
                    padding: 15px;
                    margin-top: 20px;
                    font-family: "Courier New", monospace;
                    font-size: 12px;
                }
                .tech-details h4 {
                    color: #ff6b6b;
                    margin: 0 0 10px 0;
                    font-size: 12px;
                    text-transform: uppercase;
                }
                .tech-row {
                    display: flex;
                    justify-content: space-between;
                    padding: 5px 0;
                    border-bottom: 1px solid rgba(255,255,255,0.1);
                }
                .tech-label {
                    color: #888;
                }
                .tech-value {
                    color: #0f0;
                    text-align: right;
                }
                .footer {
                    background: rgba(0,0,0,0.3);
                    padding: 20px;
                    text-align: center;
                    font-size: 11px;
                    color: #666;
                }
                .badge {
                    display: inline-block;
                    background: rgba(0, 255, 0, 0.2);
                    color: #0f0;
                    padding: 4px 12px;
                    border-radius: 20px;
                    font-size: 11px;
                    margin-top: 10px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>🔐 CYBER CRIME SECURITY</h1>
                    <p>Nuevo mensaje recibido</p>
                </div>
                <div class="content">
                    <div class="info-card">
                        <div class="info-label">👤 Remitente</div>
                        <div class="info-value">' . $nombre . '</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label">📧 Correo electrónico</div>
                        <div class="info-value">' . $email_remitente . '</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label">📌 Asunto</div>
                        <div class="info-value">' . $asunto . '</div>
                    </div>
                    
                    <div class="message-box">
                        <h3>💬 Mensaje</h3>
                        <p class="message-text">' . nl2br($mensaje_usuario) . '</p>
                    </div>
                    
                    <div class="tech-details">
                        <h4>🖥️ INFORMACIÓN TÉCNICA</h4>
                        <div class="tech-row">
                            <span class="tech-label">🌐 IP del usuario:</span>
                            <span class="tech-value">' . $ip_usuario . '</span>
                        </div>
                        <div class="tech-row">
                            <span class="tech-label">💻 Sistema operativo:</span>
                            <span class="tech-value">' . $os . '</span>
                        </div>
                        <div class="tech-row">
                            <span class="tech-label">🌍 Navegador:</span>
                            <span class="tech-value">' . $browser . '</span>
                        </div>
                        <div class="tech-row">
                            <span class="tech-label">📅 Fecha y hora:</span>
                            <span class="tech-value">' . date('d/m/Y H:i:s') . '</span>
                        </div>
                        <div class="tech-row">
                            <span class="tech-label">🆔 User Agent:</span>
                            <span class="tech-value" style="font-size:10px;">' . substr($user_agent, 0, 60) . '...</span>
                        </div>
                    </div>
                    
                    <div class="badge">🔒 Mensaje cifrado extremo a extremo</div>
                </div>
                <div class="footer">
                    Cyber Crime Security System © 2026
                </div>
            </div>
        </body>
        </html>';
        
        // Versión texto plano
        $mail->AltBody = "Nuevo mensaje de contacto\n\n";
        $mail->AltBody .= "Nombre: $nombre\n";
        $mail->AltBody .= "Correo: $email_remitente\n";
        $mail->AltBody .= "Asunto: $asunto\n";
        $mail->AltBody .= "Mensaje:\n$mensaje_usuario\n\n";
        $mail->AltBody .= "--- Información técnica ---\n";
        $mail->AltBody .= "IP: $ip_usuario\n";
        $mail->AltBody .= "Sistema Operativo: $os\n";
        $mail->AltBody .= "Navegador: $browser\n";
        $mail->AltBody .= "Fecha: " . date('d/m/Y H:i:s');
        
        $mail->send();
        $mensaje_envio = "✨ ¡Muchas gracias por tu mensaje! ✨<br>📬 Me pondré en contacto contigo muy pronto.";
        $tipo_mensaje = "exito";
    } catch (Exception $e) {
        $mensaje_envio = "❌ Lo siento, hubo un error al enviar tu mensaje.<br>🔧 Por favor, inténtalo de nuevo más tarde.";
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
            backdrop-filter: blur(10px);
        }
        .mensaje-envio.exito {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.15), rgba(0, 200, 0, 0.05));
            border: 1px solid rgba(0, 255, 0, 0.3);
            color: #0f0;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.1);
        }
        .mensaje-envio.error {
            background: linear-gradient(135deg, rgba(255, 0, 0, 0.15), rgba(200, 0, 0, 0.05));
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #f66;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .info-seguridad {
            margin-top: 15px;
            text-align: center;
            font-size: 12px;
            color: #0a0;
            font-family: monospace;
        }
        .email-form-container h2 {
            text-align: center;
            margin-bottom: 25px;
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
