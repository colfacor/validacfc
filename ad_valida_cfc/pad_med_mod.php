<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$id = base64_decode($_GET['id']);
$lista =("SELECT * FROM pad_medicos WHERE id = $id");
$rs = mysqli_query($conexion,$lista);
$row = mysqli_fetch_array($rs); 
$nombre = $row['nombre'];
$mp = $row['mp'];
$especialidad = $row['especialidad'];
$zona = $row['zona'];
$centro = $row['centro'];
$estado = $row['estado'];
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
		<form class="form-validate-jquery" action="pad_med_mod_.php?id=<?php echo $id ?>" method="POST">
			<fieldset class="mb-3">
				<legend class="text-uppercase font-size-sm font-weight-bold">Editar Medico</legend>
				<?php 
				if($msj == 'error'){
				echo '<div class="alert alert-danger alert-styled-left alert-dismissible">
					<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
					<span class="font-weight-semibold">ERROR!</span> La Matricula ingresada ya se encuentra registrado.
			    </div>'; }
			    ?>
				<!-- Basic text input -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">NOMBRE <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="text" name="nombre" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  value="<?php echo $nombre ?>">
					</div>
				</div>
				<!-- /basic text input -->

				<!-- Number range -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">MATRICULA <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="mp" maxlength="8" class="form-control"  value="<?php echo $mp ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-3">ESPECIALIDAD <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="especialidad" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  class="form-control"  value="<?php echo $especialidad ?>">
					</div>
				</div>

			<div class="form-group row">
					<label class="col-form-label col-lg-3">ZONA <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select name="zona" class="form-control" required>
							<option value='<?php echo $zona?>'><?php echo $zona?></option>
							<?php 
	                      	include('inc/conexion.php');
	                      	$result1 =  mysqli_query($conexion," SELECT zona FROM efectores GROUP BY zona ORDER BY zona DESC");
				           	while ($reg1=mysqli_fetch_array($result1)){  
	                             echo " <option value='".$reg1['zona']."'>".$reg1['zona']."</option>"; 
	                        }
	                        ?>  
						</select>
					</div>
				</div>

			<div class="form-group row">
					<label class="col-form-label col-lg-3">CENTRO <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="centro" maxlength="8" class="form-control"  value="<?php echo $centro ?>">
					</div>
				</div>
				<!-- /number range -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">ESTADO <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select name="estado" class="form-control" required>
						<?php
						$lista ="SELECT * FROM pad_medicos WHERE id = $id";
						$rs = mysqli_query($conexion,$lista);
						$row = mysqli_fetch_array($rs); 
						$estado = $row['estado'];
						if($estado == 1){
						echo '<option value="1">ACTIVO</option>'; 
						}else{
						echo '<option value="1">INACTIVO</option>'; 
						}
						?>
							<option value="1">ACTIVO</option> 
							<option value="0">INACTIVO</option> 
						</select>
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