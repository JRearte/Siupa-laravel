<!-- resources/views/usuario/estadistica.blade.php -->
<div class="estadisticas-container">
    <div class="row text-center">
        <div class="col-sm-12">
            <h3>Total de usuarios: {{ $totalUsuarios }}</h3>
        </div>
    </div>

    <!-- Porcentaje de usuarios en cada categoría -->
    <div class="row text-center mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card card-category">
                <div class="card-body">
                    <h5 class="card-title">Bienestar</h5>
                    <p class="card-text">{{ $usuariosBienestar }} usuarios
                        ({{ number_format($porcentajeBienestar, 2) }}%)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-category">
                <div class="card-body">
                    <h5 class="card-title">Coordinador</h5>
                    <p class="card-text">{{ $usuariosCoordinador }} usuarios
                        ({{ number_format($porcentajeCoordinador, 2) }}%)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-category">
                <div class="card-body">
                    <h5 class="card-title">Maestro</h5>
                    <p class="card-text">{{ $usuariosMaestro }} usuarios
                        ({{ number_format($porcentajeMaestro, 2) }}%)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-category">
                <div class="card-body">
                    <h5 class="card-title">Invitado</h5>
                    <p class="card-text">{{ $usuariosInvitado }} usuarios
                        ({{ number_format($porcentajeInvitado, 2) }}%)</p>
                </div>
            </div>
        </div>
    </div>
</div>
