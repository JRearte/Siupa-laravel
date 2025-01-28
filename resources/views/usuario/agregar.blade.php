@extends('layouts.principal')
@section('title', 'Agragar usuario')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <i class="icon fa-solid fa-user-plus"></i> {{ __('Crear') }} usuario
            </h1>
        </header>
        <form method="POST" action="{{ route('usuario.registrar') }}" role="form" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @include('usuario.formulario')
        </form>
    </section>
@endsection