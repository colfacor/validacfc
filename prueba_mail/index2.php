<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Documento</title>
</head>
<style>
	body{
		text-align:  center;
	}
</style>
<body>
	<h2>Formulario de contacto</h2>
	<form action="index2.php" method="POST">
		<label for="nombre">Nombre</label>
		<input type="text" id="nombre" name="nombre"><br>
		<label for="email">Email</label>
		<input type="email" id="email" name="email"><br>
		<label for="mensaje">Mensaje</label>
		<textarea name="mensaje" id="mensaje" cols="30" rows="10"></textarea><br>
		<input type="submit" value="enviar" name="enviar">
	</form>

	<?php 
   if(isset($_POST["enviar"])){
    $nombre=$_POST["nombre"];
    $email=$_POST["email"];
    $mensaje=$_POST["mensaje"];

    $destinatario="gastondangelo12@gmail.com";
    $asunto="nuevo mensaje de $email";

    $contenido="Nombre : $nombre \n";
    $contenido="email : $email \n";
    $contenido="mensaje : $mensaje \n";

    $header="From: colfacor.org.ar";

    $mail=mail($destinatario,$asunto,$contenido,$header);

    if($mail){
    	echo "<script>alert('el correo se encio correctamente');</script>";
    }else{
    	echo "<script>alert('el correo no se envio');</script>";
    }
    }
   

    ?>
</body>
</html>