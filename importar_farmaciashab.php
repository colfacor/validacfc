<?php 
include('inc/conexion.php');

$filas=file('fh.csv');
foreach($filas as $value){

list($cuit, $idsucursal, $estado, $id_obrasocial) = explode(";", $value);

$lista7 =("SELECT * FROM farm_habilitadas WHERE cuit ='$cuit' AND idsucursal = '$idsucursal' AND id_obrasocial = '$id_obrasocial'");
$rs7 = mysqli_query($conexion,$lista7);
$row7 = mysqli_fetch_array($rs7); 
$estado_ = $row7["estado"];


if($estado_ <>1){

mysqli_query($conexion,"INSERT INTO farm_habilitadas(cuit, idsucursal, estado, id_obrasocial, fec) VALUES ('$cuit', '$idsucursal', '1', '$id_obrasocial', '2023-04-28 14:00:00')")
or die("Problemas en el select".mysqli_error($conexion));

}else{

	echo 'YA ESTA LA MATRICULA<br>';
	}
} 

echo 'SE COMPLETO CON EXITO LA IMPORTACION';
?>