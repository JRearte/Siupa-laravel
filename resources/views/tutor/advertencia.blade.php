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
                    <i class="fas fa-exclamation-triangle modal-confirmacion-icono"></i>
                    Confirmación de Eliminación
                </h5>
            </div>

            <div class="modal-body modal-confirmacion-body">
                <p class="modal-confirmacion-mensaje">
                    ¿Está seguro de que desea eliminar al tutor 
                    <span class="modal-confirmacion-resaltado"><strong>{{ $tutor->Nombre }} {{ $tutor->Apellido }}</strong></span>?  
                    Esta acción no se puede deshacer. Si solo desea conservar sus datos sin que sean considerados en el sistema, 
                    considere <strong>deshabilitarlo</strong> en lugar de eliminarlo.
                </p>
            
                <p><strong>Eliminar este tutor también eliminará los siguientes datos asociados:</strong></p>
            
                <ul class="modal-confirmacion-lista">
                    <li>El <strong>infante</strong> vinculado y toda su información.</li>
                    <li>Los <strong>datos de contacto</strong> y el <strong>domicilio</strong> del tutor.</li>
                    @if ($tutor->Tipo_tutor === 'Trabajador')
                        <li>El historial de <strong>cuotas pagadas</strong>.</li>
                    @else
                        <li>Los <strong>registros académicos</strong> del tutor.</li>
                    @endif
                </ul>
            </div>
            

            <div class="modal-footer modal-confirmacion-footer">
                <form action="{{ route('tutor.eliminar', $tutor->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger modal-confirmacion-boton">Eliminar</button>
                </form>
                <button type="button" class="btn btn-secondary modal-confirmacion-boton"
                    data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
