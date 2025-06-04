<?php
require_once("config/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Registro de Usuario</h2>
        <form id="registro_form" novalidate>
            <div class="mb-3">
                <label for="usu_nom" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="usu_nom" name="usu_nom" required>
                <div class="invalid-feedback">Por favor, ingresa tu nombre.</div>
            </div>
            <div class="mb-3">
                <label for="usu_correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="usu_correo" name="usu_correo" required>
                <div class="invalid-feedback">Por favor, ingresa un correo válido.</div>
            </div>
            <div class="mb-3">
                <label for="usu_pass" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="usu_pass" name="usu_pass" required>
                <div class="invalid-feedback">Por favor, ingresa una contraseña.</div>
            </div>
            <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="TU_SITE_KEY"></div>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("registro_form");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);

            try {
                const response = await fetch("procesar_registro.php", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    alert("Registro exitoso. Ahora puedes iniciar sesión.");
                    form.reset();
                    form.classList.remove('was-validated');
                } else {
                    alert(result.message);
                }
            } catch (error) {
                console.error("Error en el registro:", error);
                alert("Ocurrió un error al procesar el registro.");
            }
        });
    });
    </script>
</body>
</html>
