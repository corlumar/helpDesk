<?php
	require_once("../../config/conexion.php");
	if(isset($_SESSION["usu_id"])){
?>
<!DOCTYPE html>
<html>
    <?php require_once("../Mainhead/head.php");?>	
    <title>HelpDesk - Nuevo Ticket</title>
</head>
<body class="with-side-menu">

	<?php require_once("../Mainheader/header.php");?>

	<div class="mobile-menu-left-overlay"></div>
	
    <?php require_once("../MainNav/nav.php");?>
    
    <!-- CONTENIDO -->
    
	<div class="page-content">
		<div class="container-fluid">
		
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Nuevo Ticket</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Nuevo Ticket</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
	
            <div class="box-typical box-typical-padding">
				<p>
					Desde esta ventana podrá crear un nuevo ticket de soporte.
				</p>
            </div>
				
				<h5 class="m-t-lg with-border">Ingresar Información</h5>

				<div class="row">
				<form method="POST" id="ticket_form">
				
					<input type="hidden" id="usu_idx" value="<?php echo $_SESSION['usu_id']; ?>">
					<input type="hidden" id="rol_idx" value="<?php echo $_SESSION['rol_id']; ?>">

				
					<div class="col-lg-6">
						<fieldset class="form-group">
							<label class="form-label semibold" for="exampleInput">Categoría</label>
							<select id="cat_id" name="cat_id" class="form-control">
							
							</select>
						</fieldset>
					</div>
					<div class="col-lg-6">
						<fieldset class="form-group">
							<label class="form-label semibold" for="ticket_titulo">Título</label>
							<input type="text" class="form-control" id="ticket_titulo" name="ticket_titulo" placeholder="Ingrese Título">
						</fieldset>
					</div>
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label semibold" for="ticket_descripcion">Descripción</label>
							<div class="summernote-theme-1">
					        <textarea id="ticket_descripcion" class="summernote" name="ticket_descripcion"></textarea>
				            </div>
						</fieldset>
					</div>
					<div class="col-lg-12">
				            <button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary" id="btn-guardar">Guardar</button>
	                </div>
				</form>    
				</div><!--.row-->
	
    <?php require_once("../MainJs/js.php");?>
    
    <script type="text/javascript" src="nuevoTicket.js"></script>
	
</body>
</html>
<?php
	} else {
		header("Location:".$conectar->ruta()."../login.php");
	}
	
	?>