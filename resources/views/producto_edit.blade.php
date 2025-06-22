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
            <input type="text" name="valor" id="valor" value="{{ old('valor', number_format($producto->valor, 0, ',', '.')) }}" required oninput="formatearNumero(this)">
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
            <label for="id_categoria">Categoría:</label>
                <select name="id_categoria" id="id_categoria" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}" {{ $categoria->id_categoria == $producto->id_categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
        </div>

        <div class="mb-3">
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" min="0" value="{{ old('cantidad', $producto->cantidad) }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <center><a href="{{ url('producto') }}" class="btn-menu">Volver al Menú Principal</a></center>
    </form>
</div>x
<br>
</body>
</html>
