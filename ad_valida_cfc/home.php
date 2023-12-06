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
            	<div class="col-sm-6 col-xl-4">
            		<a href="home_psico.php">
					<div class="card card-body bg-danger-400 has-bg-image">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-0"></h3>
								<span class="text-uppercase font-size-xs">PROGRAMA MUNICIPALIDAD MEJORAR</span>
							</div>

							<div class="ml-3 align-self-center">
								<i class="icon-files-empty icon-3x opacity-75"></i>
							</div>
						</div>
					</div>
				</div></a>
			</div>
				
		</div>
	</div>
	<!-- /main content -->
</div>

<!-- /page content -->
