@extends('layouts.principal')
@section('title', 'Modificar trabajador')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Modificar') }} trabajador</span>
            </h1>
        </header>
        <form method="POST" action="{{ route('tutor.modificar-trabajador', $trabajador->id) }}">
            @method('PATCH')
            @csrf
            <input type="hidden" name="tutor_id" value="{{ $tutor_id }}">
            @include('tutor.formulario-trabajador')
        </form>
    </section>
@endsection
