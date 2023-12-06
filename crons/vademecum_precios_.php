<?php
include '../inc/conexion.php';

date_default_timezone_set("America/Argentina/Buenos_Aires");
$fecha = date('Y-m-d');
$fecha_date = date('Y-m-d h:i:s');

// Obtener los datos de alfabeta_articulos
$alfa_query = "SELECT * FROM alfabeta_articulos";
$result_alfa = mysqli_query($conexion, $alfa_query);
$rs_alfa = mysqli_fetch_array($result_alfa); 
$reg_ = $rs_alfa['reg'];

if(empty($reg_)) {
    echo "NO SE ACTUALIZARON LOS PRECIOS PORQUE LA TABLA ESTA VACIA";
    // ... código para enviar mensaje de error a Telegram ...
    exit();
} else {
    // Consulta para obtener todos los datos necesarios de vade_psicotropicos
    $psico_query = "SELECT * FROM vade_psicotropicos WHERE porcentaje > 0";
    $result_psico = mysqli_query($conexion, $psico_query);

    if (!$result_psico) {
        die("Error al consultar la base de datos: " . mysqli_error($conexion));
    }

    while ($rs = mysqli_fetch_array($result_psico)) {
        $reg = $rs['reg'];
        $precio = $rs['precio'];
        $comprimidos_ab = $rs['comprimidos_ab'];
        $porcentaje = $rs['porcentaje'] / 100;

        // Consultar alfabeta_articulos para cada registro de vade_psicotropicos
        $padron_query = "SELECT * FROM alfabeta_articulos WHERE reg = '$reg'";
        $result_padron = mysqli_query($conexion, $padron_query);
        $rs_padron = mysqli_fetch_array($result_padron);

        if(empty($rs_padron['prc'])) {
            echo "ALGUNOS MEDICAMENTOS NO SE ENCONTRARON: ".$rs['medicamento']." | ".$rs['marca']." | ".$rs['presentacion'].'<br>';
        } else {
            $precio_nuevo_ab = ($rs_padron['prc'] - ($rs_padron['prc'] * $porcentaje)) / $comprimidos_ab;
            
            // Utilizar prepared statements para actualizar vade_psicotropicos
            $update_query = "UPDATE vade_psicotropicos SET precio = ?, modif = ? WHERE reg = ?";
            $stmt = mysqli_prepare($conexion, $update_query);
            mysqli_stmt_bind_param($stmt, "dss", $precio_nuevo_ab, $fecha_date, $reg);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    echo "PRECIOS ACTUALIZADOS";
}
?>