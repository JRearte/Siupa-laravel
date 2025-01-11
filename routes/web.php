<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SalaController;



//Rutas del usuario
//Primer parametro  /usuario       → lo que muestra el URL (nombre de la ruta).
//Segundo parametro listar         → el nombre de la función (método invocado).
//Tercer parametro  usuario.listar → el nombre asignado a la ruta para ser invocada en la vista.
Route::controller(UsuarioController::class)->middleware('auth')->group(function () {
    Route::get('/usuarios', 'listar')->name('usuario.index');
    Route::get('usuario/presentacion/{id}', 'presentar')->name('usuario.presentacion');
    Route::get('usuario/formulario', 'formularioRegistrar')->name('usuario.agregar');
    Route::post('usuario/registrar', 'registrar')->name('usuario.registrar');
    Route::get('usuario/formulario/{id}', 'formularioModificar')->name('usuario.editar');
    Route::patch('usuario/modificar/{usuario}', 'modificar')->name('usuario.modificar');
    Route::get('usuario/advertencia/{id}', 'advertirEliminacion')->name('usuario.confirmar');
    Route::delete('usuario/eliminar/{id}', 'eliminar')->name('usuario.eliminar');
    Route::get('/usuario/reporte', 'generarReporte')->name('usuario.reporte');
});


Route::controller(SalaController::class)->middleware('auth')->group(function () {
    Route::get('/sala', 'listar')->name('sala.listar');
    Route::get('sala/agregar', 'agregar')->name('sala.agregar');
    Route::post('sala/registrar', 'registrar')->name('sala.registrar');
    Route::get('sala/editar/{id}', 'editar')->name('sala.editar');
    Route::patch('sala/modificar/{sala}', 'modificar')->name('sala.modificar');
    Route::delete('sala/eliminar/{id}', 'eliminar')->name('sala.eliminar');
});

Route::post('validar', [UsuarioController::class, 'validar'])->name('usuario.validar'); // Sin middleware
Route::post('/', [UsuarioController::class, 'logout'])->name('usuario.logout')->middleware('auth');
Route::get('/', [LoginController::class, 'inicio'])->name('login');//no aplicar seguridad o no existira forma de acceder 