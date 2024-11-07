<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container d-flex justify-content-between">
        <!-- Logo alineado a la izquierda -->
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('sep-ipn.png') }}" alt="Logo IPN" style="height: 130px; margin-right: 10px;">
        </a>

        <!-- Botón de colapso para pantallas pequeñas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Enlaces del menú -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard"><h4>Inicio</h4></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/usuarios/crear"><h4>Agregar usuario</h4></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/usuarios/list"><h4>Listado de usuarios</h4></a>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link text-white">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
    </div>
</nav>
<br><br><br><br><br><br><br><br>
