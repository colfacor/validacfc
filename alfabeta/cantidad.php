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

// Crea una instancia del cliente SOAP
$client = new SoapClient($url);

// Llama al método del servicio web con los parámetros especificados
$response = $client->__soapCall("actualizar", array($params));

// Recupera el contenido del archivo ZIP desde la respuesta del servicio web
$zipContent = $response->return;

// Define el nombre del archivo ZIP que se va a descargar
$zipFileName = "archivo.zip";

// Crea un archivo temporal para guardar el contenido del archivo ZIP
$tmpZipFile = tempnam(sys_get_temp_dir(), 'zip');

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
    } else {

        // Creamos un objeto SimpleXMLElement con el XML
        $xml_obj = new SimpleXMLElement($datosTxt);

        //Conectamos a la BD

        include('../inc/conexion.php');
        
        foreach ($xml_obj->basecompleta->Cantidad->registro as $registro) {

            mysqli_query($conexion,"INSERT INTO `alfabeta_cantidad` (`id`, `des`) VALUES ('$registro->id', '$registro->des');");

        }

    }
    // Cierra el archivo ZIP
    $zip->close();
}
?>