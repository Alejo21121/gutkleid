<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\FacturaVenta;
use App\Models\DetalleFacturaV;
use App\Models\MetodoPago;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use App\Models\Imagen;
use App\Models\Talla;
use Illuminate\Support\Facades\Mail;
use App\Mail\FacturaMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Shuchkin\SimpleXLSXGen;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $totalFinal = 0;
        foreach ($carrito as $item) {
            $totalFinal += ($item['valor'] ?? 0) * ($item['cantidad'] ?? 0);
        }
        return view('carrito', compact('carrito', 'totalFinal'));
    }

    public function exportarPDF()
    {
        // Obtén los datos de todas las ventas con su cliente asociado
        $ventas = FacturaVenta::with('cliente')->get();

        // Carga la vista 'pdf.ventas_pdf' y le pasa los datos de las ventas
        $pdf = Pdf::loadView('ventas_pdf', compact('ventas'));

        // Muestra el PDF en el navegador para su descarga
        return $pdf->stream('reporte_ventas.pdf');
    }

    public function exportarExcel()
    {
        // Traemos todos los registros de ventas con su relación de cliente (Persona)
        $ventas = FacturaVenta::with('cliente')->get();

        // Encabezados de la tabla, exactamente como aparecen en tu vista
        $header = [
            '# Factura',
            'Fecha',
            'Cliente',
            'Valor',
            'Estado',
        ];

        // Preparamos los datos para la exportación
        $data = [];
        foreach ($ventas as $venta) {
            $data[] = [
                $venta->id_factura_venta,
                $venta->fecha_venta,
                ($venta->cliente->nombres ?? 'N/A') . ' - ' . ($venta->cliente->documento ?? 'N/A'), // Muestra el nombre y documento del cliente
                '$' . number_format($venta->total, 0, ',', '.'), // Formatea el valor como en la vista
                'Vendido', // Estado de la factura
            ];
        }

        // Unimos los encabezados con los datos
        array_unshift($data, $header);

        // Generamos el archivo de Excel y lo descargamos
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('ventas.xlsx');
    }

    public function finalizar(Request $request)
    {
        $carrito = session()->get('carrito', []);
        $usuario = session('usuario');

        $tipoEntrega = $request->input('tipo_entrega');
        $infoAdicional = $request->input('info_adicional');

        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
        }
        if (empty($usuario) || !isset($usuario['id_persona'])) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para completar la compra.');
        }

        DB::beginTransaction();

        try {
            // 1️⃣ Crear factura
            $factura = new FacturaVenta();
            $factura->fecha_venta = now();
            $factura->nit_tienda = '123456789';
            $factura->dire_tienda = 'Tv 79 #68 Sur-98a';
            $factura->telef_tienda = '3001234567';
            $factura->id_persona = $usuario['id_persona'];
            $factura->id_metodo_pago = MetodoPago::first()->id_metodo_pago ?? 1;
            $factura->total = 0;
            $factura->envio = 0;
            $factura->info_adicional = $infoAdicional;
            $factura->save();

            $totalFactura = 0;

            // 2️⃣ Procesar cada producto en el carrito
            foreach ($carrito as $item) {
                $producto = Producto::find($item['id_producto']);
                if (!$producto) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with('error', 'Producto no encontrado.');
                }

                $tallaBuscada = strtoupper(trim($item['talla'] ?? ''));
                if (empty($tallaBuscada)) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with('error', 'Debe seleccionar una talla para ' . $producto->nombre);
                }

                $tallaProducto = Talla::where('id_producto', $producto->id_producto)
                    ->where('talla', $tallaBuscada)
                    ->first();

                if (!$tallaProducto || $tallaProducto->cantidad < $item['cantidad']) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with('error', 'Stock insuficiente para ' . $producto->nombre . ' talla ' . $tallaBuscada);
                }

                $cantidad = $item['cantidad'];
                $valorUnitario = $item['valor'] ?? 0;
                $totalItem = $valorUnitario * $cantidad;
                $ivaItem = $totalItem * 0.19;

                // Guardar detalle de factura
                $detalle = new DetalleFacturaV();
                $detalle->id_factura_venta = $factura->id_factura_venta;
                $detalle->id_producto = $producto->id_producto;
                $detalle->id_talla = $tallaProducto->id;
                $detalle->cantidad = $cantidad;
                $detalle->subtotal = $totalItem;
                $detalle->iva = $ivaItem;
                $detalle->color = $item['color'] ?? 'N/A';
                $detalle->save();

                // Reducir stock
                $tallaProducto->cantidad -= $cantidad;
                $tallaProducto->save();

                $totalFactura += $totalItem;
            }

            // 3️⃣ Calcular envío
            $costoEnvio = ($tipoEntrega === 'tienda') ? 0 : (($totalFactura >= 150000) ? 0 : 15000);

            // 4️⃣ Guardar total y envío en la factura
            $factura->envio = $costoEnvio;
            $factura->total = $totalFactura + $costoEnvio + ($totalFactura * 0.19);
            $factura->save();

            DB::commit();

            // 5️⃣ Cargar relaciones para PDF
            $factura->load(['detalles.producto', 'cliente', 'detalles.talla']);

            // 6️⃣ Generar PDF
            $pdf = Pdf::loadView('factura_pdf', ['factura' => $factura]);
            $nombreArchivo = 'Factura_GutKleid_' . $factura->id_factura_venta . '.pdf';
            $rutaArchivo = 'facturas/' . $nombreArchivo;
            $rutaCompleta = public_path($rutaArchivo);

            if (!file_exists(public_path('facturas'))) {
                mkdir(public_path('facturas'), 0777, true);
            }

            $pdf->save($rutaCompleta);

            $factura->factura_pdf = $rutaArchivo;
            $factura->save();

            // 7️⃣ Enviar correo al cliente
            if (!empty($usuario['correo'])) {
                Mail::to($usuario['correo'])->send(new FacturaMail($factura, $rutaCompleta));
            }

            // 8️⃣ Limpiar carrito
            Session::forget('carrito');

            return redirect()->route('confirmacion.final', ['id_factura' => $factura->id_factura_venta]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('carrito.index')->with('error', 'Error al finalizar la compra: ' . $e->getMessage());
        }
    }


    public function mostrarConfirmacionFinal($id_factura)
    {
        try {
            $factura = FacturaVenta::with(['detalles.producto', 'cliente', 'detalles.talla'])->findOrFail($id_factura);
            return view('confirmacion_final', compact('factura'));
        } catch (\Exception $e) {
            return redirect()->route('historial')->with('error', 'Factura no encontrada.');
        }
    }

    public function agregar(Request $request)
    {
        $id_producto = $request->input('id_producto');
        $nombre = $request->input('nombre');
        $valor = $request->input('precio');
        $talla = strtoupper(trim($request->input('talla')));
        $color = $request->input('color') ?? 'N/A';
        $cantidad = max((int) $request->input('cantidad', 1), 1);

        if (empty($talla)) {
            return redirect()->route('carrito.index')->with('error', 'Debe seleccionar una talla para continuar.');
        }

        $producto = Producto::with('imagenes')->findOrFail($id_producto);
        $rutaImagen = $producto->imagenes->first()->ruta ?? 'IMG/default.jpg';
        $rutaCompleta = 'IMG/imagenes_demo/' . basename($rutaImagen);

        $carrito = session()->get('carrito', []);
        $clave = $id_producto . '-' . $talla . '-' . $color;

        if (isset($carrito[$clave])) {
            $carrito[$clave]['cantidad'] += $cantidad;
        } else {
            $carrito[$clave] = [
                "id_producto" => $id_producto,
                "nombre" => $nombre,
                "valor" => $valor,
                "talla" => $talla,
                "color" => $color,
                "cantidad" => $cantidad,
                "imagen" => $rutaCompleta,
                "total" => $valor * $cantidad
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito.');
    }

    public function actualizarCantidad(Request $request, $clave)
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$clave])) {
            $tipo = $request->input('tipo');
            if ($tipo === 'sumar') $carrito[$clave]['cantidad'] += 1;
            elseif ($tipo === 'restar' && $carrito[$clave]['cantidad'] > 1) $carrito[$clave]['cantidad'] -= 1;
            session()->put('carrito', $carrito);
        }
        return redirect()->route('carrito.index');
    }

    public function eliminar($clave)
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$clave])) {
            unset($carrito[$clave]);
            session()->put('carrito', $carrito);
        }
        return redirect()->back()->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->back()->with('success', 'Carrito vaciado.');
    }

    public function guardarEnvio(Request $request)
    {
        $tasaIVA = 0.19;
        $costoEnvioDomicilio = 15000;

        $carrito = session()->get('carrito', []);
        $usuario = session('usuario');
        $envio = $request->only(['tipo_entrega', 'direccion', 'info_adicional']);
        $persona = Persona::find($usuario['id_persona']);

        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['valor'] * $item['cantidad']; // multiplicar por cantidad
        }

        $ivaTotal = round($subtotal * $tasaIVA, 0);

        $costoEnvio = 0;
        if ($envio['tipo_entrega'] === 'domicilio') {
            $costoEnvio = ($subtotal >= 150000) ? 0 : $costoEnvioDomicilio;
        }

        $totalFinal = $subtotal + $ivaTotal + $costoEnvio;


        if ($envio['tipo_entrega'] === 'tienda') {
            $direccionMostrada = 'Tv 79 #68 Sur 98a';
        } else {
            $direccionMostrada = data_get($envio, 'direccion') ?? optional($persona)->direccion ?? 'Sin dirección';
        }

        $infoAdicional = data_get($envio, 'info_adicional') ?? optional($persona)->info_adicional ?? '';

        return view('confirmacion', [
            'detallesCarrito' => $carrito,
            'subtotal' => $subtotal,
            'ivaTotal' => $ivaTotal,
            'costoEnvio' => $costoEnvio,
            'totalFinal' => $totalFinal,
            'persona' => $persona,
            'envio' => $envio,
            'direccionMostrada' => $direccionMostrada,
            'infoAdicional' => $infoAdicional
        ]);
    }

    public function generarFacturaPDF($id_factura)
    {
        try {
            $factura = FacturaVenta::with([
                'detalles.producto',
                'cliente',
                'detalles.talla'
            ])->findOrFail($id_factura);

            $pdf = Pdf::loadView('factura_pdf', ['factura' => $factura]);

            $nombreArchivo = 'Factura_GutKleid_' . $factura->id_factura_venta . '.pdf';

            return $pdf->stream($nombreArchivo);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
}
