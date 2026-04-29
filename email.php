<?php

// 🚨 Requiere PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de que PHPMailer está instalado con Composer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = htmlspecialchars($_POST["name"]);
    $destinatario = htmlspecialchars($_POST["to_email"]);
    $mensaje = htmlspecialchars($_POST["message"]);

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP (cámbialo si usas otro)
        $mail->SMTPAuth = true;
        $mail->Username = 'asirclean@gmail.com'; // Tu correo SMTP
        $mail->Password = 'jagx whvr ektj iffb'; // Tu contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configurar el remitente (usamos el correo de prueba y el nombre del usuario)
        $mail->setFrom('anonimo@tudominio.com', $nombre);
        $mail->addAddress($destinatario); // Correo del destinatario ingresado por el usuario

        // Contenido del correo
        $mail->isHTML(false);
        $mail->Subject = 'Mensaje Anónimo de ' . $nombre;
        $mail->Body = $mensaje;

        $mail->send();
        echo "Correo enviado con éxito.";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Crime - Hacking the Pentagon</title>
    <link rel="stylesheet" href="css/email_style.css">
</head>
<body>
    <div id="matrix"></div> <!-- Fondo de Matrix -->

    <!-- Contenedor de botones arriba a la izquierda -->
    <div class="botones-superiores">
        <a href="index.php" class="inicio-btn">Inicio</a>
    </div>

    <!-- Menú desplegable -->
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

    <!-- Contenedor de formulario con estilo profesional -->
    <div class="email-form-container">
        <h2>Envía un Correo Electrónico</h2>
        <form method="POST">
            <label for="name">Tu Nombre (o pseudónimo):</label>
            <input type="text" name="name" id="name" placeholder="Tu nombre" required>

            <label for="to_email">Correo del Destinatario:</label>
            <input type="email" name="to_email" id="to_email" placeholder="destinatario@example.com" required>

            <label for="message">Escribe tu mensaje:</label>
            <textarea name="message" id="message" placeholder="Escribe tu mensaje aquí..." required></textarea>

            <button type="submit">Enviar</button>
        </form>
    </div>

    <script src="matrix.js"></script> <!-- Efecto de Matrix -->
