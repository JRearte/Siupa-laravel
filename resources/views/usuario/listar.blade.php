@vite(['resources/css/tabla.css'])
<div class="user">
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
                        $primerNombre = explode(' ', $nombreCompleto)[0];
                        $apellidoCompleto = $usuario->Apellido;
                        $primerApellido = explode(' ', $apellidoCompleto)[0];
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
                                        <i class="fa-solid fa-crown icon"></i> Bienestar
                                    @elseif($usuario->Categoria == 'Coordinador')
                                        <i class="fa-solid fa-user-tie icon"></i> Coordinador
                                    @elseif($usuario->Categoria == 'Maestro')
                                        <i class="fa-solid fa-chalkboard-teacher icon"></i> Maestro
                                    @else
                                        <i class="fa-solid fa-user icon"></i> Invitado
                                    @endif
                                </div>
                            </div>

                            <!-- Botón de presentacion -->
                            <div @if (auth()->user()->Categoria !== 'Bienestar') d-none @endif">
                                <a href="{{ route('usuario.presentacion', $usuario->id) }}">
                                    <div class="presentacion">
                                        <i class="fa-solid fa-gear"></i>
                                    </div>
                                </a>
                            </div>
                            
                        </td>
                    </tr>
                @endforeach
                @if ($usuarios->isEmpty())
                    <tr>
                        <td colspan="2" class="text-center">No hay usuarios.</td>
                    </tr>
                @endif
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
</div>
