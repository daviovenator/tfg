<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔒 Generador de Tarjetas Virtuales - Testing</title>
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
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .warning {
            background: #e74c3c;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            border-bottom: 3px solid #c0392b;
        }
        
        .form-container {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        select, button {
            width: 100%;
            padding: 12px;
            border: 2px solid #bdc3c7;
            border-radius: 8px;
            font-size: 16px;
        }
        
        button {
            background: #27ae60;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        button:hover {
            background: #219a52;
        }
        
        .results {
            padding: 0 30px 30px;
        }
        
        .tarjeta {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .tarjeta h3 {
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .tarjeta-linea {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 5px 0;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .label {
            font-weight: 600;
        }
        
        .valor {
            font-family: 'Courier New', monospace;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            background: #ecf0f1;
            color: #7f8c8d;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔒 Generador de Tarjetas Virtuales</h1>
            <p>SOLO PARA PRUEBAS Y DESARROLLO</p>
        </div>
        
        <div class="warning">
            ⚠️ ADVERTENCIA: Estos números NO son reales. Solo para testing.
        </div>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="tipo_tarjeta">Tipo de Tarjeta:</label>
                    <select name="tipo_tarjeta" id="tipo_tarjeta">
                        <option value="visa">Visa</option>
                        <option value="mastercard">Mastercard</option>
                        <option value="amex">American Express</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="cantidad">Cantidad a generar:</label>
                    <select name="cantidad" id="cantidad">
                        <option value="1">1 Tarjeta</option>
                        <option value="3">3 Tarjetas</option>
                        <option value="5">5 Tarjetas</option>
                    </select>
                </div>
                
                <button type="submit" name="generar">🎴 Generar Tarjetas</button>
            </form>
        </div>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generar'])) {
            $tipo_tarjeta = $_POST['tipo_tarjeta'] ?? 'visa';
            $cantidad = intval($_POST['cantidad'] ?? 1);
            
            // Incluir la lógica del generador
            include 'logica_generador.php';
            
            $generador = new GeneradorTarjetasWeb();
            
            echo '<div class="results">';
            echo '<h2 style="color: #2c3e50; margin-bottom: 20px;">📋 Resultados Generados:</h2>';
            
            for ($i = 1; $i <= $cantidad; $i++) {
                $tarjeta = $generador->generarTarjetaCompleta($tipo_tarjeta);
                
                echo '<div class="tarjeta">';
                echo '<h3>🎴 Tarjeta ' . $i . ' (' . $tarjeta['tipo_tarjeta'] . ')</h3>';
                
                echo '<div class="tarjeta-linea">';
                echo '<span class="label">👤 Nombre:</span>';
                echo '<span class="valor">' . htmlspecialchars($tarjeta['nombre_completo']) . '</span>';
                echo '</div>';
                
                echo '<div class="tarjeta-linea">';
                echo '<span class="label">🔢 Número:</span>';
                echo '<span class="valor">' . $tarjeta['numero_tarjeta'] . '</span>';
                echo '</div>';
                
                echo '<div class="tarjeta-linea">';
                echo '<span class="label">📅 Expira:</span>';
                echo '<span class="valor">' . $tarjeta['fecha_expiracion'] . '</span>';
                echo '</div>';
                
                echo '<div class="tarjeta-linea">';
                echo '<span class="label">🔐 CVV:</span>';
                echo '<span class="valor">' . $tarjeta['codigo_seguridad'] . '</span>';
                echo '</div>';
                
                echo '<div class="tarjeta-linea">';
                echo '<span class="label">🏠 Dirección:</span>';
                echo '<span class="valor">' . htmlspecialchars(substr($tarjeta['direccion'], 0, 30)) . '...</span>';
                echo '</div>';
                
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
        
        <div class="footer">
            <p>🔐 Este generador crea números que pasan validación Luhn pero NO son reales</p>
            <p>Úsalo solo para pruebas legítimas de desarrollo</p>
        </div>
    </div>
</body>
</html>
