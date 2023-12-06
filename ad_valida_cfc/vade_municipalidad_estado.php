<?php
include 'inc/conexion.php';
$troquel = $_GET['troquel']; 

$lista =("SELECT * FROM vade_psicotropicos WHERE troquel = $troquel");
$rs = mysqli_query($conexion,$lista);
$row = mysqli_fetch_array($rs); 
$estado = $row['estado'];

if($estado == 1){
mysqli_query($conexion, "UPDATE vade_psicotropicos 
						    SET estado = '0'
                      	WHERE troquel = '$troquel'") or
die("Problemas en el select:".mysqli_error($conexion));
	echo header("location: vademecum.php?exito=exito");
mysqli_close($conexion);
}else{
	mysqli_query($conexion, "UPDATE vade_psicotropicos 
						    SET estado = '1'
                      	WHERE troquel = '$troquel'") or
die("Problemas en el select:".mysqli_error($conexion));
	echo header("location: vademecum.php?exito=exito");
mysqli_close($conexion);
}
?>