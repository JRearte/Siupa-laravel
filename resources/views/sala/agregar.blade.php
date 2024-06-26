@extends('layouts.formulario')
@section('title', 'Agragar sala')

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Crear') }} sala</span>
                    </div>
                    <div class="card-body bg-white">
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