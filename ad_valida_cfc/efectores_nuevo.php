<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
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
		<form class="form-validate-jquery" action="efectores_nuevo_.php" method="POST">
			<fieldset class="mb-3">
				<legend class="text-uppercase font-size-sm font-weight-bold">Nuevo Efector</legend>
				<!-- Basic text input -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">ZONA <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="number" name="zona" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-3">NOMBRE <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="text" name="nombre" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
					</div>
				</div>
				<!-- /basic text input -->

				<!-- Number range -->
				<div class="form-group row">
					<label class="col-form-label col-lg-3">DOMICILIO <span class="text-danger">*</span></label>
					<div class="col-lg-4">
						<input type="text" name="domicilio"  class="form-control"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
					</div>
				</div>

			</fieldset>
			<div class="d-flex justify-content-end align-items-center">
				<button type="submit" class="btn btn-primary ml-3">Confirmar <i class="icon-paperplane ml-2"></i></button>
			</div>
			<a href="pad_med.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
		</form>
	</div>
</div>