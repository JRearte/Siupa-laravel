@extends('layouts.principal')
@section('title', 'Gestor de usuarios')
@section('content')
    <div class="contenedor-principal">

        <!-- Cabecera principal -->
        <div class="cabecera">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Título -->
                <h6 class="titulo mb-0">{{ __('Gestión de Usuarios') }}</h6>

                <!-- Formulario del buscador -->
                <form method="GET" action="{{ route('usuario.index') }}" class="d-flex me-3">
                    <input type="text" name="buscar" class="form-control form-control-sm buscador-input"
                        placeholder="Buscar usuarios" value="{{ request('buscar') }}" autocomplete="off" />
                    <button type="submit" class="btn btn-dark btn-sm ms-2 buscador-btn">
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
                </div>

                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li class="{{ auth()->user()->Categoria !== 'Bienestar' ? 'd-none' : '' }}">
                            <a class="dropdown-item" href="{{ route('usuario.agregar') }}">
                                <i class="fas fa-user-plus"></i> Agregar
                            </a>
                        </li>
                        <li class="{{ auth()->user()->Categoria !== 'Bienestar' ? 'd-none' : '' }}">
                            <a class="dropdown-item" href="{{ route('usuario.reporte') }}">
                                <i class="fa-solid fa-file-lines"></i> Reporte
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('usuario.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-door-closed"></i> Cerrar Sesión
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('usuario.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </ul>
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
