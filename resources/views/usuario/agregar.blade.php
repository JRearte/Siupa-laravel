@extends('layouts.principal')
@section('title', 'Registrar usuario')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <i class="icon fa-solid fa-user-plus"></i> {{ __('Registrar usuario') }} 
            </h1>
        </header>
        <form method="POST" action="{{ route('usuario.registrar') }}" role="form" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @include('usuario.formulario')
        </form>
    </section>
@endsection