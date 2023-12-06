<?php

// Verificamos si se han proporcionado los parámetros necesarios
if(isset($_GET['num_cierre'], $_GET['num_receta'], $_GET['renglon'])) {
    $num_cierre = $_GET['num_cierre'];
    $num_receta = $_GET['num_receta'];
    $renglon = $_GET['renglon'];

    // Conectamos a la base de datos
    include('inc/conexion.php');

    // Obtenemos la cantidad y el precio de la tabla detalle_recetas
    $consulta_detalle_receta = mysqli_query($conexion, "SELECT cantidad, precio FROM detalle_recetas WHERE num_receta = '$num_receta' AND renglon = '$renglon'");
    $detalle_receta = mysqli_fetch_assoc($consulta_detalle_receta);

    if($detalle_receta) {
        $cantidad = $detalle_receta['cantidad'];
        $precio = $detalle_receta['precio'];

        // Dividimos el precio por la cantidad
        $precio_actualizado = $cantidad > 0 ? $precio / $cantidad : 0;

        // Actualizamos la tabla detalle_recetas
        $actualizar_detalle_receta = mysqli_query($conexion, "UPDATE detalle_recetas SET precio = '$precio_actualizado' WHERE num_receta = '$num_receta' AND renglon = '$renglon'");

        if($actualizar_detalle_receta) {
            // Redirigimos a la página principal con un mensaje de éxito
            //header("Location: cierres_detalle_receta.php?mensaje=actualizacion_exitosa");
            header("Location: cierres_detalle_receta.php?num_receta=" . base64_encode($num_receta) . "&num_cierre=" . base64_encode($num_cierre));
            exit();
        } else {
            echo "Error al actualizar el importe: " . mysqli_error($conexion);
        }
    } else {
        echo "No se encontró el registro ";
    }

    // Cerramos la conexión a la base de datos
    mysqli_close($conexion);
} else {
    echo "Faltan parámetros necesarios para la actualización.";
}
?>
