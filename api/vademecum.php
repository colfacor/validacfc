<?php
// Incluimos el archivo de conexión a la base de datos
require_once 'conexion_api.php';
//logearPeticiones();

$headers = getallheaders();
$authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if (!$authorizationHeader) {
    header('HTTP/1.1 401 Unauthorized');
    exit;
}

// Definimos la IP del cliente
$clientIp = $_SERVER['REMOTE_ADDR'];

// Consultamos si la IP está en la tabla whitelist
$sql = "SELECT * FROM whitelist WHERE ip = '$clientIp'";
$resultado = $conexion_api->query($sql);

if ($resultado->num_rows == 0) {
  // Si la dirección IP no está permitida, enviamos una respuesta de error 400
    header('HTTP/1.1 401 Unauthorized');
  exit;
}

$token = str_replace('Bearer ', '', $authorizationHeader);

    $sql = "SELECT * FROM token WHERE token ='$token' AND expiration >= NOW()";
    $result = mysqli_query($conexion_api,$sql);

// Verificar si hay resultados en la consulta
if (mysqli_num_rows($result) == 0) {
    // Emitir respuesta de error 401
    header('HTTP/1.1 401 Unauthorized');
    exit();
}


// el token es válido, se puede continuar con la lógica de la aplicación


//Chequeo que el usuario tenga permisos para el endpoint





//DEVUELVE PSICOTROPICOS
if($_GET['data']=='psicotropicos'){

        // incluir archivo de conexión a la base de datos
        include('../inc/conexion.php');

        // consulta para obtener todos los datos de la tabla
        $sql = "SELECT a.reg, a.troquel, a.medicamento, a.marca	, a.presentacion, c.des, a.estado	            	                                         
		                                                  FROM vade_psicotropicos a
		                                                  LEFT JOIN alfabeta_laboratorios c
		                                                  ON a.cod_laboratorio = c.id";

        // ejecutar consulta y obtener resultado
        $resultado = mysqli_query($conexion, $sql);

        // verificar si hay resultados
        if(mysqli_num_rows($resultado) > 0){
            // crear arreglo para almacenar los datos
            $datos = array();

            // recorrer resultados y agregarlos al arreglo
            while($fila = mysqli_fetch_assoc($resultado)){
                $datos[] = $fila;
            }

            // convertir arreglo a formato JSON y mostrar en pantalla
            http_response_code(200);
            echo json_encode($datos);
        } else {
            // mostrar mensaje de error si no hay resultados
          http_response_code(404);
            echo "No se encontraron datos";
        }

        // cerrar conexión a la base de datos
        mysqli_close($conexion);
        exit();
}


//Devuelve psicotropicos de mejorar
if($_GET['data']=='mejorar'){

        // incluir archivo de conexión a la base de datos
        include('../inc/conexion.php');

        // consulta para obtener todos los datos de la tabla
        $sql = "SELECT a.troquel, a.medicamento, a.presentacion, c.des, a.marca		            	                                         
		                                                  FROM vade_mejorar a
		                                                  LEFT JOIN alfabeta_laboratorios c
		                                                  ON a.cod_laboratorio = c.id WHERE a.estado=1";

        // ejecutar consulta y obtener resultado
        $resultado = mysqli_query($conexion, $sql);

        // verificar si hay resultados
        if(mysqli_num_rows($resultado) > 0){
            // crear arreglo para almacenar los datos
            $datos = array();

            // recorrer resultados y agregarlos al arreglo
            while($fila = mysqli_fetch_assoc($resultado)){
                $datos[] = $fila;
            }

            // convertir arreglo a formato JSON y mostrar en pantalla
            http_response_code(200);
            echo json_encode($datos);
        } else {
            // mostrar mensaje de error si no hay resultados
          http_response_code(404);
            echo "No se encontraron datos";
        }

        // cerrar conexión a la base de datos
        mysqli_close($conexion);
        exit();
}

http_response_code(404);
 echo "No se encontraron datos";
?>