<?php
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
include 'inc/conexion.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha = date("Y-m-d  H:i:s");
$contra = $_POST['contra']; 
$contra1 = $_POST['contra1']; 

if($contra <> $contra1){

	$logFile = fopen("../log/log_cambiocontrasena.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Error Cambiar Contraseña: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$contra.' = '.$contra1.'| '.$fecha_alta.''.$hora.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
echo header("location: cambiarcontrasena.php?msj=".base64_encode('err')."");

}else{ 

$clave = md5($contra.'contra');

mysqli_query($conexion, " UPDATE users
		   							SET password = '$clave', fec = '$fecha'
		                          	WHERE cuit = '$cuit' AND idsucursal = '$idsucursal'")
or die("Problemas en el select".mysqli_error($conexion));
mysqli_close($conexion);
$logFile = fopen("../log/log_cambiocontrasena.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Cambiar Contraseña: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$contra.' = '.$contra1.'| '.$fecha_alta.''.$hora.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
echo header("location: cambiarcontrasena.php?msj=".base64_encode('ex')."");

}  ?>