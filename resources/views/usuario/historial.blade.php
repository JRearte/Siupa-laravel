@vite(['resources/css/historial.css'])
<div class="historial-container">
    @foreach($historial as $registro)
        <div class="historial-item">
            <div class="usuarioauth">
                <strong>Usuario: </strong> {{ $registro->usuario->Nombre }} {{ $registro->usuario->Apellido }}
            </div>
            <div class="accion">
                <strong>Acción:</strong> {{ $registro->accion }}
            </div>
            <div class="detalle">
                <strong>Detalle: </strong> {{ $registro->detalles }}
            </div>
        </div>
        <hr class="separator">
    @endforeach
</div>


