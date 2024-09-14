@section('title', 'Formulario de sala')
<div class="formulario">
    <div class="row">
        <div class="col-12">
        
            <div class="form-group mb-3">
                <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
                <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror" value="{{ old('Nombre', $sala?->Nombre) }}" id="nombre" placeholder="Nombre">
                {!! $errors->first('Nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

            <div class="form-group mb-3">
                <label for="edad" class="form-label">{{ __('Edad') }}</label>
                <input type="number" name="Edad" class="form-control @error('Edad') is-invalid @enderror" value="{{ old('Edad', $sala?->Edad) }}" id="edad" placeholder="Edad">
                {!! $errors->first('Edad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

            <div class="form-group mb-3">
                <label for="capacidad" class="form-label">{{ __('Caoacidad') }}</label>
                <input type="number" name="Capacidad" class="form-control @error('Capacidad') is-invalid @enderror" value="{{ old('Capacidad', $sala?->Capacidad) }}" id="capacidad" placeholder="Capacidad">
                {!! $errors->first('Capacidad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

        </div>
            <div class="col-12 mt-3 text-center">
            <button type="submit" class="btn btn-primary">{{ __('Aceptar') }}</button>
            <a class="btn btn-primary" href="{{ route('sala.listar') }}"> {{ __('Cancelar') }}</a>
        </div>
    </div>
</div>