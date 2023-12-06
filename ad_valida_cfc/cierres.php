<?php
include('inc/header.php');
include('inc/panel.php');
include('inc/conexion.php');
session_start();
$dni = $_SESSION['dni'];
?>
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Mis Cierres de Presentacion</h5><br>
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
		<?php 
	if(base64_decode($_GET['msj']) == 'an'){
	echo'
	<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<span class="font-weight-semibold">ATENCION!</span> El Cierre se Anulo con Exito.
    </div>'; }
    if(base64_decode($_GET['msj']) == 'ex'){
	echo'
	<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<span class="font-weight-semibold">ATENCION!</span> El Cierre se realizo con Exito.
    </div>'; } ?>
	
		<div class="table-responsive">
			<table class="table table-bordered table-hover datatable-highlight">
			<thead>
				<tr class="bg-dark">
					<th>Periodo</th>
					<th>cierre</th>
					<th>Recetas</th>
					<th>Total</th>
					<th class="text-center">Opciones</th>
				</tr>
			</thead>
				<tbody id="tabla">
			    <?php
			    include ('inc/conexion.php');
	            $registros = mysqli_query($conexion," SELECT a.periodo, a.num_cierre, a.cant_recetas, a.tf, a.fecha_alta
	            										FROM cierres_lotes a 
	            										LEFT JOIN detalle_cierres b 
	            										ON a.num_cierre = b.num_cierre
	            										LEFT JOIN validaciones c 
	            										ON b.num_receta = c.num_receta
	            										GROUP BY a.num_cierre");
	           	while ($reg=mysqli_fetch_array($registros)){        
	        		echo "<tr>"
	                ."<td>".$reg['periodo']."</td>"
	                ."<td>".$reg['num_cierre']."</td>"
					."<td>".$reg['cant_recetas']."</td>"
					."<td>$ ".number_format($reg['tf'], 2)."</td>"
					."<td>"."<a target='_blank' href='comprobantecierrepdf.php?num_cierre=".base64_encode($reg['num_cierre'])."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
					<a data-toggle='modal'><span class='badge bg-danger-400' data-toggle='modal' data-target='#a".$reg['num_cierre']."'>ELIMINAR</span></a></td>"
		            ."</tr>"; 

					echo "<div id='a".$reg['num_cierre']."' class='modal fade' tabindex='-1'>
					<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header bg-danger'>
							<h6 class='modal-title'>Eliminar Cierre de Lotes</h6>
							<button type='button' class='close' data-dismiss='modal'>&times;</button>
						</div>

						<div class='modal-body'>
							<h6 class='font-weight-semibold'>¿Esta seguro de Eliminar el Cierre de Lotes N ".$reg['num_cierre']."?</h6>
							<hr>								
						</div>

						<div class='modal-footer'>
							<button type='button' class='btn btn-secondary' data-dismiss='modal'>Salir</button>
							<a href='cierre_anular.php?num_cierre=".$reg['num_cierre']."'><button type='button' class='btn bg-danger'>Eliminar Cierre</button></a>
						</div>
					</div>
					</div>
					</div>"; }  ?>
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