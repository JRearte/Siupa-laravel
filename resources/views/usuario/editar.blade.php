@extends('layouts.principal')
@section('title', 'Modificar usuario')
@vite(['resources/css/formulario.css'])
@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title"><i class="icon fa-solid fa-user-pen"></i> {{ __('Modificar') }} usuario</span>
            </h1>
        </header>
        <form method="POST" action="{{ route('usuario.modificar', $usuario->id) }}" role="form"
            enctype="multipart/form-data" autocomplete="off">
            {{ method_field('PATCH') }}
            @csrf
            @include('usuario.formulario')
        </form>
    </section>
@endsection