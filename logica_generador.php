<?php
class GeneradorTarjetasWeb {
    private $bins_testing;
    private $estilos_tarjetas;
    
    public function __construct() {
        // BINs específicos para testing
        $this->bins_testing = [
            'visa' => ['4111', '4012', '4222', '4539', '4556'],      
            'mastercard' => ['5100', '5200', '5500', '5432', '5123'],
            'amex' => ['3400', '3700', '3782', '3714']
        ];

        // Estilos CSS para cada tipo de tarjeta
        $this->estilos_tarjetas = [
            'visa' => [
                'fondo' => 'linear-gradient(135deg, #1a1f71 0%, #3a5ccc 100%)',
                'color_texto' => '#ffffff',
                'logo_color' => '#ffffff',
                'nombre' => 'VISA',
                'logo' => 'VISA'
            ],
            'mastercard' => [
                'fondo' => 'linear-gradient(135deg, #eb001b 0%, #f79e1b 100%)',
                'color_texto' => '#ffffff',
                'logo_color' => '#ffffff',
                'nombre' => 'MasterCard',
                'logo' => 'MASTERCARD'
            ],
            'amex' => [
                'fondo' => 'linear-gradient(135deg, #0070ba 0%, #2e7ebd 100%)',
                'color_texto' => '#ffffff',
                'logo_color' => '#ffffff',
                'nombre' => 'American Express',
                'logo' => 'AMEX'
            ]
        ];
    }
    
    private function algoritmoLuhn($numero) {
        $numero = str_replace(' ', '', $numero);
        $sum = 0;
        $alt = false;
        
        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $n = intval($numero[$i]);
            if ($alt) {
                $n *= 2;
                if ($n > 9) {
                    $n = ($n % 10) + 1;
                }
            }
            $sum += $n;
            $alt = !$alt;
        }
        
