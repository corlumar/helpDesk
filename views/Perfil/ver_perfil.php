<?php
require_once("../../config/conexion.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["usu_id"])) {
    header("Location: ../../login.php?m=3");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../Mainhead/head.php"); ?>
    <title>Mi Perfil</title>
</head>
<body class="with-side-menu">

    <?php require_once("../Mainheader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php"); ?>

    <div class="page-content">
        <div class="container-fluid">
            <h2>👤 Mi Perfil</h2>

            <div class="box-typical box-typical-padding">
                <div class="text-center">
                    <img src="../../public/img/<?php echo $_SESSION["avatar"]; ?>" class="rounded-circle" width="100" alt="Avatar">
                </div>

                <table class="table mt-4">
                    <tr>
                        <th>Nombre:</th>
                        <td><?php echo $_SESSION["usu_nom"]; ?></td>
                    </tr>
                    <tr>
                        <th>Apellido:</th>
                        <td><?php echo $_SESSION["usu_ape"]; ?></td>
                    </tr>
                    <tr>
                        <th>Correo:</th>
                        <td><?php echo $_SESSION["usu_id"]; ?>@andercode.com</td> <!-- Puedes ajustar esto si guardas el correo -->
                    </tr>
                    <tr>
                        <th>Rol:</th>
                        <td><?php echo $_SESSION["rol_nombre"]; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <?php require_once("../MainJs/js.php"); ?>
</body>
</html>

