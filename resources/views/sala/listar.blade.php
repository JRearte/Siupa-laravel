@vite(['resources/css/tabla.css'])
<div class="contenido-principal user">
    <!-- Tabla para la Sala 1 -->
    @if ($sala1)
        <div class="tabla-usuarios">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th>{{ $sala1->Nombre }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sala1->infante as $infante)
                            <tr>
                                <td class="usuario">
                                    <div>
                                        <div class="nombre">
                                            <strong>{{ $infante->Nombre }} {{ $infante->Apellido }}</strong>
                                            @if ($infante->Genero == 'Masculino')
                                                <i class="fa fa-mars" style="color: rgb(0, 0, 0);"></i>
                                            @else
                                                <i class="fa fa-venus" style="color: rgb(0, 0, 0);"></i> 
                                            @endif
                                        </div>
                                        <div class="categoria">
                                            @if ($infante->Categoria == 'Ingresante')
                                                <i class="fa-solid fa-user-plus"></i> Ingresante
                                            @elseif($infante->Categoria == 'Readmitido')
                                                <i class="fa-solid fa-user-check"></i> Readmitido
                                            @else
                                                <i class="fa-solid fa-question-circle"></i> No especificado
                                            @endif
                                        </div>
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
        </div>
    @endif

    <!-- Tabla para la Sala 2 -->
    @if ($sala2)
        <div class="tabla-usuarios">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th>{{ $sala2->Nombre }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sala2->infante as $infante)
                            <tr>
                                <td class="usuario">
                                    <div>
                                        <div class="nombre">
                                            <strong>{{ $infante->Nombre }} {{ $infante->Apellido }}</strong>
                                            @if ($infante->Genero == 'Masculino')
                                                <i class="fa fa-mars" style="color: rgb(0, 0, 0);"></i>
                                            @else
                                                <i class="fa fa-venus" style="color: rgb(0, 0, 0);"></i> 
                                            @endif
                                        </div>
                                        <div class="categoria">
                                            @if ($infante->Categoria == 'Ingresante')
                                                <i class="fa-solid fa-user-plus"></i> Ingresante
                                            @elseif($infante->Categoria == 'Readmitido')
                                                <i class="fa-solid fa-user-check"></i> Readmitido
                                            @else
                                                <i class="fa-solid fa-question-circle"></i> No especificado
                                            @endif
                                        </div>
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
        </div>
    @endif

    <!-- Tabla para la Sala 3 -->
    @if ($sala3)
        <div class="tabla-usuarios">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th>{{ $sala3->Nombre }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sala3->infante as $infante)
                            <tr>
                                <td class="usuario">
                                    <div>
                                        <div class="nombre">
                                            <strong>{{ $infante->Nombre }} {{ $infante->Apellido }}</strong>
                                            @if ($infante->Genero == 'Masculino')
                                                <i class="fa fa-mars" style="color: rgb(0, 0, 0);"></i>
                                            @else
                                                <i class="fa fa-venus" style="color: rgb(0, 0, 0);"></i> 
                                            @endif
                                        </div>
                                        <div class="categoria">
                                            @if ($infante->Categoria == 'Ingresante')
                                                <i class="fa-solid fa-user-plus"></i> Ingresante
                                            @elseif($infante->Categoria == 'Readmitido')
                                                <i class="fa-solid fa-user-check"></i> Readmitido
                                            @else
                                                <i class="fa-solid fa-question-circle"></i> No especificado
                                            @endif
                                        </div>
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
        </div>
    @endif
</div>
