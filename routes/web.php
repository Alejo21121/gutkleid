<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RecuperarController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ComprasController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\MetodoPagoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Ruta principal (Inicio) ---
Route::get('/', [ProductoController::class, 'paginaInicio'])->name('inicio');

// --- Rutas de Autenticación (Login y Registro) ---
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.procesar');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro.form');
Route::post('/registro', [RegistroController::class, 'registrar'])->name('registro.enviar');

<<<<<<< HEAD
=======
// --- Rutas de Productos ---
// Exportaciones de productos
Route::get('/producto/exportar-pdf', [ProductoController::class, 'exportarPDF'])->name('producto.exportarPDF');
Route::get('/producto/exportar-excel', [ProductoController::class, 'exportarExcel'])->name('producto.exportarExcel');
// CRUD completo de productos
Route::resource('producto', ProductoController::class);
>>>>>>> 1c1ab74ed36ba0056e86f00d52a6134a83828c87

// --- Rutas para Vistas Estáticas ---
Route::view('/correo_cliente', 'correo_cliente')->name('correo_cliente');
Route::view('/contraseña', 'contraseña')->name('contraseña');
Route::view('/recuperar_cuenta', 'recuperar_cuenta')->name('recuperar_cuenta');
Route::view('/terminos', 'terminos')->name('terminos');
Route::view('/preguntas', 'preguntas')->name('preguntas');
Route::view('/mi-cuenta-cli', 'cuenta_cli')->name('cuenta_cli');
Route::view('/mi-cuenta', 'user')->name('cuenta');
Route::view('/reseñas', 'reseñas')->name('reseñas');
Route::view('/tiendas', 'tiendas')->name('tiendas');
Route::view('/redes', 'redes')->name('redes');

<<<<<<< HEAD

// --- Grupo solo para ADMIN (rol 1) ---
Route::middleware(['role:1'])->group(function () {
=======
// --- Usuarios --- 
// Rutas de exportación de usuarios (Mover estas rutas antes del resource)
Route::get('/usuarios/exportar-excel', [UsuarioController::class, 'exportarExcel'])->name('usuarios.exportarExcel');
Route::get('usuarios/exportarPDF', [UsuarioController::class, 'exportarPDF'])->name('usuarios.exportarPDF');
>>>>>>> 1c1ab74ed36ba0056e86f00d52a6134a83828c87

    // --- Rutas de Productos ---
    // Exportaciones de productos
    Route::get('/producto/exportar-pdf', [ProductoController::class, 'exportarPDF'])->name('producto.exportarPDF');
    Route::get('/producto/exportar-excel', [ProductoController::class, 'exportarExcel'])->name('producto.exportarExcel');
    // CRUD completo de productos
    Route::resource('producto', ProductoController::class);
    // --- Usuarios --- 
    // Rutas de exportación de usuarios (Mover estas rutas antes del resource)
    Route::get('/usuarios/exportar-excel', [UsuarioController::class, 'exportarExcel'])->name('usuarios.exportarExcel');
    Route::get('usuarios/exportarPDF', [UsuarioController::class, 'exportarPDF'])->name('usuarios.exportarPDF');

    // CRUD de usuarios
    Route::resource('usuarios', UsuarioController::class);

    Route::get('/perfil/editar', [UsuarioController::class, 'editar'])->name('perfil.editar');
    Route::post('/perfil/actualizar', [UsuarioController::class, 'actualizar'])->name('perfil.actualizar');
    Route::post('/perfil/eliminar-imagen', [UsuarioController::class, 'eliminarImagen'])->name('perfil.eliminarImagen');

    // --- Recuperar cuenta ---
    Route::post('/enviar-codigo', [RecuperarController::class, 'enviarCodigo'])->name('enviar.codigo');
    Route::get('/codigo', [RecuperarController::class, 'vistaCodigo'])->name('codigo');
    Route::post('/validar-codigo', [RecuperarController::class, 'validarCodigo'])->name('validar.codigo');

    // --- Dashboard / Análisis ---
    Route::get('/analisis', [DashboardController::class, 'index'])->name('analisis');

    // Imágenes del producto
    Route::get('/producto/{id}/imagenes', [ProductoController::class, 'gestionarImagenes'])->name('producto.imagenes');
    Route::post('/producto/{id}/imagenes', [ProductoController::class, 'subirImagen'])->name('producto.imagenes.subir');
    Route::delete('/imagenes/{id}', [ProductoController::class, 'eliminarImagen'])->name('imagenes.eliminar');

    // --- Compras ---
    // Exportaciones de compras
    Route::get('/compras/exportar-pdf', [ComprasController::class, 'exportarPDF'])->name('compras.exportarPDF');
    Route::get('/compras/exportar-excel', [ComprasController::class, 'exportarExcel'])->name('compras.exportarExcel');
    // CRUD de compras
    Route::resource('compras', ComprasController::class);

    Route::post('/categorias', [ProductoController::class, 'storeCategoria'])->name('categorias.store');
    Route::post('/subcategorias', [ProductoController::class, 'storeSubcategoria'])->name('subcategorias.store');

    Route::delete('/categorias/{id}', [ProductoController::class, 'destroyCat'])->name('categorias.destroy');
    Route::delete('/subcategorias/{id}', [ProductoController::class, 'destroySub'])->name('subcategorias.destroy');

    Route::get('/inventario/exportar-pdf', [ProductoController::class, 'exportarPDF'])->name('inventario.exportarPDF');
    Route::get('/ventas/exportar-pdf', [CarritoController::class, 'exportarPDF'])->name('ventas.exportarPDF');

    // --- Ventas ---
    Route::get('/ventas', [UsuarioController::class, 'ventas'])->name('ventas');
    // Exportaciones de ventas
    Route::get('/ventas/exportar-excel', [CarritoController::class, 'exportarExcel'])->name('ventas.exportarExcel');
});

