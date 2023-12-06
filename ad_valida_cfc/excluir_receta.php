<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Conexión a la base de datos (asegúrate de incluir tu propio archivo de conexión)
include('inc/conexion.php');

if (isset($_GET['num_receta']) && isset($_GET['num_cierre']) && isset($_GET['tf']) && isset($_GET['cuit_farm'])) {
    // Obtén los valores enviados por GET
    $numReceta = $_GET['num_receta'];
    $numCierre = $_GET['num_cierre'];
    $tf = $_GET['tf'];
    $cuitFarm = $_GET['cuit_farm'];

    // Inicializa una transacción
    mysqli_begin_transaction($conexion);

    // 1. Actualiza el campo 'cierre' en la tabla 'validaciones' de 1 a 0
    $query1 = "UPDATE validaciones SET cierre = 0 WHERE num_receta = '$numReceta'";
    
    if (mysqli_query($conexion, $query1)) {
        // 2. Elimina el registro en la tabla 'detalle_cierres'
        $query2 = "DELETE FROM detalle_cierres WHERE num_receta = '$numReceta' AND num_cierre = '$numCierre'";
        
        if (mysqli_query($conexion, $query2)) {
            // 3. Actualiza la tabla 'cierre_lotes' para restar el valor de 'tf', 'tos' y reducir en 1 'cant_recetas'
            $query3 = "UPDATE cierres_lotes SET tf = tf - '$tf', tos = tos - '$tf', cant_recetas = cant_recetas - 1 WHERE num_cierre = '$numCierre'";

            if (mysqli_query($conexion, $query3)) {
                // Todas las operaciones exitosas, confirma la transacción
                mysqli_commit($conexion);
                
                // Redirige de vuelta a la página de origen
                $encodedNumCierre = base64_encode($numCierre);
                header("Location: auditoria_cierres_detalle.php?num_cierre=$encodedNumCierre&cuit_farm=$cuitFarm");
               // header("Location: auditoria_cierres_detalle.php?num_cierre=$numCierre&cuit_farm=$cuitFarm");
                exit();
            } else {
                // Error en la actualización de 'cierre_lotes'
                mysqli_rollback($conexion);
                echo "error_update_cierre_lotes";
            }
        } else {
            // Error en la eliminación de 'detalle_cierres'
            mysqli_rollback($conexion);
            echo "error_delete_detalle_cierres";
        }
    } else {
        // Error en la actualización de 'validaciones'
        mysqli_rollback($conexion);
        echo "error_update_validaciones";
    }
} else {
    // Datos no recibidos adecuadamente
    echo "missing_data";
}

// Cierra la conexión a la base de datos (asegúrate de hacerlo en tu archivo de conexión)
mysqli_close($conexion);
?>
