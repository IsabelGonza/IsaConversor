<?php
function ver_errores()
{
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
function get_extension($filename){
    $arr_extension = explode(".",$filename);
    return $arr_extension[1];
}
function comprobar_formato_valido($nombre){
    $extension = get_extension($nombre);
    $extensiones_validas = ['xml','json'];
    if( in_array($extension, $extensiones_validas)){
        return true;
    }else{
        return false;
    }
}
function obtener_informacion_archivo($file){
        $nombre_fichero = $file["name"];
        $tamanyo = $file["size"];
        $tipo_fichero = $file["type"];

    return $nombre_fichero;
   /* rename("datos-2.txt", "datos---2.txt");*/
}
function leer_fichero($nombre){
    echo file_get_contents($nombre);
}

function imprimir_fichero_xml($archivo){
    if(isset($archivo['tmp_name'])){
        $xml = simplexml_load_file($archivo['tmp_name']);
    }else{
        if(is_string($archivo)){
            $xml = simplexml_load_string($archivo);
        }
    }
    displayChildrenRecursive($xml);
}
function displayChildrenRecursive($xmlObj,$depth=0)
{
    foreach($xmlObj->children() as $child)
    {
        echo "<br>";
        echo str_repeat('-',$depth)."><strong>".$child->getName()."</strong>: ".$child;
        displayChildrenRecursive($child,$depth+1);
    }
}

function imprimir_fichero_json($archivo){
    $obj = json_decode($archivo, true);
    return imprime_bonito_array($obj);
}

function descargar_archivo_convertido($converted_file){

    $TheFile = basename($converted_file);

    header( "Content-Type: application/octet-stream");
    header( "Content-Length: ".filesize($converted_file));
    header( "Content-Disposition: attachment; filename=".$TheFile."");
    readfile($converted_file);
}

//Convierte un archivo .xml a json
function convert_to_xml($archivo){
    if(is_file($archivo['tmp_name'])){
        $object = simplexml_load_file($archivo['tmp_name']);
    }
    /*if(is_string($archivo)){
        $object = simplexml_load_string($archivo);
    }*/
    $json = json_encode($object);
    return $json;
}
 function xml2json ($url) {
    $fileContents= file_get_contents($url);
    $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
    $fileContents = trim(str_replace('"', "'", $fileContents));
    $simpleXml = simplexml_load_string($fileContents);
    $json = json_encode($simpleXml);

    return $json;
}
//Convierte un archivo .json a xml
function convert_to_json($archivo){
    $xml = new SimpleXMLElement('<root/>');
    array_walk_recursive($archivo, array ($xml, 'addChild'));
    print $xml->asXML();
}
// function defination to convert array to xml
function array_to_xml( $data, &$xml_data ) {
    foreach( $data as $key => $value ) {
        if( is_array($value) ) {
            if( is_numeric($key) ){
                $key = 'item'.$key; //dealing with <0/>..<n/> issues
            }
            $subnode = $xml_data->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key",htmlspecialchars("$value"));
        }
    }
}

//Funciones para debug.
function imprime_bonito_post(){
    if ($_POST) {
        echo '<pre>';
        echo htmlspecialchars(print_r($_POST, true));
        echo '</pre>';
    }
}
function imprime_bonito_files(){
    if ($_POST) {
        echo '<pre>';
        echo htmlspecialchars(print_r($_FILES, true));
        echo '</pre>';
    }
}
function imprime_bonito_array($arr){
    echo '<pre>';
    echo htmlspecialchars(print_r($arr, true));
    echo '</pre>';
}
