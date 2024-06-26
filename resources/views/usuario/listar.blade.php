@extends('layouts.principal')
@section('title', 'Gestor de Usuarios')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Gestor de usuarios') }}
                        </span>
                        <div class="text-center" style="background: #94C1D9; border:none;">
                        <div class="card p-2" style="background: #94C1D9; border:none;"> <!-- Reducido el padding a p-2 -->
                            <div class="d-flex align-items-center">
                                <div class="user-icon mr-2"> <!-- Reducido el margin a mr-2 -->
                                    <i class="fas fa-user-circle fa-lg"></i> <!-- Tamaño grande de icono -->
                                </div>
                                <div>
                                    @if (Auth::check())
                                        <p class="mb-0">{{ Auth::user()->Nombre }} {{ Auth::user()->Apellido }}</p> 
                                    @else
                                        <p class="mb-0">No estás autenticado</p> 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="float-right">
                            <a href="{{ route('usuario.logout') }}" class="btn btn-primary btn-sm float-right mr-2"  data-placement="left"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit(); ">
                                <i class="fas fa-sign-out-alt"></i> <!-- Icono de salida -->
                            </a>
                            <form id = "logout-form" action="{{ route('usuario.logout') }}" method="post" style="display:none; ">@csrf</form>
                            <a href="{{ route('menu') }}" class="btn btn-primary btn-sm float-right mr-2"  data-placement="left">
                                <i class="fas fa-home"></i> <!-- Icono de menu -->
                            </a>
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
                                    <th>No</th>
                                    <th>Legajo</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Categoria</th>
                                    <th>Habilitado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $usuario->Legajo }}</td>
                                        <td>{{ $usuario->Nombre }}</td>
                                        <td>{{ $usuario->Apellido }}</td>
                                        <td>{{ $usuario->Categoria }}</td>
                                        <td>@if($usuario->Habilitado == 1) Activado @else Desactivado @endif</td>
                                        <td>
                                            <form action="{{ route('usuario.eliminar', $usuario->id) }}" method="POST">
                                                <a class="btn btn-sm btn-success" href="{{ route('usuario.editar',$usuario->id) }}"><i class="fas fa-user-edit" style="color: #ffffff;"></i> {{ __('Modificar') }}</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                            </form>
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
