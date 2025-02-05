@extends('layouts.principal')
@section('title', 'Modificar sala')
@vite(['resources/css/formulario.css'])
@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Modificar sala') }} </span>
            </h1>
        </header>
        <form method="POST" action="{{ route('sala.modificar', $sala->id) }}" role="form" enctype="multipart/form-data"
            autocomplete="off">
            {{ method_field('PATCH') }}
            @csrf
            @include('sala.formulario')
        </form>
    </section>
@endsection
