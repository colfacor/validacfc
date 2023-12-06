<?php
include ('inc/conexion.php');
session_start();
$num_receta = base64_decode($_GET['num_receta']);
mysqli_query($conexion,"DELETE from recetas 
  							WHERE num_receta='$num_receta'");

mysqli_query($conexion,"DELETE from detalle_recetas 
  							WHERE num_receta='$num_receta'");

mysqli_query($conexion,"DELETE from validaciones 
  							WHERE num_receta='$num_receta'");

unset($_SESSION['num_receta']);
echo header("location: validaciones.php?msj=".base64_encode('an')."");
mysqli_close($conexion);
?>