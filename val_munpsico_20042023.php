<?php 
include('inc/conexion.php');
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_hoy = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');



//DATOS FARMACIA
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
$ip_add = $_SERVER['REMOTE_ADDR'];





$id_obrasocial = 1;
$num_receta = $_POST['nro_receta'];
$_SESSION['num_receta'] = $num_receta;
$dni = $_POST['dni'];
$_SESSION['dni'] = $dni;


//CREO CONEXION API DATOS DE RECETA 
$ch = curl_init(); // Ini
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type:application/json"
));

 $body = '{
        "id":"'.$num_receta.'",
        "dni":"'.$dni.'",
        "cuit":99999999999,
        "sucursal":1,
        "apikey":"d881d8ea2402b131bd1c7a7cfd199ddb",
        "opera":0
      }';
curl_setopt($ch, CURLOPT_URL, "http://34.231.253.195:5001/api/v1/recetasearch");
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$respuesta = curl_exec($ch); // Respuesta
curl_close($ch); // Cierro el CURL
$row=json_decode($respuesta);                       
//print_r($respuesta);
$troquel = $row->troquel;
$apellido = $row->apellido;
$nombre = $row->nombre;
$sigla_os = $row->sigla_os;
$dni = $row->dni;
$nroafiliado = $row->nroafiliado;
$fechaemision = $row->fechaemision;
$ley = $row->ley;
$matricprescr = $row->matricprescr;
$apellidomed = $row->apellidomed;
$nombremed = $row->nombremed;
$matricespec_prescr = $row->matricespec_prescr;
$denominacion = $row->denominacion;
$linkreceta = $row->linkreceta;
$nro_receta=$row->prescripcion[1];
$troquel=$row->prescripcion[3];
$cant_prescripta=$row->prescripcion[6];
$fecha_emision_subst = substr($fechaemision, 0, -14);
$logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validaciones: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' - '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





$obr =("SELECT * FROM obras_sociales WHERE id = '$id_obrasocial'");
$r1 = mysqli_query($conexion,$obr);
$rs1 = mysqli_fetch_array($r1); 
$padron = $rs1['padron'];

