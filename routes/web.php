<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\InfanteController;
use App\Http\Controllers\AsistenciaController;


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
    Route::delete('usuario/eliminar/{id}', 'eliminar')->name('usuario.eliminar');
    Route::get('/usuario/reporte', 'generarReporte')->name('usuario.reporte');
    Route::get('/usuario/reporte-especifico/{id}', 'generarReporteEspecifico')->name('usuario.reporte-especifico');
});


Route::controller(SalaController::class)->middleware('auth')->group(function () {
    Route::get('/salas', 'listar')->name('sala.index');
    Route::get('sala/presentacion/{id}', 'presentar')->name('sala.presentacion');
    //Route::get('sala/formulario', 'formularioRegistrar')->name('sala.agregar');
    //Route::post('sala/registrar', 'registrar')->name('sala.registrar');
    Route::get('sala/formulario/{id}', 'formularioModificar')->name('sala.editar');
    Route::patch('sala/modificar/{sala}', 'modificar')->name('sala.modificar');
    //Route::get('sala/advertencia/{id}', 'advertirEliminacion')->name('sala.confirmar');
    //Route::delete('sala/eliminar/{id}', 'eliminar')->name('sala.eliminar');
    Route::get('/sala/reporte-especifico/{id}', 'generarReporteEspecifico')->name('sala.reporte-especifico');
});

Route::controller(TutorController::class)->middleware('auth')->group(function () {
    Route::get('/tutores', 'listar')->name('tutor.index');
    Route::get('tutor/presentacion/{id}', 'presentar')->name('tutor.presentacion');
    Route::get('tutor/formulario', 'formularioRegistrar')->name('tutor.agregar');
    Route::post('tutor/registrar', 'registrar')->name('tutor.registrar');
    Route::get('tutor/formulario/{id}', 'formularioModificar')->name('tutor.editar');
    Route::patch('tutor/modificar/{tutor}', 'modificar')->name('tutor.modificar');
    Route::delete('tutor/eliminar/{id}', 'eliminar')->name('tutor.eliminar');

    // Rutas para registrar y eliminar contactos
    Route::get('tutor/{tutor_id}/formulario-registrar-telefono', 'formularioRegistrarTelefono')->name('tutor.agregar-telefono');
    Route::post('tutor/{tutor_id}/registrar-telefono', 'registrarTelefono')->name('tutor.registrar-telefono');
    Route::delete('tutor/eliminar-telefono/{id}', 'eliminarTelefono')->name('tutor.eliminar-telefono');

    Route::get('tutor/{tutor_id}/formulario-registrar-correo', 'formularioRegistrarCorreo')->name('tutor.agregar-correo');
    Route::post('tutor/{tutor_id}/registrar-correo', 'registrarCorreo')->name('tutor.registrar-correo');
    Route::delete('tutor/eliminar-correo/{id}', 'eliminarCorreo')->name('tutor.eliminar-correo');

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

    // Rutas para Registrar y Eliminar cuotas
    Route::get('tutor/{tutor_id}/formulario-registrar-cuota', 'formularioRegistrarCuota')->name('tutor.agregar-cuota');
    Route::post('tutor/{trabajador_id}/registrar-cuota', 'registrarCuota')->name('tutor.registrar-cuota');
    Route::delete('tutor/{tutor_id}/eliminar-cuota/{cuota_id}', 'eliminarCuota')->name('tutor.eliminar-cuota');

    // Rutas para Registrar y Modificar carrera
    Route::get('tutor/{tutor_id}/formulario-registrar-carrera', 'formularioRegistrarCarrera')->name('tutor.agregar-carrera');
    Route::post('tutor/{tutor_id}/registrar-carrera', 'registrarCarrera')->name('tutor.registrar-carrera');
    Route::get('tutor/{tutor_id}/formulario-modificar-carrera', 'formularioModificarCarrera')->name('tutor.editar-carrera');
    Route::patch('tutor/carrera-modificar/{carrera}', 'modificarCarrera')->name('tutor.modificar-carrera');

    // Rutas para Registrar, Modificar y Eliminar asignaturas
    Route::get('tutor/{tutor_id}/formulario-registrar-asignatura/{carrera_id}', 'formularioRegistrarAsignatura')->name('tutor.agregar-asignatura');
    Route::post('tutor/{tutor_id}/registrar-asignatura/{carrera_id}', 'registrarAsignatura')->name('tutor.registrar-asignatura');
    Route::get('tutor/{carrera_id}/formulario-modificar-asignatura/{asignatura_id}', 'formularioModificarAsignatura')->name('tutor.editar-asignatura');
    Route::patch('tutor/asignatura-modificar/{asignatura}', 'modificarAsignatura')->name('tutor.modificar-asignatura');
    Route::delete('tutor/{tutor_id}/eliminar-asignatura/{asignatura_id}', 'eliminarAsignatura')->name('tutor.eliminar-asignatura');
});

Route::controller(InfanteController::class)->middleware('auth')->group(function () {
    Route::get('infante/presentacion/{id}', 'presentar')->name('infante.presentacion');
    Route::get('infante/{tutor_id}/formulario-registrar', 'formularioRegistrar')->name('infante.agregar');
    Route::post('infante/{tutor_id}/registrar', 'registrar')->name('infante.registrar');
    Route::get('infante/formulario-modificar/{id}', 'formularioModificar')->name('infante.editar');
    Route::patch('infante/modificar/{infante}', 'modificar')->name('infante.modificar');
    Route::delete('infante/eliminar/{id}', 'eliminar')->name('infante.eliminar');
    
    // Rutas para Registrar y Eliminar datos médicos
    Route::get('infante/{infante_id}/formulario-registrar-medico', 'formularioRegistrarMedico')->name('infante.agregar-medico');
    Route::post('infante/{infante_id}/registrar-medico', 'registrarMedico')->name('infante.registrar-medico');
    Route::delete('infante/eliminar-medico/{id}', 'eliminarMedico')->name('infante.eliminar-medico');
    
    // Rutas para Registrar, Modificar y Eliminar familiares
    Route::get('infante/{infante_id}/formulario-registrar-familiar', 'formularioRegistrarFamiliar')->name('infante.agregar-familiar');
    Route::post('infante/{infante_id}/registrar-familiar', 'registrarFamiliar')->name('infante.registrar-familiar');
    Route::get('infante/formulario-modificar-familiar/{id}', 'formularioModificarFamiliar')->name('infante.editar-familiar');
    Route::patch('infante/modificar-familiar/{familia}', 'modificarFamiliar')->name('infante.modificar-familiar');
    Route::delete('infante/eliminar-familiar/{id}', 'eliminarFamiliar')->name('infante.eliminar-familiar');
});

Route::controller(AsistenciaController::class)->middleware('auth')->group(function () {
    Route::get('asistencia/presentacion/{id}', 'presentar')->name('asistencia.presentacion');
    Route::get('/asistencias', 'listar')->name('asistencia.index');
    Route::get('asistencia/{infante}/{sala}/reporte', 'generarReporteEspecifico')->name('asistencia.reporte-especifico');
});

Route::post('validar', [UsuarioController::class, 'validar'])->name('usuario.validar'); // Sin middleware
Route::post('/', [UsuarioController::class, 'logout'])->name('usuario.logout')->middleware('auth');
Route::get('/', [LoginController::class, 'inicio'])->name('login');//no aplicar seguridad o no existira forma de acceder 
