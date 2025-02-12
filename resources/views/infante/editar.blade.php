@extends('layouts.principal')
@section('title', 'Modificar infante')
@vite(['resources/css/formulario.css'])
@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Modificar infante') }} </span>
            </h1>
        </header>
        <form method="POST" action="{{ route('infante.modificar', $infante->id) }}">
            @method('PATCH')
            @csrf
            <input type="hidden" name="tutor_id" value="{{ $infante->tutor_id }}">
            @include('infante.formulario')
            <div class="contenido">
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Aceptar') }}
                    </button>

                    <a class="btn btn-secondary" href="{{ route('infante.presentacion', ['id' => $infante->id]) }}">
                        {{ __('Cancelar') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
