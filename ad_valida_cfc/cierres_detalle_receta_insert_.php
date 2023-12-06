<?php
$cantidad = $_POST['cantidad'];
$medicamento = urldecode($_POST['medicamento']);
$presentacion = urldecode($_POST['presentacion']);
$fecha_receta = $_POST['fecha_receta'];
$num_receta = $_POST['num_receta'];
$debito = $_POST['debito'];
$auditor = $_POST['auditor'];
$total_auditado = $_POST['total_auditado'];
$observaciones = $_POST['observaciones'];
$precio = $_POST['precio'];
$fecha_auditoria = date("Y-m-d");
$renglon = $_POST['renglon'];
$num_cierre = $_POST['num_cierre'];

// Verifica si ya existe un registro en la tabla auditoria con el mismo num_receta y renglon
include('inc/conexion.php');
$query = "SELECT * FROM auditoria WHERE num_receta = '$num_receta' AND renglon = '$renglon'";
$result = mysqli_query($conexion, $query);

if (mysqli_num_rows($result) > 0) {
    // Si ya existe un registro, realiza una actualización en lugar de una inserción
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $updateQuery = "UPDATE auditoria SET cantidad='$cantidad', presentacion='$presentacion', medicamento='$medicamento', precio='$precio', debito='$debito' , num_cierre='$num_cierre', total_auditado='$total_auditado', observaciones='$observaciones', auditor='$auditor', fecha_receta='$fecha_receta', fecha_auditoria='$fecha_auditoria' WHERE num_receta = '$num_receta' AND renglon = '$renglon'";
    mysqli_query($conexion, $updateQuery);
} else {
    // Si no existe un registro, realiza una inserción
    $insertQuery = "INSERT INTO auditoria(cantidad, presentacion, medicamento, num_receta, debito, precio, total_auditado, observaciones, auditor, fecha_receta, fecha_auditoria, renglon, num_cierre) VALUES ('$cantidad', '$presentacion', '$medicamento', '$num_receta', '$debito', '$precio','$total_auditado', '$observaciones', '$auditor', '$fecha_receta', '$fecha_auditoria', '$renglon', '$num_cierre')";
    mysqli_query($conexion, $insertQuery);
}

// Actualiza el campo 'precio' en la tabla 'detalle_recetas' con el valor de 'total_auditado'  CANTIDAD SI SE ROMPE EL CODIGO SACAR ESTO
$updatePrecioQuery = "UPDATE detalle_recetas SET precio='$total_auditado', cantidad='$cantidad' WHERE num_receta = '$num_receta' AND renglon = '$renglon'";
mysqli_query($conexion, $updatePrecioQuery);

// Obtiene el valor actual de 'tf' en la tabla 'detalle_cierres'
$selectTfQuery = "SELECT tf FROM detalle_cierres WHERE num_receta = '$num_receta'";
$resultTf = mysqli_query($conexion, $selectTfQuery);
$rowTf = mysqli_fetch_assoc($resultTf);

if ($rowTf) {
    $tfActual = $rowTf['tf'];
    // Resta el valor de 'debito' al valor actual de 'tf'
    $tfNuevo = $tfActual - $debito;
    
    // Actualiza el campo 'tf' en la tabla 'detalle_cierres' con el nuevo valor
    $updateTfQuery = "UPDATE detalle_cierres SET tf='$tfNuevo' WHERE num_receta = '$num_receta'";
    mysqli_query($conexion, $updateTfQuery);
}

// Obtén el valor actual de 'tf' y 'tos' en la tabla 'cierres_lotes'
$selectCierresQuery = "SELECT tf, tos FROM cierres_lotes WHERE num_cierre = '$num_cierre'";
$resultCierres = mysqli_query($conexion, $selectCierresQuery);
$rowCierres = mysqli_fetch_assoc($resultCierres);

if ($rowCierres) {
    $tfActual = $rowCierres['tf'];
    $tosActual = $rowCierres['tos'];

    // Resta el valor de 'debito' a los valores actuales de 'tf' y 'tos'
    $tfNuevo = $tfActual - $debito;
    $tosNuevo = $tosActual - $debito;

    // Actualiza los campos 'tf' y 'tos' en la tabla 'cierres_lotes' con los nuevos valores
    $updateCierresQuery = "UPDATE cierres_lotes SET tf='$tfNuevo', tos='$tosNuevo' WHERE num_cierre = '$num_cierre'";
    mysqli_query($conexion, $updateCierresQuery);
}

header("Location: cierres_detalle_receta.php?num_receta=" . base64_encode($num_receta) . "&num_cierre=" . base64_encode($num_cierre));

 
 //header("Location: cierres_detalle_receta.php?num_receta=" . base64_encode($num_receta));
 


?>
