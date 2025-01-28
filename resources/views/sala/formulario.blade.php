@section('title', 'Formulario de sala')
<div class="contenido">
    <div class="form-group mb-3">
        <label for="nombre" class="form-label">
            {{ __('Nombre') }}
        </label>
        <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror"
            value="{{ old('Nombre', $sala?->Nombre) }}" id="nombre">
        
        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Nombre'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Nombre') }}
                </div>
            @endif
        </div>
    </div>
    
    <div class="form-group mb-3">
        <label for="edad" class="form-label">
            {{ __('Edad') }}
            <span class="tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edad permitida para ingresar">
                <i class="fa-solid fa-circle-question"></i>
            </span>
        </label>
        <input type="number" name="Edad" class="form-control @error('Edad') is-invalid @enderror"
            value="{{ old('Edad', $sala?->Edad) }}" id="edad">
        
        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Edad'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Edad') }}
                </div>
            @endif
        </div>
    </div>
    
    <div class="form-group mb-3">
        <label for="capacidad" class="form-label">
            {{ __('Capacidad') }}
            <span class="tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Capacidad máxima permitida">
                <i class="fa-solid fa-circle-question"></i>
            </span>
        </label>
        <input type="number" name="Capacidad" class="form-control @error('Capacidad') is-invalid @enderror"
            value="{{ old('Capacidad', $sala?->Capacidad) }}" id="capacidad">
        
        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Capacidad'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Capacidad') }}
                </div>
            @endif
        </div>
    </div>
    
    <div class="form-buttons">
        <button type="submit" class="btn btn-primary">
            {{ __('Aceptar') }}
        </button>
        <a class="btn btn-secondary" href="{{ route('sala.index') }}"> 
            {{ __('Cancelar') }}
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
