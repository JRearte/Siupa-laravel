@extends('layouts.formulario')
@section('title', 'Modificar sala')

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Modificar') }} sala</span>
                    </div>
                    <div class="card-body bg-white">
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