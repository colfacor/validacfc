<?php 
include('inc/conexion.php');
$ip_add = $_SERVER['REMOTE_ADDR'];

if(trim($_POST["dni"]) != "" && trim($_POST["contra"]) != "")

{

    $dni = strtolower(htmlentities($_POST["dni"], ENT_QUOTES));   

    $contra = $_POST["contra"];    


$result = mysqli_query($conexion,"SELECT * FROM usuarios WHERE dni = '$dni'");

if($row = mysqli_fetch_array($result)){

if($row["password"] == $contra){

session_start();
$_SESSION["dni"]  = $row['dni'];
$_SESSION["logueado"] = 1;

if($_POST['dni']=='admin'){



$_SESSION["admin"] = 'si';

}
$_SESSION["dni"]  = $row['dni'];
$_SESSION["logueado"] = 1;

$ip = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set("America/Argentina/Buenos_Aires");
$fecha= date("d/m/y"); 
$hora=date("H:i");

$logFile = fopen("log_inicio.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Inicio Sesion EXITOSO: ".$dni.' - '.$contra.' - '.$ip_add) or die("Error escribiendo en el archivo");fclose($logFile);
header("Location:home.php");

}else{
$logFile = fopen("log_inicio.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Inicio Sesion ERROR: ".$dni.' - '.$contra.' - '.$ip_add) or die("Error escribiendo en el archivo");fclose($logFile);
echo header("Location:index.php?mensaje_error=1");

}

}else{

$result = mysqli_query($conexion,"SELECT * FROM usuarios WHERE dni = '$dni'");


if (mysqli_num_rows($result)==0) {
echo header("Location:index.php?mensaje_error=1");
}


if($row = mysqli_fetch_array($result)){
if($row["password"] == $_POST["contra"]){

session_start();
$_SESSION["dni"]  = $row['dni'];
$_SESSION["logueado"] = 1;
$logFile = fopen("log_inicio.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Inicio Sesion ERROR: ".$dni.' - '.$contra.' - '.$ip_add) or die("Error escribiendo en el archivo");fclose($logFile);
echo header("Location:index.php?mensaje_error=1");

}else{
$logFile = fopen("log_inicio.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Inicio Sesion ERROR: ".$dni.' - '.$contra.' - '.$ip_add) or die("Error escribiendo en el archivo");fclose($logFile);
echo header("Location:index.php?mensaje_error=1");
}
}


}

mysqli_free_result($result);

}else{

echo header("Location:index.php?error=vacio&user=$mail&mensaje=$mensaje");

}


?>