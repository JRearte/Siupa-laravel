<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UsuarioController;



//Rutas del usuario
//Primer parametro  /usuario       → lo que muestra el URL.
//Segundo parametro listar         → el nombre de la función.
//Tercer parametro  usuario.listar → el nombre asignado a la ruta para ser invocada como funcion en general.
Route::controller(UsuarioController::class)->group(function(){
    Route::get('/usuario','listar')->name('usuario.listar');
    Route::get('usuario/agregar','agregar')->name('usuario.agregar');
    Route::post('usuario/registrar','registrar')->name('usuario.registrar');
    Route::get('usuario/editar/{id}','editar')->name('usuario.editar');
    Route::patch('usuario/modificar/{usuario}','modificar')->name('usuario.modificar');
    Route::delete('usuario/eliminar/{id}','eliminar')->name('usuario.eliminar');
    Route::post('validar','validar')->name('usuario.validar');
});



Route::get('/menu', [MenuController::class, 'menu'])->name('menu');
Route::get('/', [LoginController::class, 'inicio'])->name('login');


