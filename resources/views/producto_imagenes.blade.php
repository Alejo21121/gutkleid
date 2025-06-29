<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Imágenes de {{ $producto->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <h2>Imágenes de: {{ $producto->nombre }}</h2>

    <form action="{{ route('producto.imagenes.subir', $producto->id_producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="imagenes" class="form-label">Subir nuevas imágenes</label>
            <input type="file" name="imagenes[]" multiple class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Subir</button>
        <a href="{{ route('producto.index') }}" class="btn btn-secondary">Volver</a>
    </form>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <div class="row mt-4">
        @foreach ($producto->imagenes as $imagen)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <img src="{{ asset('storage/' . $imagen->ruta) }}" class="card-img-top" alt="Imagen del producto">
                    <div class="card-body text-center">
                        <form action="{{ route('imagenes.eliminar', $imagen->id_imagen) }}" method="POST" onsubmit="return confirm('¿Eliminar esta imagen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>
