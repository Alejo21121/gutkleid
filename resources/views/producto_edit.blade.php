<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/estiloagre.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="IMG/icono2.ico" type="image/x-icon">
</head>
<body>
<header class="cabeza">
    <nav class="barras">
        <!-- CENTRO -->
        <div class="nav-center">
            <a href="/">
                <div class="logo">
                    <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
                </div>
            </a>
        </div>

        <!-- DERECHA -->
        <div class="nav-right">
            <div class="usuario-info">
                @if (session('usuario'))
                    <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
                    <a href="{{ route('cuenta') }}">
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}" alt="Perfil" class="perfil-icono">
                    </a>
                    <a href="{{ route('logout') }}" class="filter-btn"><i class="bi bi-door-open"></i></a>
                @else
                    <a href="{{ route('login') }}" class="inis">
                        <p class="filter-btn">INICIAR SESION</p>
                    </a>
                @endif

                <!-- Carrito -->
                <a href="{{ route('carrito.index') }}" class="fontcarr">
                    <i class="bi bi-cart3"></i>
                </a>
            </div>
        </div>
    </nav>
    <hr>

    <main class="main">
        <form action="{{ route('producto.update', $producto->id_producto) }}" method="POST" class="formedit">
            @csrf
            @method('PUT')
            <center><h2>Editar Producto</h2></center>

            <!-- 🔹 Contenedor en flex -->
            <div class="contenedor-flex">
                <!-- Bloque 1: Datos del producto -->
                <div class="contenedor-producto">
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

                    <div class="mb-3" id="subcategoria-container" style="display:none;">
                        <label for="id_subcategoria">Subcategoría:</label>
                        <select name="id_subcategoria" id="id_subcategoria"></select>
                    </div>
                </div>

                <!-- Bloque 2: Tallas -->
                <div class="contenedor-tallas">
                    <h4>Tallas y cantidades:</h4>
                    <div id="contenedor-tallas">
                        @foreach ($producto->tallas as $index => $talla)
                            <div class="fila-talla d-flex align-items-center mb-2">
                                <input type="text" name="tallas[{{ $index }}][talla]" value="{{ $talla->talla }}" class="form-label" placeholder="Talla" required>
                                <input type="number" name="tallas[{{ $index }}][cantidad]" value="{{ $talla->cantidad }}" class="form-label" placeholder="Cantidad" min="0" required>
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="botones-acciones">
                <button type="button" class="botoncategor" onclick="agregarTalla()">Agregar otra talla</button>
                <button type="submit" class="botoningre">Actualizar</button>
            </div>

            <center><a href="{{ url('producto') }}" class="volve">Volver al Menú Principal</a></center>
        </form>
    </main>

    <br>

    <footer class="pie">
        <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
        <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
        <a href="{{ route('reseñas') }}" class="abaj">Reseñas</a>
        <a href="{{ route('tiendas') }}" class="abaj">Tiendas</a>
        <a href="{{ route('redes') }}" class="abaj">Redes</a>
        <br><br>
        <p>&copy; 2024 - GUT KLEID.</p>
    </footer>
</header>

<script>
    let contador = {{ $producto->tallas->count() }};
    let productoSubcategoria = {{ $producto->id_subcategoria ?? 'null' }};

    function agregarTalla() {
        const contenedor = document.getElementById('contenedor-tallas');
        const div = document.createElement('div');
        div.classList.add('fila-talla', 'd-flex', 'align-items-center', 'mb-2');

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

    window.onload = mostrarSubcategorias;
</script>
</body>
</html>
