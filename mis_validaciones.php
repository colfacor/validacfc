<?php 
include('inc/header.php');
include('inc/panel.php');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
include('inc/conexion.php');
if (!isset($_SESSION['cuit'])) {
    header("location: index.php?msj=".base64_encode('cs')."");
}
$_SESSION["id_obrasocial"] = $id_obrasocial;
$mensaje_nuevo = $_GET['mensaje_nuevo'];
$mensaje_repetido = $_GET['mensaje_repetido'];
$mensaje_cantrec = $_GET['mensaje_cantrec'];
$mensaje_fecha = $_GET['mensaje_fecha'];

$result = mysqli_query($conexion,"SELECT * FROM recetas");
$array = array();
if($result){
while ($row=mysqli_fetch_array($result)){ 
$equipo = utf8_encode($row['num_receta']);
			array_push($array, $equipo); 
		}
	}
?>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<script type="text/javascript" src="jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="estilos.css">
	<link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<script type="text/javascript" src="jquery-ui.js"></script>
	<script src="formulario.js"></script>
</head>

<body>

<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Consultar Recetas</h5>
		<div class="header-elements">
			<div class="list-icons">
        		<a class="list-icons-item" data-action="reload"></a>
        	</div>
    	</div>
	</div>


	<div class="card-body">				
		<div class="click2edit">
		<hr>
		<div class="row">
			<div class="form-group row">
				<label class="col-form-label col-lg-6">Buscar por Numero de Receta</label>
				<div class="col-lg-10">
					<div class="input-group">
						<span class="input-group-prepend">
							<span class="input-group-text"><i class="icon-checkmark3"></i></span>
						</span>
						<input type="text" class="form-control" placeholder="" id="c"  name="dni">
						<span class="input-group-append">
						</span>
					</div>
				</div>
			</div>
		</div>	
    </div>
</div>


<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title"></h5>
		<div class="header-elements">
			<div class="list-icons">		                		
	    		<a class="list-icons-item" data-action="reload"></a>		                		
	    	</div>
		</div>
	</div>
	<div class="card-body">
		
	</div>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr class="bg-blue">
					<th>N° de Receta</th>
					<th>Fecha Prescripcion</th>
					<th>Nombre Medico</th>
					<th>tipo MP</th>
					<th>MP</th>
					<th>Obra Social</th>
					<th>Cobertura</th>
					<th>Troquel</th>
					<th>Cantidad</th>
					<th>Diagnostico</th>
					<th>Historia Clinica</th>
					<th>Estado de Receta</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td id="num_receta"></td>
					<td id="fecha_prescripcion"></td>
					<td id="nombre_medico"></td>
					<td id="tipo_mp"></td>
					<td id="mp"></td>
					<td id="id_obrasocial"></td>
					<td id="cobertura"></td>
					<td id="troquel"></td>
					<td id="cantidad"></td>
					<td id="diagnostico"></td>
					<td id="historia_clinica"></td>
					<td id="estado_rec"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
		



<script type="text/javascript">
$(document).ready(function () {
	var items = <?= json_encode($array) ?>

	$("#c").autocomplete({
		source: items,
		select: function (event, item) {
			var params = {
				num_receta: item.item.value
			};
			$.get("get_validador_consulta.php", params, function (response) {
				var json = JSON.parse(response);
				if (json.status == 200){
					$("#num_receta").html(json.num_receta);
					$("#fecha_prescripcion").html(json.fecha_prescripcion);
					$("#nombre_medico").html(json.nombre_medico);
					$("#tipo_mp").html(json.tipo_mp);
					$("#mp").html(json.mp);
					$("#id_obrasocial").html(json.id_obrasocial);
					$("#cobertura").html(json.cobertura);
					$("#troquel").html(json.troquel);
					$("#cantidad").html(json.cantidad);
					$("#diagnostico").html(json.diagnostico);
					$("#historia_clinica").html(json.historia_clinica);
					$("#estado_rec").html(json.estado_rec);
					
					}else{
					}
				}); // ajax
			}
		});
	});
</script>

