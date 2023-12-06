<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$msj = $_GET['msj'];
$mp = $_GET['mp'];
$dni = $_SESSION['dni'];
$periodo = $_POST['periodo'];
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
		<legend class="text-uppercase font-size-sm font-weight-bold">Medico : <?php echo $mp ?></legend>
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
						<th>N Receta</th>
						<th>DNI Afiliado</th>
						<th>Afiliado</th>
						<th>Opciones</th>
						
					</tr>
				</thead>
					<tbody id="tabla">
				    <?php
		            $registros = mysqli_query($conexion," SELECT a.mp,
		            	                                           b.num_receta, b.mp_med, b.dni_afi,
		            	                                           c.dni, c.nombre, c.apellido
					                                                   FROM pad_medicos a
					                                                   LEFT JOIN recetas b
					                                                   ON a.mp = b.mp_med	
					                                                   LEFT JOIN pad_psicotropicos c
					                                                   ON b.dni_afi = c.dni		                                                   
					                                                   WHERE b.mp_med = '$mp'");

			           	while ($reg=mysqli_fetch_array($registros)){  			         
		        		echo '<tr>';
		        		   echo '<td><strong>'.$reg['num_receta'].'</td></strong>';
		        		   echo '<td><strong>'.$reg['dni_afi'].'</td></strong>';
		        		   echo '<td><strong>'.$reg['nombre'].' '.$reg['apellido'].'</td></strong>';
		        		   echo "<td><a href='cons_afi_ver_detalle.php?num_receta=".$reg['num_receta']."'><span class='badge badge-info'>Ver detalle receta</span></a></td>";
				        		              
			          echo  "</tr>"; }?>
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