</body>
</html><?php
// Configuración básica
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mensaje_envio = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario tradicional
    $nombre = htmlspecialchars(trim($_POST["name"] ?? ''));
    $asunto = htmlspecialchars(trim($_POST["subject"] ?? ''));
    $email_remitente = htmlspecialchars(trim($_POST["email"] ?? ''));
    $mensaje_usuario = htmlspecialchars(trim($_POST["message"] ?? ''));
    
    // Validar que todos los campos estén llenos
    if (empty($nombre) || empty($asunto) || empty($email_remitente) || empty($mensaje_usuario)) {
        $mensaje_envio = "❌ Todos los campos son obligatorios.";
        $tipo_mensaje = "error";
    } else {
        // ============================================
        // INFORMACIÓN TÉCNICA
        // ============================================
        
        // 1. IP del usuario
        $ip_usuario = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';
        if (strpos($ip_usuario, ',') !== false) {
            $ip_usuario = explode(',', $ip_usuario)[0];
        }
        $ip_usuario = trim($ip_usuario);
        
        // 2. User Agent completo
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido';
        
        // 3. Sistema Operativo
        $os = "Desconocido";
        if (preg_match('/Windows NT 10.0/', $user_agent)) $os = "Windows 10";
        elseif (preg_match('/Windows NT 11.0/', $user_agent)) $os = "Windows 11";
        elseif (preg_match('/Windows NT 6.1/', $user_agent)) $os = "Windows 7";
        elseif (preg_match('/Windows NT 6.2/', $user_agent)) $os = "Windows 8";
        elseif (preg_match('/Windows NT 6.3/', $user_agent)) $os = "Windows 8.1";
        elseif (preg_match('/Mac OS X/', $user_agent)) $os = "macOS";
        elseif (preg_match('/Linux/', $user_agent)) $os = "Linux";
        elseif (preg_match('/Android/', $user_agent)) $os = "Android";
        elseif (preg_match('/iPhone/', $user_agent)) $os = "iOS";
        elseif (preg_match('/iPad/', $user_agent)) $os = "iPadOS";
        
        // 4. Navegador y versión
        $browser = "Desconocido";
        $browser_version = "Desconocido";
        if (preg_match('/Chrome/i', $user_agent) && !preg_match('/Edg/i', $user_agent)) {
            $browser = "Google Chrome";
            preg_match('/Chrome\/(\d+)/', $user_agent, $matches);
            $browser_version = $matches[1] ?? 'Desconocido';
        }
        elseif (preg_match('/Firefox/i', $user_agent)) {
            $browser = "Mozilla Firefox";
            preg_match('/Firefox\/(\d+)/', $user_agent, $matches);
            $browser_version = $matches[1] ?? 'Desconocido';
        }
        elseif (preg_match('/Safari/i', $user_agent) && !preg_match('/Chrome/i', $user_agent)) {
            $browser = "Safari";
            preg_match('/Version\/(\d+)/', $user_agent, $matches);
            $browser_version = $matches[1] ?? 'Desconocido';
        }
        elseif (preg_match('/Edg/i', $user_agent)) {
            $browser = "Microsoft Edge";
            preg_match('/Edg\/(\d+)/', $user_agent, $matches);
            $browser_version = $matches[1] ?? 'Desconocido';
        }
        elseif (preg_match('/Opera/i', $user_agent) || preg_match('/OPR/i', $user_agent)) {
            $browser = "Opera";
            preg_match('/Opera\/(\d+)/', $user_agent, $matches);
            $browser_version = $matches[1] ?? 'Desconocido';
        }
        
        // 5. Idioma del navegador
        $idioma = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'Desconocido';
        $idioma_principal = explode(',', $idioma)[0];
        
        // 6. Página de origen (referer)
        $pagina_origen = $_SERVER['HTTP_REFERER'] ?? 'Directo o desconocido';
        
        // 7. Página actual
        $pagina_actual = $_SERVER['REQUEST_URI'] ?? 'Desconocida';
        
        // 8. Fecha y hora
        $fecha_servidor = date('d/m/Y H:i:s');
        
        // ============================================
        // ENVÍO DE CORREO
        // ============================================
        
        $mail = new PHPMailer(true);
        
        try {
            // Configuración SMTP de Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'asirclean@gmail.com';
            $mail->Password   = 'jagx whvr ektj iffb'; // Tu contraseña de aplicación
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
            
            // Cuerpo del mensaje
            $mail->Body = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 20px;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #ffffff;
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    }
                    .header {
                        background-color: #2c3e50;
                        color: white;
                        padding: 20px;
                        text-align: center;
                    }
                    .header h1 {
                        margin: 0;
                        font-size: 20px;
                    }
                    .content {
                        padding: 25px;
                    }
                    .info-block {
                        margin-bottom: 20px;
                        padding: 15px;
                        background-color: #f8f9fa;
                        border-left: 4px solid #3498db;
                        border-radius: 4px;
                    }
                    .info-label {
                        font-weight: bold;
                        color: #2c3e50;
                        margin-bottom: 5px;
                        font-size: 12px;
                        text-transform: uppercase;
                    }
                    .info-value {
                        color: #333;
                        font-size: 14px;
                        word-break: break-word;
                    }
                    .message-box {
                        background-color: #f8f9fa;
                        padding: 15px;
                        border-radius: 4px;
                        margin-top: 10px;
                        line-height: 1.6;
                    }
                    .footer {
                        background-color: #ecf0f1;
                        padding: 15px;
                        text-align: center;
                        font-size: 11px;
                        color: #7f8c8d;
                    }
                    hr {
                        margin: 20px 0;
                        border: none;
                        border-top: 1px solid #ddd;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>📋 NUEVO MENSAJE DE CONTACTO</h1>
                    </div>
                    <div class="content">
                        <div class="info-block">
                            <div class="info-label">👤 NOMBRE</div>
                            <div class="info-value">' . $nombre . '</div>
                        </div>
                        
                        <div class="info-block">
                            <div class="info-label">📧 CORREO ELECTRÓNICO</div>
                            <div class="info-value">' . $email_remitente . '</div>
                        </div>
                        
                        <div class="info-block">
                            <div class="info-label">📌 ASUNTO</div>
                            <div class="info-value">' . $asunto . '</div>
                        </div>
                        
                        <div class="info-block">
                            <div class="info-label">💬 MENSAJE</div>
                            <div class="message-box">' . nl2br(htmlspecialchars($mensaje_usuario)) . '</div>
                        </div>
                        
                        <hr>
                        
                        <div class="info-block">
                            <div class="info-label">🖥️ INFORMACIÓN TÉCNICA</div>
                            <div class="info-value">
                                <strong>IP:</strong> ' . $ip_usuario . '<br>
                                <strong>Sistema Operativo:</strong> ' . $os . '<br>
                                <strong>Navegador:</strong> ' . $browser . ' ' . $browser_version . '<br>
                                <strong>Idioma:</strong> ' . $idioma_principal . '<br>
                                <strong>Fecha:</strong> ' . $fecha_servidor . '
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        Este mensaje fue enviado desde el formulario de contacto de Cyber Crime System<br>
                        © ' . date('Y') . ' Cyber Crime Security
                    </div>
                </div>
            </body>
            </html>';
            
            // Versión texto plano
            $mail->AltBody = "NUEVO MENSAJE DE CONTACTO\n\n";
            $mail->AltBody .= "Nombre: $nombre\n";
            $mail->AltBody .= "Email: $email_remitente\n";
            $mail->AltBody .= "Asunto: $asunto\n\n";
            $mail->AltBody .= "Mensaje:\n$mensaje_usuario\n\n";
            $mail->AltBody .= "--- Información técnica ---\n";
            $mail->AltBody .= "IP: $ip_usuario\n";
            $mail->AltBody .= "SO: $os\n";
            $mail->AltBody .= "Navegador: $browser $browser_version\n";
            $mail->AltBody .= "Fecha: $fecha_servidor";
            
            $mail->send();
            $mensaje_envio = "✅ ¡Mensaje enviado con éxito!<br>📬 Me pondré en contacto contigo muy pronto.";
            $tipo_mensaje = "exito";
            
        } catch (Exception $e) {
            $mensaje_envio = "❌ Error al enviar el mensaje: " . $mail->ErrorInfo;
            $tipo_mensaje = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Crime - Contacto Seguro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .email-form-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            margin-top: 15px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
            margin-top: 25px;
        }

        button:hover {
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .mensaje-envio {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
            animation: slideIn 0.5s ease-out;
        }

        .mensaje-envio.exito {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .mensaje-envio.error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .botones-superiores {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }

        .inicio-btn {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            padding: 10px 20px;
            border-radius: 25px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .inicio-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .dropdown {
            position: fixed;
            top: 20px;
            right: 20px;
            display: inline-block;
            z-index: 1000;
        }

        .dropbtn {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .dropbtn:hover {
            background: rgba(255,255,255,0.3);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: rgba(0,0,0,0.9);
            backdrop-filter: blur(10px);
            min-width: 180px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .dropdown-content a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateX(5px);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .info-seguridad {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }

        @media (max-width: 768px) {
            .email-form-container {
                margin: 20px;
                padding: 25px;
            }
            
            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
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
        
        <form method="POST" action="">
            <label for="name">🕵️ Tu Nombre o Alias:</label>
            <input type="text" name="name" id="name" placeholder="Ej: Neo / Trinity / ZeroCool" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">

            <label for="subject">📌 Asunto:</label>
            <input type="text" name="subject" id="subject" placeholder="Motivo de tu mensaje" required value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">

            <label for="email">✉️ Tu Correo Electrónico:</label>
            <input type="email" name="email" id="email" placeholder="usuario@ejemplo.com" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

            <label for="message">💬 Mensaje:</label>
            <textarea name="message" id="message" placeholder="Escribe tu mensaje aquí..." rows="6" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>

            <button type="submit">🚀 Enviar Mensaje</button>
        </form>
        
        <div class="info-seguridad">
            <small>🔒 Tu mensaje viaja de forma segura y cifrada</small>
        </div>
    </div>
</body>
</html>
