@extends('layouts.principal')
@section('title', 'Registrar asistencia')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <i class="icon fa-solid fa-user-plus"></i> {{ __('Registrar asistencia') }} 
            </h1>
        </header>
        <form method="POST" action="{{ route('asistencia.registrar') }}" role="form" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <input type="hidden" name="Fecha" value="{{ $asistencia->Fecha->format('Y-m-d') }}">
            <input type="hidden" name="infante_id" value="{{ $asistencia->infante_id }}">
            <input type="hidden" name="sala_id" value="{{ $asistencia->sala_id }}">
            <input type="hidden" name="usuario_id" value="{{ $asistencia->usuario_id }}">
            @include('asistencia.formulario')
        </form>
    </section>
@endsection