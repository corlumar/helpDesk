
document.addEventListener("DOMContentLoaded", function () {
    const usu_id = document.getElementById("usu_idx")?.value;
    const rol_id = document.getElementById("rol_idx")?.value;

    if (!usu_id || !rol_id) {
        console.error("Error: usu_id o rol_id undefined");
        return;
    }

    listarTickets("Abierto");
});

function listarTickets(estado) {
    const usu_id = document.getElementById("usu_idx")?.value;
    const rol_id = document.getElementById("rol_idx")?.value;

    const isAdmin = rol_id == 1;
    const isSoporte = rol_id == 2;
    const isUsuario = rol_id == 3;

    const endpoint = isUsuario
        ? '../../controller/ticketController.php?op=listar_x_usu'
        : '../../controller/ticketController.php?op=listar';

    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: isUsuario ? `usu_id=${usu_id}` : ''
    })
    .then(response => response.text())
    .then(text => {
        if (!text || text.trim() === '') throw new Error("Respuesta vacía del servidor");
        return JSON.parse(text);
    })
    .then(json => {
        const tbody = document.querySelector("#ticket_data");
        if (!tbody) throw new Error("Elemento tbody no encontrado");

        tbody.innerHTML = "";

        json.data.forEach(row => {
            const tr = document.createElement("tr");

            row.slice(0, 6).forEach(cell => {
                const td = document.createElement("td");
                td.innerHTML = cell;
                tr.appendChild(td);
            });

            // Columna Acciones
            const tdAcciones = document.createElement("td");

            // Botón Ver
            const btnVer = document.createElement("button");
                btnVer.className = "btn btn-primary btn-sm";
                btnVer.innerHTML = '<i class="fa fa-eye"></i>';
                btnVer.onclick = () => ver(row[0]);
                tdAcciones.appendChild(btnVer);

            function editar(ticket_id) {
            fetch('../../controller/ticketController.php?op=obtener_ticket', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `ticket_id=${ticket_id}`
            })
            .then(response => response.json())
            .then(data => {
                // Rellenar el formulario con los datos del ticket
                document.getElementById('ticket_id').value = data.ticket_id;
                document.getElementById('titulo').value = data.titulo;
                document.getElementById('descripcion').value = data.descripcion;
                document.getElementById('categoria_id').value = data.categoria_id;
                // Mostrar el modal
                $('#modalEditarTicket').modal('show');
            })
            .catch(error => {
                console.error('Error al obtener los datos del ticket:', error);
            });
        }

            // Cerrar (Admin y Soporte)
            if (isAdmin || isUsuario) {
            const btnEditar = document.createElement("button");
            btnEditar.className = "btn btn-warning btn-sm ms-2";
            btnEditar.innerHTML = '<i class="fa fa-edit"></i>';
            btnEditar.onclick = () => editar(row[0]);
            tdAcciones.appendChild(btnEditar);
        }

        // Botón Cerrar (solo para Admin y Soporte)
        if (isAdmin || isSoporte) {
            const btnCerrar = document.createElement("button");
            btnCerrar.className = "btn btn-danger btn-sm ms-2";
            btnCerrar.innerHTML = '<i class="fa fa-times"></i>';
            btnCerrar.onclick = () => cerrar(row[0]);
            tdAcciones.appendChild(btnCerrar);
        }

        tr.appendChild(tdAcciones);
        tbody.appendChild(tr);
        });
    })
    .catch(error => {
        console.error("Error al cargar los tickets:", error);
    });
    
function editar(ticket_id) {
    // Abre el modal (asegúrate de tener Bootstrap cargado)
    const modal = new bootstrap.Modal(document.getElementById('modalEditarTicket'));
    modal.show();

    // Limpia el formulario
    document.getElementById('edit_ticket_id').value = '';
    document.getElementById('edit_ticket_titulo').value = '';
    document.getElementById('edit_ticket_descripcion').value = '';

    // Fetch al backend para obtener los datos del ticket
    fetch(`../../controller/ticketController.php?op=obtener&id=${ticket_id}`)
        .then(response => response.json())
        .then(data => {
            if (data && data.ticket_id) {
                document.getElementById('edit_ticket_id').value = data.ticket_id;
                document.getElementById('edit_ticket_titulo').value = data.ticket_titulo;
                document.getElementById('edit_ticket_descripcion').value = data.ticket_descripcion;
            } else {
                alert("No se pudo cargar la información del ticket.");
            }
        })
        .catch(error => {
            console.error("Error al obtener los datos del ticket:", error);
            alert("Hubo un error al cargar los datos del ticket.");
        });
}

document.addEventListener("DOMContentLoaded", function () {
    const formEditar = document.getElementById("formEditarTicket");

    formEditar.addEventListener("submit", function (e) {
        e.preventDefault();

        const ticket_id = document.getElementById('edit_ticket_id').value;
        const titulo = document.getElementById('edit_ticket_titulo').value.trim();
        const descripcion = document.getElementById('edit_ticket_descripcion').value.trim();

        if (!titulo || !descripcion) {
            alert("Todos los campos son obligatorios.");
            return;
        }

        const formData = new URLSearchParams();
        formData.append("ticket_id", ticket_id);
        formData.append("ticket_titulo", titulo);
        formData.append("ticket_descripcion", descripcion);

        fetch('../../controller/ticketController.php?op=actualizar', {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formData.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Ticket actualizado correctamente.");
                bootstrap.Modal.getInstance(document.getElementById("modalEditarTicket")).hide();
                listarTickets("Abierto"); // Recarga la tabla
            } else {
                alert("Error al actualizar el ticket.");
            }
        })
        .catch(error => {
            console.error("Error al guardar los cambios:", error);
            alert("Error inesperado al actualizar.");
        });
    });
});


}
