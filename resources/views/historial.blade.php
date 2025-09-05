<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Historial de Pedidos</title>
  <link rel="stylesheet" href="{{ asset('CSS/USER.CSS') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

  <header class="cabeza">
    <nav class="barras">
      <div class="barra1">
        <a href="{{ url()->previous() }}">
          <button class="filter-btn"><i class="bi bi-arrow-left"></i> Volver</button>
        </a>
        <a href="{{ url('/reseñas') }}">
          <button class="filter-btn">Acerca de</button>
        </a>
      </div>

      <div class="logo">
        <a href="{{ route('inicio') }}">
          <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
        </a>
      </div>

      <div class="barra2">
        <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
        <a href="{{ route('carrito.index') }}">
          <button class="filter-btn"><i class="bi bi-cart3"></i></button>
        </a>
      </div>
    </nav>
  </header>
</head>

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
            <td>{{ $factura->metodo_pago }}</td>
            <td class="text-primary fw-bold">{{ strtoupper($factura->entrega) }}</td>
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

  <footer class="pie">
    <div class="foot">
      <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
      <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
    </div>
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