@vite(['resources/css/estadistica.css'])
@vite(['resources/js/grafico.js'])

<div class="estadisticas-container">
    <!-- Contenedor 1 -->
    <div class="estadistica" data-id="chartBienestar" data-porcentaje="{{ $porcentajeBienestar }}">
        <div class="grafico-contenedor">
            <canvas id="chartBienestar" class="grafico"></canvas>
            <div class="cantidad-adentro">
                <span class="cantidad">{{ $usuariosBienestar }} / {{ $totalUsuarios }}</span>
            </div>
        </div>
        <div class="icono-adentro">
            <i class="fa-solid fa-crown"></i>
        </div>
        <div class="contenido">
            <div class="titulo-porcentaje">
                <h3>Bienestar</h3>
                <span class="porcentaje">{{ number_format($porcentajeBienestar, 2) }}%</span>
            </div>
        </div>
    </div>

    <!-- Contenedor 2 -->
    <div class="estadistica" data-id="chartCoordinador" data-porcentaje="{{ $porcentajeCoordinador }}">
        <div class="grafico-contenedor">
            <canvas id="chartCoordinador" class="grafico"></canvas>
            <div class="cantidad-adentro">
                <span class="cantidad">{{ $usuariosCoordinador }} / {{ $totalUsuarios }}</span>
            </div>
        </div>
        <div class="icono-adentro">
            <i class="fa-solid fa-user-tie"></i>
        </div>
        <div class="contenido">
            <div class="titulo-porcentaje">
                <h3>Coordinador</h3>
                <span class="porcentaje">{{ number_format($porcentajeCoordinador, 2) }}%</span>
            </div>
        </div>
    </div>

    <!-- Contenedor 3 -->
    <div class="estadistica" data-id="chartMaestro" data-porcentaje="{{ $porcentajeMaestro }}">
        <div class="grafico-contenedor">
            <canvas id="chartMaestro" class="grafico"></canvas>
            <div class="cantidad-adentro">
                <span class="cantidad">{{ $usuariosMaestro }} / {{ $totalUsuarios }}</span>
            </div>
        </div>
        <div class="icono-adentro">
            <i class="fa-solid fa-chalkboard-teacher"></i>
        </div>
        <div class="contenido">
            <div class="titulo-porcentaje">
                <h3>Maestro</h3>
                <span class="porcentaje">{{ number_format($porcentajeMaestro, 2) }}%</span>
            </div>
        </div>
    </div>

    <!-- Contenedor 4 -->
    <div class="estadistica" data-id="chartInvitado" data-porcentaje="{{ $porcentajeInvitado }}">
        <div class="grafico-contenedor">
            <canvas id="chartInvitado" class="grafico"></canvas>
            <div class="cantidad-adentro">
                <span class="cantidad">{{ $usuariosInvitado }} / {{ $totalUsuarios }}</span>
            </div>
        </div>
        <div class="icono-adentro">
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="contenido">
            <div class="titulo-porcentaje">
                <h3>Invitado</h3>
                <span class="porcentaje">{{ number_format($porcentajeInvitado, 2) }}%</span>
            </div>
        </div>
    </div>
</div>