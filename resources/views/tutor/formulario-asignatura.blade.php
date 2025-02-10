@section('title', 'Formulario de asignatura')

<div class="contenido">
    <!-- Legajo -->
    <div class="form-group mb-3">
        <label for="codigo" class="form-label">{{ __('Código') }}</label>
        <input type="text" name="Codigo" class="form-control @error('Codigo') is-invalid @enderror"
            value="{{ old('Codigo', $asignatura?->Codigo) }}" id="codigo">
    
        <div class="mensaje-container">
            @if ($errors->has('Codigo'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Codigo') }}
                </div>
            @endif
        </div>
    </div>
    
    <div class="form-group mb-3">
        <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
        <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror"
            value="{{ old('Nombre', $asignatura?->Nombre) }}" id="nombre">
    
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
        <label for="fecha" class="form-label">{{ __('Fecha') }}</label>
        <input type="date" name="Fecha" class="form-control @error('Fecha') is-invalid @enderror"
            value="{{ old('Fecha', optional($asignatura)->Fecha ? $asignatura->Fecha->format('Y-m-d') : '') }}" id="fecha">
    
        <div class="mensaje-container">
            @if ($errors->has('Fecha'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Fecha') }}
                </div>
            @endif
        </div>
    </div>
    
    <div class="form-group mb-3">
        <label for="condicion" class="form-label">{{ __('Condición') }}</label>
        <select name="Condicion" class="form-control @error('Condicion') is-invalid @enderror" id="condicion">
            <option value="Cursando" {{ old('Condicion', $asignatura?->Condicion) == 'Cursando' ? 'selected' : '' }}>
                {{ __('Cursando') }}
            </option>
            <option value="Libre" {{ old('Condicion', $asignatura?->Condicion) == 'Libre' ? 'selected' : '' }}>
                {{ __('Libre') }}
            </option>
            <option value="Regular" {{ old('Condicion', $asignatura?->Condicion) == 'Regular' ? 'selected' : '' }}>
                {{ __('Regular') }}
            </option>
            <option value="Aprobado" {{ old('Condicion', $asignatura?->Condicion) == 'Aprobado' ? 'selected' : '' }}>
                {{ __('Aprobado') }}
            </option>
        </select>
    
        <div class="mensaje-container">
            @if ($errors->has('Condicion'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Condicion') }}
                </div>
            @endif
        </div>
    </div>
    
    <div class="form-group mb-3">
        <label for="calificacion" class="form-label">{{ __('Calificación') }}</label>
        <input type="number" name="Calificacion" class="form-control @error('Calificacion') is-invalid @enderror"
            value="{{ old('Calificacion', $asignatura?->Calificacion) }}" id="calificacion" min="0" max="10">
    
        <div class="mensaje-container">
            @if ($errors->has('Calificacion'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Calificacion') }}
                </div>
            @endif
        </div>
    </div>
    

    <!-- Botones -->
    <div class="form-buttons">
        <button type="submit" class="btn btn-primary">
            {{ __('Siguiente') }}
        </button>


        <a class="btn btn-secondary"
            href="{{ route('tutor.presentacion', $tutor_id) }}">
            {{ __('Cancelar') }}
        </a>

    </div>
</div>