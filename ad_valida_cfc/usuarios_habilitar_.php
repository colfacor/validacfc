<?php 
session_start();
$dni = $_SESSION['dni'];

$idmatricula = $_POST['idmatricula'];
$idsucursal = $_POST['idsucursal'];
$id_obrasocial = $_POST['id_obrasocial'];

include('inc/conexion.php');

	$padron =("SELECT * FROM users WHERE idmatricula = '$idmatricula' AND idsucursal = '$idsucursal'");
	$r = mysqli_query($conexion,$padron);
	$rs = mysqli_fetch_array($r); 
	$cuit = $rs['cuit'];

	foreach ($id_obrasocial as $c) {

		$padron1 =("SELECT idmatricula FROM farm_habilitadas WHERE idmatricula = '$idmatricula' AND idsucursal = '$idsucursal' AND id_obrasocial = '$id_obrasocial'");
		$r = mysqli_query($conexion,$padron1);
		$rs = mysqli_fetch_array($r); 
		$idmatricula_ = $rs['idmatricula'];


		  	 mysqli_query($conexion,"INSERT INTO farm_habilitadas (idmatricula, idsucursal, cuit, estado, id_obrasocial)
		 	VALUES ('$idmatricula', '$idsucursal', '$cuit', '1', '$c')");
		 	header("location: usuarios_habilitar.php?msj=".base64_encode('ex')."");

	}
?>