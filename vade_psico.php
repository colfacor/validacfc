<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
include('inc/conexion.php');
if (!isset($_SESSION['cuit'])) {
    header("location: index.php?msj=".base64_encode('cs')."");
}
$msj = $_GET['msj'];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Content area -->
<div class="content">
	<!-- Form validation -->
	<div class="card">

		<div class="card-body">
		<legend class="text-uppercase font-size-lg font-weight-bold"><span class='badge bg-warning-400'><h4>Vademecum : Puede entregar genericos en todos los casos. Las marcas sugeridas solo son de guia</h4></span></legend>
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
						<th>Marca</th>
						<th>Precio x U</th>
						
						
					</tr>
				</thead>
					<tbody id="tabla">
				    <?php
		            $registros = mysqli_query($conexion,"SELECT  a.troquel, a.medicamento, a.presentacion, a.cod_laboratorio, a.precio, a.estado, c.des, a.marca
		            	                                          
		                                                  FROM vade_psicotropicos a
		                                                  LEFT JOIN alfabeta_laboratorios c
		                                                  ON a.cod_laboratorio = c.id
		                                                  WHERE estado =1
		                                                  ORDER BY a.medicamento");

			           	while ($reg=mysqli_fetch_array($registros)){
			           	if($reg['estado'] == 1){  			         
		        	echo "<tr>"
				        		
		                ."<td><span class='badge bg-primary-400'><strong>".$reg['medicamento']."</strong>".$reg['presentacion']."</span></td>"
		               ."<td><span class='badge bg-danger-400'>".$reg['marca']."</span></td>"            
		                ."<td><strong> $ </strong>".$reg['precio']."</td>"	
		                	 
		                //."<td><a href='vade_municipalidad_estado.php?troquel=".$reg['troquel']."'><strong><span class='badge bg-success-400'>Activo</strong></a></td>"	
		                     
			            ."</tr>";   

			             }else{

			            echo "<tr>"
				        		
		                ."<td><span class='badge bg-primary-400'><strong>".$reg['medicamento']."</strong>".$reg['presentacion']."</span></td>"
		                ."<td><span class='badge bg-danger-400'>".$reg['marca']."</span></td>"            
		                ."<td><strong> $ </strong>".$reg['precio']."</td>"	
		                	 
		               // ."<td><a href='vade_municipalidad_estado.php?troquel=".$reg['troquel']."'><strong><span class='badge bg-danger-400'>Inactivo</strong></a></td>"	
		                     
			            ."</tr>"; 



			             } } ?>
					</tbody>
				</table>
			</div>                    
			<br>
			<div class="form-group">
				<a href="home.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
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