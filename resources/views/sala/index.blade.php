@extends('layouts.principal')
@section('title', 'Gestor de salas')
@section('content')
    <div class="contenedor-principal">

        <!-- Cabecera principal -->
        <div class="cabecera">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Título -->
                <h6 class="titulo mb-0">{{ __('Gestión de Salas') }}</h6>

                <!-- Botones de acciones -->
                <div class="acciones d-flex">
                    <a href="{{ route('sala.agregar') }}" class="btn btn-dark ms-2">
                        <i class="fas fa-plus-square"></i> <span>{{ __('Agregar') }}</span>
                    </a>

                </div>
            </div>
        </div>

        <!-- Contenedor de datos principales -->
        <div class="contenido-principal">
            @include('sala.listar', ['sala1' => $sala1, 'sala2' => $sala2, 'sala3' => $sala3])
            
            <!-- Sección de estadísticas -->
            <div class="estadisticas-usuarios">
                @include('sala.estadistica', compact('sala1', 'sala2', 'sala3'))
            </div>
        </div>

    </div>
@endsection