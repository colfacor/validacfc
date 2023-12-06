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
			<legend class="text-uppercase font-size-sm font-weight-bold">Reporte Validaciones</legend>
			<form action="reporte_validaciones.php" method="POST">
			<div class="form-group row">
				<div class="col-3">
					<strong>Desde</strong> <input type="date" class="form-control" name="desde">
				</div>
				<div class="col-3">
					<strong>Hasta</strong> <input type="date" class="form-control" name="hasta">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-2">
					<button type="submit" class="btn btn-danger"> Buscar</button>
					<a href="home_psico.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>