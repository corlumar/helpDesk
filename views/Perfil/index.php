<?php
require_once("../../config/conexion.php");
session_start();

if (!isset($_SESSION["usu_id"])) {
    header("Location: ../../index.php?m=3");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <?php require_once("../Mainhead/head.php"); ?>
    <title>HelpDesk - Perfil</title>
</head>
<body class="with-side-menu">

    <?php require_once("../Mainheader/header.php"); ?>

    <div class="mobile-menu-left-overlay"></div>

    <?php require_once("../MainNav/nav.php"); ?>

    <!-- CONTENIDO -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card text-center p-4 shadow-lg">
                        <img src="../../public/img/<?php echo $_SESSION["avatar"]; ?>" alt="Avatar" class="rounded-circle mx-auto" width="120" height="120">
                        <h3 class="mt-3"><?php echo $_SESSION["usu_nom"] . ' ' . $_SESSION["usu_ape"]; ?></h3>
                        <p class="text-muted"><?php echo $_SESSION["rol_nombre"]; ?></p>

                        <hr>

                        <div class="text-left mt-4">
                            <p><strong>Correo:</strong> <?php echo isset($_SESSION["usu_correo"]) ? $_SESSION["usu_correo"] : 'N/A'; ?></p>
                            <p><strong>ID Usuario:</strong> <?php echo $_SESSION["usu_id"]; ?></p>
                            <p><strong>Rol ID:</strong> <?php echo $_SESSION["rol_id"]; ?></p>
                        </div>

                        <a href="../Home/" class="btn btn-primary mt-3">Volver al Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENIDO -->

    <?php require_once("../MainJs/js.php"); ?>
</body>
</html>
