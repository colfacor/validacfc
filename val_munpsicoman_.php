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

$lista2 =("SELECT num_receta, id  FROM recetas WHERE tipo = 2 order by id DESC LIMIT 1");
$rs2 = mysqli_query($conexion,$lista2);
$row = mysqli_fetch_array($rs2); 
$num_receta = '00'.($row['id'] + 1);
$_SESSION['num_receta'] = $num_receta;
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
$ip_add = $_SERVER['REMOTE_ADDR'];
$id_obrasocial = 1;

$fecha_receta = $_POST['fecha_receta'];
$dni = $_POST['dni'];
$mp_med = $_POST['mp_med'];
$apellido = $_POST['apellido'];
$nombre = $_POST['nombre'];

$logFile = fopen("../log/log_validacion_manuales.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validaciones Manuales: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta) or die("Error escribiendo en el archivo");fclose($logFile);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//VALIDO QUE EL AFILIADO ESTE REGISTRADO SINO LO INSERTO
$afi =("SELECT dni FROM pad_psicotropicos WHERE dni = '$dni' AND estado = 1");
$r = mysqli_query($conexion,$afi);
$rs = mysqli_fetch_array($r); 
$dni_ = $rs['dni'];

if($dni_ <> $dni){
 mysqli_query($conexion,"INSERT INTO pad_psicotropicos (dni, nombre, apellido, diagnostico, genero, fec_nac, telefono, calle, numero, dpto, piso, barrio, prescriptor, efector, fecha_inscripcion, estado, dia, mes, ano, hora, minuto, ip, fecha_alta, user) 
  VALUES ('$dni', '$nombre', '$apellido', '0', '0', '2022-01-01', '0', '0', '0', '0', '0', '0', '$mp_med', '0', '2022-01-01', '1', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_alta', '$cuit')");
}

//VALIDO QUE LA RECETA QUE INGRESA NO ESTA REGISTRADA SINO REGISTRO
$receta =("SELECT num_receta FROM recetas WHERE num_receta = '$num_receta'");
$rs1 = mysqli_query($conexion,$receta);
$row1 = mysqli_fetch_array($rs1); 
$num_receta_ = $row1['num_receta'];

//VALIDO QUE LA FECHA QUE INSERTA ES MENOR A UN MES DE QUE SE EXPENDIO LA RECETA
$fecha_vencimiento = date("Y-m-d",strtotime($fecha_receta."+ 30 days")); 

if($fecha_receta > $fecha_alta){
$logFile = fopen("../log/log_validacion_manuales.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: FECHA MAYOR A LA ACUTAL ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_alta.''.$hora.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
header("location: val_munpsicoman.php?msj=".base64_encode('fe')."");

}elseif($fecha_alta > $fecha_vencimiento){

$logFile = fopen("../log/log_validacion_manuales.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: RECETA VENCIDA ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_alta.''.$hora.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
 header("location: val_munpsicoman.php?msj=".base64_encode('exp')."");

}elseif($num_receta_ <> $num_receta){

mysqli_query($conexion,"INSERT INTO recetas (id_obrasocial, num_receta, fecha_receta, mp_med, dni_afi, estado, tipo, dia, mes, ano, hora, minuto, ipfarm, fecha_alta, linkreceta)

    values ('1', '$num_receta', '$fecha_receta', '$mp_med', '$dni', '3', '2','$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_alta', '')")
    
    or die("Problemas en el select".mysqli_error($conexion));
mysqli_close($conexion);
 header("location: val_munpsicomanmed.php");
}else{
	$logFile = fopen("../log/log_validacion_manuales.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: RECETA DUPLICADA ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_alta.''.$hora.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
	header("location: val_munpsicoman.php?msj=".base64_encode('copy')."");
}
?>  