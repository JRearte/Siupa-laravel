@extends('layouts.principal')
@section('title', 'Registrar telefono')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">{{ __('Registrar telefono') }}</h1>
        </header>
        <form method="POST" action="{{ route('tutor.registrar-telefono', ['tutor_id' => $tutor_id]) }}" role="form"
            enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="contenido">
                <input type="hidden" name="tutor_id" value="{{ $tutor_id }}">

                <!-- Número telefonico-->
                <div class="form-group mb-3">
                    <label for="numero" class="form-label">{{ __('Número telefonico') }}</label>
                    <input type="number" name="Numero"
                        class="form-control @error('Numero') is-invalid @enderror"
                        value="{{ old('Numero', $telefono?->Numero ?? '') }}" 
                        id="numero" placeholder="2966123456">
                
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
                    <a class="btn btn-secondary" href="{{ route('tutor.presentacion', $tutor_id) }}">
                        {{ __('Cancelar') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection