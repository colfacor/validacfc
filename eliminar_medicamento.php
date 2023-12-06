<?php
include ('inc/conexion.php');
$id = base64_decode($_GET['id']);
  mysqli_query($conexion,"DELETE from detalle_recetas 
  							WHERE id='$id'") or

    die("Problemas en el select:".mysqli_error($conexion));
		echo header("location: val_munpsicomanmed.php?msj=".base64_encode('el')."");
	mysqli_close($conexion);
?>