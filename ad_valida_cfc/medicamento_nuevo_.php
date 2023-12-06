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


$padron =("SELECT troquel FROM vade_psicotropicos WHERE troquel = '$troquel' AND estado = 1");
$r = mysqli_query($conexion,$padron);
$rs = mysqli_fetch_array($r); 
$troquel_ = $rs['troquel'];

if($troquel_ == $troquel){
	echo "<script> window.location='medicamento_nuevo.php?msj=".base64_encode('rep')."'; </script>";
}else{
   	mysqli_query($conexion,"INSERT INTO vade_psicotropicos(reg, troquel, medicamento, marca, presentacion, comprimidos_ab, comprimidos, precio, cod_laboratorio, estado, porcentaje, tipo, tipo_med, tope)
    VALUES ('$reg', '$troquel',  '$medicamento', '$marca', '$presentacion', '$comprimidos_ab', '$comprimidos', '$precio', '$cod_laboratorio', '$estado', '$porcentaje', '$tipo','$tipo_med','$tope')")
   or die("Problemas en el select".mysqli_error($conexion));
	mysqli_close($conexion);
   echo "<script> window.location='vademecum.php?msj=".base64_encode('valida')."'; </script>";
}
?>