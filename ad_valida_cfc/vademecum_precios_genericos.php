<?php
include '../inc/conexion.php';
$porcentaje = 7.8;
$registros = mysqli_query($conexion,"SELECT * FROM vade_psicotropicos WHERE estado = 1 AND tipo = 1");
while ($reg=mysqli_fetch_array($registros)){
$troquel = $reg['troquel'];
$precio = $reg['precio'];

$precio_nuevo = ($reg['precio'] * $porcentaje)/100 + $reg['precio'];


mysqli_query($conexion, "UPDATE vade_psicotropicos 
						    SET precio = '$precio_nuevo'
                      		WHERE troquel = '$troquel'");
} 
echo header("location: vademecum_precios.php?msj=".base64_encode('md')."");
?>