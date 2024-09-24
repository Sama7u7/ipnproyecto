<!-- ESTE ES LA PLANTILLA PRINCIPAL DE LA PAGINA  -->
<!DOCTYPE html>
<html lang="es">
<head>
<header>
        
        <!-- Header de la pagina -->
        @include('partials.menu')
     </header>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Aquí puedes agregar tus estilos CSS -->
    <link href="{{ asset('css/style3.css') }}"  rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #6c1d45;padding-left: 40px;
        }
        .navbar-brand {
            color: #fff;
            padding-left: 40px;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: #fff;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
</head>
<body>
   

    <main>
        <!-- Aquí se incluirá el contenido específico de cada página -->
        @yield('content')
    </main>

    <footer>
        <!-- Aquí puedes agregar el contenido del pie de página que se repetirá en todas las páginas -->
        @include('partials.footer')
    </footer>

    <!-- Aquí puedes incluir tus scripts JavaScript -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>