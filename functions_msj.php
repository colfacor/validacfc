<?php 

$usuario = 'CFC_sivadon_e';
$contra = 'kIisx7bVmxCFV4r';

//consulto MASCULINO
$curl = curl_init();
curl_setopt_array($curl, array(
  //CURLOPT_URL => "https://misvalidaciones.dev.cordoba.gob.ar/api/consultarActivoPSS?dni=$dni",
  CURLOPT_URL => "https://interoperabilidad.cordoba.gob.ar/api/consultarPersona?dni=27173917",
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
echo $data['listaPersonas'][0]['persona']['activo'];