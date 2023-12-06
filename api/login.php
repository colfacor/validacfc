<?php
// Incluimos el archivo de conexión a la base de datos
require_once 'conexion_api.php';
//logearPeticiones();
// Definimos la IP del cliente
$clientIp = $_SERVER['REMOTE_ADDR'];

// Consultamos si la IP está en la tabla whitelist
$sql = "SELECT * FROM whitelist WHERE ip = '$clientIp'";
$resultado = $conexion_api->query($sql);

if ($resultado->num_rows == 0) {
  // Si la dirección IP no está permitida, enviamos una respuesta de error 400
  http_response_code(401);
  echo 'Acceso denegado.';
  exit;
}

// Verificamos si se han enviado los datos del formulario
if (isset($_GET['username']) && isset($_GET['password'])) {
    // Comprobamos si el usuario y la contraseña son correctos
    $username = $_GET['username'];
    $password = md5($_GET['password'].'gastu');

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $resultado = $conexion_api->query($sql);

    if ($resultado->num_rows == 1) {
      // Si el usuario y la contraseña son correctos, creamos un token de acceso
      $token = bin2hex(random_bytes(16));
      $expiration = date('Y-m-d H:i:s', strtotime('+4 hours'));
        
      // Insertamos el token en la tabla "token"
      $sql_token = "INSERT INTO token (user, token, expiration) VALUES ('$username', '$token', '$expiration')";
      $resultado_token = $conexion_api->query($sql_token);

      if ($resultado_token) {
        // Si se inserta correctamente el token, enviamos la respuesta con el token generado
        http_response_code(200);
        echo json_encode($token);
        exit;
      } else {
        // Si no se inserta correctamente el token, mostramos un mensaje de error
        http_response_code(400);
        echo 'No se pudo generar el token.';
      }

    } else {
      // Si los datos no son correctos, mostramos un mensaje de error
      http_response_code(401);
      echo 'Usuario o contraseña incorrectos.';
    }

}else{
  // Si no se han enviado los datos del formulario, enviamos una respuesta de error 400
  http_response_code(400);
  echo 'Se requiere un nombre de usuario y una contraseña.';
  exit;
}

?>