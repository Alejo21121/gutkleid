<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gut Kleid</title>
        <link rel="stylesheet" href="{{ asset('CSS/estilocreation.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
        <link rel="icon" href="IMG/icono2.ico" class="imagenl" type="image/x-icon" >
</head>
<body>
<header class="cabeza">
    <nav class="barras">
        <!-- CENTRO -->
        <div class="nav-center">
            <a href="/">
            <div class="logo">
                <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
            </div></a>
        </div>

        <!-- DERECHA -->
        <div class="nav-right">
            <div class="usuario-info">
                @if (session('usuario'))
                    <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
                    <a href="{{ route('cuenta') }}">
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}"
                             alt="Perfil"
                             class="perfil-icono">
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
    @if (session('mensaje'))
    <div class="alerta-exito">
        {{ session('mensaje') }}
    </div>
    @endif
<form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h2 class="titulopag">Agregar Producto</h2>

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required>

    <label for="valor">Valor:</label>
    <input type="text" name="valor" id="valor" required oninput="formatearNumero(this)">

    <label for="marca">Marca:</label>
    <input type="text" name="marca" id="marca" required>

    <label for="sexo">Sexo:</label>
    <select name="sexo" class="form-control" required>
        <option value="">Seleccione el sexo</option>
        <option value="Hombre" {{ old('sexo', $producto->sexo ?? '') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
        <option value="Mujer" {{ old('sexo', $producto->sexo ?? '') == 'Mujer' ? 'selected' : '' }}>Mujer</option>
        <option value="Unisex" {{ old('sexo', $producto->sexo ?? '') == 'Unisex' ? 'selected' : '' }}>Unisex</option>
    </select>

    <label for="color">Color:</label>
    <input type="text" name="color" id="color" required>

    <!-- Categoría -->
    <div class="mb-3">
        <div class="d-flex align-items-center justify-content-between gap-2">
            <label for="id_categoria" class="form-label">Categoría:</label>
        </div>
        <select name="id_categoria" id="id_categoria" class="form-control mt-2" required onchange="mostrarSubcategorias()">
            <option value="">Seleccione una categoría</option>
            @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id_categoria }}"
                data-subcategorias='@json($categoria->subcategorias)'>
                {{ $categoria->nombre }}
            </option>
            @endforeach
        </select>
        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalCategoria">
            Editar Categoría
        </button>
    </div>

    <!-- Subcategoría -->
    <div id="subcategoria-container" style="display:none;" class="mb-3">
        <div class="d-flex align-items-center justify-content-between gap-2">
            <label for="id_subcategoria" class="form-label">Subcategoría:</label>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#modalSubcategoria">
                Editar Subcategoría
            </button>
        </div>
        <select name="id_subcategoria" id="id_subcategoria" class="form-control mt-2"></select>
    </div>

    <!-- 👇 Campo para imágenes -->
    <div class="mb-3">
    <label for="imagenes">Imágenes (puedes subir varias):</label>
    <input type="file" name="imagenes[]" multiple>
    </div>

    <!-- Tallas y cantidades -->
    <label class="form-label">Tallas y cantidades:</label>
    <div id="tallas-container">
        <div class="row g-2 align-items-center talla-item mb-2">
            <div class="col-md-4">
                <input type="text" name="tallas[0][talla]" class="form-control" placeholder="Talla" required>
            </div>
            <div class="col-md-4">
                <input type="number" name="tallas[0][cantidad]" class="form-control" placeholder="Cantidad" min="0" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger w-100" onclick="eliminarTalla(this)"><i class="bi bi-x"></i></button>
            </div>
        </div>
    </div>

    <br>
    <button type="button" class="botoncategor" onclick="agregarTalla()"><i class="bi bi-arrow-down-circle"></i> Agregar otra talla</button>
        <button type="submit" class="botoningre">Agregar Producto</button>
    <center><a href="{{ url('producto') }}" class="volve">Volver al Menú Principal</a></center>
