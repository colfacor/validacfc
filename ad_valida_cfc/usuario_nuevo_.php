<?php 
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha = date("Y-m-d  H:i:s");
$dni = $_SESSION['dni'];
$ip_add = $_SERVER['REMOTE_ADDR'];
$idmatricula = $_POST['idmatricula'];
$farmacia = $_POST['farmacia'];
$idsucursal = $_POST['idsucursal'];
$cuit = $_POST['cuit'];
$telefono = $_POST['telefono'];
$domicilio = $_POST['domicilio'];
$email = $_POST['email'];
$password = md5($_POST['password'].'contra');

include('inc/conexion.php');

$padron =("SELECT * FROM users WHERE idmatricula = '$idmatricula' and idsucursal = '$idsucursal'");
$r = mysqli_query($conexion,$padron);
$rs = mysqli_fetch_array($r); 
$idmatricula_ = $rs['idmatricula'];
$idsucursal_ = $rs['idsucursal'];
if($idmatricula == $idmatricula_ AND $idsucursal == $idsucursal_){
    echo header("location: usuarios.php?msj=".base64_encode('error')."");
}else{
   mysqli_query($conexion,"INSERT INTO users(idmatricula, idsucursal, farmacia, cuit, password, telefono, domicilio, email)
    VALUES ('$idmatricula', '$idsucursal', '$farmacia', '$cuit', '$password', '$telefono','$domicilio','$email')");
 echo header("location: usuarios.php?msj=".base64_encode('valid')."");
}
?>