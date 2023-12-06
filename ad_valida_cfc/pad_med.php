<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$msj = base64_decode($_GET['msj']);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Content area -->
<div class="content">
	<!-- Form validation -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="card-title"><a href="pad_mednew.php"><button type="button" class="btn btn-danger"> Nuevo Medico</button></a> </h5>
			
			<div class="header-elements">
				<div class="list-icons">            		
           		<a class="list-icons-item" data-action="reload"></a>          	
            	</div>
        	</div>
		</div>


		<div class="card-body">
		<legend class="text-uppercase font-size-sm font-weight-bold">Datos Medicos</legend>
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
			if($msj == 'ex'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">FELICITACIONES!</span> El Medico se ingreso con Exito.
		    </div>'; }
		    if($msj == 'md'){
			echo'
			<div class="alert alert-warning alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">FELICITACIONES!</span> El Medico se Modifico con Exito.
		    </div>'; }
		     if($msj == 'err'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> El Medico ya se encuentra en la base.
		    </div>'; } ?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover datatable-highlight">
				<thead>
					<tr class="bg-dark">
						<th>Nombre</th>
						<th>MP</th>
						<th>Especialidad</th>
						<th>Zona</th>
						<th>Centro</th>
						<th>Estado</th>
					</tr>
				</thead>
					<tbody id="tabla">
				    <?php
		            $registros = mysqli_query($conexion," SELECT * FROM pad_medicos ORDER BY nombre ASC");

			           	while ($reg=mysqli_fetch_array($registros)){  
			           	if($reg['estado'] == 1){     
		        		echo "<tr>"
		        		."<td>".$reg['nombre']."</td>"
		                ."<td>".$reg['mp']."</td>"
		                ."<td>".$reg['especialidad']."</td>"
		                ."<td>".$reg['zona']."</td>"
		                ."<td>".$reg['centro']."</td>"
		                ."<td><span class='badge bg-success-400'>ACTIVO</span>
		                <a href='pad_med_mod.php?id=".base64_encode($reg['id'])."'><span class='badge badge-info'>Modificar</span></a>
		                </td>"
			            ."</tr>";  }else {
			            	echo "<tr>"
		        		."<td>".$reg['nombre']."</td>"
		                ."<td>".$reg['mp']."</td>"
		                ."<td>".$reg['especialidad']."</td>"
		                ."<td>".$reg['zona']."</td>"
		                ."<td>".$reg['centro']."</td>"
		                ."<td><span class='badge bg-danger-400'>INACTIVO</span>
		                <a href='pad_med_mod.php?id=".base64_encode($reg['id'])."'><span class='badge badge-info'>Modificar</span></a>
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