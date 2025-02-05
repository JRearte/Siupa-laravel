@extends('layouts.principal')
@section('title', 'Agregar cuota')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">{{ __('Crear cuota') }}</h1>
        </header>
        <form method="POST" action="{{ route('tutor.registrar-cuota', ['trabajador_id' => $trabajador_id]) }}" role="form"
            enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="contenido">
                <input type="hidden" name="trabajador_id" value="{{ $trabajador_id }}">

                <!-- Valor de la cuota -->
                <div class="form-group mb-3">
                    <label for="valor_cuota" class="form-label">{{ __('Valor') }}</label>
                    <input type="number" name="Valor"
                        class="form-control @error('Valor') is-invalid @enderror"
                        value="{{ old('Valor', $cuota?->Valor ?? '') }}" 
                        id="valor_cuota" placeholder="0">
                
                    <!-- Contenedor de mensaje de error -->
                    <div class="mensaje-container">
                        @if ($errors->has('Valor'))
                            <div class="mensaje-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('Valor') }}
                            </div>
                        @endif
                    </div>
                </div>
                

                <!-- Fecha de la cuota -->
                <div class="form-group mb-3">
                    <label for="fecha_cuota" class="form-label">{{ __('Fecha de pago') }}</label>
                    <input type="date" name="Fecha" class="form-control @error('Fecha') is-invalid @enderror"
                        value="{{ old('Fecha', $cuota?->Fecha) }}" id="fecha_cuota">

                    <!-- Contenedor de mensaje de error -->
                    <div class="mensaje-container">
                        @if ($errors->has('Fecha'))
                            <div class="mensaje-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('Fecha') }}
                            </div>
                        @endif
                    </div>
                </div>


                <!-- Botones -->
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Aceptar') }}
                    </button>
                    <a class="btn btn-secondary" href="{{ route('tutor.presentacion', $trabajador_id) }}">
                        {{ __('Cancelar') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
