<?php
include('inc/header.php');
include('inc/panel.php');
session_start();
$msj = base64_decode($_GET['msj']);
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<!-- Content area -->
	<div class="content">
		<!-- Form validation -->
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">HABILITAR OBRA SOCIAL</h5>
				<div class="header-elements">
					<div class="list-icons">
                		<a class="list-icons-item" data-action="collapse"></a>
                		<a class="list-icons-item" data-action="reload"></a>
                		<a class="list-icons-item" data-action="remove"></a>
                	</div>
            	</div>
			</div>
			<div class="card-body">
				<form class="form-validate-jquery" action="usuarios_habilitar_.php" method="POST">
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Datos Farmacias</legend>
									<?php 
						if($msj == 'ex'){
						echo'
						<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
							<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
							<span class="font-weight-semibold">FELICITACIONES!</span> La Obra Social se ingreso con Exito.
					    </div>'; }
					    if($msj == 'rep'){
						echo'
						<div class="alert alert-warning alert-styled-left alert-arrow-left alert-dismissible">
							<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
							<span class="font-weight-semibold">FELICITACIONES!</span> La Obra Social ya se encuentra Habilitada para la farmacia.
					    </div>'; } ?>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">FARMACIA <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select data-placeholder="Select a state" name="idmatricula" class="form-control select-clear" data-fouc>
							<?php 
	                      	include('inc/conexion.php');
	                      	$result1 =  mysqli_query($conexion," SELECT * FROM users ORDER BY idmatricula ASC");
				           	while ($rs=mysqli_fetch_array($result1)){  
	                        echo " <option value=".$rs['idmatricula'].">".$rs['idmatricula'].' | '.$rs['idsucursal'].' - '.$rs['farmacia']."</option>"; 
	                        }
	                        ?>  
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-3">SUC <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select name="idsucursal" class="form-control" required>
	                    <option value="1">1</option> 
	                    <option value="2">2</option> 
	                    <option value="3">3</option> 
	                    <option value="4">4</option> 
	                    <option value="5">5</option> 
	                    <option value="6">6</option> 
	                    <option value="7">7</option> 
	                    <option value="8">8</option> 
	                    <option value="9">9</option> 
	                    <option value="10">10</option>
	                    <option value="11">11</option>
	                    <option value="12">12</option>
	                    <option value="13">13</option>
	                    <option value="14">14</option> 
	                    <option value="15">15</option>
	                    <option value="16">16</option>
	                    <option value="17">17</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">OBRAS SOCIALES <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select class="form-control select-multiple-tokenization" multiple="multiple" data-fouc name='id_obrasocial[]'>
							<?php 
	                      	include('inc/conexion.php');
	                      	$result1 =  mysqli_query($conexion," SELECT * FROM obras_sociales WHERE padron = '1' ORDER BY obra_social ASC");
				           	while ($rs=mysqli_fetch_array($result1)){  
	                             echo " <option value=".$rs['id'].">".$rs['obra_social']."</option>"; 
	                        }
	                        ?>  
						</select>
					</div>
				</div>
				</fieldset>
				<div class="d-flex justify-content-end align-items-center">
					<button type="reset" class="btn btn-light" id="reset">Borrar Datos <i class="icon-reload-alt ml-2"></i></button>
					<button type="submit" class="btn btn-primary ml-3">Confirmar <i class="icon-paperplane ml-2"></i></button>
				</div>
				<a href="home_psico.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
			</form>
		</div>
	</div>
	<!-- /form validation -->
</div>
<!-- /content area -->