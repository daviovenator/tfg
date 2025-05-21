<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Crime - Hacking the Pentagon</title>
    <link rel="stylesheet" href="css/virus_style.css">
</head>
<body>
    <div id="matrix"></div> <!-- Fondo de Matrix -->

    <!-- Contenedor de botones arriba a la izquierda -->
    <div class="botones-superiores">
        <a href="index.php" class="inicio-btn">Inicio</a>
    </div>

    <h1>Listado de Virus</h1>

    <!-- Botón de despliegue para la lista de Virus Windows -->
    <button class="toggle-button" onclick="toggleList('windows')">Mostrar/Ocultar Virus en Windows</button>
    <div class="virus-list" id="windows">
        <ul>
            <li><a href="/zips/I_LOVE_YOU.zip">ILOVEYOU</a></li>
            <li><a href="/zips/MyDoom-master.zip">MyDoom</a></li>
            <li><a href="/zips/virus-blaster-main.zip">Blaster</a></li>
            <li><a href="/zips/Sasser-master.zip">Sasser</a></li>
            <li><a href="/zips/stuxnet-main.zip">Stuxnet</a></li>
            <li><a href="/zips/Zeus-translation.zip">Zeus</a></li>
        </ul>
    </div>

    <!-- Botón de despliegue para la lista de Virus Ubuntu -->
    <button class="toggle-button" onclick="toggleList('ubuntu')">Mostrar/Ocultar Virus en Ubuntu</button>
    <div class="virus-list" id="ubuntu">
        <ul>
            <li><a href="/zips/rex-master.zip">Linux.Rex</a></li>
            <li><a href="/zips/linux-backdoor-master.zip">Linux.Backdoor</a></li>
            <li><a href="/zips/ransomware-linux-gpg-master.zip">Ransomware Linux.crypt</a></li>
            <li><a href="/zips/maldev-main.zip">Linux.Maldev.1</a></li>
            <li><a href="/zips/bash-virus-master.zip">Linux.Bash.PB</a></li>
        </ul>
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

    <script src="matrix.js"></script> <!-- Efecto de Matrix -->

    <script>
        // Función para mostrar u ocultar las listas de virus
        function toggleList(id) {
            var list = document.getElementById(id);
            if (list.style.display === "none" || list.style.display === "") {
                list.style.display = "block";
            } else {
                list.style.display = "none";
            }
        }
    </script>
</body>
</html>
