<?php
include('inc/conexion.php');
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibe los datos del formulario
    $id = $_POST["id"];
    $cantidad = $_POST["cantidad"];
    $medicamento = mysqli_real_escape_string($conexion, $_POST["medicamento"]);
    $presentacion = mysqli_real_escape_string($conexion, $_POST["presentacion"]);
    $num_receta = $_POST["num_receta"];
    $num_validacion = $_POST["num_validacion"];
    $precio = floatval($_POST["precio"]);
    $debito = floatval($_POST["debito"]);
    $total_auditado = floatval($_POST["total_auditado"]);
    $observaciones = mysqli_real_escape_string($conexion, $_POST["observaciones"]);
    $auditor = mysqli_real_escape_string($conexion, $_POST["auditor"]);
    $fecha_receta = $_POST["fecha_receta"];
    $fecha_auditoria = $_POST["fecha_auditoria"];

    // Preparar la consulta SQL (usar consultas preparadas sería aún mejor)
    $sql = "INSERT INTO auditoria (id, cantidad, medicamento, presentacion, num_receta, num_validacion, precio, debito, total_auditado, observaciones, auditor, fecha_receta, fecha_auditoria)
            VALUES ('$id', '$cantidad', '$medicamento', '$presentacion', '$num_receta', '$num_validacion', '$precio', '$debito', '$total_auditado', '$observaciones', '$auditor', '$fecha_receta', '$fecha_auditoria')";

    if (mysqli_query($conexion, $sql)) {
        echo "Inserción exitosa";
    } else {
        echo "Error en la inserción: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
?>
