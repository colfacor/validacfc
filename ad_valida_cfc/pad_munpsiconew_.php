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
$msj = base64_decode($_GET['msj']);

$dni = $_SESSION['dni'];
$ip_add = $_SERVER['REMOTE_ADDR'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni_afi = $_POST['dni_afi'];
$diagnostico = $_POST['diagnostico'];
$genero = $_POST['genero'];
$fec_nac = $_POST['fec_nac'];
$telefono = $_POST['telefono'];
$calle = $_POST['calle'];
$numero = $_POST['numero'];
$piso = $_POST['piso'];
$dpto = $_POST['dpto'];
$barrio = $_POST['barrio'];
$prescriptor = $_POST['prescriptor'];
$efector = $_POST['efector'];
$fecha_inscripcion = $_POST['fecha_inscripcion'];
//VALIDO QUE EL MEDICO ESTE REGISTRADO SINO LO INSERTO
$padron =("SELECT dni FROM pad_psicotropicos WHERE dni = '$dni_afi' AND estado = 1");
$r = mysqli_query($conexion,$padron);
$rs = mysqli_fetch_array($r); 
$dni_afi_ = $rs['dni'];

if($dni_afi_ == $dni_afi){
	echo "<script> window.location='pad_munpsico.php?msj=".base64_encode('rep')."'; </script>";
}else{
   	mysqli_query($conexion,"INSERT INTO pad_psicotropicos(nombre, apellido, dni, diagnostico, genero, fec_nac, telefono, calle, numero, piso, dpto, barrio, prescriptor, efector, fecha_inscripcion, dia, mes, ano, hora, minuto, ip, fecha_alta, user)
    VALUES ('$nombre', '$apellido',  '$dni_afi', '$diagnostico', '$genero', '$fec_nac', '$telefono', '$calle', '$numero', '$piso', '$dpto', '$barrio','$prescriptor','$efector','$fecha_inscripcion', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_alta', '$dni')")
   or die("Problemas en el select".mysqli_error($conexion));
	mysqli_close($conexion);
   echo "<script> window.location='pad_munpsico.php?msj=".base64_encode('valid')."'; </script>";
}
?>