@extends('layouts.principal')
@section('title', 'Carta de Asistencias')
@section('content')
    @vite(['resources/css/presentacion.css'])
    @vite(['resources/js/dropdown.js'])
    <div class="presentacion">
        <div class="container">

            <!-- ==================== Encabezado ==================== -->
            <div class="header">
                <!-- Icono según el tipo de tutor -->
                <div class="icon-container">
                    @if ($infante->Categoria == 'Ingresante')
                        <i class="fa-solid fa-user-plus icon"></i>
                    @else
                        <i class="fa-solid fa-user-check icon"></i>
                    @endif

                </div>
                <!-- Fechas de creación y modificación -->
                <div class="datos">
                    <p><strong>Creación:</strong></p>
                    <p>{{ $infante->created_at->translatedFormat('d F Y \a \l\a\s H:i') }}</p>
                    <p><strong>Modificación:</strong></p>
                    <p>{{ $infante->updated_at->translatedFormat('d F Y \a \l\a\s H:i') }}</p>
                </div>
                
                <div class="opciones">
                    <a href="{{ route('asistencia.reporte-especifico', ['infante' => $infante->id, 'sala' => $infante->sala_id]) }}">
                        <i class="fas fa-file-alt"></i>
                    </a>
                </div>
            </div>
            <hr class="separador">

            <!-- ==================== Información del Infante ==================== -->
            <div class="content">
                <div class="column">
                    <p><strong>Nombre:</strong></p>
                    <p>{{ $infante->Nombre }} {{ $infante->Apellido }}</p>
                    <p><strong>Género:</strong></p>
                    <p>{{ $infante->Genero }}</p>
                    <p><strong>Fecha de nacimiento:</strong></p>
                    <p>{{ $infante->Fecha_de_nacimiento->translatedFormat('d F Y') }}</p>


                </div>
                <div class="column">
                    <p><strong>Documento:</strong></p>
                    <p>{{ $infante->Tipo_documento }}: {{ $infante->Numero_documento }}</p>
                    <p><strong>Categoria:</strong></p>
                    <p>{{ $infante->Categoria }}</p>
                    <p><strong>Fecha de asignacion:</strong></p>
                    <p>{{ $infante->Fecha_de_asignacion->translatedFormat('d F Y') }}</p>

                </div>
            </div>
            <hr class="separador">

            @include('asistencia.calendario', ['mes' => $mes, 'asistenciasPorDia' => $asistenciasPorDia, 'infante' => $infante])


            <!-- ==================== Botón de retorno ==================== -->
            <a href="{{ route('asistencia.index') }}" class="btn btn-primary">Volver</a>
        </div>
    </div>
@endsection
