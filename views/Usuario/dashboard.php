<?php
require_once("../../config/conexion.php");
session_start();
if (!isset($_SESSION["usu_id"])) {
    header("Location: ../../login.php?m=3");
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once("../Mainhead/head.php"); ?>
    <title>Usuario - Panel</title>
</head>
<body>
    <?php require_once("../Mainheader/header.php"); ?>
    <?php require_once("../MainNav/nav.php"); ?>
    
    <div class="container mt-4">
        <h1>Bienvenido, <?php echo $_SESSION["usu_nom"]; ?></h1>
        <a href="lista_tickets_usuario.php" class="btn btn-primary">Ver mis tickets</a>
        <a href="nuevo_ticket.php" class="btn btn-success">Nuevo Ticket</a>
    </div>

    <?php require_once("../MainJs/js.php"); ?>
</body>
</html>
