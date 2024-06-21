<!-- resources/views/reporte/usuarioReporte.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Usuarios</title>
    <style>
        /* Añade tus estilos personalizados aquí */
        @page {margin: 2.5cm 1.5cm 1.5cm 1.5cm;}
        header {position: fixed; top: -2.5cm; left: -1.5cm; width: 120%; height: 2.5cm; border-bottom: solid 1px black;}
        footer {position: fixed; bottom: -1.5cm; left: -1.5cm; width: 120%; height: 1.5cm; border-top: solid 1px black;}
        .numero { width: 0.2cm; text-align: center;}
        .contador { width: 0.2cm; text-align:  center;}
        body { font-family: Arial, sans-serif;}
        table { width: 100%; border-collapse: collapse; position: relative; top: 0cm;}
        th, td { width: 16%; border: 1px solid black; padding: 8px; text-align: center;}
        th { background-color: #f2f2f2; }
       
        .content { margin: 1cm 0cm 1cm 0cm; }
    </style>
</head>
<body>
    <header>
      <h1></h1> 
    </header>
    <div class="content">
    
        <table>
            <thead>
                <tr>
                    <th class = 'numero'>No</th>
                    <th>Legajo</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Categoria</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 0; @endphp
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td class = 'contador'>{{ ++$i }}</td>
                        <td>{{ $usuario->Legajo }}</td>
                        <td>{{ $usuario->Nombre }}</td>
                        <td>{{ $usuario->Apellido }}</td>
                        <td>{{ $usuario->Categoria }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <footer>
        <h1></h1>
    </footer>
</body>
</html>
