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
$id = base64_decode($_GET['id']);

$dni = $_SESSION['dni'];
$ip_add = $_SERVER['REMOTE_ADDR'];
$reg = $_POST['reg'];
$troquel = $_POST['troquel'];
$medicamento = $_POST['medicamento'];
$marca = $_POST['marca'];
$presentacion = $_POST['presentacion'];
$comprimidos_ab = $_POST['comprimidos_ab'];
$comprimidos = $_POST['comprimidos'];
$precio = $_POST['precio'];
$cod_laboratorio = $_POST['cod_laboratorio'];
$estado = $_POST['estado'];
$porcentaje = $_POST['porcentaje'];
$tipo = $_POST['tipo'];
$tipo_med = $_POST['tipo_med'];
$tope = $_POST['tope'];
mysqli_query($conexion, "UPDATE vade_psicotropicos 
						    SET troquel = '$troquel', reg = '$reg', medicamento = '$medicamento', marca = '$marca', presentacion = '$presentacion', comprimidos_ab = '$comprimidos_ab', comprimidos = '$comprimidos' , precio = '$precio', cod_laboratorio = '$cod_laboratorio', estado = '$estado', porcentaje = '$porcentaje' , tipo = '$tipo' , tipo_med = '$tipo_med', tope = '$tope'
                      	WHERE id = '$id'") or
die("Problemas en el select:".mysqli_error($conexion));
	echo header("location: vademecum.php?msj=".base64_encode('md')."");
mysqli_close($conexion);
?>