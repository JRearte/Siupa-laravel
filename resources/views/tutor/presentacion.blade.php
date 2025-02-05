@extends('layouts.principal')
@section('title', 'Carta de Tutor')
@section('content')
    @vite(['resources/css/presentacion.css'])
    <div class="presentacion">
        <div class="container">

            <!-- ==================== Encabezado ==================== -->
            <div class="header">
                <!-- Icono según el tipo de tutor -->
                <div class="icon-container">
                    @if ($tutor->Tipo_tutor == 'Trabajador')
                        <i class="fa-solid fa-briefcase icon"></i>
                    @elseif($tutor->Tipo_tutor == 'Alumno')
                        <i class="fa-solid fa-graduation-cap icon"></i>
                    @else
                        <i class="fa-solid fa-user icon"></i>
                    @endif
                </div>
                <!-- Fechas de creación y modificación -->
                <div class="datos">
                    <p><strong>Creación:</strong></p>
                    <p>{{ $tutor->created_at->translatedFormat('d F Y \a \l\a\s H:i') }}</p>
                    <p><strong>Modificación:</strong></p>
                    <p>{{ $tutor->updated_at->translatedFormat('d F Y \a \l\a\s H:i') }}</p>
                </div>
                <!-- Opción de eliminar -->
                <div class="opciones">
                    <a class="eliminar" href="{{ route('tutor.confirmar', $tutor->id) }}">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </div>
            </div>
            <hr class="separador">

            <!-- ==================== Información del Tutor ==================== -->
            <div class="content">
                <div class="column">
                    <p><strong>Legajo:</strong></p>
                    <p>{{ $tutor->Legajo }}</p>
                    <p><strong>Nombre:</strong></p>
                    <p>{{ $tutor->Nombre }} {{ $tutor->Apellido }}</p>
                    <p><strong>Fecha de nacimiento:</strong></p>
                    <p>{{ $tutor->Fecha_de_nacimiento->translatedFormat('d F Y') }}</p>
                    <p><strong>Edad:</strong></p>
                    <p>{{ $edad }} años</p>

                    <!-- Información adicional si es Trabajador -->
                    @if ($tutor->Tipo_tutor === 'Trabajador' && $trabajador)
                        <div class="trabajador">
                            <p><strong>Cargo:</strong></p>
                            <p>{{ $trabajador->Cargo }}</p>
                        </div>
                    @endif
                </div>
                <div class="column">
                    <p><strong>Documento:</strong></p>
                    <p>{{ $tutor->Tipo_documento }}: {{ $tutor->Numero_documento }}</p>
                    <p><strong>Género:</strong></p>
                    <p>{{ $tutor->Genero }}</p>
                    <p><strong>Estado:</strong></p>
                    <p>{{ $tutor->Habilitado ? 'Habilitado' : 'Deshabilitado' }}</p>

                    <!-- Información de trabajador -->
                    @if ($tutor->Tipo_tutor === 'Trabajador' && $trabajador)
                        <div class="trabajador">
                            <p><strong>Tipo de Tutor:</strong></p>
                            <p>{{ $tutor->Tipo_tutor }} {{ $trabajador?->Tipo }}</p>
                            <p><strong>Horas de trabajo:</strong></p>
                            <p>{{ $trabajador?->Hora }}</p>
                        </div>
                    @endif

                    <!-- Información de alumno -->
                    @if ($tutor->Tipo_tutor === 'Alumno')
                        <p><strong>Tipo de Tutor:</strong></p>
                        <p>{{ $tutor->Tipo_tutor }}</p>
                    @endif

                    <!-- Botón de edición -->
                    <div class="opciones editar">
                        <a class="editar" href="{{ route('tutor.editar', $tutor?->id) }}">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="separador">

            <!-- ==================== Información de Domicilio y Contacto ==================== -->
            <div class="content">
                <div class="column">
                    <!-- Encabezado del domicilio -->
                    <a href="{{ route($tutor->domicilio ? 'tutor.editar-domicilio' : 'tutor.agregar-domicilio', $tutor?->id) }}"
                        class="domicilio">
                        <i class="fa-solid fa-house"></i>
                        <span>Domicilio</span>
                        <i class="fa-solid {{ $tutor->domicilio ? 'fa-pencil' : 'fa-plus' }}"></i>
                    </a>
                    <!-- Datos del domicilio -->
                    <p><strong>Provincia:</strong></p>
                    <p>{{ $tutor->domicilio?->Provincia }}</p>
                    <p><strong>Localidad:</strong></p>
                    <p>{{ $tutor->domicilio?->Localidad }}</p>
                    <p><strong>Barrio:</strong></p>
                    <p>{{ $tutor->domicilio?->Barrio }}</p>
                    <p><strong>Calle:</strong></p>
                    <p>{{ $tutor->domicilio?->Calle }}</p>
                    <p><strong>Número:</strong></p>
                    <p>{{ $tutor->domicilio?->Numero }}</p>
                    <p><strong>Código postal:</strong></p>
                    <p>{{ $tutor->domicilio?->Codigo_postal }}</p>
                </div>
                <div class="column">
                    <!-- Encabezado de contactos -->
                    <div class="dropdown">
                        <span class="domicilio dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-address-book"></i> Contactos
                        </span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('tutor.agregar-telefono', $tutor->id) }}"><i
                                        class="fa-solid fa-phone"></i> Teléfono</a></li>
                            <li><a class="dropdown-item" href="{{ route('tutor.agregar-correo', $tutor->id) }}"><i
                                        class="fa-regular fa-envelope"></i> Correo</a></li>
                        </ul>
                    </div>

                    <p><strong><i class="fa-regular fa-envelope"></i> Correo:</strong></p>
                    @foreach ($tutor->correos as $correo)
                        <div class="contactos-item correo">
                            <p>{{ $correo?->Mail }}</p>
                            <form action="{{ route('tutor.eliminar-correo', $correo->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="eliminar btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>
                    @endforeach
                    
                    <hr class="separador">
                    <p><strong><i class="fa-solid fa-phone"></i> Teléfono:</strong></p>
                    @foreach ($tutor->telefonos as $telefono)
                        <div class="contactos-item">
                            <p>{{ $telefono?->Numero }}</p>
                            <form action="{{ route('tutor.eliminar-telefono', $telefono->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="eliminar btn-danger"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr class="separador">

            <!-- ==================== Información de Cuotas ==================== -->
            <div class="trabajador {{ $tutor->Tipo_tutor === 'Trabajador' ? 'activo' : 'oculto' }}">
                <div class="cuotas-container">

                    <a href="{{ route('tutor.agregar-cuota', $tutor->id) }}" class="cuota-boton">
                        <i class="fa-solid fa-piggy-bank"></i>
                        <span>Cuotas</span>
                        <i class="fa-solid fa-plus"></i>
                    </a>

                    <hr class="separador">
                    @if ($tutor->Tipo_tutor === 'Trabajador')
                        @if ($cuotas)
                            <div class="cuotas">
                                @foreach ($cuotas as $cuota)
                                    <div class="cuota-item">
                                        <p>${{ number_format($cuota?->Valor, 2) }}</p>
                                        <p>{{ $cuota->Fecha->translatedFormat('d F Y') }}</p>
                                        <form action="{{ route('tutor.eliminar-cuota', [$tutor->id, $cuota->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="eliminar btn-danger"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                @endforeach
                                <div class="cuota-item recaudacion-total">
                                    <p>${{ number_format($total, 2) }}</p>
                                    <strong>Recaudación total</strong>
                                </div>
                            </div>
                        @else
                            <p>No tiene cuotas registradas.</p>
                        @endif
                    @endif
                </div>
            </div>

            <!-- ==================== COSAS POR HACER ==================== -->


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


            <!-- ==================== Botón de retorno ==================== -->
            <a href="{{ route('tutor.index') }}" class="btn btn-primary">Volver</a>
        </div>
    </div>
@endsection
