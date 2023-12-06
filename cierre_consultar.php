<?php 
include('inc/header.php');
include('inc/panel.php');
include('inc/conexion.php');

// Establecer el tiempo de vida de la cookie de sesión en 30 días (2592000 segundos)
$cookie_lifetime = 2592000; // 30 días

// Establecer el tiempo de vida de la sesión en el servidor (opcional)
ini_set('session.gc_maxlifetime', $cookie_lifetime);

// Configurar los parámetros de la cookie de sesión
session_set_cookie_params($cookie_lifetime);

// Iniciar la sesión
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
if (!isset($_SESSION['cuit'])) {
    header("location: index.php?msj=".base64_encode('cs')."");
}
$periodo = $_POST["periodo"];
$ano = substr($periodo, 0, -2);
$mes = substr($periodo, -2);
$periodofinal = $ano.$periodo_1;
$id_obrasocial = $_POST['id_obrasocial'];

$obr =("SELECT * FROM obras_sociales WHERE id = '$id_obrasocial'");
$r1 = mysqli_query($conexion, $obr);
$rs1 = mysqli_fetch_array($r1); 
$obra_social = $rs1['obra_social'];

$obr =("SELECT COUNT(a.num_receta) as tot_rec
FROM validaciones a  
LEFT JOIN recetas c ON a.num_receta = c.num_receta 
WHERE a.cierre = '0' AND a.cuit_farm = '$cuit' AND a.suc_farm = '$idsucursal' AND c.id_obrasocial = '$id_obrasocial'");
$r1 = mysqli_query($conexion, $obr);
$rs1 = mysqli_fetch_array($r1); 
$tot_rec = $rs1['tot_rec'];
?>

<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">SELECCIONE RECETAS QUE INCLUIRÁ EN EL CIERRE DE <?php echo $obra_social ?></h5>

		<div class="header-elements">
    	</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<form id="formAnularValidacion" action="cierre_confirmar_.php?periodo=<?php echo $periodo ?>&id_obrasocial=<?php echo $id_obrasocial ?>" method="POST">
					<div class="form-group">
						<label class="d-block font-weight-semibold">Periodo a Cerrar   <br> <br><?php echo $periodo ?>   |    TOTAL DE RECETAS SIN CERRAR: <?php echo $tot_rec ?></label><br>
						<?php
						$registros = mysqli_query($conexion, "SELECT a.num_validacion, a.num_receta, a.dia, a.ano, a.mes, SUM(b.precio*b.cantidad) as tf  
							FROM validaciones a 
							LEFT JOIN detalle_recetas b ON a.num_receta = b.num_receta 
							LEFT JOIN recetas c ON a.num_receta = c.num_receta 
							WHERE c.estado = 1 AND a.estado = 1 AND a.cierre = 0 AND a.cuit_farm = '$cuit' AND a.suc_farm = '$idsucursal' AND c.id_obrasocial = '$id_obrasocial'
							GROUP BY a.num_validacion, a.num_receta, a.dia, a.ano, a.mes");
					while ($reg = mysqli_fetch_array($registros)) {
					    echo "<div class='custom-control custom-checkbox'>
					            <input class='form-check-input' type='checkbox' name='num_receta[]' value='" . $reg['num_receta'] . "' data-num-validacion='" . $reg['num_validacion'] . "' checked>" . $reg['num_validacion'] . " | " . $reg['num_receta'] . " | " . $reg['dia'] . "-" . $reg['mes'] . "-" . $reg['ano'] . "
					        </div>
					        <input type='hidden' name='tf[]' value=" . $reg['tf'] . ">
					        <hr>";
					}
						?>
					</div>
					<br>
					<div class="form-group">
						<a href="cierres.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
						<button type="submit" id="btnAnularValidacion" class="btn btn-primary">Confirmar Cierre</button>
						<div class="loader" id="loader"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
 <script>
    document.getElementById('formAnularValidacion').addEventListener('submit', function() {
        // Desactivar el botón después de hacer clic
        document.getElementById('btnAnularValidacion').setAttribute('disabled', 'disabled');
    });
</script>
<script src="scripts.js"></script>