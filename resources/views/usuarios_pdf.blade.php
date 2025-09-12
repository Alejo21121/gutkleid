<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 20px;
        }
        h1 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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

    <h1>Reporte de Usuarios</h1>

    <table>
        <thead>
            <tr>
                <th>ID Persona</th>
                <th>Documento</th>
                <th>Tipo Doc</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id_persona }}</td>
                <td>{{ $usuario->documento }}</td>
                <td>{{ $usuario->tipoDocumento->nombre ?? 'N/A' }}</td>
                <td>{{ $usuario->nombres }}</td>
                <td>{{ $usuario->apellidos }}</td>
                <td>{{ $usuario->telefono }}</td>
                <td>{{ $usuario->correo }}</td>
                <td>{{ $usuario->rol->nombre ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>