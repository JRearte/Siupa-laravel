@extends('layouts.principal')
@section('title', 'Advertencia')
@section('content')
@vite(['resources/css/alerta.css'])
<div class="container confirmacion-container">
    <div class="alert alert-warning confirmacion-alerta">
        <h4 class="alert-heading confirmacion-titulo">
            <i class="fas fa-exclamation-triangle confirmacion-icono"></i> 
            Confirmación de Eliminación
        </h4>
        <p class="confirmacion-mensaje">
            ¿Está seguro de que desea eliminar la sala 
            <strong>{{ $sala->Nombre }}</strong>? 
            Esta acción no se puede deshacer. Antes de confirmar, asegúrese de que no haya infantes en la sala.
        </p>        
        <hr>
        <form action="{{ route('sala.eliminar', $sala->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger confirmacion-boton">Eliminar</button>
            <a href="{{ route('sala.index') }}" class="btn btn-secondary confirmacion-boton">Cancelar</a>
        </form>
    </div>
</div>
@endsection