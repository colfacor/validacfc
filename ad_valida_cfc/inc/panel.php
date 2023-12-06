<?php 
include ('conexion.php');
session_start();
$dni = $_SESSION['dni'];
$user =("SELECT nombre, apellido, perfil FROM usuarios WHERE dni = '$dni'");
$r = mysqli_query($conexion,$user);
$rs = mysqli_fetch_array($r); 
$nombre = $rs['nombre'];
$apellido = $rs['apellido'];
$perfil = $rs['perfil'];
?>
<body>
<!-- Page header -->
<div class="page-header page-header-dark">
	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark border-transparent">
		<div class="navbar-brand wmin-0 mr-5">
			<a href="home.php" class="d-inline-block">
				<img src="" alt="">
			</a>
		</div>
		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="navbar-mobile">
			<span class="badge bg-success-400">Admin Validador CFC</span>
			<ul class="navbar-nav ml-md-auto">	
				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
						<span><?php echo $apellido ?> <?php echo $nombre ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="cambiarcontrasena.php" class="dropdown-item"><i class="icon-lock"></i> Cambiar Contraseña</a>
						<a href="logout.php" class="dropdown-item"><i class="icon-switch2"></i> Salir</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4>Inicio <small class="font-size-base opacity-50">Bienvenido al Admin Validacion CFC</small></h4>
			<a href="#" class="header-elements-toggle text-white d-md-none"><i class="icon-more"></i></a>
		</div>
	</div>
	<div class="navbar navbar-expand-md navbar-dark border-top-0">
		<div class="d-md-none w-100">
			<button type="button" class="navbar-toggler d-flex align-items-center w-100" data-toggle="collapse" data-target="#navbar-navigation">
				<i class="icon-menu-open mr-2"></i>
				Menu
			</button>
		</div>
		<div class="navbar-collapse collapse" id="navbar-navigation">
			<ul class="navbar-nav navbar-nav-highlight">
				<li class="nav-item">
					<a href="home.php" class="navbar-nav-link active">
						<i class="icon-home4 mr-2"></i>
						Inicio
					</a>
				</li>
			</ul>
			<ul class="navbar-nav navbar-nav-highlight">
				<li class="nav-item">
					<a href="home_psico.php" class="navbar-nav-link active">
						<i class="icon-file-check2 mr-2"></i>
						PROGRAMA MUNICIPALIDAD MEJORAR
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="page-content">
	<div class="content-wrapper">
		<div class="content">
			<!-- Main charts -->
			<div class="row">
				<div class="col-xl-7">
				</div>				
			</div>