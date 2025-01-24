@extends('layouts.principal')
@section('title', 'Gestor de tutores')
@section('content')
    <div class="contenedor-principal">

        <div class="cabecera">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Título -->
                <h6 class="titulo mb-0">{{ __('Gestión de Tutores') }}</h6>
            </div>
        </div>


        <div class="contenido-principal">
            @include('tutor.listar', ['trabajadores' => $trabajadores, 'alumnos' => $alumnos])

        </div>

    </div>
@endsection
