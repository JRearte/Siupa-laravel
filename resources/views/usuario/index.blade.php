@extends('layouts.principal')
@section('title', 'Gestor de usuarios')
@section('content')
    <div class="contenedor-principal">
        <!-- Alertas -->
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <!-- Toast de éxito -->
            @if (session('success'))
                <div id="toastSuccess" class="toast toast-success align-items-center text-bg-success border-0 show"
                    role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <i class="fa-solid fa-circle-check icon"></i> <!-- Icono de éxito -->
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <!-- Barra de progreso -->
                        <div class="progress-bar">
                            <div class="progress-bar-fill"></div>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
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
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Cabecera principal -->
        <div class="cabecera">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Título -->
                <h6 class="titulo mb-0">{{ __('Gestión de Usuarios') }}</h6>

                <!-- Formulario del buscador -->
                <form method="GET" action="{{ route('usuario.index') }}" class="d-flex me-3">
                    <input type="text" name="buscar" class="form-control form-control-sm buscador-input"
                        placeholder="Buscar usuarios" value="{{ request('buscar') }}" />
                    <button type="submit" class="btn btn-secondary btn-sm ms-2 buscador-btn">
                        <i class="fas fa-search"></i> <span>{{ __('Buscar') }}</span>
                    </button>
                </form>

                <!-- Botones de acciones -->
                <div class="acciones d-flex">
                    <a href="{{ route('usuario.agregar') }}" class="btn btn-dark ms-2">
                        <i class="fas fa-user-plus"></i> <span>{{ __('Agregar') }}</span>
                    </a>
                    <a href="{{ route('usuario.reporte') }}" class="btn btn-dark ms-2">
                        <i class="fa-solid fa-file-lines"></i> <span>{{ __('Reporte') }}</span>
                    </a>

                    <!-- Cerrar Sesión -->
                    <a href="{{ route('usuario.logout') }}" class="btn btn-danger ms-2">
                        <i class="cerrar-icon fa-solid fa-door-closed"></i>
                    </a>
                    <form id="logout-form" action="{{ route('usuario.logout') }}" method="post" style="display: none;">
                        @csrf
                    </form>
                </div>

            </div>
        </div>

        <!-- Contenedor de datos principales -->
        <div class="contenido-principal">
            <!-- Listado de usuarios -->
            <div class="tabla-usuarios">
                @include('usuario.listar', ['usuarios' => $usuarios])
            </div>

            <!-- Historial de usuarios -->
            <div class="historial-usuarios">
                @include('usuario.historial', ['historial' => $historial])
            </div>

            <!-- Sección de estadísticas -->
            <div class="estadisticas-usuarios">
                @include('usuario.estadistica', [
                    'totalUsuarios' => $totalUsuarios,
                    'usuariosBienestar' => $usuariosBienestar,
                    'usuariosCoordinador' => $usuariosCoordinador,
                    'usuariosMaestro' => $usuariosMaestro,
                    'usuariosInvitado' => $usuariosInvitado,
                    'porcentajeBienestar' => $porcentajeBienestar,
                    'porcentajeCoordinador' => $porcentajeCoordinador,
                    'porcentajeMaestro' => $porcentajeMaestro,
                    'porcentajeInvitado' => $porcentajeInvitado,
                ])
            </div>
        </div>
    </div>

@endsection
