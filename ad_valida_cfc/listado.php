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
		 <h5 class="card-title"><a href="listado_excel.php"><button type="button" class="btn btn-info"> Exportar Excel</button></a> </h5>
			<div class="header-elements">
				<div class="list-icons">            		
           		<a class="list-icons-item" data-action="reload"></a>          	
            	</div>
        	</div>
		</div>


		<div class="card-body">
		<legend class="text-uppercase font-size-sm font-weight-bold">Listado</legend>
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
				<span class="font-weight-semibold">FELICITACIONES!</span> El Afiliado se ingreso con Exito.
		    </div>'; }
		    if($msj == 'md'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">FELICITACIONES!</span> El Afiliado se Modifico con Exito.
		    </div>'; }
		     if($msj == 'rep'){
			echo'
			<div class="alert alert-warning alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> El Afiliado ya se encuentra en el padron.
		    </div>'; } ?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover datatable-highlight">
				<thead>
					<tr class="bg-dark">
						<th>RECETA</th>
						<th>TIPO</th>
						<th>CANTIDAD DE MEDICAMENTO</th>
						<th>NOMBRE DE LA DROGA</th>
						<th>COMERCIAL</th>
						<th>PROFESIONAL SUSCRIPTOR</th>
						<th>DIAGNOSTICO</th>

					</tr>
				</thead>
					<tbody id="tabla">
				    <?php
		            $registros = mysqli_query($conexion," SELECT a.num_receta,b.tipo, b.mp_med, b.dni_afi, c.tipo, d.cantidad, d.troquel, e.troquel, e.medicamento, e.marca, f.mp, f.nombre, g.dni, g.diagnostico
		            	FROM validaciones a
		            	LEFT JOIN recetas b
		            	ON a.num_receta = b.num_receta
		            	LEFT JOIN tipos_medicamentos c 
		            	ON b.tipo = c.id
		            	LEFT JOIN detalle_recetas d
		            	ON a.num_receta = d.num_receta
		            	LEFT JOIN vade_psicotropicos e
		            	ON d.troquel = e.troquel
		            	LEFT JOIN pad_medicos f 
		            	ON b.mp_med = f.mp
		            	LEFT JOIN pad_psicotropicos g
		            	ON b.dni_afi = g.dni      

		            ");

			           	while ($reg=mysqli_fetch_array($registros)){  
			              
		        		echo "<tr>"
		                ."<td>".$reg['num_receta']."</td>"
		                ."<td>".$reg['tipo']."</td>"
		                ."<td>".$reg['cantidad']."</td>"
		                ."<td>".$reg['medicamento']."</td>"
		                ."<td>".$reg['marca']."</td>"
		                ."<td>".$reg['nombre']."</td>"
		                ."<td>".$reg['diagnostico']."</td>"
		           
			            ."</tr>";  
			        	
			      
			             }?>
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