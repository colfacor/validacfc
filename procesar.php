<?php
$conexion = mysqli_connect("localhost", "validacfc_user", "gn8Ap#&4Pxd$", "validacfc_base") or die("Problemas con la conexión");
mysqli_set_charset($conexion, "utf8");

// Obtener el código de barras escaneado desde la URL
$codigoBarras = $_GET['codigo'];

// Realizar una consulta para buscar la validación
$query = "SELECT num_validacion FROM validaciones WHERE num_validacion = '$codigoBarras'";
$result = mysqli_query($conexion, $query);

if ($row = mysqli_fetch_assoc($result)) {
    // Si se encuentra la validación, devolverla como respuesta JSON
    echo json_encode($row);
} else {
    // Si no se encuentra la validación, devolver un JSON vacío o un mensaje de error
    echo json_encode([]);
}
?>
