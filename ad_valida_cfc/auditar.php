<?php
// Archivo: insertar_auditoria.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... Tu código para procesar la solicitud POST ...

    // Imprimir una respuesta de depuración
    echo "Solicitud POST recibida correctamente.";
} else {
    // Manejo de casos en los que no se realiza una solicitud POST.
}
// Incluir el archivo de conexión a la base de datos
include('inc/conexion.php');

// Obtener los datos del formulario
$cantidad = $_POST['cantidad'];
$medicamento = $_POST['medicamento'];
$presentacion = $_POST['presentacion'];
$num_receta = $_POST['num_receta'];
$num_validacion = $_POST['num_validacion'];
$precio = $_POST['precio'];
$debito = $_POST['debito'];
$total_auditado = $_POST['total_auditado'];
$observaciones = $_POST['observaciones'];
$auditor = $_POST['auditor'];
$fecha_receta = $_POST['fecha_receta'];
$fecha_auditoria = $_POST['fecha_auditoria'];

// Consulta SQL para insertar datos en la tabla "auditoria"
$sql = "INSERT INTO auditoria (cantidad, medicamento, presentacion, num_receta, num_validacion, precio, debito, total_auditado, observaciones, auditor, fecha_receta, fecha_auditoria)
        VALUES ('$cantidad', '$medicamento', '$presentacion', '$num_receta', '$num_validacion', '$precio', '$debito', '$total_auditado', '$observaciones', '$auditor', '$fecha_receta', '$fecha_auditoria')";

// Ejecutar la consulta
if (mysqli_query($conexion, $sql)) {
    // Inserción exitosa
    echo "Inserción exitosa en la tabla 'auditoria'.";
} else {
    // Error en la inserción
    echo "Error al insertar datos en la tabla 'auditoria': " . mysqli_error($conexion);
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
