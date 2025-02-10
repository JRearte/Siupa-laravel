@extends('layouts.principal')
@section('title', 'Modificar asignatura')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Modificar asignatura') }}</span>
            </h1>
        </header>
        <form method="POST" action="{{ route('tutor.modificar-asignatura',  $asignatura->id) }}">
            @method('PATCH')
            @csrf
            <input type="hidden" name="tutor_id" value="{{ $tutor_id }}">
            <input type="hidden" name="carrera_id" value="{{ $carrera_id }}">
            @include('tutor.formulario-asignatura')
        </form>
    </section>
@endsection
