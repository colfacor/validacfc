<?php
for ($renglon = 1; $renglon <= 4; $renglon++) {

$ch = curl_init(); // Ini
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type:application/json"
));

$body = '{
  "idReceta": "152662",
  "renglon": "'.$renglon.'",
  "ip": "'.$ip_add.'",
  "codigo_dispensado": 0,
  "cantidad_dispensada": 0,
  "farmacia": 99999999999,
  "sucursal": 1,
  "dispensacion_cond": null,
  "observacion": "dispensado",
  "tipo_opera": "1"
}';

curl_setopt($ch, CURLOPT_URL, "https://api.recetasalud.ar/colfacor/v2/api/dispensa");
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$respuesta = curl_exec($ch); // Respuesta
curl_close($ch); // Cierro el CURL
$row=json_decode($respuesta);

}
?>