        return ($sum % 10 == 0);
    }
    
    private function calcularDigitoVerificacion($numero) {
        $numero = str_replace(' ', '', $numero);
        $sum = 0;
        $alt = true;
        
        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $n = intval($numero[$i]);
            if ($alt) {
                $n *= 2;
                if ($n > 9) {
                    $n = ($n % 10) + 1;
                }
            }
            $sum += $n;
            $alt = !$alt;
        }
        
        return (10 - ($sum % 10)) % 10;
    }
    
    public function generarNumeroRealista($tipo = 'visa') {
        if (!isset($this->bins_testing[$tipo])) {
            $tipo = 'visa';
        }
        
        // Seleccionar BIN aleatorio
        $bin_base = $this->bins_testing[$tipo][array_rand($this->bins_testing[$tipo])];
        
        // Completar hasta 15 dígitos
        $numero = $bin_base;
        $digitos_necesarios = 15 - strlen($numero);
        
        for ($i = 0; $i < $digitos_necesarios; $i++) {
            $numero .= rand(0, 9);
        }
        
        // Calcular dígito de verificación
        $digito_verificacion = $this->calcularDigitoVerificacion($numero);
        $numero_completo = $numero . $digito_verificacion;
        
        // Formatear con espacios cada 4 dígitos
        return implode(' ', str_split($numero_completo, 4));
    }
    
    public function generarFechaExpiracion() {
        $meses_futuro = rand(12, 36); // 1 a 3 años en futuro
        $fecha = new DateTime();
        $fecha->modify("+$meses_futuro months");
        return $fecha->format('m/y');
    }
    
    public function generarCodigoSeguridad($tipo = 'visa') {
        if ($tipo === 'amex') {
            return str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } else {
            return str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        }
    }
    
    public function generarNombreCompleto() {
        $nombres = ['CARLOS', 'ANA', 'LUIS', 'MARIA', 'JAVIER', 'ELENA', 'DAVID', 'LAURA', 'PEDRO', 'SOFIA'];
        $apellidos = ['GARCIA', 'RODRIGUEZ', 'GONZALEZ', 'FERNANDEZ', 'LOPEZ', 'MARTINEZ', 'SANCHEZ', 'PEREZ', 'GOMEZ', 'MARTIN'];
        
        $nombre = $nombres[array_rand($nombres)];
        $apellido1 = $apellidos[array_rand($apellidos)];
        $apellido2 = $apellidos[array_rand($apellidos)];
        
        return "$nombre $apellido1 $apellido2";
    }

    public function generarTelefonoEspanol() {
        $prefijos = ['600', '601', '602', '603', '604', '605', '606', '607', '608', '609', 
                    '610', '611', '612', '613', '614', '615', '616', '617', '618', '619',
                    '650', '651', '652', '653', '654', '655', '656', '657', '658', '659',
                    '680', '681', '682', '683', '684', '685', '686', '687', '688', '689',
                    '690', '691', '692', '693', '694', '695', '696', '697', '698', '699'];
        
        $prefijo = $prefijos[array_rand($prefijos)];
        $sufijo = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        return "+34 $prefijo $sufijo";
    }

    public function generarEmail($nombre_completo) {
        $nombres = explode(' ', $nombre_completo);
        $nombre_base = strtolower($nombres[0] ?? 'usuario'); // CORREGIDO: valor por defecto
        $apellido_base = strtolower($nombres[1] ?? 'test');  // CORREGIDO: valor por defecto
        
        $dominios = ['gmail.com', 'hotmail.com', 'yahoo.es', 'outlook.com', 'icloud.com'];
        $dominio = $dominios[array_rand($dominios)];
        
        $variaciones = [
            "$nombre_base.$apellido_base",
            "$nombre_base" . substr($apellido_base, 0, 3),
            ($nombres[0][0] ?? 'u') . $apellido_base, // CORREGIDO: valor por defecto
            "$nombre_base" . rand(10, 99)
        ];
        
        $usuario = $variaciones[array_rand($variaciones)];
        return "$usuario@$dominio";
    }
    
    public function generarDireccionCompleta() {
        $ciudades = [
            'MADRID' => [
                'calles' => ['GRAN VÍA', 'ALCALÁ', 'PRECIADOS', 'FUENCARRAL', 'ATOCHA', 'SERRANO'],
                'codigos' => ['28001', '28013', '28014', '28015', '28020', '28028']
            ],
            'BARCELONA' => [
                'calles' => ['LAS RAMBLAS', 'PASEO DE GRACIA', 'DIAGONAL', 'ARAGÓN', 'MUNTANER', 'VALENCIA'],
                'codigos' => ['08001', '08002', '08007', '08008', '08009', '08015']
            ],
            'VALENCIA' => [
                'calles' => ['COLÓN', 'RUZAFÁ', 'XÀTIVA', 'GUILLEM DE CASTRO', 'BLASCO IBÁÑEZ', 'GRAN VÍA'],
                'codigos' => ['46001', '46002', '46003', '46004', '46005', '46010']
            ],
            'SEVILLA' => [
                'calles' => ['TETUÁN', 'SIERPES', 'ASUNCIÓN', 'RECAREDO', 'LUIS MONTOTO', 'SAN JACINTO'],
                'codigos' => ['41001', '41002', '41003', '41004', '41008', '41010']
            ],
            'BILBAO' => [
                'calles' => ['GRAN VÍA', 'AUTONOMÍA', 'LICENCIADO POZA', 'ERCILLA', 'ALAMEDA URQUIJO', 'SABINO ARANA'],
                'codigos' => ['48001', '48002', '48003', '48004', '48008', '48009']
            ]
        ];
        
        $ciudad = array_rand($ciudades);
        $calle = $ciudades[$ciudad]['calles'][array_rand($ciudades[$ciudad]['calles'])];
        $codigo_postal = $ciudades[$ciudad]['codigos'][array_rand($ciudades[$ciudad]['codigos'])];
        $numero = rand(1, 200);
        $piso = rand(1, 10);
        $puerta = chr(rand(65, 70)); // A-F
        
        return [
            'calle' => "C/ $calle, $numero",
            'piso' => "{$piso}º $puerta",
            'ciudad' => $ciudad,
            'codigo_postal' => $codigo_postal,
            'completa' => "C/ $calle, $numero, {$piso}º $puerta, $codigo_postal $ciudad"
        ];
    }

    public function obtenerEstiloTarjeta($tipo) {
        return $this->estilos_tarjetas[$tipo] ?? $this->estilos_tarjetas['visa'];
    }
    
    public function generarTarjetaCompleta($tipo = 'visa') {
        $nombre_completo = $this->generarNombreCompleto();
        $direccion = $this->generarDireccionCompleta();
        $email = $this->generarEmail($nombre_completo);
        $telefono = $this->generarTelefonoEspanol();
        $estilo = $this->obtenerEstiloTarjeta($tipo);
        
        return [
            'nombre_completo' => $nombre_completo,
            'numero_tarjeta' => $this->generarNumeroRealista($tipo),
            'fecha_expiracion' => $this->generarFechaExpiracion(),
            'codigo_seguridad' => $this->generarCodigoSeguridad($tipo),
            'tipo_tarjeta' => strtoupper($tipo),
            'direccion_completa' => $direccion['completa'],
            'direccion_detallada' => $direccion,
            'email' => $email,
            'telefono' => $telefono,
            'estilo_tarjeta' => $estilo
        ];
    }

    public function mostrarTarjetaDobleCara($datos_tarjeta) {
        $estilo = $datos_tarjeta['estilo_tarjeta'];
        
        $html = "
        <div style='display: flex; justify-content: center; margin: 40px 0; gap: 30px; flex-wrap: wrap;'>
            
            <!-- CARA FRONTAL -->
            <div class='cara-frontal' style='
                background: {$estilo['fondo']};
                color: {$estilo['color_texto']};
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 15px 35px rgba(0,0,0,0.3);
                font-family: \"Arial\", sans-serif;
                width: 450px;
                height: 280px;
                position: relative;
                overflow: hidden;
                transition: transform 0.5s ease;
                transform-style: preserve-3d;
            '>
                
                <!-- Logo de la tarjeta -->
                <div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;'>
                    <div style='font-size: 28px; font-weight: bold; letter-spacing: 1px;'>{$estilo['logo']}</div>
                    <div style='font-size: 20px; opacity: 0.9;'>● ● ● ●</div>
                </div>
                
                <!-- Chip -->
                <div style='width: 50px; height: 40px; background: linear-gradient(45deg, gold, orange); border-radius: 8px; margin-bottom: 20px;'></div>
                
                <!-- Número de tarjeta -->
                <div style='font-size: 24px; letter-spacing: 3px; margin-bottom: 40px; font-weight: bold; text-align: center;'>
                    {$datos_tarjeta['numero_tarjeta']}
                </div>
                
                <!-- Información inferior -->
                <div style='display: flex; justify-content: space-between; align-items: flex-end;'>
                    <div style='flex: 2;'>
                        <div style='font-size: 12px; opacity: 0.8; margin-bottom: 5px;'>TITULAR</div>
                        <div style='font-size: 16px; font-weight: bold; letter-spacing: 1px;'>{$datos_tarjeta['nombre_completo']}</div>
                    </div>
                    <div style='flex: 1; text-align: right;'>
                        <div style='font-size: 12px; opacity: 0.8; margin-bottom: 5px;'>EXPIRA</div>
                        <div style='font-size: 18px; font-weight: bold;'>{$datos_tarjeta['fecha_expiracion']}</div>
                    </div>
                </div>
                
                <!-- Efectos decorativos -->
                <div style='position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;'></div>
                <div style='position: absolute; bottom: -30px; left: -30px; width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 50%;'></div>
            </div>
            
            <!-- CARA TRASERA -->
            <div class='cara-trasera' style='
                background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
                color: white;
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 15px 35px rgba(0,0,0,0.3);
                font-family: \"Arial\", sans-serif;
                width: 450px;
                height: 280px;
                position: relative;
                overflow: hidden;
                transition: transform 0.5s ease;
                transform-style: preserve-3d;
            '>
                
                <!-- Banda magnética -->
                <div style='background: #2c3e50; height: 50px; margin: -30px -30px 20px -30px;'></div>
                <div style='background: #000; height: 40px; margin-bottom: 30px;'></div>
                
                <!-- Franja para firma -->
                <div style='background: #ecf0f1; height: 40px; margin-bottom: 20px; border-radius: 5px; position: relative;'>
                    <div style='position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: #7f8c8d; font-size: 12px;'>
                        Firma del titular
                    </div>
                    <div style='position: absolute; top: 50%; right: 10px; transform: translateY(-50%); background: white; color: #34495e; padding: 2px 8px; border-radius: 3px; font-size: 10px;'>
                        {$datos_tarjeta['codigo_seguridad']}
                    </div>
                </div>
                
                <!-- CVV -->
                <div style='background: white; color: #2c3e50; padding: 15px; border-radius: 8px; text-align: center; margin-top: 20px;'>
                    <div style='font-size: 12px; margin-bottom: 5px;'>CÓDIGO DE SEGURIDAD</div>
                    <div style='font-size: 24px; font-weight: bold; letter-spacing: 3px;'>
                        {$datos_tarjeta['codigo_seguridad']}
                    </div>
                    <div style='font-size: 10px; color: #7f8c8d; margin-top: 5px;'>
                        CVV - No compartir este código
                    </div>
                </div>
                
                <!-- Información de contacto -->
                <div style='position: absolute; bottom: 15px; left: 30px; right: 30px; font-size: 10px; color: #bdc3c7; text-align: center;'>
                    {$estilo['nombre']} • Servicio al cliente 24h
                </div>
                
                <!-- Efectos decorativos traseros -->
                <div style='position: absolute; top: 60px; right: 30px; font-size: 12px; color: #7f8c8d;'>
                    ●●●
                </div>
            </div>
        </div>";
        
        return $html;
    }
}

