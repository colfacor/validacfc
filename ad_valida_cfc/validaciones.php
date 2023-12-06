<?php
include('inc/header.php');
include('inc/panel.php');
include('inc/conexion.php');
session_start();
$dni = $_SESSION['dni'];
?>
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Mis Validaciones</h5><br>
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
	if(base64_decode($_GET['msj']) == 'an'){
	echo'
	<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<span class="font-weight-semibold">ATENCION!</span> La Receta se Anulo con Exito.
    </div>'; }
    if(base64_decode($_GET['msj']) == 'ex'){
	echo'
	<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<span class="font-weight-semibold">ATENCION!</span> La Receta se Valido con Exito.
    </div>'; } ?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover datatable-highlight">
			<thead>
				<tr class="bg-dark">
					<th>Farmacia</th>
					<th>N Validacion</th>
					<th>N Receta</th>
					<th>DNI Afiliado</th>
					<th>Afiliado</th>
					<th>Fecha Rec</th>
					<th>Validacion</th>
					<th class="text-center">Opciones</th>
				</tr>
			</thead>
				<tbody id="tabla">
			    <?php
	            $registros = mysqli_query($conexion," SELECT b.tipo, a.num_receta, a.estado, a.num_validacion, a.cuit_farm, a.suc_farm, a.fecha_alta, b.dni_afi, c.dni, c.nombre, c.apellido, c.apellido, b.fecha_receta
	            										FROM validaciones a 
	            										LEFT JOIN recetas b 
	            										ON a.num_receta = b.num_receta
	            										LEFT JOIN pad_psicotropicos c
	            										ON b.dni_afi = c.dni
	            										ORDER BY a.fec DESC");
	           	while ($reg=mysqli_fetch_array($registros)){ 
	           	$fecha_vencimiento = date("Y-m-d",strtotime($reg['fecha_receta']."+ 30 days")); 
	           	if ($reg['estado'] == '1' AND $reg['tipo'] == 1 AND $fecha_vencimiento >= $fecha_hoy){          
	        		echo "<tr>"
	        		."<td>".$reg['cuit_farm']." | ".$reg['suc_farm']."</td>"
	                ."<td>".$reg['num_validacion']."</td>"
	                ."<td><span class='badge bg-success-400'>".$reg['num_receta']."</span></td>"
	                ."<td>".$reg['dni_afi']."</td>"
	                ."<td>".$reg['nombre']." ".$reg['apellido']."</td>"
					."<td>".$reg['fecha_receta']."</td>"
					."<td>".$reg['fecha_alta']."</td>"
					."<td>"."<a target='_blank' href='comprobantepdf.php?num_validacion=".base64_encode($reg['num_validacion'])."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
					
				</td>"
		            ."</tr>";

		            echo "<div id='a".$reg['num_validacion']."' class='modal fade' tabindex='-1'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header bg-danger'>
										<h6 class='modal-title'>Anular Validacion</h6>
										<button type='button' class='close' data-dismiss='modal'>&times;</button>
									</div>

									<div class='modal-body'>
									<form action='validacion_anular.php?num_validacion=".base64_encode($reg['num_validacion'])."&tipo=".base64_encode($reg['tipo'])."' method='POST'>
										<h6 class='font-weight-semibold'>¿Esta seguro de anular la validacion ".$reg['num_validacion']."?</h6>
										<hr>
										<div class='form-group row'>
											<label class='col-form-label col-lg-3'>MOTIVO <span class='text-danger'></span></label>
											<div class='col-lg-6'>
												<select name='tipo_opera' class='form-control' required>
													<option value='1'>NEGATIVA DEL PACIENTE</option> 
													<option value='2'>FALTA STOCK</option> 
													<option value='3'>OTROS</option> 
												</select>
											</div>
										</div>															
									</div>

									<div class='modal-footer'>
										<button type='button' class='btn btn-secondary' data-dismiss='modal'>Salir</button>
										<button type='submit' class='btn bg-danger'>Anular Validacion</button>
									</div>
								</div>
							</div>
						</div>"; } 

						if ($reg['estado'] == '1' AND $reg['tipo'] == 2 AND $fecha_vencimiento >= $fecha_hoy){          
	        		echo "<tr>"
	        		."<td><span class='badge bg-success-400'>VALIDADO</span></td>"
	                ."<td>".$reg['num_validacion']."</td>"
	                ."<td><span class='badge bg-primary-400'>".$reg['num_receta']."</span></td>"
	                ."<td>".$reg['dni_afi']."</td>"
	                ."<td>".$reg['nombre']." ".$reg['apellido']."</td>"
					."<td>".$reg['fecha_receta']."</td>"
					."<td>".$reg['fecha_alta']."</td>"
					."<td>"."<a target='_blank' href='comprobantepdf.php?num_validacion=".base64_encode($reg['num_validacion'])."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
					
				</td>"
		            ."</tr>";

		            echo "<div id='a".$reg['num_validacion']."' class='modal fade' tabindex='-1'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header bg-danger'>
										<h6 class='modal-title'>Anular Validacion</h6>
										<button type='button' class='close' data-dismiss='modal'>&times;</button>
									</div>

									<div class='modal-body'>
									<form action='validacion_anular.php?num_validacion=".base64_encode($reg['num_validacion'])."&tipo=".base64_encode($reg['tipo'])."' method='POST'>
										<h6 class='font-weight-semibold'>¿Esta seguro de anular la validacion ".$reg['num_validacion']."?</h6>
										<hr>
										<div class='form-group row'>
											<label class='col-form-label col-lg-3'>MOTIVO <span class='text-danger'></span></label>
											<div class='col-lg-6'>
												<select name='tipo_opera' class='form-control' required>
													<option value='1'>NEGATIVA DEL PACIENTE</option> 
													<option value='2'>FALTA STOCK</option> 
													<option value='3'>OTROS</option> 
												</select>
											</div>
										</div>															
									</div>

									<div class='modal-footer'>
										<button type='button' class='btn btn-secondary' data-dismiss='modal'>Salir</button>
										<button type='submit' class='btn bg-danger'>Anular Validacion</button>
									</div>
								</div>
							</div>
						</div>"; } 

						if ($reg['estado'] == '1' AND $fecha_vencimiento < $fecha_hoy){          
	        		echo "<tr>"
	        		."<td><span class='badge bg-success-400'>VALIDADO</span></td>"
	                ."<td>".$reg['num_validacion']."</td>"
	                ."<td><span class='badge bg-primary-400'>".$reg['num_receta']."</span></td>"
	                ."<td>".$reg['dni_afi']."</td>"
	                ."<td>".$reg['nombre']." ".$reg['apellido']."</td>"
					."<td>".$reg['fecha_receta']."</td>"
					."<td>".$reg['fecha_alta']."</td>"
					."<td>"."<a target='_blank' href='comprobantepdf.php?num_validacion=".base64_encode($reg['num_validacion'])."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a></td>"
		            ."</tr>"; } 
		          
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