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
    <title>Ayuda</title>
</head>
<body class="with-side-menu">

    <?php require_once("../Mainheader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php"); ?>

    <div class="page-content">
        <div class="container-fluid">
            <h2>❓ Centro de Ayuda</h2>

            <div class="box-typical box-typical-padding">
                <p>Bienvenido al sistema HelpDesk de Andercode. Aquí puedes encontrar respuestas a preguntas frecuentes y cómo contactar con soporte.</p>

                <h5>📌 ¿Cómo creo un ticket?</h5>
                <p>Ve al menú <strong>"Mis Tickets"</strong> y haz clic en <strong>"Nuevo Ticket"</strong>. Completa el formulario y envíalo.</p>

                <h5>🔍 ¿Cómo puedo ver mis tickets?</h5>
                <p>En el menú lateral, entra en <strong>"Mis Tickets"</strong>. Ahí verás la lista de todos tus tickets abiertos y cerrados.</p>

                <h5>👨‍💻 ¿Cómo contacto al soporte?</h5>
                <p>Puedes escribir directamente a: <a href="mailto:soporte@andercode.com">soporte@andercode.com</a></p>

                <h5>⚙️ ¿Cómo actualizo mi perfil?</h5>
                <p>Haz clic en <strong>"Perfil"</strong> en el menú lateral y podrás ver tus datos. La edición estará disponible próximamente.</p>
            </div>
        </div>
    </div>

    <?php require_once("../MainJs/js.php"); ?>
</body>
</html>
