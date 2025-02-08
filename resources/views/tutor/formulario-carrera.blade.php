@section('title', 'Formulario de tutor alumno')

<div class="contenido">

    <!-- Código de la Carrera -->
    <div class="form-group mb-3">
        <label for="codigo" class="form-label">{{ __('Código') }}</label>
        <input type="text" name="Codigo" class="form-control @error('Codigo') is-invalid @enderror"
            value="{{ old('Codigo', $carrera?->Codigo) }}" id="codigo">

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Codigo'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Codigo') }}
                </div>
            @endif
        </div>
    </div>
    
    <!-- Nombre de la Carrera -->
    <div class="form-group mb-3">
        <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
        <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror"
            value="{{ old('Nombre', $carrera?->Nombre) }}" id="nombre">

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

</div>
