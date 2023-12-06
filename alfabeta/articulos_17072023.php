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
// Crea una instancia del cliente SOAP
$client = new SoapClient($url);
echo "Conectado... \n";
// Llama al método del servicio web con los parámetros especificados
$response = $client->__soapCall("actualizar", array($params));
echo "Obteniendo zip \n";
// Recupera el contenido del archivo ZIP desde la respuesta del servicio web
$zipContent = $response->return;

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
*/

            
        }

    }
    // Cierra el archivo ZIP
    $zip->close();
    echo "Finalizado \n";   
}
?>