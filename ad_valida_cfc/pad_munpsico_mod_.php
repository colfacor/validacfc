<?php
include 'inc/conexion.php';
session_start();
$dni = $_SESSION['dni'];
$ip_add = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_alta = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');
$id =$_GET['id'];
$nombre = $_POST['nombre']; 
$apellido = $_POST['apellido']; 
$dni_ = $_POST['dni']; 
$estado = $_POST['estado']; 
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
$diagnostico = $_POST['diagnostico']; 
mysqli_query($conexion, "UPDATE pad_psicotropicos 
						    SET nombre = '$nombre', apellido = '$apellido', dni = '$dni_', diagnostico = '$diagnostico', estado = '$estado', genero = '$genero', telefono = '$telefono', calle = '$calle', numero = '$numero', piso = '$piso', dpto = '$dpto', barrio = '$barrio', fec_nac = '$fec_nac', prescriptor = '$prescriptor', efector = '$efector', fecha_inscripcion = '$fecha_inscripcion', user = '$dni'
                      	WHERE id = '$id'") or

die("Problemas en el select:".mysqli_error($conexion));
	echo header("location: pad_munpsico.php?msj=".base64_encode('md')."");
mysqli_close($conexion);
?>