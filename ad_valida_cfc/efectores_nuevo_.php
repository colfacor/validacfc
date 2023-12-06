<?php 
include('inc/conexion.php');
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
$zona = $_POST['zona'];
$nombre = $_POST['nombre'];
$domicilio = $_POST['domicilio'];
mysqli_query($conexion,"INSERT INTO efectores(zona, nombre, domicilio)
VALUES ('$zona', '$nombre', '$domicilio')")
or die("Problemas en el select".mysqli_error($conexion));
mysqli_close($conexion);
echo "<script> window.location='efectores.php?msj=valid'; </script>";
?>