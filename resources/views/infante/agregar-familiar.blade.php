@extends('layouts.principal')
@section('title', 'Registrar infante')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Registrar infante') }} </span>
            </h1>
        </header>

        <form method="POST" action="{{ route('infante.registrar-familiar', ['infante_id' => $infante_id]) }}" role="form"
            enctype="multipart/form-data" autocomplete="off">
            @csrf

            <input type="hidden" name="infante_id" value="{{ $infante_id }}">
            @include('infante.formulario-familiar')
            
        </form>
    </section>
@endsection