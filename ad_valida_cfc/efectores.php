<?php
include('inc/header.php');
include('inc/panel.php');
include('inc/conexion.php');
session_start();
$dni = $_SESSION['dni'];
?>
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="card-title"><a href="efectores_nuevo.php"><button type="button" class="btn btn-danger"> Nuevo Efector</button></a> </h5>
			
			<div class="header-elements">
				<div class="list-icons">            		
           		<a class="list-icons-item" data-action="reload"></a>          	
            	</div>
        	</div>
		</div>

	<div class="card-body">
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
	<div class="card-body">
	<?php 
	if(base64_decode($_GET['msj']) == 'md'){
	echo'
	<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<span class="font-weight-semibold">ATENCION!</span> El Efector se modifico con exito.
    </div>'; }
    if(base64_decode($_GET['msj']) == 'ex'){
	echo'
	<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<span class="font-weight-semibold">ATENCION!</span> El Efector se creo con exito.
    </div>'; } ?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover datatable-highlight">
			<thead>
				<tr class="bg-dark">
					<th>ZONA</th>
					<th>NOMBRE</th>
					<th>DOMICILIO</th>
					<th class="text-center">Opciones</th>
				</tr>
			</thead>
				<tbody id="tabla">
			    <?php
	            $registros = mysqli_query($conexion," SELECT id, zona, nombre, domicilio FROM efectores ORDER BY zona ASC");
	           	while ($reg=mysqli_fetch_array($registros)){ 
	           	$fecha_vencimiento = date("Y-m-d",strtotime($reg['fecha_receta']."+ 30 days"));         
	        		echo "<tr>"
	        		."<td><span class='badge bg-success-400'>".$reg['zona']."</span></td>"
	                ."<td>".$reg['nombre']."</td>"
					."<td>".$reg['domicilio']."</td>"
					."<td>"."<a href='efectores_update.php?id=".base64_encode($reg['id'])."'><button type='button' class='btn bg-primary-400 btn-icon'><i class='icon-pencil'></i></button></a>
				</td>"
		            ."</tr>";
		          	} ?>
				</tbody>
			</table>
		</div>                    
		<br>
		<div class="form-group">
			<a href="home_psico.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
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