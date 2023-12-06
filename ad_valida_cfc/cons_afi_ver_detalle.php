<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$msj = $_GET['msj'];
$num_receta = $_GET['num_receta'];
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
		<legend class="text-uppercase font-size-sm font-weight-bold">Receta:  <?php echo $num_receta ?></legend>
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
						<th>Cantidad</th>
						<th>Medicamento</th>
						<th>Presentacion</th>
						<th>Precio</th>
						
					</tr>
				</thead>
					<tbody id="tabla">
				    <?php
		            $registros = mysqli_query($conexion," SELECT a.num_receta, a.fecha_receta, a.dni_afi, a.fecha_alta
		            	                                           b.num_receta, b.cantidad, b.troquel, b.precio,
		            	                                           c.medicamento, c.presentacion, c.troquel
		            	                                    FROM recetas a
		            	                                    LEFT JOIN detalle_recetas b
		            	                                    ON a.num_receta = b.num_receta
		            	                                    LEFT JOIN vade_municipalidad c
		            	                                    ON b.troquel = c.troquel
		            	                                    WHERE a.num_receta = '$num_receta'
		            	                                    ");

			           	while ($reg=mysqli_fetch_array($registros)){  			         
		        		echo '<tr>';
		        		   echo '<td><strong>'.$reg['cantidad'].'</td></strong>';
		        		   echo '<td><strong>'.$reg['medicamento'].'</td></strong>';
		        		   echo '<td><strong>'.$reg['presentacion'].'</td></strong>';
		        		   echo '<td><strong>'.$reg['precio'].'</td></strong>';
        		              
			          echo  "</tr>"; }?>
					</tbody>
				</table>
			</div>                    
			<br>
			<div class="form-group">
				<a href="cons_afi_ver.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
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