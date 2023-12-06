<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$id = base64_decode($_GET['id']);
$lista =("SELECT * FROM efectores WHERE id = $id");
$rs = mysqli_query($conexion,$lista);
$row = mysqli_fetch_array($rs); 
$nombre = $row['nombre'];
$zona = $row['zona'];
$domicilio = $row['domicilio'];
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
		<form class="form-validate-jquery" action="efectores_update_.php?id=<?php echo $id ?>" method="POST">
			<fieldset class="mb-3">
				<legend class="text-uppercase font-size-sm font-weight-bold">Editar Efectores</legend>
				<!-- Basic text input -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">ZONA <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="text" name="zona" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  value="<?php echo $zona ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-3">NOMBRE <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="text" name="nombre" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  value="<?php echo $nombre ?>">
					</div>
				</div>
				<!-- /basic text input -->

				<!-- Number range -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">DOMICILIO <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="domicilio"  class="form-control"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $domicilio ?>">
					</div>
				</div>

			</fieldset>
			<div class="d-flex justify-content-end align-items-center">
				<button type="submit" class="btn btn-primary ml-3">Confirmar <i class="icon-paperplane ml-2"></i></button>
			</div>
			<a href="pad_med.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
		</form>
	</div>
</div>