<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$idmatricula = base64_decode($_GET['idmatricula']);
$idsucursal = base64_decode($_GET['idsucursal']);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Content area -->
<div class="content">
	<!-- Form validation -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<div class="header-elements">
				<div class="list-icons">            		
           		<a class="list-icons-item" data-action="reload"></a>          	
            	</div>
        	</div>
		</div>


		<div class="card-body">
		<legend class="text-uppercase font-size-sm font-weight-bold">Farmacia <?php echo $idmatricula ?> |  <?php echo $idsucursal ?> Obras Habilitadas</legend>
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
						<th>OBRA SOCIAL</th>
					</tr>
				</thead>
					<tbody id="tabla">
				    <?php

		            $registros = mysqli_query($conexion,"SELECT b.obra_social 
		            	FROM farm_habilitadas a 
		            	LEFT JOIN obras_sociales b 
		            	ON a.id_obrasocial = b.id 
		            	LEFT JOIN users c 
		            	ON a.idmatricula = c.idmatricula AND a.idsucursal = c.idsucursal
		            	WHERE a.idmatricula = '$idmatricula' AND a.idsucursal AND '$idsucursal'");
			           	while ($reg=mysqli_fetch_array($registros)){   
		        		echo "<tr>"
		        		."<td><span class='badge badge-danger'>".$reg['obra_social']."</span></td>"
			            ."</tr>"; }?>
					</tbody>
				</table>
			</div>                    
			<br>
			<div class="form-group">
				<a href="usuarios.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
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