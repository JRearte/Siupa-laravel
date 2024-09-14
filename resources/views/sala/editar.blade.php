@extends('layouts.principal')
@section('title', 'Modificar sala')
@vite(['resources/css/formulario.css'])
@section('content')
    <section class="formulario container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        <span class="card-title">{{ __('Modificar') }} sala</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('sala.modificar', $sala->id) }}"  role="form" enctype="multipart/form-data" autocomplete="off">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('sala.formulario')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection