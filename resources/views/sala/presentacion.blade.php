@extends('layouts.principal')
@section('title', 'Carta de sala')
@section('content')
    @vite(['resources/css/presentacion.css'])
    @vite(['resources/js/dropdown.js'])
    <div class="presentacion">
        <div class="container">

            <!-- ==================== Encabezado ==================== -->
            <div class="header">
                <!-- Icono según el tipo de tutor -->
                <div class="icon-container">
                    @if ($sala->Edad == 0)
                        <i class="fa-solid fa-baby-carriage icon"></i>
                    @elseif ($sala->Edad == 1)
                        <i class="fa-solid fa-child icon"></i>
                    @else
                        <i class="fa-solid fa-child-reaching icon"></i>
                    @endif


                </div>
                <!-- Fechas de creación y modificación -->
                <div class="datos">
                    <p><strong>Creación:</strong></p>
                    <p>{{ $sala->created_at->translatedFormat('d F Y \a \l\a\s H:i') }}</p>
                    <p><strong>Modificación:</strong></p>
                    <p>{{ $sala->updated_at->translatedFormat('d F Y \a \l\a\s H:i') }}</p>
                </div>
                <!-- Opción de eliminar -->
                <div class="opciones">
                    <a href="{{ route('sala.reporte-especifico', $sala->id) }}">
                        <i class="fas fa-file-alt"></i>
                    </a>                    
                </div>
            </div>
            <hr class="separador">

            <!-- ==================== Información de la sala ==================== -->
            <div class="content">
                <div class="column">
                    <p><strong>Nombre:</strong></p>
                    <p>{{ $sala->Nombre }} </p>
                    <p><strong>Edad:</strong></p>
                    <p>{{ $sala->Edad }} {{ $sala->Edad == 1 ? 'año' : 'años' }}</p>

                </div>
                <div class="column">
                    <p><strong>Capacidad:</strong></p>
                    <p>{{ $sala->Capacidad }}</p>
                    <p><strong>Infantes:</strong></p>
                    <p>{{ $cantidad }}</p>


                    <!-- Botón de edición -->
                    <div class="opciones editar">
                        <a class="editar" href="{{ route('sala.editar', $sala->id) }}">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="separador">


            <!-- ==================== Información de los infantes ==================== -->
            <div class="trabajador">
                <div class="cuotas-container">
                    <div style="text-align: center">
                        <span>
                            @if ($sala->Edad == 0)
                                <i class="fa-solid fa-baby-carriage"></i>
                            @elseif ($sala->Edad == 1)
                                <i class="fa-solid fa-child"></i>
                            @else
                                <i class="fa-solid fa-child-reaching"></i>
                            @endif
                            Infantes
                        </span>
                    </div>

                    <hr class="separador">

                    @if ($infantes)
                        <div class="cuotas">
                            @foreach ($infantes as $infante)
                                <div class="cuota-item">
                                    <p>
                                        @if ($infante->Categoria === 'Ingresante')
                                            <i class="fa-solid fa-user-plus"></i>
                                        @else
                                            <i class="fa-solid fa-user-check"></i>
                                        @endif
                                        {{ $infante->Nombre }} {{ $infante->Apellido }}
                                    </p>
                                    <p>{{ $infante->Fecha_de_asignacion->translatedFormat('d F Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No hay infantes inscriptos.</p>
                    @endif
                </div>
            </div>

            <!-- ==================== Botón de retorno ==================== -->
            <a href="{{ route('sala.index') }}" class="btn btn-primary">Volver</a>
        </div>
    </div>
@endsection
