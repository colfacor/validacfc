<?php
include 'inc/conexion.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha = date("Y-m-d  H:i:s");
$id = $_GET['id']; 
$idmatricula = $_POST['idmatricula']; 
$idsucursal = $_POST['idsucursal']; 
$farmacia = $_POST['farmacia']; 
$cuit = $_POST['cuit'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$domicilio = $_POST['domicilio'];
$password = md5($_POST["password"].'contra');
$estado = $_POST['estado'];

if(!empty($password)){
mysqli_query($conexion, "UPDATE users 
						    SET idmatricula = '$idmatricula', idsucursal = '$idsucursal', farmacia = '$farmacia', cuit = '$cuit', estado = '1', telefono = '$telefono', domicilio = '$domicilio', email = '$email'
                      	WHERE id = '$id'");
}else{
mysqli_query($conexion, "UPDATE users 
						    SET idmatricula = '$idmatricula', idsucursal = '$idsucursal', farmacia = '$farmacia', cuit = '$cuit', password = '$password', estado = '1', telefono = '$telefono', domicilio = '$domicilio', email = '$email'
                      	WHERE id = '$id'");
}
echo header("location: usuarios.php?msj=".base64_encode('mod')."");
mysqli_close($conexion);
?>