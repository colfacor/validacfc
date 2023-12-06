<?php
include('inc/header.php');
include('inc/panel.php');
session_start();
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<!-- Content area -->
	<div class="content">
		<!-- Form validation -->
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">MEDICO NUEVO</h5>
				<div class="header-elements">
					<div class="list-icons">
                		<a class="list-icons-item" data-action="collapse"></a>
                		<a class="list-icons-item" data-action="reload"></a>
                		<a class="list-icons-item" data-action="remove"></a>
                	</div>
            	</div>
			</div>
			<div class="card-body">
				<form class="form-validate-jquery" action="pad_mednew_.php" method="POST">
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Datos Medico</legend>
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
								<input type="text" name="nombre" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required placeholder="APELLIDO NOMBRE">
							</div>
						</div>
						<!-- /basic text input -->

						<!-- Number range -->
						<div class="form-group row">
							<label class="col-form-label col-lg-3">MATRICULA <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="mp" maxlength="8" class="form-control" required placeholder="MP" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-3">ESPECIALIDAD <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="especialidad"  class="form-control" required placeholder="" />
							</div>
						</div>
						<!-- /number range -->

						<div class="form-group row">
					<label class="col-form-label col-lg-3">ZONA <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select name="zona" class="form-control" required>
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
							<div class="col-lg-6">
								<input type="text" name="centro" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required placeholder="CENTRO">
							</div>
						</div>


					</fieldset>
					<div class="d-flex justify-content-end align-items-center">
						<button type="reset" class="btn btn-light" id="reset">Borrar Datos <i class="icon-reload-alt ml-2"></i></button>
						<button type="submit" class="btn btn-primary ml-3">Confirmar <i class="icon-paperplane ml-2"></i></button>
					</div>
					<a href="pad_med.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
				</form>
			</div>
		</div>
		<!-- /form validation -->
	</div>
	<!-- /content area -->