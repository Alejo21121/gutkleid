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

            <div class="mb-3">
                <label for="sexo">Sexo:</label>
                <select name="sexo" class="form-control" required>
                    <option value="Hombre" {{ strtolower(old('sexo', $producto->sexo ?? '')) == 'hombre' ? 'selected' : '' }}>Hombre</option>
                    <option value="Mujer" {{ strtolower(old('sexo', $producto->sexo ?? '')) == 'mujer' ? 'selected' : '' }}>Mujer</option>
                    <option value="Unisex" {{ strtolower(old('sexo', $producto->sexo ?? '')) == 'unisex' ? 'selected' : '' }}>Unisex</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">Color:</label>
                <input type="text" name="color" value="{{ old('color', $producto->color) }}" class="form-control" required>
            </div>

            {{-- Categoría --}}
            <div class="mb-3">
                <label for="id_categoria">Categoría:</label>
                <select name="id_categoria" id="id_categoria" required onchange="mostrarSubcategorias()">
                    <option value="">Seleccione una categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}" 
                            data-subcategorias='@json($categoria->subcategorias)' 
                            {{ $categoria->id_categoria == $producto->id_categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Subcategoría --}}
            <div class="mb-3" id="subcategoria-container" style="display:none;">
                <label for="id_subcategoria">Subcategoría:</label>
                <select name="id_subcategoria" id="id_subcategoria"></select>
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
        let contador = {{ $producto->tallas->count() }};
        let productoSubcategoria = {{ $producto->id_subcategoria ?? 'null' }};

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

        // Manejo de subcategorías dinámicas
        function mostrarSubcategorias() {
            let categoriaSelect = document.getElementById('id_categoria');
            let subcategoriaContainer = document.getElementById('subcategoria-container');
            let subcategoriaSelect = document.getElementById('id_subcategoria');

            subcategoriaSelect.innerHTML = "";

            let option = categoriaSelect.options[categoriaSelect.selectedIndex];
            let subcategorias = option.getAttribute('data-subcategorias');

            if (subcategorias) {
                subcategorias = JSON.parse(subcategorias);

                if (subcategorias.length > 0) {
                    subcategoriaContainer.style.display = "block";

                    let emptyOpt = document.createElement("option");
                    emptyOpt.value = "";
                    emptyOpt.textContent = "-- Seleccione una subcategoría --";
                    subcategoriaSelect.appendChild(emptyOpt);

                    subcategorias.forEach(sub => {
                        let opt = document.createElement("option");
                        opt.value = sub.id_subcategoria;
                        opt.textContent = sub.nombre;

                        if (productoSubcategoria === sub.id_subcategoria) {
                            opt.selected = true;
                        }

                        subcategoriaSelect.appendChild(opt);
                    });
                } else {
                    subcategoriaContainer.style.display = "none";
                }
            } else {
                subcategoriaContainer.style.display = "none";
            }
        }

        // Ejecutar al cargar la página
        window.onload = mostrarSubcategorias;
    </script>
</body>
</html>
