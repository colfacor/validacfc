<?php 
include('inc/conexion.php');
if(trim($_POST["idmatricula"]) != "" && trim($_POST["idsucursal"]) != "" && trim($_POST["contra"]) != "")
{
    $idmatricula = strtolower(htmlentities($_POST["idmatricula"], ENT_QUOTES));   
    $idsucursal = strtolower(htmlentities($_POST["idsucursal"], ENT_QUOTES));  
    $contra = md5($_POST["contra"].'contra');   
  
$result = mysqli_query($conexion,"SELECT * FROM users WHERE cuit = '$idmatricula' AND idsucursal = '$idsucursal'");
if($row = mysqli_fetch_array($result)){
if($row["password"] == $contra){

session_start();
$_SESSION["cuit"]  = $row['cuit'];
$_SESSION["idsucursal"]  = $row['idsucursal'];
$_SESSION["logueado"] = 1;
$_SESSION["convenio"] = $row['convenio'];

if($_POST['idmatricula']=='admin'){
$_SESSION["admin"] = 'si';
}
$_SESSION["cuit"]  = $row['cuit'];
$_SESSION["idsucursal"]  = $row['idsucursal'];
$_SESSION["logueado"] = 1;
$_SESSION["convenio"] = $row['convenio'];

$ip = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set("America/Argentina/Buenos_Aires");
$fecha= date("d/m/y"); 
$hora=date("H:i");
header("Location:home.php");
}else{
echo header("Location:index.php?msj=".base64_encode('err')."");
}
}else{
$result = mysqli_query($conexion,"SELECT * FROM users WHERE cuit = '$idmatricula' AND idsucursal = '$idsucursal'");
if (mysqli_num_rows($result)==0) {
echo header("Location:index.php?msj=".base64_encode('err')."");
}
if($row = mysqli_fetch_array($result)){
if($row["password"] == $contra){
session_start();
$_SESSION["cuit"]  = $row['cuit'];
$_SESSION["idsucursal"]  = $row['idsucursal'];
$_SESSION["logueado"] = 1;
$_SESSION["convenio"] = $row['convenio'];
echo header("Location:index.php?msj=".base64_encode('err')."");
}else{
echo header("Location:index.php?msj=".base64_encode('err')."");
		}
	}
}
mysqli_free_result($result);
}else{
echo header("Location:index.php?msj=".base64_encode('err')."");
}
?>