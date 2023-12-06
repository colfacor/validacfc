<?php
include('inc/header.php');
include('inc/panel.php');
session_start();
$msj = $_GET['msj'];
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<!-- Content area -->
	<div class="content">
		<!-- Form validation -->
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">AFILIADO NUEVO</h5>
				<div class="header-elements">
					<div class="list-icons">
                		<a class="list-icons-item" data-action="collapse"></a>
                		<a class="list-icons-item" data-action="reload"></a>
                		<a class="list-icons-item" data-action="remove"></a>
                	</div>
            	</div>
			</div>
			<div class="card-body">
				<form class="form-validate-jquery" action="pad_munpsiconew_.php" method="POST">
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Datos Afiliado</legend>
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
								<input type="text" name="nombre" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required placeholder="NOMBRE">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-3">APELLIDO <span class="text-danger">*</span></label>
							<div class="col-lg-6">
								<input type="text" name="apellido" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required placeholder="APELLIDO">
							</div>
						</div>
						<!-- /basic text input -->

						<!-- Number range -->
						<div class="form-group row">
							<label class="col-form-label col-lg-3">DNI <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="dni_afi" maxlength="8" class="form-control" required placeholder="DNI" />
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">FECHA NAC. <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="date" name="fec_nac" class="form-control" required/>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">TELEFONO <span class="text-danger">(Sin 0)*</span></label>
							<div class="col-lg-4">
								<input type="number" name="telefono" maxlength="10" class="form-control" required placeholder="TELEFONO" />
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">CALLE <span class="text-danger"></span></label>
							<div class="col-lg-4">
								<input type="text" name="calle"  class="form-control" required placeholder="CALLE" />
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">NUMERO <span class="text-danger"></span></label>
							<div class="col-lg-2">
								<input type="number" name="numero"  class="form-control" required placeholder="NUMERO" />
							</div>
						</div>

					

						<div class="form-group row">
							<label class="col-form-label col-lg-3">BARRIO <span class="text-danger"></span></label>
							<div class="col-lg-4">
								<input type="text" name="barrio"  class="form-control" required placeholder="BARRIO" />
							</div>
						</div>

						

						<div class="form-group row">
							<label class="col-form-label col-lg-3">FECHA INSCRIPCION <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="date" name="fecha_inscripcion" class="form-control" required/>
							</div>
						</div>
						<!-- /number range -->
						<div class="form-group row">
							<label class="col-form-label col-lg-3">DIAGNOSTICO <span class="text-danger">*</span></label>
							<div class="col-lg-6">
								<input type="text" name="diagnostico" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="DIAGNOSTICO">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-3">PRESCRIPTOR <span class="text-danger">*</span> (MP|NOMBRE|ZONA|CENTRO)</label>
								<div class="col-lg-6">
							<select data-placeholder="Select a state" name="prescriptor" class="form-control select-clear" data-fouc required>	

							<?php 
	                      	include('inc/conexion.php');
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
								<select data-placeholder="Select a state" name="efector" class="form-control select-clear" data-fouc>	


							<?php 
	                      	include('inc/conexion.php');
	                      	$result1 =  mysqli_query($conexion," SELECT * FROM efectores ORDER BY nombre ASC");
				           	while ($reg1=mysqli_fetch_array($result1)){  
	                             echo " <option value='".$reg1['id']."'>".$reg1['nombre']."</option>"; 
	                        }
	                        ?>  
							</select>
						</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">SEXO <span class="text-danger">*</span></label>
							<div class="col-lg-4"><select name="genero" class="form-control" required>
								<option value=''></option>
								<option value='F'>F</option>
								<option value='M'>M</option>
							</select>
							</div>
						</div>
					</fieldset>
					<div class="d-flex justify-content-end align-items-center">
						<button type="reset" class="btn btn-light" id="reset">Borrar Datos <i class="icon-reload-alt ml-2"></i></button>
						<button type="submit" class="btn btn-primary ml-3">Confirmar <i class="icon-paperplane ml-2"></i></button>
					</div>
					<a href="pad_munpsico.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
				</form>
			</div>
		</div>
		<!-- /form validation -->
	</div>
	<!-- /content area -->