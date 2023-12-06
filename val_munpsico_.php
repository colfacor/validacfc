<?php 
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
include('inc/conexion.php');
include('api/funciones.php');
if (!isset($_SESSION['cuit'])) {
    header("location: index.php?msj=".base64_encode('cs')."");
    exit();
}
$num_receta=$_POST['num_receta'];
$sigipsa=$_POST['sigipsa'];
$dni=$_POST['dni'];

$val_munpsico=val_munpsico($num_receta,$sigipsa,$dni);
$resp_munpsico=substr($val_munpsico, 0,6);
    if($resp_munpsico=='compro'){
        echo "<script>window.open('$val_munpsico', '_blank');</script>";
        echo "<script> window.location='validaciones.php?msj=".base64_encode('ex')."'; </script>";
    }else{
  header("location: val_munpsico.php?msj=".$val_munpsico."");
  }
?>