<?php
// URL del servicio web
$url = "http://abws.alfabeta.net/alfabeta-webservice/abWsDescargas?wsdl";

// Parámetros para la solicitud
$params = array(
    "id" => "1444",
    "clave" => "DeanFunes720",
    "xml" => "<parametros>
<ultimologMF>220323</ultimologMF>
<basecompleta>S</basecompleta>
<solotablas>N</solotablas>
</parametros>"
);
echo "Conectando... \n";


$client = new SoapClient($url);
echo "Conectado... \n";

$maxAttempts = 3;
$attempts = 0;
$zipContent = '';

while ($attempts < $maxAttempts && empty($zipContent)) {
    $response = $client->__soapCall("actualizar", array($params));
    echo "Obteniendo zip (Intento " . ($attempts + 1) . ") \n";
    $zipContent = $response->return;
    $attempts++;
}

if (!empty($zipContent)) {
    // El archivo ZIP se ha obtenido correctamente
    // Aquí puedes realizar las operaciones que necesites con el archivo
    // Por ejemplo, guardar el archivo en el disco o procesar su contenido

    // Ejemplo: Guardar el archivo ZIP en el disco
    file_put_contents('archivo.zip', $zipContent);

    echo "Archivo ZIP obtenido correctamente.\n";
} else {
    // No se ha obtenido el archivo ZIP después de los intentos
    echo "Error: No se pudo obtener el archivo ZIP después de $maxAttempts intentos.\n";
        // Configura el token de acceso de tu bot
    $token = '5963088482:AAH4TlK5_7thdlrF0WDvNHz5fA_7ArXYRy0';

    // Configura el chat ID del grupo al que deseas enviar mensajes
    $chatId = '@colfacbot';

    // Configura el mensaje que deseas enviar
    $message = urlencode('ERROR AL CONECTAR A ALFABETA');

    // Construye la URL de la API de Telegram para enviar el mensaje
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=$message";

    // Envía una solicitud GET a la URL utilizando cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Imprime la respuesta de la API de Telegram para verificar que el mensaje fue enviado correctamente
    var_dump($response);
    exit();
}



// Define el nombre del archivo ZIP que se va a descargar
$zipFileName = "archivo.zip";

// Crea un archivo temporal para guardar el contenido del archivo ZIP
$tmpZipFile = tempnam(sys_get_temp_dir(), 'zip');
echo "Abriendo Zip \n";
// Guarda el contenido del archivo ZIP en el archivo temporal
file_put_contents($tmpZipFile, $zipContent);

// Crea una instancia de la clase ZipArchive
$zip = new ZipArchive;

// Abre el archivo ZIP temporal
if ($zip->open($tmpZipFile) === TRUE) {

    // Busca y extrae el archivo "datos.txt"
    $datosTxt = $zip->getFromName('datos.txt');

    if($datosTxt == null){
        echo 'no hay datos';
        // Configura el token de acceso de tu bot
    $token = '5963088482:AAH4TlK5_7thdlrF0WDvNHz5fA_7ArXYRy0';

    // Configura el chat ID del grupo al que deseas enviar mensajes
    $chatId = '@colfacbot';

    // Configura el mensaje que deseas enviar
    $message = urlencode('EL ARCHIVO BAJO VACIO');

    // Construye la URL de la API de Telegram para enviar el mensaje
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=$message";

    // Envía una solicitud GET a la URL utilizando cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Imprime la respuesta de la API de Telegram para verificar que el mensaje fue enviado correctamente
    var_dump($response);
    exit();
    } else {
        echo "Abriendo TXT \n";
        // Creamos un objeto SimpleXMLElement con el XML
        $xml_obj = new SimpleXMLElement($datosTxt);

        //Conectamos a la BD

        include('../inc/conexion.php');
        echo "Borrando tabla \n";
        mysqli_query($conexion,"TRUNCATE TABLE alfabeta_articulos");        
        echo "Tabla borrada \n";
        foreach ($xml_obj->basecompleta->articulos->articulo as $articulo) {
            echo "Cargando: $articulo->reg - $articulo->nom - $articulo->pres ";
            $nom=str_replace("'", "\'", $articulo->nom);
            $pres=str_replace("'", "\'", $articulo->pres);
            $resultado=mysqli_query($conexion,"INSERT INTO alfabeta_articulos (`reg`, `prc`, `vig`, `nom`, `pres`, `labo`, `tro`, `est`, `imp`, `hel`, `iva`, `bars`, `tipov`, `salud`, `tam`, `for`, `via`, `dro`, `acc`, `upot`, `pot`, `uuni`, `uni`, `grav`, `cel`, `id`) VALUES ('$articulo->reg', '$articulo->prc', '$articulo->vig', '$nom', '$pres', '$articulo->labo', '$articulo->tro', '$articulo->est', '$articulo->imp', '$articulo->hel', '$articulo->iva', '$articulo->bars', '$articulo->tipov', '$articulo->salud', '$articulo->tam', '$articulo->for', '$articulo->via', '$articulo->dro', '$articulo->acc', '$articulo->upot', '$articulo->pot', '$articulo->uuni', '$articulo->uni', '$articulo->grav', '$articulo->cel', null)");
        
/*
            if ($resultado) {
              $filas_afectadas = mysqli_affected_rows($conexion);
              if ($filas_afectadas > 0) {
                // La inserción se realizó correctamente
                echo "\n";
              } else {
                // No se insertó ninguna fila
                echo " - No se insertó ninguna fila.\n";
              }
            } else {
              // Error al ejecutar la consulta de inserción
              echo " - Error al ejecutar la consulta de inserción: " . mysqli_error($conexion)."\n";
            }



            $padron =("SELECT * FROM vade_psicotropicos WHERE reg = '$articulo->reg'");
            $r = mysqli_query($conexion,$padron);
            $rs1 = mysqli_fetch_array($r); 
            $reg = $rs1['reg'];
            $comprimidos = $rs1['comprimidos'];

            if(!empty($reg)){
            $precio_nuevo_ab = ($articulo->prc - ($articulo->prc*0.15)) / $comprimidos;

            mysqli_query($conexion, "UPDATE vade_psicotropicos 
                                        SET precio = '$precio_nuevo_ab'
                                        WHERE reg = '$articulo->reg'");
            }
            */
            
        }

    }
    // Cierra el archivo ZIP
    $zip->close();
    echo "Finalizado \n";   
}
?>