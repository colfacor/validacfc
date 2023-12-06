<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
$msj = base64_decode($_GET['msj']);

$lista =("SELECT * FROM users WHERE cuit = '$cuit' AND idsucursal = '$idsucursal'");
$rs = mysqli_query($conexion,$lista);
$row = mysqli_fetch_array($rs); 
$farmacia = $row['farmacia'];
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- Content area -->
<div class="content">
	<!-- Form validation -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<div class="header-elements">
				<div class="list-icons">            		
           		<a class="list-icons-item" data-action="reload"></a>          	
            	</div>
        	</div>
		</div>
		<div class="card-body">
		<form class="form-validate-jquery" action="cambiarcontrasena_.php" method="POST">
			<fieldset class="mb-3">
				<legend class="text-uppercase font-size-sm font-weight-bold">Cambiar Contraseña</legend>
				<!-- Basic text input -->
				<?php 
				if(base64_decode($_GET['msj']) == 'err'){
				echo'
				<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
					<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
					<span class="font-weight-semibold">ATENCION!</span> Las Contraseñas no coinciden.
			    </div>'; }
			    if(base64_decode($_GET['msj']) == 'ex'){
				echo'
				<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
					<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
					<span class="font-weight-semibold">ATENCION!</span> La Contraseña se modifico con exito.
			    </div>'; } ?>		

				<div class="form-group row">
					<label class="col-form-label col-lg-3">CONTRASEÑA NUEVA <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="password" name="contra" class="form-control" value="">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">REPETIR CONTRASEÑA NUEVA <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="password" name="contra1" class="form-control" value="">
					</div>
				</div>
			
			</fieldset>
			<div class="d-flex justify-content-end align-items-center">
				<button type="submit" class="btn btn-primary ml-3">Confirmar <i class="icon-paperplane ml-2"></i></button>
			</div>
			<a href="home.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
		</form>
	</div>
</div>