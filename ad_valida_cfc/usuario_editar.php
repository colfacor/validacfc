<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$id = base64_decode($_GET['id']);
$lista =("SELECT * FROM users WHERE id = $id");
$rs = mysqli_query($conexion,$lista);
$row = mysqli_fetch_array($rs); 
$idmatricula = $row['idmatricula'];
$idsucursal = $row['idsucursal'];
$farmacia = $row['farmacia'];
$cuit = $row['cuit'];
$password = $row['password'];
$estado = $row['estado'];
$email = $row['email'];
$lista1 =("SELECT * FROM users WHERE idmatricula = $idmatricula AND idsucursal = $idsucursal");
$rs1 = mysqli_query($conexion,$lista1);
$row1 = mysqli_fetch_array($rs1); 
$contra = $row1['contra'];
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
		<form class="form-validate-jquery" action="usuario_editar_.php?id=<?php echo $id ?>" method="POST">
			<fieldset class="mb-3">
				<legend class="text-uppercase font-size-sm font-weight-bold">Editar Usuario <?php echo $contra ?></legend>
				<!-- Basic text input -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">MATRICULA <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="number" name="idmatricula" class="form-control" value="<?php echo $idmatricula ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-3">SUCURSAL <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="number" name="idsucursal" class="form-control" value="<?php echo $idsucursal ?>">
					</div>
				</div>
			
				<div class="form-group row">
					<label class="col-form-label col-lg-3">FARMACIA <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="farmacia" class="form-control"  value="<?php echo $farmacia ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">TELEFONO <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="telefono" class="form-control"  value="<?php echo $telefono ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">DOMICILIO <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="domicilio" class="form-control"  value="<?php echo $domicilio ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">EMAIL <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="email" name="email" class="form-control"  value="<?php echo $email ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">CUIT <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="cuit" class="form-control"  value="<?php echo $cuit ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">CONTRASEÑA NUEVA <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="password" class="form-control" value="">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">ESTADO <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select name="estado" class="form-control" required>
						<?php
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
			<a href="usuarios.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
		</form>
	</div>
</div>