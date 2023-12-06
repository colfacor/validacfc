<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$msj = base64_decode($_GET['msj']);
$porcentaje = $_POST['porcentaje'];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Content area -->
<div class="content">
	<!-- Form validation -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="card-title"><a href="reporte_vademecum.php"><button type="button" class="btn btn-info"> Exportar Excel</button></a> </h5>
			<div class="header-elements">
				<div class="list-icons">            		          	
            	</div>
        	</div>
		</div>
		<div class="card-body">
			<legend class="text-uppercase font-size-sm font-weight-bold">Actualizar Precios</legend>
			<form action="vademecum_precios.php" method="POST">
			<div class="form-group row">
				<div class="col-3">
					<strong>Porcentaje</strong> <input type="text" class="form-control" name="porcentaje" value="<?php echo $porcentaje ?>">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-2">
					<button type="submit" class="btn btn-danger"> Actualizar</button>
				</div>
			</div>
			</form>
			<form action="vademecum_precios_genericos.php" method="POST">
			<div class="form-group row">
				<div class="col-2">
					<input type="hidden" value="<?php echo $porcentaje ?>">
					<button type="submit" class="btn btn-danger">Confirmar Actualizacion</button>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>
<div class="content">
	<!-- Form validation -->
	<div class="card">


		<div class="card-body">
		<legend class="text-uppercase font-size-sm font-weight-bold">Precios Vademecum Psicotropicos</legend>
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
				<span class="font-weight-semibold"></span> Los precios se modificaron con Exito.
		    </div>'; }
		    if($msj == 'valida'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold"></span> El medicamento se ingreso con Exito.
		    </div>'; }
		    if($msj == 'md'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold"></span> Medicamentos Actualizados con Exito.
		    </div>';}
		    if($msj == 'mod'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold"></span> Medicamento Actualizado con Exito.
		    </div>'; } ?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover datatable-highlight">
				<thead>
					<tr class="bg-dark">
						<th>Medicamento</th>
						<th>Presentacion</th>
						<th>Marca</th>
						<th>Laboratorio</th>
						<th>Precio Ant</th>
						<th>Precio Nue</th>
						<th>Estado</th>
						
						
					</tr>
				</thead>
					<tbody id="tabla">
				    <?php
		            $registros = mysqli_query($conexion,"SELECT  a.troquel, a.medicamento, a.presentacion, a.cod_laboratorio, a.precio, a.tipo, a.estado, a.marca, b.des , a.comprimidos     
		                                                  FROM vade_psicotropicos a
		                                                  LEFT JOIN alfabeta_laboratorios b 
		                                                  ON a.cod_laboratorio = b.id 
		                                                 ");

			           	while ($reg=mysqli_fetch_array($registros)){
			           	$troquel = $reg['troquel'];
			           	$reg_ = $reg['reg'];
			           	if($reg['estado'] == 1 AND $reg['tipo'] == 1){  		
			           	$precio_nuevo = ($reg['precio'] * $porcentaje)/100 + $reg['precio'];	         
		        		echo "<tr>"
				        		
		               // ."<td><strong>".$reg['troquel']."</td></strong>"
		                ."<td><span class='badge bg-warning-400'>GENERICO</span> <strong>".$reg['medicamento']."</td></strong>"
		                ."<td><span class='badge bg-primary-400'>".$reg['presentacion']."</td>"
		                ."<td><span class='badge bg-primary-400'>".$reg['marca']."</td>"
		                ."<td><span class='badge bg-danger-400'>".$reg['des']."</td>"	            
		                ."<td><strong> $ </strong>".$reg['precio']."</td>"
		                ."<td><strong> $ </strong>".number_format($precio_nuevo,2)."</td>"		 
		                ."<td><a href='vade_municipalidad_estado.php?troquel=".$reg['troquel']."'><strong><span class='badge bg-success-400'>Activo</strong></a>
		                <a href='vademecum_precios_update.php?troquel=".base64_encode($reg['troquel'])."'><strong><span class='badge bg-warning-400'>Editar Precio</strong></a>"
			            ."</tr>";   

			             }

			             if($reg['estado'] == 1 AND $reg['tipo'] == 2){  	
			            echo "<tr>"
				         //."<td><strong>".$rs['troquel']."</td></strong>"
		                ."<td><span class='badge bg-info-400'>ALFABETA</span> <strong>".$reg['medicamento']."</td></strong>"
		                ."<td><span class='badge bg-primary-400'>".$reg['presentacion']."</td>"
		                ."<td><span class='badge bg-primary-400'>".$reg['marca']."</td>"
		                ."<td><span class='badge bg-danger-400'>".$reg['des']."</td>"	            
		                ."<td><strong> $ </strong>".$reg['precio']."</td>"
		                ."<td><strong> $ </strong>".$reg['precio']."</td>"		 
		                ."<td><a href='vade_municipalidad_estado.php?troquel=".$reg['troquel']."'><strong><span class='badge bg-success-400'>Activo</strong></a>"
			            ."</tr>"; 



			             } 
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