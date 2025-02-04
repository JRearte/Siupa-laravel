@extends('layouts.principal')
@section('title', 'Agregar tutor trabajador')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">{{ __('Crear trabajador') }}</h1>
        </header>
        <div class="contenido">
            <form method="POST" action="{{ route('tutor.registrar-trabajador', ['tutor_id' => $tutor_id]) }}" role="form"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                <input type="hidden" name="tutor_id" value="{{ $tutor_id }}">
                @include('tutor.formulario-trabajador')
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        {{ __('Aceptar') }}
                    </button>
                </div>
            </form>

            <form action="{{ route('tutor.eliminar', $tutor_id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="form-buttons">
                    <button type="submit" class="btn btn-secondary" style="width: 100%;">Cancelar</button>
                </div>
            </form>
        </div>
    </section>
@endsection
