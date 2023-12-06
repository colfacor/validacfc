<?php 
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
if (!isset($_SESSION['cuit'])) {
    header("location: index.php?msj=".base64_encode('cs')."");
     exit();
}
include('inc/conexion.php');
include('inc/header.php');
include('inc/panel.php');
include('api/funciones.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_alta = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');
$nro_receta_ = $_POST['nro_receta_'];
$dni = $_POST['dni'];
$ip_add = $_SERVER['REMOTE_ADDR'];
$msj = base64_decode($_GET['msj']);
if (!empty($dni)){
// RECIBO DATOS DE RECETA 
$respuesta = consultarReceta($dni,$nro_receta_);
$row=json_decode($respuesta,true);												
//print_r($respuesta);
$troquel = $row["troquel"];
$apellido = $row["apellido"];
$nombre = $row["nombre"];
$sigla_os = $row["sigla_os"];
$dni_ = $row["dni"];
$nroafiliado = $row["nroafiliado"];
$fechaemision = $row["fechaemision"];
$apellidomed = $row["apellidomed"];
$nombremed = $row["nombremed"];
$matricprescr = $row["matricprescr"];
$matricespec_prescr = $row["matricespec_prescr"];
$nro_receta = $row["nro_receta"];
$denominacion = $row["denominacion"];
$linkreceta = $row["linkreceta"];
$ley = $row["ley"];
$fecha_emision = substr($fechaemision, 0, 10);
$fecha_vencimiento = date("Y-m-d",strtotime($fecha_emision."+ 30 days")); 
}
$logFile = fopen("log/log_consultas.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Consulta Receta: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' | '.$nro_receta_.' - '.$dni ) or die("Error escribiendo en el archivo");fclose($logFile);
?>
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">VALIDAR RECETAS ELECTRONICAS</h5>
		<div class="header-elements">
			<div class="list-icons">
        		<a class="list-icons-item" data-action="reload"></a>
        	</div>
    	</div>
	</div>

	<div class="card-body">	
			<?php 
			 if($msj == 'cant'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> La Cantidad de Medicamentos permitida es hasta 3 por Receta.
		    </div>'; }
			if($msj == 'copy'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> La Receta ya se encuentra registrada.
		    </div>'; }
		    if($msj == 'fe'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> La Receta se encuentra Vencida.
		    </div>'; }
		    if($msj == 'af'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> El paciente no se encuentra en el Padron.
		    </div>'; } 
		     if($msj == 'fes'){
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
		    </div>'; }
		     if($msj == 'med'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> Medicamento fuera de Vademecum.
		    </div>'; }
		     if($msj == 'fh'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> La Farmacia no se encuentra habilitada para validar la Obra Social.
		    </div>'; } 
		     if($msj == 'comp'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> La Cantidad de Comprimidos es menor a la presentacion del Medicamento.
		    </div>'; } 
		   // if(!empty($respuesta)){
			//echo'
			//<div class="alert alert-warning alert-styled-left alert-arrow-left alert-dismissible">
			//	<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
			//	<span class="font-weight-semibold">ATENCION!</span> Error en servidor CMPC.
		    //</div>'; } ?>	
	<a href="val_munpsicoman.php"><button type="button"  class="btn btn-danger"><i class="icon-copy"></i> Receta Manual</button></a>
	<br><br>		
		<div class="click2edit">
			<div class="alert alert-warning alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">RECUERDE! </span> Ingrese el Numero de Receta SIN los 0, ni el (-).<p><span class="font-weight-semibold">EJEMPLO: </span> Si el numero es 0000045287-1, debe colocar 45287.</p>
	    	</div>	
		<hr>
			<div class="row">

			<form name="form1" method="POST" action="val_munpsico.php" id="cdr">
				<div class="form-group row">

				<label class="col-form-label col-lg-6">Buscar por DNI y Nro Receta (Hasta el -)</label>
					<div class="col-lg-12">
						<div class="input-group">
							<span class="input-group-prepend">
								<span class="input-group-text">NRO RECETA</span>
							</span>
							<input type="number" class="form-control" placeholder="" id="nro_receta_" name="nro_receta_" required>


							 <label for="numeroInput">Ingresa un número sin ceros por delante:</label>
    <input type="text" id="numeroInput" oninput="validarNumero(this)">
    <p id="mensajeError" style="color: red; display: none;">Entrada inválida. Debes ingresar un número sin ceros por delante.</p>

    <script>
        function validarNumero(input) {
            var valor = input.value.trim();
            var mensajeError = document.getElementById("mensajeError");

            if (!valor.match(/^[1-9][0-9]*$/)) {
                mensajeError.style.display = "block";
            } else {
                mensajeError.style.display = "none";
            }
        }
    </script>


    
							<span class="input-group-prepend">
								<span class="input-group-text">DNI</span>
							</span>
							<input type="number" class="form-control" placeholder="" id="dni" name="dni" required>
						</div>
					</div>
				</div>
			</div>	
			<div class="form-group">
				<button type="submit" class="btn btn-info" id="buscar">Buscar</button>
				<a href="home.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
			</div>
			</form>
			<?php 
			$receta =("SELECT num_receta, estado FROM validaciones	WHERE num_receta = '$nro_receta_'");
			$rs1 = mysqli_query($conexion,$receta);
			$row1 = mysqli_fetch_array($rs1); 
			$resultado = $row1['num_receta'];
			$estado = $row1['estado'];
			if($resultado == $nro_receta_ AND $estado == 1){
				echo '
				<span class="badge bg-danger-400">LA RECETA YA SE ENCUENTRA VALIDADA</span> ';
			}else{  
			if ($dni > 0 AND $dni_ == 0) {  
				echo '<span class="badge bg-danger-400">NO SE ENCONTRARON RESULTADOS CON LOS DATOS INGRESADOS</span> ';
			}?>
    	</div>
	</div>
	<?php if ($dni > 0 AND $dni_ > 0) {  ?>
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="card-title"></h5>
			<div class="header-elements">
				<div class="list-icons">
	    			<a class="list-icons-item" data-action="reload"></a>
	    		</div>
			</div>
		</div>

		<div class="card-body">				
			<div class="click2edit">
				<h5 class="card-title">Receta Electrónica</h5>
				<hr>
				<fieldset class="mb-2">
					<form method="POST" action="val_munpsico_.php">
					<div class="row row-sm">
						<div class="col-xl-12">
							<div class="card">
								<div class="card-body">									
									<div class="row">
										<div class="col-md-12">
								            <div class="card">
								                <div class="card-body">
								                	<table width="100%">
													    <tr>
													    <th colspan="2" width="50%" align="left"><font size="1.2em">Receta Electrónica <?php echo $sigla_os ?></font></th>
													    <th colspan="4" width="50%" align="right"><font size="0.8em">ORIGINAL</font></th>
													    </tr> 
													   <tr>
													      <td colspan="6" width="100%"><hr style="border: 1px solid #000;" /></td>
													    </tr>  
													    <tr>
													    	<td colspan="2" width="25%"><h2>Fecha:</h2> <?php echo $fecha_emision ?></td>
													      	<td colspan="2" width="50%"><h2>Nro: <?php echo $nro_receta_ ?></h2></td>
													      	<td colspan="2" width="25%"><img src="images/logo_fus.png" width="250px"></td>
													    </tr>
													    <tr>
													    	<td colspan="6" width="100%"><hr style="border: 1px solid #CCC;" />Paciente: <?php echo $apellido ?> <?php echo $nombre ?> - DNI: <?php echo $dni_ ?><br>
													    	<?php 
													    	$lista7 =("SELECT diagnostico FROM pad_psicotropicos WHERE dni = '$dni'");
															$rs7 = mysqli_query($conexion,$lista7);
															$row7 = mysqli_fetch_array($rs7); 
															$diagnostico = $row7['diagnostico'];
															?>
															Diagnostico = <?php echo $diagnostico ?><br>
													    	Nro Afiliado: <?php echo $nroafiliado ?><br>
													    	Obra Social: <?php echo $sigla_os ?></td>
													      <td colspan="6" width="60%"></td>
													    </tr>  

													    <tr>
													      <td colspan="3" width="40%"><font size="1em"><b></b></font> </td>  
													      <td colspan="3" width="60%"><font size="1em"></font> </td>
													    </tr>
													        <tr>
													      <td colspan="6" width="100%"><hr style="border: 1px solid #CCC;" /></td>
													    </tr> 
													    <tr>
													      <td colspan="6" width="100%"><font size="1.2em">Prescripción</font></td>
													    </tr> 
												    </table>

												    <table width="100%" border="1" cellspacing="0" bordercolor="ccc" cellpadding="2">
												    <tr>
												      <td colspan="1" width="3%"><b>COMPRIMIDOS</b></td>
												      <td colspan="1" width="20%"><b>MEDICAMENTO</b></td>
												      <td colspan="1" width="20%"><b>PRESENTACION</b></td>
												      <td colspan="1" width="20%"><b>PRECIO</b></td>
												    </tr>
												    
													<?php 
													if($sigla_os == 'MUNI-X-CBA'){
														foreach ($row["prescripcion"] as $item) {
														$troquel=$item["troquel"];
														$cant_prescripta=$item["cant_prescripta"];
														$nombrecomercial=$item["nombrecomercial"];
														$renglon=$item["renglon"];
														include('inc/conexion.php');
														$medi =("SELECT troquel, medicamento, presentacion, precio, marca FROM vade_psicotropicos WHERE troquel = '$troquel' AND estado = 1");
														$r = mysqli_query($conexion,$medi);
														$rs = mysqli_fetch_array($r); 
														$precio = $rs['precio'];
														$marca = $rs['marca'];
														$presentacion = $rs['presentacion'];
														$medicamento = $rs['medicamento'];
														if(empty($precio)){
														echo "<tr class='table-danger'>";
														echo "<td colspan='1' width='3%'><input name='cantidad[]' id='cantidad' value='".$cant_prescripta."'>";
														echo "<td colspan='1' width='3%'><FONT COLOR='red'>FUERA DE VADEMECUM | $medicamento";
														echo "<td colspan='1' width='3%'>$presentacion";
														echo "<td colspan='1' width='3%'>$precio";
														echo"<input type='hidden' name='troquel[]' id='troquel' value='".$troquel."'>";
														echo"<input type='hidden' name='renglon[]' id='renglon' value='".$renglon."'>";
													}else{
														echo "<tr>";
														echo "<td colspan='1' width='3%'><input name='cantidad[]' id='cantidad' value='".$cant_prescripta."'>";
														echo "<td colspan='1' width='3%'>$medicamento";
														echo "<td colspan='1' width='3%'>$presentacion";
														echo "<td colspan='1' width='3%'>$precio";
														echo"<input type='hidden' name='troquel[]' id='troquel' value='".$troquel."'>";
														echo"<input type='hidden' name='renglon[]' id='renglon' value='".$renglon."'>";
														}
													}}
													?>
												    </table>
												    <table width="100%" cellpadding="2">
												   	<tr>
												      <td colspan="6" width="100%"><hr style="border: 1px solid #CCC;" />Medico: <?php echo $matricprescr.' / '.$matricespec_prescr ?><br><?php echo $nombremed.' '.$apellidomed ?><br>
												      	<?php echo $denominacion ?>
												      </td>
												    </tr> 
												    <tr>
												    <?php
													padronSigipsa($dni);
													if(padronSigipsa($dni)<>'OK'){
														echo'
													<input type="hidden" name="sigipsa" value="EXCEPCION">
													';} 
													?>
												      <td colspan="6" width="100%"><hr style="border: 1px solid #CCC;" /></td>
												    </tr> 
												    <tr>
												      <td colspan="6" width="100%">Vence el día: <?php echo $fecha_vencimiento ?></font></td>	
												    </tr>
												    </table> 							
												</div>
								            </div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
				<div class="form-group">  
					<?php if($sigla_os == 'MUNI-X-CBA'){ ?>
					<button type="submit" id="guardar" class="btn btn-success"><i class="icon-checkmark3 mr-2"></i> Validar</button>
					<?php } ?>
					<a target="_blank" href="http://aplicaciones.cmpc.org.ar/receta/tmp/<?php echo $nro_receta_ ?>.pdf"><button type="button"  class="btn btn-danger"><i class="icon-printer"></i> Receta Original</button></a>
					<?php } ?> 
				</div>
			</div>
	    </div>
		<?php
		padronSigipsa($dni);
		if(padronSigipsa($dni)<>'OK'){
			echo'
		<input type="hidden" name="sigipsa" value="EXCEPCION">
		';} 
		?>
	    <input type="hidden" name="nro_receta" value="<?php echo $nro_receta_ ?>" required>
	    <input type="hidden" name="dni" value="<?php echo $dni ?>" required>
	    </form>
	</div>
<?php } ?>