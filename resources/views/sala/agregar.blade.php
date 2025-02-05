@extends('layouts.principal')
@section('title', 'Registrar sala')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Registrar sala') }}</span>
            </h1>
        </header>
        <form method="POST" action="{{ route('sala.registrar') }}" role="form" enctype="multipart/form-data"
            autocomplete="off">
            @csrf
            @include('sala.formulario')
        </form>
    </section>
@endsection
