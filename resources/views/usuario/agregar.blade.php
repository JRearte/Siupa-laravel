@extends('layouts.principal')
@section('title', 'Agragar usuario')
@vite(['resources/css/formulario.css'])

@section('content')
    <section class="formulario container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        <span class="card-title"><i class="icon fa-solid fa-user-plus"></i> {{ __('Crear') }} usuario</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('usuario.registrar') }}" role="form" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @include('usuario.formulario')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



