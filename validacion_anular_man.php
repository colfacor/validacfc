<?php
include ('inc/conexion.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_hoy = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
$ip_add = $_SERVER['REMOTE_ADDR'];
$num_validacion = base64_decode($_GET['num_validacion']);

$tipo = base64_decode($_GET['tipo']);
$tipo_opera = $_POST['tipo_opera'];

$rec =("SELECT a.num_receta , b.tipo, b.dni_afi
  FROM validaciones a
  LEFT JOIN recetas b 
  ON a.num_receta = b.num_receta 
  WHERE a.num_validacion = '$num_validacion'");
$r1 = mysqli_query($conexion,$rec);
$rs1 = mysqli_fetch_array($r1); 
$num_receta = $rs1['num_receta'];
$dni = $rs1['dni_afi'];

$logFile = fopen("../log/log_anulaciones.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Anulacion de Receta: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' | '.$num_receta.' - '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);

$rec3 =("SELECT count(b.renglon) as total
  FROM validaciones a
  LEFT JOIN detalle_recetas b 
  ON a.num_receta = b.num_receta 
  WHERE a.num_receta = '$num_receta'");
$r3 = mysqli_query($conexion,$rec3);
$rs3 = mysqli_fetch_array($r3); 
$total = $rs3['total'];

mysqli_query($conexion,"INSERT INTO validaciones_anuladas(num_receta, num_validacion, cuit_farm, suc_farm, dni, estado, dia, mes, ano, hora, minuto, ipfarm, fecha_alta)

VALUES ('$num_receta', '$num_validacion', '$cuit', '$idsucursal', '$dni', '$tipo_opera', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_hoy')");

for ($renglon = 1; $renglon <= 4; $renglon++) {


mysqli_query($conexion,"DELETE from excep_afi 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from recetas 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from detalle_recetas 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from detalle_recetas_prescriptas 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from validaciones 
WHERE num_validacion = '$num_validacion'") or
die("Problemas en el select:".mysqli_error($conexion));

}

$logFile = fopen("../log/log_validaciones.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." VALIDACION ANULADA: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_validacion.' - '.$num_receta.' - '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
echo header("location: validaciones.php?msj=".base64_encode('an')."");
mysqli_close($conexion);
?>