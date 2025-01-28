@vite(['resources/css/tabla.css'])
<div class="contenido-principal user">
    <!-- Tabla para trabajadores -->
    @if ($trabajadores->count() > 0)
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
                        @foreach ($trabajadores as $trabajador)
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
                                                <div>
                                                    @if ($infante->Genero == 'Masculino')
                                                        <i class="fa-solid fa-mars icon"></i> {{ $infante->Nombre }}
                                                        {{ $infante->Apellido }}
                                                    @else
                                                        <i class="fa-solid fa-venus icon"></i> {{ $infante->Nombre }}
                                                        {{ $infante->Apellido }}
                                                    @endif
                                                </div>
                                                |
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Botón de opciones -->
                                    <div class="opt">
                                        <div class="dropdown @if (auth()->user()->Categoria !== 'Bienestar') d-none @endif">
                                            <button class="btn btn-sm btn-secondary dropbtn">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-content">
                                                <a class="dropdown-item" href="{{ route('tutor.presentacion', $trabajador->id) }}">
                                                    <i class="fas fa-user icon"></i> Presentación
                                                </a>
                                                <a class="dropdown-item">
                                                    <i class="fa-solid fa-pencil icon"></i> Editar
                                                </a>
                                                <a class="dropdown-item">
                                                    <i class="fa fa-fw fa-trash icon"></i> Eliminar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($trabajadores->isEmpty())
                            <tr>
                                <td colspan="2" class="text-center">No hay trabajadores.</td>
                            </tr>
                        @endif
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
    @if ($alumnos->count() > 0)
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
                        @foreach ($alumnos as $alumno)
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
                                                <div>
                                                    @if ($infante->Genero == 'Masculino')
                                                        <i class="fa-solid fa-mars icon"></i> {{ $infante->Nombre }}
                                                        {{ $infante->Apellido }}
                                                    @else
                                                        <i class="fa-solid fa-venus icon"></i> {{ $infante->Nombre }}
                                                        {{ $infante->Apellido }}
                                                    @endif
                                                </div>
                                                |
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <!-- Botón de opciones -->
                                    <div class="opt">
                                        <div class="dropdown @if (auth()->user()->Categoria !== 'Bienestar') d-none @endif">
                                            <button class="btn btn-sm btn-secondary dropbtn">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-content">
                                                <a class="dropdown-item" href="{{ route('tutor.presentacion', $alumno->id) }}">
                                                    <i class="fas fa-user icon"></i> Presentación
                                                </a>
                                                <a class="dropdown-item">
                                                    <i class="fa-solid fa-pencil icon"></i> Editar
                                                </a>
                                                <a class="dropdown-item">
                                                    <i class="fa fa-fw fa-trash icon"></i> Eliminar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($alumnos->isEmpty())
                            <tr>
                                <td colspan="2" class="text-center">No hay alumnos.</td>
                            </tr>
                        @endif
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

</div>
