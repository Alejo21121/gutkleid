<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de GutKleid</title>
    <link rel="stylesheet" href="{{ asset('css/GESTION ANALISIS.css') }}">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
    <header class="cabeza">
        <nav class="barras">
            <div class="barra1">
                <a href="{{ route('producto.index') }}"><button class="filter-bccselect">Inventario</button></a>
                <a href="{{ route('analisis') }}"><button class="filter-bcc">Análisis</button></a>
                <a href="{{ route('usuarios.index') }}"><button class="filter-bcc">Usuarios</button></a>
            </div>
            <div class="logo">
                <a href="{{ route('inicio') }}">
                    <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo" class="logo">
                </a>
            </div>
            <div class="barra2">
                <div class="usuario-info">
                    @if (session('usuario'))
                        <p class="user-name">Hola {{ session('usuario')['nombres'] }}</p>
                        <a href="{{ route('logout') }}"><button class="filter-btn"><i class="bi bi-door-open"></i></button></a>
                        <a href="{{ route('cuenta') }}">
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}"
                            alt="Perfil"
                            class="perfil-icono">
                    </a>
                    @else
                        <a href="{{ route('login') }}"><p class="filter-btna">Inicia sesión</p></a>
                    @endif
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section class="contenedor-graficos">
            <h2>Análisis General</h2>

            <!-- Gráfico de productos por categoría -->
            <div id="grafico_categoria" class="grafico"></div>

            <!-- Gráfico de ventas mensuales -->
            <div id="grafico_ventas" class="grafico"></div>

            <!-- Gráfico de impuestos por producto -->
            <div id="grafico_impuestos" class="grafico"></div>

            <!-- Agrega más secciones según necesidades -->
        </section>
    </main>

    <script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        // Productos por categoría
        var dataCategoria = google.visualization.arrayToDataTable([
            ['Categoría', 'Cantidad'],
            @foreach($porCategoria as $cat)
                ['{{ $cat->categoria }}', {{ $cat->cantidad }}],
            @endforeach
        ]);

        var optionsCategoria = {
            title: 'Productos por Categoría'
        };

        var chartCategoria = new google.visualization.PieChart(document.getElementById('grafico_categoria'));
        chartCategoria.draw(dataCategoria, optionsCategoria);

        // Ventas mensuales
        var dataVentas = google.visualization.arrayToDataTable([
            ['Mes', 'Total Ventas'],
            @if($ventasMensuales->count() > 0)
                @foreach($ventasMensuales as $venta)
                    ['{{ \Carbon\Carbon::create()->month($venta->mes)->locale("es")->monthName }}', {{ $venta->total }}],
                @endforeach
            @else
                ['Sin datos', 0]
            @endif
        ]);

        var optionsVentas = {
            title: 'Ventas Mensuales',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chartVentas = new google.visualization.LineChart(document.getElementById('grafico_ventas'));
        chartVentas.draw(dataVentas, optionsVentas);

        // Ocultar el gráfico de impuestos (no funcional aún)
        document.getElementById('grafico_impuestos').style.display = 'none';
    }
</script>
</body>
</html>
