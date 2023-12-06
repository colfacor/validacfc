<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_alta = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');
session_start();
$ip_add = $_SERVER['REMOTE_ADDR'];
$logFile = fopen("../log/log_consultas_man.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Consulta Receta: ".$cuit.' / '.$idsucursal.' - '.$ip_add) or die("Error escribiendo en el archivo");fclose($logFile);
$msj = base64_decode($_GET['msj']);
?>

<script type="text/javascript" src="jquery-1.12.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="jquery-ui.css">
<script type="text/javascript" src="jquery-ui.js"></script>

<!-- Content area -->
<div class="content">
		<!-- Form validation -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">RECETAS MUNICIPALIDAD PSICOTROPICOS</h5>
			<div class="header-elements">
				<div class="list-icons">
	        		<a class="list-icons-item" data-action="reload"></a>
	        	</div>
	    	</div>
		</div>
		<div class="card-body">		
		<?php 
			if($msj == 'copy'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> La Receta ya se encuentra registrada.
		    </div>'; }
		    if($msj == 'exp'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> La Receta se encuentra Vencida.
		    </div>'; }
		    if($msj == 'af'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> El paciente no se encuentra habilitado.
		    </div>'; } 
		    if($msj == 'md'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> El medico no se encuentra habilitado.
		    </div>'; }
		     if($msj == 'fe'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> La Fecha de Receta es Mayor a la Fecha Actual.
		    </div>'; }
		     if($msj == 'cons'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> El Paciente excedio el consumo del medicamento.
		    </div>'; } ?>		

		</div>
	</div>


	<!-- /table header styling -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<div class="header-elements">
				<div class="list-icons">
	        	</div>
	    	</div>
		</div>
		<div class="card-body">
			<form method="POST" action="val_munpsicoman_.php">
			<fieldset class="mb-3">
			<legend class="text-uppercase font-size-sm font-weight-bold">Datos Receta</legend>
			<div class="form-group row">
				<div class="col-3">
					<strong>Nombre Paciente</strong> <input style="text-transform:uppercase"  type="text" class="form-control" name="nombre" required> 
				</div>
				<div class="col-3">
					<strong>Apellido Paciente</strong> <input style="text-transform:uppercase"  type="text" class="form-control" name="apellido" required> 
				</div>
				<div class="col-3">
					<strong>DNI Paciente</strong> <input type="number" class="form-control" id="numeroInput" oninput="validarNumero(this)" name="dni" required>
				</div>
				  <script>
				    function validarNumero(input) {
				      var valor = input.value;

				      // Eliminar cualquier caracter que no sea un número
				      valor = valor.replace(/\D/g, '');

				      // Limitar la longitud a 8 caracteres
				      if (valor.length > 8) {
				        valor = valor.slice(0, 8); // Truncar a 8 caracteres
				      }

				      // Actualizar el valor del input
				      input.value = valor;

				      // Verificar si la longitud es 0
				      if (valor.length === 0) {
				        document.getElementById("mensajeError1").textContent = ""; // No hay error
				      } else if (valor.length <= 8) {
				        document.getElementById("mensajeError1").textContent = ""; // No hay error
				      } else {
				        document.getElementById("mensajeError1").textContent = "No más de 8 caracteres permitidos";
				      }
				    }
				  </script>
			</div>	
			<div class="form-group row">
						<!--<div class="col-3">
						<strong>N Receta</strong> (SOLO NUMEROS)
						    <input class="form-control" type="number" id="miInput" name="nro_receta"  oninput="validarInput(this)" required>
						</div>
						  <script>
						    function validarInput(input) {
						      // Eliminar caracteres que no son números
						      input.value = input.value.replace(/[^0-9]/g, '');

						      // Verificar si la longitud es mayor que 6 caracteres
						      if (input.value.length > 6) {
						        document.getElementById("mensaje-Error").textContent = "No más de 6 caracteres permitidos";
						        input.value = input.value.substring(0, 6); // Truncar a 6 caracteres
						      } else {
						        document.getElementById("mensaje-Error").textContent = "";
						      }
						    }
						  </script>-->
						<div class="col-4">
							<strong>Fecha Receta</strong> <input class="form-control" type="date" id="fechaInput" oninput="validarFecha(this)" name="fecha_receta" required>
						</div>
					
					 <script>
					    function validarFecha(input) {
					      var fechaIngresada = new Date(input.value);
					      var fechaActual = new Date();

					      // Comparamos la fecha ingresada con la fecha actual
					      if (fechaIngresada > fechaActual) {
					        document.getElementById("mensajeError").textContent = "La fecha no puede ser mayor que la actual";
					        input.value = ''; // Borrar el valor ingresado
					      } else {
					        document.getElementById("mensajeError").textContent = "";
					      }
					    }
					  </script>
					  <div class="col-3">
							<strong>MP Medico</strong> <input type="number" onchange="javascript:this.value=this.value.toUpperCase();" class="form-control" id="numeroInput1" oninput="validarNumero2(this)"  name="mp_med" required>
						</div>
						<script>
						    function validarNumero2(input) {
						      var valor = input.value;

						      // Eliminar cualquier caracter que no sea un número
						      valor = valor.replace(/\D/g, '');

						      // Limitar la longitud a 8 caracteres
						      if (valor.length > 6) {
						        valor = valor.slice(0, 8); // Truncar a 8 caracteres
						      }

						      // Actualizar el valor del input
						      input.value = valor;

						      // Verificar si la longitud es 0
						      if (valor.length === 0) {
						        document.getElementById("mensajeError2").textContent = ""; // No hay error
						      } else if (valor.length < 6) {
						        document.getElementById("mensajeError2").textContent = ""; // No hay error
						      } else {
						        document.getElementById("mensajeError2").textContent = "No más de 6 caracteres permitidos";
						      }
						    }
						</script>
					</div>
					<p id="mensaje-Error" style="color: red; display: none;">NUMERO INGRESADO INVALIDO. Debes ingresar un número que no contenga Guiones (-), ni CEROS (0) por delante. </p>
					<p id="mensajeError" style="color: red;"></p>
					<p id="mensajeError1" style="color: red;"></p>

					<div class="form-group row">
						
				
						<div class="col-5">
							<strong>Diagnostico</strong> <input type="text" style="text-transform:uppercase" class="form-control" name="diagnostico">
						</div>
					</div>
					<p id="mensajeError2" style="color: red;"></p>
					<div class="form-group row">
						<div class="col-6">
						<button id="botonGuardar" class="btn btn-danger" type="submit">Continuar con la Carga de Medicamentos</button>
						<a href="home.php"><button type="button" class="btn btn-dark">Volver</button></a>
					</div>
				</div>
					</form>
				</div>
			</div>
			</fieldset>	
		</div>			
	</div>
</div>