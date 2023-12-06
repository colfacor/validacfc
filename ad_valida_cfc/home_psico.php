<?php
include('inc/header.php');
include('inc/panel.php');
include('inc/conexion.php');
session_start();
$dni = $_SESSION['dni'];
$user =("SELECT nombre, apellido, perfil FROM usuarios WHERE dni = '$dni'");
$r = mysqli_query($conexion,$user);
$rs = mysqli_fetch_array($r); 
$nombre = $rs['nombre'];
$apellido = $rs['apellido'];
$perfil = $rs['perfil'];
?>
<meta http-equiv="refresh" content="60" > 
			<div class="row">
				<?php if($perfil == '1' OR $perfil == '2'){ ?>
					<div class="col-sm-6 col-xl-3">
            		<a href="recetas_validadas_.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Recetas Validadas</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>
            	<div class="col-sm-6 col-xl-3">
            		<a href="pad_munpsico.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Padron PROGRAMA MUNICIPALIDAD MEJORAR</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>
				<div class="col-sm-6 col-xl-3">
            		<a href="pad_med.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Padron Medicos Habilitados</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>
				<?php } ?>
				<?php if($perfil == '1'){ ?>
				<div class="col-sm-6 col-xl-3">
            		<a href="usuarios.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Usuarios CFC Valida</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>

				<!--<div class="col-sm-6 col-xl-3">
            		<a href="usuarios_habilitar.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Habilitar Obra Social Farmacia</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a> -->
		

			<!--	<div class="col-sm-6 col-xl-3">
            		<a href="consumos.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Consumos</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a> -->
				<?php } ?>
				<?php if($perfil == '1' OR $perfil == '3' OR $perfil == '2'){ ?>
				<div class="col-sm-6 col-xl-3">
            		<a href="reportes.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Reporte Validaciones</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>
				<div class="col-sm-6 col-xl-3">
            		<a href="vademecum.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Vademecum Precios</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>
				<div class="col-sm-6 col-xl-3">
            		<a href="ab.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Buscar AlfaBeta</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>
				<?php } ?>
				<?php if($perfil == '1' OR $perfil == '2'){ ?>
				<div class="col-sm-6 col-xl-3">
            		<a href="efectores.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Efectores</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>
				<?php } ?>

				<?php if($perfil == '1' OR $perfil == '2'){ ?>
				<div class="col-sm-6 col-xl-3">
            		<a href="auditoria_cierre.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Auditoria de Cierres</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>
				<?php } ?>

				<?php if($perfil == '1' OR $perfil == '2'){ ?>
				<div class="col-sm-6 col-xl-3">
            		<a href="val_anuladas.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">Validaciones Anuladas</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>
				<?php } ?>

			</div>
		</div>
	</div>
	<!-- /main content -->
</div>

<!-- /page content -->
