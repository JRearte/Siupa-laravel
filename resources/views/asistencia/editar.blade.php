@extends('layouts.principal')
@section('title', 'Modificar asistencia')
@vite(['resources/css/formulario.css'])
@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title"><i class="icon fa-solid fa-user-pen"></i> {{ __('Modificar asistencia') }}</span>
            </h1>
        </header>
        <form method="POST" action="{{ route('asistencia.modificar', $asistencia->id) }}" role="form"
            enctype="multipart/form-data" autocomplete="off">
            {{ method_field('PATCH') }}
            @csrf
            <input type="hidden" name="asistencia_id" value="{{ $asistencia->id }}">
            <input type="hidden" name="Fecha" value="{{ $asistencia->Fecha->format('Y-m-d') }}">
            <input type="hidden" name="infante_id" value="{{ $asistencia->infante_id }}">
            <input type="hidden" name="sala_id" value="{{ $asistencia->sala_id }}">
            <input type="hidden" name="usuario_id" value="{{ $asistencia->usuario_id }}">
            @include('asistencia.formulario')
        </form>
    </section>
@endsection