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
    <title>Nuevo Ticket</title>
</head>
<body class="with-side-menu">

    <?php require_once("../Mainheader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php"); ?>

    <div class="page-content">
        <div class="container-fluid">
            <h2>🆕 Crear Nuevo Ticket</h2>

            <div class="box-typical box-typical-padding">
                <form id="formulario_ticket">
                    <input type="hidden" name="usu_id" value="<?php echo $_SESSION["usu_id"]; ?>">

                    <div class="form-group">
                        <label>Categoría:</label>
                        <select id="cat_id" name="cat_id" class="form-control" required>
                            <!-- Categorías se cargarán con JS -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Título del Ticket:</label>
                        <input type="text" name="ticket_titulo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea name="ticket_descripcion" class="form-control" rows="5" required></textarea>
                    </div>

                    <input type="hidden" name="ticket_estado" value="Abierto">

                    <button type="submit" class="btn btn-success">Guardar Ticket</button>
                </form>
            </div>
        </div>
    </div>

    <?php require_once("../MainJs/js.php"); ?>
    <script>
        $(document).ready(function () {
            // Cargar categorías
            $.post("../../controller/categoriaController.php?op=select", function(data) {
                $("#cat_id").html(data);
            });

            // Guardar ticket
            $("#formulario_ticket").submit(function(e) {
                e.preventDefault();
                $.post("../../controller/ticketController.php?op=insert", $(this).serialize(), function(response) {
                    if (response.success) {
                        Swal.fire("Éxito", "Ticket registrado correctamente", "success")
                            .then(() => window.location.href = "lista_tickets.php");
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                }, "json").fail(function() {
                    Swal.fire("Error", "No se pudo registrar el ticket", "error");
                });
            });
        });
    </script>
</body>
</html>
