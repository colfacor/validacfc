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
$periodo = $rs1['periodo'];

$id_obrasocial = $_POST['id_obrasocial'];


$obr =("SELECT a.periodo, a.num_cierre, a.cant_recetas, a.tf, a.fecha_alta, d.obra_social
		FROM cierres_lotes a 
		LEFT JOIN detalle_cierres b 
		ON a.num_cierre = b.num_cierre
		LEFT JOIN validaciones c 
		ON b.num_receta = c.num_receta
		LEFT JOIN obras_sociales d 
		ON d.id = a.id_obrasocial
		WHERE c.cuit_farm = '$cuit' and c.suc_farm = '$idsucursal' AND a.periodo = '$periodo' AND a.id_obrasocial = '$id_obrasocial'
		GROUP BY a.periodo, a.num_cierre, a.cant_recetas, a.tf, a.fecha_alta, d.obra_social
		ORDER BY a.periodo DESC");
$r1 = mysqli_query($conexion,$obr);
$rs1 = mysqli_fetch_array($r1); 
$result_per = $rs1['periodo'];
?> 
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">CIERRES DE PRESENTACION</h5><br>
		<div class="header-elements">
    	</div>   	
	</div>
    <form action="cierre_consultar.php" method="POST">
		<div class="card-body">			
			<div class="form-group">
				<label class="d-block"><strong>Seleccione el Periodo: <?php echo $periodo ?></strong></label>
				<?php if($result_per == $periodo){ 
					echo'
					<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
						<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
						<span class="font-weight-semibold">ATENCION!</span> Ya posee un cierre en este periodo.
				    </div>';
				}else{
					echo'
				<select class="form-control select-fixed-single" name="periodo" id="periodo" data-fouc required>
	                <option value='.$periodo.'>'.$periodo.'</option></select>';
				
				} ?>
			</div>
			<br>	
			<input type="hidden" name="id_obrasocial" value="<?php echo $id_obrasocial?>">	
			<div class="form-group">
				<a href="cierre_os_seleccionar.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
				<?php if($result_per <> $periodo){ ?>
				<button type="submit" class="btn btn-primary">Confirmar</button>
				<?php } ?>
			</div>
		</form>
		</div>
	</div>
</div> 