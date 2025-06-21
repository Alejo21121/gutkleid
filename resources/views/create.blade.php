<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/estiloagre.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>
<body>

@if (session('mensaje'))
    <div class="mensaje éxito">
        {{ session('mensaje') }}
    </div>
@endif

<form action="{{ route('producto.store') }}" method="POST">
    @csrf
    <h2>Agregar Producto</h2>

    <label for="id_producto">ID Producto:</label>
    <input type="number" name="id_producto" id="id_producto" required>

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required>

    <label for="valor">Valor:</label>
    <input type="text" name="valor" id="valor" required>

    <label for="marca">Marca:</label>
    <input type="text" name="marca" id="marca" required>

    <label for="talla">Talla:</label>
    <input type="text" name="talla" id="talla" required>

    <label for="color">Color:</label>
    <input type="text" name="color" id="color" required>

    <label for="categoria">Categoría:</label>
    <input type="text" name="categoria" id="categoria" required>

    <button type="submit">Agregar Producto</button>
    <center><a href="{{ url('producto') }}" class="btn-menu">Volver al Menú Principal</a></center>
</form>
<br>
</body>
</html>
