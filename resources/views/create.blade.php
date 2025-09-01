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

        <label for="id_categoria">Categoría:</label>
        <select name="id_categoria" id="id_categoria" required onchange="mostrarSubcategorias()">
            <option value="">Seleccione una categoría</option>
            @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id_categoria }}"
                data-subcategorias='@json($categoria->subcategorias)'>
                {{ $categoria->nombre }}
            </option>
            @endforeach
        </select>

        <div id="subcategoria-container" style="display:none;">
            <label for="id_subcategoria">Subcategoría:</label>
            <select name="id_subcategoria" id="id_subcategoria"></select>
        </div>

        <label>Tallas y cantidades:</label>
        <div id="tallas-container">
            <div class="talla-item">
                <input type="text" name="tallas[0][talla]" placeholder="Talla" required>
                <input type="number" name="tallas[0][cantidad]" placeholder="Cantidad" min="0" required>
                <button type="button" onclick="eliminarTalla(this)">❌</button>
            </div>
        </div>
        <br>
        <button type="button" onclick="agregarTalla()">➕ Agregar otra talla</button>

        <button type="submit">Agregar Producto</button>
        <center><a href="{{ url('producto') }}" class="btn-menu">Volver al Menú Principal</a></center>
    </form>
    <br>

    <script>
        let contadorTalla = 1;

        function agregarTalla() {
            const container = document.getElementById('tallas-container');

            const div = document.createElement('div');
            div.classList.add('talla-item');

            div.innerHTML = `
        <input type="text" name="tallas[${contadorTalla}][talla]" placeholder="Talla" required>
        <input type="number" name="tallas[${contadorTalla}][cantidad]" placeholder="Cantidad" min="0" required>
        <button type="button" onclick="eliminarTalla(this)">❌</button>
    `;

            container.appendChild(div);
            contadorTalla++;
        }

        function eliminarTalla(boton) {
            boton.parentElement.remove();
        }
    </script>

    <script>
        function mostrarSubcategorias() {
            let categoriaSelect = document.getElementById('id_categoria');
            let subcategoriaContainer = document.getElementById('subcategoria-container');
            let subcategoriaSelect = document.getElementById('id_subcategoria');

            // limpiar
            subcategoriaSelect.innerHTML = "";

            // obtener la opción seleccionada
            let option = categoriaSelect.options[categoriaSelect.selectedIndex];
            let subcategorias = option.getAttribute('data-subcategorias');

            if (subcategorias) {
                subcategorias = JSON.parse(subcategorias);

                if (subcategorias.length > 0) {
                    subcategoriaContainer.style.display = "block"; // mostrar select

                    subcategorias.forEach(sub => {
                        let opt = document.createElement("option");
                        opt.value = sub.id_subcategoria;
                        opt.textContent = sub.nombre;
                        subcategoriaSelect.appendChild(opt);
                    });
                } else {
                    subcategoriaContainer.style.display = "none"; // ocultar si no hay
                }
            } else {
                subcategoriaContainer.style.display = "none";
            }
        }
    </script>


</body>

</html>