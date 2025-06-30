<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Imágenes de {{ $producto->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <h2>Imágenes de: {{ $producto->nombre }}</h2>

    {{-- Mensajes de éxito o error --}}
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    {{-- Mostrar formulario solo si tiene menos de 4 imágenes --}}
    @if ($producto->imagenes->count() < 4)
        <form action="{{ route('producto.imagenes.subir', $producto->id_producto) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="imagenes" class="form-label">Subir nuevas imágenes</label>
                <input type="file" name="imagenes[]" multiple class="form-control" accept="image/*">
                <small class="text-muted">Puedes subir hasta {{ 4 - $producto->imagenes->count() }} imagen(es) más.</small>
            </div>
            <button type="submit" class="btn btn-primary">Subir</button>
            <a href="{{ route('producto.index') }}" class="btn btn-secondary">Volver</a>
        </form>
    @else
        <div class="alert alert-warning mt-3">
            ⚠️ Este producto ya tiene 4 imágenes. No puedes subir más.
        </div>
        <a href="{{ route('producto.index') }}" class="btn btn-secondary mt-2">Volver</a>
    @endif

    {{-- Mostrar imágenes existentes --}}
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
