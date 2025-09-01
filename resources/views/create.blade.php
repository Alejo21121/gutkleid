<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/estiloagre.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <!-- Botón modal categoría -->
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalCategoria">
                    Editar Categoría
                </button>
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
        </div>


        <!-- Subcategoría -->
        <div id="subcategoria-container" style="display:none;" class="mb-3">
            <div class="d-flex align-items-center justify-content-between gap-2">
                <label for="id_subcategoria" class="form-label">Subcategoría:</label>
                <!-- Botón modal subcategoría -->
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalSubcategoria">
                     Editar Subcategoría
                </button>
            </div>
            <select name="id_subcategoria" id="id_subcategoria" class="form-control mt-2"></select>
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
                    <button type="button" class="btn btn-danger w-100" onclick="eliminarTalla(this)">❌</button>
                </div>
            </div>
        </div>
        <br>
        <button type="button" class="btn btn-outline-primary" onclick="agregarTalla()">➕ Agregar otra talla</button>

        <button type="submit" class="btn btn-success mt-3">Agregar Producto</button>
        <center><a href="{{ url('producto') }}" class="btn-menu">Volver al Menú Principal</a></center>
    </form>
    <br>

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
                            <button type="submit" class="btn btn-success w-100">➕ Crear Categoría</button>
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
                            <button type="submit" class="btn btn-danger w-100">❌ Eliminar Categoría</button>
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

                    <label for="subcategoria_eliminar">Eliminar subcategoría:</label>
                    <select id="subcategoria_eliminar" class="form-control mb-2" name="id_subcategoria" required>
                        <option value="">Seleccione una subcategoría</option>
                        @foreach ($subcategorias as $sub)
                        <option value="{{ $sub->id_subcategoria }}">{{ $sub->nombre }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-danger w-100">❌ Eliminar Subcategoría</button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Captura el form de eliminar y actualiza la acción dinámicamente
    document.getElementById('formEliminarSubcategoria').addEventListener('submit', function (e) {
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
            <button type="button" class="btn btn-danger w-100" onclick="eliminarTalla(this)">❌</button>
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

</body>

</html>