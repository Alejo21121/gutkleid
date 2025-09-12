<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Compras</title>
<style>
body {
font-family: Arial, sans-serif;
margin: 0;
padding: 20px;
font-size: 12px;
}
h1 {
text-align: center;
font-size: 24px;
margin-bottom: 20px;
}
table {
width: 100%;
border-collapse: collapse;
margin-bottom: 20px;
}
th, td {
border: 1px solid #ddd;
padding: 8px;
text-align: left;
}
th {
background-color: #f2f2f2;
font-size: 14px;
}
td {
font-size: 12px;
}
.header {
text-align: center;
margin-bottom: 20px;
}
</style>
</head>
<body>

<div class="header">
    <h1>Reporte de Compras - Gut Kleid</h1>
    <p>Fecha de Generación: {{ date('d/m/Y') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th># Factura</th>
            <th>Fecha</th>
            <th>Proveedor</th>
            <th>Valor</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($compras as $compra)
        <tr>
            <td>{{ $compra->id_factura_compras }}</td>
            <td>{{ $compra->fecha_compra }}</td>
            <td>{{ $compra->proveedor->nombre ?? 'N/A' }}</td>
            <td>${{ number_format($compra->valor, 0, ',', '.') }}</td>
            <td>{{ $compra->estado }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>