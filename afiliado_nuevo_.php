<?php
include('inc/conexion.php');

$ip_add = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_alta = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');

$num_afiliado = $_POST['num_afiliado'];
$dni = $_POST['dni'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$genero = $_POST['genero'];
$fecha_nac = $_POST['fecha_nac'];

$padron =("SELECT dni FROM pad_psicotropicos WHERE dni = '$dni'");
$rs = mysqli_query($conexion,$padron);
$row = mysqli_fetch_array($rs); 
$dni_ = $row['dni'];


if($dni_ == $dni){
	$mr = 1; 
	header("location:validacion_nueva.php?mr=$mr");
}elseif
	($fecha_nac > $fecha_alta){

		$mfi = 1; 
	header("location:validacion_nueva.php?mfi=$mfi");
}else{
	$mn = 1; 
	mysqli_query($conexion,"INSERT INTO pad_psicotropicos(num_afiliado, dni, nombre, apellido, genero, fecha_nac, estado, fecha_alta, dia, mes, ano, hora, minuto, ip) 
	        values ('$num_afiliado','$dni','$_REQUEST[nombre]','$_REQUEST[apellido]','$_REQUEST[genero]','$_REQUEST[fecha_nac]','1','$fecha_alta','$dia','$mes','$ano','$hora','$minuto','$ip_add')") 
	or die("Problemas en el select".mysqli_error($conexion));		
	mysqli_close($conexion);
 header("location:validacion_nueva.php?mn=$mn"); 
}
?>