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
    <title>HelpDesk - Nuevo Ticket</title>
</head>
<body class="with-side-menu">

    <?php require_once("../Mainheader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php"); ?>

    <div class="page-content">
        <div class="container-fluid">
            <h2>📝 Crear Nuevo Ticket</h2>

            <form id="ticket_form" class="mt-4">
                <input type="hidden" name="usu_id" id="usu_id" value="<?php echo $_SESSION['usu_id']; ?>">

                <div class="mb-3">
                    <label for="cat_id" class="form-label">Categoría</label>
                    <select class="form-select" id="cat_id" name="cat_id" required>
                        <!-- Se llena con JS -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="ticket_titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="ticket_titulo" name="ticket_titulo" placeholder="Título del ticket" required>
                </div>

                <div class="mb-3">
                    <label for="ticket_descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="ticket_descripcion" name="ticket_descripcion" rows="4" placeholder="Describa el problema o solicitud" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Enviar Ticket</button>
            </form>
        </div>
    </div>

    <?php require_once("../MainJs/js.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../views/Ticket/nuevoTicket.js"></script>

</body>
</html>
