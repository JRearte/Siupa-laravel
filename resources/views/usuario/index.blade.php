@extends('layouts.principal')
@section('title', 'Gestor de usuarios')
@section('content')
@vite(['resources/css/tabla.css'])

    <div class="content-container">
        <!-- Incluir el listado de usuarios -->
        @include('usuario.listar', ['usuarios' => $usuarios])
        
        <!-- Incluir las estadísticas -->
        @include('usuario.estadistica', [
            'totalUsuarios' => $totalUsuarios,
            'usuariosBienestar' => $usuariosBienestar,
            'usuariosCoordinador' => $usuariosCoordinador,
            'usuariosMaestro' => $usuariosMaestro,
            'usuariosInvitado' => $usuariosInvitado,
            'porcentajeBienestar' => $porcentajeBienestar,
            'porcentajeCoordinador' => $porcentajeCoordinador,
            'porcentajeMaestro' => $porcentajeMaestro,
            'porcentajeInvitado' => $porcentajeInvitado,
        ])

    </div>
@endsection
