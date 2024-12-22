<div class="table-container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-movida">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Gestor de usuarios') }}
                        </span>
                        <div class="float-right">
                            <a href="{{ route('usuario.agregar') }}" class="btn btn-dark btn-sm float-right mr-2"
                                data-placement="left">
                                <i class="fas fa-user-plus"></i> <!-- Icono de agregar -->
                                {{ __('Agregar') }}
                            </a>
                            <a href="{{ route('usuario.reporte') }}" class="btn btn-dark btn-sm float-right mr-2"
                                data-placement="left">
                                <i class="fa-solid fa-file-lines"></i> <!-- Icono de reporte -->
                                {{ __('Reporte') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="toast-container position-fixed top-0 end-0 p-3">
                    <!-- Toast de éxito -->
                    @if (session('success'))
                        <div id="toastSuccess"
                            class="toast toast-success align-items-center text-bg-success border-0 show" role="alert"
                            aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <i class="fa-solid fa-circle-check icon"></i> <!-- Icono de éxito -->
                                <div class="toast-body">
                                    {{ session('success') }}
                                </div>
                                <!-- Barra de progreso -->
                                <div class="progress-bar">
                                    <div class="progress-bar-fill"></div>
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                    data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <!-- Toast de error -->
                    @if (session('error'))
                        <div id="toastError" class="toast toast-error align-items-center text-bg-danger border-0 show"
                            role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <i class="fa-solid fa-circle-exclamation icon"></i> <!-- Icono de error -->
                                <div class="toast-body">
                                    {{ session('error') }}
                                </div>
                                <!-- Barra de progreso -->
                                <div class="progress-bar">
                                    <div class="progress-bar-fill"></div>
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                    data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                </div>



                <!-- Cuerpo de la tabla de usuario -->
                <div class="card-body">
                    <div id="table-container" class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th class="col-n">#</th>
                                    <th class="col-legajo">Legajo</th>
                                    <th class="col-nombre">Usuario</th>
                                    <th class="col-categoria">Categoría</th>
                                    <th class="col-opcion">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td class="col-n">{{ ++$i }}</td>
                                        <td class="col-legajo">{{ $usuario->Legajo }}</td>
                                        @php
                                            $nombreCompleto = $usuario->Nombre;
                                            $primerNombre = explode(' ', $nombreCompleto)[0]; // Toma el primer nombre
                                            $apellidoCompleto = $usuario->Apellido;
                                            $primerApellido = explode(' ', $apellidoCompleto)[0]; // Toma el primer apellido
                                        @endphp
                                        <td class="col-nombre">
                                            @if ($usuario->Habilitado == 1)
                                                <i class="fa-regular fa-circle-check" style="color: #00b415;"></i>
                                            @else
                                                <i class="fa-solid fa-ban" style="color: #fa0000;"></i>
                                            @endif
                                            {{ $primerApellido }} {{ $primerNombre }}
                                        </td>
                                        <td class="col-categoria">{{ $usuario->Categoria }}</td>

                                        <td class="col-opcion">
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('usuario.presentacion', $usuario->id) }}">
                                                <i class="fas fa-user"></i>
                                            </a>
                                            <a class="btn btn-sm btn-success"
                                                href="{{ route('usuario.editar', $usuario->id) }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <a class="btn btn-sm btn-danger"
                                                href="{{ route('usuario.confirmar', $usuario->id) }}">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Paginación de usuarios -->
            <div class="container">
                {!! $usuarios->links('vendor.pagination.bootstrap-4') !!}
            </div>
        </div>
    </div>
</div>
