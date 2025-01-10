<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SalaController;



//Rutas del usuario
//Primer parametro  /usuario       → lo que muestra el URL.
//Segundo parametro listar         → el nombre de la función.
//Tercer parametro  usuario.listar → el nombre asignado a la ruta para ser invocada como funcion en general.
    Route::controller(UsuarioController::class)->middleware('auth')->group(function() {
        Route::get('/usuarios', 'listar')->name('usuario.index');
        Route::get('usuario/presentacion/{id}', 'mostrar')->name('usuario.presentacion');
        Route::get('usuario/agregar', 'agregar')->name('usuario.agregar');
        Route::post('usuario/registrar', 'registrar')->name('usuario.registrar');
        Route::get('usuario/editar/{id}', 'editar')->name('usuario.editar');
        Route::patch('usuario/modificar/{usuario}', 'modificar')->name('usuario.modificar');
        Route::delete('usuario/eliminar/{id}', 'eliminar')->name('usuario.eliminar');
        Route::get('usuario/confirmar/{id}', 'confirmar')->name('usuario.confirmar');
        Route::get('/usuario/reporte', 'generarReporte')->name('usuario.reporte');
    });
    
Route::post('validar', [UsuarioController::class, 'validar'])->name('usuario.validar'); // Sin middleware
Route::post('/', [UsuarioController::class, 'logout'])->name('usuario.logout')->middleware('auth');



Route::controller(SalaController::class)->middleware('auth')->group(function(){
    Route::get('/sala','listar')->name('sala.listar');
    Route::get('sala/agregar','agregar')->name('sala.agregar');
    Route::post('sala/registrar','registrar')->name('sala.registrar');
    Route::get('sala/editar/{id}', 'editar')->name('sala.editar');
    Route::patch('sala/modificar/{sala}','modificar')->name('sala.modificar');
    Route::delete('sala/eliminar/{id}','eliminar')->name('sala.eliminar');
});

Route::get('/', [LoginController::class, 'inicio'])->name('login');//no aplicar seguridad o no existira forma de acceder 