<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$msj = $_GET['msj'];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Content area -->
<div class="content">
	<!-- Form validation -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<div class="header-elements">
				<div class="list-icons">            		          	
            	</div>
        	</div>
		</div>
		<div class="card-body">
			<legend class="text-uppercase font-size-sm font-weight-bold">Reporte Consumos</legend>
			
			<form action="reporte_consumos.php" method="POST">
			<div class="form-group row">
				<div class="col-3">
							<strong>Periodo</strong><select name="periodo" class="form-control">
							<?php 
	                      	include('inc/conexion.php');
	                      	$result1 =  mysqli_query($conexion," SELECT periodo FROM cierres_lotes GROUP BY periodo DESC");
				           	while ($reg1=mysqli_fetch_array($result1)){  
	                             echo " <option value='".$reg1['periodo']."'>".$reg1['periodo']."</option>"; 
	                        }
	                        ?>  
							</select>
						</div>
			</div>
			<div class="form-group row">
				<div class="col-2">
					<button type="submit" class="btn btn-danger"> Buscar</button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>

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
		<legend class="text-uppercase font-size-sm font-weight-bold">Datos Afiliados</legend>
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
						<th>NOMBRE</th>
						<th>DNI</th>
						<th>OPCION</th>
					</tr>
				</thead>
					<tbody id="tabla">
				    <?php
		            	$registros = mysqli_query($conexion," SELECT DISTINCT(b.dni), b.id, b.apellido, b.nombre  
		            	FROM recetas a 
		            	LEFT JOIN pad_psicotropicos b 
		            	ON b.dni = a.dni_afi 
		            	ORDER BY b.apellido ASC");
			           	while ($reg=mysqli_fetch_array($registros)){    
		        		echo "<tr>"
		        		."<td>".$reg['apellido']." ".$reg['nombre']."</td>"
		                ."<td>".$reg['dni']."</td>"
		                ."<td> <a href='consumos_afiliados.php?id=".base64_encode($reg['dni'])."'><span class='badge badge-info'>Consumos</span></a>
		                </td>"
			            ."</tr>"; }?>
					</tbody>
				</table>
			</div>                    
			<br>
			<div class="form-group">
				<a href="home_psico.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
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