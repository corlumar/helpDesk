document.addEventListener("DOMContentLoaded", () => {
    cargarCategorias();

    const form = document.getElementById("ticket_form");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const titulo = document.getElementById("ticket_titulo").value.trim();
        const descripcion = document.getElementById("ticket_descripcion").value.trim();
        const cat_id = document.getElementById("cat_id").value;

        if (!titulo || !descripcion || !cat_id) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor completa todos los campos obligatorios.'
            });
            return;
        }

        const formData = new FormData(form);

        try {
            const res = await fetch("../../controller/ticketController.php?op=insert", {
                method: "POST",
                body: formData
            });

            const data = await res.json();

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Ticket registrado',
                    text: data.message || 'El ticket se ha creado correctamente.'
                });

                form.reset();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'No se pudo registrar el ticket.'
                });
            }
        } catch (err) {
            console.error("Error al enviar el ticket:", err);
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor.'
            });
        }
    });
});

async function cargarCategorias() {
    try {
        const res = await fetch("../../controller/categoria.php?op=combo");
        const html = await res.text();
        document.getElementById("cat_id").innerHTML = html;
    } catch (error) {
        console.error("Error al cargar las categorías:", error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar las categorías.'
        });
    }
}
