<?php
require_once("../../config/conexion.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["usu_id"]) || $_SESSION["rol_id"] != 1) {
    header("Location: ../../login.php?m=3");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../Mainhead/head.php"); ?>
    <title>Gestión de Usuarios</title>
</head>
<body class="with-side-menu">
    <?php require_once("../Mainheader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php"); ?>

    <div class="page-content">
        <div class="container-fluid">
            <h2>👥 Gestión de Usuarios</h2>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#usuarioModal">Agregar Usuario</button>
            <table class="table table-bordered" id="tablaUsuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contenido dinámico -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Agregar/Editar Usuario -->
    <div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formUsuario">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="usuarioModalLabel">Agregar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="usu_id" name="usu_id">
                        <div class="mb-3">
                            <label for="usu_nom" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="usu_nom" name="usu_nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="usu_correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="usu_correo" name="usu_correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol_id" class="form-label">Rol</label>
                            <select class="form-select" id="rol_id" name="rol_id" required>
                                <option value="1">Administrador</option>
                                <option value="2">Usuario</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="usu_pass" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="usu_pass" name="usu_pass" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php require_once("../MainJs/js.php"); ?>
    <script src="../../controllers/usuario.js"></script>
</body>
</html>
