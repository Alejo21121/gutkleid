<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $factura->id_factura_venta }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 30px;
        }

        h2 {
            margin: 0;
            color: #6F4E37;
        }

        .logo {
            width: 140px;
            height: auto;
        }

        .seccion-titulo {
            background-color: #6F4E37;
            color: white;
            padding: 6px;
            margin-top: 25px;
            font-weight: bold;
        }

        .tabla-datos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .tabla-datos th, .tabla-datos td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }

        .tabla-datos th {
            background-color: #f4f4f4;
            color: #6F4E37;
        }

        .totales {
            margin-top: 20px;
            text-align: right;
        }

        .totales p {
            margin: 4px 0;
        }

        .footer {
            font-size: 10px;
            text-align: center;
            margin-top: 40px;
            color: #888;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            height: auto;
        }

        .datos-empresa {
            text-align: right;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <!-- Encabezado con Logo (izquierda) y datos (derecha) -->
    <div class="encabezado">
        <div>
            <img src="{{ public_path('IMG/LOGO3_cafe.jpg') }}" class="logo" alt="Logo Gut Kleid">
        </div>
        <div class="datos-empresa">
            <h2>Gut Kleid</h2>
            <p><strong>NIT:</strong> {{ $factura->nit_tienda }}</p>
            <p><strong>Teléfono:</strong> {{ $factura->telef_tienda }}</p>
            <p><strong>Dirección:</strong> {{ $factura->dire_tienda }}</p>
            <p><strong>Fecha:</strong> {{ $factura->fecha_venta }}</p>
        </div>
    </div>

    <!-- Sección Cliente -->
    <div class="seccion-titulo">Datos del Cliente</div>
    <table class="tabla-datos">
        <tr>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Teléfono</th>
        </tr>
        <tr>
            <td>{{ $factura->cliente->nombres }} {{ $factura->cliente->apellidos }}</td>
            <td>{{ $factura->cliente->documento }}</td>
            <td>{{ $factura->cliente->correo }}</td>
            <td>{{ $factura->cliente->direccion }}</td>
            <td>{{ $factura->cliente->telefono }}</td>
        </tr>
    </table>

    <!-- Sección Productos -->
    <div class="seccion-titulo">Detalle de Productos</div>
    <table class="tabla-datos">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Talla</th>
                <th>Cantidad</th>
                <th>Valor Unitario</th>
                <th>Subtotal</th>
                <th>IVA</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $subtotalGeneral = 0;
                $ivaGeneral = 0;
            @endphp

            @foreach ($factura->detalles as $detalle)
                @php
                    $cantidad = $detalle->cantidad;
                    $valorUnitario = $detalle->producto->valor;
                    $subtotal = $valorUnitario * $cantidad;
                    $iva = $detalle->iva;
                    $total = $subtotal + $iva;
                    $subtotalGeneral += $subtotal;
                    $ivaGeneral += $iva;
                @endphp
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->talla ?? 'N/A' }}</td>
                    <td>{{ number_format($cantidad, 0) }}</td>
                    <td>${{ number_format($valorUnitario, 0, ',', '.') }}</td>
                    <td>${{ number_format($subtotal, 0, ',', '.') }}</td>
                    <td>${{ number_format($iva, 0, ',', '.') }}</td>
                    <td>${{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totales -->
    <div class="seccion-titulo">Totales</div>
    <div class="totales">
        <p><strong>Subtotal:</strong> ${{ number_format($subtotalGeneral, 0, ',', '.') }}</p>
        <p><strong>IVA Total:</strong> ${{ number_format($ivaGeneral, 0, ',', '.') }}</p>
        <p><strong>Gastos de envío:</strong> ${{ number_format($factura->envio, 0, ',', '.') }}</p>
        <p><strong>Total a pagar:</strong> <strong style="color:#6F4E37;">${{ number_format($factura->total, 0, ',', '.') }}</strong></p>
    </div>


    <!-- Footer -->
    <div class="footer">
        Gracias por tu compra. Cualquier duda o reclamo escríbenos a soporte@gutkleid.com <br>
        © Gut Kleid 2025 – Todos los derechos reservados.
    </div>

</body>
</html>
