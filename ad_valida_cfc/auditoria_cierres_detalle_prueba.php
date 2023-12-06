<?php 
include('inc/header.php');
include('inc/panel.php');
$ip_add = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_hoy = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
$num_receta = base64_decode($_GET['num_receta']);
$num_cierre = base64_decode($_GET['num_cierre']);
$_SESSION['num_cierre'] = $num_cierre;
$num_cierre = $_SESSION['num_cierre'];
?>

<!DOCTYPE html>

<html>
<head>
    <title>Formulario de Auditoria</title>
</head>
<body>
    <h1>Formulario de Auditoria</h1>
    <form action="insert.php" method="POST">

        <label for="cantidad">Cantidad:</label>
        <input type="text" name="cantidad" id="cantidad"><br>

        <label for="medicamento">Medicamento:</label>
        <input type="text" name="medicamento" id="medicamento"><br>

        <label for="presentacion">Presentación:</label>
        <input type="text" name="presentacion" id="presentacion"><br>

        <label for="num_receta">Número de Receta:</label>
        <input type="text" name="num_receta" id="num_receta"><br>

        <label for="num_validacion">Número de Validación:</label>
        <input type="text" name="num_validacion" id="num_validacion"><br>

        <label for="precio">Precio:</label>
        <input type="text" name="precio" id="precio"><br>

        <label for="debito">Débito:</label>
        <input type="text" name="debito" id="debito"><br>

        <label for="total_auditado">Total Auditado:</label>
        <input type="text" name="total_auditado" id="total_auditado"><br>

        <label for="observaciones">Observaciones:</label>
        <textarea name="observaciones" id="observaciones"></textarea><br>

        <label for="auditor">Auditor:</label>
        <input type="text" name="auditor" id="auditor"><br>

        <label for="fecha_receta">Fecha de Receta:</label>
        <input type="text" name="fecha_receta" id="fecha_receta"><br>

        <label for="fecha_auditoria">Fecha de Auditoria:</label>
        <input type="text" name="fecha_auditoria" id="fecha_auditoria"><br>

        <input type="submit" value="Guardar">
    </form>
</body>
</html>
