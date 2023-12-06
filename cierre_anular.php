<?php
include ('inc/conexion.php');
$num_cierre = $_GET['num_cierre'];
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_alta = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');

//DATOS FARMACIA
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
$ip_add = $_SERVER['REMOTE_ADDR'];

mysqli_query($conexion, "UPDATE validaciones
INNER JOIN detalle_cierres 
ON validaciones.num_receta = detalle_cierres.num_receta
SET validaciones.cierre = 0
WHERE detalle_cierres.num_cierre = '$num_cierre'"); 

mysqli_query($conexion,"DELETE from cierres_lotes 
WHERE num_cierre='$num_cierre'");

mysqli_query($conexion,"DELETE from detalle_cierres 
WHERE num_cierre='$num_cierre'");

$logFile = fopen("../log/log_cierres.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Cierre Anular: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_cierre) or die("Error escribiendo en el archivo");fclose($logFile);
echo header("location: cierres.php?msj=".base64_encode('an')."");
mysqli_close($conexion);
?>