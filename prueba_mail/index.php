<?php
include('mail.php');
$conexion = mysqli_connect("localhost", "validacfc_user", "gn8Ap#&4Pxd$", "validacfc_base") or
    die("Problemas con la conexión");
mysqli_set_charset($conexion, "utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $receta = $_POST["receta"];
    $dni_afiliado = $_POST["dni_afiliado"];

    // Verificar si los datos existen en la base de datos y la receta tiene estado 0
    $query = "SELECT datos.id, datos.dni, datos.estado, datos_afi.nombre, datos_afi.mail FROM datos
              INNER JOIN datos_afi ON datos.dni = datos_afi.dni_afi
              WHERE datos.receta = '$receta' AND datos_afi.dni_afi = '$dni_afiliado' AND datos.estado = 0";

    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Cambiar el estado de la receta a 1
        $receta_id = $row["id"];
        $update_query = "UPDATE datos SET estado = 1 WHERE id = $receta_id";
        mysqli_query($conexion, $update_query);

        // Enviar correo al afiliado
        $afiliado_nombre = $row["nombre"];
        $afiliado_mail = $row["mail"];

        $subject = "Satisfacción de uso del sistema";
        $message = "Estimado $afiliado_nombre,\n\n";
        $message .= "Su receta con número $receta ha sido ingresada con éxito.\n";
        $message .= "Gracias por utilizar nuestro sistema.";

        // Configurar las cabeceras del correo
        $headers = "From: cfc@colfacor.org.ar\r\n";
        $headers .= "Reply-To: gastondangelo@colfacor.org.ar\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Enviar el correo - Usar $afiliado_mail como destinatario
        if (mail($afiliado_mail, $subject, $message, $headers)) {
            echo "Receta ingresada con éxito y correo enviado a $afiliado_mail.";
        } else {
            echo "Receta ingresada con éxito, pero hubo un error al enviar el correo.";
        }
    } else {
        // Datos no encontrados o receta ya registrada
        $query = "SELECT id FROM datos WHERE receta = '$receta' AND estado = 1";
        $result = mysqli_query($conexion, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "Receta ya registrada.";
        } else {
            echo "Los datos no existen en nuestra base de datos.";
        }
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Receta</title>
</head>
<body>
    <form method="post" action="">
        <label for="receta">Número de Receta:</label>
        <input type="text" name="receta" required><br><br>

        <label for="dni_afiliado">DNI del Afiliado:</label>
        <input type="text" name="dni_afiliado" required><br><br>

        <!-- Agregar un campo oculto para el destinatario -->
        <input type="hidden" name="recipient" value="<?php echo $afiliado_mail; ?>">

        <input type="submit" value="Ingresar Receta">
    </form>
</body>
</html>
