<?php

function padronSigipsa($dni){
$usuario = 'CFC_sivadon_e';
$contra = 'kIisx7bVmxCFV4r';

//consulto MASCULINO
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://misvalidaciones.dev.cordoba.gob.ar/api/consultarActivoPSS?dni=$dni",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 3,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic '.base64_encode("$usuario:$contra")
  ),
));

$response = curl_exec($curl);
curl_close($curl);
$data= json_decode($response, true);


  if ($data['lista'][0]['persona']['activo'] === 'SI') {
    //Respondo con el OK
    return 'OK';
    }else{
    //Respondo con la excepcion 
    //return $data['lista'][0]['persona']['detalleActivo'];
        return null;
  }

}

function consultarReceta($dni,$nro_receta){
  $ch = curl_init(); // Ini
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type:application/json"
  ));
   $body = '{
          "id":"'.$nro_receta.'",
          "dni":"'.$dni.'",
          "cuit":99999999999,
          "sucursal":1,
          "apikey":"d881d8ea2402b131bd1c7a7cfd199ddb",
          "opera":0
        }';

  curl_setopt($ch, CURLOPT_URL, "https://api.recetasalud.ar/colfacor/api/v1/recetasearch");
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 3); 
  $respuesta = curl_exec($ch); // Respuesta
  
  if ($respuesta === false) {
      // No hubo respuesta del endpoint dentro del tiempo de espera
      $error = curl_error($ch);
      return "Error en servidor CMPC: " . $error;
  }

  curl_close($ch); // Cierro el CURL
  return $respuesta;       
}


// Función para verificar si un usuario tiene permiso del endpoint
function verificarPermiso($usuario, $endpoint) {
 
    // Consulta para verificar el permiso
    $sql = "SELECT COUNT(*) AS count FROM permisos WHERE usuario = $usuario AND endpoint = '$endpoint'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row["count"];
        
        // Si se encontró al menos un registro, el usuario tiene el permiso
        if ($count > 0) {
            return true;
        }
    }
    
    // Si no se encontró ningún registro o el permiso no coincide, el usuario no tiene el permiso
    return false;
}

function logearPeticiones($endpoint,$useragent) {
    // Establecer la zona horaria a Argentina
    date_default_timezone_set('America/Argentina/Buenos_Aires');

    // Obtener el método de la petición
    $metodo = $_SERVER['REQUEST_METHOD'];
    
    // Obtener los datos de la petición según el método
    switch ($metodo) {
        case 'GET':
            $datos = $_GET;
            break;
        case 'POST':
            $datos = $_POST;
            break;
        case 'PUT':
            parse_str(file_get_contents("php://input"), $datos);
            break;
        default:
            $datos = array();
            break;
    }
    
    // Obtener la fecha y hora actual
    $fechaHora = date('Y-m-d H:i:s');
    
    // Crear una cadena con la información de la petición, nombre del archivo y la fecha/hora
    $registro = "Fecha/Hora: " . $fechaHora . "\n";
    $registro .= "EndPoint: " . $endpoint . "\n";
    $registro .= "Método: " . $metodo . "\n";
    $registro .= "Datos: " . print_r($datos, true) . "\n";
    $registro .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
    $registro .= "User-Agent: " . $useragent . "\n";
    $registro .= "----------------------------------------------\n";
    
    // Guardar el registro en un archivo de texto
    file_put_contents('../../peticiones-test.log', $registro, FILE_APPEND);
}




function val_munpsico($cuit, $idsucursal, $num_receta, $sigipsa, $dni, $cantidad, $renglon, $troquel)
{
    include('conexion-test.php');

    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha_hoy = date('Y-m-d');
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    $hora = date('H');
    $minuto = date('i');
    $ip_add = $_SERVER['REMOTE_ADDR'];
    $id_obrasocial = 1;




    //CREO CONEXION API DATOS DE RECETA 
    $ch = curl_init(); // Inicio de CURL
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json"
    ));

    $body = '{
        "id": "'.$num_receta.'",
        "dni": "'.$dni.'",
        "cuit": 99999999999,
        "sucursal": 1,
        "apikey":"d881d8ea2402b131bd1c7a7cfd199ddb",
        "opera": 0
    }';

    curl_setopt($ch, CURLOPT_URL, "https://api.recetasalud.ar/colfacor/api/v1/recetasearch");
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($ch); // Respuesta
    curl_close($ch); // Cierro el CURL

    // Decoding the response as an associative array (true parameter)
    $row = json_decode($respuesta);

//print_r($row);

