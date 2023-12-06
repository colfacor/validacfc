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
$num_receta = base64_decode($_GET['num_receta']);
$num_cierre = base64_decode($_GET['num_cierre']);
?>
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Numero Receta: <?php echo $num_receta ?></h5><br>
		<div class="header-elements">
			<div class="list-icons">
        		<a class="list-icons-item" data-action="reload"></a>
        	</div>
    	</div>   	
	</div>
	<div class="card-body">
		 <div class="form-group row">	
			<div class="col-md-2">			
			</div>
			<div class="col-md-2">			
			</div>
			<div class="col-md-2">			
			</div>
			<div class="col-md-2">			
			</div>
			<div class="col-md-2">		
			</div>
			<div class="col-md-2">
				<input type="text" name="caja_busqueda" id="buscador" class="form-control rounded-round" placeholder="Buscar...."></input>
			</div>
	  </div>	
	
		<div class="table-responsive">
			<table class="table table-bordered table-hover datatable-highlight">
			<thead>
				<tr class="bg-dark">
					<th>Cantidad</th>
					<th>Receta</th>
					<th>Total</th>
					<th class="text-center">Opciones</th>
				</tr>
			</thead>
				<tbody id="tabla">
			    <?php
			    include ('inc/conexion.php');
	            $registros = mysqli_query($conexion," SELECT a.dni_afi, a.fecha_receta, c.apellido, c.nombre, d.cantidad, d.precio, e.medicamento, e.presentacion
	            										FROM recetas a
	            										LEFT JOIN pad_psicotropicos c 
	            										ON a.dni_afi = c.dni
	            										LEFT JOIN detalle_recetas d 
	            										ON d.num_receta = a.num_receta
	            										LEFT JOIN vade_psicotropicos e 
	            										ON d.troquel = e.troquel
	            										WHERE a.num_receta = '$num_receta'");
	           	while ($reg=mysqli_fetch_array($registros)){  
	           		$total = $reg['cantidad'] * $reg['precio'];
	        		echo "<tr>"
	        		."<td><span class='badge bg-success-400'>".$reg['cantidad']."</span></td>"
	                ."<td><span class='badge bg-primary-400'>".$reg['medicamento']."</span></td>"
	                ."<td><span class='badge bg-primary-400'>".$reg['presentacion']."</span></td>"
					."<td><span class='badge bg-danger-400'>$ ".number_format($total, 2)."</span></td>"
		            ."</tr>"; } ?>
				</tbody>
			</table>
		</div>                    
		<br>
		<div class="form-group">
			<a href="cierres_detalle.php?num_cierre=<?php echo base64_encode($num_cierre) ?>"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
  $("#buscador").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tabla tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>