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
                <strong>¿Está seguro de que desea eliminar al infante
                    <span style="color: #d9534f;">{{ $infante->Nombre }} {{ $infante->Apellido }}</span>?</strong>
            </p>
            <p>Esta acción es <strong>irreversible</strong>. Si solo desea impedir que el infante dejen de ser 
                funcional en el sistema, considere <strong>deshabilitarlo</strong> en lugar de eliminarlo.</p>
            <p><strong>Eliminar este infante afectará los siguientes datos relacionados:</strong></p>
            <ul class="confirmacion-lista">
                <li>El <strong>familiares</strong> asociado y toda su información.</li>
                <li>Los <strong>datos médicos</strong>.</li>
                <li>Las <strong>asistencias</strong>.</li>

            </ul>
            <p class="confirmacion-advertencia">⚠️ Esta acción no se puede deshacer.</p>

            <hr>

            <form action="{{ route('infante.eliminar', $infante->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger confirmacion-boton">Eliminar</button>
                <a href="{{ route('infante.presentacion', $infante->id) }}" class="btn btn-secondary confirmacion-boton">Cancelar</a>
            </form>
        </div>
    </div>
@endsection