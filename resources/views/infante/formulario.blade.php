@section('title', 'Formulario de Infante')

<div class="contenido">
    <!-- Nombre y Apellido -->
    <div class="row">
        <div class="form-group mb-3 col-md-6">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror"
                value="{{ old('Nombre', $infante?->Nombre) }}" id="nombre">

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
                value="{{ old('Apellido', $infante?->Apellido) }}" id="apellido">

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
            <option value="Masculino" {{ old('Genero', $infante?->Genero) == 'Masculino' ? 'selected' : '' }}>
                {{ __('Masculino') }}</option>
            <option value="Femenino" {{ old('Genero', $infante?->Genero) == 'Femenino' ? 'selected' : '' }}>
                {{ __('Femenino') }}</option>
        </select>

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
            value="{{ old('Fecha_de_nacimiento', optional($infante)->Fecha_de_nacimiento ? $infante->Fecha_de_nacimiento->format('Y-m-d') : '') }}"
            id="fecha_nacimiento">

        <div class="mensaje-container">
            @if ($errors->has('Fecha_de_nacimiento'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Fecha_de_nacimiento') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Número de Documento y Tipo de Documento -->
    <div class="row">
        <div class="form-group mb-3 col-md-6">
            <label for="numero_documento" class="form-label">{{ __('Número de Documento') }}</label>
            <input type="text" name="Numero_documento"
                class="form-control @error('Numero_documento') is-invalid @enderror"
                value="{{ old('Numero_documento', $infante?->Numero_documento) }}" id="numero_documento">

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
                value="{{ old('Tipo_documento', $infante?->Tipo_documento) }}" id="tipo_documento">

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

    <!-- Categoría -->
    <div class="form-group mb-3">
        <label for="categoria" class="form-label">{{ __('Categoría') }}</label>
        <select name="Categoria" class="form-control @error('Categoria') is-invalid @enderror" id="categoria">
            <option value="Ingresante" {{ old('Categoria', $infante?->Categoria) == 'Ingresante' ? 'selected' : '' }}>
                {{ __('Ingresante') }}</option>
            <option value="Readmitido" {{ old('Categoria', $infante?->Categoria) == 'Readmitido' ? 'selected' : '' }}>
                {{ __('Readmitido') }}</option>
        </select>

        <div class="mensaje-container">
            @if ($errors->has('Categoria'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Categoria') }}
                </div>
            @endif
        </div>
    </div>


    <!-- Fecha de Asignación -->
    <div class="form-group mb-3">
        <label for="fecha_asignacion" class="form-label">{{ __('Fecha de Asignación') }}</label>
        <input type="date" name="Fecha_de_asignacion"
            class="form-control @error('Fecha_de_asignacion') is-invalid @enderror"
            value="{{ old('Fecha_de_asignacion', optional($infante)->Fecha_de_asignacion ? $infante->Fecha_de_asignacion->format('Y-m-d') : '') }}"
            id="fecha_asignacion">

        <div class="mensaje-container">
            @if ($errors->has('Fecha_de_asignacion'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Fecha_de_asignacion') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Selección de salas -->
    @if (!is_null($infante->sala_id) && isset($salas))
        <div class="form-group mb-3">
            <label for="sala_id" class="form-label">{{ __('Sala') }}</label>
            <select name="sala_id" class="form-control @error('sala_id') is-invalid @enderror" id="sala_id">
                @foreach ($salas as $sala)
                    <option value="{{ $sala->id }}"
                        {{ (int) old('sala_id', $infante->sala_id) === (int) $sala->id ? 'selected' : '' }}>
                        {{ $sala->Nombre }} ({{ $sala->Edad }} años)
                    </option>
                @endforeach
            </select>

            <div class="mensaje-container">
                @if ($errors->has('sala_id'))
                    <div class="mensaje-error show">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('sala_id') }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Habilitado -->
    <div class="form-check form-switch mb-3">
        <input type="hidden" name="Habilitado" value="0">
        <input class="form-check-input" type="checkbox" id="habilitado" name="Habilitado" value="1"
            {{ old('Habilitado', $infante?->Habilitado) == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="habilitado">{{ __('Habilitado') }}</label>
    </div>
    
</div>
