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
    <title>HelpDesk - Lista de Tickets</title>
</head>
<body class="with-side-menu">
    <?php require_once("../Mainheader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php"); ?>

    <div class="page-content">
        <div class="container-fluid">
            <h2>📋 <?php echo ($_SESSION["rol_id"] == 1 || $_SESSION["rol_id"] == 2) ? "Gestión de Tickets" : "Mis Tickets"; ?></h2>

            <input type="hidden" id="usu_idx" value="<?php echo $_SESSION["usu_id"]; ?>">
            <input type="hidden" id="rol_idx" value="<?php echo $_SESSION["rol_id"]; ?>">

            <div id="ticket_wrapper">
    <div class="mb-2">
        <input class="search form-control mb-2" placeholder="Buscar ticket...">
        <select class="form-control filter-categoria mb-2">
            <option value="">Todas las categorías</option>
        </select>
        <select class="form-control filter-usuario mb-2">
            <option value="">Todos los usuarios</option>
        </select>
        <div class="mb-2">
            <button class="btn btn-outline-primary filter-estado" data-estado="">Todos</button>
            <button class="btn btn-outline-primary filter-estado" data-estado="Abierto">Abiertos</button>
            <button class="btn btn-outline-secondary filter-estado" data-estado="Cerrado">Cerrados</button>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th class="sort" data-sort="ticket_id">N° Ticket</th>
                <th class="sort" data-sort="cat_nom">Categoría</th>
                <th class="sort" data-sort="ticket_titulo">Título</th>
                <th class="sort" data-sort="usuario">Usuario</th>
                <th class="sort" data-sort="fecha">Fecha</th>
                <th class="sort" data-sort="estado">Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody class="list" id="ticket_data"></tbody>
    </table>
</div>
    
        </div>
    </div>

    <?php require_once("../MainJs/js.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <script src="../../views/Ticket/consultarTicket.js"></script>
    
 <!-- Modal Editar Ticket -->
<div class="modal fade" id="modalEditarTicket" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="formEditarTicket">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarLabel">Editar Ticket</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">

          <input type="hidden" id="edit_ticket_id" name="ticket_id">
          
        <div class="mb-3">
            <label for="edit_ticket_titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="edit_ticket_titulo" name="ticket_titulo" required>
            <div class="invalid-feedback">El título es obligatorio.</div>
        </div>

        <div class="mb-3">
            <label for="edit_ticket_descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="edit_ticket_descripcion" name="ticket_descripcion" rows="4" required></textarea>
            <div class="invalid-feedback">La descripción es obligatoria y debe tener al menos 10 caracteres.
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>


</body>
</html>
