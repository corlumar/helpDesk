<?php
require_once("../../config/conexion.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["usu_id"]) || $_SESSION["rol_id"] != 2) {
    header("Location: ../../login.php?m=3");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../Mainhead/head.php"); ?>
    <title>HelpDesk - Panel de Soporte</title>
</head>
<body class="with-side-menu">
    <?php require_once("../Mainheader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php"); ?>

    <div class="page-content">
        <div class="container-fluid">
            <h2>🔧 Panel de Soporte</h2>
            <p>Bienvenido, <?php echo $_SESSION["usu_nom"] ?? 'Soporte'; ?>.</p>

            <div class="row">
                <div class="col-md-6">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Ver Tickets</h5>
                            <p class="card-text">Consulta y gestiona tickets asignados.</p>
                            <a href="../Ticket/lista_tickets.php" class="btn btn-light">Ir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once("../MainJs/js.php"); ?>
</body>
</html>

