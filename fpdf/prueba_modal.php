<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
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

    <?php 
	if($mn == '1'){
	echo'	
	<div class="alert alert-success alert-dismissible alert-styled-left border-top-0 border-bottom-0 border-right-0">
                <span class="font-weight-semibold"><strong>ATENCION!</strong></span> Afiliado Ingresado con Exito.
                <button type="button" class="close" data-dismiss="alert">×</button>
    </div>';} 

	if($mr == '1'){
	echo'	
	<div class="alert alert-danger alert-dismissible alert-styled-left border-top-0 border-bottom-0 border-right-0">
                <span class="font-weight-semibold"><strong>ATENCION!</strong></span> El Afiliado ya se Encuentra Registrado.
                <button type="button" class="close" data-dismiss="alert">×</button>
    </div>';}

    if($mfi == '1'){
	echo'	
	<div class="alert alert-danger alert-dismissible alert-styled-left border-top-0 border-bottom-0 border-right-0">
                <span class="font-weight-semibold"><strong>ATENCION!</strong></span> La Fecha de Nacimiento es MAYOR a la fecha actual.
                <button type="button" class="close" data-dismiss="alert">×</button>
    </div>';}
    ?>

		<div class="card-body">
				<div class="form-group">
		<a href="validacion_anulada.php"><button type="button" id="anulada" class="btn btn-primary"> Recetas Anuladas</button></a>
	</div>
			<div class="table-responsive">
			<table class="table table-bordered table-hover datatable-highlight">
				<thead>
					<tr class="bg-dark">
						<th>N Validacion</th>
						<th>N Receta</th>
						<th>Fecha</th>
						<th class="text-center">Opc</th>
					</tr>
				</thead>
				<tbody>
			    <?php
                $registros = mysqli_query($conexion," SELECT a.num_receta, a.estado, a.num_validacion, a.cuit_farm, a.suc_farm, a.fecha_alta, b.dni_afi
                										FROM validaciones a 
                										LEFT JOIN recetas b 
                										ON a.num_receta = b.num_receta
                										WHERE a.cuit_farm = $cuit and a.suc_farm = $idsucursal ");
               	while ($reg=mysqli_fetch_array($registros)){ 
               	if ($reg['estado'] == '1'){          
            		echo "<tr>"
	                ."<td>".$reg['num_validacion']."</td>"
	                ."<td>".$reg['num_receta']."</td>"
					."<td>".$reg['fecha_alta']."</td>"
					."<td>"."<a target='_blank' href='comprobantepdf.php?num_validacion=".$reg['num_validacion']."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
							<a href='validacion_anular.php?num_validacion=".$reg['num_validacion']."' data-toggle='modal'><button type='button' class='btn bg-danger' data-toggle='modal' data-target='#modal_theme_danger'>Anular Validacion <i class='icon-x ml-2'></i></button></a>
							</td>"

		            ."</tr>";  

		              }else {
		              	echo "<tr>"	               	                	               										
		            ."</tr>";  
		             }
		              }
		             ?>
		              
                      <?php

                       $registros = mysqli_query($conexion," SELECT a.num_receta, a.num_validacion, a.cuit_farm, a.suc_farm, a.fecha_alta, b.dni_afi, b.estado
                										FROM validaciones a 
                										LEFT JOIN recetas b 
                										ON a.num_receta = b.num_receta
                										WHERE a.cuit_farm = $cuit and a.suc_farm = $idsucursal ");
                       while ($reg=mysqli_fetch_array($registros)){ 

		           echo "'<div id='modal_theme_danger' class='modal fade' tabindex='-1'>
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class='modal-header bg-danger'>
								<h6 class='modal-title'>Anular Validacion</h6>
								<button type='button' class='close' data-dismiss='modal'>&times;</button>
							</div>

							<div class='modal-body'>
								<h6 class='font-weight-semibold'>¿Esta seguro de anular la validacion?</h6>
								<hr>								
							</div>

							<div class='modal-footer'>
								<button type='button' class='btn btn-link' data-dismiss='modal'>Salir</button>
								<a href='validacion_anular.php?num_validacion=".$reg['num_validacion']."'><button type='button' class='btn bg-danger'>Anular Validacion</button></a>
							</div>
						</div>
					</div>
				</div>";
		            }
                   
	            ?> 


				</tbody>
			</table>
		</div>
		                         
			<br>
			<div class="form-group">
				<a href="home.php"><button type="button" id="volver" class="btn btn-primary"> Volver</button></a>
			</div>
		</div>
	</div>
</div>

                              
			

