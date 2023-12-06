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
			<h5 class="card-title"><a href="pad_munpsiconew.php"><button type="button" class="btn btn-danger"> Nuevo Afiliado</button></a></h5>  <h5 class="card-title"><a href="pad_excel.php"><button type="button" class="btn btn-info"> Exportar Excel</button></a> </h5>
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
						<th>NOMBRE</th>
						<th>DNI</th>
						<th>GENERO</th>
						<th>FEC NAC</th>
						<th>USUARIO</th>
						<th>ESTADO</th>

					</tr>
				</thead>
					<tbody id="tabla">
				    <?php
		            $registros = mysqli_query($conexion," SELECT a.id, a.apellido, a.nombre, a.dni, a.genero, a.fec_nac, a.estado, b.apellido as ape 
		            	FROM pad_psicotropicos a 
		            	LEFT JOIN usuarios b 
		            	ON a.user = b.dni 
		            	ORDER BY a.apellido ASC");

			           	while ($reg=mysqli_fetch_array($registros)){  
			           	if($reg['estado'] == 1){     
		        		echo "<tr>"
		        		."<td>".$reg['apellido']." ".$reg['nombre']."</td>"
		                ."<td>".$reg['dni']."</td>"
		                ."<td>".$reg['genero']."</td>"
		                ."<td>".$reg['fec_nac']."</td>"
		                ."<td>".$reg['ape']."</td>"
		                ."<td><span class='badge bg-success-400'>ACTIVO</span>
		                <a href='pad_munpsico_mod.php?id=".base64_encode($reg['id'])."'><span class='badge badge-info'>Modificar</span></a>
		                </td>"
			            ."</tr>";  
			        	}else {
			            echo "<tr>"
		        		."<td>".$reg['apellido']." ".$reg['nombre']."</td>"
		                ."<td>".$reg['dni']."</td>"
		                ."<td>".$reg['genero']."</td>"
		                ."<td>".$reg['fec_nac']."</td>"
		                ."<td>".$reg['ape']."</td>"
		                ."<td><span class='badge bg-danger-400'>INACTIVO</span>
		                <a href='pad_munpsico_mod.php?id=".base64_encode($reg['id'])."'><span class='badge badge-info'>Modificar</span></a>
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