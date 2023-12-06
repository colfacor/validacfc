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
				<h5 class="card-title">MEDICAMENTO NUEVO</h5>
				<div class="header-elements">
					<div class="list-icons">
                		<a class="list-icons-item" data-action="collapse"></a>
                		<a class="list-icons-item" data-action="reload"></a>
                		<a class="list-icons-item" data-action="remove"></a>
                	</div>
            	</div>
			</div>
			<div class="card-body">
				<form class="form-validate-jquery" action="medicamento_nuevo_.php" method="POST">
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Datos Medicamento</legend>
						<?php 
						if($msj == 'rep'){
						echo '<div class="alert alert-danger alert-styled-left alert-dismissible">
							<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
							<span class="font-weight-semibold">ERROR!</span> El TROQUEL ingresado ya se encuentra registrado.
					    </div>'; }
					    ?>
					    
						<!-- Basic text input -->
						<div class="form-group row">
							<label class="col-form-label col-lg-3">REG <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="number" name="reg" maxlength="8" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required placeholder="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-3">TROQUEL <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="number" name="troquel" maxlength="8" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required placeholder="">
							</div>
						</div>
						<!-- /basic text input -->

						<!-- Number range -->
						<div class="form-group row">
							<label class="col-form-label col-lg-3">MONODROGA <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="medicamento" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required placeholder="" />
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">MARCA <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="marca" class="form-control"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required/>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">PRESENTACION <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="presentacion" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required placeholder="" />
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">COMPRIMIDOS AB <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="number" name="comprimidos_ab"  class="form-control" required placeholder="" />
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">COMPRIMIDOS <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="number" name="comprimidos"  class="form-control" required placeholder="" />
							</div>
						</div>

					

						<div class="form-group row">
							<label class="col-form-label col-lg-3">PRECIO <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="precio"  class="form-control" required placeholder="" />
							</div>
						</div>

						

						<div class="form-group row">
							<label class="col-form-label col-lg-3">LABORATORIO <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<select  name="cod_laboratorio" class="form-control select-clear" data-fouc required>	

								<?php 
		                      	include('inc/conexion.php');
		                      	$result1 =  mysqli_query($conexion," SELECT *
		                      		                                 FROM alfabeta_laboratorios 
		                      		                                 ORDER BY des ASC");
					           	while ($reg1=mysqli_fetch_array($result1)){  
		                             echo " <option value='".$reg1['id']."'>".$reg1['des']."</option>"; 
		                        }
		                        ?>  
								</select>
							</div>
						</div>


						<div class="form-group row">
							<label class="col-form-label col-lg-3">ESTADO <span class="text-danger">*</span></label>
							<div class="col-lg-4"><select name="estado" class="form-control" required>
								<option value='1'>ACTIVO</option>
								<option value='0'>INACTIVO</option>
							</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">PORCENTAJE A DESCONTAR <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="porcentaje"  class="form-control" required placeholder="" />
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">TIPO <span class="text-danger">De donde se actualiza el precio</span></label>
							<div class="col-lg-4"><select name="tipo" class="form-control" required>
								<option value='2'>ALFABETA</option>
								<option value='1'>COCOFA</option>
							</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">TIPO DE MEDICAMENTO <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="tipo_med"  class="form-control" required placeholder="" />
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">TOPE MENSUAL <span class="text-danger">*</span></label>
							<div class="col-lg-4">
								<input type="number" name="tope"  class="form-control" required placeholder="" />
							</div>
						</div>

					</fieldset>
					<div class="d-flex justify-content-end align-items-center">
						<button type="reset" class="btn btn-light" id="reset">Borrar Datos <i class="icon-reload-alt ml-2"></i></button>
						<button type="submit" class="btn btn-primary ml-3">Confirmar <i class="icon-paperplane ml-2"></i></button>
					</div>
					<a href="vademecum.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
				</form>
			</div>
		</div>
		<!-- /form validation -->
	</div>
	<!-- /content area -->