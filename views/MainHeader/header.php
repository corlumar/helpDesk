<!-- views/MainHeader/header.php -->
<header class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="../Home/inicio.php">
            <img src="../../public/img/logo-2.png" alt="Logo" height="40">
        </a>

        <!-- Botón hamburguesa para responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú desplegable -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../../public/img/<?php echo $_SESSION['avatar']; ?>" class="rounded-circle me-2" width="40" height="40">
                        <span><?php echo $_SESSION["usu_nom"] . ' ' . $_SESSION["usu_ape"]; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="../Perfil/ver_perfil.php">👤 Perfil</a></li>
                        <li><a class="dropdown-item" href="../Ayuda/ayuda.php">❓ Ayuda</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="../../logout.php" onclick="return confirm('¿Deseas cerrar sesión?');">🔒 Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
