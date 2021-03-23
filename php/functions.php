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

function download(){
$content = $_POST['archivo_convertido_input'];
$nombre_fichero = "file_converted";
$extension = ".json";

$direccion_file = ".".DIRECTORY_SEPARATOR."download";
$fileroute = crear_carpeta(__DIR__,"download");
$file_dir = "$direccion_file".DIRECTORY_SEPARATOR."$nombre_fichero$extension";
//Creamos el archivo
$file = crear_fichero("$nombre_fichero","$content","$extension","$file_dir");
    if (file_exists($file_dir)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file_dir).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_dir));
        readfile($file_dir);
        exit;
    }
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



function print_hidden($archivo_convertido){

   echo  '<div id="campo_oculto">';
    echo "<input type='hidden' name='archivo_convertido_input' value='$archivo_convertido'>";
    echo '</div>';
}

//Ficheros

//funcion que crea una carpeta en la ruta indicada y con el nombre que se indica y devuelve la ruta a la carpeta
function crear_carpeta($url,$name){
    $micarpeta = $url.DIRECTORY_SEPARATOR.$name;
    if (!file_exists($micarpeta)) {
        mkdir($micarpeta, 0777, true);
    }
    return $micarpeta;
}
function crear_fichero($nombre, $contenido, $extension, $url=null ,$modo="w"){

    if ($nombre != "" && $contenido != "") {
        //Si es modo escritura, crea el fichero o lo machaca
        if ($modo == "w") {
            //Si el final del nombre del archivo no es el de la extensión se lo añadimos
            if (substr($nombre, -4) != $extension) {
                $nombre = $nombre . $extension;
            }
        }
        $archivo = fopen($nombre, $modo);
        $escrito = fwrite($archivo, $contenido . PHP_EOL);

        $resultado = fclose($archivo);
        if ($resultado && $escrito) {
            if($url != null){
                rename("$nombre","$url");
            }
            return true;
        } else {
           return false;
        }
    } else {
      return false;
    }
}
function imprime_directorio($direccion){
    return  scandir ($direccion);
}

//Funciones para debug.
function imprime_bonito_post(){
    if ($_POST) {
        echo '<pre>';
        echo htmlspecialchars(print_r($_POST, true));
        echo '</pre>';
    }
}
function imprime_bonito_get(){
    if ($_GET) {
        echo '<pre>';
        echo htmlspecialchars(print_r($_GET, true));
        echo '</pre>';
    }
}
function imprime_bonito_request(){
    if ($_REQUEST) {
        echo '<pre>';
        echo htmlspecialchars(print_r($_REQUEST, true));
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
function imprime_todas_variables(){
    $vars = get_defined_vars();
    print_r($vars);
}
