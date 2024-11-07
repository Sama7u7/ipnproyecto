<!-- ESTE ES LA PLANTILLA PRINCIPAL DE LA PAGINA  -->
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO IPN</title>
    <!-- Aquí puedes agregar tus estilos CSS -->
    <link href="{{ asset('css/style3.css') }}"  rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>


    <main>
        <!-- Aquí se incluirá el contenido específico de cada página -->
        @yield('content')
    </main>



    <!-- Aquí puedes incluir tus scripts JavaScript -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
