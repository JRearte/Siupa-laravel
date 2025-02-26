@section('title', 'Formulario de asistencia')

<div class="contenido">

    <!-- Hora de Ingreso -->
    <div class="form-group mb-3">
        <label for="hora_ingreso" class="form-label">{{ __('Hora de Ingreso') }}</label>
        <input type="time" name="Hora_Ingreso" class="form-control @error('Hora_Ingreso') is-invalid @enderror"
            value="{{ old('Hora_Ingreso', $asistencia?->Hora_Ingreso) }}" id="hora_ingreso">

        <div class="mensaje-container">
            @if ($errors->has('Hora_Ingreso'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Hora_Ingreso') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Hora de Salida -->
    <div class="form-group mb-3">
        <label for="hora_salida" class="form-label">{{ __('Hora de Salida') }}</label>
        <input type="time" name="Hora_Salida" class="form-control @error('Hora_Salida') is-invalid @enderror"
            value="{{ old('Hora_Salida', $asistencia?->Hora_Salida) }}" id="hora_salida">
            

        <div class="mensaje-container">
            @if ($errors->has('Hora_Salida'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Hora_Salida') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Estado -->
    <div class="form-group mb-3">
        <label for="estado" class="form-label">{{ __('Estado') }}</label>
        <select name="Estado" class="form-select @error('Estado') is-invalid @enderror" id="estado">
            <option value="Presente" {{ old('Estado', $asistencia?->Estado) == 'Presente' ? 'selected' : '' }}>
                {{ __('Presente') }}
            </option>
            <option value="Ausente Justificado"
                {{ old('Estado', $asistencia?->Estado) == 'Ausente Justificado' ? 'selected' : '' }}>
                {{ __('Ausente Justificado') }}
            </option>
            <option value="Ausente Injustificado"
                {{ old('Estado', $asistencia?->Estado) == 'Ausente Injustificado' ? 'selected' : '' }}>
                {{ __('Ausente Injustificado') }}
            </option>
        </select>

        <div class="mensaje-container">
            @if ($errors->has('Estado'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Estado') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Observación -->
    <div class="form-group mb-3">
        <label for="observacion" class="form-label">{{ __('Observación') }}</label>
        <textarea name="Observacion" class="form-control @error('Observacion') is-invalid @enderror" id="observacion"
            rows="3">{{ old('Observacion', $asistencia?->Observacion) }}</textarea>

        <div class="mensaje-container">
            @if ($errors->has('Observacion'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Observacion') }}
                </div>
            @endif
        </div>
    </div>



    <div class="form-buttons">
        <button type="submit" class="btn btn-primary">
            {{ __('Aceptar') }}
        </button>
        <a class="btn btn-secondary" href="{{ route('asistencia.presentacion', $asistencia->infante_id) }}">
            {{ __('Cancelar') }}
        </a>
    </div>
</div>
