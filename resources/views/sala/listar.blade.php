@vite(['resources/css/tabla.css'])
<div class="contenido-principal user">
    <!-- Tabla para la Sala 1 -->
    @if ($sala1)
        <div class="tabla-salas">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th class="d-flex justify-content-between align-items-center">
                                <!-- Edad alineada a la izquierda -->
                                <span>{{ $sala1->Edad }}</span>
                            
                                <!-- Nombre centrado -->
                                <span class="mx-auto text-center">{{ $sala1->Nombre }}</span>

                                <a href="{{ route('sala.presentacion',$sala1->id)}}">
                                    <div class="presentacion" style="width: 20px; height: 20px ">
                                        <i class="fa-solid fa-gear"></i>
                                    </div>
                                </a>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sala1->infante as $infante)
                            @php
                                $nombreCompleto = $infante->Nombre;
                                $primerNombre = explode(' ', $nombreCompleto)[0];
                                $apellidoCompleto = $infante->Apellido;
                                $primerApellido = explode(' ', $apellidoCompleto)[0];
                            @endphp
                            <tr>
                                <td class="usuario">
                                    <div>
                                        <div class="nombre">
                                            <div class="habilitado">
                                                <strong>{{ $primerApellido }} {{ $primerNombre }}</strong>
                                                @if ($infante->Habilitado == 0)
                                                    <i class="fa-solid fa-lock"></i>
                                                @else
                                                    <i class="fa-solid fa-lock-open"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="categoria">
                                            @if ($infante->Categoria == 'Ingresante')
                                                <i class="fa-solid fa-user-plus icon"></i> Ingresante
                                            @else
                                                <i class="fa-solid fa-user-check icon"></i> Readmitido
                                            @endif
                                        </div>
                                    </div>
                                    <div @if (auth()->user()->Categoria !== 'Bienestar') d-none @endif">
                                        <a href="{{ route('infante.presentacion',$infante->id)}}">
                                            <div class="presentacion">
                                                <i class="fa-solid fa-gear"></i>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">No hay infantes en esta sala.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="container paginacion">
                <ul class="pagination">

                    @if ($sala1->infante->currentPage() > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $sala1->infante->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span> Anterior
                            </a>
                        </li>
                    @endif

                    @if ($sala1->infante->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $sala1->infante->nextPageUrl() }}" aria-label="Next">
                                Siguiente <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
    @endif

    <!-- Tabla para la Sala 2 -->
    @if ($sala2)
        <div class="tabla-salas">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th class="d-flex justify-content-between align-items-center">
                                <!-- Edad alineada a la izquierda -->
                                <span>{{ $sala2->Edad }}</span>
                            
                                <!-- Nombre centrado -->
                                <span class="mx-auto text-center">{{ $sala2->Nombre }}</span>
                            
                                <a href="{{ route('sala.presentacion',$sala2->id)}}">
                                    <div class="presentacion" style="width: 20px; height: 20px ">
                                        <i class="fa-solid fa-gear"></i>
                                    </div>
                                </a>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sala2->infante as $infante)
                            @php
                                $nombreCompleto = $infante->Nombre;
                                $primerNombre = explode(' ', $nombreCompleto)[0];
                                $apellidoCompleto = $infante->Apellido;
                                $primerApellido = explode(' ', $apellidoCompleto)[0];
                            @endphp
                            <tr>
                                <td class="usuario">
                                    <div>
                                        <div class="nombre">
                                            <div class="habilitado">
                                                <strong>{{ $primerApellido }} {{ $primerNombre }}</strong>
                                                @if ($infante->Habilitado == 0)
                                                    <i class="fa-solid fa-lock"></i>
                                                @else
                                                    <i class="fa-solid fa-lock-open"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="categoria">
                                            @if ($infante->Categoria == 'Ingresante')
                                                <i class="fa-solid fa-user-plus icon"></i> Ingresante
                                            @else
                                                <i class="fa-solid fa-user-check icon"></i> Readmitido
                                            @endif
                                        </div>
                                    </div>
                                    <div @if (auth()->user()->Categoria !== 'Bienestar') d-none @endif">
                                        <a href="{{ route('infante.presentacion',$infante->id)}}">
                                            <div class="presentacion">
                                                <i class="fa-solid fa-gear"></i>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">No hay infantes en esta sala.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="container paginacion">
                <ul class="pagination">

                    @if ($sala2->infante->currentPage() > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $sala2->infante->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span> Anterior
                            </a>
                        </li>
                    @endif

                    @if ($sala2->infante->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $sala2->infante->nextPageUrl() }}" aria-label="Next">
                                Siguiente <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
    @endif

    <!-- Tabla para la Sala 3 -->
    @if ($sala3)
        <div class="tabla-salas">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th class="d-flex justify-content-between align-items-center">
                                <!-- Edad alineada a la izquierda -->
                                <span>{{ $sala3->Edad }}</span>
                            
                                <!-- Nombre centrado -->
                                <span class="mx-auto text-center">{{ $sala3->Nombre }}</span>
                            
                                <a href="{{ route('sala.presentacion',$sala3->id)}}">
                                    <div class="presentacion" style="width: 20px; height: 20px ">
                                        <i class="fa-solid fa-gear"></i>
                                    </div>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sala3->infante as $infante)
                            @php
                                $nombreCompleto = $infante->Nombre;
                                $primerNombre = explode(' ', $nombreCompleto)[0];
                                $apellidoCompleto = $infante->Apellido;
                                $primerApellido = explode(' ', $apellidoCompleto)[0];
                            @endphp
                            <tr>
                                <td class="usuario">
                                    <div>
                                        <div class="nombre">
                                            <div class="habilitado">
                                                <strong>{{ $primerApellido }} {{ $primerNombre }}</strong>
                                                @if ($infante->Habilitado == 0)
                                                    <i class="fa-solid fa-lock"></i>
                                                @else
                                                    <i class="fa-solid fa-lock-open"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="categoria">
                                            @if ($infante->Categoria == 'Ingresante')
                                                <i class="fa-solid fa-user-plus icon"></i> Ingresante
                                            @else
                                                <i class="fa-solid fa-user-check icon"></i> Readmitido
                                            @endif
                                        </div>
                                    </div>
                                    <div @if (auth()->user()->Categoria !== 'Bienestar') d-none @endif">
                                        <a href="{{ route('infante.presentacion',$infante->id)}}">
                                            <div class="presentacion">
                                                <i class="fa-solid fa-gear"></i>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">No hay infantes en esta sala.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="container paginacion">
                <ul class="pagination">

                    @if ($sala3->infante->currentPage() > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $sala3->infante->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span> Anterior
                            </a>
                        </li>
                    @endif

                    @if ($sala3->infante->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $sala3->infante->nextPageUrl() }}" aria-label="Next">
                                Siguiente <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
    @endif
</div>
