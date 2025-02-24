<!-- Botón para abrir el modal -->
<div class="opciones">
    <a class="eliminar" data-bs-toggle="modal" data-bs-target="#modalConfirmacion">
        <i class="fa-solid fa-trash-can"></i>
    </a>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="modalConfirmacion" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-confirmacion">
            <div class="modal-header modal-confirmacion-header">
                <h5 class="modal-title modal-confirmacion-titulo">
                    <i class="fas fa-exclamation-triangle modal-confirmacion-icono"></i> 
                    Confirmación de Eliminación
                </h5>
            </div>

            <div class="modal-body modal-confirmacion-body">
                <p class="modal-confirmacion-mensaje">
                    ¿Está seguro de que desea eliminar al usuario 
                    <strong class="modal-confirmacion-usuario">{{ $usuario->Nombre }} {{ $usuario->Apellido }}</strong>?
                    Esta acción no se puede deshacer. Si solo desea impedir que el usuario siga interactuando con el
                    sistema, considere <strong>deshabilitarlo</strong> en lugar de eliminarlo.
                </p>
            </div>

            <div class="modal-footer modal-confirmacion-footer">
                <form action="{{ route('usuario.eliminar', $usuario->id) }}" method="POST" class="modal-confirmacion-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger modal-confirmacion-boton">Eliminar</button>
                </form>
                <button type="button" class="btn btn-secondary modal-confirmacion-boton" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

