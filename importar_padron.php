<?php 
include('inc/conexion.php');

$filas=file('Muni.csv');
foreach($filas as $value){
list($idmatricula, $idsucursal, $farmacia, $cuit, $password, $telefono, $domicilio) = explode(";", $value);

$lista7 =("SELECT * FROM users WHERE idmatricula ='$idmatricula' AND idsucursal = '$idsucursal'");
$rs7 = mysqli_query($conexion,$lista7);
$row7 = mysqli_fetch_array($rs7); 
$estado_ = $row7['estado'];


if($estado_ <>1){

$clave = md5($password.'contra');

mysqli_query($conexion,"INSERT INTO users(idmatricula,idsucursal,farmacia,cuit,password,telefono,domicilio,estado) VALUES ('$idmatricula', '$idsucursal', '$farmacia', '$cuit', '$clave', '$telefono', '$domicilio')");

}else{

	echo 'YA ESTA LA MATRICULA<br>';

	}
} 
echo 'SE COMPLETO CON EXITO LA IMPORTACION';
?>