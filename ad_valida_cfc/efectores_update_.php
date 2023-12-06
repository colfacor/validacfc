<?php
include 'inc/conexion.php';
$id = $_GET['id']; 
$nombre = $_POST['nombre']; 
$zona = $_POST['zona']; 
$domicilio = $_POST['domicilio']; 
mysqli_query($conexion, "UPDATE efectores 
						    SET nombre = '$nombre', zona = '$zona', domicilio = '$domicilio'
                      	WHERE id = '$id'") or

die("Problemas en el select:".mysqli_error($conexion));
	echo header("location: efectores.php?msj=".base64_encode('md')."");
mysqli_close($conexion);
?>