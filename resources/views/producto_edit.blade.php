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
            <center>
                <h2>Editar Producto</h2>
            </center>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="valor" class="form-label">Valor:</label>
                <input type="text" name="valor" id="valor" value="{{ old('valor', $producto->valor) }}" class="form-control" required oninput="formatearNumero(this)">

            </div>

            <div class="mb-3">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" name="marca" value="{{ old('marca', $producto->marca) }}" class="form-control" required>
            </div>

            <label for="sexo">Sexo:</label>
            <select name="sexo" class="form-control" required>
                <option value="Hombre" {{ old('sexo', $producto->sexo ?? '') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                <option value="Mujer" {{ old('sexo', $producto->sexo ?? '') == 'Mujer' ? 'selected' : '' }}>Mujer</option>
            </select>


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

            <h4>Tallas y cantidades:</h4>

            <div id="contenedor-tallas">
                @foreach ($producto->tallas as $index => $talla)
                <div class="fila-talla">
                    <input type="text" name="tallas[{{ $index }}][talla]" value="{{ $talla->talla }}" class="form-control me-2" placeholder="Talla" required>
                    <input type="number" name="tallas[{{ $index }}][cantidad]" value="{{ $talla->cantidad }}" class="form-control me-2" placeholder="Cantidad" min="0" required>
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                @endforeach
            </div>

            <div class="botones-acciones">
                <button type="button" class="btn btn-success" onclick="agregarTalla()">Agregar otra talla</button>
                <button type="submit" class="btn btn-success">Actualizar</button>
            </div>

            <center><a href="{{ url('producto') }}" class="btn-menu">Volver al Menú Principal</a></center>
        </form>
    </div>
    <br>

    <script>
        let contador = {
            {
                $producto - > tallas - > count()
            }
        };

        function agregarTalla() {
            const contenedor = document.getElementById('contenedor-tallas');
            const div = document.createElement('div');
            div.classList.add('mb-2', 'd-flex', 'align-items-center', 'fila-talla');

            div.innerHTML = `
            <input type="text" name="tallas[${contador}][talla]" class="form-control me-2" placeholder="Talla" required>
            <input type="number" name="tallas[${contador}][cantidad]" class="form-control me-2" placeholder="Cantidad" min="0" required>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
        `;

            contenedor.appendChild(div);
            contador++;
        }
    </script>

</body>

</html>