<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
        }
        h1, h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reporte de Ventas - GUT KLEID</h1>
    <table>
        <thead>
            <tr>
                <th># Factura</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Valor</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->id_factura_venta }}</td>
                <td>{{ $venta->fecha_venta }}</td>
                <td>{{ $venta->cliente->nombres }} - {{ $venta->cliente->documento }}</td>
                <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                <td>Vendido</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>