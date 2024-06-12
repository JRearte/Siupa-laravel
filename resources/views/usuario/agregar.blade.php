@extends('layouts.formulario')
@section('title', 'Agragar usuario')

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Crear') }} usuario</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('usuario.registrar') }}"  role="form" enctype="multipart/form-data" autocomplete="off">
                            @csrf

                            @include('usuario.formulario')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
