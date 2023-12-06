<?php
include('inc/conexion.php');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
$num_receta = $_SESSION['num_receta'];
$cantidad = $_POST['cantidad'];
$num_receta = $_SESSION['num_receta'];
$troquel = $_POST['troquel'];

date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_hoy = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');

$afi =("SELECT dni FROM pad_psicotropicos WHERE dni = '$dni_afi' AND estado = 1");
$r = mysqli_query($conexion,$afi);
$rs = mysqli_fetch_array($r); 
$dni_afi = $rs['dni'];

$fec =("SELECT MAX(c.fecha_alta)
FROM recetas a 
LEFT JOIN detalle_recetas b 
ON a.num_receta = b.num_receta
LEFT JOIN validaciones c 
ON a.num_receta = c.num_receta
WHERE b.troquel = '$troquel' AND c.estado = 1 AND a.dni_afi = '$dni_afi'");
$r = mysqli_query($conexion,$fec);
$rs = mysqli_fetch_array($r); 
$fecha_alta_rec = $rs['fecha_alta'];

$fecha_topeconsumo = date("Y-m-d",strtotime($fecha_alta_rec."+ 30 days")); 

$receta =("SELECT COUNT(id) as total FROM detalle_recetas WHERE num_receta = '$num_receta'");
$rs1 = mysqli_query($conexion,$receta);
$row1 = mysqli_fetch_array($rs1); 
$total = $row1['total'];

if($total >= '4'){
	$logFile = fopen("../log/log_validaciones_error.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_cantidad_medicamentos_mayora3: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta) or die("Error escribiendo en el archivo");fclose($logFile);
header("location: val_munpsicomanmed.php?msj=".base64_encode('cant')."");

}elseif($cantidad <=0){

 $logFile = fopen("../log/log_validaciones.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: CANTIDAD <0 ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.''.$hora.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
header("location: val_munpsicomanmed.php?msj=".base64_encode('canti')."");
}elseif($fecha_hoy > $fecha_topeconsumo){

 $logFile = fopen("../log/log_validaciones.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: EXCEDIO EL CONSUMO ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.''.$hora.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
header("location: val_munpsicomanmed.php?msj=".base64_encode('cons')."");
}else{

$rec3 =("SELECT count(renglon) as total_renglon
  FROM detalle_recetas
  WHERE num_receta = '$num_receta'");
$r3 = mysqli_query($conexion,$rec3);
$rs3 = mysqli_fetch_array($r3); 
$total_renglon = $rs3['total_renglon']+1;

$sum =("SELECT * FROM vade_psicotropicos WHERE troquel = '$troquel'");
$r = mysqli_query($conexion,$sum);
$rs = mysqli_fetch_array($r); 
$precio = $rs['precio'];

mysqli_query($conexion,"INSERT INTO detalle_recetas (num_receta, cantidad, troquel, precio, renglon)
    values ('$num_receta', '$cantidad', '$troquel', '$precio', '$total_renglon')")
    or die("Problemas en el select".mysqli_error($conexion));
mysqli_close($conexion);
header("location: val_munpsicomanmed.php?msj=".base64_encode('ex')."");
}
?>  