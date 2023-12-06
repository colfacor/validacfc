<?php 
$mensaje_error = $_GET['mensaje_error']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Admin Validador CFC - Ingresar</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="global_assets/js/main/jquery.min.js"></script>
	<script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="assets/js/app.js"></script>
	<!-- /theme JS files -->

</head>

<style type="text/css">

body {
  height: 400px;
  background-image: url("images/foton.png");
  background-size: cover;
  background-repeat:no-repeat;
  background-position: center center;
  }

</style>

<body>
      
	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark">
		<div class="navbar-brand">
			<a href="index.php" class="d-inline-block">
				<img src="" alt="">
			</a>
		</div>

		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
			<span class="badge bg-danger ml-md-3 mr-md-auto">Admin Validador CFC</span>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Login form -->
				<form name="loginform" id="loginform" action="validar.php" method="post">
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<img src="images/logo_index.png" alt="">
								<h5 class="mb-0">Admin Validador CFC</h5>
								<div class="alert bg-primary text-white alert-styled-left alert-dismissible">
									<span class="font-weight-semibold">Bienvenido!</span> Ingrese sus Datos
							    </div>
							    <?php
							    $mensaje_error = $_GET['mensaje_error'];
							     if($mensaje_error == 1){ ?>
							    <div class="alert bg-danger text-white alert-styled-left alert-dismissible">
									<span class="font-weight-semibold">Usuario y Contraseña Inválidos</span>
							    </div>
							    <?php } ?>
							</div>
							


							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="number" class="form-control" placeholder="" name="dni">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password" class="form-control" name="contra" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-danger btn-block">Ingresar<i class="icon-circle-right2 ml-2"></i></button>
							</div>

							<!--<div class="text-center">
								<a type="submit" class="btn bg-info" data-toggle="modal" data-target="#modal_theme_danger">Olvido la Contraseña?</a>
							</div>-->
						</div>
					</div>
				</form>
				<!-- /login form -->
			</div>
			<!-- /content area -->
		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->
</body>
</html>
