<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/principal.css'])
    @vite(['resources/js/toast.js'])
    @vite(['resources/js/menu_desplegable.js'])

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Mensajes de alerta -->
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <!-- Toast de éxito -->
                @if (session('success'))
                    <div id="toastSuccess" class="toast toast-success align-items-center border-0 show" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <i class="fa-solid fa-circle-check icon"></i>
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                            <div class="progress-bar">
                                <div class="progress-bar-fill"></div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Toast de información -->
                @if (session('info'))
                    <div id="toastInfo" class="toast toast-info align-items-center border-0 show" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <i class="fa-solid fa-circle-info icon"></i>
                            <div class="toast-body">
                                {{ session('info') }}
                            </div>
                            <div class="progress-bar">
                                <div class="progress-bar-fill"></div>
                            </div>
                        </div>
                    </div>
                @endif


                <!-- Toast de error -->
                @if (session('error'))
                    <div id="toastError" class="toast toast-error align-items-center border-0 show" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <i class="fa-solid fa-circle-exclamation icon"></i>
                            <div class="toast-body">
                                {{ session('error') }}
                            </div>
                            <div class="progress-bar">
                                <div class="progress-bar-fill"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

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

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @yield('scripts')
</body>

</html>
