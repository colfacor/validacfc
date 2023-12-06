<?php $msj = base64_decode($_GET['msj']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Valida CFC - Ingresar</title>

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
<link rel="icon" href="favicon.ico">
</head>

<style type="text/css">

body {
  height: 400px;
  background: radial-gradient(circle, #dd1010, #7b0b0b);
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
			<span class="badge bg-danger ml-md-3 mr-md-auto">CFC VALIDA</span>
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
								<h5 class="mb-0"></h5>
								<div class="alert bg-primary text-white alert-styled-left alert-dismissible">
									<span class="font-weight-semibold">Bienvenido!</span> Ingrese sus Datos.
							    </div>
							    <?php
							     if($msj == 'err'){ ?>
							    <div class="alert bg-danger text-white alert-styled-left alert-dismissible">
									<span class="font-weight-semibold">Usuario y Contraseña Inválidos.</span>
							    </div>
							    <?php } ?>
							     <?php
							     if($msj == 'cs'){ ?>
							    <div class="alert bg-warning text-white alert-styled-left alert-dismissible">
									<span class="font-weight-semibold">Por tiempo y cuestiones de seguridad su sesion expiro, ingrese nuevamente sus datos.</span>
							    </div>
							    <?php } ?>
							</div>
							


							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="number" class="form-control" placeholder="CUIT" name="idmatricula">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<label for="user_login">Sucursal</label><br />
				                <select name="idsucursal" id="idsucursal" class="form-control input-lg m-bot15">
				                	<option value="1">1</option>
				                	<option value="2">2</option>
				                	<option value="3">3</option>
				                	<option value="4">4</option>
				                	<option value="5">5</option>
				                	<option value="6">6</option>
				                	<option value="7">7</option>
				                	<option value="8">8</option>
				                	<option value="9">9</option>
				                	<option value="10">10</option>
				                	<option value="11">11</option>
				                	<option value="12">12</option>
				                	<option value="13">13</option>
				                	<option value="14">14</option>
				                	<option value="15">15</option>
				                	<option value="16">16</option>
				                	<option value="17">17</option>
				                	<option value="18">18</option>
				                	<option value="19">19</option>
				            	</select>
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