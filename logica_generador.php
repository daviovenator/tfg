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
                'nombre' => 'VISA'
            ],
            'mastercard' => [
                'fondo' => 'linear-gradient(135deg, #eb001b 0%, #f79e1b 100%)',
                'color_texto' => '#ffffff',
                'logo_color' => '#ffffff',
                'nombre' => 'MasterCard'
            ],
            'amex' => [
                'fondo' => 'linear-gradient(135deg, #0070ba 0%, #2e7ebd 100%)',
                'color_texto' => '#ffffff',
                'logo_color' => '#ffffff',
                'nombre' => 'American Express'
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
        $nombre_base = strtolower($nombres[0]);
        $apellido_base = strtolower($nombres[1]);
        
        $dominios = ['gmail.com', 'hotmail.com', 'yahoo.es', 'outlook.com', 'icloud.com'];
        $dominio = $dominios[array_rand($dominios)];
        
        $variaciones = [
            "$nombre_base.$apellido_base",
            "$nombre_base" . substr($apellido_base, 0, 3),
            $nombres[0][0] . $apellido_base,
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
            'piso' => "$pisoº $puerta",
            'ciudad' => $ciudad,
            'codigo_postal' => $codigo_postal,
            'completa' => "C/ $calle, $numero, $pisoº $puerta, $codigo_postal $ciudad"
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

    public function mostrarTarjetaHTML($datos_tarjeta) {
        $estilo = $datos_tarjeta['estilo_tarjeta'];
        
        $html = "
        <div class='tarjeta' style='
            background: {$estilo['fondo']};
            color: {$estilo['color_texto']};
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            font-family: Arial, sans-serif;
            width: 400px;
            height: 250px;
            position: relative;
            overflow: hidden;
        '>
            <div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;'>
                <div style='font-size: 24px; font-weight: bold;'>{$estilo['nombre']}</div>
                <div style='font-size: 18px; opacity: 0.9;'>● ● ● ●</div>
            </div>
            
            <div style='font-size: 22px; letter-spacing: 2px; margin-bottom: 30px; font-weight: bold;'>
                {$datos_tarjeta['numero_tarjeta']}
            </div>
            
            <div style='display: flex; justify-content: space-between; align-items: flex-end;'>
                <div>
                    <div style='font-size: 12px; opacity: 0.8;'>TITULAR</div>
                    <div style='font-size: 16px; font-weight: bold;'>{$datos_tarjeta['nombre_completo']}</div>
                </div>
                <div>
                    <div style='font-size: 12px; opacity: 0.8;'>EXPIRA</div>
                    <div style='font-size: 16px; font-weight: bold;'>{$datos_tarjeta['fecha_expiracion']}</div>
                </div>
            </div>
            
            <div style='position: absolute; bottom: 20px; right: 25px; font-size: 14px; opacity: 0.7;'>
                CVV: {$datos_tarjeta['codigo_seguridad']}
            </div>
        </div>";
        
        return $html;
    }
}

// Ejemplo de uso
$generador = new GeneradorTarjetasWeb();

// Generar tarjetas de diferentes tipos
$tipos = ['visa', 'mastercard', 'amex'];

foreach ($tipos as $tipo) {
    $tarjeta = $generador->generarTarjetaCompleta($tipo);
    
    echo "<h3>Tarjeta {$tarjeta['tipo_tarjeta']} Generada:</h3>";
    echo $generador->mostrarTarjetaHTML($tarjeta);
    
    echo "<div style='background: #f5f5f5; padding: 15px; margin: 10px 0; border-radius: 8px;'>";
    echo "<strong>Datos completos:</strong><br>";
    echo "Nombre: {$tarjeta['nombre_completo']}<br>";
    echo "Email: {$tarjeta['email']}<br>";
    echo "Teléfono: {$tarjeta['telefono']}<br>";
    echo "Dirección: {$tarjeta['direccion_completa']}<br>";
    echo "Número: {$tarjeta['numero_tarjeta']}<br>";
    echo "Expira: {$tarjeta['fecha_expiracion']}<br>";
    echo "CVV: {$tarjeta['codigo_seguridad']}<br>";
    echo "</div>";
    echo "<hr>";
}
?>
