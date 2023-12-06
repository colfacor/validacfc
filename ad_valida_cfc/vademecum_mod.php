<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$id = base64_decode($_GET['id']);
$lista =("SELECT  a.troquel, a.medicamento, a.presentacion, a.cod_laboratorio, a.precio, a.tipo, a.estado, a.marca, b.des , a.id , a.reg  , a.tope, a.porcentaje, a.tipo_med  , a.tipo, a.comprimidos, a.comprimidos_ab
FROM vade_psicotropicos a
LEFT JOIN alfabeta_laboratorios b 
ON a.cod_laboratorio = b.id  WHERE a.id = '$id'");
$rs = mysqli_query($conexion,$lista);
$row = mysqli_fetch_array($rs); 
$medicamento = $row['medicamento'];
$presentacion = $row['presentacion'];
$cod_laboratorio = $row['cod_laboratorio'];
$marca = $row['marca'];
$precio = $row['precio'];
$tipo = $row['tipo'];
$estado = $row['estado'];
$des = $row['des'];
$troquel = $row['troquel'];
$reg = $row['reg'];
$tipo_med = $row['tipo_med'];
$porcentaje = $row['porcentaje'];
$tope = $row['tope'];
$comprimidos_ab = $row['comprimidos_ab'];
$comprimidos = $row['comprimidos'];
?>
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
		<form class="form-validate-jquery" action="vademecum_mod_.php?id=<?php echo base64_encode($id) ?>" method="POST">
			<fieldset class="mb-3">
				<legend class="text-uppercase font-size-sm font-weight-bold">Editar Medicamento</legend>
				<!-- Basic text input -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">REG <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="text" name="reg" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  value="<?php echo $reg ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">TROQUEL <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="text" name="troquel" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  value="<?php echo $troquel ?>">
					</div>
				</div>
				<!-- /basic text input -->

				<div class="form-group row">
					<label class="col-form-label col-lg-3">MEDICAMENTO <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="text" name="medicamento" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  value="<?php echo $medicamento ?>">
					</div>
				</div>

				<!-- Number range -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">PRESENTACION <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="presentacion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control"  value="<?php echo $presentacion ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-3">MARCA <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="marca" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  class="form-control"  value="<?php echo $marca ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-3">PRECIO <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="precio" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  class="form-control"  value="<?php echo $precio ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">COMPRIMIDOS <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="comprimidos" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  class="form-control"  value="<?php echo $comprimidos ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">COMPRIMIDOS AB <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="comprimidos_ab" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  class="form-control"  value="<?php echo $comprimidos_ab ?>">
					</div>
				</div>

			<div class="form-group row">
					<label class="col-form-label col-lg-3">LABORATORIOS <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select name="cod_laboratorio" class="form-control" required>
							<option value='<?php echo $cod_laboratorio?>'><?php echo $des?></option>
							<?php 
	                      	include('inc/conexion.php');
	                      	$result1 =  mysqli_query($conexion," SELECT id, des FROM alfabeta_laboratorios ORDER BY des ASC");
				           	while ($reg1=mysqli_fetch_array($result1)){  
	                             echo " <option value='".$reg1['id']."'>".$reg1['des']."</option>"; 
	                        }
	                        ?>  
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">ESTADO <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select name="estado" class="form-control" required>
						<?php
						$lista ="SELECT * FROM vade_psicotropicos WHERE troquel = '$troquel'";
						$rs = mysqli_query($conexion,$lista);
						$row = mysqli_fetch_array($rs); 
						$estado = $row['estado'];
						if($estado == 1){
						echo '<option value="1">ACTIVO</option>'; 
						}else{
						echo '<option value="0">INACTIVO</option>'; 
						}
						?>
							<option value="1">ACTIVO</option> 
							<option value="0">INACTIVO</option> 
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">TIPO <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<select name="tipo" class="form-control" required>
						<?php
						$lista ="SELECT * FROM vade_psicotropicos WHERE troquel = '$troquel'";
						$rs = mysqli_query($conexion,$lista);
						$row = mysqli_fetch_array($rs); 
						$tipo = $row['tipo'];
						if($tipo == 1){
						echo '<option value="1">COCOFA</option>'; 
						}else{
						echo '<option value="2">ALFABETA</option>'; 
						}
						?>
							<option value="1">COCOFA</option> 
							<option value="2">ALFABETA</option> 
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">PORCENTAJE <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="porcentaje" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  class="form-control"  value="<?php echo $porcentaje ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">TIPO MEDICAMENTO <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="tipo_med" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  class="form-control"  value="<?php echo $tipo_med ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-3">TOPE <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="tope" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  class="form-control"  value="<?php echo $tope ?>">
					</div>
				</div>

			</fieldset>
			<div class="d-flex justify-content-end align-items-center">
				<button type="submit" class="btn btn-primary ml-3">Confirmar <i class="icon-paperplane ml-2"></i></button>
			</div>
			<a href="vademecum.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
		</form>
	</div>
</div>