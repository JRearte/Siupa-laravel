@extends('layouts.principal')
@section('title', 'Agregar domicilio')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">{{ __('Crear domicilio') }}</h1>
        </header>
        <form method="POST" action="{{ route('tutor.registrar-domicilio', ['tutor_id' => $tutor_id]) }}" role="form" enctype="multipart/form-data"
            autocomplete="off">
            @csrf
            <input type="hidden" name="tutor_id" value="{{ $tutor_id }}">
            @include('tutor.formulario-domicilio')
        </form>
    </section>
@endsection