$apellido = $row->apellido;
$nombre = $row->nombre;
$sigla_os = $row->sigla_os;
$dni = $row->dni;
$nroafiliado = $row->nroafiliado;
$fechaemision = $row->fechaemision;
//$ley = $row->ley25649;
$matricprescr = $row->matricprescr;
$apellidomed = $row->apellidomed;
$nombremed = $row->nombremed;
$matricespec_prescr = $row->matricespec_prescr;
$denominacion = $row->denominacion;
$linkreceta = $row->linkreceta;

//$nro_receta=$row->prescripcion[1];
//$cant_prescripta=$row->prescripcion[0];
$fecha_emision_subst = substr($fechaemision, 0, -14);

//print_r($cant_prescripta);


/*
    $apellido = $respuesta['apellido'] ?? '';
    $nombre = $respuesta['nombre'] ?? '';
    $sigla_os = $respuesta['sigla_os'] ?? '';
    $dni = $respuesta['dni'] ?? '';
    $nroafiliado = $respuesta['nroafiliado'] ?? '';
    $fechaemision = $respuesta['fechaemision'] ?? '';
    $ley = $respuesta['prescripcion'][0]['ley'] ?? ''; 
    $matricprescr = $respuesta['matricprescr'] ?? '';
    $apellidomed = $respuesta['apellidomed'] ?? '';
    $nombremed = $respuesta['nombremed'] ?? '';
    $matricespec_prescr = $respuesta['matricespec_prescr'] ?? '';
    $denominacion = $respuesta['denominacion'] ?? '';
    $linkreceta = $respuesta['linkreceta'] ?? '';

    $nro_receta = $respuesta['prescripcion'][0]['nro_receta'] ?? ''; 
    $cant_prescripta = $respuesta['prescripcion'][0]['cant_prescripta'] ?? ''; 
    $fecha_emision_subst = substr($fechaemision, 0, -14);
*/
    $logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
    fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validaciones: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' - '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");
    fclose($logFile);

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $obr = ("SELECT * FROM obras_sociales WHERE id = '$id_obrasocial'");
    $r1 = mysqli_query($conexion, $obr);
    $rs1 = mysqli_fetch_array($r1);
    $padron = $rs1['padron'];



    //VALIDO QUE LA FARMACIA ESTE HABILITADA PARA RECIBIR LA OBRA SOCIAL
    if ($padron == 1) {
        $farmhab = ("SELECT * FROM farm_habilitadas WHERE cuit = '$cuit' AND idsucursal = '$idsucursal' AND id_obrasocial = '$id_obrasocial'");
        $r1 = mysqli_query($conexion, $farmhab);
        $rs1 = mysqli_fetch_array($r1);
        $cuit_ = $rs1['cuit'];
        $idsucursal_ = $rs1['idsucursal'];
        if ($cuit_ <> $cuit && $idsucursal_ <> $idsucursal) {
            $logFile = fopen("log/log_farmacianohabilitada.txt", 'a') or die("Error creando archivo");
            fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: FARMACIA NO HABILITADA PARA LA OBRA SOCIAL: ".$id_obrasocial.'  '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");
            fclose($logFile);
            return base64_encode('fh');
            exit();
        }
    }

    $cant = $cantidad;
    $renglon = $renglon;
    $troq = $troquel;

    //VALIDO QUE LA CANTIDAD SEA IGUAL O MAYOR A LA PRESCRIPCION DEL MEDICO
    $cant = array(); // Inicializar la variable $cant como un array vacío
    foreach ($cant as $index => $value) {
        $medi = ("SELECT precio, comprimidos FROM vade_psicotropicos WHERE troquel = '$troq[$index]'");
        $r = mysqli_query($conexion, $medi);
        $rs = mysqli_fetch_array($r);
        $precio = $rs['precio'];
        $comprimidos = $rs['comprimidos'];
        if ($cant[$index] < $comprimidos && $cant[$index] <> '0') {
            mysqli_query($conexion, "DELETE from recetas WHERE num_receta = '$num_receta'");
            mysqli_query($conexion, "DELETE from detalle_recetas WHERE num_receta = '$num_receta'");
            mysqli_query($conexion, "DELETE from detalle_recetas_prescriptas WHERE num_receta = '$num_receta'");
            $logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
            fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: CANTIDAD DE COMPRIMIDOS MENOS A PRESENTACION ".$dni.' '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");
            fclose($logFile);
            return base64_encode('comp');
            exit();
        }
    }



    //VALIDO QUE EL AFILIADO ESTE REGISTRADO
    $afi = ("SELECT dni FROM pad_psicotropicos WHERE dni = '$dni' AND estado = 1");
    $r = mysqli_query($conexion, $afi);
    $rs = mysqli_fetch_array($r);
    $dni_ = $rs['dni'] ?? '';



    //VALIDO QUE LA RECETA QUE INGRESA NO ESTA REGISTRADA SINO REGISTRO
    $receta =("SELECT num_receta FROM recetas WHERE num_receta = '$num_receta' AND estado <> 3");
    $rs1 = mysqli_query($conexion,$receta);
    $row1 = mysqli_fetch_array($rs1); 
    $num_receta_ = $row1['num_receta']  ?? '';
    //VALIDO QUE LA FECHA QUE INSERTA ES MENOR A UN MES DE QUE SE EXPENDIO LA RECETA
    $fecha_vencimiento = date("Y-m-d",strtotime($fecha_emision_subst."+ 30 days")); 

    //VALIDO QUE EL MEDICO ESTE REGISTRADO
    $afi =("SELECT * FROM pad_medicos WHERE mp = '$matricprescr'");
    $r = mysqli_query($conexion,$afi);
    $rs = mysqli_fetch_array($r); 
    $mp_ = $rs['mp']  ?? '';

    if($mp_ <> $matricprescr){
    $nombre_medico = $nombremed.' '.$apellidomed;
     mysqli_query($conexion,"INSERT INTO pad_medicos (mp, nombre, especialidad, zona, centro, estado, dia, mes, ano, hora, minuto, fecha_alta, ip) 
      VALUES ('$matricprescr', '$nombre_medico', '', '', '', '1', '$dia', '$mes', '$ano', '$hora', '$minuto', '$fecha_hoy','$ip_add')");
    }

    if($dni_ <> $dni){
     mysqli_query($conexion,"INSERT INTO pad_psicotropicos (dni, nombre, apellido, diagnostico, genero, fec_nac, telefono, calle, numero, dpto, piso, barrio, prescriptor, efector, fecha_inscripcion, estado, dia, mes, ano, hora, minuto, ip, fecha_alta, user) 
      VALUES ('$dni', '$nombre', '$apellido', '0', '0', '2022-01-01', '0', '0', '0', '0', '0', '0', '$matricespec_prescr', '0', '2022-01-01', '1', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_hoy', '$cuit')");
    }

    if($fecha_emision_subst > $fecha_hoy){
      $logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
    fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: FECHA MAYOR A LA ACTUAL: ".$fecha_emision_subst.' '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
    return base64_encode('fes');

    }elseif($fecha_hoy > $fecha_vencimiento){
    $logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
    fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: RECETA VENCIDA: ".$fecha_vencimiento.' '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
     return base64_encode('exp');

    }elseif($num_receta_ <> $num_receta){

    $cant = $cantidad;
    $renglon = $renglon;
    $troq = $troquel;

    foreach($cant as $index => $value) {

    $medi =("SELECT precio, comprimidos FROM vade_psicotropicos WHERE troquel = '$troq[$index]'");
    $r = mysqli_query($conexion,$medi);
    $rs = mysqli_fetch_array($r); 
    $precio = $rs['precio'];
    $comprimidos = $rs['comprimidos'];

    mysqli_query($conexion,"INSERT INTO detalle_recetas(num_receta, cantidad, troquel, precio, renglon) 
        values ('$num_receta', '$cant[$index]', '$troq[$index]', '$precio', '$renglon[$index]')");


    mysqli_query($conexion,"INSERT INTO consumos_afi(id_obrasocial, id_plan, num_receta, dni, troquel, cantidad, dia, mes, ano, hora, minuto, fecha) 
        values ('$id_obrasocial', '100', '$num_receta', '$dni', '$troq[$index]', '$cant[$index]', '$dia', '$mes', '$ano', '$hora', '$minuto', '$fecha_hoy')");
      
    }



    foreach ($row->prescripcion as $item) {
  $troquel=$item->troquel;
  $cant_prescripta=$item->cant_prescripta;
  $renglon=$item->renglon;



    // INSERTO DATOS EN SERVIDOR DE CONSEJO MEDICO
    $ch1 = curl_init(); // Ini
    curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
        "Content-Type:application/json"
    ));

    $body1 = '{
      "idReceta": "'.$num_receta.'",
      "renglon": "'.$renglon.'",
      "ip": "'.$ip_add.'",
      "codigo_dispensado": "'.$troquel.'",
      "cantidad_dispensada": "'.$cant_prescripta.'",
      "farmacia": 99999999999,
      "sucursal": 1,
      "dispensacion_cond": 1,
      "observacion": "dispensado",
      "tipo_opera": 0
    }';

    curl_setopt($ch1, CURLOPT_URL, "https://api.recetasalud.ar/colfacor/api/v1/dispensa");
    curl_setopt($ch1, CURLOPT_POST, TRUE);
    curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch1, CURLOPT_POSTFIELDS, $body1);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    $respuesta1 = curl_exec($ch1); // Respuesta
    curl_close($ch1); // Cierro el CURL
    $row1=json_decode($respuesta1);

    $medi =("SELECT precio, comprimidos FROM vade_psicotropicos WHERE troquel = '$troquel'");
    $r = mysqli_query($conexion,$medi);
    $rs = mysqli_fetch_array($r); 
    $precio = $rs['precio'];
    $comprimidos = $rs['comprimidos'];


    mysqli_query($conexion,"INSERT INTO detalle_recetas_prescriptas(num_receta, cantidad, troquel, precio, renglon) 
        values ('$num_receta', '$cant_prescripta', '$troquel', '$precio', '$renglon')");

    } 

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //INSERTO DATOS DE RECETA

    $insert_receta=mysqli_query($conexion,"INSERT INTO recetas(id_obrasocial, num_receta, fecha_receta, mp_med, dni_afi, estado, tipo, dia, mes, ano, hora, minuto, ipfarm, fecha_alta)
        VALUES ('$id_obrasocial', '$num_receta',  '$fecha_emision_subst', '$matricprescr', '$dni', '1', '1', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_hoy')");


    //CREO NUMERO DE VALIDACION
    $lista =("SELECT MAX(id) as id FROM validaciones");
    $rs = mysqli_query($conexion,$lista);
    $row = mysqli_fetch_array($rs); 
    $num_validacion = ($row['id'] + 1).$num_receta.$ano.$mes.$dia;

    mysqli_query($conexion,"INSERT INTO validaciones(num_receta, num_validacion, cuit_farm, suc_farm, estado, dia, mes, ano, hora, minuto, ipfarm, fecha_alta)

    VALUES ('$num_receta', '$num_validacion', '$cuit', '$idsucursal', '1', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_hoy')");



    if($sigipsa=='EXCEPCION'){ 
    mysqli_query($conexion,"INSERT INTO excep_afi(num_receta, motivo, fecha_alta)
        VALUES ('$num_receta', 'EXCEPCION', '$fecha_hoy')");
    }

    $logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
    fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validaciones: ".$num_validacion.' '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
     return "comprobantepdf.php?num_validacion=".base64_encode($num_validacion)."&id_obrasocial=".base64_encode($id_obrasocial);
     
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }else{
      $logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
      fwrite($logFile, "\n".date("d/m/Y H:i:s")." Validacion_error: RECETA YA VALIDADA ".$dni.' '.$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_receta.' | '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
      
      return base64_encode('copy');
      }
}


function anularReceta_mun($num_validacion,$tipo,$tipo_opera,$cuit,$idsucursal){

include ('conexion-test.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_hoy = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');
$ip_add = $_SERVER['REMOTE_ADDR'];


$rec =("SELECT a.num_receta , b.tipo, b.dni_afi
  FROM validaciones a
  LEFT JOIN recetas b 
  ON a.num_receta = b.num_receta 
  WHERE a.num_validacion = '$num_validacion'");
$r1 = mysqli_query($conexion,$rec);
$rs1 = mysqli_fetch_array($r1); 
$num_receta = $rs1['num_receta'];
$dni = $rs1['dni_afi'];

$logFile = fopen("log/log_anulaciones.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." Anulacion de Receta: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' | '.$num_receta.' - '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);

$rec3 =("SELECT count(b.renglon) as total
  FROM validaciones a
  LEFT JOIN detalle_recetas b 
  ON a.num_receta = b.num_receta 
  WHERE a.num_receta = '$num_receta'");
$r3 = mysqli_query($conexion,$rec3);
$rs3 = mysqli_fetch_array($r3); 
$total = $rs3['total'];

mysqli_query($conexion,"INSERT INTO validaciones_anuladas(num_receta, num_validacion, cuit_farm, suc_farm, dni, estado, dia, mes, ano, hora, minuto, ipfarm, fecha_alta)

VALUES ('$num_receta', '$num_validacion', '$cuit', '$idsucursal', '$dni', '$tipo_opera', '$dia', '$mes', '$ano', '$hora', '$minuto', '$ip_add', '$fecha_hoy')");

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


mysqli_query($conexion,"DELETE from excep_afi 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from recetas 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from detalle_recetas 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from detalle_recetas_prescriptas 
WHERE num_receta = '$num_receta'");
mysqli_query($conexion,"DELETE from validaciones 
WHERE num_validacion = '$num_validacion'") or
die("Problemas en el select:".mysqli_error($conexion));

}

$logFile = fopen("log/log_validaciones.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s")." VALIDACION ANULADA: ".$cuit.' / '.$idsucursal.' - '.$ip_add.' - '.$num_validacion.' - '.$num_receta.' - '.$fecha_hoy.' '.$hora.':'.$minuto) or die("Error escribiendo en el archivo");fclose($logFile);
//echo header("location: validaciones.php?msj=".base64_encode('an')."");
mysqli_close($conexion);
return "an";
}
?>