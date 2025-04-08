@vite(['resources/css/tabla.css'])
<div class="contenido-principal user tutor">
    <!-- Tabla para trabajadores -->
    @if ($trabajadores)
        <div class="tabla-salas">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th class="d-flex justify-content-between align-items-center">
                                <!-- Nombre centrado -->
                                <span class="mx-auto text-center">Trabajadores</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trabajadores as $trabajador)
                            @php
                                $nombreCompleto = $trabajador->Nombre;
                                $primerNombre = explode(' ', $nombreCompleto)[0];
                                $apellidoCompleto = $trabajador->Apellido;
                                $primerApellido = explode(' ', $apellidoCompleto)[0];
                            @endphp
                            <tr>
                                <td class="usuario">
                                    <div>
                                        <div class="nombre">
                                            <div class="habilitado">
                                                <strong>{{ $primerApellido }} {{ $primerNombre }}</strong>
                                                @if ($trabajador->Habilitado == 0)
                                                    <i class="fa-solid fa-lock"></i>
                                                @else
                                                    <i class="fa-solid fa-lock-open"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="categoria">
                                            @foreach ($trabajador->infantes as $infante)
                                                @php
                                                    $nombreCompleto = $infante->Nombre;
                                                    $primerNombre = explode(' ', $nombreCompleto)[0];
                                                    $apellidoCompleto = $infante->Apellido;
                                                    $primerApellido = explode(' ', $apellidoCompleto)[0];
                                                @endphp
                                                <div>
                                                    {{ $primerNombre }} {{ $primerApellido}}
                                                </div>
                                                |
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Botón de opciones -->
                                    <div>
                                        <a href="{{ route('tutor.presentacion', $trabajador->id) }}">
                                            <div class="presentacion">
                                                <i class="fa-solid fa-gear"></i>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">No hay trabajadores.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="container paginacion">
                <ul class="pagination">
                    @if ($trabajadores->currentPage() > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $trabajadores->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span> Anterior
                            </a>
                        </li>
                    @endif

                    @if ($trabajadores->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $trabajadores->nextPageUrl() }}" aria-label="Next">
                                Siguiente <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    @endif




    <!-- Tabla para alumnos -->
    @if ($alumnos)
        <div class="tabla-salas">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th class="d-flex justify-content-between align-items-center">
                                <!-- Nombre centrado -->
                                <span class="mx-auto text-center">Alumnos</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alumnos as $alumno)
                            @php
                                $nombreCompleto = $alumno->Nombre;
                                $primerNombre = explode(' ', $nombreCompleto)[0];
                                $apellidoCompleto = $alumno->Apellido;
                                $primerApellido = explode(' ', $apellidoCompleto)[0];
                            @endphp
                            <tr>
                                <td class="usuario">
                                    <div>
                                        <div class="nombre">
                                            <div class="habilitado">
                                                <strong>{{ $primerApellido }} {{ $primerNombre }}</strong>
                                                @if ($alumno->Habilitado == 0)
                                                    <i class="fa-solid fa-lock"></i>
                                                @else
                                                    <i class="fa-solid fa-lock-open"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="categoria">
                                            @foreach ($alumno->infantes as $infante)
                                                @php
                                                    $nombreCompleto = $infante->Nombre;
                                                    $primerNombre = explode(' ', $nombreCompleto)[0];
                                                    $apellidoCompleto = $infante->Apellido;
                                                    $primerApellido = explode(' ', $apellidoCompleto)[0];
                                                @endphp
                                                <div>
                                                    {{ $primerNombre }} {{ $primerApellido}}
                                                </div>
                                                |
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Botón de opciones -->
                                    <div>
                                        <a href="{{ route('tutor.presentacion', $alumno->id) }}">
                                            <div class="presentacion">
                                                <i class="fa-solid fa-gear"></i>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">No hay alumnos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="container paginacion">
                <ul class="pagination">
                    @if ($alumnos->currentPage() > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $alumnos->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span> Anterior
                            </a>
                        </li>
                    @endif

                    @if ($alumnos->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $alumnos->nextPageUrl() }}" aria-label="Next">
                                Siguiente <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    @endif


    @if ($birthday)
        <div class="tabla-salas">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th class="d-flex justify-content-between align-items-center">
                                <span class="mx-auto text-center">Próximos Cumpleaños</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($birthday as $infante)
                            @php
                                $esHoy = now()->isSameDay($infante->fechaCumple);
                            @endphp
                            <tr class="{{ $esHoy ? 'cumple-hoy' : '' }}">
                                <td class="usuario year">
                                    <div>
                                        <div class="nombre">
                                            <div class="habilitado">
                                                @php
                                                    $apellido = explode(' ', $infante->Apellido)[0];
                                                    $nombre = explode(' ', $infante->Nombre)[0];
                                                @endphp
                                                <strong>{{ $apellido }} {{ $nombre }}</strong>
                                                <i class="fa-solid fa-birthday-cake"></i>
                                            </div>
                                        </div>
                                        <div class="birthday">
                                            {{ ucfirst($infante->fechaCumple->translatedFormat('d F')) }}
                                            @if ($esHoy)
                                                <span class="aviso-cumple"><i
                                                        class="fa-solid fa-birthday-cake pastel"></i> ¡Hoy es su
                                                    cumpleaños! <i class="fa-solid fa-gift pastel"></i></span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">No hay cumpleaños próximos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif



</div>
