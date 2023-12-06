<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$id = base64_decode($_GET['id']);
$lista =("SELECT * FROM pad_psicotropicos WHERE id = $id");
$rs = mysqli_query($conexion,$lista);
$row = mysqli_fetch_array($rs); 
$nombre = $row['nombre'];
$apellido = $row['apellido'];
$dni = $row['dni'];
$diagnostico = $row['diagnostico'];
$fec_nac = $row['fec_nac'];
$telefono = $row['telefono'];
$calle = $row['calle'];
$numero = $row['numero'];
$piso = $row['piso'];
$dpto = $row['dpto'];
$barrio = $row['barrio'];
$efector = $row['efector'];
$prescriptor = $row['prescriptor'];
$fecha_inscripcion = $row['fecha_inscripcion'];
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
		<form class="form-validate-jquery" action="pad_munpsico_mod_.php?id=<?php echo $id ?>" method="POST">
			<fieldset class="mb-3">
				<legend class="text-uppercase font-size-sm font-weight-bold">Editar Afiliado</legend>
				<?php 
				if($msj == 'error'){
				echo '<div class="alert alert-danger alert-styled-left alert-dismissible">
					<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
					<span class="font-weight-semibold">ERROR!</span> El DNI ingresado ya se encuentra registrado.
			    </div>'; }
			    ?>
				<!-- Basic text input -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">NOMBRE <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="text" name="nombre" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  value="<?php echo $nombre ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-3">APELLIDO <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="text" name="apellido" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  value="<?php echo $apellido ?>">
					</div>
				</div>
				<!-- /basic text input -->

				<!-- Number range -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">DNI <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="dni" maxlength="8" class="form-control"  value="<?php echo $dni ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-3">FECHA NAC. <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="date" name="fec_nac" class="form-control" value="<?php echo $fec_nac ?>" >
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">TELEFONO <span class="text-danger">(Sin 0)*</span></label>
					<div class="col-lg-4">
						<input type="number" name="telefono" maxlength="10" class="form-control" value="<?php echo $telefono ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">CALLE <span class="text-danger"></span></label>
					<div class="col-lg-4">
						<input type="text" name="calle" class="form-control" value="<?php echo $calle ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">NUMERO <span class="text-danger"></span></label>
					<div class="col-lg-4">
						<input type="number" name="numero" class="form-control" value="<?php echo $numero ?>">
					</div>
				</div>


				<div class="form-group row">
					<label class="col-form-label col-lg-3">BARRIO <span class="text-danger"></span></label>
					<div class="col-lg-4">
						<input type="text" name="barrio" class="form-control" value="<?php echo $barrio ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">FECHA INSCRIPCION <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="date" name="fecha_inscripcion" class="form-control" value="<?php echo $fecha_inscripcion ?>" >
					</div>
				</div>

				<!-- /number range -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">DIAGNOSTICO <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="text" name="diagnostico" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  value="<?php echo $diagnostico ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">PRESCRIPTOR<span class="text-danger">*</span> (MP|NOMBRE|ZONA|CENTRO)</label>
					<div class="col-lg-6">

							<select data-placeholder="Select a state" name="prescriptor" class="form-control select-clear" data-fouc required>	

							<?php 
	                      	include('inc/conexion.php');
	                      	$result1 =  mysqli_query($conexion," SELECT *
	                      		                                 FROM pad_medicos 
	                      		                                 WHERE mp = '$prescriptor'");
				           	while ($reg1=mysqli_fetch_array($result1)){  
	                             echo " <option value='".$reg1['mp']."'>".$reg1['mp']." - ".$reg1['nombre']." | ".$reg1['zona']." | ".$reg1['centro']."</option>"; 
	                        }
	                        $result1 =  mysqli_query($conexion," SELECT *
	                      		                                 FROM pad_medicos 
	                      		                                 ORDER BY nombre ASC");
				           	while ($reg1=mysqli_fetch_array($result1)){  
	                             echo " <option value='".$reg1['mp']."'>".$reg1['mp']." - ".$reg1['nombre']." | ".$reg1['zona']." | ".$reg1['centro']."</option>"; 
	                        }
	                        ?>  
						</select>
					</div>
				</div>
						
				<div class="form-group row">
					<label class="col-form-label col-lg-3">EFECTOR <span class="text-danger">*</span></label>
					<div class="col-lg-6">

							<select data-placeholder="Select a state" name="efector" class="form-control select-clear" data-fouc required>	
						<?php 
                      	include('inc/conexion.php');
                      	$result1 =  mysqli_query($conexion," SELECT * FROM efectores WHERE id = '$efector'");
			           	while ($reg1=mysqli_fetch_array($result1)){  
                             echo " <option value='".$reg1['id']."'>".$reg1['nombre']."</option>"; 
                        }
                        $result1 =  mysqli_query($conexion," SELECT * FROM efectores ORDER BY nombre ASC");
			           	while ($reg1=mysqli_fetch_array($result1)){  
                             echo " <option value='".$reg1['id']."'>".$reg1['nombre']."</option>"; 
                        }
                        ?>  
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">GENERO <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select name="genero" class="form-control" required>
						<?php
						$lista =("SELECT * FROM pad_psicotropicos WHERE id = $id");
						$rs = mysqli_query($conexion,$lista);
						$row = mysqli_fetch_array($rs); 
						$genero = $row['genero'];
						if($genero == 'M'){
						echo '<option value="M">M</option>'; 
						}else{
						echo '<option value="F">F</option>'; 
						}
						?>
							<option value="M">M</option> 
							<option value="F">F</option> 
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-3">ESTADO <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select name="estado" class="form-control" required>
						<?php
						$lista =("SELECT * FROM pad_psicotropicos WHERE id = $id");
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
			<a href="pad_munpsico.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
		</form>
	</div>
</div>


































































