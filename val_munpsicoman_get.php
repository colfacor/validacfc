<?php
// Conecta a la base de datos (Asegúrate de cambiar estos valores según tu configuración)
$servername = "localhost";
$username = "validacfc_user";
$password = "gn8Ap#&4Pxd$";
$dbname = "validacfc_base";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $opcion = $_POST["opcion"];
    
    // Realiza la consulta a la base de datos según la opción seleccionada
    // Cambia la consulta y las columnas de acuerdo a tu estructura de base de datos
    $sql = "SELECT troquel, medicamento, marca, presentacion, precio FROM vade_psicotropicos WHERE id = '$opcion'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resultado1 = $row["troquel"];
        $resultado2 = $row["medicamento"];
        $resultado3 = $row["marca"];
        $resultado4 = $row["presentacion"];
        $resultado5 = $row["precio"];
        
        $response = array("resultado1" => $resultado1, "resultado2" => $resultado2, "resultado3" => $resultado3, "resultado4" => $resultado4, "resultado5" => $resultado5);
        echo json_encode($response);
    }
    else {
        echo "Sin resultados";
    }
}

$conn->close();
?>