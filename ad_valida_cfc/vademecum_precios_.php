<?php
include 'inc/conexion.php';

$registros = mysqli_query($conexion,"SELECT * FROM vade_psicotropicos_23062023 WHERE estado = 1 AND tipo = 2");
while ($reg=mysqli_fetch_array($registros)){
$troquel = $reg['troquel'];
$precio = $reg['precio'];
$comprimidos = $reg['comprimidos'];

$padron =("SELECT * FROM alfabeta_articulos WHERE tro = '$troquel'");
$r = mysqli_query($conexion,$padron);
$rs = mysqli_fetch_array($r); 
$precio_nuevo_ab = ($rs['prc'] - ($precio*0.15)) / $comprimidos;


mysqli_query($conexion, "UPDATE vade_psicotropicos_23062023 
						    SET precio = '$precio_nuevo_ab'
                      		WHERE troquel = '$troquel'");
} 
echo "PRECIOS ACTUALIZADOS";
?>