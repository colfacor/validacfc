<?php
// Conexión a la base de datos (asegúrate de incluir tu propio archivo de conexión)
include('inc/conexion.php');

// Comprueba si se ha recibido el número de cierre, el período, la número de receta y el total por POST
if (isset($_GET['num_cierre']) && isset($_GET['periodo']) && isset($_GET['num_receta']) && isset($_GET['total']) && isset($_GET['cuit_farm'])) {
    // Obtén los valores enviados por POST
    $numCierre = $_GET['num_cierre'];
    $periodo = $_GET['periodo'];
    $numReceta = $_GET['num_receta'];
    $total_tf = $_GET['total'];
    $cuitFarm = $_GET['cuit_farm'];

    // Inicializa una transacción
    mysqli_begin_transaction($conexion);

    // Realiza la inserción en la tabla detalle_cierres
    $query1 = "INSERT INTO detalle_cierres (periodo, num_cierre, num_receta, tf) VALUES ('$periodo', '$numCierre', '$numReceta', '$total_tf')";
    
    if (mysqli_query($conexion, $query1)) {
        // Inserción exitosa, ahora actualiza el estado en la tabla validaciones a 1
        $query2 = "UPDATE validaciones SET cierre = 1 WHERE num_receta = '$numReceta'";
        
        if (mysqli_query($conexion, $query2)) {
            // Realiza el último update en la tabla cierre_lotes
            $query3 = "UPDATE cierres_lotes SET tf = tf + '$total_tf', tos = tos + '$total_tf', cant_recetas = cant_recetas + 1 WHERE num_cierre = '$numCierre'";

            if (mysqli_query($conexion, $query3)) {
                // Todas las operaciones exitosas, confirma la transacción
                mysqli_commit($conexion);
            
                // Redirige a validacion_incluir.php
                header("Location: validacion_incluir.php?num_cierre=$numCierre&cuit_farm=$cuitFarm");
                exit();
            } else {
                // Error en el último update
                mysqli_rollback($conexion);
                echo "error_update_cierre_lotes";
            }
        } else {
            // Error en la actualización del estado
            mysqli_rollback($conexion);
            echo "error_update_validaciones";
        }
    } else {
        // Error en la inserción
        mysqli_rollback($conexion);
        echo "error_insert_detalle_cierres";
    }
} else {
    // Datos no recibidos adecuadamente
    echo "missing_data";
}

// Cierra la conexión a la base de datos (asegúrate de hacerlo en tu archivo de conexión)
mysqli_close($conexion);
?>