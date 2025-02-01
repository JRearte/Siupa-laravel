<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\TutorController;



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
    Route::get('/salas', 'listar')->name('sala.index');
    Route::get('sala/formulario', 'formularioRegistrar')->name('sala.agregar');
    Route::post('sala/registrar', 'registrar')->name('sala.registrar');
    Route::get('sala/formulario/{id}', 'formularioModificar')->name('sala.editar');
    Route::patch('sala/modificar/{sala}', 'modificar')->name('sala.modificar');
    Route::get('sala/advertencia/{id}', 'advertirEliminacion')->name('sala.confirmar');
    Route::delete('sala/eliminar/{id}', 'eliminar')->name('sala.eliminar');
});

Route::controller(TutorController::class)->middleware('auth')->group(function () {
    Route::get('/tutores', 'listar')->name('tutor.index');
    Route::get('tutor/presentacion/{id}', 'presentar')->name('tutor.presentacion');
    Route::get('tutor/formulario', 'formularioRegistrar')->name('tutor.agregar');
    Route::post('tutor/registrar', 'registrar')->name('tutor.registrar');
    Route::get('tutor/formulario/{id}', 'formularioModificar')->name('tutor.editar');
    Route::patch('tutor/modificar/{tutor}', 'modificar')->name('tutor.modificar');

    // Rutas para Registrar y Modificar domicilio
    Route::get('tutor/{tutor_id}/formulario-registrar-domicilio', 'formularioRegistrarDomicilio')->name('tutor.agregar-domicilio');
    Route::post('tutor/{tutor_id}/registrar-domicilio', 'registrarDomicilio')->name('tutor.registrar-domicilio');
    Route::get('tutor/{tutor_id}/formulario-modificar-domicilio', 'formularioModificarDomicilio')->name('tutor.editar-domicilio');
    Route::patch('tutor/domicilio-modificar/{domicilio}', 'modificarDomicilio')->name('tutor.modificar-domicilio');

    // Rutas para Registrar y Modificar trabajador universitario
    Route::get('tutor/{tutor_id}/formulario-registrar-trabajador', 'formularioRegistrarTrabajador')->name('tutor.agregar-trabajador');
    Route::post('tutor/{tutor_id}/registrar-trabajador', 'registrarTrabajador')->name('tutor.registrar-trabajador');
    Route::get('tutor/{tutor_id}/formulario-modificar-trabajador', 'formularioModificarTrabajador')->name('tutor.editar-trabajador');
    Route::patch('tutor/trabajador-modificar/{trabajador}', 'modificarTrabajador')->name('tutor.modificar-trabajador');
});


Route::post('validar', [UsuarioController::class, 'validar'])->name('usuario.validar'); // Sin middleware
Route::post('/', [UsuarioController::class, 'logout'])->name('usuario.logout')->middleware('auth');
Route::get('/', [LoginController::class, 'inicio'])->name('login');//no aplicar seguridad o no existira forma de acceder 
