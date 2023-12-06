<?php 
include('inc/conexion.php');

$cuit_farm = $_POST["cuit_farm"];   
$suc_farm = $_POST["suc_farm"];  
$password = $_POST["password"];   
  

echo header("Location:index.php?msj=".base64_encode('err')."");

?>