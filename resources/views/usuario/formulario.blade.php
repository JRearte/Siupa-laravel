@section('title', 'Formulario de usuario')

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
            value="{{ old('Legajo', $usuario?->Legajo) }}" id="legajo">

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
                value="{{ old('Nombre', $usuario?->Nombre) }}" id="nombre">

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
                value="{{ old('Apellido', $usuario?->Apellido) }}" id="apellido">

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

    <!-- Categoria -->
    @if (auth()->user()->Categoria == 'Bienestar')
        <div class="form-group mb-3">
            <label for="categoria" class="form-label">
                {{ __('Categoria') }}
                <span class="tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                    title="<div class='tooltip-list'>
                <div class='tooltip-item'><strong>Bienestar:</strong> gestiona todo menos asistencias.</div>
                <div class='tooltip-item'><strong>Coordinador:</strong> gestiona las asistencias.</div>
                <div class='tooltip-item'><strong>Maestro:</strong> solo registra asistencias.</div>
                <div class='tooltip-item'><strong>Invitado:</strong> solo puede ver información básica.</div>
            </div>">
                    <i class="fa-solid fa-circle-question"></i>
                </span>
            </label>
            <select name="Categoria" class="form-select @error('Categoria') is-invalid @enderror" id="categoria">
                @foreach ($categorias as $nombre => $valorCifrado)
                    <option value="{{ $valorCifrado }}"
                        {{ Crypt::decryptString(old('Categoria', $categoriaEncriptada)) == $nombre ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>

            <!-- Contenedor de mensaje de error -->
            <div class="mensaje-container">
                @if ($errors->has('Categoria'))
                    <div class="mensaje-error show">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('Categoria') }}
                    </div>
                @endif
            </div>
        </div>
    @else
        <input type="hidden" name="Categoria" id="categoria" value="{{ $categoriaEncriptada }}">
    @endif


    <!-- Contraseña -->
    <div x-data="{ verPassword: false }" class="form-group mb-3">
        <label for="password" class="form-label">{{ __('Contraseña') }}</label>
        <div class="input-group">
            <input :type="verPassword ? 'text' : 'password'" name="password"
                class="form-control @error('password') is-invalid @enderror" id="password" maxlength="60">
            <button type="button" class="btn-visibility" @click="verPassword = !verPassword">
                <i :class="verPassword ? 'fa-solid fa-eye-slash icon' : 'fa-solid fa-eye icon'"></i>
            </button>
        </div>

        <!-- Contenedor de mensaje de error -->
        <div class="mensaje-container">
            @if ($errors->has('password'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Habilitado -->
    @if (auth()->user()->Categoria == 'Bienestar')
        <div class="form-check form-switch mb-3">
            <input type="hidden" name="Habilitado" value="0">
            <input class="form-check-input" type="checkbox" id="habilitado" name="Habilitado" value="1"
                {{ old('Habilitado', $usuario?->Habilitado) == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="habilitado">{{ __('Habilitado') }}</label>
        </div>
    @else
        <input type="hidden" name="Habilitado" id="habilitado" value="{{ old('Habilitado', $usuario?->Habilitado) }}">
    @endif


    <!-- Botones -->
    <div class="form-buttons">
        <button type="submit" class="btn btn-primary">
            {{ __('Aceptar') }}
        </button>
        <a class="btn btn-secondary"
            href="{{ $usuario?->id == null ? route('usuario.index') : route('usuario.presentacion', $usuario->id) }}">
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
