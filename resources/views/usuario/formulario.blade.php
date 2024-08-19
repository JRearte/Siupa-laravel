@section('title', 'Formulario de usuario')
<div class="formulario">
    <div class="row">
        <div class="col-12">

            <div class="form-group mb-3">
                <label for="legajo" class="form-label">{{ __('Legajo') }}</label>
                <input type="text" name="Legajo" class="form-control @error('Legajo') is-invalid @enderror" value="{{ old('Legajo', $usuario?->Legajo) }}" id="legajo" placeholder="Ejemplo: 1-37202750/17">
                {!! $errors->first('Legajo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

            <div class="form-group mb-3">
                <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
                <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror" value="{{ old('Nombre', $usuario?->Nombre) }}" id="nombre">
                {!! $errors->first('Nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

            <div class="form-group mb-3">
                <label for="apellido" class="form-label">{{ __('Apellido') }}</label>
                <input type="text" name="Apellido" class="form-control @error('Apellido') is-invalid @enderror" value="{{ old('Apellido', $usuario?->Apellido) }}" id="apellido">
                {!! $errors->first('Apellido', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

            <div class="form-group mb-3">
                <label for="categoria" class="form-label">{{ __('Categoria') }}</label>
                <select name="Categoria" class="form-select @error('Categoria') is-invalid @enderror" id="categoria">
                    <option class="opcion" value="Maestro" {{ (old('Categoria', $usuario?->Categoria) == 'Maestro') ? 'selected' : '' }}>Maestro</option>
                    <option class="opcion" value="Coordinador" {{ (old('Categoria', $usuario?->Categoria) == 'Coordinador') ? 'selected' : '' }}>Coordinador</option>
                    <option class="opcion" value="Bienestar" {{ (old('Categoria', $usuario?->Categoria) == 'Bienestar') ? 'selected' : '' }}>Bienestar</option>
                    <option class="opcion" value="Invitado" {{ (old('Categoria', $usuario?->Categoria) == 'Invitado') ? 'selected' : '' }}>Invitado</option>
                </select>
                {!! $errors->first('Categoria', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

            <div class="form-group mb-3">
                <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" maxlength="60">
                {!! $errors->first('password', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>
            
            <div class="form-group mb-3">
                <label for="habilitado" class="form-label">{{ __('Estado') }}</label>
                <select name="Habilitado" class="form-select @error('Habilitado') is-invalid @enderror" id="habilitado">
                    <option class="opcion" value="0" {{ old('Habilitado', $usuario?->Habilitado) == 0 ? 'selected' : '' }}>Deshabilitado</option>
                    <option class="opcion" value="1" {{ old('Habilitado', $usuario?->Habilitado) == 1 ? 'selected' : '' }}>Habilitado</option>
                </select>
                {!! $errors->first('Habilitado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

        </div>
        <div class="col-12 mt-3 text-center">
            <button type="submit" class="btn btn-primary">{{ __('Aceptar') }}</button>
            <a class="btn btn-secondary" href="{{ route('usuario.listar') }}">{{ __('Cancelar') }}</a>
        </div>
    </div>
</div>
