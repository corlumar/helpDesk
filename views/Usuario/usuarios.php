<?php
require_once("../../config/conexion.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["usu_id"]) || $_SESSION["rol_id"] != 1) {
    header("Location: ../../login.php?m=4"); // Rol no autorizado
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Usuarios Registrados</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tablaUsuarios">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos se cargarán aquí mediante Fetch API -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Editar Usuario -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="formEditarUsuario">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="edit_usu_id" name="usu_id">
              <div class="mb-3">
                <label for="edit_usu_nom" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="edit_usu_nom" name="usu_nom" required>
              </div>
              <div class="mb-3">
                <label for="edit_usu_correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="edit_usu_correo" name="usu_correo" required>
              </div>
              <div class="mb-3">
                <label for="edit_rol_id" class="form-label">Rol</label>
                <select class="form-select" id="edit_rol_id" name="rol_id" required>
                  <option value="1">Administrador</option>
                  <option value="2">Usuario</option>
                  <!-- Agrega más roles según tu sistema -->
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script para cargar y gestionar los usuarios -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const tablaUsuarios = document.querySelector("#tablaUsuarios tbody");
            const modalEditarUsuario = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
            const formEditarUsuario = document.getElementById("formEditarUsuario");

            // Función para cargar usuarios
            function cargarUsuarios() {
                fetch("procesar_usuarios.php")
                    .then(response => response.json())
                    .then(data => {
                        tablaUsuarios.innerHTML = "";
                        data.forEach(usuario => {
                            const tr = document.createElement("tr");
                            tr.innerHTML = `
                                <td>${usuario.usu_id}</td>
                                <td>${usuario.usu_nom}</td>
                                <td>${usuario.usu_correo}</td>
                                <td>${usuario.rol_nom}</td>
                                <td>${usuario.fecha_registro}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1 btnEditar" data-id="${usuario.usu_id}" data-nombre="${usuario.usu_nom}" data-correo="${usuario.usu_correo}" data-rol="${usuario.rol_id}">Editar</button>
                                    <button class="btn btn-sm btn-danger btnEliminar" data-id="${usuario.usu_id}">Eliminar</button>
                                </td>
                            `;
                            tablaUsuarios.appendChild(tr);
                        });

                        // Asignar eventos a los botones de editar
                        document.querySelectorAll(".btnEditar").forEach(button => {
                            button.addEventListener("click", () => {
                                document.getElementById("edit_usu_id").value = button.dataset.id;
                                document.getElementById("edit_usu_nom").value = button.dataset.nombre;
                                document.getElementById("edit_usu_correo").value = button.dataset.correo;
                                document.getElementById("edit_rol_id").value = button.dataset.rol;
                                modalEditarUsuario.show();
                            });
                        });

                        // Asignar eventos a los botones de eliminar
                        document.querySelectorAll(".btnEliminar").forEach(button => {
                            button.addEventListener("click", () => {
                                const usu_id = button.dataset.id;
                                Swal.fire({
                                    title: '¿Estás seguro?',
                                    text: "Esta acción no se puede deshacer.",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Sí, eliminar',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        fetch("procesar_usuarios.php", {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json"
                                            },
                                            body: JSON.stringify({ accion: "eliminar", usu_id })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                Swal.fire('Eliminado', data.message, 'success');
                                                cargarUsuarios();
                                            } else {
                                                Swal.fire('Error', data.message, 'error');
                                            }
                                        })
                                        .catch(error => {
                                            console.error("Error al eliminar el usuario:", error);
                                            Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
                                        });
                                    }
                                });
                            });
                        });
                    })
                    .catch(error => {
                        console.error("Error al cargar los usuarios:", error);
                    });
            }

            // Cargar usuarios al iniciar
            cargarUsuarios();

            // Manejar el envío del formulario de edición
            formEditarUsuario.addEventListener("submit", (e) => {
                e.preventDefault();
                const formData = new FormData(formEditarUsuario);
                formData.append("accion", "editar");

                fetch("procesar_usuarios.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Actualizado', data.message, 'success');
                        modalEditarUsuario.hide();
                        cargarUsuarios();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error("Error al editar el usuario:", error);
                    Swal.fire('Error', 'No se pudo actualizar el usuario.', 'error');
                });
            });
        });
    </script>
</body>
</html>
