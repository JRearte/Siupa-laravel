@extends('layouts.principal')
@section('title', 'Registrar infante')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Registrar dato médico') }} </span>
            </h1>
        </header>

        <form method="POST" action="{{ route('infante.registrar-medico', ['infante_id' => $infante_id]) }}" role="form"
            enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="contenido">
                <input type="hidden" name="infante_id" value="{{ $infante_id }}">
                <div class="form-group mb-3">
                    <label for="tipo" class="form-label">{{ __('Tipo') }}</label>
                    <select name="Tipo" id="tipo" class="form-control @error('Tipo') is-invalid @enderror">
                        <option value="Discapacidad" {{ old('Tipo', $medico?->Tipo) == 'Discapacidad' ? 'selected' : '' }}>
                            Discapacidad
                        </option>
                        <option value="Alergia" {{ old('Tipo', $medico?->Tipo) == 'Alergia' ? 'selected' : '' }}>
                            Alergia
                        </option>
                        <option value="Vacuna" {{ old('Tipo', $medico?->Tipo) == 'Vacuna' ? 'selected' : '' }}>
                            Vacuna
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

                <div class="form-group mb-3">
                    <label for="nombre" class="form-label">{{ __('Descripción') }}</label>
                    <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror"
                        value="{{ old('Nombre', $medico?->Nombre ?? '') }}" id="nombre" >

                    <div class="mensaje-container">
                        @if ($errors->has('Nombre'))
                            <div class="mensaje-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('Nombre') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Aceptar') }}
                    </button>

                    <a class="btn btn-secondary" href="{{ route('infante.presentacion', ['id' => $infante_id]) }}">
                        {{ __('Cancelar') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
