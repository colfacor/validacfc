<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
require_once 'conexion_api.php';
include ('conexion-test.php');
include ("funciones.php");

$headers = getallheaders();
$authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
logearPeticiones(basename(__FILE__),$_SERVER['HTTP_USER_AGENT'].' - '.$authorizationHeader);

if (!$authorizationHeader) {
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


$num_receta=$_GET['nro_receta'];
$cuit=$_GET['cuit'];
$idsucursal=$_GET['id_sucursal'];
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');
$ip_add = $_SERVER['REMOTE_ADDR'];
$tipo_opera=1;
$fecha_hoy = date("Y-m-d");

$rec3 = "SELECT *
         FROM validaciones  
         WHERE num_receta = '$num_receta' AND cuit_farm = '$cuit' AND suc_farm = '$idsucursal' 
         ORDER BY id DESC LIMIT 1";
$r3 = mysqli_query($conexion, $rec3);

if (!$r3) {
    // Error en la consulta SQL
    http_response_code(500); // Código de error interno del servidor
    //echo "Error en la consulta SQL: " . mysqli_error($conexion);
    exit;
}

$rs3 = mysqli_fetch_array($r3);

if (!$rs3) {
    // No se encontraron resultados, imprimir código 400
    http_response_code(400); // Código de solicitud incorrecta
    echo "No se encontraron resultados.";
    exit;
}

$rec4 = "SELECT dni_afi
         FROM recetas  
         WHERE num_receta = '$num_receta' 
         ORDER BY id DESC LIMIT 1";
$r4 = mysqli_query($conexion, $rec4);
$rs4 = mysqli_fetch_array($r4);

mysqli_query($conexion,"INSERT INTO validaciones_anuladas(num_receta, num_validacion, cuit_farm, suc_farm, dni, estado, dia, mes, ano, hora, minuto, ipfarm, fecha_alta) VALUES ('$num_receta', '$rs3[num_validacion]', '$rs3[cuit_farm]', '$rs3[suc_farm]', '$rs4[dni_afi]', '$tipo_opera', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_hoy')");

for ($renglon = 1; $renglon <= 4; $renglon++) {

$ch = curl_init(); // Ini
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type:application/json"
));

$body = '{
  "idReceta": "'.$num_receta.'",
  "renglon": "'.$renglon.'",
  "ip": "'.$ip_add.'",
  "codigo_dispensado": 0,
  "cantidad_dispensada": 0,
  "farmacia": 99999999999,
  "sucursal": 1,
  "dispensacion_cond": null,
  "observacion": "dispensado",
  "tipo_opera": "'.$tipo_opera.'"
}';

curl_setopt($ch, CURLOPT_URL, "https://api.recetasalud.ar/colfacor/api/v1/dispensa");
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$respuesta = curl_exec($ch); // Respuesta
curl_close($ch); // Cierro el CURL
$row=json_decode($respuesta);

}

mysqli_query($conexion,"DELETE from excep_afi 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from recetas 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from detalle_recetas 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from detalle_recetas_prescriptas 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from validaciones 
WHERE num_validacion = '$num_validacion'");

http_response_code(200);
echo "Receta anulada.";

?>