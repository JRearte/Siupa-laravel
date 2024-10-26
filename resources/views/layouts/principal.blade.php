<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
    <title>@yield('title', 'Default Title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Cargando Bootstrap y FontAwesome desde tu instalación interna -->
    @vite(['resources/css/principal.css'])
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2">
                @include('layouts.sidebar')
            </div>

            <!-- Contenido Principal -->
            <main id="main-content" class="col-md-10">
                @yield('content')
            </main>
        </div>
    </div>
    <!-- jQuery (opcional, pero necesario para algunos componentes de Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Popper.js para Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>



    <script>
        /*
        document.addEventListener('DOMContentLoaded', function () {
            // Recupera la posición de scroll almacenada
            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, scrollPosition);
                localStorage.removeItem('scrollPosition'); // Limpiar después de usar
            }
        
            // Recupera el número de página almacenado
            const pageNumber = localStorage.getItem('pageNumber');
            if (pageNumber) {
                const paginationLinks = document.querySelectorAll('.pagination a');
                paginationLinks.forEach(link => {
                    if (link.href.includes(`page=${pageNumber}`)) {
                        link.click(); // Hace clic en el enlace de la página guardada
                    }
                });
            }
        });
        
        window.addEventListener('click', function (event) {
            if (event.target.matches('.pagination a')) {
                // Guarda el número de página cuando el usuario hace clic en la paginación
                const pageNumber = new URL(event.target.href).searchParams.get('page');
                localStorage.setItem('pageNumber', pageNumber);
            }
        });
        
        window.addEventListener('beforeunload', function () {
            // Guarda la posición de scroll antes de descargar la página
            localStorage.setItem('scrollPosition', window.scrollY);
        });
        */
        </script>

    @yield('scripts')
    
</body>
</html>
