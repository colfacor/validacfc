<?php
// Incluimos el archivo de conexión a la base de datos
require_once 'conexion_api.php';

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


//DEVUELVE EXEPCIONES SEGUN PERIODO / FECHA
if(is_null($_GET["desde"] ) or is_null($_GET["hasta"] )){
        // mostrar mensaje de error si no hay resultados
        http_response_code(404);
}else{

        // incluir archivo de conexión a la base de datos
        include('../inc/conexion.php');
       
        // consulta para obtener todos los datos de la tabla
        $sql = "SELECT a.num_receta, a.fecha_alta, b.fecha_receta, b.mp_med, b.dni_afi, c.renglon, c.cantidad, c.precio, d.medicamento, d.presentacion, f.nombre as nom, f.apellido as ape, g.farmacia, f.diagnostico, c.troquel, h.periodo, a.dia, a.hora, a.minuto, a.ano, a.mes, i.motivo
                                  FROM validaciones a 
                                  LEFT JOIN recetas b 
                                  ON a.num_receta = b.num_receta
                                  LEFT JOIN detalle_recetas c 
                                  ON b.num_receta = c.num_receta
                                  LEFT JOIN vade_psicotropicos d 
                                  ON c.troquel = d.troquel 
                                  LEFT JOIN pad_psicotropicos f 
                                  ON b.dni_afi = f.dni
                                  LEFT JOIN users g 
                                  ON a.cuit_farm = g.cuit AND a.suc_farm = g.idsucursal
                                  LEFT JOIN detalle_cierres h 
                                  ON a.num_receta = h.num_receta
                                   LEFT JOIN excep_afi i 
                                  ON a.num_receta = i.num_receta
                                  WHERE  a.fecha_alta BETWEEN '$_GET[desde]' AND '$_GET[hasta]'
                                  ORDER BY f.apellido ASC";

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