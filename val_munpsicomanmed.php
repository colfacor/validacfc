<?php 
include('inc/header.php');
include('inc/panel.php');
include ('inc/conexion.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_alta = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');
session_start();
$msj = base64_decode($_GET['msj']);

$num_receta = $_SESSION['num_receta'];
$ip_add = $_SERVER['REMOTE_ADDR'];
$logFile = fopen("../log/log_consultas.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Consulta Receta: ".$cuit.' / '.$idsucursal.' - '.$ip_add) or die("Error escribiendo en el archivo");fclose($logFile);
?>
<!-- Content area -->
<div class="content">
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">RECETAS MUNICIPALIDAD PSICOTROPICOS</h5>
			<div class="header-elements">
				<div class="list-icons">
	        		<a class="list-icons-item" data-action="reload"></a>
	        	</div>
	    	</div>
		</div>
		<div class="card-body">	
		<?php 
		    if($msj == 'cant'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> La Cantidad de Medicamentos permitida es hasta 4 por Receta.
		    </div>'; }
		    if($msj == 'canti'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> La Cantidad tiene que ser Mayor a 0.
		    </div>'; }
		     if($msj == 'ex'){
			echo'
			<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> El Medicamento se agrego con exito.
		    </div>'; }
		    if($msj == 'el'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> El Medicamento se elimino con exito.
		    </div>'; }
		     if($msj == 'cons'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> El Paciente excedio el consumo del medicamento.
		    </div>'; } 
		     if($msj == 'ingmed'){
			echo'
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<span class="font-weight-semibold">ATENCION!</span> Debe ingresar Medicamentos.
		    </div>'; } ?>		
	<div class="card">
		<div class="card-header header-elements-inline">
			<div class="header-elements">
				<div class="list-icons">
	        	</div>
	    	</div>
		</div>
		<div class="card-body">
			<form method="POST" action="val_munpsicomanmed_.php">
			<fieldset class="mb-3">
			<legend class="text-uppercase font-size-sm font-weight-bold">Datos Receta</legend>

					<div class="form-group row">
						<div class="col-8">
							<strong>Buscar Medicamento</strong><span class="input-group-prepend">	<select class="form-control select-search" id="opciones" data-fouc>
							<?php 
					      	$result1 =  mysqli_query($conexion,"SELECT * FROM vade_psicotropicos");
					       	while ($reg1=mysqli_fetch_array($result1)){  
					             echo " <option value='".$reg1['id']."'>".$reg1['medicamento']." | ".$reg1['presentacion']." | ".$reg1['marca']."</option>"; 
					        }
					        ?>  
						</select></span>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-4">
							<strong>Cantidad</strong> <input type="number" class="form-control" id="" name="cantidad" value="" required>
						</div>
						<div class="col-6">
							<strong>Medicamento</strong> <input type="text" class="form-control" id="inputResultado2" name="medicamento" value="" readonly>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-4">
							<strong>Presentacion</strong> <input type="text" class="form-control" id="inputResultado4" name="presentacion" value="" readonly>
						</div>
						<div class="col-4">
							<strong>Marca</strong> <input type="text" id="inputResultado3" class="form-control" name="marca" value="" readonly>
						</div>
						<div class="col-4">
							<strong>Precio * Comprimido</strong> <input type="text" id="inputResultado5" class="form-control" name="precio" value="" readonly>
						</div>
						<input type="hidden" id="inputResultado1" class="form-control" name="troquel" value="<?php echo $troquel ?>" readonly>
					</div>

					<div class="form-group row">
						<button id="botonGuardar" class="btn btn-danger" type="submit">Continuar con la Carga de Medicamentos</button>
					</div>
				</form>
				</div>	
			</div>
		</div>
	</div>
</div>
<?php 
	$lista =("SELECT a.num_receta, a.fecha_receta, a.mp_med, a.dni_afi, b.nombre, b.apellido, d.troquel
				FROM recetas a
				LEFT JOIN pad_psicotropicos b 
				ON a.dni_afi = b.dni 
				LEFT JOIN detalle_recetas d 
				ON a.num_receta = d.num_receta
				WHERE a.num_receta = '$num_receta'");
	$rs = mysqli_query($conexion,$lista);
	$row = mysqli_fetch_array($rs); 
	$nombre = $row['nombre'];
	$apellido = $row['apellido'];
	$mp_med = $row['mp_med'];
	$dni_afi = $row['dni_afi'];
	$troquel_ = $row['troquel'];
?>
	<!-- Content area -->
<div class="content">

<!-- Basic table -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<legend class="text-uppercase font-size-sm font-weight-bold">Datos Receta N° <?php echo $num_receta ?></legend>	
			<div class="header-elements">
				<div class="list-icons">
            		<a class="list-icons-item" data-action="collapse"></a>
            	</div>
        	</div>
		</div>
		<div class="card-body">
			<strong><u>Afiliado:</u></strong> <?php echo $nombre.' '.$apellido.' | <strong><u>DNI:</u></strong> '.$dni_afi ?><br>
			<strong><u>Matricula:</u></strong> <?php echo $mp_med  ?><br>
		</div>
		<?php if($troquel_ >0){ ?>
            <div class="card-body">
		    <div class="table-responsive">
			<table class="table">

				<thead>
					<tr>
						<th>Cant</th>
						<th>Medicamento</th>
						<th>Precio</th>
						<th>Opc</th>
					</tr>
				</thead>
				<tbody>
				 <?php
	            $registros = mysqli_query($conexion,"SELECT d.cantidad, d.precio, e.medicamento, d.id, e.marca, e.presentacion 
													FROM detalle_recetas d 
													LEFT JOIN vade_psicotropicos e 
													ON d.troquel = e.troquel
													WHERE d.num_receta = '$num_receta' ");
           		while ($reg=mysqli_fetch_array($registros)){ 
           		$precio_total = $reg['precio'] * $reg['cantidad'];
				echo "<tr>"
                ."<td>".$reg['cantidad']."</td>"
                ."<td>".$reg['medicamento']." ".$reg['presentacion']." | ".$reg['marca']."</td>"
				."<td>$ ".$precio_total."</td>"
				."<td>"."<a data-toggle='modal'><span class='badge bg-danger-400' data-toggle='modal' data-target='#a".$reg['id']."'>Eliminar</span></a></td>"
	            ."</tr>";
	            echo "	
	            <div id='a".$reg['id']."' class='modal fade' tabindex='-1'>
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class='modal-header bg-danger'>
								<h6 class='modal-title'>Eliminar Medicamento</h6>
								<button type='button' class='close' data-dismiss='modal'>&times;</button>
							</div>

							<div class='modal-body'>
								<h6 class='font-weight-semibold'>¿Esta seguro de Eliminar ".$reg['medicamento']."?</h6>
								<hr>								
							</div>

							<div class='modal-footer'>
								<button type='button' class='btn btn-secondary' data-dismiss='modal'>Salir</button>
								<a href='eliminar_medicamento.php?id=".base64_encode($reg['id'])."'><button type='button' class='btn bg-danger'>Eliminar Medicamento</button></a>
							</div>
						</div>
					</div>
				</div>"; } ?>
				</tbody>
				<footer>
					<tr>
						<th></th>
						<th>TOTAL</th>
						<?php 
						$lista =("SELECT SUM(precio * cantidad) as total
									FROM detalle_recetas 
									WHERE num_receta = '$num_receta'");
						$rs = mysqli_query($conexion,$lista);
						$row = mysqli_fetch_array($rs); 
						$total = $row['total'];
						?>
						<th>$ <?php echo number_format($total, 2);?></th>
						<th></th>
					</tr>
				</footer>
			</table>
		</div>
	</div>
<?php } ?>
	<!-- /basic table -->
 </div>
 <a data-toggle='modal' data-toggle='modal' data-target='#b'><button type="button" class="btn btn-danger">Anular Receta</button></a>
 <a href="val_munpsicomanval.php?num_receta=<?php echo base64_encode($num_receta) ?>"><button type="button" class="btn btn-success">Validar Receta</button></a>
</div>

 <div id='b' class='modal fade' tabindex='-1'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header bg-danger'>
				<h6 class='modal-title'>Eliminar Receta</h6>
				<button type='button' class='close' data-dismiss='modal'>&times;</button>
			</div>

			<div class='modal-body'>
				<h6 class='font-weight-semibold'>¿Esta seguro de Eliminar la Receta N° <?php echo $num_receta ?> ?</h6>
				<hr>								
			</div>

			<div class='modal-footer'>
				<button type='button' class='btn btn-secondary' data-dismiss='modal'>Salir</button>
				<a href='eliminar_receta.php?num_receta=<?php echo base64_encode($num_receta) ?>'><button type='button' class='btn bg-danger'>Eliminar</button></a>
			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function() {
        $("#opciones").change(function() {
            var seleccion = $(this).val();
            
            $.ajax({
                type: "POST",
                url: "val_munpsicoman_get.php",
                data: { opcion: seleccion },
                success: function(data) {
                    var resultados = JSON.parse(data);
                    $("#inputResultado1").val(resultados.resultado1);
                    $("#inputResultado2").val(resultados.resultado2);
                    $("#inputResultado3").val(resultados.resultado3);
                    $("#inputResultado4").val(resultados.resultado4);
                    $("#inputResultado5").val(resultados.resultado5);
                }
            });
        });
    });
</script>