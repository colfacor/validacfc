<?php 
include('inc/header.php');
include('inc/panel.php');
?>

<!-- Content area -->
<div class="content">

	<!-- /table header styling -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<div class="header-elements">
				<div class="list-icons">
	        	</div>
	    	</div>
		</div>
		<div class="card-body">
			<form method="POST" action="usuario_nuevo_.php">
			<fieldset class="mb-3">
			<legend class="text-uppercase font-size-sm font-weight-bold">Datos de la Farmacia</legend>
			<div class="form-group row">
				<div class="col-3">
					<strong>MATRICULA </strong> <input type="text" class="form-control" name="idmatricula" value="<?php echo $idmatricula ?>" >
				</div>
				<div class="col-3">
					<strong>SUCURSAL </strong> <input type="text" class="form-control" name="idsucursal" value="<?php echo $idsucursal ?>" >
				</div>
				<div class="col-3">
					<strong>FARMACIA</strong> <input type="text" class="form-control" name="farmacia" value="<?php echo $farmacia;?>" >
				</div>
				
			</div>	
			<div class="form-group row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-3">
						<strong>CUIT</strong>  
						    <input class="form-control" type="text" name="cuit" value="<?php echo $cuit;?>" >
						</div>
						<div class="col-3">
							<strong>CONTRASEÑA</strong> <input class="form-control" type="text" name="password" value="<?php echo $password;?>" >
						</div>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-4">
						<strong>TELEFONO</strong>  
						    <input class="form-control" type="number" name="telefono" value="<?php echo $telefono;?>" >
						</div>
						<div class="col-4">
							<strong>DOMICILIO</strong> <input class="form-control" type="text" name="domicilio" value="<?php echo $domicilio;?>" >
						</div>
						<div class="col-4">
							<strong>EMAIL</strong> <input class="form-control" type="email" name="email" value="<?php echo $email;?>" >
						</div>
					</div>
				</div>
			</div>
			</fieldset>
			<div class="text-left">
				<button type="submit" class="btn btn-danger">Cargar Usuario<i class="icon-floppy-disk ml-2"></i></button>
				<a href="usuarios.php"><button type="button" class="btn btn-dark">Volver</button></a>
			</div>
			</form>
		</div>			
	</div>
</div>