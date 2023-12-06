<?php
include('inc/header.php');
include('inc/panel.php');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
include('inc/conexion.php');
if (!isset($_SESSION['cuit'])) {
    header("location: index.php?msj=".base64_encode('cs')."");
     exit();
}
unset($_SESSION['num_receta']);
?>
<meta http-equiv="refresh" content="60" > 
			<div class="row">
            	<div class="col-sm-6 col-xl-4">
            		<a href="val_munpsico.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Validar Receta</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-copy icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>

				<div class="col-sm-6 col-xl-4">
					<a href="validaciones.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Validaciones</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-xl-4">
					<a href="cierres.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Cierres de Presentacion</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-folder5 icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-xl-4">
					<a href="vade_psico.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Consulta Precios Medicamentos</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-coin-dollar icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /main content -->
</div>