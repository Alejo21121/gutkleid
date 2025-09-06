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
            <a href="{{ route('compras.index') }}"><button class="filter-bcc">Compras</button></a>
            <a href="{{ route('ventas') }}"><button class="filter-bcc">Ventas</button></a>
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
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}" alt="Perfil" class="perfil-icono">
                    </a>
                    <a href="{{ route('logout') }}"><button class="filter-btn"><i class="bi bi-door-open"></i></button></a>
                @else
                    <a href="{{ route('login') }}"><p class="filter-btna">Inicia sesión</p></a>
                @endif
            </div>
        </div>
    </nav>
</header>
<main class="main-analisis container-fluid py-4">
    <h2 class="text-center mb-5 fw-bold">Análisis General</h2>

    <!-- Métricas rápidas -->
    <div class="row justify-content-center g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card text-center shadow-sm p-3">
                <h6 class="text-muted"><i class="bi bi-person-fill"></i> Total Clientes</h6>
                <p class="fs-2 fw-bold text-primary mb-0">{{ $totalClientes }}</p>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card text-center shadow-sm p-3">
                <h6 class="text-muted"><i class="bi bi-box-seam"></i> Total Productos</h6>
                <p class="fs-2 fw-bold text-success mb-0">{{ $totalProductos }}</p>
            </div>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="grafico p-3 bg-white shadow-sm rounded h-100">
                <h6 class="fw-bold text-center mb-3">Productos por Categoría</h6>
                <div id="grafico_categoria" class="chart-canvas"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="grafico p-3 bg-white shadow-sm rounded h-100">
                <h6 class="fw-bold text-center mb-3">Ventas Mensuales</h6>
                <div id="grafico_ventas" class="chart-canvas"></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-12">
            <div class="grafico p-3 bg-white shadow-sm rounded">
                <h6 class="fw-bold text-center mb-3">Top 10 Productos Más Vendidos</h6>
                <div id="grafico_mas_vendidos" class="chart-canvas"></div>
            </div>
        </div>
    </div>
</main>

<footer class="pie mt-5 text-center">
    <div class="foot mb-2">
        <a href="{{ route('terminos') }}" class="abaj me-3">Términos y Condiciones</a>
        <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
    </div>
    <p>&copy; 2024 - GUT KLEID.</p>
</footer>

<!-- Scripts -->
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

    function drawCharts() {
        const dataCategoria = google.visualization.arrayToDataTable([
            ['Categoría', 'Cantidad'],
            @foreach($porCategoria as $cat)
                ['{{ $cat->categoria }}', {{ $cat->cantidad }}],
            @endforeach
        ]);
        const totalCategorias = dataCategoria.getNumberOfRows();
        const coloresGenerados = [];
        for (let i = 0; i < totalCategorias; i++) {
            const hue = Math.floor((360 / totalCategorias) * i);
            coloresGenerados.push(hslToHex(hue, 70, 60));
        }
        new google.visualization.PieChart(document.getElementById('grafico_categoria')).draw(dataCategoria, {
            title: '',
            pieHole: 0.3,
            width: '100%',
            height: 400,
            chartArea: { width: '90%', height: '80%' },
            colors: coloresGenerados
        });

        const rawData = [
            @if($ventasMensuales->count() > 0)
                @foreach($ventasMensuales as $venta)
                    ['{{ \Carbon\Carbon::create()->month($venta->mes)->locale("es")->monthName }}', {{ $venta->total }}],
                @endforeach
            @else
                ['Sin datos', 0]
            @endif
        ];
        const dataVentas = new google.visualization.DataTable();
        dataVentas.addColumn('string', 'Mes');
        dataVentas.addColumn('number', 'Total Ventas');
        dataVentas.addColumn({ type: 'string', role: 'annotation' });
        rawData.forEach(row => {
            const valor = row[1];
            const anotacion = new Intl.NumberFormat('es-CO').format(valor);
            dataVentas.addRow([row[0], valor, anotacion]);
        });
        new google.visualization.ColumnChart(document.getElementById('grafico_ventas')).draw(dataVentas, {
            title: '',
            width: '100%',
            height: 400,
            legend: { position: 'none' },
            colors: ['#1976D2'],
            bar: { groupWidth: '60%' },
            annotations: {
                alwaysOutside: false,
                textStyle: { fontSize: 13, color: '#fff', auraColor: 'none' },
                highContrast: true
            },
            hAxis: { title: 'Mes', slantedText: true, slantedTextAngle: 45 },
            vAxis: { title: 'Total en Ventas' },
            chartArea: { top: 60, width: '85%', height: '70%' }
        });

        const dataVendidos = google.visualization.arrayToDataTable([
            ['Producto', 'Cantidad Vendida'],
            @foreach($productosMasVendidos as $prod)
                ['{{ $prod->producto }}', {{ $prod->total_vendido }}],
            @endforeach
        ]);
        new google.visualization.BarChart(document.getElementById('grafico_mas_vendidos')).draw(dataVendidos, {
            title: '',
            height: 400,
            colors: ['#388E3C'],
            chartArea: { width: '75%', height: '70%' },
            hAxis: { title: 'Cantidad Vendida', minValue: 0, textStyle: { fontSize: 12 } },
            vAxis: { title: 'Producto', textStyle: { fontSize: 12 } }
        });
    }
</script>

</body>
</html>
