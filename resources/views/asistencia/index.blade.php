@extends('layouts.principal')
@section('title', 'Gestor de asistencias')
@section('content')
    <div class="contenedor-principal">

        <!-- Cabecera principal -->
        <div class="cabecera">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Título -->
                <h6 class="titulo mb-0">{{ __('Gestión de Asistencias') }}</h6>

                <!-- Formulario del buscador -->
                <form method="GET" action="{{ route('asistencia.index') }}" class="d-flex me-3">
                    <input type="text" name="buscar" class="form-control form-control-sm buscador-input"
                        placeholder="Buscar infante" value="{{ request('buscar') }}" autocomplete="off" />
                    <button type="submit" class="btn btn-dark btn-sm ms-2 buscador-btn">
                        <i class="fas fa-search"></i> <span>{{ __('Buscar') }}</span>
                    </button>
                </form>
                

                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu">
                                    
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
            @include('asistencia.listar', ['sala1' => $sala1, 'sala2' => $sala2, 'sala3' => $sala3])


        </div>

    </div>
@endsection