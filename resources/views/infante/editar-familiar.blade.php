@extends('layouts.principal')
@section('title', 'Modificar infante')
@vite(['resources/css/formulario.css'])
@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Modificar infante') }} </span>
            </h1>
        </header>
        <form method="POST" action="{{ route('infante.modificar-familiar', $familia->id) }}">
            @method('PATCH')
            @csrf
            <input type="hidden" name="infante_id" value="{{ $familia->infante_id }}">
            @include('infante.formulario-familiar')
        </form>
    </section>
@endsection