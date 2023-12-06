<?php 
include('inc/conexion.php');
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');


$troquel = $_POST['troquel'];
$medicamento = $_POST['medicamento'];
$presentacion = $_POST['presentacion'];
$cod_laboratorio = $_POST['cod_laboratorio'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$estado = $_POST['estado'];


   mysqli_query($conexion,"INSERT INTO vade_psicotropicos(troquel, medicamento, presentacion, cod_laboratorio, precio, estado, tipo)
    VALUES ('$troquel', '$medicamento', '$presentacion', '$cod_laboratorio', '$precio', '$estado', '$tipo')")
   or die("Problemas en el select".mysqli_error($conexion));
	mysqli_close($conexion);
   echo "<script> window.location='vademecum_nuevo.php?msj=valid'; </script>";

?>