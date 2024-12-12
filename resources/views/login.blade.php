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

    <div class="contenedor-principal">
        <!-- Lado izquierdo: Login -->
        <div class="lado-izquierdo">
            <form method="POST" action="{{ route('usuario.validar') }}" class="formulario-login">
                @csrf

                <!-- Icono y Título -->
                <div class="text-center mb-4">
                    <i class="icono-escuela fas fa-school"></i>
                    <h2 class="titulo">BIENVENIDO</h2>
                    <h3 class="subtitulo">Sistema de Información UPA</h3>
                </div>

                <!-- Campos de formulario -->
                <div class="grupo-formulario">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" id="Legajo" name="Legajo" class="form-control" placeholder="Legajo">
                    </div>
                </div>

                <div class="grupo-formulario">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Contraseña">
                    </div>
                </div>

                <!-- Botón -->
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>

                <!-- Mensaje de error -->
                <div class="mensaje-container">
                    @if ($errors->any())
                        <div class="mensaje-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif
                </div>
            </form>

            <p class="separador"> _____________________________ Contactos _____________________________</p>

            <!-- Botones de contacto -->
            <div class="contactos">
                <a href="https://www.facebook.com/UnidadAcademicaRioTurbio" class="btn-contacto facebook"
                    target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.instagram.com/uart_unpa/" class="btn-contacto instagram" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="mailto:email@example.com" class="btn-contacto gmail" target="_blank">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="https://www.linkedin.com/in/jonatan-rearte-078b5a233/" class="btn-contacto linkedin"
                    target="_blank">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
