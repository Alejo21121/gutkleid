<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Compra - Gut Kleid</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('CSS/GESTION INVENTARIO.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>
<body>
<header class="cabeza">
    <!-- Tu navbar aquí... -->
</header>

<main>
<section class="contenedor">
    <h2><center>Registrar Nueva Compra</center></h2>
    <center>
        @if(session('error'))
            <div class="alert alert-danger w-75">{{ session('error') }}</div>
        @endif

        <form action="{{ route('compras.store') }}" method="POST" class="w-75" id="form-compra">
            @csrf

            <div class="mb-3">
                <label for="id_proveedor" class="form-label">Proveedor</label>
                <select name="id_proveedor" class="form-select" required>
                    <option value="">Seleccione un proveedor</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id_proveedor }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <hr>
            <h5>Productos</h5>
            <div id="productos">
                <div class="producto mb-3" data-index="0">
                    <select name="productos[0][id]" class="form-select mb-2 producto-select" required onchange="cargarTallas(this)">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id_producto }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>

                    <div class="tallas-container mb-2">
                        <div class="talla-row d-flex mb-1">
                            <select name="productos[0][tallas][0][talla]" class="form-select me-2 talla-select" required>
                                <option value="">Seleccione una talla</option>
                                <!-- Se llenará con JS -->
                            </select>
                            <input type="number" name="productos[0][tallas][0][cantidad]" class="form-control me-2" placeholder="Cantidad" min="1" required>
                            <input type="number" step="0.01" name="productos[0][tallas][0][precio]" class="form-control" placeholder="Precio" min="0" required>
                            <button type="button" onclick="eliminarTalla(this)" class="btn btn-danger btn-sm ms-2">X</button>
                        </div>
                    </div>
                    <button type="button" onclick="agregarTalla(0)" class="btn btn-secondary btn-sm">+ Agregar talla</button>
                </div>
            </div>

            <button type="button" onclick="agregarProducto()" class="btn btn-secondary mt-2 mb-3">+ Agregar otro producto</button>

            <input type="hidden" name="valor_total" id="valor_total">

            <a href="{{ route('compras.index') }}" class="btn btn-outline-secondary mt-2 mb-3">
                <i class="bi bi-arrow-left"></i> Volver a Compras
            </a>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">Registrar compra</button>
            </div>
        </form>
    </center>
</section>
</main>

<footer class="pie">
    <div class="foot">
        <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
        <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
    </div>
    <p>&copy; 2024 - GUT KLEID.</p>
</footer>

<!-- JSON con productos y tallas -->
<script>
    const productosTallas = @json($productos->mapWithKeys(function($p) {
        return [$p->id_producto => $p->tallas ? $p->tallas->pluck('talla') : []];
    }));
</script>

<script>
    let contador = 1;

    function agregarProducto() {
        const contenedor = document.getElementById('productos');
        const div = document.createElement('div');
        div.classList.add('producto', 'mb-3');
        div.dataset.index = contador;

        // Construir opciones de productos para el select
        let opcionesProductos = `<option value="">Seleccione un producto</option>`;
        @foreach($productos as $producto)
            opcionesProductos += `<option value="{{ $producto->id_producto }}">{{ $producto->nombre }}</option>`;
        @endforeach

        div.innerHTML = `
            <select name="productos[${contador}][id]" class="form-select mb-2 producto-select" onchange="cargarTallas(this)" required>
                ${opcionesProductos}
            </select>

            <div class="tallas-container mb-2"></div>

            <button type="button" onclick="agregarTalla(${contador})" class="btn btn-secondary btn-sm" disabled>+ Agregar talla</button>
        `;

        contenedor.appendChild(div);
        contador++;
    }

    function cargarTallas(select) {
        const productoId = select.value;
        const productoDiv = select.parentElement;
        const tallasContainer = productoDiv.querySelector('.tallas-container');
        const agregarTallaBtn = productoDiv.querySelector('button.btn-secondary');

        tallasContainer.innerHTML = ''; // limpiar tallas
        agregarTallaBtn.disabled = true;

        if (!productoId) return;

        const tallasDisponibles = productosTallas[productoId] || [];

        if (tallasDisponibles.length === 0) {
            alert("Este producto aún no tiene tallas registradas.");
            return;
        }

        // Crear primera fila de talla automáticamente
        agregarTallaPorJS(productoDiv.dataset.index, tallasDisponibles, tallasContainer);

        // Habilitar botón para agregar más tallas
        agregarTallaBtn.disabled = false;
    }

    function agregarTalla(productoIndex) {
        const productoDiv = document.querySelector(`div.producto[data-index="${productoIndex}"]`);
        const tallasContainer = productoDiv.querySelector('.tallas-container');
        const productoSelect = productoDiv.querySelector('select.producto-select');
        const productoId = productoSelect.value;
        const tallasDisponibles = productosTallas[productoId] || [];

        agregarTallaPorJS(productoIndex, tallasDisponibles, tallasContainer);
    }

    function agregarTallaPorJS(productoIndex, tallasDisponibles, container) {
        const filas = container.querySelectorAll('.talla-row');
        const newIndex = filas.length;

        let opcionesTallas = '<option value="">Seleccione una talla</option>';
        tallasDisponibles.forEach(t => {
            opcionesTallas += `<option value="${t}">${t}</option>`;
        });

        const div = document.createElement('div');
        div.classList.add('talla-row', 'd-flex', 'mb-1');
        div.innerHTML = `
            <select name="productos[${productoIndex}][tallas][${newIndex}][talla]" class="form-select me-2 talla-select" required>
                ${opcionesTallas}
            </select>
            <input type="number" name="productos[${productoIndex}][tallas][${newIndex}][cantidad]" class="form-control me-2" placeholder="Cantidad" min="1" required>
            <input type="number" step="0.01" name="productos[${productoIndex}][tallas][${newIndex}][precio]" class="form-control" placeholder="Precio" min="0" required>
            <button type="button" onclick="eliminarTalla(this)" class="btn btn-danger btn-sm ms-2">X</button>
        `;
        container.appendChild(div);
    }

    function eliminarTalla(button) {
        button.parentElement.remove();
    }

    // Calcular valor total antes de enviar
    document.getElementById('form-compra').addEventListener('submit', function (e) {
        let total = 0;
        document.querySelectorAll('#productos .producto').forEach(productoDiv => {
            productoDiv.querySelectorAll('.talla-row').forEach(tallaDiv => {
                const cantidad = parseFloat(tallaDiv.querySelector('input[name$="[cantidad]"]').value) || 0;
                const precio = parseFloat(tallaDiv.querySelector('input[name$="[precio]"]').value) || 0;
                total += cantidad * precio;
            });
        });
        document.getElementById('valor_total').value = total.toFixed(2);
    });

</script>
</body>
</html>

