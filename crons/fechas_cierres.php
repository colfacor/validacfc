<?php
include "../inc/conexion.php"; // Incluir archivo de conexión

// Vaciar la tabla "ma_fechas_presentacion"
$vaciarTablaQuery = "TRUNCATE TABLE ma_fechas_presentacion";
mysqli_query($conexion, $vaciarTablaQuery);

// Obtener datos de la API y insertarlos en la tabla
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type:application/json"
));

curl_setopt($ch, CURLOPT_URL, "https://www.colfacor.org.ar/api_fechas.php?key=clave");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$respuesta = curl_exec($ch);
curl_close($ch);

$rows = json_decode($respuesta, true);

foreach ($rows as $row) {
    $fecha_inicio = $row['fecha_inicio'];
    $fecha_presentacion = $row['fecha_presentacion'];
    $fecha_bloqueo = $row['fecha_bloqueo'];
    $quincena = $row['quincena'];
    $estado = $row['estado'];
    $periodo = $row['periodo'];



    $insertarQuery = "INSERT INTO ma_fechas_presentacion (fecha_inicio, fecha_presentacion, fecha_bloqueo, quincena, estado, periodo,leyenda) VALUES ('$fecha_inicio', '$fecha_presentacion','$fecha_bloqueo','$quincena','$estado','$periodo','')";
    mysqli_query($conexion, $insertarQuery);
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
