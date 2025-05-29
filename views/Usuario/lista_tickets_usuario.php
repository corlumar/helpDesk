<?php
require_once("../../config/conexion.php");
session_start();
if (!isset($_SESSION["usu_id"]) || $_SESSION["rol_id"] != 3) {
    header("Location: ../../login.php?m=3");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../Mainhead/head.php"); ?>
    <title>Usuario - Mis Tickets</title>
</head>
<body>
    <?php require_once("../Mainheader/header.php"); ?>
    <?php require_once("../MainNav/nav.php"); ?>

    <div class="container mt-4">
        <h2>🎫 Mis Tickets</h2>
        <div id="ticket_wrapper_usuario"></div>
    </div>

    <?php require_once("../MainJs/js.php"); ?>
    <script src="../../views/Ticket/consultarTicket.js"></script>
    <script>document.addEventListener('DOMContentLoaded', () => listarTickets("usuario"));</script>
</body>
</html>
