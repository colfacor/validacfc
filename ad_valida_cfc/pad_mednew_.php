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
$dni = $_SESSION['dni'];
$ip_add = $_SERVER['REMOTE_ADDR'];

$nombre = $_POST['nombre'];
$zona = $_POST['zona'];
$centro = $_POST['centro'];
$mp = $_POST['mp'];
$especialidad = $_POST['especialidad'];
//VALIDO QUE EL MEDICO ESTE REGISTRADO SINO LO INSERTO
$padron =("SELECT mp FROM pad_medicos WHERE mp = '$mp' AND centro = '$centro'");
$r = mysqli_query($conexion,$padron);
$rs = mysqli_fetch_array($r); 
$mp_ = $rs['mp'];
if($mp == $mp_){
    echo "<script> window.location='pad_med.php?msj=".base64_encode('err')."'; </script>";
}else{
   mysqli_query($conexion,"INSERT INTO pad_medicos(nombre, especialidad, mp, zona, centro, dia, mes, ano, hora, minuto, ip, fecha_alta)
    VALUES ('$nombre', '$especialidad', '$mp', '$zona', '$centro', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_alta')")
   or die("Problemas en el select".mysqli_error($conexion));
	mysqli_close($conexion);
   echo "<script> window.location='pad_med.php?msj=".base64_encode('ex')."'; </script>";
}
?>