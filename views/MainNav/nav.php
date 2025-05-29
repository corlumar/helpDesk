<aside class="sidebar bg-light border-end vh-100" id="sidebarMenu" style="width: 250px; position: fixed;">
    <div class="sidebar-header text-center py-4">
        
        <!-- Logo -->
        <div class="text-center py-3 border-bottom">
            <a href="../Home/inicio.php">
                <img src="../../public/img/logo-2.png" alt="Logo" height="50">
            </a>
        </div>

        <!-- Panel de usuario -->
    <div class="text-center px-3 pb-3">
        <img src="../../public/img/<?php echo $_SESSION["avatar"]; ?>" class="rounded-circle mb-2" width="60" height="60" alt="Avatar">
        <h6 class="mb-0"><?php echo $_SESSION["usu_nom"] . ' ' . $_SESSION["usu_ape"]; ?></h6>
        <small class="text-muted"><?php echo $_SESSION["rol_nombre"]; ?></small>
    </div>

        <!-- Menú -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="../Home/inicio.php">
                <i class="bi bi-house"></i> Inicio
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../Perfil/ver_perfil.php">
                <i class="bi bi-person"></i> Perfil
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../Ayuda/ayuda.php">
                <i class="bi bi-question-circle"></i> Ayuda
            </a>
        </li>

            <?php if ($_SESSION["rol_id"] == 1 || $_SESSION["rol_id"] == 2): ?>
                <li class="nav-item">
                    <a class="nav-link" href="../Ticket/lista_tickets.php">
                        <i class="bi bi-card-list"></i> Gestión de Tickets
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link" href="../Ticket/consultar_ticket.php">
                    <i class="bi bi-journal-text"></i>Mis Tickets
                </a>
            </li>

            <li class="nav-item mt-auto">
                <a class="nav-link text-danger" href="../../logout.php" onclick="return confirm('¿Estás seguro que deseas cerrar sesión?');">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </a>
            </li>
        </ul>

    </div>
</aside>
