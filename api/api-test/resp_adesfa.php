<?php
// Incluimos el archivo de conexión a la base de datos
require_once 'conexion_api.php';
include("funciones.php");

logearPeticiones(basename(__FILE__),$_SERVER['HTTP_USER_AGENT']);

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
$nro_receta=$_GET['nro_receta'];

// Llamo a la funcion consultar receta
$json = consultarReceta($dni,$nro_receta);
$data = json_decode($json, true);

if ($json =='Receta NO se puede Dispensar') {
    // Emitir respuesta de error 401
    header('HTTP/1.1 400 Unauthorized');
    echo $json;
    exit();
}else{

//print_r($data);
// Obtener el array de "prescripcion"
$prescripciones = $data['prescripcion'];

// Función para generar el arreglo para cada prescripción
function generarArrayPrescripcion($prescripcion) {
    $nroItem = $prescripcion['renglon'];
    $codTroquel = $prescripcion['troquel'];
    $importeUnitario = ''; // Precio x cant_prescripta - No se proporciona en el array original
    $cantidadSolicitada = $prescripcion['cant_prescripta'];

// Busco el precio en la tabla y multiplico por la cantidad
    include("conexion-test.php");
    $sql = "SELECT precio FROM vade_psicotropicos WHERE troquel=$codTroquel";
    $rs = mysqli_query($conexion, $sql);
    $row1 = mysqli_fetch_array($rs);

// Multiplico precio por cantidad
    $precio=number_format($row1['precio']*$prescripcion['cant_prescripta'],2);
    
    $prescripcionArray = array('Item' => [ array(
        'NroItem' => $nroItem,
        'CodBarras' => '',
        'CodTroquel' => $codTroquel,
        'Alfabeta' => '',
        'Kairos' => '',
        'Codigo' => '',
        'ImporteUnitario' => $precio,
        'CantidadSolicitada' => $cantidadSolicitada,
        'CantidadAprobada' => '',
        'PorcentajeCobertura' => '',
        'CodPreautorizacion' => '',
        'ImporteCobertura' => '',
        'Diagnostico' => '',
        'DosisDiaria' => '',
        'DiasTratamiento' => '',
        'Generico' => ''
    ) ] );

    return $prescripcionArray;
}

// Generar el arreglo para cada prescripción
$prescripcionesArray = array();
foreach ($prescripciones as $prescripcion) {
    $prescripcionArray = generarArrayPrescripcion($prescripcion);
    $prescripcionesArray[] = $prescripcionArray;
}


$datos = array(
    "EncabezadoMensaje" => array(
        "TipoMsj" => "200",
        "CodAccion" => "290020",
        "IdMsj" => "1",
        "InicioTrx" => array(
            "Fecha" => "20220426",
            "Hora" => "210911"
        ),
        "Software" => array(
            "CodigoADESFA" => "",
            "Nombre" => "",
            "Version" => ""
        ),
        "Validador" => array(
            "CodigoADESFA" => "",
            "Nombre" => ""
        ),
        "Prestador" => array(
            "CodigoADESFA" => "",
            "Cuit" => "",
            "Codigo" => ""
        )
    ),
    "EncabezadoReceta" => array(
        "Financiador" => array(
            "Codigo" => ""
        ),
        "Beneficiario" => array(
            "TipoDoc" => "DNI",
            "NroDoc" => $dni,
        ),
        "Credencial" => array(
            "Numero" => "",
            "Plan" => ""
        ),
        "FechaReceta" => "20210917",
        "Prescriptor" => array(
            "TipoMatricula" => "P",
            "NroMatricula" => "234"
        ),
        "Formulario" => array(
            "Numero" => "9194001017622",
            "Fecha" => "20210917"
        )
    ),
    "DetalleReceta" => array(
        array($prescripcionesArray)
    )
);

$json_final = json_encode($datos);

$json_final=str_replace('[[[','',$json_final);
$json_final=str_replace(']]]','',$json_final);

echo $json_final;
}
?>