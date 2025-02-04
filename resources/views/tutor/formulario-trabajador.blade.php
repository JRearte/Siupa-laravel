@section('title', 'Formulario de tutor trabajador')

<div class="contenido">
    <div class="form-group mb-3">
        <label for="hora" class="form-label">{{ __('Horas de Trabajo') }}</label>
        <input type="number" name="Hora" class="form-control @error('Hora') is-invalid @enderror"
            value="{{ old('Hora', $trabajador?->Hora) }}" id="hora" min="1" step="1">

        <div class="mensaje-container">
            @if ($errors->has('Hora'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Hora') }}
                </div>
            @endif
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="cargo" class="form-label">{{ __('Cargo') }}</label>
        <input type="text" name="Cargo" class="form-control @error('Cargo') is-invalid @enderror"
            value="{{ old('Cargo', $trabajador?->Cargo) }}" id="cargo">

        <div class="mensaje-container">
            @if ($errors->has('Cargo'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Cargo') }}
                </div>
            @endif
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="tipo_trabajador" class="form-label">{{ __('Tipo de Trabajador') }}</label>
        <select name="Tipo" class="form-control @error('Tipo') is-invalid @enderror" id="tipo_trabajador">
            <option value="Docente" {{ old('Tipo', $trabajador?->Tipo) === 'Docente' ? 'selected' : '' }}>
                Docente
            </option>
            <option value="No docente" {{ old('Tipo', $trabajador?->Tipo) === 'No docente' ? 'selected' : '' }}>
                No docente
            </option>
        </select>

        <div class="mensaje-container">
            @if ($errors->has('Tipo'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Tipo') }}
                </div>
            @endif
        </div>
    </div>
</div>
