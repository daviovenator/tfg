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
    <title>Base de Datos - Temas de ASIR</title>
    <link rel="stylesheet" href="css/base_style.css"> <!-- Link al CSS profesional -->
</head>
<body>
    <div id="matrix"></div> <!-- Fondo de Matrix -->

    <!-- Botón Inicio -->
    <button class="inicio-btn"><a href="hackeo.php">Atrás</a></button>

    <!-- Título principal -->
    <h1>Base de Datos</h1>

    <!-- Sección de contenido sobre Base de Datos -->
    <div class="section-container">
        <div class="section-box">
            <h2>¿Qué son las Bases de Datos?</h2>
            <p>Las bases de datos son sistemas que permiten almacenar, organizar y recuperar grandes cantidades de datos de forma eficiente. Son fundamentales en aplicaciones web, donde la información de los usuarios, productos, y transacciones se guarda de manera estructurada y accesible.</p>
            <p>Las bases de datos pueden clasificarse en dos tipos principales: bases de datos relacionales (como MySQL, PostgreSQL) y bases de datos no relacionales (como MongoDB, Redis).</p>
        </div>

        <div class="section-box">
            <h2>Tipos de Bases de Datos</h2>
            <ul>
                <li><strong>Relacionales:</strong> Organizan los datos en tablas relacionadas entre sí. Ejemplo: <strong>MySQL</strong>, <strong>PostgreSQL</strong>.</li>
                <li><strong>No Relacionales:</strong> Almacenan los datos de forma más flexible, sin necesidad de una estructura tabular rígida. Ejemplo: <strong>MongoDB</strong>, <strong>Redis</strong>.</li>
                <li><strong>En la Nube:</strong> Proporcionan bases de datos escalables a través de plataformas en la nube. Ejemplo: <strong>AWS RDS</strong>, <strong>Google Cloud SQL</strong>.</li>
            </ul>
        </div>

        <div class="section-box">
            <h2>¿Por qué son Importantes?</h2>
            <p>Las bases de datos son cruciales para el almacenamiento de datos que debe ser accesible, seguro y escalable. Son la columna vertebral de muchas aplicaciones modernas, como tiendas en línea, plataformas de redes sociales y sistemas de gestión empresarial.</p>
            <p>El conocimiento de bases de datos es esencial para el desarrollo de aplicaciones web, ya que nos permite integrar y gestionar la información de forma eficiente y eficaz.</p>
        </div>
    </div>

    <!-- Pie de página con información adicional -->
    <footer>
        <p>© 2025 ASIR - Todos los derechos reservados.</p>
    </footer>

    <script src="matrix.js"></script> <!-- Efecto de Matrix -->
</body>
</html>




