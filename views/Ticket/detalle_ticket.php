<?php
require_once("../../config/conexion.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["usu_id"])) {
    header("Location: ../../login.php?m=3");
    exit();
}

// Verificar que se pasó un ticket_id
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    echo "<h3>Error: ticket no válido.</h3>";
    exit();
}

$ticket_id = intval($_GET["id"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../Mainhead/head.php"); ?>
    <title>HelpDesk - Detalle Ticket</title>
</head>
<body class="with-side-menu">

    <?php require_once("../Mainheader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php"); ?>

    <div class="page-content">
        <div class="container-fluid">
            <h2>🎫 Detalle del Ticket #<?php echo $ticket_id; ?></h2>

            <!-- Aquí irán los detalles cargados vía AJAX -->
            <div id="ticket_detalle" class="box-typical box-typical-padding">
                <p><strong>Cargando datos del ticket...</strong></p>
            </div>
        </div>
    </div>

    <?php require_once("../MainJs/js.php"); ?>
    <script>
        $(document).ready(function () {
            var ticket_id = <?php echo $ticket_id; ?>;
            $.post("../../controller/ticketController.php?op=detalle", { ticket_id: ticket_id }, function(data) {
                if (data.success) {
                    const t = data.ticket;
                    $("#ticket_detalle").html(`
                        <p><strong>Título:</strong> ${t.ticket_titulo}</p>
                        <p><strong>Descripción:</strong> ${t.ticket_descripcion}</p>
                        <p><strong>Estado:</strong> ${t.ticket_estado}</p>
                        <p><strong>Fecha de Creación:</strong> ${t.fecha_crea}</p>
                        <p><strong>Categoría:</strong> ${t.cat_nom}</p>
                        <p><strong>Usuario:</strong> ${t.usu_nom} ${t.usu_ape}</p>
                    `);
                } else {
                    $("#ticket_detalle").html(`<div class="alert alert-danger">${data.message}</div>`);
                }
            }, "json").fail(function(xhr, status, error) {
                console.error("Error al cargar ticket:", xhr.responseText);
                $("#ticket_detalle").html(`<div class="alert alert-danger">Error cargando datos.</div>`);
            });
        });
    </script>
</body>
</html>

