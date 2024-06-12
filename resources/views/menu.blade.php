<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/Menu.css'])
    <title>Menú Principal</title>
</head>
<body>
    <div class = "contenedor">

        <!--Usuario-->
        <div class="usuario">
        <a href="{{ route('usuario.listar') }}">
        <div class = "galeria">
        <center><img src = "{{ asset('imagen/usuario.png') }}" class = "imagen"></center>
        <label class = "texto">Usuario</label>
        <p>Persona con el rol de interactuar con las funciones que ofrece el sistema SIUpa. </p>
        </div></a></div>
        
        <!--Sala-->
        <div class="sala">
        <a href="{{ route('sala.listar') }}">
        <div class = "galeria">
        <center><img src = "{{ asset('imagen/sala.png') }}"class = "imagen"></center>
        <label class = "texto">Sala</label>
        <p>Dominio donde los niños y docentes realizaran las actividades del jardin maternal.</p>
        </div></a></div>

        <!--Tutor-->
        <div class="tutor">
        <a href="./GUI_Tutor.php">
        <div class = "galeria">
        <center><img src = "{{ asset('imagen/tutor.png') }}" class = "imagen"></center>
        <label class = "texto">Tutor</label>
        <p>Familiar a cargo del niño con un rol en el entorno universitario.</p>
        </div></a></div>

        <!--Niño-->
        <div class="niño">
        <a href="../GUI/Asistencia.php">
        <div class = "galeria">
        <center><img src = "{{ asset('imagen/niño.png') }}" class = "imagen"></center>
        <label class = "texto">Niño</label>
        <p>Infante que asiste al jardin maternal durante el periodo de cursadas.</p>
        </div></a></div>

        <!--Asistencia-->
        <div class="asistencia">
        <a href="../GUI/Asistencia.php">
        <div class = "galeria">
        <center><img src = "{{ asset('imagen/asistencia.png') }}" class = "imagen"></center>
        <label class = "texto">Asistencia</label>
        <p>Registro de todos los niños y usuarios que asistieron en el dia a dia de sus cursadas.</p>
        </div></a></div>

        <!--Reporte-->
        <div class="reporte">
        <a href="./GUI_Reporte.php">
        <div class = "galeria">
        <center><img src = "{{ asset('imagen/reporte.png') }}" class = "imagen"></center>
        <label class = "texto">Reporte</label>
        <p>Datos recopilados del sistema para su descarga en formato PDF </p>
        </div></a></div>
    </div>
</body>
</html>