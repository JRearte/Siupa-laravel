@extends('layouts.principal')
@section('title', 'Modificar tutor')
@vite(['resources/css/formulario.css'])
@section('content')
    <section class="formulario">
        <header class="form-header">
            <h1 class="form-title">
                <span class="card-title">{{ __('Modificar') }} tutor</span>
            </h1>
        </header>
        <form method="POST" action="{{ route('tutor.modificar', $tutor->id) }}" role="form" enctype="multipart/form-data"
            autocomplete="off">
            {{ method_field('PATCH') }}
            @csrf
            @include('tutor.formulario')
        </form>
    </section>
@endsection