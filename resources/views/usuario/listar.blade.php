@extends('layouts.principal')
@section('title', 'Gestor de Usuarios')
@section('content')
@vite(['resources/css/tabla.css']) 
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-movida">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Total de usuarios') }} {{ $totalUsuarios }}
                        </span>
                        <div class="float-right">
                            <a href="{{ route('usuario.agregar') }}" class="btn btn-dark btn-sm float-right mr-2"  data-placement="left">
                            <i class="fas fa-user-plus" style="color: #ffffff;"></i> <!-- Icono de agregar -->
                                {{ __('Agregar') }}
                            </a>
                            <a href="{{ route('usuario.reporte') }}" class="btn btn-dark btn-sm float-right mr-2"  data-placement="left">
                            <i class="fas fa-file-pdf" style="color: #ffffff;"></i><!-- Icono de reporte -->
                                {{ __('Reporte') }}
                            </a>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div id="success-message" class="alert alert-success m-4">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th class="col-n">#</th>
                                    <th class="col-legajo">Legajo</th>
                                    <th class="col-nombre">Nombre</th>
                                    <th class="col-categoria">Categoria</th>
                                    <th class="col-habilitado">Habilitado</th>
                                    <th class="col-opcion">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td class="col-n">{{ ++$i }}</td>
                                        <td>{{ $usuario->Legajo }}</td>
                                        @php
                                        $nombreCompleto = $usuario->Nombre;
                                        $primerNombre = explode(' ', $nombreCompleto)[0]; // Toma el primer nombre
                                        $apellidoCompleto = $usuario->Apellido;
                                        $primerApellido = explode(' ', $apellidoCompleto)[0]; // Toma el primer nombre
                                        @endphp
                                        <td>{{ $primerNombre }} {{ $primerApellido }}</td>
                                        <td>{{ $usuario->Categoria }}</td>
                                        <td>@if($usuario->Habilitado == 1) Activado @else Desactivado @endif</td>

                                        <td th class="col-opcion">
                                            <a class="btn btn-sm btn-primary" href="{{ route('usuario.presentacion',$usuario->id) }}"><i class="fas fa-user"></i></a>
                                            <a class="btn btn-sm btn-success" href="{{ route('usuario.editar',$usuario->id) }}"><i class="fa-solid fa-pencil"></i></i></a>
                                            <a class="btn btn-sm btn-danger" href="{{ route('usuario.confirmar',$usuario->id) }}"><i class="fa fa-fw fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container">
                {!! $usuarios->links('vendor.pagination.bootstrap-4') !!}
            </div>
        </div>
    </div>
@endsection



@section('scripts')
    <script>
        // Función para ocultar el mensaje de éxito después de 7 segundos
        setTimeout(function() {
            document.getElementById('success-message').style.display = 'none';
        }, 7000);
    </script>
@endsection
