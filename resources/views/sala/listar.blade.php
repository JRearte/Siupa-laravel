@extends('layouts.principal')
@section('title', 'Gestor de salas')
@section('content')
@vite(['resources/css/tabla.css']) 
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-movida">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Gestor de salas') }}
                        </span>
                        <div class="float-right">

                            <!-- AQUI VA EL REPORTE -->
                            <a href="{{ route('sala.agregar') }}" class="btn btn-dark btn-sm float-right mr-2"  data-placement="left">
                                <i class="fa-solid fa-plus"></i> <!-- Icono de agregar -->
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
                                    <th class="col-n">#</th>
                                    <th class="col-nombre">Nombre</th>
                                    <th class="col-opcion">Edad</th>
                                    <th class="col-opcion">Capacidad</th>
                                    <th class="col-opcion" >Infantes</th>
                                    <th class="col-opcion">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salas as $sala)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $sala->Nombre }}</td>
                                        <td class="col-opcion">{{ $sala->Edad }}</td>
                                        <td class="col-opcion">{{ $sala->Capacidad }}</td>
                                        <td class="col-opcion">{{ $sala->infantes_count }}</td>
                                        <td class="col-opcion">
                                            <form action="{{ route('sala.eliminar', $sala->id) }}" method="POST">
                                            <a class="btn btn-sm btn-success" href="{{ route('sala.editar',$sala->id) }}"><i class="fa-solid fa-pencil"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> </button>
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
                {!! $salas->links('vendor.pagination.bootstrap-4') !!}
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