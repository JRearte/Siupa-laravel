@extends('layouts.principal')
@section('title', 'Carta de usuario')
@section('content')
@vite(['resources/css/presentacion.css'])
<div class="presentacion">
    <div class="container">
        <div class="card">
            <div class="card-header">Información de usuario</div>
            <div class="card-body">
                <p class="card-text"><strong>Legajo:</strong> {{ $usuario->Legajo }}</p>
                <p class="card-text"><strong>Nombre:</strong> {{ $usuario->Nombre }}</p>
                <p class="card-text"><strong>Apellido:</strong> {{ $usuario->Apellido }}</p>
                <p class="card-text"><strong>Categoría:</strong> {{ $usuario->Categoria }}</p>
                <p class="card-text"><strong>Estado:</strong> {{ $usuario->Habilitado ? 'Habilitado' : 'Deshabilitado' }}</p>
                <p class="card-text"><strong>Fecha de creación:</strong> {{ $usuario->created_at->format('d/m/Y H:i:s') }}</p>
                <p class="card-text"><strong>Última modificación:</strong> {{ $usuario->updated_at->format('d/m/Y H:i:s') }}</p>
            </div>
            <a href="{{ route('usuario.index') }}" class="btn btn-primary mt-3">Volver</a>
        </div>
    </div>
</div>
@endsection