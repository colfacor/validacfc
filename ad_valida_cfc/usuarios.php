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
			<h5 class="card-title"><a href="usuario_nuevo.php"><button type="button" class="btn btn-danger"> Nuevo Usuario</button></a></h5>
			<div class="header-elements">
				<div class="list-icons">            		
           		<a class="list-icons-item" data-action="reload"></a>          	
            	</div>
        	</div>
		</div>


		<div class="card-body">
		<legend class="text-uppercase font-size-sm font-weight-bold">Datos Usuario</legend>
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
		    if($msj == 'mod'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">FELICITACIONES!</span> El Usuario se Modifico con Exito.
		    </div>'; }
		     if($msj == 'res'){
			echo'
			<div class="alert alert-warning alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> Se Reestablecio la contraseña con EXITO. La nueva contraseña es el CUIT
		    </div>'; }
		    if($msj == 'valid'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">FELICITACIONES!</span> El Usuario se Registro con Exito.
		    </div>'; }
		    if($msj == 'error'){
			echo'
			<div class="alert alert-warning alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> El Usuario ya se encuentra registrado.
		    </div>'; } ?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover datatable-highlight">
				<thead>
					<tr class="bg-dark">
						<th>Matricula</th>
						<th>Farmacia</th>
						<th>Cuit</th>
						<th>Email</th>
						<th>Opciones</th>
					</tr>
				</thead>
					<tbody id="tabla">
				    <?php

		            $registros = mysqli_query($conexion,"SELECT * FROM users ORDER BY idmatricula ASC");

			           	while ($reg=mysqli_fetch_array($registros)){  
			           	if($reg['estado'] == 1) {

		        		echo "<tr>"
		        		."<td>".$reg['idmatricula']." <span class='badge badge-danger'>(".$reg['idsucursal'].")"."</span></td>"
		                ."<td>".$reg['farmacia']."</td>"
		                ."<td>".$reg['cuit']."</td>"
		                ."<td>".$reg['email']."</td>"
		                ."<td>
		                <span class='badge badge-success'>Activo</span>
		                <a href='usuario_editar.php?id=".base64_encode($reg['id'])."'><span class='badge badge-info'>Modificar</span></a>
		                <a href='reestablecer_contrasena.php?id=".base64_encode($reg['id'])."'><span class='badge badge-warning'>Reestablecer Contrasena</span></a>
		                 
		                	                
		                </td>"
			            ."</tr>";  

			             }

                  	if($reg['estado'] == 0) {

		        		echo "<tr>"
		        		."<td>".$reg['idmatricula']." <span class='badge badge-danger'>(".$reg['idsucursal'].")"."</span></td>"
		                ."<td>".$reg['farmacia']."</td>"
		                ."<td>".$reg['cuit']."</td>"
		                 ."<td>".$reg['email']."</td>"
		                ."<td>
		                <span class='badge badge-danger'>Inactivo</span>
		                <a href='usuario_editar.php?id=".base64_encode($reg['id'])."'><span class='badge badge-info'>Modificar</span></a>
		                <a href='reestablecer_contrasena.php?id=".base64_encode($reg['id'])."'><span class='badge badge-warning'>Reestablecer Contrasena</span></a>
		                
		                
		                 	                  
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