
<div class="opciones">
    <a class="eliminar" data-bs-toggle="modal" data-bs-target="#modalConfirmacion">
        <i class="fa-solid fa-trash-can"></i>
    </a>
</div>

<div class="modal fade" id="modalConfirmacion" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-confirmacion">
            <div class="modal-header modal-confirmacion-header">
                <h5 class="modal-title modal-confirmacion-titulo">
                    <i class="fas fa-exclamation-triangle modal-confirmacion-icono"></i> Confirmación de Eliminación
                </h5>
            </div>

            <div class="modal-body modal-confirmacion-body">
                <p class="modal-confirmacion-mensaje">
                    ¿Está seguro de que desea eliminar al infante
                    <span class="modal-confirmacion-resaltado"><strong>{{ $infante->Nombre }}
                            {{ $infante->Apellido }}</strong></span>?
                    Esta acción no se puede <strong>deshacer</strong>. Si solo desea impedir que el infante siga formando parte del sistema, considere <strong>deshabilitarlo</strong> en lugar de eliminarlo.
                </p>

                <p>Eliminar este infante afectará los siguientes datos relacionados:</p>
                <ul class="modal-confirmacion-lista">
                    <li>Los <strong>familiares</strong> asociados y toda su información.</li>
                    <li>Los <strong>datos médicos</strong> del infante.</li>
                    <li>Los registros de <strong>asistencias</strong>.</li>
                </ul>
            </div>

            <div class="modal-footer modal-confirmacion-footer">
                <form action="{{ route('infante.eliminar', $infante->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger modal-confirmacion-boton">Eliminar</button>
                </form>
                <button type="button" class="btn btn-secondary modal-confirmacion-boton" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>