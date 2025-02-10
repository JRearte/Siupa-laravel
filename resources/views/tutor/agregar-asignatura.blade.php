@extends('layouts.principal')
@section('title', 'Registrar asignatura')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">{{ __('Registrar asignatura') }}</h1>
        </header>
        <div class="contenido">
            <form method="POST" action="{{ route('tutor.registrar-asignatura', ['tutor_id' => $tutor_id, 'carrera_id' => $carrera_id]) }}" role="form"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                <input type="hidden" name="tutor_id" value="{{ $tutor_id }}">
                <input type="hidden" name="carrera_id" value="{{ $carrera_id }}">

                @include('tutor.formulario-asignatura')

            </form>
        </div>
    </section>
@endsection
