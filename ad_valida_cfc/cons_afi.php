<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$msj = $_GET['msj'];
$mp = $_GET['mp'];
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
		<legend class="text-uppercase font-size-sm font-weight-bold"></legend>
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
			<?php 
			if($msj == 'valid'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">FELICITACIONES!</span> El Medico se ingreso con Exito.
		    </div>'; }
		    if($msj == 'md'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">FELICITACIONES!</span> El Medico se Modifico con Exito.
		    </div>'; } ?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover datatable-highlight">
				<thead>
					<tr class="bg-dark">
						<th>Nombre</th>
						<th>MP</th>
						<th>Estado</th>
					</tr>
				</thead>
					<tbody id="tabla">
				    <?php
		            $registros = mysqli_query($conexion," SELECT * FROM pad_medicos ORDER BY apellido ASC");

			           	while ($reg=mysqli_fetch_array($registros)){  
			           	if($reg['estado'] == 1){     
		        		echo "<tr>"
		        		."<td>".$reg['nombre']." ".$reg['apellido']."</td>"
		                ."<td>".$reg['mp']."</td>"
		                ."<td><span class='badge bg-success-400'>ACTIVO</span>
		                <a href='cons_afi_ver.php?mp=".$reg['mp']."'><span class='badge badge-info'>Ver</span></a>
		                </td>"
			            ."</tr>";  }else {
			            	echo "<tr>"
		        		."<td>".$reg['nombre']." ".$reg['apellido']."</td>"
		                ."<td>".$reg['mp']."</td>"
		                ."<td><span class='badge bg-danger-400'>INACTIVO</span>
		                <a href='cons_afi_ver.php?mp=".$reg['mp']."'><span class='badge badge-info'>Ver</span></a>
		                </td>"
			            ."</tr>";
			            }  }?>
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