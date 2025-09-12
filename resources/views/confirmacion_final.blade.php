<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Exitosa - Gut Kleid</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container-confirmacion {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .icon-success {
            font-size: 5rem;
            color: #28a745;
        }

        .btn-descargar {
            background-color: #6F4E37;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-descargar:hover {
            background-color: #5a412f;
        }
    </style>
</head>

<body>
    <div class="container-confirmacion text-center">
        <i class="bi bi-check-circle-fill icon-success mb-3"></i>
        <h2 class="mb-3">¡Gracias por tu compra, {{ $factura->cliente->nombres }}!</h2>
        <p class="lead">Tu pedido ha sido procesado exitosamente. Recibirás un correo electrónico con la confirmación y los detalles de tu compra.</p>
        <p><strong>Número de Factura:</strong> #{{ $factura->id_factura_venta }}</p>

        <hr class="my-4">

<h4>Resumen de la compra</h4>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Talla</th>
                    <th>Color</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($factura->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->nombre }}</td>
                        <td>{{ $detalle->talla->talla }}</td>
                        <td>{{ $detalle->color ?? 'N/A' }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>$ {{ number_format($detalle->subtotal + $detalle->iva, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Total a Pagar:</strong></td>
                    <td><strong>$ {{ number_format($factura->total, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

        <div class="mt-4">
            <a href="{{ route('venta.descargarFactura', $factura->id_factura_venta) }}" class="btn-descargar"><i class="bi bi-file-earmark-arrow-down-fill"></i> Descargar Factura</a>
            <a href="{{ route('inicio') }}" class="btn btn-secondary ms-3">Volver al inicio</a>
        </div>
    </div>
</body>

</html>