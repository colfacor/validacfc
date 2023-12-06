<?php

if($_POST["contra"]==$_POST["contra1"]){

include('inc/conexion.php');
session_start();
$dni=$_SESSION["dni"];
$clave = md5($_POST["contra"].'contra');	 

 $registros = mysqli_query($conexion,"INSERT INTO usuarios (contra,user) VALUES ('$clave','$dni');");
echo header("Location:index.php");

}else{
	 echo header("Location:1login.php?error=1");
} ?>