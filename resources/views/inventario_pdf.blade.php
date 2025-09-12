<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
            margin: 30px;
        }

        h1 {
            text-align: center;
            color: #6F4E37;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .tabla-inventario {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .tabla-inventario th,
        .tabla-inventario td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
        }

        .tabla-inventario th {
            background-color: #f4f4f4;
            color: #6F4E37;
            font-weight: bold;
        }

        .fila-producto {
            page-break-inside: avoid;
        }

        .totales {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }
        
    </style>
</head>
<body>

    <h1>Reporte de Inventario</h1>

    <table class="tabla-inventario">
        <thead>
            <tr>
                <th>Referencia</th>
                <th>Nombre</th>
                <th>Valor</th>
                <th>IVA (19%)</th>
                <th>Marca</th>
                <th>Sexo</th>
                <th>Talla (Cant.)</th>
                <th>Color</th>
                <th>Categoría</th>
                <th>Cantidad Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
            @php
                $tallas_cant = $producto->tallas->map(function ($talla) {
                    return "{$talla->talla} ({$talla->cantidad})";
                })->implode(', ');
                $iva = $producto->valor * 0.19;
            @endphp
            <tr class="fila-producto">
                <td>{{ $producto->id_producto }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>${{ number_format($producto->valor, 0, ',', '.') }}</td>
                <td>${{ number_format($iva, 0, ',', '.') }}</td>
                <td>{{ $producto->marca }}</td>
                <td>{{ $producto->sexo }}</td>
                <td>{{ $tallas_cant }}</td>
                <td>{{ $producto->color }}</td>
                <td>{{ $producto->categoria->nombre ?? 'N/A' }} -> {{ $producto->subcategoria->nombre ?? 'N/A' }}</td>
                <td>{{ $producto->tallas->sum('cantidad') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="totales">
        Total de productos registrados: {{ $productos->count() }}
    </div>

</body>
</html>
