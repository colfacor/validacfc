<?php 
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
if (!isset($_SESSION['cuit'])) {
    header("location: index.php?msj=".base64_encode('cs')."");
     exit();
}
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
include('api/funciones.php');
$fecha_hoy = date("Y-m-d");
$msj = base64_decode($_GET['msj']);
?>
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Validaciones</h5><br>
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
	if(!empty($_POST['tipo_opera'])){
		
	if(anularReceta_mun(base64_decode($_GET['num_receta']),base64_decode($_GET['tipo']),$_POST['tipo_opera']) == 'an'){
	echo'
	<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<span class="font-weight-semibold">ATENCION!</span> La Receta se Anulo con Exito.
    </div>'; } }
    if(base64_decode($_GET['msj']) == 'ex'){
	echo'
	<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<span class="font-weight-semibold">ATENCION!</span> La Receta se Valido con Exito.
    </div>'; }
     if(base64_decode($_GET['msj']) == 'an'){
	echo'
	<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<span class="font-weight-semibold">ATENCION!</span> La Receta se Anulo con Exito.
    </div>'; } ?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover datatable-highlight">
			<thead>
				<tr class="bg-dark">
					<th>Obra Social</th>
					<th>Estado</th>
				
					<th>Receta</th>
					<th>Afiliado</th>

					<th>F Rec</th>
					<th>Validacion</th>
					<th class="text-center">Opc</th>
				</tr>
			</thead>
				<tbody id="tabla">
			    <?php
	            $registros = mysqli_query($conexion," SELECT b.tipo, a.num_receta, a.estado, a.num_validacion, a.cuit_farm, a.suc_farm, a.fecha_alta, b.dni_afi, b.fecha_receta, d.obra_social, b.id_obrasocial, b.linkreceta
	            										FROM validaciones a 
	            										LEFT JOIN recetas b 
	            										ON a.num_receta = b.num_receta
	            										LEFT JOIN obras_sociales d
	            										ON d.id = b.id_obrasocial
	            										WHERE a.cuit_farm = '$cuit' and a.suc_farm = '$idsucursal' AND a.cierre = 0 ORDER BY a.fec DESC");
	           	while ($reg=mysqli_fetch_array($registros)){ 
	           	$fecha_vencimiento = date("Y-m-d",strtotime($reg['fecha_receta']."+ 30 days")); 
	           	if ($reg['estado'] == '1' AND $reg['tipo'] == 1 AND $fecha_vencimiento >= $fecha_hoy){          
	        		echo "<tr>"
	        		."<td><span class='badge bg-danger-400'>".$reg['obra_social']."</span></td>"
	        		."<td><span class='badge bg-success-400'>VALIDADO</span></td>"
	                ."<td><span class='badge bg-primary-400'>".$reg['num_receta']."</span></td>"
	                ."<td>".$reg['dni_afi']."</td>"
	                
					."<td>".$reg['fecha_receta']."</td>"
					."<td>".$reg['fecha_alta']."</td>"
					."<td>"."<a target='_blank' href='comprobantepdf.php?num_validacion=".base64_encode($reg['num_validacion'])."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
					<a target='_blank' href='".$reg['linkreceta']."'><button type='button' class='btn bg-warning-400 btn-icon '>Receta</button></a>
					
					<a data-toggle='modal'><span class='badge bg-danger-400' data-toggle='modal' data-target='#a".$reg['num_validacion']."'>ANULAR</span></a></td>"
		            ."</tr>";

		            echo "<div id='a".$reg['num_validacion']."' class='modal fade' tabindex='-1'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header bg-danger'>
										<h6 class='modal-title'>Anular Validacion</h6>
										<button type='button' class='close' data-dismiss='modal'>&times;</button>
									</div>

									<div class='modal-body'>
									<form id='formAnularValidacion' action='validaciones.php?msj=".base64_encode('an')."&num_receta=".base64_encode($reg['num_receta'])."&tipo=".base64_encode($reg['tipo'])."' method='POST'>
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
										
										<button type='submit' id='btnAnularValidacion' class='btn bg-danger'>Anular Validación</button>
									</div>
								</div>
								</form>
							</div>
						</div>"; } 

					if ($reg['estado'] == '1' AND $reg['tipo'] == 2 AND $fecha_vencimiento >= $fecha_hoy){          
	        		echo "<tr>"
	        		."<td><span class='badge bg-danger-400'>".$reg['obra_social']."</span></td>"
	        		."<td><span class='badge bg-success-400'>VALIDADO</span></td>"
	               
	                ."<td><span class='badge bg-primary-400'>".$reg['num_receta']."</span></td>"
	                ."<td>".$reg['dni_afi']."</td>"
	                
					."<td>".$reg['fecha_receta']."</td>"
					."<td>".$reg['fecha_alta']."</td>"
					."<td>"."<a target='_blank' href='comprobantepdf.php?num_validacion=".base64_encode($reg['num_validacion'])."&id_obrasocial=".base64_encode($reg['id_obrasocial'])."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
					
					<a data-toggle='modal'><span class='badge bg-danger-400' data-toggle='modal' data-target='#a".$reg['num_validacion']."'>ANULAR</span></a></td>"
		            ."</tr>";

		            echo "<div id='a".$reg['num_validacion']."' class='modal fade' tabindex='-1'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header bg-danger'>
										<h6 class='modal-title'>Anular Validacion</h6>
										<button type='button' class='close' data-dismiss='modal'>&times;</button>
									</div>

									<div class='modal-body'>
									<form action='validacion_anular_man.php?msj=".base64_encode('an')."&num_validacion=".base64_encode($reg['num_validacion'])."&tipo=".base64_encode($reg['tipo'])."' method='POST'>
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
										 <div class='loader' id='loader'></div>
									</div>
								</div>
								</form>
							</div>
						</div>"; } 

					if ($reg['estado'] == '1' AND $fecha_vencimiento < $fecha_hoy){          
	        		echo "<tr>"
	        		."<td><span class='badge bg-danger-400'>".$reg['obra_social']."</span></td>"
	        		."<td><span class='badge bg-success-400'>VALIDADO</span></td>"
	               
	                ."<td><span class='badge bg-primary-400'>".$reg['num_receta']."</span></td>"
	                ."<td>".$reg['dni_afi']."</td>"
					."<td>".$reg['fecha_receta']."</td>"
					."<td>".$reg['fecha_alta']."</td>"
					."<td>"."<a target='_blank' href='comprobantepdf.php?num_validacion=".base64_encode($reg['num_validacion'])."&id_obrasocial=".base64_encode($reg['id_obrasocial'])."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
					<a target='_blank' href='".$reg['linkreceta']."'><button type='button' class='btn bg-warning-400 btn-icon '>Receta</button></a></td>"
		            ."</tr>"; } 
		          
		          	} ?>
				</tbody>
			</table>
		</div>                    
		<br>
		<div class="form-group">
			<a href="home.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
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

<script>
    document.getElementById('formAnularValidacion').addEventListener('submit', function() {
        // Desactivar el botón después de hacer clic
        document.getElementById('btnAnularValidacion').setAttribute('disabled', 'disabled');
    });
</script>
<script src="scripts.js"></script>