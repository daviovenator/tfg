<?php
class GeneradorTarjetasWeb {
    private $bins_testing;
    
    public function __construct() {
        // BINs específicos para testing
        $this->bins_testing = [
            'visa' => ['4111', '4012', '4222', '4539', '4556'],      
            'mastercard' => ['5100', '5200', '5500', '5432', '5123'],
            'amex' => ['3400', '3700', '3782', '3714']
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
    
    public function generarDireccion() {
        $calles = ['CALLE GRAN VÍA', 'AVENIDA LIBERTAD', 'CALLE MAYOR', 'PLAZA ESPAÑA', 'CALLE ALCALÁ', 'PASEO GRACIA'];
        $numeros = ['123', '45', '67', '89', '12', '34'];
        $ciudades = ['MADRID', 'BARCELONA', 'VALENCIA', 'SEVILLA', 'BILBAO', 'MÁLAGA'];
        $codigos = ['28013', '08001', '46001', '41001', '48001', '29001'];
        
        $calle = $calles[array_rand($calles)];
        $numero = $numeros[array_rand($numeros)];
        $ciudad = $ciudades[array_rand($ciudades)];
        $codigo = $codigos[array_rand($codigos)];
        
        return "$calle $numero, $ciudad, $codigo";
    }
    
    public function generarTarjetaCompleta($tipo = 'visa') {
        return [
            'nombre_completo' => $this->generarNombreCompleto(),
            'numero_tarjeta' => $this->generarNumeroRealista($tipo),
            'fecha_expiracion' => $this->generarFechaExpiracion(),
            'codigo_seguridad' => $this->generarCodigoSeguridad($tipo),
            'tipo_tarjeta' => strtoupper($tipo),
            'direccion' => $this->generarDireccion()
        ];
    }
}
?>