</form>
</main>
    <!-- Modal Administrar Categoría -->
    <div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="modalCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCategoriaLabel">Administrar Categorías</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <!-- FORM CREAR -->
                    <form action="{{ route('categorias.store') }}" method="POST" class="mb-3">
                        @csrf
                        <label for="nombre_categoria">Nombre de categoría:</label>
                        <input type="text" name="nombre" id="nombre_categoria" class="form-control" required>

                        <label for="genero">Género:</label>
                        <select name="genero" id="genero" class="form-control" required>
                            <option value="hombre">Hombre</option>
                            <option value="mujer">Mujer</option>
                            <option value="unisex" selected>Unisex</option>
                        </select>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-success w-100"><i class="bi bi-arrow-down-circle"></i> Crear Categoría</button>
                        </div>
                    </form>

                    <hr>

                    <!-- FORM ELIMINAR -->
                    <form action="{{ route('categorias.destroy', 0) }}" method="POST"
                        onsubmit="event.preventDefault(); confirmarEliminar(this)">
                        @csrf
                        @method('DELETE')

                        <label for="id_categoria_delete">Eliminar categoría:</label>
                        <select name="id" id="id_categoria_delete" class="form-control" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-danger w-100"><i class="bi bi-x"></i> Eliminar Categoría</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal Crear/Eliminar Subcategoría -->
    <div class="modal fade" id="modalSubcategoria" tabindex="-1" aria-labelledby="modalSubcategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalSubcategoriaLabel">Administrar Subcategorías</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Formulario crear subcategoría -->
                    <form action="{{ route('subcategorias.store') }}" method="POST" class="mb-3">
                        @csrf
                        <label for="id_categoria_modal">Categoría:</label>
                        <select name="id_categoria" id="id_categoria_modal" class="form-control mb-2" required>
                            @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>

                        <label for="nombre_subcategoria">Nombre de subcategoría:</label>
                        <input type="text" name="nombre" id="nombre_subcategoria" class="form-control mb-3" required>

                        <button type="submit" class="btn btn-success w-100">✅ Crear Subcategoría</button>
                    </form>

                    <hr>

                    <!-- Formulario eliminar subcategoría -->
                    <form id="formEliminarSubcategoria" method="POST">
                        @csrf
                        @method('DELETE')

                        <!-- Select de categoría -->
                        <label for="categoria_eliminar">Categoría:</label>
                        <select id="categoria_eliminar" class="form-control mb-2" required onchange="cargarSubcategoriasEliminar()">
                            <option value="">Seleccione una categoría</option>
                            @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}"
                                data-subcategorias='@json($categoria->subcategorias)'>
                                {{ $categoria->nombre }}
                            </option>
                            @endforeach
                        </select>

                        <!-- Select de subcategorías dependientes -->
                        <label for="subcategoria_eliminar">Subcategoría:</label>
                        <select id="subcategoria_eliminar" class="form-control mb-2" name="id_subcategoria" required>
                            <option value="">Seleccione una subcategoría</option>
                        </select>

                        <button type="submit" class="btn btn-danger w-100"><i class="bi bi-x"></i> Eliminar Subcategoría</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Llenar dinámicamente las subcategorías según la categoría seleccionada
        function cargarSubcategoriasEliminar() {
            let categoriaSelect = document.getElementById("categoria_eliminar");
            let subcategoriaSelect = document.getElementById("subcategoria_eliminar");

            // Resetear el select de subcategorías
            subcategoriaSelect.innerHTML = "<option value=''>Seleccione una subcategoría</option>";

            // Obtener subcategorías de la categoría seleccionada
            let option = categoriaSelect.options[categoriaSelect.selectedIndex];
            let subcategorias = option.getAttribute("data-subcategorias");

            if (subcategorias) {
                subcategorias = JSON.parse(subcategorias);
                subcategorias.forEach(sub => {
                    let opt = document.createElement("option");
                    opt.value = sub.id_subcategoria;
                    opt.textContent = sub.nombre;
                    subcategoriaSelect.appendChild(opt);
                });
            }
        }

        // Captura el form de eliminar y actualiza la acción dinámicamente
        document.getElementById('formEliminarSubcategoria').addEventListener('submit', function(e) {
            e.preventDefault();
            let subId = document.getElementById('subcategoria_eliminar').value;
            if (subId) {
                this.action = '/subcategorias/' + subId;
                this.submit();
            }
        });
    </script>


    <script>
        // Captura el form de eliminar y actualiza la acción dinámicamente
        document.getElementById('formEliminarSubcategoria').addEventListener('submit', function(e) {
            e.preventDefault();
            let subId = document.getElementById('subcategoria_eliminar').value;
            if (subId) {
                this.action = '/subcategorias/' + subId;
                this.submit();
            }
        });
    </script>


    <script>
        let contadorTalla = 1;

        function agregarTalla() {
            const container = document.getElementById('tallas-container');
            const div = document.createElement('div');
            div.classList.add('row', 'g-2', 'align-items-center', 'talla-item', 'mb-2');
            div.innerHTML = `
        <div class="col-md-4">
            <input type="text" name="tallas[${contadorTalla}][talla]" class="form-control" placeholder="Talla" required>
        </div>
        <div class="col-md-4">
            <input type="number" name="tallas[${contadorTalla}][cantidad]" class="form-control" placeholder="Cantidad" min="0" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger w-100" onclick="eliminarTalla(this)"><i class="bi bi-x"></i></button>
        </div>
    `;
            container.appendChild(div);
            contadorTalla++;
        }

        function eliminarTalla(boton) {
            boton.closest('.talla-item').remove(); // 👈 ahora elimina toda la fila
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
                    subcategorias.forEach(sub => {
                        let opt = document.createElement("option");
                        opt.value = sub.id_subcategoria;
                        opt.textContent = sub.nombre;
                        subcategoriaSelect.appendChild(opt);
                    });
                } else {
                    subcategoriaContainer.style.display = "none";
                }
            } else {
                subcategoriaContainer.style.display = "none";
            }
        }
    </script>

    <script>
        function setCategoriaEliminar(id) {
            let form = document.getElementById('formEliminarCategoria');
            if (id) {
                form.action = "/categorias/" + id;
            } else {
                form.action = "#";
            }
        }

        function setSubcategoriaEliminar(id) {
            let form = document.getElementById('formEliminarSubcategoria');
            if (id) {
                form.action = "/subcategorias/" + id;
            } else {
                form.action = "#";
            }
        }
    </script>

    <script>
        function setCategoriaEliminar(id) {
            let form = document.getElementById('formEliminarCategoria');
            if (id) {
                form.action = "/categorias/" + id;
            } else {
                form.action = "#";
            }
        }

        function setSubcategoriaEliminar(id) {
            let form = document.getElementById('formEliminarSubcategoria');
            if (id) {
                form.action = "/subcategorias/" + id;
            } else {
                form.action = "#";
            }
        }
    </script>

    <script>
        function confirmarEliminar(form) {
            if (confirm("¿Seguro que quieres eliminar esta categoría?")) {
                // Cambiar el action con el ID de la categoría seleccionada
                let select = form.querySelector("select[name='id']");
                let id = select.value;
                if (id) {
                    form.action = "{{ url('categorias') }}/" + id;
                    form.submit();
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <footer class="pie">
            <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
            <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
            <a href="{{ route('reseñas') }}" class="abaj">Reseñas</a>
            <a href="{{ route('tiendas') }}" class="abaj">Tiendas</a>
            <a href="{{ route('redes') }}" class="abaj">Redes</a>
            <br>
            <br>
            <p>&copy; 2024 - GUT KLEID.</p>
        </footer>

</body>

</html>