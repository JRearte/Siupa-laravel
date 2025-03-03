@extends('layouts.principal')
@section('title', 'Gestor de tutores')
@section('content')
    <div class="contenedor-principal">

        <div class="cabecera">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Título -->
                <h6 class="titulo mb-0">{{ __('Gestión de Tutores') }}</h6>

                <!-- Formulario del buscador -->
                <form method="GET" action="{{ route('tutor.index') }}" class="d-flex me-3">
                    <input type="text" name="buscar" class="form-control form-control-sm buscador-input"
                        placeholder="Buscar tutores" value="{{ request('buscar') }}" autocomplete="off" />
                    <button type="submit" class="btn btn-dark btn-sm ms-2 buscador-btn">
                        <i class="fas fa-search"></i> <span>{{ __('Buscar') }}</span>
                    </button>
                </form>

                <div class="acciones d-flex  @if (auth()->user()->Categoria !== 'Bienestar') d-none @endif">
                    <a href="{{ route('tutor.agregar') }}" class="btn btn-dark ms-2">
                        <i class="fas fa-user-plus"></i> <span>{{ __('Agregar') }}</span>
                    </a>
                </div>


                
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('tutor.agregar') }}">
                                <i class="fas fa-user-plus"></i> Agregar
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" >
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


        <div class="contenido-principal">
            @include('tutor.listar', ['trabajadores' => $trabajadores, 'alumnos' => $alumnos, 'birthday' => $birthday])

        </div>

    </div>
@endsection
