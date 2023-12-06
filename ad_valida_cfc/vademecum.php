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
			<h5 class="card-title"><a href="medicamento_nuevo.php"><button type="button" class="btn btn-danger"> Nuevo Medicamento</button></a> <a href="https://validacfc.colfacor.org.ar/crons/vademecum_precios_.php"><button target="_blank" type="button" class="btn btn-danger"> Actualizacion de Precios AB</button></a>  <a href="reporte_vademecum.php"><button type="button" class="btn btn-info"> Exportar Excel</button></a></h5>
			<div class="header-elements">
				<div class="list-icons">            		          	
            	</div>
        	</div>
		</div>

		<div class="card-body">
		<legend class="text-uppercase font-size-sm font-weight-bold">Vademecum Psicotropicos</legend>
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
				<span class="font-weight-semibold"></span> Medicamento ingresado con Exito.
		    </div>'; }
		    if($msj == 'valida'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold"></span> Medicamento ingresado con Exito.
		    </div>'; }
		    if($msj == 'md'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold"></span> Medicamento modificado con Exito.
		    </div>'; } ?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover datatable-highlight">
				<thead>
					<tr class="bg-dark">
					
						<th>Medicamento</th>
						<th>Presentacion</th>
						<th>Marca</th>
						<th>Laboratorio</th>
						<th>Precio</th>
						<th>Estado</th>
						
						
					</tr>
				</thead>
					<tbody id="tabla">
				    <?php
		            $registros = mysqli_query($conexion,"SELECT  a.troquel, a.medicamento, a.presentacion, a.cod_laboratorio, a.precio, a.tipo, a.estado, a.marca, b.des  , a.id    
		                                                  FROM vade_psicotropicos a
		                                                  LEFT JOIN alfabeta_laboratorios b 
		                                                  ON a.cod_laboratorio = b.id 
		                                                 ");

			           	while ($reg=mysqli_fetch_array($registros)){
			           	if($reg['estado'] == 1){  			         
		        	echo "<tr>"
				        		
		                //."<td><strong>".$reg['troquel']."</td></strong>"
		                ."<td><strong>".$reg['medicamento']."</td></strong>"
		                ."<td><span class='badge bg-primary-400'>".$reg['presentacion']."</td>"
		                ."<td><span class='badge bg-primary-400'>".$reg['marca']."</td>"
		                ."<td><span class='badge bg-danger-400'>".$reg['des']."</td>"	            
		                ."<td><strong> $ </strong>".$reg['precio']."</td>"	
		                	 
		                ."<td><a href='vade_municipalidad_estado.php?troquel=".$reg['troquel']."'><strong><span class='badge bg-success-400'>Activo</strong></a>
		                 <a href='vademecum_mod.php?id=".base64_encode($reg['id'])."'><span class='badge badge-info'>Modificar</span></a></td>"	
		                     
			            ."</tr>";   

			             }else{

			            echo "<tr>"
				         //."<td><strong>".$reg['troquel']."</td></strong>"
		                ."<td><strong>".$reg['medicamento']."</td></strong>"
		                ."<td><span class='badge bg-primary-400'>".$reg['presentacion']."</td>"
		                ."<td><span class='badge bg-primary-400'>".$reg['marca']."</td>"
		                ."<td><span class='badge bg-danger-400'>".$reg['des']."</td>"	            
		                ."<td><strong> $ </strong>".$reg['precio']."</td>"	
		                	 
		                ."<td><a href='vade_municipalidad_estado.php?troquel=".$reg['troquel']."'><strong><span class='badge bg-danger-400'>Inactivo</strong></a>
		                 <a href='vademecum_mod.php?id=".base64_encode($reg['id'])."'><span class='badge badge-info'>Modificar</span></a></td>"	
		                     
			            ."</tr>"; 



			             } } ?>
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