<?php 
session_start();
include('inc/conexion.php');
if($_SESSION["logueado"]=='1'){
}else{ 
	echo "<script>location.href='index.php';</script>";
	die();
} 
$dni = $_SESSION['dni'];
?>