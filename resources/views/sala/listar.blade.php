@extends('layouts.principal')
@section('title', 'Gestor de sala')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Gestor de salas') }}
                        </span>
                        <div class="float-right">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm float-right mr-2"  data-placement="left">
                                <i class="fas fa-sign-out-alt"></i> <!-- Icono de salida -->
                            </a>
                            <a href="{{ route('sala.agregar') }}" class="btn btn-dark btn-sm float-right mr-2"  data-placement="left">
                            <i class="fas fa-user-plus" style="color: #ffffff;"></i> <!-- Icono de agregar -->
                                {{ __('Agregar') }}
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
                                    <th>Nombre</th>
                                    <th>Edad</th>
                                    <th>Capacidad</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salas as $sala)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $sala->Nombre }}</td>
                                        <td>{{ $sala->Edad }}</td>
                                        <td>{{ $sala->Capacidad }}</td>
                                        <td>
                                            <form action="{{ route('sala.eliminar', $sala->id) }}" method="POST">
                                            <a class="btn btn-sm btn-success" href="{{ route('sala.editar',$sala->id) }}"><i class="fas fa-user-edit" style="color: #ffffff;"></i> {{ __('Modificar') }}</a>
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
            {!! $salas->links() !!}
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