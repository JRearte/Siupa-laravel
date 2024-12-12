@vite(['resources/css/sidebar.css']) 
<aside class="sidebar d-flex flex-column">
    
    <!-- Sección del Usuario -->
    <div class="user-section text-center mb-4">
        <div class="card p-2">
            <div class="d-flex align-items-start">
                <!-- Contenedor del Icono de Usuario -->
                <div class="user-icon">
                    <i class="fa-regular fa-user"></i>
                </div>

                <!-- Contenedor del Nombre de Usuario y Elemento Adicional -->
                <div class="user-info ml-2 d-flex flex-column justify-content-between">
                    <!-- Nombre del Usuario -->
                    <div class="user-name">
                        @if (Auth::check())
                            @php
                                $nombreCompleto = Auth::user()->Nombre;
                                $primerNombre = explode(' ', $nombreCompleto)[0]; // Toma el primer nombre
                                $apellidoCompleto = Auth::user()->Apellido;
                                $primerApellido = explode(' ', $apellidoCompleto)[0]; // Toma el primer nombre
                            @endphp
                            <p class="mb-0">{{ $primerNombre }} {{ $primerApellido }}</p> 
                        @else
                            <p class="mb-0">No estás autenticado</p> 
                        @endif
                    </div>

                    <!-- Elemento Adicional -->
                    <div class="user-extra">
                        <p class="mb-0 text-muted">{{ Auth::user()->Categoria }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Listado de Enlaces -->
    <ul class="nav flex-column mb-auto">
        <li class="nav-item mb-2">
            <a href="{{ route('usuario.index') }}" class="nav-link">
                <i class="fas fa-user icon"></i>
                <p class="nav-text">Usuario</p>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('sala.listar') }}" class="nav-link">
                <i class="fas fa-home icon"></i>
                <p class="nav-text">Sala</p>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('sala.listar') }}" class="nav-link">
                <i class="fas fa-user-tie icon"></i>
                <p class="nav-text">Tutor</p>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('sala.listar') }}" class="nav-link">
                <i class="fas fa-child icon"></i>
                <p class="nav-text">Infante</p>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('sala.listar') }}" class="nav-link">
                <i class="fas fa-clock icon"></i>
                <p class="nav-text">Asistencia</p>
            </a>
        </li>
    </ul>


    <!-- Cerrar Sesión -->
    <div class="mt-auto">
        <a href="{{ route('usuario.logout') }}" class="btn btn-danger">
            <i class="logout-icon fa-solid fa-door-open"></i>
            <i class="cerrar-icon fa-solid fa-door-closed"></i>
            <span class="btn-text">Cerrar Sesión</span>
        </a>
        <form id="logout-form" action="{{ route('usuario.logout') }}" method="post" style="display: none;">
            @csrf
        </form>
    </div>
</aside>
