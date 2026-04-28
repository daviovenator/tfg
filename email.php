<?php
$mensaje_envio = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["name"]);
    $asunto = htmlspecialchars($_POST["subject"]);
    $email_remitente = htmlspecialchars($_POST["email"]);
    $mensaje = htmlspecialchars($_POST["message"]);

    // Correo destino fijo
    $destino = "davidcigaran@gmail.com";
    
    // Asunto del correo que llegará a David
    $asunto_completo = "Mensaje de $nombre: $asunto";
    
    // Cuerpo del mensaje
    $cuerpo = "Nombre: $nombre\n";
    $cuerpo .= "Correo del remitente: $email_remitente\n";
    $cuerpo .= "Asunto original: $asunto\n";
    $cuerpo .= "Mensaje:\n$mensaje\n";
    
    // Cabeceras: indicamos que el correo viene del usuario (pero se enviará desde el servidor)
    $cabeceras = "From: $email_remitente\r\n";
    $cabeceras .= "Reply-To: $email_remitente\r\n";
    
    // Envío
    if (mail($destino, $asunto_completo, $cuerpo, $cabeceras)) {
        $mensaje_envio = "✅ Correo enviado con éxito a davidcigaran@gmail.com";
    } else {
        $mensaje_envio = "❌ Error al enviar el correo. Intenta de nuevo más tarde.";
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
        
        <?php if ($mensaje_envio): ?>
            <div class="mensaje-envio"><?php echo $mensaje_envio; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <label for="name">Tu Nombre (o pseudónimo):</label>
            <input type="text" name="name" id="name" placeholder="Ej: HackTheGibson" required>

            <label for="subject">Asunto:</label>
            <input type="text" name="subject" id="subject" placeholder="Asunto del mensaje" required>

            <label for="email">Tu Correo Electrónico:</label>
            <input type="email" name="email" id="email" placeholder="tucorreo@ejemplo.com" required>

            <label for="message">Mensaje:</label>
            <textarea name="message" id="message" placeholder="Escribe tu mensaje aquí..." required></textarea>

            <button type="submit">Enviar</button>
        </form>
    </div>

    <script src="matrix.js"></script> <!-- Efecto de Matrix -->
</body>
</html>
