
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
}
