@extends('layouts.principal')
@section('title', 'Carta de Infante')
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
                <!-- Opción de eliminar -->
                <div class="opciones">
                    @include('infante.advertencia', ['infante' => $infante])
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
                    <p><strong>Edad:</strong></p>
                    <p>{{ $edad }}</p>


                </div>
                <div class="column">
                    <p><strong>Documento:</strong></p>
                    <p>{{ $infante->Tipo_documento }}: {{ $infante->Numero_documento }}</p>
                    <p><strong>Categoria:</strong></p>
                    <p>{{ $infante->Categoria }}</p>
                    <p><strong>Fecha de asignacion:</strong></p>
                    <p>{{ $infante->Fecha_de_asignacion->translatedFormat('d F Y') }}</p>
                    <p><strong>Estado:</strong></p>
                    <p>{{ $infante->Habilitado ? 'Habilitado' : 'Deshabilitado' }}</p>

                    <!-- Botón de edición -->
                    <div class="opciones editar">
                        <a class="editar" href="{{ route('infante.editar', $infante->id) }}">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="separador">

            <div class="infantes-container">
                <div class="infante-card">
                    <div class="infante-info">
                        <p class="infante-nombre">
                            <i class="fa-solid {{ $infante->tutor->Genero === 'Masculino' ? 'fa-child' : 'fa-child-dress' }}"></i>
                            {{ $infante->tutor->Nombre }} {{ $infante->tutor->Apellido }}
                        </p>
                        <p class="infante-sala">
                            @if ($infante->tutor->Tipo_tutor == 'Trabajador')
                                <i class="fa-solid fa-briefcase"></i>
                            @else
                                <i class="fa-solid fa-graduation-cap"></i>
                            @endif
                            {{ $infante->tutor->Tipo_tutor }}
                        </p>
                    </div>

                    <a href="{{ route('tutor.presentacion', $infante->tutor_id) }}" class="infante-opciones">
                        <i class="fa-solid fa-gear"></i>
                    </a>
                </div>
            </div>
            <hr class="separador">

            <!-- ==================== Familiares ==================== -->
            <div class="datos-academicos t-familiar">
                <a href="{{ $infante->Habilitado != 0 ? route('infante.agregar-familiar', $infante->id) : '#' }}"
                    class="cuota-boton {{ $infante->Habilitado == 0 ? 'disabled' : '' }}"
                    {{ $infante->Habilitado == 0 ? 'aria-disabled=true' : '' }}>
                    <i class="fa-solid fa-users"></i>
                    <span>Familiares</span>
                    <i class="fa-solid fa-plus"></i>
                </a>
                <hr class="separador">

                <div x-data="{ abierto: null }">
                    @foreach ($infante->familiares as $familiar)
                        <div class="asignatura">
                            <div class="contenido">
                                <button class="familiar-vinculo"
                                    @click="abierto === {{ $familiar->id }} ? abierto = null : abierto = {{ $familiar->id }}">
                                    <i class="fa-solid fa-user"></i> {{ $familiar->Vinculo }}
                                    <i class="fa-solid"
                                        :class="abierto === {{ $familiar->id }} ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>

                                <div x-show="abierto === {{ $familiar->id }}" class="familiar-detalles" x-cloak>
                                    <div><strong>Nombre: </strong>{{ $familiar->Nombre }} {{ $familiar->Apellido }}</div>
                                    <div><strong>{{ $familiar->Tipo_documento }}: </strong>
                                        {{ $familiar->Numero_documento }}</div>
                                    <div><strong>Edad: </strong>{{ $familiar->edad }}</div>
                                    <div><strong>Trabajo: </strong>{{ $familiar?->Lugar_de_trabajo ?? 'No especificado' }}
                                    </div>
                                    <div><strong>Ingreso:
                                        </strong>${{ number_format($familiar?->Ingreso, 2) ?? 'No especificado' }}</div>
                                </div>
                            </div>

                            @if ($infante->Habilitado != 0)
                                <div x-show="abierto === {{ $familiar->id }}" x-cloak class="acciones">
                                    <a class="editar" href="{{ route('infante.editar-familiar', $familiar->id) }}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <hr class="separador">
                                    <div class="eliminar-wrapper">
                                        <button class="eliminar btn-danger" onclick="toggleDropdown(this)">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <div class="dropdown-eliminar">
                                            <p class="mensaje-eliminar">¿Eliminar familiar?</p>
                                            <div class="botones">
                                                <form action="{{ route('infante.eliminar-familiar', $familiar->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="confirmar">Eliminar</button>
                                                </form>
                                                <button class="cancelar" onclick="toggleDropdown(this)">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>



            <hr class="separador">
            <!-- ==================== Datos Médicos ==================== -->
            <div class="cuotas-container">
                <a href="{{ $infante->Habilitado != 0 ? route('infante.agregar-medico', $infante->id) : '#' }}"
                    class="cuota-boton {{ $infante->Habilitado == 0 ? 'disabled' : '' }}"
                    {{ $infante->Habilitado == 0 ? 'aria-disabled=true' : '' }}>
                    <i class="fa-solid fa-kit-medical"></i>
                    <span>Datos Médicos</span>
                    <i class="fa-solid fa-plus"></i>
                </a>

                <hr class="separador">

                @if ($infante->medicos->isNotEmpty())
                    <div class="cuotas">
                        @foreach ($infante->medicos as $medico)
                            <div class="cuota-item datos-medicos-item">
                                <div class="datos-medicos-info">
                                    <i
                                        class="fa-solid {{ $medico->Tipo == 'Vacuna' ? 'fa-syringe' : ($medico->Tipo == 'Alergia' ? 'fa-allergies' : 'fa-wheelchair') }}"></i>

                                    <p class="tipo">{{ $medico->Tipo }}: </p>
                                    <p class="detalle">{{ $medico->Nombre }}</p>
                                </div>

                                <!-- Botón alineado a la derecha -->
                                @if ($infante->Habilitado != 0)
                                    <div class="eliminar-wrapper">
                                        <button class="eliminar btn-danger" onclick="toggleDropdown(this)">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>

                                        <div class="dropdown-eliminar">
                                            <p class="mensaje-eliminar">¿Eliminar dato médico?</p>
                                            <div class="botones">
                                                <form action="{{ route('infante.eliminar-medico', [$medico->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="confirmar">Eliminar</button>
                                                </form>
                                                <button class="cancelar" onclick="toggleDropdown(this)">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No tiene datos médicos registrados.</p>
                @endif
            </div>


            <!-- ==================== Botón de retorno ==================== -->
            <a href="{{ route('sala.index') }}" class="btn btn-primary">Volver</a>
        </div>
    </div>
@endsection
