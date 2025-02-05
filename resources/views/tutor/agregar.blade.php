@extends('layouts.principal')
@section('title', 'Registrar tutor')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Registrar tutor') }} </span>
            </h1>
        </header>
        <form method="POST" action="{{ route('tutor.registrar') }}" role="form" enctype="multipart/form-data"
            autocomplete="off">
            @csrf
            @include('tutor.formulario')
        </form>
    </section>
@endsection