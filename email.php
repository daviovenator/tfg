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
        <a href="hackeo.php" class="inicio-btn">Inicio</a>
        <a href="logout.php" class="salir-btn">Salir</a>
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
</html>
