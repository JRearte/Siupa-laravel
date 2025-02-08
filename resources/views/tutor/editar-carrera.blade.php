@extends('layouts.principal')
@section('title', 'Modificar carrera')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Modificar carrera') }} </span>
            </h1>
        </header>
        <form method="POST" action="{{ route('tutor.modificar-carrera', $carrera->id) }}">
            @method('PATCH')
            @csrf
            <input type="hidden" name="tutor_id" value="{{ $tutor_id }}">
            @include('tutor.formulario-carrera')
            <div class="contenido">
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        {{ __('Aceptar') }}
                    </button>
                    <a href="{{ route('tutor.presentacion', $tutor_id) }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </section>
@endsection