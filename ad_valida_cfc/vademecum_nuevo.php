<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$msj = $_GET['msj'];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Content area -->
<div class="content">
	<!-- Form validation -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<div class="header-elements">
				<div class="list-icons">            		          	
            	</div>
        	</div>
		</div>


		<div class="card-body">
		<legend class="text-uppercase font-size-sm font-weight-bold">Agregar</legend>
    <div class="form-group row">	
		<div class="col-md-2">			
		</div>
		
		
	    </div>
			<?php 
			if($msj == 'valid'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">FELICITACIONES!</span> El Medico se ingreso con Exito.
		    </div>'; }
		    if($msj == 'md'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">FELICITACIONES!</span> El Medico se Modifico con Exito.
		    </div>'; } ?>
			                   
			<br>
			<form action="vademecum_nuevo_.php" method="POST">
		<div class="form-group row">
			<div class="col-lg-3">
				<input type="number" name="troquel" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Troquel"></input>
			</div>
		</div>
			<div class="form-group row">
			<div class="col-lg-3">
				<input type="text" name="medicamento" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Medicamento"></input>
			</div>
		</div>
			<div class="form-group row">
				<div class="col-lg-3">
				<input type="text" name="presentacion" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Presentacion"></input>
			</div>
		</div>
			<div class="form-group row">
				<div class="col-lg-3">
				<input type="number" name="cod_laboratorio" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Cod Laboratorio"></input>
			</div>
		</div>
			<div class="form-group row">
				<div class="col-lg-3">
				<input type="number" name="precio" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Precio"></input>
			</div>
		</div>		

		<div class="form-group row">
					<div class="col-lg-3">
						<select name="tipo" class="form-control" required>
						<?php
						$lista =("SELECT * FROM tipos_medicamentos");
						$rs = mysqli_query($conexion,$lista);
						$row = mysqli_fetch_array($rs); 
						$tipo = $row['tipo'];
						?> 
							<option value="1">COMPRIMIDOS</option> 
							<option value="2">GOTAS</option>
							<option value="2">INYECTABLES</option> 
						</select>
					</div>
				</div>
		
	      <div class="form-group row">
					<div class="col-lg-3">
						<select name="estado" class="form-control" required>
						<?php
						$lista =("SELECT * FROM pad_medicos WHERE id = $id");
						$rs = mysqli_query($conexion,$lista);
						$row = mysqli_fetch_array($rs); 
						$estado = $row['estado'];
						?>
							<option value="1">ACTIVO</option> 
							<option value="0">INACTIVO</option> 
						</select>
					</div>
				</div>
			  <button type="submit" id="agregar" class="btn btn-danger"> Agregar</button>
			  <a href="vademecum.php"><button type="button" id="agregar" class="btn btn-danger"> Volver</button></a>
		</div>
		 </form>
	</div>
</div>
