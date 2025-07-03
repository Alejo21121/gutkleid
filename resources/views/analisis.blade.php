<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de GutKleid</title>
    <link rel="stylesheet" href="{{ asset('css/analisis.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>
<body>

<header class="cabeza">
    <nav class="barras">
        <div class="barra1">
            <a href="{{ route('producto.index') }}"><button class="filter-bcc">Inventario</button></a>
            <a href="{{ route('analisis') }}"><button class="filter-bccselect">Análisis</button></a>
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
                    <a href="{{ route('cuenta') }}">
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}"
                             alt="Perfil" class="perfil-icono">
                    </a>
                    <a href="{{ route('logout') }}"><button class="filter-btn"><i class="bi bi-door-open"></i></button></a>
                @else
                    <a href="{{ route('login') }}"><p class="filter-btna">Inicia sesión</p></a>
                @endif
            </div>
        </div>
    </nav>
</header>

<main class="main-analisis container py-4">
    <h2 class="text-center mb-4">Análisis General</h2>
    <div class="row justify-content-center mb-5">
        <div class="col-md-4">
            <div class="card shadow p-3 mb-4 rounded">
                <h5 class="card-title"><i class="bi bi-person-fill"></i> Total Clientes Registrados</h5>
                <p class="card-text fs-3 fw-bold text-primary">{{ $totalClientes }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow p-3 mb-4 rounded">
                <h5 class="card-title"><i class="bi bi-box-seam"></i> Total de Productos Registrados</h5>
                <p class="card-text fs-3 fw-bold text-success">{{ $totalProductos }}</p>
            </div>
        </div>
    </div>
    <div class="row justify-content-center g-4">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="grafico">
                <div id="grafico_categoria"></div>
            </div>
        </div>
        <div class="col-lg-6 col-md-8 col-12">
            <div class="grafico">
                <div id="grafico_ventas"></div>
            </div>
        </div>
    </div>
    <div style="display: none;" id="grafico_impuestos"></div>
</main>

<footer class="pie">
    <div class="foot">
        <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
        <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
    </div>
    <p>&copy; 2024 - GUT KLEID.</p>
</footer>

<script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawCharts);

    function hslToHex(h, s, l) {
        s /= 100;
        l /= 100;

        const k = n => (n + h / 30) % 12;
        const a = s * Math.min(l, 1 - l);
        const f = n => {
            const color = l - a * Math.max(-1, Math.min(k(n) - 3, Math.min(9 - k(n), 1)));
            return Math.round(255 * color).toString(16).padStart(2, '0');
        };

        return `#${f(0)}${f(8)}${f(4)}`;
    }

    function generarColoresUnicos(cantidad) {
        const colores = [];
        for (let i = 0; i < cantidad; i++) {
            const hue = Math.floor((360 / cantidad) * i);
            colores.push(hslToHex(hue, 70, 60));
        }
        return colores;
    }

    function drawCharts() {
        // Datos de Categoría
        var dataCategoria = google.visualization.arrayToDataTable([
            ['Categoría', 'Cantidad'],
            @foreach($porCategoria as $cat)
                ['{{ $cat->categoria }}', {{ $cat->cantidad }}],
            @endforeach
        ]);

        const totalCategorias = dataCategoria.getNumberOfRows();
        const coloresGenerados = generarColoresUnicos(totalCategorias);

        var optionsCategoria = {
            title: 'Productos por Categoría',
            pieHole: 0.3,
            width: '100%',
            height: 350,
            chartArea: {width: '90%', height: '90%'},
            colors: coloresGenerados
        };

        var chartCategoria = new google.visualization.PieChart(document.getElementById('grafico_categoria'));
        chartCategoria.draw(dataCategoria, optionsCategoria);

        // Datos de Ventas
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
            legend: { position: 'bottom' },
            colors: ['#42A5F5']
        };

        var chartVentas = new google.visualization.LineChart(document.getElementById('grafico_ventas'));
        chartVentas.draw(dataVentas, optionsVentas);
    }
</script>

</body>
</html>
