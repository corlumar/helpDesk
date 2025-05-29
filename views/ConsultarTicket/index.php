<?php
	require_once("../../config/conexion.php");
	 session_start();
	 
		
	if(isset($_SESSION["usu_id"])){
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once("../Mainhead/head.php");?>	
    <title>HelpDesk - Consultar Ticket</title>
</head>
<body class="with-side-menu">
	$_SESSION['usu_id'];
	$_SESSION['rol_id'];
	
	<?php require_once("../Mainheader/header.php");?>

	<div class="mobile-menu-left-overlay"></div>
	
    <?php require_once("../MainNav/nav.php");?>
    
    <input type="hidden" id="usu_idx" value="<?php echo $_SESSION['usu_id'];?>">
	<input type="hidden" id="rol_idx" value="<?php echo $_SESSION['rol_id'];?>">
    
    <!-- CONTENIDO -->
    
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Consultar Ticket</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Consultar Ticket</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			 <div class="box-typical box-typical-padding">
			 
			<div class="mb-3">
				<button class="btn btn-outline-primary" onclick="listarTickets('Abierto')">Ver Abiertos</button>
				<button class="btn btn-outline-secondary" onclick="listarTickets('Cerrado')">Ver Cerrados</button>
			</div>
			 
				<table id="ticket_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<th style="width: 5%;">Número Ticket</th>
							<th style="width: 15%;">Categoría</th>
							<th style="width: 20%;">Título</th>
							<th style="width: 20%;">Usuario</th>
							<th style="width: 15%;">Fecha Creación</th>
							<th style="width: 10%;">Estado</th>
							<th style="width: 10%;">Acciones</th>
						
						</tr>
					</thead>	
					<tbody>
					</tbody>	
				</table>	
				
            </div>
		</div>
	</div>
	
	<!-- CONTENIDO -->
	
    <?php require_once("../MainJs/js.php");?>
    
    <script type="text/javascript" src="../Ticket/consultarTicket.js"></script>
	
</body>
</html>
<?php
	} else {
		header("Location:".$conectar->ruta()."../../login.php");
	}
	
?>