<?php 
session_start();
$id = base64_decode($_GET['id']);
include('inc/conexion.php');

$padron =("SELECT * FROM users WHERE id = '$id'");
$r = mysqli_query($conexion,$padron);
$rs = mysqli_fetch_array($r); 
$password = md5($rs['cuit'].'contra');

mysqli_query($conexion, "UPDATE users 
SET password = '$password' WHERE id = '$id'") or
die("Problemas en el select:".mysqli_error($conexion));
echo header("location: usuarios.php?msj=".base64_encode('res')."");
mysqli_close($conexion);
?>