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
                <strong>¿Está seguro de que desea eliminar al tutor
                    <span style="color: #d9534f;">{{ $tutor->Nombre }} {{ $tutor->Apellido }}</span>?</strong>
            </p>
            <p>Esta acción es <strong>irreversible</strong>. Si solo desea impedir que el tutor y sus infantes dejen de ser 
                funcionales en el sistema, considere <strong>deshabilitarlo</strong> en lugar de eliminarlo.</p>
            <p><strong>Eliminar este tutor afectará los siguientes datos relacionados:</strong></p>
            <ul class="confirmacion-lista">
                <li>El <strong>infante</strong> asociado y toda su información.</li>
                <li>Los <strong>datos de contacto</strong> y el <strong>domicilio</strong> del tutor.</li>
                @if ($tutor->Tipo_tutor === 'Trabajador')
                    <li>El historial de <strong>cuotas pagadas</strong>.</li>
                @else
                    <li>Los <strong>datos académicos</strong> del tutor.</li>
                @endif
            </ul>
            <p class="confirmacion-advertencia">⚠️ Esta acción no se puede deshacer.</p>

            <hr>

            <form action="{{ route('tutor.eliminar', $tutor->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger confirmacion-boton">Eliminar</button>
                <a href="{{ route('tutor.presentacion', $tutor->id) }}" class="btn btn-secondary confirmacion-boton">Cancelar</a>
            </form>
        </div>
    </div>
@endsection

