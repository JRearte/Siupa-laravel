@extends('layouts.app')
<!--@vite(['resources/css/Formulario.css'])-->
<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="legajo" class="form-label">{{ __('Legajo') }}</label>
            <input type="text" name="Legajo" class="form-control @error('Legajo') is-invalid @enderror" value="{{ old('Legajo', $usuario?->Legajo) }}" id="legajo" placeholder = "Ejemplo: 1-37202750/17">
            {!! $errors->first('Legajo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror" value="{{ old('Nombre', $usuario?->Nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('Nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="apellido" class="form-label">{{ __('Apellido') }}</label>
            <input type="text" name="Apellido" class="form-control @error('Apellido') is-invalid @enderror" value="{{ old('Apellido', $usuario?->Apellido) }}" id="apellido" placeholder="Apellido">
            {!! $errors->first('Apellido', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="categoria" class="form-label">{{ __('Categoria') }}</label>
            <select name="Categoria" class="form-select @error('Categoria') is-invalid @enderror" id="categoria">
                <option value="Maestro" {{ (old('Categoria', $usuario?->Categoria) == 'Maestro') ? 'selected' : '' }}>Maestro</option>
                <option value="Coordinador" {{ (old('Categoria', $usuario?->Categoria) == 'Coordinador') ? 'selected' : '' }}>Coordinador</option>
                <option value="Invitado" {{ (old('Categoria', $usuario?->Categoria) == 'Invitado') ? 'selected' : '' }}>Invitado</option>
                <option value="Bienestar" {{ (old('Categoria', $usuario?->Categoria) == 'Bienestar') ? 'selected' : '' }}>Bienestar</option>
            </select>
            {!! $errors->first('Categoria', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
            <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"  id="password" placeholder="Clave" maxlength="60">
            {!! $errors->first('password', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="habilitado" class="form-label">{{ __('Habilitado') }}</label>
            <select name="Habilitado" class="form-select @error('Habilitado') is-invalid @enderror" id="habilitado">
                <option value="1" {{ old('Habilitado', $usuario?->Habilitado) == 1 ? 'selected' : '' }}>Habilitado</option>
                <option value="0" {{ old('Habilitado', $usuario?->Habilitado) == 0 ? 'selected' : '' }}>Deshabilitado</option>
            </select>
            {!! $errors->first('Habilitado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Aceptar') }}</button>
        <a class="btn btn-primary" href="{{ route('usuario.listar') }}"> {{ __('Cancelar') }}</a>
    </div>
</div>