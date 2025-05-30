<?php
require_once("config/conexion.php");
require_once("models/Usuario.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = new Usuario();
    $usu_correo = $_POST["usu_correo"] ?? '';
    $usu_pass = $_POST["usu_pass"] ?? '';

    if (empty($usu_correo) || empty($usu_pass)) {
        header("Location: login.php?m=1"); // campos vacíos
        exit();
    }

    $datos = $usuario->login($usu_correo, $usu_pass);

    if (is_array($datos) && count($datos) > 0) {
        $_SESSION["usu_id"] = $datos["usu_id"];
        $_SESSION["usu_nom"] = $datos["usu_nom"];
        $_SESSION["rol_id"] = $datos["rol_id"];

        // Redirigir según el rol
        switch ($_SESSION["rol_id"]) {
            case 1: // Admin
                header("Location: views/Admin/dashboard.php");
                break;
            case 2: // Soporte
                header("Location: views/Soporte/dashboard.php");
                break;
            case 3: // Usuario
                header("Location: views/Usuario/dashboard.php");
                break;
            default:
                header("Location: login.php?m=4"); // Rol desconocido
                break;
        }
        exit();
    } else {
        header("Location: login.php?m=2"); // credenciales inválidas
        exit();
    }
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Mesa de Ayuda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 y Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #0062E6, #33AEFF);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
        }

        .login-title {
            font-weight: bold;
            color: #0062E6;
        }

        .form-control:focus {
            border-color: #0062E6;
            box-shadow: 0 0 0 0.2rem rgba(0, 98, 230, 0.25);
        }
    </style>
</head>
<body>

<div class="login-card">
    <h4 class="text-center login-title mb-4"><i class="fa fa-sign-in-alt me-2"></i>Iniciar Sesión</h4>

    <?php if (isset($_GET["m"])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>
            <?php
                switch ($_GET["m"]) {
                    case "1": echo "Usuario y/o contraseña incorrectos."; break;
                    case "2": echo "Los campos están vacíos."; break;
                    case "3": echo "Debe iniciar sesión para acceder."; break;
                }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <input type="hidden" name="enviar" value="si">

        <div class="mb-3">
            <label for="usu_correo" class="form-label">Correo Electrónico</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control" id="usu_correo" name="usu_correo" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="usu_pass" class="form-label">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" id="usu_pass" name="usu_pass" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="rol_id" class="form-label">Seleccionar Rol</label>
            <select name="rol_id" id="rol_id" class="form-select" required>
                <option value="">-- Seleccione un rol --</option>
                <option value="1">👑 Administrador</option>
                <option value="2">🛠️ Soporte</option>
                <option value="3">🙋 Usuario</option>
            </select>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <a href="#">¿Olvidaste tu contraseña?</a>
            <a href="#" id="btnsoporte">Soporte</a>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="fa fa-sign-in-alt me-2"></i> Acceder
        </button>
        
        <?php if (isset($_GET['login']) && $_GET['login'] === 'success'): ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: 'success',
            title: '¡Bienvenido!',
            text: 'Has iniciado sesión correctamente',
            confirmButtonText: 'Continuar',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        });
        </script>
        <?php endif; ?>

    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
