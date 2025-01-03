<div class="estadisticas-container">
    <!-- Contenedor 1 -->
    <div class="estadistica">
        <div class="icono-fondo">
            <i class="fa-solid fa-crown"></i>
        </div>
        <div class="contenido">
            <h3>Bienestar</h3>
            <div class="info">
                <span>{{ $usuariosBienestar }} / {{ $totalUsuarios }} usuarios</span>
                <span class="porcentaje">{{ number_format($porcentajeBienestar, 2) }}%</span>
            </div>
        </div>
    </div>

    <!-- Contenedor 2 -->
    <div class="estadistica">
        <div class="icono-fondo">
            <i class="fa-solid fa-user-tie"></i>
        </div>
        <div class="contenido">
            <h3>Coordinador</h3>
            <div class="info">
                <span>{{ $usuariosCoordinador }} / {{ $totalUsuarios }} usuarios</span>
                <span class="porcentaje">{{ number_format($porcentajeCoordinador, 2) }}%</span>
            </div>
        </div>
    </div>

    <!-- Contenedor 3 -->
    <div class="estadistica">
        <div class="icono-fondo">
            <i class="fa-solid fa-chalkboard-teacher"></i>
        </div>
        <div class="contenido">
            <h3>Maestro</h3>
            <div class="info">
                <span>{{ $usuariosMaestro }} / {{ $totalUsuarios }} usuarios</span>
                <span class="porcentaje">{{ number_format($porcentajeMaestro, 2) }}%</span>
            </div>
        </div>
    </div>

    <!-- Contenedor 4 -->
    <div class="estadistica">
        <div class="icono-fondo">
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="contenido">
            <h3>Invitado</h3>
            <div class="info">
                <span>{{ $usuariosInvitado }} / {{ $totalUsuarios }} usuarios</span>
                <span class="porcentaje">{{ number_format($porcentajeInvitado, 2) }}%</span>
            </div>
        </div>
    </div>
</div>

