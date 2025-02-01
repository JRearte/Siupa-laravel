@extends('layouts.principal')
@section('title', 'Carta de Tutor')
@section('content')
    @vite(['resources/css/presentacion.css'])
    <div class="presentacion">
        <div class="container">
            <!-- Encabezado -->
            <div class="header">
                <div class="icon-container">
                    @if ($tutor->Tipo_tutor == 'Trabajador')
                        <i class="fa-solid fa-briefcase icon"></i>
                    @elseif($tutor->Tipo_tutor == 'Alumno')
                        <i class="fa-solid fa-graduation-cap icon"></i>
                    @else
                        <i class="fa-solid fa-user icon"></i>
                    @endif
                </div>
                <div class="datos">
                    <p><strong>Creación:</strong></p>
                    <p>{{ $tutor->created_at->translatedFormat('d F Y \a \l\a\s H:i') }}</p>
                    <p><strong>Modificación:</strong></p>
                    <p>{{ $tutor->updated_at->translatedFormat('d F Y \a \l\a\s H:i') }}</p>
                </div>
            </div>

            <hr class="separador">

            <!-- Información del Tutor -->
            <div class="content">

                <div class="column">
                    <p><strong>Legajo:</strong></p>
                    <p>{{ $tutor->Legajo }}</p>
                    <p><strong>Nombre:</strong></p>
                    <p>{{ $tutor->Nombre }} {{ $tutor->Apellido }}</p>
                    <p><strong>Fecha de nacimiento:</strong></p>
                    <p> {{ \Carbon\Carbon::parse($tutor->Fecha_de_nacimiento)->translatedFormat('d F Y') }}</p>
                    <p><strong>Edad:</strong></p>
                    <p>{{ $edad }} años</p>

                    <!-- Datos de Trabajador -->
                    @if ($tutor->Tipo_tutor === 'Trabajador' && $trabajador)
                        <div class="trabajador">
                            <p><strong>Cargo:</strong></p>
                            <p>{{ $trabajador->Cargo }}</p>
                        </div>
                    @endif


                </div>
                <div class="column">

                    @if ($tutor->Tipo_tutor === 'Trabajador' && $trabajador)
                        <div class="opciones" data-tipo="{{ strtolower($tutor->Tipo_tutor) }}">
                            <a href="{{ route('tutor.editar-trabajador', $tutor?->id) }}" class="btn btn-dark ms-2">
                                <i class="original fa-regular fa-id-card"></i>
                                <i class="cambio fa-solid fa-pencil"></i>
                            </a>
                        </div>
                    @else
                        <div class="opciones" data-tipo="{{ strtolower($tutor->Tipo_tutor) }}">
                            <a href="{{ route('tutor.agregar-trabajador', $tutor?->id) }}" class="btn btn-dark ms-2">
                                <i class="original fa-regular fa-id-card"></i>
                                <i class="cambio fa-solid fa-plus"></i>
                            </a>
                        </div>
                    @endif


                    <p><strong>Documento:</strong></p>
                    <p>{{ $tutor->Tipo_documento }}: {{ $tutor->Numero_documento }}</p>
                    <p><strong>Género:</strong></p>
                    <p>{{ $tutor->Genero }}</p>
                    <p><strong>Estado:</strong></p>
                    <p>{{ $tutor->Habilitado ? 'Habilitado' : 'Deshabilitado' }}</p>

                    <!-- Datos de Trabajador -->
                    @if ($tutor->Tipo_tutor === 'Trabajador' && $trabajador)
                        <div class="trabajador">
                            <p><strong>Tipo de Tutor:</strong></p>
                            <p>{{ $tutor->Tipo_tutor }} {{ $trabajador?->Tipo }}</p>
                            <p><strong>Horas de trabajo:</strong></p>
                            <p>{{ $trabajador?->Hora }}</p>
                        </div>
                    @endif

                    <!-- Datos de Alumno -->
                    @if ($tutor->Tipo_tutor === 'Alumno')
                        <p><strong>Tipo de Tutor:</strong></p>
                        <p>{{ $tutor->Tipo_tutor }}</p>
                    @endif

                </div>
            </div>

            <hr class="separador">

            <!-- Información de Domicilio y Contacto -->
            <div class="content">

                <div class="column">
                    @if ($tutor->domicilio)
                        <div class="opciones domicilio">
                            <a href="{{ route('tutor.editar-domicilio', $tutor?->id) }}" class="btn btn-dark ms-2">
                                <i class="original fa-solid fa-house"></i>
                                <i class="cambio fa-solid fa-pencil"></i>
                            </a>
                            <h5>Domicilio</h5>
                        </div>
                        <p><strong>Provincia:</strong></p>
                        <p>{{ $tutor->domicilio?->Provincia }}</p>
                        <p><strong>Localidad:</strong></p>
                        <p>{{ $tutor->domicilio?->Localidad }}</p>
                        <p><strong>Barrio:</strong></p>
                        <p>{{ $tutor->domicilio?->Barrio }}</p>
                        <p><strong>Calle:</strong></p>
                        <p>{{ $tutor->domicilio?->Calle }}</p>
                        <p><strong>Numero:</strong></p>
                        <p>{{ $tutor->domicilio?->Numero }}</p>
                        <p><strong>Código postal:</strong></p>
                        <p>{{ $tutor->domicilio?->Codigo_postal }}</p>
                    @else
                        <div class="opciones domicilio">
                            <a href="{{ route('tutor.agregar-domicilio', $tutor?->id) }}" class="btn btn-dark ms-2">
                                <i class="original fa-solid fa-house"></i>
                                <i class="cambio fa-solid fa-plus"></i>
                            </a>
                            <h5>Domicilio</h5>
                        </div>
                    @endif
                </div>

                <div class="column">
                    <h5><i class="fa-solid fa-address-book"></i> Contactos</h5>
                    <p><strong>Correo:</strong></p>
                    @foreach ($tutor->correos as $correo)
                        <p>{{ $correo?->Mail }}</p>
                    @endforeach
                    <hr class="separador">
                    <p><strong>Teléfono:</strong></p>
                    @foreach ($tutor->telefonos as $telefono)
                        <p>{{ $telefono?->Numero }}</p>
                    @endforeach
                </div>
            </div>
            <hr class="separador">

            <div class="trabajador {{ $tutor->Tipo_tutor === 'Trabajador' ? 'activo' : 'oculto' }}">
                <!-- Cuotas de trabajador -->
                <div class="cuotas-container">
                    <h6><i class="fa-solid fa-piggy-bank"></i> Cuotas</h6>
                    @if ($tutor->Tipo_tutor === 'Trabajador')
                        @if ($cuotas)
                            <div class="cuotas">
                                <div class="cuotas-header">
                                    <p><strong>Valor</strong></p>
                                    <p><strong>Fecha</strong></p>
                                </div>
                                @foreach ($cuotas as $cuota)
                                    <div class="cuota-item">
                                        <p>${{ number_format($cuota?->Valor, 2) }}</p>
                                        <p>{{ \Carbon\Carbon::parse($cuota?->Fecha)->translatedFormat('d F Y') }}</p>
                                    </div>
                                @endforeach
                                <div class="cuota-item">
                                    <p>${{ number_format($total, 2) }}</p>
                                    <p><strong>Recaudación total </strong> </p>
                                </div>
                            </div>
                        @else
                            <p>No tiene cuotas registradas.</p>
                        @endif
                    @endif
                </div>
            </div>









            @if ($tutor->Tipo_tutor === 'Alumno')
                <!-- Datos de Alumno -->
                <h3>Datos de Alumno</h3>
                <p><strong>Carrera:</strong> {{ $carrera?->Nombre }}</p>

                <h4>Asignaturas</h4>
                <ul>
                    @foreach ($asignaturas as $asignatura)
                        <li>{{ $asignatura?->Nombre }} - Condición: {{ $asignatura?->Condicion }} - Calificación:
                            {{ $asignatura?->Calificacion }}</li>
                    @endforeach
                </ul>
            @endif

            <!-- Infantes -->
            <h3>Infantes</h3>
            <ul>
                @foreach ($infantes as $infante)
                    <li>{{ $infante?->Nombre }} {{ $infante?->Apellido }} - {{ $infante?->Categoria }}</li>
                @endforeach
            </ul>

            <!-- Botón -->
            <a href="{{ route('tutor.index') }}" class="btn btn-primary">Volver</a>
        </div>
    </div>
@endsection
