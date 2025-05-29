document.addEventListener("DOMContentLoaded", function () {
    const usu_id = document.getElementById("usu_idx")?.value;
    const rol_id = document.getElementById("rol_idx")?.value;

    if (!usu_id || !rol_id) {
        console.error("Error: usu_id o rol_id undefined");
        return;
    }

    listarTickets("Abierto");

    const formEditar = document.getElementById("formEditarTicket");
    if (formEditar) {
        formEditar.addEventListener("submit", function (e) {
            e.preventDefault();

            const ticket_id = document.getElementById('edit_ticket_id').value;
            const titulo = document.getElementById('edit_ticket_titulo').value.trim();
            const descripcion = document.getElementById('edit_ticket_descripcion').value.trim();

            if (!titulo || !descripcion) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos vacíos',
                    text: 'Por favor completa todos los campos.'
                });
                return;
            }

            const formData = new URLSearchParams();
            formData.append("ticket_id", ticket_id);
            formData.append("ticket_titulo", titulo);
            formData.append("ticket_descripcion", descripcion);

            fetch('../../controller/ticketController.php?op=actualizar', {
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Ticket actualizado!',
                            text: 'Los cambios se guardaron correctamente.'
                        });
                        bootstrap.Modal.getInstance(document.getElementById("modalEditarTicket")).hide();
                        listarTickets("Abierto");
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo actualizar el ticket.'
                        });
                    }
                })
                .catch(error => {
                    console.error("Error al guardar los cambios:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error inesperado',
                        text: 'Hubo un problema al conectar con el servidor.'
                    });
                });
        });
    }
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
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: isUsuario ? `usu_id=${usu_id}` : ''
    })
        .then(response => response.text())
        .then(text => {
            console.log("Respuesta cruda del servidor:", text);
            if (!text || text.trim().startsWith("<")) throw new Error("Se recibió HTML, no JSON");
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

                const tdAcciones = document.createElement("td");

                const btnVer = document.createElement("button");
                btnVer.className = "btn btn-primary btn-sm";
                btnVer.innerHTML = '<i class="fa fa-eye"></i>';
                btnVer.onclick = () => ver(row[0]);
                tdAcciones.appendChild(btnVer);

                if (isAdmin || isUsuario) {
                    const btnEditar = document.createElement("button");
                    btnEditar.className = "btn btn-warning btn-sm ms-2";
                    btnEditar.innerHTML = '<i class="fa fa-edit"></i>';
                    btnEditar.onclick = () => editar(row[0]);
                    tdAcciones.appendChild(btnEditar);
                }

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
}

function ver(ticket_id) {
    window.location.href = `detalle_ticket.php?id=${ticket_id}`;
}

function cerrar(ticket_id) {
    if (!confirm("¿Estás seguro de que deseas cerrar este ticket?")) return;

    fetch('../../controller/ticketController.php?op=cerrar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `ticket_id=${ticket_id}`
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            listarTickets("Abierto");
        })
        .catch(error => {
            console.error("Error al cerrar el ticket:", error);
        });
}

function editar(ticket_id) {
    fetch(`../../controller/ticketController.php?op=obtener&ticket_id=${ticket_id}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById("edit_ticket_id").value = data.ticket_id;
            document.getElementById("edit_ticket_titulo").value = data.ticket_titulo;
            document.getElementById("edit_ticket_descripcion").value = data.ticket_descripcion;

            new bootstrap.Modal(document.getElementById('modalEditarTicket')).show();
        })
        .catch(err => {
            console.error("Error al obtener ticket para editar:", err);
            Swal.fire("Error", "No se pudo cargar el ticket", "error");
        });
}

