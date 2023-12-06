<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
if (!isset($_SESSION['cuit'])) {
    header("location: index.php?msj=".base64_encode('cs')."");
}
$obr =("SELECT * FROM ma_fechas_presentacion WHERE estado = 1");
$r1 = mysqli_query($conexion,$obr);
$rs1 = mysqli_fetch_array($r1); 
$quincena = $rs1['quincena'];
$estado = $rs1['estado'];

?> 
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">CIERRES DE PRESENTACION</h5><br>
		<div class="header-elements">
    	</div>   	
	</div>
    <form action="cierre_seleccionar.php" method="POST">
		<div class="card-body">			
			<div class="form-group">
				<label class="d-block"><strong>Seleccione la Obra Social:</strong></label>
				<select class="form-control select-fixed-single" name="id_obrasocial" id="id_obrasocial" data-fouc required>
				<?php	 $registros = mysqli_query($conexion," SELECT * FROM obras_sociales
	            										WHERE estado= 1 and quincena = '$quincena'");
	           	while ($reg=mysqli_fetch_array($registros)){ 
	           		echo"
	                <option value='".$reg['id']."'>".$reg['obra_social']."</option> ";
					} ?>
				</select>
			</div>
			<br>		
			<div class="form-group">
				<a href="cierres.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</form>
		</div>
	</div>
</div> 