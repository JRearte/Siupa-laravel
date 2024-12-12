@extends('layouts.principal')
@section('title', 'Confirmar Eliminación')
@section('content')
@vite(['resources/css/alerta.css'])
<div class="container confirmacion-container">
    <div class="alert alert-warning confirmacion-alerta">
        <h4 class="alert-heading confirmacion-titulo">
            <i class="fas fa-exclamation-triangle confirmacion-icono"></i> 
            Confirmación de Eliminación
        </h4>
        <p class="confirmacion-mensaje">
            ¿Está seguro de que desea eliminar al usuario 
            <strong>{{ $usuario->Nombre }} {{ $usuario->Apellido }}</strong>? 
            Esta acción no se puede deshacer. Si solo desea impedir que el usuario siga interactuando con el sistema, considere deshabilitarlo en lugar de eliminarlo.
        </p>
        <hr>
        <form action="{{ route('usuario.eliminar', $usuario->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger confirmacion-boton">Eliminar</button>
            <a href="{{ route('usuario.index') }}" class="btn btn-secondary confirmacion-boton">Cancelar</a>
        </form>
    </div>
</div>
@endsection

