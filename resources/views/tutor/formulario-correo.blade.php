@extends('layouts.principal')
@section('title', 'Registrar correo')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">{{ __('Registrar correo') }}</h1>
        </header>
        <form method="POST" action="{{ route('tutor.registrar-correo', ['tutor_id' => $tutor_id]) }}" role="form"
            enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="contenido">
                <input type="hidden" name="tutor_id" value="{{ $tutor_id }}">

                <div class="form-group mb-3">
                    <label for="correo" class="form-label">{{ __('Correo electrónico') }}</label>
                    <input type="text" name="Mail"
                        class="form-control @error('Mail') is-invalid @enderror"
                        value="{{ old('Mail', $correo?->Mail ?? '') }}" 
                        id="correo" placeholder="example@mail.com">
            
                    <!-- Contenedor de mensaje de error -->
                    <div class="mensaje-container">
                        @if ($errors->has('Mail'))
                            <div class="mensaje-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('Mail') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Botones -->
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Aceptar') }}
                    </button>
                    <a class="btn btn-secondary" href="{{ route('tutor.presentacion', $tutor_id) }}">
                        {{ __('Cancelar') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