// --- Carrito ---
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/finalizar', [CarritoController::class, 'finalizar'])->name('carrito.finalizar');
Route::delete('/carrito/eliminar/{id_producto}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::get('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
Route::post('/carrito/actualizar/{id}', [CarritoController::class, 'actualizarCantidad'])->name('carrito.actualizar');

// Ver producto
Route::get('/producto/ver/{id}', [ProductoController::class, 'verProducto'])->name('producto.ver');

// --- Dirección ---
Route::get('/direccion', function () {
    return view('direccion');
})->name('direccion');
Route::post('/actualizar-direccion', [UsuarioController::class, 'actualizarDireccion'])->name('perfil.actualizar_direccion');

// --- Historial ---
Route::get('/historial', [UsuarioController::class, 'historial'])->name('historial');
Route::get('/productos', [ProductoController::class, 'paginaFiltrada'])->name('productos.filtrados');

// --- Envio ---
Route::get('/envio', [EnvioController::class, 'index'])->name('envio.index');
Route::post('/envio/guardar', [EnvioController::class, 'guardar'])->name('envio.guardar');
Route::get('/envio/confirmacion', [EnvioController::class, 'confirmacion'])->name('envio.confirmacion');
Route::get('/compra/confirmacion', [ComprasController::class, 'confirmacion'])->name('compra.confirmacion');

// --- Rutas de Proceso de Venta y Facturación ---
Route::post('/venta/procesar', [CarritoController::class, 'procesarVenta'])->name('venta.procesar');
Route::get('/confirmacion/final/{id_factura}', [CarritoController::class, 'mostrarConfirmacionFinal'])->name('confirmacion.final');
Route::get('/factura/descargar/{id_factura}', [CarritoController::class, 'generarFacturaPDF'])->name('venta.descargarFactura');
<<<<<<< HEAD
=======

Route::get('/inventario/exportar-pdf', [ProductoController::class, 'exportarPDF'])->name('inventario.exportarPDF');
Route::get('/ventas/exportar-pdf', [CarritoController::class, 'exportarPDF'])->name('ventas.exportarPDF');

Route::get('/metodo-pago', [MetodoPagoController::class, 'index'])->name('metodo_pago.index');
Route::post('/metodo-pago/confirmar', [MetodoPagoController::class, 'store'])->name('metodo_pago.store');

Route::get('/confirmacion', [MetodoPagoController::class, 'confirmacion'])->name('metodo_pago.confirmacion');

Route::delete('/producto/{id_producto}/imagen/{id_imagen}', [ProductoController::class, 'eliminarImagen'])->name('producto.imagen.eliminar');
>>>>>>> 1c1ab74ed36ba0056e86f00d52a6134a83828c87
