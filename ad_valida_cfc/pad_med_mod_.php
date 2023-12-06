<?php
include 'inc/conexion.php';
$id = $_GET['id']; 
$nombre = $_POST['nombre']; 
$zona = $_POST['zona']; 
$mp = $_POST['mp']; 
$especialidad = $_POST['especialidad']; 
$centro = $_POST['centro']; 
$estado = $_POST['estado']; 
mysqli_query($conexion, "UPDATE pad_medicos 
						    SET nombre = '$nombre', zona = '$zona', mp = '$mp', especialidad = '$especialidad', estado = '$estado', centro = '$centro'
                      	WHERE id = '$id'") or

die("Problemas en el select:".mysqli_error($conexion));
	echo header("location: pad_med.php?msj=".base64_encode('md')."");
mysqli_close($conexion);
?>