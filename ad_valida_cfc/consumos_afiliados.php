<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$id = base64_decode($_GET['id']);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Content area -->
<div class="content">
	<!-- Form validation -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="card-title"> </h5>
			<div class="header-elements">
				<div class="list-icons">            		
           		<a class="list-icons-item" data-action="reload"></a>          	
            	</div>
        	</div>
		</div>


		<div class="card-body">
		<legend class="text-uppercase font-size-sm font-weight-bold">Datos Consumos</legend>
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
						<th>FECHA</th>
						<th>CIERRE</th>
						<th>MEDICAMENTO</th>
						<th>CANTIDAD</th>
					</tr>
				</thead>
					<tbody id="tabla">
				     <?php
		            $registros = mysqli_query($conexion," SELECT a.dni_afi, SUM(b.cantidad) as cantidad, b.troquel, a.num_receta, c.medicamento, c.presentacion, d.fecha_alta, e.periodo  
		            	FROM recetas a 
		            	LEFT JOIN detalle_recetas b 
		            	ON a.num_receta = b.num_receta
		            	LEFT JOIN vade_municipalidad c 
		            	ON b.troquel = c.troquel
		            	LEFT JOIN validaciones d 
		            	ON d.num_receta = a.num_receta
		            	LEFT JOIN detalle_cierres e 
		            	ON d.num_receta = e.num_receta
		            	WHERE a.dni_afi = '$id' 
		            	GROUP BY b.troquel
		            	ORDER BY b.id ASC");
			           	while ($reg=mysqli_fetch_array($registros)){    
		        		echo "<tr>"
		        		."<td>".$reg['fecha_alta']."</td>"
		        		."<td><span class='badge badge-success'>".$reg['periodo']."</span></td>"
		                ."<td><span class='badge badge-info'>".$reg['medicamento']." ".$reg['presentacion']."</span></td>"
		                ."<td><span class='badge badge-danger'>".$reg['cantidad']."</span></td>"
		                ."</tr>"; }?>
					</tbody>
				</table>
			</div>                    
			<br>
			<div class="form-group">
				<a href="consumos.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
			</div>
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