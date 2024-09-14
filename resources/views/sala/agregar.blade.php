@extends('layouts.principal')
@section('title', 'Agragar sala')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="card">
                    <div class="card-header text-center">
                        <span class="card-title">{{ __('Crear') }} sala</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('sala.registrar') }}"  role="form" enctype="multipart/form-data" autocomplete="off">
                            @csrf

                            @include('sala.formulario')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection