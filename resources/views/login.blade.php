<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/Login.css'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Inicio</title>
</head>
<body class="cuerpo">

    <div class="contenedor-login">
        <form method="POST" action="{{ route('usuario.validar') }}" class="formulario-login">
            @csrf

            <!-- Icono de la escuela y título -->
            <div class="text-center mb-4">
                <i class="icono-escuela fas fa-school"></i>
                <h2 class="titulo-siupa">SIUPA</h2>
            </div>

            <!-- Campo de Legajo -->
            <div class="grupo-formulario">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" id="Legajo" name="Legajo" class="form-control" placeholder="Legajo">
                </div>
            </div>

            <!-- Campo de Contraseña -->
            <div class="grupo-formulario">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
                </div>
            </div>

            <!-- Botón de Iniciar Sesión -->
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>

            <!-- Mensaje de error -->
            @if ($errors->any())
            <div class="mensaje-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            <i class="icono-errores fas fa-exclamation-triangle"></i>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

        </form>
    </div>

</body>
</html>
