<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$troquel = base64_decode($_GET['troquel']);
$lista =("SELECT * FROM vade_psicotropicos WHERE troquel = $troquel");
$rs = mysqli_query($conexion,$lista);
$row = mysqli_fetch_array($rs); 
$precio = $row['precio'];
$medicamento = $row['medicamento'];
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
		<form class="form-validate-jquery" action="vademecum_precios_update_.php?troquel=<?php echo base64_encode($troquel) ?>" method="POST">
			<fieldset class="mb-3">
				<legend class="text-uppercase font-size-sm font-weight-bold">Editar Medicamento <?php echo $medicamento ?></legend>
				<!-- Basic text input -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">PRECIO <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="texto" name="precio" class="form-control" value="<?php echo $precio ?>">
					</div>
				</div>

			
			</fieldset>
			<div class="d-flex justify-content-end align-items-center">
				<button type="submit" class="btn btn-primary ml-3">Confirmar <i class="icon-paperplane ml-2"></i></button>
			</div>
			<a href="vademecum_precios.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
		</form>
	</div>
</div>