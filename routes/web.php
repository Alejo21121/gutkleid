<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RecuperarController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ComprasController;
use Barryvdh\DomPDF\Facade\Pdf;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta principal
Route::get('/', [InicioController::class, 'index'])->name('inicio');

// --- Rutas de Autenticación (Login y Registro) ---
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.procesar');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro.form');
Route::post('/registro', [RegistroController::class, 'registrar'])->name('registro.enviar');

// --- Rutas de Perfil de Usuario ---
Route::get('/producto/{producto}/edit', [ProductoController::class, 'edit'])->name('producto.edit');
Route::put('/producto/{producto}', [ProductoController::class, 'update'])->name('producto.update');

// --- Rutas Adicionales de Productos (DEBEN IR ANTES de Route::resource) ---
// Estas rutas son más específicas y podrían ser "tragadas" por el comodín {producto}
// si Route::resource se declara antes.
Route::get('/producto/exportar-excel', [ProductoController::class, 'exportarExcel'])->name('producto.exportarExcel');
Route::get('/producto/exportar-pdf', [ProductoController::class, 'exportarPDF'])->name('producto.exportarPDF');

// --- Rutas para la gestión de Productos (CRUD completo) ---
// La línea Route::resource debe ir DESPUÉS de las rutas específicas que comparten el prefijo.
// Esta línea genera: index, create, store, show, edit, update, destroy.
Route::resource('producto', ProductoController::class);

// --- Rutas para Vistas Estáticas o que solo retornan una vista ---
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
Route::view('/analisis', 'analisis')->name('analisis');
Route::view('/inicio', 'inicio')->name('inicio_view');

Route::resource('usuarios', UsuarioController::class);
Route::get('usuarios/exportarExcel', [UsuarioController::class, 'exportarExcel'])->name('usuarios.exportarExcel');
Route::get('usuarios/exportarPDF', [UsuarioController::class, 'exportarPDF'])->name('usuarios.exportarPDF');


Route::get('/perfil/editar', [UsuarioController::class, 'editar'])->name('perfil.editar');
Route::post('/perfil/actualizar', [UsuarioController::class, 'actualizar'])->name('perfil.actualizar');
Route::post('/perfil/eliminar-imagen', [UsuarioController::class, 'eliminarImagen'])->name('perfil.eliminarImagen');



Route::post('/enviar-codigo', [RecuperarController::class, 'enviarCodigo'])->name('enviar.codigo');
Route::get('/codigo', [RecuperarController::class, 'vistaCodigo'])->name('codigo');
Route::post('/validar-codigo', [RecuperarController::class, 'validarCodigo'])->name('validar.codigo');

Route::get('/analisis', [DashboardController::class, 'index'])->name('analisis');

Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/finalizar', [CarritoController::class, 'finalizar'])->name('carrito.finalizar');
Route::delete('/carrito/eliminar/{id_producto}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::get('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');

Route::get('/producto/ver/{id}', [ProductoController::class, 'verProducto'])->name('producto.ver');


// Imagenes del producto
Route::get('/producto/{id}/imagenes', [ProductoController::class, 'gestionarImagenes'])->name('producto.imagenes');
Route::post('/producto/{id}/imagenes', [ProductoController::class, 'subirImagen'])->name('producto.imagenes.subir');
Route::delete('/imagenes/{id}', [ProductoController::class, 'eliminarImagen'])->name('imagenes.eliminar');

Route::post('/carrito/actualizar/{id}', [CarritoController::class, 'actualizarCantidad'])->name('carrito.actualizar');

Route::resource('compras', ComprasController::class);
Route::get('/compras/exportar-excel', [ComprasController::class, 'exportarExcel'])->name('compras.exportarExcel');
Route::get('/compras/exportar-pdf', [ComprasController::class, 'exportarPDF'])->name('compras.exportarPDF');
Route::post('/compras/store', [ComprasController::class, 'store'])->name('compra.store');


Route::get('/direccion', function () {return view('direccion');})->name('direccion');
Route::post('/actualizar-direccion', [UsuarioController::class, 'actualizarDireccion'])->name('perfil.actualizar_direccion');

Route::get('/historial', [UsuarioController::class, 'historial'])->name('historial');
