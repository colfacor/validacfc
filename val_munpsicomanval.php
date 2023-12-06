<?php 
include('inc/conexion.php');
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
$num_receta = base64_decode($_GET['num_receta']);
$ip_add = $_SERVER['REMOTE_ADDR'];
$id_obrasocial = 1;

$lista =("SELECT * FROM detalle_recetas WHERE num_receta = '$num_receta'");
$rs = mysqli_query($conexion,$lista);
$row = mysqli_fetch_array($rs); 
$num_receta_ = $row['num_receta'];
if(empty($num_receta_)){
header("location: val_munpsicomanmed.php?msj=".base64_encode('ingmed')."");
exit();
}

//CREO NUMERO DE VALIDACION
$lista =("SELECT MAX(id) as id FROM validaciones");
$rs = mysqli_query($conexion,$lista);
$row = mysqli_fetch_array($rs); 
$num_validacion = ($row['id'] + 1).$num_receta.$ano.$mes.$dia;

mysqli_query($conexion,"INSERT INTO validaciones(num_receta, num_validacion, cuit_farm, suc_farm, estado, dia, mes, ano, hora, minuto, ipfarm, fecha_alta)

VALUES ('$num_receta', '$num_validacion', '$cuit', '$idsucursal', '1', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_alta')");

 mysqli_query($conexion, " UPDATE recetas
		   					SET estado = '1'
		                    WHERE num_receta= '$num_receta'")

or die("Problemas en el select".mysqli_error($conexion));
mysqli_close($conexion);
unset($_SESSION['num_receta']);
$logFile = fopen("../log/log_validacionesmanuales.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validaciones: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta) or die("Error escribiendo en el archivo");fclose($logFile);
echo "<script>window.open('comprobantepdf.php?num_validacion=".base64_encode($num_validacion)."&id_obrasocial=".base64_encode($id_obrasocial)."', '_blank');</script>";
echo "<script> window.location='validaciones.php?msj=".base64_encode('ex')."'; </script>";
?>