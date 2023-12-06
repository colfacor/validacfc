<?php
include('inc/conexion.php');
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibe los datos del formulario
    $cantidad = $_POST["cantidad_modal"];
    $medicamento = mysqli_real_escape_string($conexion, $_POST["medicamento_modal"]);
    $presentacion = mysqli_real_escape_string($conexion, $_POST["presentacion_modal"]);
    $num_receta = mysqli_real_escape_string($conexion, $_POST["num_receta"]);
    $precio = floatval($_POST["precio"]);
    $debito = floatval($_POST["debito"]);
    $total_auditado = floatval($_POST["total_real"]);
    $observaciones = mysqli_real_escape_string($conexion, $_POST["observaciones"]);
    $auditor = mysqli_real_escape_string($conexion, $_POST["auditor"]);
    $fecha_receta = mysqli_real_escape_string($conexion, $_POST["fecha_receta"]);
    $fecha_auditoria = mysqli_real_escape_string($conexion, $_POST["fecha_auditoria"]);

    // Preparar la consulta SQL (usar consultas preparadas sería aún mejor)
    $sql = "INSERT INTO auditoria (cantidad, medicamento, presentacion, num_receta, precio, debito, total_auditado, observaciones, auditor, fecha_receta, fecha_auditoria)
            VALUES ('$cantidad', '$medicamento', '$presentacion', '$num_receta', '$precio', '$debito', '$total_auditado', '$observaciones', '$auditor', '$fecha_receta', '$fecha_auditoria')";

    if (mysqli_query($conexion, $sql)) {
        echo "Inserción exitosa";
    } else {
        echo "Error en la inserción: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
?>
