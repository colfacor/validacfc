<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
// Incluimos el archivo de conexión a la base de datos
require_once 'conexion_api.php';
require_once 'conexion-test.php';
include("funciones.php");
//logearPeticiones();

$headers = getallheaders();
$authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

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


// el token es válido, se puede continuar con la lógica de la aplicación
$dni=$_GET['dni'];
$num_receta=$_GET['nro_receta'];
$cuit=$_GET['cuit'];
$idsucursal=$_GET['id_sucursal'];
$ip_add = $_SERVER['REMOTE_ADDR'];
$id_obrasocial = $_GET['id_obrasocial'];
$cantidad= $_GET['cant_prescripta'];
$renglon= $_GET['renglon'];
$troquel= $_GET['troquel'];

//VALIDAR LA FARMACIA QUE SE CONECTA


// Consulto la receta
$json = consultarReceta($dni,$num_receta);
$row = json_decode($json, true);
//print_r($json);


if ($json =='Receta NO se puede Dispensar') {
    // Emitir respuesta de error 401
    header('HTTP/1.1 400 Unauthorized');
    echo $json;
    exit();
}else{

//Valido que la obra social sea muni
    if($id_obrasocial==1){
        $sigipsa='SI';
        
        //VALIDANDO LA RECETA
        $respuesta = val_munpsico($cuit,$idsucursal,$num_receta,$sigipsa,$dni,$cantidad,$renglon,$troquel);
        
        header('HTTP/1.1 200');

        $resp_munpsico=substr($respuesta, 0,6);
        if($resp_munpsico=='compro'){
            echo 'https://validacfc.colfacor.org.ar/'.$respuesta;
        }else{
            header('HTTP/1.1 400');
            echo "Error: ".$respuesta;
        }
    }

}



?>