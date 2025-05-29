<?php
require_once("../../config/conexion.php");
session_start(); // <- asegúrate de tener esto si no está en conexion.php

if (!isset($_SESSION["usu_id"])) {
    header("Location: ../../index.php?m=3"); // Redirige si NO hay sesión
    exit();
}
?>
<!DOCTYPE html>
<html>
    <?php require_once("../Mainhead/head.php");?>	
    <title>HelpDesk - <?php echo $_SESSION["usu_nom"] . ' ' . $_SESSION["usu_ape"]; ?></title>

</head>
<body class="with-side-menu">

	<?php require_once("../Mainheader/header.php");?>
	
	<a href="../../logout.php" class="btn btn-danger">Cerrar sesión</a>


	<div class="mobile-menu-left-overlay"></div>
	
    <?php require_once("../MainNav/nav.php");?>
    
    <!-- CONTENIDO -->
    
	<div class="page-content">
		<div class="container-fluid">
			Blank page.
		</div>
	</div>
	
	<!-- CONTENIDO -->
	
    <?php require_once("../MainJs/js.php");?>
    
    <script type="text/javascript" src="home.js"></script>
	
</body>
</html>
