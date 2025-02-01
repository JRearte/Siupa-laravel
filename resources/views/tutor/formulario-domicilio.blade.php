@section('title', 'Formulario de domicilio')

<div class="contenido">
    <!-- Provincia -->
    <div class="form-group mb-3">
        <label for="provincia" class="form-label">
            {{ __('Provincia') }}
        </label>
        <input type="text" name="Provincia" class="form-control @error('Provincia') is-invalid @enderror"
            value="{{ old('Provincia', $domicilio?->Provincia) }}" id="provincia">

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Provincia'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Provincia') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Localidad -->
    <div class="form-group mb-3">
        <label for="localidad" class="form-label">
            {{ __('Localidad') }}
        </label>
        <input type="text" name="Localidad" class="form-control @error('Localidad') is-invalid @enderror"
            value="{{ old('Localidad', $domicilio?->Localidad) }}" id="localidad">

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Localidad'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Localidad') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Código Postal -->
    <div class="form-group mb-3">
        <label for="codigo_postal" class="form-label">
            {{ __('Código Postal') }}
        </label>
        <input type="text" name="Codigo_postal" class="form-control @error('Codigo_postal') is-invalid @enderror"
            value="{{ old('Codigo_postal', $domicilio?->Codigo_postal) }}" id="codigo_postal">

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Codigo_postal'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Codigo_postal') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Barrio -->
    <div class="form-group mb-3">
        <label for="Barrio" class="form-label">
            {{ __('Barrio') }}
        </label>
        <input type="text" name="Barrio" class="form-control @error('Barrio') is-invalid @enderror"
            value="{{ old('Barrio', $domicilio?->Barrio) }}" id="barrio">

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Barrio'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Barrio') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Calle -->
    <div class="form-group mb-3">
        <label for="calle" class="form-label">
            {{ __('Calle') }}
        </label>
        <input type="text" name="Calle" class="form-control @error('Calle') is-invalid @enderror"
            value="{{ old('Calle', $domicilio?->Calle) }}" id="calle">

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Calle'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Calle') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Número -->
    <div class="form-group mb-3">
        <label for="numero" class="form-label">
            {{ __('Número') }}
        </label>
        <input type="text" name="Numero" class="form-control @error('Numero') is-invalid @enderror"
            value="{{ old('Numero', $domicilio?->Numero) }}" id="numero">

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('Numero'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Numero') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Botones -->
    <div class="form-buttons">
        <button type="submit" class="btn btn-primary">
            {{ __('Aceptar') }}
        </button>
        <a class="btn btn-secondary" href="{{ route('tutor.presentacion', ['id' => $tutor_id]) }}">
            {{ __('Cancelar') }}
        </a>
    </div>
</div>
