<?php
include 'inc/conexion.php';
$troquel = base64_decode($_GET['troquel']);
$precio = $_POST['precio']; 

mysqli_query($conexion, "UPDATE vade_psicotropicos 
						    SET precio = '$precio'
                      	WHERE troquel = '$troquel'");
echo header("location: vademecum_precios.php?msj=".base64_encode('mod')."");
mysqli_close($conexion);
?>