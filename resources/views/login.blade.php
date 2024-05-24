
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/Login.css'])
    <title>Inicio</title>
</head>
<body>

    <form method="POST" action="{{ route('usuario.validar') }}">

        @csrf

        <label for="Legajo">Legajo:</label>
        <input type="text" id="Legajo" name="Legajo">

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">

        <button type="submit">Iniciar Sesión</button>
        @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </ul>
        </div>
        @endif

    </form>

</body>
</html>

</body>
</html>