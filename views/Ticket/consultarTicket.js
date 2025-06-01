document.addEventListener("DOMContentLoaded", () => {
    const usu_id = document.getElementById("usu_idx")?.value;
    const rol_id = document.getElementById("rol_idx")?.value;

    if (!usu_id || !rol_id) {
        console.error("Usuario o rol no definidos");
        return;
    }

    listarTickets("Abierto");
    cargarFiltros();
    setupFormEditar();
});

let lista;

function listarTickets(estado) {
    const usu_id = document.getElementById("usu_idx").value;
    const rol_id = document.getElementById("rol_idx").value;

    const endpoint = rol_id == 3
        ? '../../controller/ticketController.php?op=listar_x_usu'
        : '../../controller/ticketController.php?op=listar';

    fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: rol_id == 3 ? `usu_id=${usu_id}` : ''
    })
        .then(res => res.text())
        .then(text => {
            if (!text || text.trim().startsWith('<')) throw new Error("Respuesta no válida");
            return JSON.parse(text);
        })
        .then(json => {
            const tbody = document.getElementById("ticket_data");
            tbody.innerHTML = "";

            json.data.forEach(row => {
                const tr = document.createElement("tr");
                const clases = ["ticket_id", "cat_nom", "ticket_titulo", "usuario", "fecha", "estado"];
                row.slice(0, 6).forEach((cell, i) => {
                    const td = document.createElement("td");
                    td.className = clases[i];
                    td.innerHTML = cell;
                    tr.appendChild(td);
                });

                const tdAccion = document.createElement("td");
                tdAccion.innerHTML = row[6];
                tr.appendChild(tdAccion);

                tbody.appendChild(tr);
            });

            inicializarListJS();
        })
        .catch(err => console.error("Error cargando tickets:", err));
}

function inicializarListJS() {
    if (lista) lista.destroy();

    lista = new List('ticket_wrapper', {
        valueNames: ['ticket_id', 'cat_nom', 'ticket_titulo', 'usuario', 'fecha', 'estado'],
        page: 10,
        pagination: true
    });

    document.querySelectorAll('.filter-estado').forEach(btn => {
        btn.addEventListener('click', () => {
            const estado = btn.dataset.estado.toLowerCase();
            lista.filter(item => {
                return estado === "" || item.values().estado.toLowerCase().includes(estado);
            });
        });
    });

    document.querySelector('.filter-categoria').addEventListener('change', function () {
        const filtro = this.value.toLowerCase();
        lista.filter(item => item.values().cat_nom.toLowerCase().includes(filtro));
    });

    document.querySelector('.filter-usuario').addEventListener('change', function () {
        const filtro = this.value.toLowerCase();
        lista.filter(item => item.values().usuario.toLowerCase().includes(filtro));
    });
}

function cargarFiltros() {
    fetch("../../controller/categoria.php?op=combo_json")
        .then(res => res.json())
        .then(data => {
            const select = document.querySelector(".filter-categoria");
            data.forEach(cat => {
                select.innerHTML += `<option value="${cat.cat_nom}">${cat.cat_nom}</option>`;
            });
        });

    fetch("../../controller/usuario.php?op=listar_combo")
        .then(res => res.json())
        .then(data => {
            const select = document.querySelector(".filter-usuario");
            data.forEach(user => {
                const nombre = `${user.usu_nom} ${user.usu_ape}`;
                select.innerHTML += `<option value="${nombre}">${nombre}</option>`;
            });
        });
}

function ver(id) {
    window.location.href = `detalle_ticket.php?id=${id}`;
}

function cerrar(ticket_id) {
    if (!confirm("¿Cerrar este ticket?")) return;

    fetch('../../controller/ticketController.php?op=cerrar', {
        method: "POST",
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `ticket_id=${ticket_id}`
    })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            listarTickets("Abierto");
        })
        .catch(err => console.error("Error al cerrar:", err));
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
            console.error("Error al cargar ticket para edición:", err);
        });
}

function setupFormEditar() {
    const form = document.getElementById("formEditarTicket");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const ticket_id = document.getElementById('edit_ticket_id').value;
        const titulo = document.getElementById('edit_ticket_titulo').value.trim();
        const descripcion = document.getElementById('edit_ticket_descripcion').value.trim();

        if (!titulo || !descripcion) {
            Swal.fire({ icon: 'warning', title: 'Campos vacíos', text: 'Completa todos los campos' });
            return;
        }

        const formData = new URLSearchParams();
        formData.append("ticket_id", ticket_id);
        formData.append("ticket_titulo", titulo);
        formData.append("ticket_descripcion", descripcion);

        fetch('../../controller/ticketController.php?op=actualizar', {
            method: "POST",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({ icon: 'success', title: 'Actualizado', text: data.message });
                    bootstrap.Modal.getInstance(document.getElementById("modalEditarTicket")).hide();
                    listarTickets("Abierto");
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.message });
                }
            })
            .catch(err => {
                console.error("Error al actualizar ticket:", err);
                Swal.fire({ icon: 'error', title: 'Error', text: 'Error inesperado.' });
            });
    });
}