// INTERFAZ WEB COMPLETA
echo "
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Generador de Tarjetas de Prueba</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.5em;
        }
        .form-group {
            text-align: center;
            margin-bottom: 40px;
        }
        select, button {
            padding: 15px 25px;
            font-size: 18px;
            border: none;
            border-radius: 10px;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        select {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            min-width: 200px;
        }
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .tarjeta-container {
            display: flex;
            justify-content: center;
            margin: 40px 0;
        }
        .datos-tarjeta {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin-top: 30px;
            border-left: 5px solid #667eea;
        }
        .datos-tarjeta h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        .info-item {
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .cara-frontal:hover, .cara-trasera:hover {
            transform: translateY(-10px) rotateY(5deg);
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🎴 Generador de Tarjetas de Prueba</h1>
        
        <div class='form-group'>
            <form method='POST'>
                <select name='tipo_tarjeta'>
                    <option value='visa'" . (($_POST['tipo_tarjeta'] ?? '') == 'visa' ? ' selected' : '') . ">VISA</option>
                    <option value='mastercard'" . (($_POST['tipo_tarjeta'] ?? '') == 'mastercard' ? ' selected' : '') . ">MasterCard</option>
                    <option value='amex'" . (($_POST['tipo_tarjeta'] ?? '') == 'amex' ? ' selected' : '') . ">American Express</option>
                </select>
                <button type='submit' name='generar'>🔄 Generar Tarjeta</button>
            </form>
        </div>
";

// Generar tarjeta según selección
$generador = new GeneradorTarjetasWeb();
$tipo_seleccionado = $_POST['tipo_tarjeta'] ?? 'visa';

if (isset($_POST['generar'])) {
    $tarjeta = $generador->generarTarjetaCompleta($tipo_seleccionado);
    
    echo "<h2 style='text-align: center; color: #333; margin-bottom: 30px;'>Tarjeta {$tarjeta['tipo_tarjeta']} Generada</h2>";
    echo $generador->mostrarTarjetaDobleCara($tarjeta);
    
    echo "<div class='datos-tarjeta'>";
    echo "<h3>📋 Datos Completos de la Tarjeta:</h3>";
    echo "<div class='info-item'><strong>👤 Nombre:</strong> {$tarjeta['nombre_completo']}</div>";
    echo "<div class='info-item'><strong>📧 Email:</strong> {$tarjeta['email']}</div>";
    echo "<div class='info-item'><strong>📞 Teléfono:</strong> {$tarjeta['telefono']}</div>";
    echo "<div class='info-item'><strong>🏠 Dirección:</strong> {$tarjeta['direccion_completa']}</div>";
    echo "<div class='info-item'><strong>💳 Número:</strong> {$tarjeta['numero_tarjeta']}</div>";
    echo "<div class='info-item'><strong>📅 Expira:</strong> {$tarjeta['fecha_expiracion']}</div>";
    echo "<div class='info-item'><strong>🔒 CVV:</strong> {$tarjeta['codigo_seguridad']}</div>";
    echo "<div class='info-item'><strong>🎴 Tipo:</strong> {$tarjeta['tipo_tarjeta']}</div>";
    echo "</div>";
}

echo "
    </div>
</body>
</html>
";
?>
