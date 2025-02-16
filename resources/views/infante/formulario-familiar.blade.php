@section('title', 'Formulario de Familiar')

<div class="contenido">
    <!-- Nombre y Apellido -->
    <div class="row">
        <div class="form-group mb-3 col-md-6">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror"
                value="{{ old('Nombre', $familia?->Nombre) }}" id="nombre">

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
                value="{{ old('Apellido', $familia?->Apellido) }}" id="apellido">

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

    <!-- Vínculo -->
    <div class="form-group mb-3">
        <label for="vinculo" class="form-label">{{ __('Vínculo') }}</label>
        <select name="Vinculo" class="form-control @error('Vinculo') is-invalid @enderror" id="vinculo">
            @foreach (['Padre', 'Madre', 'Padrastro', 'Madrastra', 'Tío', 'Tía', 'Primo', 'Prima', 'Hermano', 'Hermana', 'Hermanastro', 'Hermanastra', 'Abuelo', 'Abuela'] as $vinculo)
                <option value="{{ $vinculo }}"
                    {{ old('Vinculo', $familia?->Vinculo) == $vinculo ? 'selected' : '' }}>
                    {{ __($vinculo) }}
                </option>
            @endforeach
        </select>

        <div class="mensaje-container">
            @if ($errors->has('Vinculo'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Vinculo') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Fecha de Nacimiento -->
    <div class="form-group mb-3">
        <label for="fecha_nacimiento" class="form-label">{{ __('Fecha de Nacimiento') }}</label>
        <input type="date" name="Fecha_de_nacimiento"
            class="form-control @error('Fecha_de_nacimiento') is-invalid @enderror"
            value="{{ old('Fecha_de_nacimiento', optional($familia)->Fecha_de_nacimiento ? $familia->Fecha_de_nacimiento->format('Y-m-d') : '') }}"
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
                value="{{ old('Numero_documento', $familia?->Numero_documento) }}" id="numero_documento">

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
                value="{{ old('Tipo_documento', $familia?->Tipo_documento) }}" id="tipo_documento">

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

    <!-- Lugar de Trabajo -->
    <div class="form-group mb-3">
        <label for="lugar_trabajo" class="form-label">{{ __('Lugar de Trabajo') }}</label>
        <input type="text" name="Lugar_de_trabajo"
            class="form-control @error('Lugar_de_trabajo') is-invalid @enderror"
            value="{{ old('Lugar_de_trabajo', $familia?->Lugar_de_trabajo) }}" id="lugar_trabajo">

        <div class="mensaje-container">
            @if ($errors->has('Lugar_de_trabajo'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Lugar_de_trabajo') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Ingreso -->
    <div class="form-group mb-3">
        <label for="ingreso" class="form-label">{{ __('Ingreso') }}</label>
        <input type="number" step="0.01" name="Ingreso" class="form-control @error('Ingreso') is-invalid @enderror"
            value="{{ old('Ingreso', $familia?->Ingreso) }}" id="ingreso">

        <div class="mensaje-container">
            @if ($errors->has('Ingreso'))
                <div class="mensaje-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('Ingreso') }}
                </div>
            @endif
        </div>
    </div>



    <!-- Habilitado -->
    <div class="form-check form-switch mb-3">
        <input type="hidden" name="Habilitado" value="0">
        <input class="form-check-input" type="checkbox" id="habilitado" name="Habilitado" value="1"
            {{ old('Habilitado', $familia?->Habilitado) == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="habilitado">{{ __('Habilitado') }}</label>
    </div>

    <div class="form-buttons">
        <button type="submit" class="btn btn-primary">
            {{ __('Aceptar') }}
        </button>

        @php
            $id = $infante_id ?? ($familia?->infante_id ?? null);
        @endphp

        @if ($id)
            <a class="btn btn-secondary" href="{{ route('infante.presentacion', ['id' => $id]) }}">
                {{ __('Cancelar') }}
            </a>
        @endif
    </div>
</div>
