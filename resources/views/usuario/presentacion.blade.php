@extends('layouts.principal')
@section('title', 'Carta de usuario')
@section('content')
    @vite(['resources/css/presentacion.css'])
    <div class="presentacion">
        <div class="container">
            <!-- Encabezado -->
            <div class="header">
                <div class="icon-container">
                    @if ($usuario->Categoria == 'Bienestar')
                        <i class="fa-solid fa-crown icon"></i>
                    @elseif($usuario->Categoria == 'Coordinador')
                        <i class="fa-solid fa-user-tie icon"></i>
                    @elseif($usuario->Categoria == 'Maestro')
                        <i class="fa-solid fa-chalkboard-teacher icon"></i>
                    @else
                        <i class="fa-solid fa-user icon"></i>
                    @endif
                </div>
                <div class="datos">
                    <p><strong>Creación:</strong></p>
                    <p>{{ $usuario->created_at->translatedFormat('d F Y \a \l\a\s H:i') }}</p>
                    <p><strong>Modificación:</strong></p>
                    <p>{{ $usuario->updated_at->translatedFormat('d F Y \a \l\a\s H:i') }}</p>
                </div>
            </div>
            <hr class="separador">

            <!-- Información del Usuario -->
            <div class="content">
                <div class="column">
                    <p><strong>Legajo:</strong></p>
                    <p>{{ $usuario->Legajo }}</p>
                    <p><strong>Nombre:</strong></p>
                    <p>{{ $usuario->Nombre }} {{ $usuario->Apellido }}</p>
                </div>
                <div class="column">
                    <p><strong>Categoría:</strong></p>
                    <p>{{ $usuario->Categoria }}</p>
                    <p><strong>Estado:</strong></p>
                    <p>{{ $usuario->Habilitado ? 'Habilitado' : 'Deshabilitado' }}</p>
                </div>
            </div>
            
            <!-- Historial del Usuario -->
            <hr class="separador">
            <div class="historial">
                @foreach ($historial as $registro)
                    <p>{{ $registro->detalles }}</p>
                    <hr class="separator">
                @endforeach
            </div>
            <!-- Botón -->
            <a href="{{ route('usuario.index') }}" class="btn btn-primary">Volver</a>
        </div>
    </div>
@endsection
