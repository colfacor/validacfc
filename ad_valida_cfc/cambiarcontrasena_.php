<?php
session_start();
$dni = $_SESSION['dni'];
include 'inc/conexion.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha = date("Y-m-d  H:i:s");
$contra = $_POST['contra']; 
$contra1 = $_POST['contra1']; 

if($contra <> $contra1){

echo header("location: cambiarcontrasena.php?msj=".base64_encode('err')."");

}else{ 

mysqli_query($conexion, " UPDATE usuarios
		   							SET password = '$contra'
		                          	WHERE dni = '$dni'")
or die("Problemas en el select".mysqli_error($conexion));
mysqli_close($conexion);
echo header("location: cambiarcontrasena.php?msj=".base64_encode('ex')."");

}  ?>