if($padron ==1){

$farmhab =("SELECT * FROM farm_habilitadas WHERE cuit = '$cuit' AND idsucursal = '$idsucursal' AND id_obrasocial = '$id_obrasocial'");
$r1 = mysqli_query($conexion,$farmhab);
$rs1 = mysqli_fetch_array($r1); 
$cuit_ = $rs1['cuit'];
$idsucursal_ = $rs1['idsucursal'];

if($cuit_ <> $cuit AND $idsucursal_ <> $idsucursal){

$logFile = fopen("log/log_farmacianohabilitada.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: FARMACIA NO HABILITADA PARA LA OBRA SOCIAL: ".$id_obrasocial.'  '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
header("location: val_munpsico.php?msj=".base64_encode('fh')."");
exit();
  }
}



//VALIDO QUE EL AFILIADO ESTE REGISTRADO
$afi =("SELECT dni FROM pad_psicotropicos WHERE dni = '$dni' AND estado = 1");
$r = mysqli_query($conexion,$afi);
$rs = mysqli_fetch_array($r); 
$dni_ = $rs['dni'];


//VALIDO QUE LA RECETA QUE INGRESA NO ESTA REGISTRADA SINO REGISTRO
$receta =("SELECT num_receta FROM recetas WHERE num_receta = '$num_receta' AND estado <> 3");
$rs1 = mysqli_query($conexion,$receta);
$row1 = mysqli_fetch_array($rs1); 
$num_receta_ = $row1['num_receta'];
//VALIDO QUE LA FECHA QUE INSERTA ES MENOR A UN MES DE QUE SE EXPENDIO LA RECETA
$fecha_vencimiento = date("Y-m-d",strtotime($fecha_emision_subst."+ 30 days")); 


if($dni_ <> $dni){
  $logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: DNI INEXISTENTE: ".$dni.'  '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
header("location: val_munpsico.php?msj=".base64_encode('af')."");

}elseif($fecha_emision_subst > $fecha_hoy){
  $logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: FECHA MAYOR A LA ACTUAL: ".$fecha_emision_subst.' '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
header("location: val_munpsico.php?msj=".base64_encode('fes')."");

}elseif($fecha_hoy > $fecha_vencimiento){
$logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: RECETA VENCIDA: ".$fecha_vencimiento.' '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
 header("location: val_munpsico.php?msj=".base64_encode('exp')."");

}elseif($num_receta_ <> $num_receta){
$FirstArray = $_POST['cantidad'][0];
$SecondArray = $_POST['renglon'][0];
$threeArray = $_POST['troquel'][0];

foreach($FirstArray as $index => $value) {
include('inc/conexion.php');
$medi =("SELECT precio FROM vade_psicotropicos WHERE troquel = '$threeArray' AND estado = 1");
$r = mysqli_query($conexion,$medi);
$rs = mysqli_fetch_array($r); 
$precio = $rs['precio'];

mysqli_query($conexion,'INSERT INTO detalle_recetas(num_receta, cantidad, troquel, precio, renglon) 
VALUES (\''.$num_receta.'\', \''.$FirstArray[$index].'\', \''.$threeArray[$index].'\', \''.$precio.'\', \''.$SecondArray[$index].'\') ');

}

$FirstArray = $_POST['cantidad'];
$SecondArray = $_POST['renglon'];
$threeArray = $_POST['troquel'];
foreach($FirstArray as $index => $value) {
include('inc/conexion.php');
$medi =("SELECT precio FROM vade_psicotropicos WHERE troquel = '$threeArray[$index]'");
$r = mysqli_query($conexion,$medi);
$rs = mysqli_fetch_array($r); 
$precio = $rs['precio'];

mysqli_query($conexion,"INSERT INTO detalle_recetas(num_receta, cantidad, troquel, precio, renglon) 
    values ('$num_receta', '$FirstArray[$index]', '$threeArray[$index]', '$precio', '$SecondArray[$index]')");

}

foreach ($row->prescripcion as $item) {
  $troquel=$item->troquel;
  $cant_prescripta=$item->cant_prescripta;
  $renglon=$item->renglon;

// INSERTO DATOS EN SERVIDOR DE CONSEJO MEDICO
$ch1 = curl_init(); // Ini
curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
    "Content-Type:application/json"
));

$body1 = '{
  "idReceta": "'.$num_receta.'",
  "renglon": "'.$renglon.'",
  "ip": "'.$ip_add.'",
  "codigo_dispensado": "'.$troquel.'",
  "cantidad_dispensada": "'.$cant_prescripta.'",
  "farmacia": 99999999999,
  "sucursal": 1,
  "dispensacion_cond": 1,
  "observacion": "dispensado",
  "tipo_opera": 1
}';

curl_setopt($ch1, CURLOPT_URL, "http:/34.231.253.195:5001/api/v1/dispensa");
curl_setopt($ch1, CURLOPT_POST, TRUE);
curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch1, CURLOPT_POSTFIELDS, $body1);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
$respuesta1 = curl_exec($ch1); // Respuesta
curl_close($ch1); // Cierro el CURL
$row1=json_decode($respuesta1);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//INSERTO DATOS DE RECETA

mysqli_query($conexion,"INSERT INTO recetas(id_obrasocial, num_receta, fecha_receta, mp_med, dni_afi, estado, tipo, dia, mes, ano, hora, minuto, ipfarm, fecha_alta)
    VALUES ('$id_obrasocial', '$num_receta',  '$fecha_emision_subst', '$matricprescr', '$dni', '1', '1', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_hoy')");

//CREO NUMERO DE VALIDACION
$lista =("SELECT MAX(id) as id FROM validaciones");
$rs = mysqli_query($conexion,$lista);
$row = mysqli_fetch_array($rs); 
$num_validacion = ($row['id'] + 1).$num_receta.$ano.$mes.$dia;

mysqli_query($conexion,"INSERT INTO validaciones(num_receta, num_validacion, cuit_farm, suc_farm, estado, dia, mes, ano, hora, minuto, ipfarm, fecha_alta)

VALUES ('$num_receta', '$num_validacion', '$cuit', '$idsucursal', '1', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_hoy')");



$logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validaciones: ".$num_validacion.' '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
echo "<script>window.open('comprobantepdf.php?num_validacion=".base64_encode($num_validacion)."&id_obrasocial=".base64_encode($id_obrasocial)."', '_blank');</script>";
echo "<script> window.location='validaciones.php?msj=".base64_encode('ex')."'; </script>";
 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
  $logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
  fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: RECETA YA VALIDADA ".$dni.' '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
  header("location: val_munpsico.php?msj=".base64_encode('copy')."");
  }

?>    