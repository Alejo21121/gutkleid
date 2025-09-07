<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Compra</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333333;
        }
        .email-container {
            max-width: 700px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            padding: 25px;
            text-align: center;
            color: white;
        }
        .logo {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .email-content {
            padding: 30px;
        }
        .factura-info {
            margin: 20px 0;
            background-color: #f8f9fa;
            border-left: 4px solid #4b6cb7;
            padding: 15px;
        }
        .factura-info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }
        table thead {
            background-color: #4b6cb7;
            color: white;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
        }
        .email-footer {
            background-color: #f0f0f0;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }
        .email-footer a {
            color: #4b6cb7;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="logo">GutKleid</div>
            <h2>Factura de tu compra</h2>
        </div>
        <div class="email-content">
            <p>Hola <strong>{{ $cliente->nombres ?? 'Cliente' }}</strong>,</p>
            <p>Gracias por tu compra. Aquí tienes los detalles de tu pedido:</p>
            
            <div class="factura-info">
                <p><strong>Factura #:</strong> {{ $factura->id_factura_venta }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($factura->fecha_venta)->format('d/m/Y H:i') }}</p>
                <p><strong>Documento:</strong> {{ $cliente->documento ?? 'N/A' }}</p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Talla</th>
                        <th>Cantidad</th>
                        <th>Total (c/IVA)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($factura->detalles as $d)
                    <tr>
                        <td>{{ $d->producto->nombre ?? 'Producto' }}</td>
                        <td>{{ $d->talla->talla ?? '-' }}</td>
                        <td>{{ $d->cantidad }}</td>
                        <td>${{ number_format(($d->subtotal + $d->iva), 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="total">Total a pagar: ${{ number_format($factura->total, 0, ',', '.') }}</p>
            <p class="total">Envío: ${{ number_format($factura->envio, 0, ',', '.') }}</p>
            
            <p>Si necesitas ayuda, responde a este correo. ❤️</p>
        </div>
        <div class="email-footer">
            <p>© 2025 GUTKLEID. Todos los derechos reservados.</p>
            <p>Este es un mensaje automático, por favor no respondas directamente.</p>
            <p>Contacto: <a href="mailto:gutkleidbs@gmail.com">gutkleidbs@gmail.com</a></p>
        </div>
    </div>
</body>
</html>
