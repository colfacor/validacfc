<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$num_receta = base64_decode($_GET['num_receta']);

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
			<fieldset class="mb-3">
				<legend class="text-uppercase font-size-sm font-weight-bold">Consumo Afiliado</legend>
				<h6>Afiliado <strong> <?php echo $num_receta ?></strong></h6>
				<?php 
				if($msj == 'error'){
				echo '<div class="alert alert-danger alert-styled-left alert-dismissible">
					<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
					<span class="font-weight-semibold">ERROR!</span> El DNI ingresado ya se encuentra registrado.
			    </div>'; }
			    ?>
	          


		    <div class="table-responsive">
				<table class="table table-bordered table-hover datatable-highlight">
				<thead>
					<tr class="bg-dark">
						<th>MEDICAMENTO</th>
						<th>TROQUEL</th>
						<th>FARMACIA</th>
						<th>CANTIDAD</th>
						<th>PRECIO X UNIDAD</th>
						<th>TOTAL</th>
						<th>CIERRE</th>
						
					</tr>
				</thead>
					<tbody id="tabla">
				    <?php
		            $registros = mysqli_query($conexion,"SELECT a.num_receta, a.fecha_alta, b.fecha_receta, b.mp_med, b.dni_afi, c.cantidad, c.precio, d.medicamento, d.presentacion, e.nombre, e.apellido, f.nombre as nom, f.apellido as ape, g.farmacia, f.diagnostico, c.troquel, h.periodo
                                  FROM validaciones a 
                                  LEFT JOIN recetas b 
                                  ON a.num_receta = b.num_receta
                                  LEFT JOIN detalle_recetas c 
                                  ON b.num_receta = c.num_receta
                                  LEFT JOIN vade_municipalidad d 
                                  ON c.troquel = d.troquel 
                                  LEFT JOIN pad_medicos e 
                                  ON b.mp_med = e.mp
                                  LEFT JOIN pad_psicotropicos f 
                                  ON b.dni_afi = f.dni
                                  LEFT JOIN users g 
                                  ON a.cuit_farm = g.cuit AND a.suc_farm = g.idsucursal
                                  LEFT JOIN detalle_cierres h 
                                  ON a.num_receta = h.num_receta
                                  WHERE a.num_receta = '$num_receta'
                                  ");

			           	while ($reg=mysqli_fetch_array($registros)){  
			              
		        		echo "<tr>"
		        		."<td>".$rs['num_receta']."</td>" 
		                ."<td>".$rs['medicamento']."</td>"
		                ."<td>".$reg['']."</td>"
		                ."<td>".$reg['']."</td>"		               
		                ."<td>
		               
		                </td>"
			            ."</tr>";   }?>
					</tbody>
				</table>
			</div>      
			
		
			</fieldset>		
			<a href="consumos.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
	
	</div>
</div>




































































