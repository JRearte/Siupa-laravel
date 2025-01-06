@vite(['resources/css/tabla.css'])
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="thead">
            <tr>
                <th>Usuarios</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                @php
                    $nombreCompleto = $usuario->Nombre;
                    $primerNombre = explode(' ', $nombreCompleto)[0]; // Toma el primer nombre
                    $apellidoCompleto = $usuario->Apellido;
                    $primerApellido = explode(' ', $apellidoCompleto)[0]; // Toma el primer apellido
                @endphp
                <tr>
                    <td class="usuario">
                        <!-- Información del usuario -->
                        <div>
                            <div class="nombre">
                                <div class="habilitado">
                                    <strong>{{ $primerApellido }} {{ $primerNombre }}</strong>
                                    @if ($usuario->Habilitado == 0)
                                        <i class="fa-solid fa-lock"></i>
                                    @else
                                        <i class="fa-solid fa-lock-open"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="categoria">
                                @if ($usuario->Categoria == 'Bienestar')
                                    <i class="fa-solid fa-crown" style="color: rgb(0, 0, 0);"></i> Bienestar
                                @elseif($usuario->Categoria == 'Coordinador')
                                    <i class="fa-solid fa-user-tie" style="color: #000000;"></i> Coordinador
                                @elseif($usuario->Categoria == 'Maestro')
                                    <i class="fa-solid fa-chalkboard-teacher" style="color: #000000;"></i> Maestro
                                @else
                                    <i class="fa-solid fa-user" style="color: #000000;"></i> Invitado
                                @endif
                            </div>
                        </div>

                        <!-- Botón de opciones -->
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropbtn">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-content">
                                <a class="dropdown-item" href="{{ route('usuario.presentacion', $usuario->id) }}">
                                    <i class="fas fa-user icon"></i> Presentación
                                </a>
                                <a class="dropdown-item" href="{{ route('usuario.editar', $usuario->id) }}">
                                    <i class="fa-solid fa-pencil icon"></i> Editar
                                </a>
                                <a class="dropdown-item" href="{{ route('usuario.confirmar', $usuario->id) }}">
                                    <i class="fa fa-fw fa-trash icon"></i> Eliminar
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="container paginacion">
    <ul class="pagination">
        @if ($usuarios->currentPage() > 1)
            <li class="page-item">
                <a class="page-link" href="{{ $usuarios->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span> Anterior
                </a>
            </li>
        @endif

        @if ($usuarios->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $usuarios->nextPageUrl() }}" aria-label="Next">
                    Siguiente <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        @endif
    </ul>
</div>
