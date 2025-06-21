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

<div class="container">     

    <form action="{{ route('producto.update', $producto->id_producto) }}" method="POST">
        @csrf
        @method('PUT')
    <center><h2>Editar Producto</h2></center>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor:</label>
            <input type="number" name="valor" value="{{ old('valor', $producto->valor) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="marca" class="form-label">Marca:</label>
            <input type="text" name="marca" value="{{ old('marca', $producto->marca) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="talla" class="form-label">Talla:</label>
            <input type="text" name="talla" value="{{ old('talla', $producto->talla) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Color:</label>
            <input type="text" name="color" value="{{ old('color', $producto->color) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría:</label>
            <input type="text" name="categoria" value="{{ old('categoria', $producto->categoria) }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <center><a href="{{ url('producto') }}" class="btn-menu">Volver al Menú Principal</a></center>
    </form>
</div>x
<br>
</body>
</html>
