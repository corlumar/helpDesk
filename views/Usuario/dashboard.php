<?php
require_once("../../config/conexion.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["usu_id"]) || $_SESSION["rol_id"] != 3) {
    header("Location: ../../login.php?m=3");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../Mainhead/head.php"); ?>
    <title>HelpDesk - Panel del Usuario</title>
</head>
<body class="with-side-menu">
    <?php require_once("../Mainheader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php"); ?>

    <div class="page-content">
        <div class="container-fluid">
            <h2>👤 Panel del Usuario</h2>
            <p>Hola <?php echo $_SESSION["usu_nom"] ?? 'Usuario'; ?>, aquí puedes gestionar tus tickets.</p>

            <div class="row">
                <div class="col-md-6">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Mis Tickets</h5>
                            <p class="card-text">Consulta los tickets que has enviado.</p>
                            <a href="../Ticket/lista_tickets.php" class="btn btn-light">Ir</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Nuevo Ticket</h5>
                            <p class="card-text">Crea un nuevo ticket para soporte técnico.</p>
                            <a href="../Ticket/nuevo_ticket.php" class="btn btn-light">Crear</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once("../MainJs/js.php"); ?>
</body>
</html>
