@extends('layouts.principal')
@section('title', 'Gestor de usuarios')
@section('content')
@vite(['resources/css/tabla.css']) 
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-movida">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Gestor de usuarios') }}
                        </span>
                        <div class="float-right">
                            <a href="{{ route('usuario.agregar') }}" class="btn btn-dark btn-sm float-right mr-2"  data-placement="left">
                            <i class="fas fa-user-plus"></i> <!-- Icono de agregar -->
                                {{ __('Agregar') }}
                            </a>
                            <a href="{{ route('usuario.reporte') }}" class="btn btn-dark btn-sm float-right mr-2"  data-placement="left">
                                <i class="fa-solid fa-file-lines"></i> <!-- Icono de reporte -->
                                {{ __('Reporte') }}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Mensaje de ejecución realizada -->
                @if ($message = Session::get('success'))
                    <div id="success-message" class="alert alert-success m-4">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <!-- Cuerpo de la tabla de usuario -->
                <div class="card-body">

                    <div class="row text-center">
                        <div class="col-sm-12">
                            <h3>Total de usuarios: {{ $totalUsuarios }}</h3>
                        </div>
                    </div>
                    
                    <!-- Porcentaje de usuarios en cada categoría -->
                    @php
                    $porcentajeBienestar = ($usuariosBienestar / $totalUsuarios) * 100;
                    $porcentajeCoordinador = ($usuariosCoordinador / $totalUsuarios) * 100;
                    $porcentajeMaestro = ($usuariosMaestro / $totalUsuarios) * 100;
                    $porcentajeInvitado = ($usuariosInvitado / $totalUsuarios) * 100;
                    @endphp
                    <!-- Cuadros de categorías de usuarios -->
                    <div class="row text-center mb-4">
                        <div class="col-md-3 col-sm-6">
                            <div class="card card-category">
                                <div class="card-body">
                                    <h5 class="card-title">Bienestar</h5>
                                    <p class="card-text">{{ $usuariosBienestar }} usuarios ({{ number_format($porcentajeBienestar, 2) }}%)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card card-category">
                                <div class="card-body">
                                    <h5 class="card-title">Coordinador</h5>
                                    <p class="card-text">{{ $usuariosCoordinador }} usuarios ({{ number_format($porcentajeCoordinador, 2) }}%)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card card-category">
                                <div class="card-body">
                                    <h5 class="card-title">Maestro</h5>
                                    <p class="card-text">{{ $usuariosMaestro }} usuarios ({{ number_format($porcentajeMaestro, 2) }}%)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card card-category">
                                <div class="card-body">
                                    <h5 class="card-title">Invitado</h5>
                                    <p class="card-text">{{ $usuariosInvitado }} usuarios ({{ number_format($porcentajeInvitado, 2) }}%)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="table-container" class="table-responsive">
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
                                        <td class="col-legajo">{{ $usuario->Legajo }}</td>
                                        @php
                                        $nombreCompleto = $usuario->Nombre;
                                        $primerNombre = explode(' ', $nombreCompleto)[0]; // Toma el primer nombre
                                        $apellidoCompleto = $usuario->Apellido;
                                        $primerApellido = explode(' ', $apellidoCompleto)[0]; // Toma el primer nombre
                                        @endphp
                                        <td class="col-nombre">{{ $primerNombre }} {{ $primerApellido }}</td>
                                        <td class="col-categoria">{{ $usuario->Categoria }}</td>
                                        <td class="col-habilitado">@if($usuario->Habilitado == 1) <i class="fa-regular fa-circle-check" style="color: #00b415;"></i> @else <i class="fa-solid fa-ban" style="color: #fa0000;"></i> @endif</td>

                                        <td th class="col-opcion">
                                            <a class="btn btn-sm btn-primary" href="{{ route('usuario.presentacion',$usuario->id) }}"><i class="fas fa-user"></i></a>
                                            <a class="btn btn-sm btn-success" href="{{ route('usuario.editar',$usuario->id) }}"><i class="fa-solid fa-pencil"></i></a>
                                            <a class="btn btn-sm btn-danger" href="{{ route('usuario.confirmar',$usuario->id) }}"><i class="fa fa-fw fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Paginación de cada 10 usuarios -->
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
