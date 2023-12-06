<?php 
include('inc/header.php');
include('inc/panel.php');
$ip_add = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_hoy = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
if (!isset($_SESSION['cuit'])) {
    header("location: index.php?msj=".base64_encode('cs')."");
}
include ('inc/conexion_pad.php');
$lista7 =("SELECT * FROM ma_fechas_presentacion WHERE estado = 1 AND quincena = 1");
$rs2 = mysqli_query($conexion,$lista7);
$row7 = mysqli_fetch_array($rs2); 
$fecha_inicio = $row7['fecha_inicio'];
$fecha_bloqueo = $row7['fecha_bloqueo'];

?>
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Mis Cierres de Lotes</h5><br>
		<div class="header-elements">
			<div class="list-icons">
        		<a class="list-icons-item" data-action="reload"></a>
        	</div>
    	</div>   	
	</div>
	<div class="card-body">
		<?php if($fecha_hoy >= $fecha_inicio AND $fecha_hoy < $fecha_bloqueo){ ?>
		<a href="cierre_seleccionar.php"><button type="button" id="" class="btn btn-primary"> Realizar Cierre</button></a><br><br>
	<?php } ?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover datatable-highlight">
			<thead>
				<tr class="bg-dark">
					<th>Periodo</th>
					<th>cierre</th>
					<th>Recetas</th>
					<th>Total</th>
					<th class="text-center">Opc</th>
				</tr>
			</thead>
				<tbody>
			    <?php
			    include ('inc/conexion.php');
	            $registros = mysqli_query($conexion," SELECT a.periodo, a.num_cierre, a.cant_recetas, a.tf, a.fecha_alta
	            										FROM cierres_lotes a 
	            										LEFT JOIN validaciones b 
	            										ON a.num_cierre = b.num_cierre
	            										WHERE b.cuit_farm = '$cuit' and b.suc_farm = '$idsucursal' 
	            										GROUP BY a.num_cierre");
	           	while ($reg=mysqli_fetch_array($registros)){        
	        		echo "<tr>"
	                ."<td>".$reg['periodo']."</td>"
	                ."<td>".$reg['num_cierre']."</td>"
					."<td>".$reg['cant_recetas']."</td>"
					."<td>".$reg['tf']."</td>"
					."<td>"."<a target='_blank' href='comprobantecierrepdf.php?num_cierre=".$reg['num_cierre']."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
					<a data-toggle='modal'><span class='badge bg-danger-400' data-toggle='modal' data-target='#a".$reg['num_cierre']."'>ELIMINAR</span></a></td>"
		            ."</tr>"; 

					echo "<div id='a".$reg['num_cierre']."' class='modal fade' tabindex='-1'>
					<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header bg-danger'>
							<h6 class='modal-title'>Eliminar Cierre de Lotes</h6>
							<button type='button' class='close' data-dismiss='modal'>&times;</button>
						</div>

						<div class='modal-body'>
							<h6 class='font-weight-semibold'>¿Esta seguro de Eliminar el Cierre de Lotes N ".$reg['num_cierre']."?</h6>
							<hr>								
						</div>

						<div class='modal-footer'>
							<button type='button' class='btn btn-secondary' data-dismiss='modal'>Salir</button>
							<a href='cierre_anular.php?num_cierre=".$reg['num_cierre']."'><button type='button' class='btn bg-danger'>Eliminar Cierre</button></a>
						</div>
					</div>
					</div>
					</div>"; }  ?>
				</tbody>
			</table>
		</div>                    
		<br>
		<div class="form-group">
			<a href="home.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
		</div>
	</div>
</div>