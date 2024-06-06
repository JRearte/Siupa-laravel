@extends('layouts.app')

@section('template_title')
    Sala
@endsection

@section('content')
    <div class="container">
        <div class="header">
            <h2>Gestor de salas</h2>
            <a href="{{ route('sala.agregar') }}" class="btn btn-primary">Agregar</a>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="content">
            <table class="table">
                <thead>
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
                                    <a href="{{ route('sala.editar', $sala->id) }}" class="btn">Modificar</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {!! $salas->links() !!}
        </div>
    </div>

    <style>
        .container {
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .content {
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination .page-link {
            padding: 8px 16px;
            margin: 0 2px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .pagination .page-link:hover {
            background-color: #0056b3;
        }
        .btn {
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .btn-danger {
            background-color: #dc3545;
        }
    </style>
@endsection
