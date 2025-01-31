@section('title', 'Formulario de tutor')

<div class="contenido">
    <!-- Legajo -->
    <div class="form-group mb-3">
        <label for="legajo" class="form-label">
            {{ __('Legajo') }}
            <span class="tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Ejemplo: 1-12345678/12 o 123">
                <i class="fa-solid fa-circle-question"></i>
            </span>
        </label>
        <input type="text" name="Legajo" class="form-control @error('Legajo') is-invalid @enderror"
            value="{{ old('Legajo', $tutor?->Legajo) }}" id="legajo">

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Legajo'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Legajo') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Nombre y Apellido -->
    <div class="row">
        <div class="form-group mb-3 col-md-6">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror"
                value="{{ old('Nombre', $tutor?->Nombre) }}" id="nombre">

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

        <div class="form-group mb-3 col-md-6">
            <label for="apellido" class="form-label">{{ __('Apellido') }}</label>
            <input type="text" name="Apellido" class="form-control @error('Apellido') is-invalid @enderror"
                value="{{ old('Apellido', $tutor?->Apellido) }}" id="apellido">

            <!-- Contenedor de mensaje de error -->
            <div class="mensaje-container">
                @if ($errors->has('Apellido'))
                    <div class="mensaje-error show">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('Apellido') }}
                    </div>
                @endif
            </div>
        </div>
    </div>


    <!-- Género -->
    <div class="form-group mb-3">
        <label for="genero" class="form-label">{{ __('Género') }}</label>
        <select name="Genero" class="form-control @error('Genero') is-invalid @enderror" id="genero">
            <option value="Masculino" {{ old('Genero', $tutor?->Genero) == 'Masculino' ? 'selected' : '' }}>
                {{ __('Masculino') }}
            </option>
            <option value="Femenino" {{ old('Genero', $tutor?->Genero) == 'Femenino' ? 'selected' : '' }}>
                {{ __('Femenino') }}
            </option>
        </select>

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Genero'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Genero') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Fecha de nacimiento -->
    <div class="form-group mb-3">
        <label for="fecha_nacimiento" class="form-label">{{ __('Fecha de Nacimiento') }}</label>
        <input type="date" name="Fecha_de_nacimiento"
            class="form-control @error('Fecha_de_nacimiento') is-invalid @enderror"
            value="{{ old('Fecha_de_nacimiento', $tutor?->Fecha_de_nacimiento) }}" id="fecha_nacimiento">

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Fecha_de_nacimiento'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Fecha_de_nacimiento') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Tipo y Número de Documento -->
    <div class="row">
        <div class="form-group mb-3 col-md-6">
            <label for="numero_documento" class="form-label">{{ __('Número de Documento') }}</label>
            <input type="text" name="Numero_documento"
                class="form-control @error('Numero_documento') is-invalid @enderror"
                value="{{ old('Numero_documento', $tutor?->Numero_documento) }}" id="numero_documento">

            <!-- Contenedor de mensaje de error -->
            <div class="mensaje-container">
                @if ($errors->has('Numero_documento'))
                    <div class="mensaje-error show">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('Numero_documento') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group mb-3 col-md-6">
            <label for="tipo_documento" class="form-label">{{ __('Tipo de Documento') }}</label>
            <input type="text" name="Tipo_documento"
                class="form-control @error('Tipo_documento') is-invalid @enderror"
                value="{{ old('Tipo_documento', $tutor?->Tipo_documento) }}" id="tipo_documento">

            <!-- Contenedor de mensaje de error -->
            <div class="mensaje-container">
                @if ($errors->has('Tipo_documento'))
                    <div class="mensaje-error show">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('Tipo_documento') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tipo de Tutor -->
    <div class="form-group mb-3" @if ($tutor?->Tipo_tutor) style="display: none;" @endif>
        <label for="tipo_tutor" class="form-label">{{ __('Tipo de Tutor') }}
            <span class="tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                title="¡Importante! Una vez registrado no se puede cambiar el tipo de tutor">
                <i class="fa-solid fa-circle-question"></i>
            </span>
        </label>
        <select name="Tipo_tutor" class="form-control @error('Tipo_tutor') is-invalid @enderror" id="tipo_tutor">
            <option value="Alumno" {{ old('Tipo_tutor', $tutor?->Tipo_tutor) === 'Alumno' ? 'selected' : '' }}>
                Alumno
            </option>
            <option value="Trabajador" {{ old('Tipo_tutor', $tutor?->Tipo_tutor) === 'Trabajador' ? 'selected' : '' }}>
                Trabajador
            </option>
        </select>

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Tipo_tutor'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Tipo_tutor') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Habilitado -->
    <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" id="habilitado" name="Habilitado" value="1"
            {{ old('Habilitado', $tutor?->Habilitado) == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="habilitado">{{ __('Habilitado') }}</label>
    </div>

    <!-- Botones -->
    <div class="form-buttons">
        <button type="submit" class="btn btn-primary">
            {{ __('Aceptar') }}
        </button>
        <a class="btn btn-secondary" href="{{ route('tutor.index') }}">
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
