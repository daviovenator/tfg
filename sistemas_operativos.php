<?php
session_start();

// 🚨 Bloquear agentes vacíos o sospechosos
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
if (empty($user_agent) || preg_match('/(curl|wget|bot|spider|crawler)/i', $user_agent)) {
    http_response_code(403);
    exit('Acceso no permitido');
}

// 🧠 Validar IP (opcional: lista blanca o bloqueos)
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
if (!filter_var($ip, FILTER_VALIDATE_IP)) {
    http_response_code(400);
    exit('IP inválida');
}

// 🚫 Filtrar headers maliciosos
foreach (getallheaders() as $key => $value) {
    if (preg_match('/(base64|<script|data:|javascript:)/i', $value)) {
        http_response_code(403);
        exit('Header sospechoso');
    }
}

// 🧼 Limitar velocidad por sesión (rate limit)
$time = time();
if (!isset($_SESSION['last_request_time'])) {
    $_SESSION['last_request_time'] = $time;
    $_SESSION['request_count'] = 1;
} else {
    if ($time - $_SESSION['last_request_time'] < 5) {
        $_SESSION['request_count']++;
        if ($_SESSION['request_count'] > 10) {
            http_response_code(429); // Too Many Requests
            exit('Demasiadas solicitudes. Intenta más tarde.');
        }
    } else {
        $_SESSION['last_request_time'] = $time;
        $_SESSION['request_count'] = 1;
    }
}

// 🚫 Prevención XSS, Clickjacking, CSRF
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header("Referrer-Policy: no-referrer");

// 🔐 HSTS (HTTPS obligatorio, requiere HTTPS en servidor real)
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');

// 🧼 Función para limpiar datos
function limpiar_xss($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// 👮 Verificación de acceso
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistemas Operativos - ASIR</title>
    <link rel="stylesheet" href="css/sistemas_style.css">
</head>
<body>
    <div id="matrix"></div> <!-- Fondo de Matrix -->

    <!-- Botón de retroceso (Inicio) -->
    <button class="inicio-btn" onclick="window.history.back();">Atrás</button>

    <h1>Sistemas Operativos - ASIR</h1>

    <!-- Sección de contenido -->
    <div class="section-container">
        <div class="section-box">
            <h2>Ubuntu</h2>
            <p>Ubuntu es una distribución de Linux basada en Debian, fácil de usar y ampliamente utilizada en entornos educativos y de servidores. Aquí aprenderás a utilizar comandos como:</p>
            <ul>
                <li><code>mkdir</code> para crear directorios</li>
                <li><code>useradd</code> para crear usuarios</li>
                <li><code>chmod</code> para cambiar permisos</li>
                <li><code>sudo</code> para ejecutar comandos con privilegios de administrador</li>
            </ul>
            <p>También aprenderás a gestionar redes y servicios dentro de un sistema Ubuntu.</p>
        </div>
        <div class="section-box">
            <h2>Windows</h2>
            <p>En el entorno Windows, nos centraremos en el uso de la interfaz gráfica, pero también aprenderás conceptos clave como:</p>
            <ul>
                <li>Gestión de usuarios y grupos</li>
                <li>Administración de Windows Server</li>
                <li>Configuración de DNS, IIS y Active Directory</li>
                <li>Directivas de grupo (GPO)</li>
            </ul>
            <p>Los sistemas Windows son fundamentales en la gestión de empresas y redes grandes.</p>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 ASIR Academy - Ciberseguridad y Desarrollo</p>
    </footer>

    <script src="matrix.js"></script> <!-- Animación Matrix -->
</body>
</html>


