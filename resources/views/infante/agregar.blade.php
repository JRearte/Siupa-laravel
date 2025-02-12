@extends('layouts.principal')
@section('title', 'Registrar infante')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Registrar infante') }} </span>
            </h1>
        </header>

        <form method="POST" action="{{ route('infante.registrar', ['tutor_id' => $tutor_id]) }}" role="form"
            enctype="multipart/form-data" autocomplete="off">
            @csrf

            <input type="hidden" name="tutor_id" value="{{ $tutor_id }}">
            @include('infante.formulario')
            <div class="contenido">
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Aceptar') }}
                    </button>

                    <a class="btn btn-secondary" href="{{ route('tutor.presentacion', ['id' => $tutor_id]) }}">
                        {{ __('Cancelar') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
