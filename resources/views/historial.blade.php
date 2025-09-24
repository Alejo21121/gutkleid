<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/USER.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>

<body id="my-account" class="page-my-account">

    <!-- HEADER -->
    <header class="cabeza">
        <nav class="barras">
            <div class="barra1">
                @if (session('usuario') && session('usuario')['id_rol'] == 1)
                <a class="filter-btn" href="{{ route('producto.index') }}">PANEL</a>
                @endif
            </div>

            <div class="logo">
                <a href="/">
                    <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
                </a>
            </div>

            <div class="usuario-info">
                @if (session('usuario'))
                <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
                <a href="{{ route('cuenta') }}">
                    <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}" alt="Perfil"
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
        </nav>
        <hr>
    <!-- MAIN -->
<main class="main">
<body class="bg-light">

  <div class="container my-5">
    <center>
      <h2 class="mb-4">HISTORIAL DE PEDIDOS</h2>
    </center>

    @if($facturas->isEmpty())
    <p class="text-center">No hay pedidos registrados.</p>
    @else
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center bg-white">
        <thead class="table-light">
          <tr>
            <th>Referencia</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Método de Pago</th>
            <th>Entrega</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($facturas as $factura)
          <tr class="pedido-row" data-pedido="pedido{{ $factura->id_factura_venta }}">
            <td>PED-{{ str_pad($factura->id_factura_venta, 5, '0', STR_PAD_LEFT) }}</td>
            <td>{{ \Carbon\Carbon::parse($factura->fecha_venta)->format('d/m/Y') }}</td>
            <td>${{ number_format(round($factura->total, -3), 0, ',', '.') }}</td>
            <td>
    {{ $factura->metodo_pago }}
    @if($factura->sub_metodo_pago)
        - {{ $factura->sub_metodo_pago }}
    @endif
</td>

            <td class="text-primary fw-bold">{{ strtoupper($factura->direccion) }}</td>
            <td><span class="icono-toggle">▼</span></td>
          </tr>
          <tr class="pedido-detalle-row">
            <td colspan="6">
              <div class="pedido-detalle p-3 border rounded" id="pedido{{ $factura->id_factura_venta }}">
                <div class="row text-center mb-4">
                  <div class="col-md-4">
                    <div class="d-flex flex-column align-items-center">
                      <div class="bg-dark rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-person text-white fs-2"></i>
                      </div>
                      <strong class="mt-2">NOMBRE DESTINATARIO</strong>
                      <div>{{ session('usuario')['nombres'] }} {{ session('usuario')['apellidos'] }}</div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="d-flex flex-column align-items-center">
                      <div class="bg-dark rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-geo-alt text-white fs-2"></i>
                      </div>
                      <strong class="mt-2">DIRECCIÓN</strong>
                      <div>{{ session('usuario')['direccion'] ?? 'No registrada' }}</div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="d-flex flex-column align-items-center">
                      <div class="bg-dark rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-wallet2 text-white fs-2"></i>
                      </div>
                      <strong class="mt-2">MÉTODO DE PAGO</strong>
                      <div>{{ $factura->metodo_pago }}</div>
                    </div>
                  </div>
                </div>


                <!-- Detalles del pedido -->
                <h5 class="text-start">DETALLES DEL PEDIDO</h5>
                <table class="table table-sm align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>Producto</th>
                      <th>Detalle</th>
                      <th>Precio unidad</th>
                      <th>Cantidad</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($factura->detalles as $detalle)
                    <tr>
                      <td>
                        <img src="{{ asset($detalle->imagen ?? 'IMG/default.jpeg') }}" alt="Producto" width="50">
                      </td>
                      <td>
                        {{ $detalle->nombre_producto }}<br>
                        <small>
                          Marca: {{ $detalle->marca ?? '---' }}<br>
                          Talla: {{ $detalle->talla ?? 'N/A' }}
                        </small>
                      </td>
                      <td>${{ number_format(round((($detalle->subtotal + $detalle->iva) / $detalle->cantidad), -3), 0, ',', '.') }}</td>
                      <td>{{ (int) $detalle->cantidad }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

                <!-- Totales -->

                <div class="text-end">
                  <p><strong>Subtotal</strong> ${{ number_format(round((($factura->total - $factura->envio) / 1.19), -3), 0, ',', '.') }}</p>
                  <p><strong>IVA Total:</strong>
                    ${{ number_format(round($factura->detalles->sum('iva'), -3), 0, ',', '.') }}
                  </p>
                  <p><strong>Envío:</strong> ${{ number_format($factura->envio, 0, ',', '.') }}</p>
                  <h5><strong>Total:</strong> ${{ number_format(round($factura->total, -3), 0, ',', '.') }}</h5>
                </div>

              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endif
  </div>
  </main>
    <footer class="pie">
        <strong><a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a></strong>
        <strong><a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a></strong>
        <strong><a href="{{ route('reseñas') }}" class="abaj">Reseñas</a></strong>
        <strong><a href="{{ route('tiendas') }}" class="abaj">Tiendas</a></strong>
        <strong><a href="{{ route('redes') }}" class="abaj">Redes</a></strong>
        <br><br>
        <p>&copy; 2024 - GUT KLEID.</p>
    </footer>

  <script>
    document.querySelectorAll(".pedido-row").forEach(row => {
      row.addEventListener("click", () => {
        const pedidoId = row.getAttribute("data-pedido");
        const detalleRow = row.nextElementSibling;
        detalleRow.classList.toggle("pedido-activo");
      });
    });
  </script>

</body>

</html>