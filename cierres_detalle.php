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
$num_cierre = base64_decode($_GET['num_cierre']);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>

<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Detalle Cierre:  <?php echo $num_cierre ?></h5><br>
		<div class="header-elements">
			<div class="list-icons">
        		<a class="list-icons-item" data-action="reload"></a>
        	</div>
    	</div>   	
	</div>
	<div class="col-md-2">
	<button id="exportToExcel" class="btn btn-success">Exportar a Excel</button>
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
					<th>Receta</th>
					<th>Total</th>
					<th class="text-center">Opciones</th>
				</tr>
			</thead>
				<tbody id="tabla">
			    <?php
			    include ('inc/conexion.php');
	            $registros = mysqli_query($conexion," SELECT a.num_cierre, a.num_receta, a.tf, f.num_validacion
	            										FROM detalle_cierres a
	            										LEFT JOIN validaciones f 
	            										ON a.num_receta = f.num_receta
	            										WHERE a.num_cierre = '$num_cierre'
	            										GROUP BY a.num_receta, a.tf, f.num_validacion
	            										ORDER BY a.num_receta ASC");
	           	while ($reg=mysqli_fetch_array($registros)){  
	        		echo "<tr>"
	                ."<td><span class='badge bg-success-400'>".$reg['num_receta']."</span></td>"
					."<td><span class='badge bg-danger-400'>$ ".number_format($reg['tf'], 2)."</span></td>"
					."<td>"."<a href='cierres_detalle_receta.php?num_receta=".base64_encode($reg['num_receta'])."&num_cierre=".base64_encode($reg['num_cierre'])."'><span class='badge bg-info-400'>VER DETALLE</span></a>
					<a target='_blank' href='comprobantepdf.php?num_validacion=".base64_encode($reg['num_validacion'])."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
					</td>"
		            ."</tr>";  } ?>
				</tbody>
			</table>
		</div>                    
		<br>
		<div class="form-group">
			<a href="cierres.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
		</div>
	</div>
</div>
<script>
document.getElementById('exportToExcel').addEventListener('click', function () {
    // Recopila los datos de la tabla que deseas exportar
    const table = document.querySelector('.table');
    const ws = XLSX.utils.table_to_sheet(table);

    // Crea un libro y agrega la hoja de cálculo
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Hoja1');

    // Guarda el archivo Excel
    XLSX.writeFile(wb, 'Reporte_validadorcfc.xlsx');
});
</script>
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